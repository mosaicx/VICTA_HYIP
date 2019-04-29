<?php
include_once '../phpViews/Handler_Users.php';

class SessionHandlers{
	function __construct(){
		if(@!session_start()){
			session_start();
		}
	}

	function setSession($AUID){
		$_SESSION["AUID"] = $AUID;
		$_SESSION['session_time'] = time();
	}

	function isValidSession(){
		if(isset($_SESSION['AUID'])){
			$UserHandler = new UserHandler();
			$UserHandler->selectUserByAuid($_SESSION["AUID"]);
			if($UserHandler->getRecordCount() > 0){
				if(isset($_SESSION['session_time']) && (time() - $_SESSION['session_time']) < 1800){
					$_SESSION['session_time'] = time();
					return true;
				}else{
					unset($_SESSION["AUID"]);
					unset($_SESSION['session_time']);
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}
?>
