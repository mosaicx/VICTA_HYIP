<?php
include_once '../phpDatabase/Database.php';

class Deposit{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $AUID; //associated user ID (GUID)
    public $TXID; //transaction ID
    public $TxDate; //transaction date and time
    public $AmountReceived;
    public $SenderAddress;
    public $Currency;
    public $ExchangeRate;
    public $Status;
    public $LoggedBy;
    public $ConfirmedBy;
    public $ConfirmDate;
    public $adminUser;
    public $database;
    public $db;
	
    // constructor with $db as database connection
    public function __construct(){
		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;
    }
	//Select All Deposits
	function SelectAllDeposits(){
	
		$query = "SELECT AUID, TXID, TxDate, AmountReceived, SenderAddress, Currency, ExchangeRate, ";
		$query .= "Status, LoggedBy, ConfirmedBy, ConfirmDate FROM deposits";
			
		$stmt = $this->conn->prepare($query);
			
		$stmt->execute();
		return $stmt;
	}

	//Select Deposit by User ID
	function SelectDepositByUser($AUID){
	
		$query = "SELECT AUID, TXID, TxDate, AmountReceived, SenderAddress, Currency, ExchangeRate, Status FROM deposits 
			where AUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);
		
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		
		$stmt->bindParam(1, $this->AUID);
			
		$stmt->execute();
		return $stmt;
	}

		//Select Deposit by User ID
	function SelectGlobalDepositExchangeRate(){
	
		$query = "SELECT AmountReceived, ExchangeRate FROM deposits";
			
		$stmt = $this->conn->prepare($query);
			
		$stmt->execute();
		return $stmt;
	}

	//Select Deposit by User ID
	function SelectUserDepositExchangeRate($AUID){
	
		$query = "SELECT AmountReceived, ExchangeRate FROM deposits 
			where AUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);
		
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		
		$stmt->bindParam(1, $this->AUID);
			
		$stmt->execute();
		return $stmt;
	}


	//Select Deposit by Tx ID
	function SelectDepositByTxId($TXID){
	
		$query = "SELECT AUID, TXID, TxDate, AmountReceived, SenderAddress, Currency, ExchangeRate, Status FROM deposits 
			where TXID = '$TXID'";
			
		$stmt = $this->conn->prepare($query);
		
		$TXID=htmlspecialchars(strip_tags($TXID));
		
		$stmt->bindParam(1, $TXID);
			
		$stmt->execute();
		return $stmt;
	}
	//Select Deposit by Tx ID
	function SelectPendingDeposits(){
	
		$query = "SELECT AUID, TXID, TxDate, AmountReceived, SenderAddress, Currency, ExchangeRate, Status FROM deposits 
			where Status = 'PENDING'";
			
		$stmt = $this->conn->prepare($query);
					
		$stmt->execute();
		return $stmt;
	}
		//Select All Deposits
	function SelectGlobalDeposit(){
	
		$query = "SELECT AUID, TXID, TxDate, AmountReceived, SenderAddress, Currency, ExchangeRate, Status FROM deposits";
			
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute();
		return $stmt;
	}

	
	// create withdrawal transaction record
	function createDeposit($AUID, $TXID, $TxDate, $AmountReceived, $SenderAddress, $Currency, $ExchangeRate, 
		$Status, $LoggedBy, $ConfirmedBy, $ConfirmDate){ 
		// query to insert record
		$query = "INSERT INTO deposits SET AUID=:AUID, TXID=:TXID, TxDate=:TxDate, AmountReceived=:AmountReceived, 
			SenderAddress=:SenderAddress, Currency=:Currency, ExchangeRate=:ExchangeRate, Status=:Status, 
			LoggedBy=:LoggedBy, ConfirmedBy=:ConfirmedBy, ConfirmDate=:ConfirmDate";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		$this->TXID=htmlspecialchars(strip_tags($TXID));
		$this->TxDate=htmlspecialchars(strip_tags($TxDate));
		$this->AmountReceived=htmlspecialchars(strip_tags($AmountReceived));
		$this->SenderAddress=htmlspecialchars(strip_tags($SenderAddress));
		$this->Currency=htmlspecialchars(strip_tags($Currency));
		$this->ExchangeRate=htmlspecialchars(strip_tags($ExchangeRate));
		$this->Status=htmlspecialchars(strip_tags($Status));
		$this->LoggedBy=htmlspecialchars(strip_tags($LoggedBy));
		$this->ConfirmedBy=htmlspecialchars(strip_tags($ConfirmedBy));
		$this->ConfirmDate=htmlspecialchars(strip_tags($ConfirmDate));
	 
		// bind values
		$stmt->bindParam(":AUID", $this->AUID);
		$stmt->bindParam(":TXID", $this->TXID);
		$stmt->bindParam(":TxDate", $this->TxDate);
		$stmt->bindParam(":AmountReceived", $this->AmountReceived);
		$stmt->bindParam(":SenderAddress", $this->SenderAddress);
		$stmt->bindParam(":Currency", $this->Currency);
		$stmt->bindParam(":ExchangeRate", $this->ExchangeRate);
		$stmt->bindParam(":Status", $this->Status);
		$stmt->bindParam(":LoggedBy", $this->LoggedBy);
		$stmt->bindParam(":ConfirmedBy", $this->ConfirmedBy);
		$stmt->bindParam(":ConfirmDate", $this->ConfirmDate);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
		// update the deposit status
	function updateDepositStatus($TXID, $Status, $adminUser){
	 	// update query
		$query = "UPDATE deposits SET Status = :Status, ConfirmedBy = :ConfirmedBy, ConfirmDate = :ConfirmDate WHERE TXID = :TXID";
		$this->ConfirmDate = date('Y-m-d H:i:s');
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->TXID=htmlspecialchars(strip_tags($TXID));
		$this->Status=htmlspecialchars(strip_tags($Status));
		$this->ConfirmDate=htmlspecialchars(strip_tags($this->ConfirmDate));
		$this->adminUser=htmlspecialchars(strip_tags($adminUser));
	 
		// bind new values
		$stmt->bindParam(':TXID', $TXID);
		$stmt->bindParam(':Status', $Status);
		$stmt->bindParam(':ConfirmDate', $ConfirmDate);
		$stmt->bindParam(':ConfirmedBy', $this->adminUser);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
}
?>