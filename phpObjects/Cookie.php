<?php
// get database connection
include_once '../phpDatabase/Database.php';
// instantiate user object
include_once '../phpObjects/User.php';
include_once '../phpViews/SelectUser.php';
 
 class Cookie{
	 public $token;
		
	// public function __construct($Email, $Password, $GUID){
	public function __construct($AUID){
		$this->token = bin2hex(openssl_random_pseudo_bytes(30));
		$this->storeTokenForUser($AUID);
	}
	
	 function storeTokenForUser($AUID){
		 echo $AUID."<br/>";
		 echo $this->token."<br/>";
	 }
}
$Cookie = new Cookie('asd');
?>