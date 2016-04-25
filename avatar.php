<?php
	session_start();
	require_once("include/db.php");
	require_once("include/func.php");
	
	//头像目录
	$dir="./images-avatar";
	
	//头像上传
	if(isset($_POST["upload"])){
		if(!isset($_SESSION["qo_user"])) exit; //必须登录才能上传头像
		header("Content-Type: text/html; charset=utf-8");
		
		$uid=getUID($_SESSION["qo_user"]);
		$result=array();
		$result["success"]=false;
		$success_num=0;
		$msg="";
		
		if(!file_exists($dir)) mkdir($dir);
		
		//处理头像图片开始
		//头像图片file域
		$avatars=array("big", "middle", "small");
		$avatars_length=count($avatars);
		for($i=0; $i<$avatars_length; $i++){
			$avatar=$_FILES[$avatars[$i]];
			$avatar_number=$i+1;
			
			if($avatar["error"]>0){
				$msg.=$avatar["error"];
			}else{
				//以 UID_avatar_大小 作为文件名
				$filename=$uid."_avatar_".$avatars[$i].".jpg";
				
				////旧头像备份
				//$c=1;
				//$oldname="";
				//while(file_exists($dir."/".($oldname=$uid."_avatar_".$avatars[$i]."_old{$c}.jpg"))){
				//	$c++;
				//}
				
				$savePath=$dir."/".$filename;
				//if(file_exists($savePath)) rename($savePath, $dir."/".$oldname);
				move_uploaded_file($avatar["tmp_name"], $savePath);
				$success_num++;
			}
		}
		//处理头像图片结束
		
		$result["msg"]=$msg;
		if($success_num>0){
			$result["success"]=true;
		}
		//返回图片的保存结果（返回内容为json字符串）
		print json_encode($result);
	}
	
	//获取头像
	else{
		$size_arr=array("big","middle","small");
		$uid=isset($_GET["uid"]) ? (int)$_GET["uid"] : "0";
		$size=isset($_GET["size"]) ? $_GET["size"] : "";
		$size=in_array($_GET["size"],$size_arr) ? $_GET["size"] : "middle";
		
		$avatarfile=$dir."/".$uid."_avatar_".$size.".jpg";
		if(file_exists($avatarfile)){
			header("location: {$avatarfile}");
			exit;
		}else{
			header("location: images/noavatar_{$size}.jpg");
			exit;
		}
	}
?>