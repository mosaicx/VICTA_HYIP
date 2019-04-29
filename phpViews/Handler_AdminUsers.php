<?php
// get database connection
include_once '../phpDatabase/Database.php';
// instantiate user object
include_once '../phpObjects/User.php';
include_once '../phpObjects/AdminUser.php';

 
 class AdminUserHandler{
	public $database;
	public $UID;
	public $Name;
	public $RegDate;
	public $Surname;
	public $Username;
	public $Password;
	public $Clearance;
	public $recordCount;

	
	//Create admin user and password  **works**
	function CreateAdminUser($Name, $Surname, $Username, $Password, $Clearance){
		$AdminUser = new AdminUser();
		$this->Name = $Name;
		$this->Surname = $Surname;
		$this->Username = $Username;
		$this->Password = $Password;
		$this->Clearance = $Clearance;
		$this->UID = bin2hex(openssl_random_pseudo_bytes(6));

		$message = "";

		if($AdminUser->CreateAdminUser($this->UID, $this->Name, $this->Surname, $this->Username, $this->Clearance)){
			$message .= "User created | ";
			if($AdminUser->createUserPassword($this->UID, $this->Password)){
					$message .= "Password created.";
					$message .= "Your account has been created.";
			}
			else{
					$message ="Unable to create Password.";
			}
		}else{
			$message = "Unable to create user.";
		}
		return $message;
	}

	//Selecting admin user by username  **works**
	function selectAdminUserByUsername($Username){

		$AdminUser = new AdminUser();
		$stmt = $AdminUser->selectAdminUserByUsername($Username);
		
		$num = $stmt->rowCount();
	 	
		$this->recordCount = $num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$user_item=array(
					'UID'=>$UID,
					'Name'=>$Name,
					'Surname'=>$Surname,
					'Username'=>$Username,
					'Clearance'=>$Clearance,
					'RegDate'=>$RegDate,
					"Message" => "user found."
				);
				
					$this->UID=$UID;
					$this->Name=$Name;
					$this->Surname=$Surname;
					$this->Username=$Username;
					$this->Clearance=$Clearance;
					$this->RegDate=$RegDate;
			}
		}else{
				$user_item =array(
					"Message" => "no user found."
			);
		}
	}
	
	//Selecting admin user by username and password **works**
	function selectAdminUsernamePass($Username, $Password){
		$AdminUser = new AdminUser();
		$stmt = $AdminUser->selectAdminUsernamePass($Username, $Password);
		$num = $stmt->rowCount();
		$message = '';
		$this->users_arr=array();
		$this->users_arr["users"]=array();
		$this->recordCount = $num;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$user_item=array(
					"UID" => $UID,
					"Name" => $Name,
					"Surname" => $Surname,
					"Username" => $Username,
					"Clearance" => $Clearance,
					"RegDate" => $RegDate,
					"Message" => "user found."
					
				);
				
					$this->UID=$user_item['UID'];
					$this->Name=$user_item['Name'] ;
					$this->Surname=$user_item['Surname'];
					$this->Username=$user_item['Username'];
					$this->Clearance=$user_item['Clearance'];
					$this->RegDate=$RegDate;
					$message = $user_item['Message'];
			}
		}else{
			$user_item =array(
				"Message" => "no user found."
			);
			$message = $user_item['Message'];
		}
		return $message;
	}

	//Selecting admin user by UID **works**
	function selectAdminUserByAuid($UID){
		$AdminUser = new AdminUser();
		$stmt = $AdminUser->selectAdminUserByAuid($UID);
		$message = '';
		$num = $stmt->rowCount();
		$this->recordCount = $num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$user_item=array(
					"UID" => $UID,
					"Name" => $Name,
					"Surname" => $Surname,
					"Username" => $Username,
					"Clearance" => $Clearance,
					"RegDate" => $RegDate,
					"Message" => "user found."
				);
				
				$this->UID=$user_item['UID'];
				$this->Name=$user_item['Name'];
				$this->Surname=$user_item['Surname'];
				$this->Username=$user_item['Username'];
				$this->Clearance=$user_item['Clearance'];
				$this->RegDate=$user_item['RegDate'];
				$message = $user_item['Message'];				
				
			}
		}else{
				$message = "no user found.";
		}
		return $message;
	}
	
	//**works**
	public function getRecordCount(){
		return $this->recordCount;
	}
	//**works**
	public function getUID(){
		return  $this->UID;
	}
	//**works**
	public function getFirstName(){
		return  $this->Name;
	}
	//**works**
	public function getSurname(){
		return  $this->Surname;
	}
	//**works**
	public function getUsername(){
		return  $this->Username;
	}
	//**works**
	public function getClearance(){
		return  $this->Clearance;
	}
	//**works**
	public function getRegDate(){
		return  $this->RegDate;
	}
}
?>