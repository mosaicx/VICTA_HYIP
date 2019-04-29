<?php
include_once '../phpDatabase/Database.php';
class AdminUser{
 
    // database connection and table name
    // object properties
    public $Name;
    public $Surname;
    public $Username;
    public $UID;
    public $Clearance;
    public $RegDate;
    public $password;
    public $database;
    private $conn;
 
 
    // constructor with $db as database connection
    public function __construct(){
		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;
    }
	//Select User
	function selectAdminUserByUsername($Username){
		$this->Username = $Username;
		$query = "SELECT UID, Name, Surname, Username, Clearance, RegDate FROM adminuser where Username = '".$this->Username."'";
			
		$stmt = $this->conn->prepare($query);

		$this->Username=htmlspecialchars(strip_tags($this->Username));
		
		$stmt->bindParam(1, $this->Username);

		$stmt->execute();
		return $stmt;	
	}
	//Select User
	function selectAdminUserByAuid($UID){
		$this->UID = $UID;
		$query = "SELECT Name, Surname, Username, Clearance, RegDate FROM adminuser where UID = '".$this->UID."'";
			
		$stmt = $this->conn->prepare($query);

		$UID=htmlspecialchars(strip_tags($this->UID));
		
		$stmt->bindParam(1, $UID);

		$stmt->execute();
		return $stmt;	
	}
	
	//Select User
	function selectAdminUsernamePass($Username, $Password){
	
		$query = "SELECT u.Name, u.Surname, u.Username, u.UID, u.Clearance, u.RegDate FROM adminuser u INNER JOIN 
			passwords p ON p.GUID = u.UID where u.Username = '".$Username."' AND p.password = '".$Password."'";
			
		$stmt = $this->conn->prepare($query);

		$Username=htmlspecialchars(strip_tags($Username));
		$Password=htmlspecialchars(strip_tags($Password));
		
		$stmt->bindParam(1, $Username);
		$stmt->bindParam(2, $Password);

		$stmt->execute();
		return $stmt;	
	}
	
	// create user
	function CreateAdminUser($UID, $Name, $Surname, $Username, $Clearance){
		$RegDate = date('Y-m-d H:i:s');
		$this->UID = $UID;
		// query to insert record
		$query = "INSERT INTO adminuser SET UID=:UID, Name=:Name, Surname=:Surname,";
		$query .= "Username=:Username, Clearance=:Clearance, RegDate=:RegDate";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->UID=htmlspecialchars(strip_tags($UID));
		$this->Name=htmlspecialchars(strip_tags($Name));
		$this->Surname=htmlspecialchars(strip_tags($Surname));
		$this->Username=htmlspecialchars(strip_tags($Username));
		$this->Clearance=htmlspecialchars(strip_tags($Clearance));
		$this->RegDate=htmlspecialchars(strip_tags($this->RegDate));
	 
		// bind values
		$stmt->bindParam(":UID", $UID);
		$stmt->bindParam(":Name", $Name);
		$stmt->bindParam(":Surname", $Surname);
		$stmt->bindParam(":Username", $Username);
		$stmt->bindParam(":Clearance", $Clearance);
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
		$this->UID=htmlspecialchars(strip_tags($GUID));
		$Password=htmlspecialchars(strip_tags($Password));
	 
		// bind values
		$stmt->bindParam(":GUID", $GUID);
		$stmt->bindParam(":Password", $Password);
		
		// execute query
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
	
	//Count Users
	function countUsers(){
	
		$query = "SELECT UID FROM adminsers";
			
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		return $stmt;	
	}
}

?>