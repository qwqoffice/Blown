<?php
	require_once("include/db.php");
	require_once("include/func.php");

	if(isset($_POST["m"])){
		$m=$_POST["m"];
	}else{
		exit;
	}
	
	if($m=="downcount"){
		if(isset($_POST["aid"])){
			$aid=$_POST["aid"];
		}else{
			exit;
		}
		
		$count=getDownloadCount($aid);
		echo json_encode(array("count"=>$count));
	}
?>