<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录-QwqOffice软件工作室</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script src="http://qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js"></script>
<script src="js/login.js"></script>
<script src="js/md5.js"></script>
<script type="text/javascript">
     setShareInfo({
         title:          '登录 QwqOffice软件工作室',
         summary:        '"以原创、创新、实用为宗旨，努力打造高品质产品。"',
         pic:            '<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>/images/icon.png',
         url:            '<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>/login.php'
     });
</script>
</head>

<body style="background-color:#F5F5F5;">
<?php
	include("include/wechat.php");
	session_start();
	require_once("include/db.php");
	require_once("include/func.php");
	$NoCode=chkAuth("NoValidateCode");
?>
<div id="login-middle">
	<div id="icon-title">
    	<div class="icon"><a href="index.php"><img src="images/icon.png" width="50" height="50" /></a></div>
        <div class="title"><h4>登录 QwqOffice</h4></div>
	</div>
    <div id="login-form">
    	<form action="" method="post" autocomplete="off" onsubmit="checkpass();return check()">
        	<p><input type="text" name="username" id="username" placeholder="用户名" autofocus /><span id="name-tip">&nbsp;</span></p>
            <p><input type="password" name="password" id="password" placeholder="密码" /><span id="pass-tip">&nbsp;</span></p>
            <p <?php if($NoCode) echo "style='display:none;'"; ?>><input type="text" name="code" id="code" placeholder="图片验证码" />
            <img src="ValidateCode.php" width="130" height="50" onclick="this.src='ValidateCode.php?'+Math.random();" />
            <span id="code-tip">&nbsp;</span>
            <div style="clear:both;"></div></p>
            <label for="submit">立即登录</label>
            <input style="display:none" id="submit" type="submit" name="login" /> 
        </form>
        <a href="register.php" style="display:block;margin:auto">注册帐号</a>
    </div>
</div>

<div id="login-footer">
<?php include("include/copyright.php"); ?>
</div>

<?php
	autoLogin();//自动登录
	//如果已经登录则跳转页面
	if(isset($_SESSION["qo_user"])){
		//登录前页面
		if(isset($_GET["url"])){
			$url=urlencode($_GET["url"]);
			header("location: {$url}");
			exit;
		}
		header("location: index.php");
		exit;
	}
	if(isset($_POST["login"])){
		//验证码
		if(!$NoCode && md5(strtolower(trim($_POST["code"])))!=$_SESSION["qo_code"]) exit;
		//查询数据库
		$username=htmlspecialchars(addslashes(trim($_POST["username"])));
		$password=md5("qo_".addslashes($_POST["password"]));
		$result=mysql_query("select * from qo_user where Username=binary '{$username}' and Password=binary '{$password}'");
		echo mysql_num_rows($result);
		if(mysql_num_rows($result)==0) exit;//提交表单时已通过AJAX验证，仍然不匹配说明伪造
		//保存SESSION
		$_SESSION["qo_user"]=$username;
		//保存COOKIE
		setcookie("qo_user", $username, time()+3600*24*7);
		setcookie("qo_key", md5(md5("qo_".$username)), time()+3600*24*7);
		//验证码作废
		$_SESSION["qo_code"]="";
		//刷新登录时间
		$datetime=date("Y-m-d H:i:s");
		mysql_query("update qo_user set LastLogin='{$datetime}' where Username='{$username}'");
		//日志
		$IP=getIP();
		$user=mysql_fetch_array($result);
		$uid=$user["UID"];
		mysql_query("insert into qo_logs values(null, {$uid}, '{$IP}', '{$datetime}', '登录用户{{$username}}')");
		
		//跳转页面
		if(isset($_GET["url"])){
			$url=urlencode($_GET["url"]);
			header("location: message.php?msg=login1&url={$url}");
			exit;
		}else{
			header("location: message.php?msg=login1");
			exit;
		}
	}
?>
</body>
</html>