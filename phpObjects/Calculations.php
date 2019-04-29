<?php
include_once '../phpDatabase/Database.php';

class Calculations{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $AUID; //associated user ID (GUID)
    public $AmountSent;
 
    // constructor with $db as database connection
    public function __construct(){
   		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;
	}
	
	//Sum of Withdrawals per user
	function CalculateUserWithdrawalSum($AUID){
	
		$query = "SELECT SUM(AmountSent) AS Sum FROM withdrawals 
			where AUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
	//Sum of Deposits per user
	function CalculateUserDepositSum($AUID){
	
		$query = "SELECT SUM(AmountReceived) AS Sum FROM Deposits 
			where AUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
	//Sum of all Withdrawals 
	function CalculateGlobalWithdrawalSum(){
	
		$query = "SELECT SUM(AmountSent) AS Sum FROM withdrawals";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}

	//Sum of all Withdrawals 
	function CalculateGlobalDepositSum(){
	
		$query = "SELECT SUM(AmountReceived) AS Sum FROM Deposits";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
}
?>