<?php
	session_start();
	require_once("include/db.php");
	require_once("include/func.php");
	
	//来源检查
	if(strpos($_SERVER["HTTP_REFERER"],$_SERVER["HTTP_HOST"])===false){
		header("location: index.php");
		exit;
	}
	
	$username=$_SESSION["qo_user"];
	$uid=getUID($username);
	$datetime=date("Y-m-d H:i:s");
	
	header("Content-Type: text/html; charset=utf-8");
	//隐私设置
	if(isset($_POST["privacy"])){
		foreach($_POST['mypriv'] as $k=>$v){
			if(in_array($k,array("Home","Msg"))) $userpriv[]=$k;
		}
		$userpriv=implode(";",$userpriv);
		mysql_query("update qo_user set Privacy='{$userpriv}' where UID={$uid}");
		echo "<script>alert('您的设置已保存！');";
		echo "location.href='home.php?mod=pref&ac=privacy'";
		echo "</script>";
	}
	//密码设置
	else if(isset($_POST["password"])){
		//验证原密码
		$oldpass=md5("qo_".addslashes($_POST["oldpwd"]));
		$newpass=md5("qo_".addslashes($_POST["newpwd"]));
		$sql="select * from qo_user where Username='{$username}' and Password='{$oldpass}'";
		if(mysql_num_rows(mysql_query($sql))>0){
			mysql_query("update qo_user set Password='{$newpass}' where UID={$uid}");
			$msg="您的设置已保存！";
		}else{
			$msg="原密码不正确！";
		}
		echo "<script>alert('{$msg}');";
		echo "location.href='home.php?mod=pref&ac=password'";
		echo "</script>";
	}
	//短消息发送
	else if(isset($_POST["send"])){
		$content=trim(addslashes(str_replace("\r\n","<br />",htmlspecialchars($_POST["msgcontent"]))));
		$refer=$_SERVER['HTTP_REFERER'];
		$refer=strpos($refer,"&last")===false?$refer."&last":$refer;
		$len=mb_strlen($content);
		if($len==0 || $len>200){
			echo "<script>alert('消息长度不符合要求！');";
			echo "location.href='{$refer}'";
			echo "</script>";
			exit;
		}
		
		$talkuid=(int)$_POST["talkuid"];
		//隐私检查
		$u=getUser($talkuid);
		$priv=explode(";", $u["Privacy"]);
		if(!in_array("Msg",$priv) && getGID($username)!=getSetting("AdminGroup")){
			echo "<script>alert('当前用户设置不接收短消息！');";
			echo "location.href='{$refer}'";
			echo "</script>";
			exit;
		}
		
		//用户检查
		if(mysql_num_rows(mysql_query("select * from qo_user where UID={$talkuid}"))<1){
			header("location: index.php");
			exit;
		}
		if($uid==$talkuid){
			echo "<script>alert('不能发短消息给自己！');";
			echo "location.href='{$refer}'";
			echo "</script>";
			exit;
		}
		
		$result=mysql_query("insert into qo_message values(null, {$uid}, null, {$talkuid}, 'Private', '{$content}', '{$datetime}', 'False')");
		echo "<script>";
		if(!$result){
			echo "alert('消息发送失败！');";
		}
		echo "location.href='{$refer}'";
		echo "</script>";
	}
	
?>