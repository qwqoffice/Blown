<?php
	//清除SESSION和COOKIE
	session_start();
	session_destroy();
	setcookie("qo_user", "", time()-3600);
	setcookie("qo_key", "", time()-3600);
	if(isset($_GET["url"])){
		$url=urlencode($_GET["url"]);
	}else{
		$url="index.php";
	}
	echo "<script>location.href='message.php?msg=logout1&url={$url}'</script>";
?>