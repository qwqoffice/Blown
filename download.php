<?php
	session_start();
	require_once("include/db.php");
	require_once("include/func.php");
	
	//权限检查
	if(!chkAuth("Download")){
		header("location: message.php?msg=auth0");
		exit;
	}
	
	if(isset($_GET["aid"])){
		$aid=$_GET["aid"];
	}else{
		exit;
	}
	$result=mysql_query("select * from qo_attach where AID={$aid}");
	if(mysql_num_rows($result)>0){
		$file=mysql_fetch_array($result);
		$filename=$file["RealFileName"];
		if(file_exists($filename)){
			//下载计数
			$isCount="yes";
			if(isset($_GET["count"])) $isCount=$_GET["count"];
			if($isCount=="yes"){
				$result=mysql_fetch_array(mysql_query("select DownCount from qo_attach where AID='{$aid}'"));
				$DownCount=$result["DownCount"]+1;
				mysql_query("update qo_attach set DownCount={$DownCount} where AID={$aid}");
			}
			//日志
			$IP=getIP();
			$datetime=date("Y-m-d H:i:s");
			$username=mysql_fetch_array(mysql_query("select * from qo_user where Username='{$_SESSION['qo_user']}'"));
			$uid=$username["UID"];
			mysql_query("insert into qo_logs values(null, {$uid}, '{$IP}', '{$datetime}', '下载附件{{$file['FileName']}}')");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename={$file['FileName']}");
			header("Content-Length: ".filesize($filename));
			ob_clean();
			flush();
			readfile($filename);
			exit;
		}else{
			header("location: message.php?msg=attach0");
			exit;
		}
	}else{
		exit;
	}
?>