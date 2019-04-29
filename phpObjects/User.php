<?php
include_once '../phpDatabase/Database.php';
class User{
 
    // database connection and table name
    // object properties
    public $Name;
    public $Surname;
    public $Email;
    public $GUID;
    public $RegDate;
    public $password;
    public $Username;
    public $database;
    private $conn;
 
 
    // constructor with $db as database connection
    public function __construct(){
		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;
    }
	
	function selectAllUsers(){
	
		$query = "SELECT Name, Surname, Username, Email, GUID, VerifyEmail, VerifyKyc, 
			RegDate FROM users";
			
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		return $stmt;	
	}

	function selectUserByAuid($AUID){
	
		$query = "SELECT Name, Surname, Username, Email, VerifyEmail, VerifyKyc, RegDate FROM users where GUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);

		$AUID=htmlspecialchars(strip_tags($AUID));
		
		$stmt->bindParam(1, $AUID);

		$stmt->execute();
		return $stmt;	
	}
	
	//Select User
	function selectUserByEmail($Email){
	
		$query = "SELECT Name, Surname, Username, Email, GUID, RegDate FROM users where Email = '$Email'";
			
		$stmt = $this->conn->prepare($query);

		$Email=htmlspecialchars(strip_tags($Email));
		
		$stmt->bindParam(1, $Email);

		$stmt->execute();
		return $stmt;	
	}

	//Select User
	function selectPassHoldByAuid($AUID){
	
		$query = "SELECT Password, passwordHold FROM passwords where GUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);

		$AUID=htmlspecialchars(strip_tags($AUID));
		
		$stmt->bindParam(1, $AUID);

		$stmt->execute();
		return $stmt;	
	}

	//Select User
	function selectUserByEmailAndPass($Email,  $Password){
	
		$query = "SELECT u.Name, u.Surname, u.Username, u.Email, u.GUID, u.RegDate FROM users u INNER JOIN 
			passwords p ON p.GUID = u.GUID where u.Email = '$Email' AND p.password = '$Password'";
			
		$stmt = $this->conn->prepare($query);

		$Email=htmlspecialchars(strip_tags($Email));
		$Password=htmlspecialchars(strip_tags($Password));
		
		$stmt->bindParam(1, $Email);
		$stmt->bindParam(2, $Password);

		$stmt->execute();
		return $stmt;	
	}
	
	// create user
	function createUser($GUID, $Name, $Surname, $Username, $Email){
		$RegDate = date('Y-m-d H:i:s');
		$VerifyKyc = 'false';
		$VerifyEmail = 'false';
		$query = "INSERT INTO users SET Name=:Name, Surname=:Surname, Username=:Username, Email=:Email, GUID=:GUID, VerifyEmail=:VerifyEmail, VerifyKyc=:VerifyKyc, RegDate=:RegDate";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->Name=htmlspecialchars(strip_tags($Name));
		$this->Surname=htmlspecialchars(strip_tags($Surname));
		$this->Username=htmlspecialchars(strip_tags($Username));
		$this->Email=htmlspecialchars(strip_tags($Email));
		$this->GUID=htmlspecialchars(strip_tags($GUID));
		$VerifyEmail=htmlspecialchars(strip_tags($VerifyEmail));
		$VerifyKyc=htmlspecialchars(strip_tags($VerifyKyc));
		$this->RegDate=htmlspecialchars(strip_tags($RegDate));
	 
		// bind values
		$stmt->bindParam(":Name", $this->Name);
		$stmt->bindParam(":Surname", $this->Surname);
		$stmt->bindParam(":Username", $this->Username);
		$stmt->bindParam(":Email", $this->Email);
		$stmt->bindParam(":GUID", $this->GUID);
		$stmt->bindParam(":VerifyEmail", $VerifyEmail);
		$stmt->bindParam(":VerifyKyc", $VerifyKyc);
		$stmt->bindParam(":RegDate", $RegDate);
	 
		// execute query
		return $stmt->execute();
	}
	
	// create user password
	function createUserPassword($GUID, $Password){
		// query to insert record
		$query = "INSERT INTO passwords SET GUID=:GUID, Password=:Password";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$GUID=htmlspecialchars(strip_tags($GUID));
		$Password=htmlspecialchars(strip_tags($Password));
	 
		// bind values
		$stmt->bindParam(":GUID", $GUID);
		$stmt->bindParam(":Password", $Password);
		
		// execute query
		return $stmt->execute();
	}
	
	// update the product
	function updateUserPasswordHold($GUID, $Password){
		// update query
		$query = "UPDATE passwords SET passwordHold = :passwordHold WHERE GUID = :GUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$GUID=htmlspecialchars(strip_tags($GUID));
		$Password=htmlspecialchars(strip_tags($Password));
	 
		// bind new values
		$stmt->bindParam(':GUID', $GUID);
		$stmt->bindParam(':passwordHold', $Password);

		// execute the query
		return $stmt->execute();
	}

	// update the product
	function updateUserPassword($GUID, $Password){
		// update query
		$query = "UPDATE passwords SET Password = :Password WHERE GUID = :GUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$GUID=htmlspecialchars(strip_tags($GUID));
		$Password=htmlspecialchars(strip_tags($Password));
	 
		// bind new values
		$stmt->bindParam(':GUID', $GUID);
		$stmt->bindParam(':Password', $Password);

		// execute the query
		return $stmt->execute();
	}

	function updateEmailVerifyStatus($GUID){
		// update query
		$query = "UPDATE users SET VerifyEmail = :VerifyEmail WHERE GUID = :GUID";
		$VerifyEmail = 'true';
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$GUID=htmlspecialchars(strip_tags($GUID));
		$VerifyEmail=htmlspecialchars(strip_tags($VerifyEmail));
		// bind new values
		$stmt->bindParam(':GUID', $GUID);			 
		$stmt->bindParam(':VerifyEmail', $VerifyEmail);			 

		// execute the query
		return $stmt->execute();
	}
	
	function updateKycVerifyStatus($GUID){
		// update query
		$query = "UPDATE users SET VerifyKyc = :VerifyKyc WHERE GUID = :GUID";
		$VerifyKyc = 'true';
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$GUID=htmlspecialchars(strip_tags($GUID));
		$VerifyKyc=htmlspecialchars(strip_tags($VerifyKyc));
		// bind new values
		$stmt->bindParam(':GUID', $GUID);			 
		$stmt->bindParam(':VerifyKyc', $VerifyKyc);			 

		// execute the query
		return $stmt->execute();
	}	
}


?>