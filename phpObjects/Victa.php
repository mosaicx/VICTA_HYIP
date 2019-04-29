<?php
include_once '../phpDatabase/Database.php';

class Victa{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $AUID; //associated user ID (GUID)
    public $TXID; //transaction ID
    public $TxDate; //transaction date and time
    public $VictaCode;
    public $VictaPrice;
    public $Quantity;
    public $database;
    public $db;
	
    // constructor with $db as database connection
    public function __construct(){
		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;
    }
	//Select All Deposits
	function SelectAllVictas(){
	
		$query = "SELECT AUID, TXID, TxDate, VictaCode, VictaPrice, Quantity FROM victa";
			
		$stmt = $this->conn->prepare($query);
			
		$stmt->execute();
		return $stmt;
	}

	//Select Deposit by User ID
	function SelectVictasByAuid($AUID){
	
		$query = "SELECT AUID, TXID, TxDate, VictaCode, VictaPrice, Quantity FROM victa WHERE AUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);
		
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		
		$stmt->bindParam(1, $this->AUID);
			
		$stmt->execute();
		return $stmt;
	}

	//Select Deposit by Tx ID
	function SelectVictasByTxId($TXID){
		
		$query = "SELECT AUID, TXID, TxDate, VictaCode, VictaPrice, Quantity FROM victa WHERE TXID = '$TXID'";
			
		$stmt = $this->conn->prepare($query);
		
		$TXID=htmlspecialchars(strip_tags($TXID));
		
		$stmt->bindParam(1, $TXID);
			
		$stmt->execute();
		return $stmt;
	}

	
	// create VICTA transaction record
	function createVicta($AUID, $VictaCode, $VictaPrice, $Quantity){ 
		$this->TxDate =  date('Y-m-d H:i:s');
		$this->TXID = bin2hex(openssl_random_pseudo_bytes(6));
		
		// query to insert record
		$query = "INSERT INTO victa SET AUID=:AUID, TXID=:TXID, TxDate=:TxDate, 
			VictaCode=:VictaCode, VictaPrice=:VictaPrice, Quantity=:Quantity";

		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		$this->TXID=htmlspecialchars(strip_tags($this->TXID));
		$this->TxDate=htmlspecialchars(strip_tags($this->TxDate));
		$this->VictaCode=htmlspecialchars(strip_tags($VictaCode));
		$this->VictaPrice=htmlspecialchars(strip_tags($VictaPrice));
		$this->Quantity=htmlspecialchars(strip_tags($Quantity));
	 
		// bind values
		$stmt->bindParam(":AUID", $this->AUID);
		$stmt->bindParam(":TXID", $this->TXID);
		$stmt->bindParam(":TxDate", $this->TxDate);
		$stmt->bindParam(":VictaCode", $this->VictaCode);
		$stmt->bindParam(":VictaPrice", $this->VictaPrice);
		$stmt->bindParam(":Quantity", $this->Quantity);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}	
}
?>