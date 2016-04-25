<?php
session_start();
require_once("include/db.php");
require_once("include/func.php");
if(isset($_GET["key"])){
	$key=$_GET["key"];
}else{
	exit;
}

if(chkAuth("NoValidateCode")){
	$NoCode=true;
}else{
	$NoCode=false;
}

if($key=="code"){
	if(md5(strtolower(trim($_POST["value"])))==$_SESSION["qo_code"] || $NoCode){
		echo "1";
	}
}else if($key=="username"){
	$value=trim($_POST["value"]);
	$result=mysql_query("select * from qo_user where Username=binary '{$value}'");
	if(mysql_num_rows($result)==0){
		echo "1";
	}
}else if($key=="password"){
	$value1=addslashes(trim($_POST["value1"]));
	$value2=md5("qo_".addslashes($_POST["value2"]));
	$value3=md5(strtolower(trim($_POST["value3"])));
	$result=mysql_query("select * from qo_user where Username=binary '{$value1}' and Password=binary '{$value2}'");
	
	if($value3==$_SESSION["qo_code"] || $NoCode){
		if(mysql_num_rows($result)>0){
			echo "1";
		}else{
			echo "0";
		}
	}else{
		echo "2";
	}
}
else{
	exit;
}
?>