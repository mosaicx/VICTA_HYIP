<?php
include_once '../phpObjects/Wallet.php';
 
 class WalletHandler{

	public $database;
	public $WalletType;
	public $WalletAddress;
	public $WalletGUID;

	//create record of user wallets **works**
	function CreateWallet($AUID, $WalletType, $WalletAddress){ 
		$wallet = new Wallet();
		if($wallet->createWallet($AUID, $WalletType, $WalletAddress)){
			$message = "Wallet was created.";
			return $message;
		}else{
			$message = "Unable to create Wallet.";
		}
		return $message;
	}
	
	//update the address of the user wallet **works**
    function updateWalletAddress($AUID, $WalletAddress){	
		$wallet = new Wallet();
		$this->AUID = $AUID;
		$this->WalletAddress = $WalletAddress;
		$ModifyDate = date('Y-m-d H:i:s');

		if($wallet->updateWalletAddress($this->AUID, $this->WalletAddress, $ModifyDate)){
			$message = 'wallet address was updated.';
		}
		else{
			$message = "unable to update wallet.";
		}
		return $message;
    }
	//update the type of wallet the user uses **works**
    function updateWalletType($AUID, $WalletType){	
		$wallet = new Wallet();
		$this->AUID = $AUID;
		$this->WalletType = $WalletType;
		$ModifyDate = date('Y-m-d H:i:s');

		if($wallet->updateWalletType($this->AUID,$this->WalletType, $ModifyDate)){
			$message = 'wallet was updated.';
		}
		else{
			$message = "unable to update wallet.";
		}
		return $message;
    }
	/*
	public function SelectWalletByAddress($WalletAddress){
		$wallet = new Wallet();

		$stmt = $wallet->selectWalletByAddress($WalletAddress);
		$num = $stmt->rowCount();

		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);			
				$wallet_item=array(
					"AUID" => $AUID,
					"WalletType" => $WalletType,
					"WalletAddress" => $WalletAddress,
					"WalletGUID" => $WalletGUID,
					"Message" => "wallet found."
				);

				$this->AUID = $AUID;
				$this->WalletType = $WalletType;
				$this->WalletAddress = $WalletAddress;
				$this->WalletGUID = $WalletGUID;
				$Message = $wallet_item['Message'];
			}
		}else{
				array("Message" => "wallet not found.");
			$this->Message = $wallet_item['Message'];
		}
		return $Message;
	}
	*/
	
	//Select wallet by Associated User ID (AUID) **works**
	function SelectWalletByUser($AUID){	 
		$wallet = new Wallet();

		$stmt = $wallet->selectWalletByUser($AUID);
		$num = $stmt->rowCount();

		if($num>0){
			$wallet_arr=array();
			$wallet_arr["wallets"]=array();
		 
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				
				$wallet_item=array(
					"WalletType" => $WalletType,
					"WalletAddress" => $WalletAddress,
					"WalletGUID" => $WalletGUID,
					"Message" => "wallet found."
				);
				
				$this->WalletType =$wallet_item['WalletType'];
				$this->WalletAddress =$wallet_item['WalletAddress'];
				$this->WalletGUID =$wallet_item['WalletGUID'];				
				$Message = $wallet_item['Message'];
			}
		}else{
				$wallet_item=array(
					"Message" => "No wallet associated with this account yet. Please verify your account first."
				);
			$this->WalletType ='';
			$this->WalletAddress ='';
			$this->WalletGUID ='';				
			$Message = $wallet_item['Message'];
		}
		return $Message;
	}
	
// **works**	
	function getWalletType(){
		return $this->WalletType;
	}
	
// **works**	
	function getWalletAddress(){
		return $this->WalletAddress;		
	}
	
// **works**	
	function getWalletGUID(){
		return $this->WalletGUID;
	}
}
?>