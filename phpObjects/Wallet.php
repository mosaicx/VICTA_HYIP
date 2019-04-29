<?php

// get database connection
include_once '../phpDatabase/Database.php';
 
// instantiate Wallet object
include_once '../phpObjects/Wallet.php';

class Wallet{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $AUID;
    public $WalletGUID; 
    public $WalletType; 
    public $WalletAddress;
    public $ModifyDate;
 
    // constructor with $db as database connection
    public function __construct(){
		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;
    }
	
	//Select Wallet by Address
	function selectWalletByAddress($WalletAddress){
	
		$query = "SELECT AUID, WalletGUID, WalletType, WalletAddress FROM wallets 
			where WalletAddress = '$WalletAddress'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}

	//Select Wallet by User
	function selectWalletByUser($AUID){
	
		$query = "SELECT AUID, WalletGUID, WalletType, WalletAddress FROM wallets 
			where AUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
	
	// create Wallet
	function createWallet($AUID, $WalletType, $WalletAddress){
	
		$ModifyDate = date('Y-m-d H:i:s');
		
		// query to insert record
		$query = "INSERT INTO wallets SET AUID=:AUID, WalletGUID=:WalletGUID, WalletType=:WalletType,
			WalletAddress=:WalletAddress, ModifyDate=:ModifyDate";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($this->AUID));
		$this->WalletGUID=htmlspecialchars(strip_tags($this->WalletGUID));
		$this->WalletType=htmlspecialchars(strip_tags($this->WalletType));
		$this->WalletAddress=htmlspecialchars(strip_tags($this->WalletAddress));
		$this->ModifyDate=htmlspecialchars(strip_tags($this->ModifyDate));
	 
		// bind values
		$stmt->bindParam(":AUID", $AUID);
		$stmt->bindParam(":WalletGUID", $WalletGUID);
		$stmt->bindParam(":WalletType", $WalletType);
		$stmt->bindParam(":WalletAddress", $WalletAddress);
		$stmt->bindParam(":ModifyDate", $ModifyDate);


		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	function updateWallet($AUID, $WalletType, $WalletAddress){
	 	// update query
		$ModifyDate = date('Y-m-d H:i:s');
		
		$query = "UPDATE wallets SET WalletType = :WalletType, WalletAddress = :WalletAddress, ModifyDate = :ModifyDate WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$AUID=htmlspecialchars(strip_tags($AUID));
		$WalletType=htmlspecialchars(strip_tags($WalletType));
		$WalletAddress=htmlspecialchars(strip_tags($WalletAddress));
		$ModifyDate=htmlspecialchars(strip_tags($ModifyDate));

	 
		// bind new values
		$stmt->bindParam(':AUID', $AUID);
		$stmt->bindParam(':WalletType', $WalletType);
		$stmt->bindParam(':WalletAddress', $WalletAddress);
		$stmt->bindParam(':ModifyDate', $ModifyDate);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	function updateWalletType($AUID, $WalletType){
	 	// update query
		$ModifyDate = date('Y-m-d H:i:s');
		$query = "UPDATE wallets SET WalletType = :WalletType, ModifyDate = :ModifyDate WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$AUID=htmlspecialchars(strip_tags($AUID));
		$WalletType=htmlspecialchars(strip_tags($WalletType));
		$ModifyDate=htmlspecialchars(strip_tags($ModifyDate));

	 
		// bind new values
		$stmt->bindParam(':AUID', $AUID);
		$stmt->bindParam(':WalletType', $WalletType);
		$stmt->bindParam(':ModifyDate', $ModifyDate);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	function updateWalletAddress($AUID, $WalletAddress){
	 	// update query
		
		$ModifyDate = date('Y-m-d H:i:s');
		$query = "UPDATE wallets SET WalletAddress = :WalletAddress, ModifyDate = :ModifyDate WHERE AUID = :AUID";
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$AUID=htmlspecialchars(strip_tags($AUID));
		$WalletAddress=htmlspecialchars(strip_tags($WalletAddress));
		$ModifyDate=htmlspecialchars(strip_tags($ModifyDate));

	 
		// bind new values
		$stmt->bindParam(':AUID', $AUID);
		$stmt->bindParam(':WalletAddress', $WalletAddress);
		$stmt->bindParam(':ModifyDate', $ModifyDate);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

}
?>