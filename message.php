<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息-QwqOffice软件工作室</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script src="js/script.js"></script>
</head>

<body>
<?php
	$message=array("reg0"=>"注册失败",
				"reg1"=>"注册成功",
				"login1"=>"登录成功",
				"reply0"=>"发表留言失败",
				"reply1"=>"发表留言成功",
				"reply2"=>"发表留言成功，审核通过后显示",
				"logout1"=>"退出登录成功",
				"attach0"=>"附件读取失败",
				"auth0"=>"您所在的用户组没有权限执行该操作");
	if(isset($_GET["msg"])){
		$msg=$_GET["msg"];
		if(!array_key_exists($msg, $message)){
			header("location: index.php");
			exit;
		}
		if(strpos($msg,"0")===false){
			$resu=1;
		}else{
			$resu=0;
		}
	}else{
		header("location: index.php");
		exit;
	}
	
	if(isset($_GET["url"])){
		$isget=true;
		$url=urldecode($_GET["url"]);
		if(strpos($_GET["url"],$_SERVER["HTTP_HOST"])===false || strpos($_GET["url"],basename(__FILE__))!==false){
			$isget=false;
			$url="index.php";
		}
	}else{
		$isget=false;
		$url="index.php";
	}
	if($resu){
		$img="success.png";
		if($isget){
			header("refresh:2; url=http://{$url}");
		}else{
			header("refresh:2; url={$url}");
		}
	}else{
		$img="failed.png";
	}
?>
<?php include("include/header.php"); ?>
<div id="content">
	<div id="message">
    	<p><img src="images/<?php echo $img; ?>" width="25" height="25" style="vertical-align:top" />&nbsp;&nbsp;<?php echo $message[$msg];?></p>
        <p><a href="<?php echo $resu ? ($isget?"http://".$url:$url) : "javascript:history.back()";?>"><?php echo $resu ? "如果您的浏览器没有自动跳转，请点击此链接" : "点击返回上一页";?></a></p>
	</div>
</div>
<?php include("include/footer.php"); ?>
</body>
</html>