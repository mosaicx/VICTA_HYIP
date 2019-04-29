<?php
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/Withdrawal.php';
include_once '../phpViews/Handler_Users.php';
 
class WithdrawalHandler{
	public $database;
	public $db;
	public $AUID;
	public $TXID;
	public $TxDate;
	public $Currency;	
	public $AmountSent;
	public $ExchangeRate;
	public $recordsTable;
	public $ReceiverAddress;
	public $pendingWithdrawalsAmount;
	
	//Create withdrawal record with "Pending" confirmation status, a transaction date, and transaction ID
	function createWithdrawal($AUID, $ReceiverAddress, $AmountSent){
		$this->AUID = $AUID;
		$this->ReceiverAddress = $ReceiverAddress;
		$this->TxDate = date('Y-m-d H:i:s');
		$this->AmountSent = $AmountSent;
		$this->Currency = 'ZAR';
		$this->ExchangeRate = 1;
		
		$withdrawal = new Withdrawal();
		if($withdrawal->createWithdrawal($this->AUID, $this->ReceiverAddress, 
			$this->TxDate, $this->AmountSent, $this->Currency, $this->ExchangeRate)){
			$message = "SUCCESS";
		}else{
			$message = "Withdrawal was not created.";
		}
		return $message;
	}

	//Select withdrawal records by AUID	
	function SelectWithdrawalsByUser($AUID){
		$withdrawal = new Withdrawal(); 
		$stmt = $withdrawal->selectWithdrawalsByUser($AUID);
		$num = $stmt->rowCount();
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
		 
				$user_item=array(
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"AmountSent" => $AmountSent,
					"ReceiverAddress" => $ReceiverAddress,
					"Currency" => $Currency,
					"ExchangeRate" => $ExchangeRate,
					"Status" => $Status,
					"Message" => "record found."
				);
				$this->recordsTable .=  "<tr><td> ".$user_item['TxDate']." </td><td> ".$user_item['AmountSent']." ".$user_item['Currency']."</td><td> ".$user_item['Status']." </td><td> ".$user_item['TXID']." </td></tr>";
				$message = $user_item['Message'];
			}
		}else{
			$this->recordsTable = "<tr><td> No record found </td><td> No record found</td><td> No record found </td><td> No record found </td></tr>";
			$message = 'No record found';
		}
		return $message;
	}

	
	//Select pending withdrawal records by AUID	
	function SelectPendingUserWithdrawals($AUID){
		$this->AUID = $AUID;
		// query deposits
		$withdrawal = new Withdrawal();
		$stmt = $withdrawal->SelectPendingUserWithdrawals($this->AUID);
		$num = $stmt->rowCount();

		if($num>0){
			// deposit array
			$this->pendingWithdrawalsAmount = 0;
			$this->recordsTable = '';
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);			
				$withdrawal_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"Status" => $Status,
					"Currency" => $Currency,
					"message" => 'record found',
					"AmountSent" => $AmountSent,
					"ExchangeRate" => $ExchangeRate,
					"ReceiverAddress" => $ReceiverAddress
				);
				$this->pendingWithdrawalsAmount += $withdrawal_item['AmountSent'];
				
				$UserHandler = new UserHandler();
				$stmt1 = $UserHandler->selectUserByAuid($withdrawal_item['AUID']);
				
				$this->recordsTable .= "<tr><td> ".$withdrawal_item['TxDate']." </td><td> ".$withdrawal_item['Currency']." ";
				$this->recordsTable .= $withdrawal_item['AmountSent']." </td><td> ".$withdrawal_item['Status']." </td><td> ";
				$this->recordsTable .= $withdrawal_item['TXID']." </td><td> ".$UserHandler->getEmail();
				$this->recordsTable .= "</td><td><input type='Submit' name='confirmSubmit' value='Confirm'><input type='hidden' name='tx_id' value='".$withdrawal_item['TXID']."'></td></tr>";
				$message = $withdrawal_item['message'];
			}
		}else{
			$this->recordsTable = "<tr><td> No record found </td><td> No record found</td><td> No record found </td><td> No record found </td><td> No record found </td><td>No record found </td></tr>";
			$message = 'No record found';
		}
		return $message;
	}
	
	//Select all pending withdrawal transaction orders
  	function SelectGlobalPendingWithdrawals(){ 
		$UserHandler = new UserHandler();
		$withdrawal = new Withdrawal();
		$stmt = $withdrawal->SelectPendingWithdrawals();
		$num = $stmt->rowCount();

		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$withdrawal_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"Status" => $Status,
					"TxDate" => $TxDate,
					"Currency" => $Currency,
					"message" => 'record found',
					"AmountSent" => $AmountSent,
					"ExchangeRate" => $ExchangeRate,
					"ReceiverAddress" => $ReceiverAddress
				);
			$stmt1 = $UserHandler->selectUserByAuid($withdrawal_item['AUID']);
			
			$this->recordsTable .= "<form enctype='multipart/form-data' name='depositForm' method='post'><tr><td> ".$withdrawal_item['TxDate']." </td><td> ".$withdrawal_item['Currency']." ";
			$this->recordsTable .= $withdrawal_item['AmountSent']." </td><td> ".$withdrawal_item['Status']." </td><td> ";
			$this->recordsTable .= $withdrawal_item['TXID']." </td><td> ".$UserHandler->getEmail();
			$this->recordsTable .= "</td><td><input type='Submit' name='confirmSubmit' value='Confirm'><input type='hidden' name='tx_id' value='".$withdrawal_item['TXID']."'></td></tr></form>";

			$message = $withdrawal_item['message'];
			}
		}else{
			$this->recordsTable = "<tr><td> No record found </td><td> No record found</td><td> No record found </td><td> No record found </td><td> No record found </td><td>No record found </td></tr>";
			$message = 'No record found';
		}
			return $message;
	}
	
	//Update withdrawal status from PENDING to CONFIRMED
	function updateWithdrawalStatus($TXID, $adminUID){	
		$this->TXID = $TXID;
		$withdrawal = new Withdrawal();
		if($withdrawal->updateWithdrawalStatus($this->TXID, $adminUID)){
			return 'SUCCESSFUL UPDATE';
		}
		else{
			return 'UPDATE UNSUCCESSFUL';
		}
	}
		
	function getRecordsTable(){
		return $this->recordsTable;
	}

	function getPendingUserWithdrawalAmount(){
		return $this->pendingWithdrawalsAmount;
	}	
}
?>