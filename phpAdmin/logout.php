<?php
	session_start();
	//instantiation of classes
	include_once '../phpViews/Handler_AdminUsers.php';	
	$AdminUserHandler = new AdminUserHandler();

	if(isset($_SESSION["ADMIN_ID"])){
		$AdminUserHandler ->selectAdminUserByAuid($_SESSION["ADMIN_ID"]);
		if($AdminUserHandler->getRecordCount() > 0){
			unset($_SESSION["ADMIN_ID"]);
			header("Location: login.php");
		}else{
			unset($_SESSION["ADMIN_ID"]);	
			header("Location: login.php");
		}
	}else{
		header("Location: login.php");
	}
	?>