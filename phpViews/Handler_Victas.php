<?php
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/Victa.php';
include_once '../phpObjects/Withdrawal.php';
include_once '../phpViews/Handler_Users.php';
 
class VictaHandler{
	public $database;
	public $db;
	public $AUID;
	public $TXID;
	public $TxDate;
	public $Currency;	
	public $AmountSent;
	public $recordCount;
	public $ExchangeRate;
	public $recordsTable;
	public $ReceiverAddress;
	public $pendingWithdrawalsAmount;
	
	function createVictaTx($AUID, $VictaCode, $VictaPrice, $Quantity){
		$this->AUID = $AUID;
		$this->VictaCode = $VictaCode;
		$this->VictaPrice = $VictaPrice;
		$this->Quantity = $Quantity;

		$Victa = new Victa();
		if($Victa->createVicta($this->AUID, $this->VictaCode, $this->VictaPrice, $this->Quantity)){
			$message = "SUCCESS";
		}else{
			$message = "FAILED";
		}
		return $message;
	}
	
	function SelectVictasByAuid($AUID){
		$Victa = new Victa(); 
		$stmt = $Victa->SelectVictasByAuid($AUID);
		$num = $stmt->rowCount();
		$this->recordCount = $num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
		 
				$victa_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"VictaCode" => $VictaCode,
					"VictaPrice" => $VictaPrice,
					"Quantity" => $Quantity,
					"message" => 'Record found'
				);
				
				$TxDate=$victa_item['TxDate'];
				$TXID=$victa_item['TXID'];
				$VictaCode=$victa_item['VictaCode'];
				$VictaPrice=$victa_item['VictaPrice'];
				$Quantity=$victa_item['Quantity'];
								
				$this->recordsTable .=  "<tr><td> ".$TxDate." </td><td> ".$TXID."</td><td>".$VictaCode."</td><td> R".$VictaPrice/$Quantity." </td><td> ".$Quantity." </td><td> R".$VictaPrice." </td></tr>";
				$message = $victa_item['message'];
			}
		}else{
			$this->recordsTable = "<tr><td> No record found </td><td> No record found</td><td> No record found </td><td> No record found </td><td> No record found </td><td> No record found </td></tr>";
			$message = 'No record found';
		}
		return $message;
	}
	
	function getRecordsTable(){
		return $this->recordsTable;
	}
	function getRecordCount(){
		return $this->recordCount;
	}
	
}
?>