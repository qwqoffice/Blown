<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
	session_start();
	require_once("include/db.php");
	require_once("include/func.php");
	
	//来源检查
	if(strpos($_SERVER["HTTP_REFERER"],$_SERVER["HTTP_HOST"])===false){
		header("location: index.php");
		exit;
	}
		
	//权限检查
	if(!chkAuth("Comment")){
		header("location: message.php?msg=auth0");
		exit;
	}
	//是否免审核
	$NoPend=chkAuth("NoPend");
	$NoPendStr=$NoPend?"通过":"审核中";
	
	if(isset($_POST["reply"])){
		//获取名字
		if(isset($_SESSION["qo_user"])){
			$username=$_SESSION["qo_user"];
		}else{
			if(trim($_POST["username"])!=""){
				$username=htmlspecialchars(addslashes(($_POST["username"])));
			}else{
				$username="游客";
			}
		}
		
		//TID
		$tid=(int)$_POST["tid"];
		if(mysql_num_rows(mysql_query("select * from qo_article where TID={$tid}"))<1){
			header("location: index.php");
			exit;
		}
		//回复类型
		$type=htmlspecialchars(addslashes($_POST["reply-type"]));
		if($type!="thread" && $type!="reply"){
			header("location: index.php");
			exit;
		}
		//回复ID
		$id=(int)$_POST["reply-id"];
		if($type=="thread"){
			if(mysql_num_rows(mysql_query("select * from qo_article where TID={$id}"))<1){
				header("location: index.php");
				exit;
			}
		}else{
			if(mysql_num_rows(mysql_query("select * from qo_reply where RID={$id} and Status='通过'"))<1){
				header("location: index.php");
				exit;
			}
		}
		$quote=$type=="thread"?"null":$id;
		//检查文本框
		if(mb_strlen(trim($_POST["reply-content"]))<6) exit;
		$content=trim(addslashes(str_replace("\r\n","<br />",htmlspecialchars($_POST["reply-content"]))));
		$url=$_POST["url"];
		if(strpos($url,$_SERVER["HTTP_HOST"])===false){
			header("location: index.php");
			exit;
		}
		$datetime=date("Y-m-d H:i:s");
		//IP
		$IP=getIP();
		//检查验证码
		if(!chkAuth("NoValidateCode") && md5(strtolower(trim($_POST["code"])))!=$_SESSION["qo_code"]) exit;
		//验证码作废
		$_SESSION["qo_code"]="";
		
		//写入数据库
		if(isset($_SESSION["qo_user"])){
			$uid=getUID($_SESSION["qo_user"]);
			$result=mysql_query("insert into qo_reply values(null, {$tid}, {$uid}, null, {$quote}, '{$content}', '{$datetime}', '{$IP}', '{$NoPendStr}')");
		}else{
			$uid="";
			$result=mysql_query("insert into qo_reply values(null, {$tid}, null, '{$username}', {$quote}, '{$content}', '{$datetime}', '{$IP}', '{$NoPendStr}')");
		}
		$insertID=mysql_insert_id();
		//消息通知
		if($type=="thread" || $type=="reply" && isUser($id)){
			$type1=ucfirst($type);
			$author=getThreadAuthor($tid);
			$touid=$type=="thread"?getUIDFromTID($id):getUIDFromRID($id);
			if($uid!=$touid){
				mysql_query("insert into qo_message values(null, null, {$insertID}, {$touid}, 'Post', null, '{$datetime}', 'False')");
				//回复评论时连主题作者一同通知
				if($type=="reply" && $uid!=$author){
					mysql_query("insert into qo_message values(null, null, {$insertID}, {$author}, 'Post', null, '{$datetime}', 'False')");
				}
			}
		}
		//echo "uid:{$uid}, anthor:{$author}, touid:{$touid}";
		//exit;

		if(!$result){
			header("location: message.php?msg=reply0");
			exit;
		}else{
			if($NoPend){
				header("location: message.php?msg=reply1&url={$url}");
			}else{
				header("location: message.php?msg=reply2&url={$url}");
			}
			exit;
		}
	}
?>
</body>
</html>