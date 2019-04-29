<?php
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/User.php';
include_once '../phpObjects/Email.php';
 
 class UserHandler{
	public $database;
	public $Email;
	public $passwordHold;
	public $Password;
	public $GUID;
	public $Name;
	public $Surname;
	public $Username;
	public $RegDate;
	public $VerifyEmail;
	public $VerifyKyc;
	public $recordCount;
	
	public function __construct(){}
	
	//Creating user and passowrd **works**
	function createUser($Name, $Surname, $Username, $Email, $Password){
		$user = new User();
		 $message = "";
		$GUID = bin2hex(openssl_random_pseudo_bytes(6));
		if($user->createUser($GUID, $Name, $Surname, $Username, $Email)){
			$message = "User created | ";
			if($user->createUserPassword($GUID, $Password)){
					$message = "Password created |";
					$message = "Your account has been created | Please login and proceed to prfile page to get started.";
			}
			else{
					$message ="Unable to create Password.";
			}
		}else{
			$message = "Unable to create user.";
		}
		return $message;
	}
	
	//selecting users based on email and password **works**
	function selectUserByEmailAndPass($Email, $Password){
		$user = new User();
		$stmt = $user->selectUserByEmailAndPass($Email, $Password);
		$num = $stmt->rowCount();
		$this->recordCount = $num;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

				extract($row);
				$user_item=array(
					"Name" => $Name,
					"Surname" => $Surname,
					"Username" => $Surname,
					"Email" => $Email,
					"GUID" => $GUID,
					"RegDate" => $RegDate,
					"Message" => "user found."
				);
				$this->Name=$Name;
				$this->Surname=$Surname;
				$this->Username=$Username;
				$this->Email=$Email;
				$this->GUID=$GUID;
				$this->RegDate=$RegDate;
				$message =$user_item{'Message'};
			}
		}else{
			$user_item =array(
				"Message" => "no user found."
			);
			$message =$user_item{'Message'};
		}
			return $message;

	}
	
	//selecting users based on email **works**
	function selectUserByEmail($Email){
		$user = new User();
		$stmt = $user->selectUserByEmail($Email);
		$num = $stmt->rowCount();
	 	
		$this->recordCount = $num;
		if($num>0){

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

				extract($row);
				$user_item=array(
					"Name" => $Name,
					"Surname" => $Surname,
					"Username" => $Username,
					"Email" => $Email,
					"GUID" => $GUID,
					"RegDate" => $RegDate,
					"Message" => "user found."
				);
				
					$this->Name=$Name;
					$this->Surname=$Surname;
					$this->Username=$Username;
					$this->Email=$Email;
					$this->GUID=$GUID;
					$this->RegDate=$RegDate;
					$message =$user_item{'Message'};
			}
		}else{
				$user_item =array(
					"Message" => "no user found."
			);
			$message =$user_item{'Message'};
		}
		return $message;
	}

	//selecting users based on email **works**
	function selectUserByAuid($AUID){
		$user = new User();
		$stmt = $user->selectUserByAuid($AUID);
		$num = $stmt->rowCount();
		$message= '';
		$this->recordCount = $num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$user_item=array(
					"Name" => $Name,
					"Surname" => $Surname,
					"Username" => $Username,
					"Email" => $Email,
					"VerifyEmail" => $VerifyEmail,
					"VerifyKyc" => $VerifyKyc,
					"RegDate" => $RegDate,
					"Message" => "user found."
				);
				
				$this->Name=$user_item['Name'];
				$this->Surname=$user_item['Surname'];
				$this->Username=$user_item['Username'];
				$this->Email=$user_item['Email'];
				$this->RegDate=$user_item['RegDate'];
				$this->VerifyEmail=$user_item['VerifyEmail'];
				$this->VerifyKyc=$user_item['VerifyKyc'];
				$message = $user_item['Message'];
			}
		}else{
				$message = "no user found.";
		}
		return $message;
	}
	
	//updating users password by based on GUID/AUID **works**
	function updateUserPassword($GUID, $Password){
		$user = new User();
		$this->Password = $Password;
		$this->GUID = $GUID;
		if($user->updateUserPassword($this->GUID, $this->Password)){
			return "Password updated";
		}else{
			return "unable to update user password.";
		}
	}

	function updateEmailVerifyStatus($GUID){
		$user = new User();
		$this->GUID = $GUID;
		if($user->updateEmailVerifyStatus($this->GUID)){
			return "Email verified";
		}else{
			return "unable to verify email.";
		}
	}

	function resetPassword($Email){
		$user = new User();
		$EmailHandler = new EmailHandler();

		$stmt = $user->selectUserByEmail($Email);
		$num = $stmt->rowCount();
		$message= '';
		$this->recordCount = $num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$user_item=array(
					"Name" => $Name,
					"Surname" => $Surname,
					"Username" => $Username,
					"Email" => $Email,
					"GUID" => $GUID,
					"RegDate" => $RegDate,
					"Message" => "user found."
				);
				
				$this->Name=$user_item['Name'];
				$this->Surname=$user_item['Surname'];
				$this->Username=$user_item['Username'];
				$this->Email=$user_item['Email'];
				$this->GUID=$user_item['GUID'];
				$this->RegDate=$user_item['RegDate'];
				$message = $user_item['Message'];
			}
		}
		$password = bin2hex(openssl_random_pseudo_bytes(4));
		 echo $password;
		if($stmt = $user->updateUserPassword($this->GUID, sha1($password))){
			if($EmailHandler->sendNewPassword($this->Email, $this->Username, $password)){
				return "Your new password was sent to your email. Use this new password to login together with your email.";				
			}else{
				return "Failed to email new  password . Please try again later.";
			}
		}
	}

	function updateUserPasswordHold($GUID, $Password){
		$user = new User();
		$this->Password = $Password;
		$this->GUID = $GUID;
		if($user->updateUserPasswordHold($this->GUID, $this->Password)){
			return "Password updated";
		}else{
			return "unable to update user password.";
		}
	}

	function selectPassHoldByAuid($GUID){
		$user = new User();
		$stmt = $user->selectPassHoldByAuid($GUID);
		$num = $stmt->rowCount();
		$message= '';
		$this->recordCount = $num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$user_item=array(
					"passwordHold" => $passwordHold,
					"Password" => $Password,
					"message" => 'Record found'
				);
				
				$this->passwordHold=$user_item['passwordHold'];
				$this->Password=$user_item['Password'];
				$message = $user_item['message'];
			}
		}else{
				$message = "no user found.";
		}
		return $message;
	}
			
	// **works**
	public function getPassword(){
		return $this->Password;
	}
// **works**
	public function getPasswordHold(){
		return $this->passwordHold;
	}
// **works**
	public function getRecordCount(){
		return $this->recordCount;
	}
	// **works**
	public function getUserArray(){
		return  json_encode($this->users_arr);
	}
	// **works**
	public function getFirstName(){
		return  $this->Name;
	}
	// **works**
	public function getSurname(){
		return  $this->Surname;
	}
	// **works**
	public function getUsername(){
		return  $this->Username;
	}
	// **works**
	public function getEmail(){
		return  $this->Email;
	}
	// **works**
	public function getEmailVerifyStatus(){
		return  $this->VerifyEmail;
	}
	// **works**
	public function getKycVerifyStatus(){
		return  $this->VerifyKyc;
	}
	// **works**
	public function getGUID(){
		return  $this->GUID;
	}
	// **works**
	public function getRegDate(){
		return  $this->RegDate;
	}
}
?>