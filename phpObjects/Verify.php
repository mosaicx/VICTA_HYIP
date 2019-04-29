<?php
include_once '../phpDatabase/Database.php';
class Verify{
 
    // database connection and table name
    // object properties
    public $UID;
    public $DateModified;
    public $VerificationCode;
    public $database;
    private $conn;
 
 
    // constructor with $db as database connection
    public function __construct(){
		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;
    }
	
	function selectEmailVerificationByUID($UID){
	
		$query = "SELECT UID, VerificationCode, VerifyType, DateModified FROM verify where UID = '$UID' AND VerifyType = 'email'";
			
		$stmt = $this->conn->prepare($query);

		$UID=htmlspecialchars(strip_tags($UID));
		
		$stmt->bindParam(1, $UID);

		$stmt->execute();
		return $stmt;	
	}

	function selectPassVerificationByUID($UID){
	
		$query = "SELECT UID, VerificationCode, VerifyType, DateModified FROM verify where UID = '$UID' AND VerifyType = 'password'";
			
		$stmt = $this->conn->prepare($query);

		$UID=htmlspecialchars(strip_tags($UID));
		
		$stmt->bindParam(1, $UID);

		$stmt->execute();
		return $stmt;	
	}
	
	function createEmailVerify($UID){
		$DateModified = date('Y-m-d H:i:s');
		$VerifyType = 'email';
		$VerificationCode =bin2hex(openssl_random_pseudo_bytes(5));;
		
		$query = "INSERT INTO verify SET UID=:UID, VerificationCode=:VerificationCode, VerifyType = :VerifyType, DateModified=:DateModified";

		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->UID=htmlspecialchars(strip_tags($this->UID));
		$this->VerificationCode=htmlspecialchars(strip_tags($this->VerificationCode));
		$VerifyType=htmlspecialchars(strip_tags($VerifyType));
		$this->DateModified=htmlspecialchars(strip_tags($this->DateModified));
		
		// bind values
		$stmt->bindParam(":UID", $UID);
		$stmt->bindParam(":VerificationCode", $VerificationCode);
		$stmt->bindParam(":VerifyType", $VerifyType);
		$stmt->bindParam(":DateModified", $DateModified);
	 
		echo $VerificationCode;
		return $stmt->execute();
	}
	function createPassVerify($UID){
		$DateModified = date('Y-m-d H:i:s');
		$VerifyType = 'password';
		$VerificationCode =bin2hex(openssl_random_pseudo_bytes(5));;
		
		$query = "INSERT INTO verify SET UID=:UID, VerificationCode=:VerificationCode, VerifyType = :VerifyType, DateModified=:DateModified";

		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->UID=htmlspecialchars(strip_tags($this->UID));
		$this->VerificationCode=htmlspecialchars(strip_tags($this->VerificationCode));
		$VerifyType=htmlspecialchars(strip_tags($VerifyType));
		$this->DateModified=htmlspecialchars(strip_tags($this->DateModified));
		
		// bind values
		$stmt->bindParam(":UID", $UID);
		$stmt->bindParam(":VerificationCode", $VerificationCode);
		$stmt->bindParam(":VerifyType", $VerifyType);
		$stmt->bindParam(":DateModified", $DateModified);
	 
		return $stmt->execute();
	}
		
	function updatePassVerify($UID){
		$query = "UPDATE verify SET VerificationCode= :VerificationCode, DateModified= :DateModified WHERE UID = :UID AND VerifyType = :VerifyType";

		$VerificationCode =bin2hex(openssl_random_pseudo_bytes(5));;
		$VerifyType = 'password';
		$DateModified = date('Y-m-d H:i:s');
		
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$UID=htmlspecialchars(strip_tags($UID));
		$VerifyType=htmlspecialchars(strip_tags($VerifyType));
		$DateModified=htmlspecialchars(strip_tags($DateModified));
		$VerificationCode=htmlspecialchars(strip_tags($VerificationCode));
		
		// bind new values
		$stmt->bindParam(':UID', $UID);			 
		$stmt->bindParam(':VerifyType', $VerifyType);			 
		$stmt->bindParam(':DateModified', $DateModified);			 
		$stmt->bindParam(':VerificationCode', $VerificationCode);

		// execute the query
		return $stmt->execute();
	}

	function updateEmailVerify($UID){
		$query = "UPDATE verify SET VerificationCode= :VerificationCode, DateModified= :DateModified WHERE UID = :UID AND VerifyType = :VerifyType";

		$VerificationCode =bin2hex(openssl_random_pseudo_bytes(5));;
		$VerifyType = 'email';
		$DateModified = date('Y-m-d H:i:s');
		
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$UID=htmlspecialchars(strip_tags($UID));
		$VerifyType=htmlspecialchars(strip_tags($VerifyType));
		$DateModified=htmlspecialchars(strip_tags($DateModified));
		$VerificationCode=htmlspecialchars(strip_tags($VerificationCode));
		
		// bind new values
		$stmt->bindParam(':UID', $UID);			 
		$stmt->bindParam(':VerifyType', $VerifyType);			 
		$stmt->bindParam(':DateModified', $DateModified);			 
		$stmt->bindParam(':VerificationCode', $VerificationCode);

		// execute the query
		return $stmt->execute();
	}
}


?>