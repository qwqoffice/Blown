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
	if(!chkAuth("Manage")){
		header("location: message.php?msg=auth0");
		exit;
	}
	
	//测试管理员检查
	if(getGID($_SESSION["qo_user"])==getSetting("TestAdminGroup")){
		header("location: admin.php?mod=message&msg=testadmin0");
		exit;
	}
	
	//公告管理
	if(isset($_POST["notice"])){
		$types=array("String"=>"文字", "Link"=>"链接");
		$status=array("Show"=>"显示","Hide"=>"隐藏");
		//添加、修改
		if(isset($_POST["opr"])){
			$opr=$_POST["opr"];
			if($opr=="edit"){
				$nid=(int)$_POST["nid"];
				chkExists("qo_notice", "NID", $nid);//检查NID
			}
			$uid=getUID($_SESSION["qo_user"]);
			//检查标题
			if(trim($_POST["title"])=="") exit;
			$noticeTitle=strip_tags($_POST["title"],"<span>");
			//检查类型
			$type=$_POST["type"];
			if(!array_key_exists($type,$types)) exit;
			//检查内容
			$content=trim(addslashes(str_replace("\r\n","<br />",htmlspecialchars($_POST["noticeContent"]))));
			if(trim($content)=="") exit;
			//检查状态
			$sta=$_POST["status"];
			if(!array_key_exists($sta,$status)) exit;
			
			$datetime=date("Y-m-d H:i:s");
			if($opr=="new"){
				$result=mysql_query("insert into qo_notice values(null,'{$uid}', '{$noticeTitle}', '{$type}', '{$content}', '{$datetime}', '{$sta}')");
			}else if($opr=="edit"){
				$result=mysql_query("update qo_notice set Title='{$noticeTitle}',NoticeType='{$type}',Content='{$content}',Status='{$sta}' where NID={$nid}");
			}else{
				header("location: admin.php");
				exit;
			}
			if(!$result){
				header("location: admin.php?mod=message&msg=notice0");
				exit;
			}
		}
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$nid=$value;
				chkExists("qo_notice", "NID", $nid);//检查NID
				$result=mysql_query("delete from qo_notice where NID={$nid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=notice0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=notice1&url=admin.php?mod=notice");
		exit;
	}
	//导航管理
	else if(isset($_POST["navi"])){
		//添加
		if(isset($_POST["newname"])){
			foreach($_POST["newname"] as $key=>$value){
				if($value=="") continue;
				$newname=htmlspecialchars(addslashes($value));
				$parent=(int)$_POST["parentcid"][$key];
				if($parent!=0) chkExists("qo_class", "CID", $parent);//检查CID
				$link=htmlspecialchars(addslashes($_POST["newlink"][$key]));
				$seq=$_POST["newseq"][$key]==""?"0":(int)$_POST["newseq"][$key];
				$result=mysql_query("insert into qo_class values(null, '{$newname}', '{$link}', {$parent}, {$seq}, null)");
				if(!$result){
					header("location: admin.php?mod=message&msg=navi0");
					exit;
				}
			}
		}
		//修改
		if(isset($_POST["namenew"])){
			foreach($_POST["namenew"] as $key=>$value){
				if($value=="") continue;
				$namenew=htmlspecialchars(addslashes($value));
				$cid=(int)$key;
				chkExists("qo_class", "CID", $cid);//检查CID
				$link=htmlspecialchars(addslashes($_POST["linknew"][$key]));
				$seq=$_POST["seqnew"][$key]==""?"0":(int)$_POST["seqnew"][$key];
				$file=isset($_FILES["filenew"]["tmp_name"][$key])? $_FILES["filenew"]["tmp_name"][$key] : "";
				$file_error=$file!="" ? $_FILES["filenew"]["error"][$key] : 4;
				$dir="./images-icon";
				if($file!=""){
					$file_count=1;
					while(file_exists("{$dir}/".($filename=date("Ymd")."-{$file_count}.".pathinfo($_FILES["filenew"]["name"][$key], PATHINFO_EXTENSION)))){
						$file_count++;
					}
				}
				if(!file_exists($dir)) mkdir($dir);
				
				if($file_error==0){
					$result=mysql_query("update qo_class set ClassName='{$namenew}', Link='{$link}', Sequence={$seq}, ICON='{$filename}' where CID=$cid");
				}else if($file_error==4){
					$result=mysql_query("update qo_class set ClassName='{$namenew}', Link='{$link}', Sequence={$seq} where CID=$cid");
				}else{
					header("location: admin.php?mod=message&msg=navi0");
					exit;
				}
				
				if($result){
					if($file_error==0) move_uploaded_file($file, $dir."/".$filename);
				}else{
					header("location: admin.php?mod=message&msg=navi0");
					exit;
				}
			}
		}
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$cid=(int)$value;
				chkExists("qo_class", "CID", $cid);//检查CID
				$result=mysql_query("delete from qo_class where CID={$cid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=navi0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=navi1&url=admin.php?mod=navi");
		exit;
	}
	//图片轮播管理
	else if(isset($_POST["carousel"])){
		//修改
		foreach($_POST["namenew"] as $key=>$value){
			$num=(int)$_POST["num"][$key];
			chkExists("qo_indeximg", "NO", $num);//检查NO
			$namenew=htmlspecialchars(addslashes($value));
			$seq=(int)$_POST["seqnew"][$key];
			$link=htmlspecialchars(addslashes($_POST["linknew"][$key]));
			$file=$_FILES["files"]["tmp_name"][$key];
			$dir="./images-index";
			$file_count=1;
			while(file_exists("{$dir}/".($filename=date("Ymd")."-{$file_count}.".pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION)))){
				$file_count++;
			}
			if(!file_exists($dir)) mkdir($dir);
			
			if($_FILES["files"]["error"][$key]==0){
				$result=mysql_query("update qo_indeximg set Sequence={$seq}, Title='{$namenew}', Link='{$link}', FileName='{$filename}' where NO={$num}");
			}else if($_FILES["files"]["error"][$key]==4){
				$result=mysql_query("update qo_indeximg set Sequence={$seq}, Title='{$namenew}', Link='{$link}' where NO={$num}");
			}else{
				header("location: admin.php?mod=message&msg=carousel0");
				exit;
			}
			
			if($result){
				if($_FILES["files"]["error"][$key]==0) move_uploaded_file($file, $dir."/".$filename);
			}else{
				header("location: admin.php?mod=message&msg=carousel0");
				exit;
			}
		}
		header("location: admin.php?mod=message&msg=carousel1&url=admin.php?mod=carousel");
		exit;
	}
	//主题管理
	else if(isset($_POST["article"])){
		//添加、修改
		if(isset($_POST["opr"])){
			$opr=$_POST["opr"];
			if($_POST["title"]=="" || $_POST["content"]=="") exit;
			if($opr=="edit"){
				$tid=(int)$_POST["tid"];
				chkExists("qo_article", "TID", $tid);//检查TID
			}
			$cid=(int)$_POST["cid"];
			chkExists("qo_class", "CID", $cid);//检查CID
			$type=$_POST["type"];
			if(!in_array($type,array("Product","Original","Repaint"))) exit;//检查type
			$title=htmlspecialchars(addslashes($_POST["title"]));
			$content=addslashes($_POST["content"]);
			$username=mysql_fetch_array(mysql_query("select * from qo_user where Username='{$_SESSION['qo_user']}'"));
			$uid=$username["UID"];
			$datetime=date("Y-m-d H:i:s");
			if($opr=="new"){
				$result=mysql_query("insert into qo_article values(null, {$cid}, {$uid}, '{$title}', '{$content}', '{$datetime}', 0, '{$type}')");
			}else if($opr=="edit"){
				$result=mysql_query("update qo_article set CID={$cid}, Title='{$title}', Content='{$content}', ArticleType='{$type}' where TID={$tid}");
			}else{
				header("location: admin.php");
				exit;
			}
			if(!$result){
				header("location: admin.php?mod=message&msg=article0");
				exit;
			}
		}
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$tid=$value;
				chkExists("qo_article", "TID", $tid);//检查TID
				$result=mysql_query("delete from qo_article where TID={$tid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=article0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=article1&url=admin.php?mod=article");
		exit;
	}
	//评论管理
	else if(isset($_POST["reply"])){
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$rid=$value;
				chkExists("qo_reply", "RID", $rid);//检查RID
				$result=mysql_query("delete from qo_reply where RID={$rid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=reply0");
					exit;
				}
			}
		}
		//审核
		if(isset($_POST["pend"])){
			foreach($_POST["pend"] as $key=>$value){
				$rid=$key;
				chkExists("qo_reply", "RID", $rid);//检查RID
				$status=$value;
				if(!in_array($status, array("审核中","通过","不通过"))){
					header("location: admin.php");
					exit;
				}
				$result=mysql_query("update qo_reply set Status='{$status}' where RID={$rid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=reply0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=reply1&url=admin.php?mod=reply");
		exit;
	}
	//附件管理
	else if(isset($_POST["attach"])){
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$aid=$value;
				chkExists("qo_attach", "AID", $aid);//检查AID
				$attach=mysql_fetch_array(mysql_query("select * from qo_attach where AID={$aid}"));
				$file=$attach["RealFileName"];
				$del_file=true;
				if(file_exists($file)) $del_file=unlink($file);
				$result=mysql_query("delete from qo_attach where AID={$value}");
				if(!$result || !$del_file){
					header("location: admin.php?mod=message&msg=attach0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=attach1&url=admin.php?mod=attach");
		exit;
	}
	//用户管理
	else if(isset($_POST["user"])){
		//添加、修改
		if(isset($_POST["opr"])){
			$opr=$_POST["opr"];
			if($opr=="edit"){
				$uid=(int)$_POST["uid"];
				chkExists("qo_user", "UID", $uid);//检查UID
				$rootuser=getSetting("RootUser");
				if(($uid==$rootuser || getGIDByUID($uid)==getSetting("AdminGroup") && $uid!=getUID($_SESSION["qo_user"])) && getUID($_SESSION["qo_user"])!=$rootuser){
					header("location: admin.php?mod=message&msg=user0");
					exit;
				}
			}
			$password=md5("qo_".addslashes($_POST["password"]));
			$gid=(int)$_POST["gid"];
			chkExists("qo_group", "GID", $gid);//检查GID
			$datetime=date("Y-m-d H:i:s");
			if($opr=="new"){
				if($_POST["username"]=="") exit;
				$username=$_POST["username"];
				$result=mysql_query("insert into qo_user values(null, {$gid}, '{$username}', '{$password}', '-', '{$datetime}', '{$datetime}','Allow')");
			}else if($opr=="edit"){
				if($_POST["password"]==md5("")){//用户不修改密码
					$result=mysql_query("update qo_user set GID={$gid} where UID={$uid}");
				}else{
					$result=mysql_query("update qo_user set GID={$gid}, Password='{$password}' where UID={$uid}");
				}
			}else{
				header("location: admin.php");
				exit;
			}
			if(!$result){
				header("location: admin.php?mod=message&msg=user0");
				exit;
			}
		}
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$uid=$value;
				chkExists("qo_user", "UID", $uid);//检查UID
				$rootuser=getSetting("RootUser");
				if(($uid==$rootuser || getGIDByUID($uid)==getSetting("AdminGroup") && $uid!=getUID($_SESSION["qo_user"])) && getUID($_SESSION["qo_user"])!=$rootuser){
					header("location: admin.php?mod=message&msg=user0");
					exit;
				}
				$result=mysql_query("delete from qo_user where UID={$uid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=user0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=user1&url=admin.php?mod=user");
		exit;
	}
	//用户组管理
	else if(isset($_POST["usergrp"])){
		//添加、修改
		if(isset($_POST["opr"])){
			$opr=$_POST["opr"];
			if($opr=="edit"){
				$gid=(int)$_POST["gid"];
				chkExists("qo_group", "GID", $gid);//检查GID
			}
			if(trim($_POST["groupname"])=="") exit;
			$groupname=htmlspecialchars(addslashes($_POST["groupname"]));
			$auths=$_POST["auths"];
			foreach($auths as $value){
				chkExists("qo_authority", "AuthID", $value);//检查AuthID
			}
			$auth_str=implode(";",$auths);
			if($opr=="new"){
				$result=mysql_query("insert into qo_group values(null, '{$groupname}', '{$auth_str}')");
			}else if($opr=="edit"){
				$result=mysql_query("update qo_group set GroupName='{$groupname}',Authority='{$auth_str}' where GID={$gid}");
			}else{
				header("location: admin.php");
				exit;
			}
			if(!$result){
				header("location: admin.php?mod=message&msg=usergrp0");
				exit;
			}
		}
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$gid=$value;
				chkExists("qo_group", "GID", $gid);//检查GID
				$result=mysql_query("delete from qo_group where GID={$gid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=usergrp0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=usergrp1&url=admin.php?mod=usergrp");
		exit;
	}
	//日志管理
	else if(isset($_POST["logs"])){
		//删除
		if(isset($_POST["delete"])){
			foreach($_POST["delete"] as $value){
				$lid=$value;
				chkExists("qo_logs", "LID", $lid);//检查LID
				$result=mysql_query("delete from qo_logs where LID={$lid}");
				if(!$result){
					header("location: admin.php?mod=message&msg=logs0");
					exit;
				}
			}
		}
		header("location: admin.php?mod=message&msg=logs1&url=admin.php?mod=logs");
		exit;
	}
	
	function chkExists($table, $column, $value){
		if(mysql_num_rows(mysql_query("select * from {$table} where {$column}={$value}"))<1){
			header("location: admin.php");
			exit;
		}
	}
?>
</body>
</html>