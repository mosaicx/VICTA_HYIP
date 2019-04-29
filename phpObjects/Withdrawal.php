<?php

include_once '../phpDatabase/Database.php';

class Withdrawal{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $AUID; //associated user ID (GUID)
    public $TXID; //transaction ID
    public $TxDate; //transaction date and time
    public $AmountSent;
    public $ReceiverAddress;
    public $Currency;
    public $ExchangeRate;
    public $Status;
 
    // constructor with $db as database connection
    public function __construct(){
   		$database = new Database();
		$db = $database->getConnection();
        $this->conn = $db;

	}
	
	//Select aLL Withdrawals
	function selectAllWithdrawals(){
	
		$query = "SELECT TXID, TxDate, AmountSent, ReceiverAddress, Currency, ExchangeRate, Status FROM withdrawals";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}

	//Select Withdrawal by Tx ID
	function selectWithdrawalsByUser($AUID){
	
		$query = "SELECT TXID, TxDate, AmountSent, ReceiverAddress, Currency, ExchangeRate, Status FROM withdrawals 
			where AUID = '$AUID'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}

	function SelectPendingWithdrawals(){
	
		$query = "SELECT AUID, TXID, TxDate, AmountSent, ReceiverAddress, Currency, ExchangeRate, Status FROM withdrawals 
			where Status = 'PENDING'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}

	function SelectPendingUserWithdrawals($AUID){
	
		$query = "SELECT AUID, TXID, TxDate, AmountSent, ReceiverAddress, Currency, ExchangeRate, Status FROM withdrawals 
			where Status = 'PENDING' AND AUID='".$AUID."'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}

	function selectWithdrawalsByTxId($TXID){
	
		$query = "SELECT TXID, TxDate, AmountSent, ReceiverAddress, Currency, ExchangeRate, Status FROM withdrawals 
			where TXID = '$TXID'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
	
	
	// create withdrawal transaction record
	function createWithdrawal($AUID, $ReceiverAddress, $TxDate, $AmountSent, $Currency, $ExchangeRate){
	 
		// query to insert record
		$query = "INSERT INTO withdrawals SET AUID=:AUID, TXID=:TXID, TxDate=:TxDate, AmountSent=:AmountSent, 
			ReceiverAddress=:ReceiverAddress, Currency=:Currency, ExchangeRate=:ExchangeRate, Status=:Status";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		$this->TXID=htmlspecialchars(strip_tags(bin2hex(openssl_random_pseudo_bytes(10))));
		$this->TxDate=htmlspecialchars(strip_tags($TxDate));
		$this->AmountSent=htmlspecialchars(strip_tags($AmountSent));
		$this->ReceiverAddress=htmlspecialchars(strip_tags($ReceiverAddress));
		$this->Currency=htmlspecialchars(strip_tags($Currency));
		$this->ExchangeRate=htmlspecialchars(strip_tags($ExchangeRate));
		$this->Status=htmlspecialchars(strip_tags('PENDING'));
	 
		// bind values
		$stmt->bindParam(":AUID", $this->AUID);
		$stmt->bindParam(":TXID", $this->TXID);
		$stmt->bindParam(":TxDate", $this->TxDate);
		$stmt->bindParam(":AmountSent", $this->AmountSent);
		$stmt->bindParam(":ReceiverAddress", $this->ReceiverAddress);
		$stmt->bindParam(":Currency", $this->Currency);
		$stmt->bindParam(":ExchangeRate", $this->ExchangeRate);
		$stmt->bindParam(":Status", $this->Status);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	//Updates the status field of the withdrawal record matching the provided transaction ID
	function updateWithdrawalStatus($TXID, $UID){
	 	// update query
		$query = "UPDATE withdrawals SET Status = :Status, ConfirmedBy = :ConfirmedBy, 
			ConfirmDate = :ConfirmDate  WHERE TXID = :TXID";
		$this->TXID = $TXID;
		$ConfirmedBy = $UID;
		$ConfirmDate = date('Y-m-d H:i:s');
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->TXID=htmlspecialchars(strip_tags($TXID));
		$Status=htmlspecialchars(strip_tags('COMPLETE'));
	 
		// bind new values
		$stmt->bindParam(':TXID', $this->TXID);
		$stmt->bindParam(':ConfirmDate', $ConfirmDate);
		$stmt->bindParam(':ConfirmedBy', $ConfirmedBy);
		$stmt->bindParam(':Status', $Status);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
}
?>