<?php
	session_start();
	//instantiation of classes

	unset($_SESSION["AUID"]);
	unset($_SESSION['session_time']);
	header("Location: login.php");
	?>