<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../Views/SelectWalletByUser.php';
include_once '../Views/CreateWallet.php';
class Blockchain{
    
	// object properties
    public $AUID;
    public $GUID;
    public $Password;
    public $ApiKey;
	public $walletType;
	public $ExchangeRate;
	
	
	function __construct($AUID, $GUID, $Password, $ApiKey){
		$this->AUID = $AUID;
		$this->GUID = $GUID;
		$this->Password = $Password;
		$this->ApiKey = $ApiKey;
		$this->walletType = 'BTC';			
	}
	
	function CheckConnection(){
		$url = "http://localhost:3000/merchant/".$this->GUID."/login?password=".$this->Password."&api_code=".$this->ApiKey;	
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);

		$ccc = curl_exec($ch);
		$json = json_decode($ccc, true);

		if ($json['success'] == 1){
			echo "Wallet Access Success";
			return true;
		}else{
			echo "Wallet Access Failure";
			return false;
		}
	}
	
	function CreateBlockchainAddress($AUID){
		//if no wallet with the associated user ($AUD) exists then create new address
		if(($selectWallet = new SelectWalletByUser($AUID))=='1'){
			echo "User already has an associated blockchain wallet";
			return false;
		}else{
			$url = "http://localhost:3000/merchant/".$this->GUID."/new_address?password=".$this->Password."&label=".$AUID; 
			//create new wallet	
			if($json_data = file_get_contents($url)){
				$json_feed = json_decode($json_data);
				echo "New Blockchain Wallet Created";
				echo "Address ".$walletAddress = $json_feed->address;
				echo "User ID ".$Label = $json_feed->label;			
				
				//add new wallet info to db
				$this->walletType = 'BTC';
				
				$this->AUID=htmlspecialchars(strip_tags($this->AUID));
				$this->walletType=htmlspecialchars(strip_tags($this->walletType));
				$walletAddress=htmlspecialchars(strip_tags($walletAddress));
				$this->AUID=htmlspecialchars(strip_tags($this->AUID));
				
				$createWallet = new CreateWallet($Label, '', $this->walletType, $walletAddress, date('Y-m-d H:i:s'));
				return true;
			}	
		}
	}
	
	function CheckAddressBalance($walletAddress){
		$url = "http://localhost:3000/merchant/".$this->GUID."/address_balance?password=".$this->Password."&address=".$walletAddress; 
		//read wallet balance
		$json_data = file_get_contents($url);
		$json_feed = json_decode($json_data);
		echo "Wallet Balance: <br/>";
		echo "Address ".$walletAddress = $json_feed->address;
		echo "Balance ".$balance = $json_feed->balance;
		return $balance;
	}
	
	function CalculateTxCharge($amount){
		$rate = 0.01;
		return $amount * $rate;
	}
	
	//untested, requires bitcoin balance to test effectively
	function MakeBlockchainPayment($recepientAddress, $amount, $senderAddress, $txChargeAddress){
		$url = "http://localhost:3000/merchant/".$this->GUID."/payment?password=".$this->Password."&to=".
			$recepientAddress."&amount=".$amount."&from=".$senderAddress;
		
		if($json_data = file_get_contents($url)){
			echo 'tx successful';
			$json_feed = json_decode($json_data);
			$message = $json_feed->message;
			$txid = $json_feed->tx_hash;	
			$this->ExchangeRate = "";
			$createWithdrawal = new CreateWithdrawal($this->AUID, $txid, $recepientAddress, $amount, $ExchangeRate, $message );
		}else{
			echo 'tx failed';
		}
	}
}

$blockchain = new Blockchain('guid1', 'd3997bc2-e21b-4e06-96be-a2853762467e', 'Beitplex1!', '');
$blockchain->MakeBlockchainPayment('13iGaeAtzJTvuSB5pzESfYiG72P5fgJRLj',  '0.0001', '1JqALnyEk2GW8iHBsYPtZCDLjV8vgUhcq5', '');
 // $blockchain->CheckAddressBalance("16GxMTF2kCNsSjiaQxSY7g4y5EEecw1cNJ");

?>