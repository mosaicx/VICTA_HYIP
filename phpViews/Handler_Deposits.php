<?php
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/Deposit.php';
include_once '../phpViews/Handler_Users.php';
 
class DepositHandler{
	public $AUID;
	public $TXID;
	public $TxDate;
	public $AmountReceived;
	public $SenderAddress;
	public $Currency;
	public $ExchangeRate;
	public $Status;
	public $LoggedBy;
	public $ConfirmedBy;
	public $ConfirmDate;
 	public $recordsTable;
	public $deposit;
	
	//create deposit transaction record with pending approval status **works** 1659.00
	function CreateDeposit($AUID, $AmountReceived, $SenderAddress, $Currency, $ExchangeRate, $LoggedBy){
		$deposit = new Deposit();
		
		$this->AUID=$AUID;		  
		$this->TXID=bin2hex(openssl_random_pseudo_bytes(12));
		$this->TxDate = date('Y-m-d H:i:s');
		$this->AmountReceived=$AmountReceived;		  
		$this->SenderAddress=$SenderAddress;		  
		$this->Currency=$Currency;		  
		$this->ExchangeRate=$ExchangeRate;		  
		$this->Status='PENDING';		  
		$this->LoggedBy=$LoggedBy;		  
		$this->ConfirmedBy='TBC';		  
		$this->ConfirmDate='0000-00-00 00:00:00';		  
				  
		if($deposit->createDeposit($this->AUID, $this->TXID, $this->TxDate, $this->AmountReceived, $this->SenderAddress, 
			$this->Currency, $this->ExchangeRate, $this->Status, $this->LoggedBy, $this->ConfirmedBy, $this->ConfirmDate)){
			return $message= "deposit was created.";
		}else{
			return $message= "Unable to create deposit.";
		}
	}

	//Update deposit transaction status from pending to confirmed  **works**
	function UpdateDepositConfirmation($adminUser, $TXID){
		$message = '';
		$deposit = new Deposit();
		$ConfirmDate = date('Y-m-d H:i:s');
		$this->status = 'CONFIRMED';
		$this->TXID= $TXID;

		if($deposit->updateDepositStatus($this->TXID, $this->status, $adminUser)){
			$message = 'SUCCESS';
		}
		else{
			$message =  'UPDATE FAILED';
		}
		return $message;
	}	

	//Select deposit transaction by transaction ID **works**
	function SelectDepositByTxId($TXID){ 
		$deposit = new Deposit();

		$stmt = $deposit->SelectDepositByTxId($TXID);
		$num = $stmt->rowCount();

		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$deposit_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"AmountReceived" => $AmountReceived,
					"SenderAddress" => $SenderAddress,
					"Currency" => $Currency,
					"ExchangeRate" => $ExchangeRate,
					"message" => 'record found',
					"Status" => $Status
				);
			$message= $deposit_item['message'];	
			$this->recordsTable .=  "<tr><td> ".$deposit_item['TxDate']." </td><td> ".$deposit_item['AmountReceived']." </td><td> R ";
			$this->recordsTable .=  $deposit_item['AmountReceived']*$deposit_item['ExchangeRate']." </td><td> ".$deposit_item['Status'];
			$this->recordsTable .=  " </td><td> ".$deposit_item['TXID']." </td></tr>";
			}
		}else{
			$message= 'record not found';
		}
		return $message;
	}
	
	//Select deposit transaction by associative user id (AUID) **works**
	function SelectDepositByAuid($AUID){ 
		$deposit = new Deposit();

		$stmt = $deposit->SelectDepositByUser($AUID);
		$num = $stmt->rowCount();

		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);			
				$deposit_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"AmountReceived" => $AmountReceived,
					"SenderAddress" => $SenderAddress,
					"Currency" => $Currency,
					"ExchangeRate" => $ExchangeRate,
					"message" => 'record found',
					"Status" => $Status
				);
				$this->recordsTable .=  "<tr><td> ".$deposit_item['TxDate']." </td><td> ".$deposit_item['AmountReceived']." </td><td> R ";
				$this->recordsTable .=  $deposit_item['AmountReceived']*$deposit_item['ExchangeRate']." </td><td> ".$deposit_item['Status']." </td><td> ".$deposit_item['TXID']." </td></tr>";
			}
		}else{
			$this->recordsTable = "<tr><td> No record found </td><td> No record found</td><td> No record found </td><td> No record found </td><td> No record found </td></tr>";
		}
	}

	//Select all deposit transaction record with a pending approval status **works**
	function SelectGlobalPendingDeposits(){ 
		$deposit = new Deposit();
		$UserHandler = new UserHandler();

		$stmt = $deposit->SelectPendingDeposits();
		$num = $stmt->rowCount();

		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$deposit_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"AmountReceived" => $AmountReceived,
					"SenderAddress" => $SenderAddress,
					"Currency" => $Currency,
					"ExchangeRate" => $ExchangeRate,
					"message" => 'record found',
					"Status" => $Status
				);
			$stmt1 = $UserHandler->selectUserByAuid($deposit_item['AUID']);
			
			$this->recordsTable .= "<form enctype='multipart/form-data' name='depositForm' method='post'><tr><td> ".$deposit_item['TxDate']." </td><td> ".$deposit_item['Currency']." ";
			$this->recordsTable .= $deposit_item['AmountReceived']." </td><td> ".$deposit_item['Status']." </td><td> ";
			$this->recordsTable .= $deposit_item['TXID']." </td><td> ".$UserHandler->getEmail();
			$this->recordsTable .= "</td><td><input type='Submit' name='confirmSubmit' value='Confirm'/><input type='hidden' name='tx_id' value='".$deposit_item['TXID']."'/></td></tr></form>";
			}
		}else{
			$this->recordsTable = "<tr><td> No record found </td><td> No record found</td><td> No record found </td><td> No record found </td><td> No record found </td><td>No record found </td></tr>";
		}
	}

	//Select return records in table data format for HTML table parsing **works**
	function getRecordsTable(){
		return $this->recordsTable;
	}
}
?>