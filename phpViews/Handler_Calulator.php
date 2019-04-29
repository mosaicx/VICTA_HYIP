<?php
 
// include database and object files
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/Withdrawal.php';
include_once '../phpObjects/Deposit.php';
 
 
 class CalculationHandler{
	 
	public $totalPendingWithdrawalRandValue;
	public $totalPendingWithdrawalBtcValue;
	public $totalConfirmedWithdrawalRandValue;
	public $totalConfirmedWithdrawalBtcValue;

	public $totalPendingUserWithdrawalRandValue;
	public $totalPendingUserWithdrawalBtcValue;
	public $totalConfirmedUserWithdrawalRandValue;
	public $totalConfirmedUserWithdrawalBtcValue;

	public $totalPendingDepositRandValue;
	public $totalPendingDepositBtcValue;
	public $totalConfirmedDepositRandValue;
	public $totalConfirmedDepositBtcValue;

	public $totalUserPendingDepositRandValue;
	public $totalUserPendingDepositBtcValue;
	public $totalUserConfirmedDepositRandValue;
	public $totalUserConfirmedDepositBtcValue;

	public $totalPendingBtcAmountEarned;
	public $totalPendingZarAmountEarned;
	public $totalConfirmedBtcAmountEarned;
	public $totalConfirmedZarAmountEarned;
	
	public $globalBtcAmountEarned;
	public $globalZarAmountEarned;
	
	public $verifiedEmailCount;
	public $unVerifiedEmailCount;
	public $DaysDiff;
	public $MonthsDiff;
	
	public $totalConfirmedZarCurrentAccount;
	
	
	
	function CalculateGlobalDeposits(){
		$deposit = new Deposit();
		$stmt = $deposit->SelectAllDeposits();
		$num = $stmt->rowCount();

		$this->totalPendingDepositRandValue=0;
		$this->totalPendingDepositBtcValue=0;
		$this->totalConfirmedDepositRandValue=0;
		$this->totalConfirmedDepositBtcValue=0;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);			
				$deposit_item=array(
					"AmountReceived" => $AmountReceived,
					"ExchangeRate" => $ExchangeRate,
					"Status" => $Status
				);
				
				$itemRandValue = $deposit_item['AmountReceived'] * $deposit_item['ExchangeRate']; 
				$itemBtcValue = $deposit_item['AmountReceived']; 
				
				if($deposit_item['Status'] == 'PENDING'){
					$this->totalPendingDepositRandValue+= $itemRandValue;
					$this->totalPendingDepositBtcValue+= $itemBtcValue;
				}else{
					$this->totalConfirmedDepositRandValue+= $itemRandValue;
					$this->totalConfirmedDepositBtcValue+= $itemBtcValue;					
				}
			}
			$message = 'Calculated.';
		}else{
			$deposit_item=array("message" => 'record not found');
			$message = $deposit_item['message'];
		}
	}	
	function CalculateGlobalWithdrawals(){ 
		$Withdrawal = new Withdrawal();

		$stmt = $Withdrawal->selectAllWithdrawals();
		$num = $stmt->rowCount();

		$this->totalPendingWithdrawalRandValue=0;
		$this->totalPendingWithdrawalBtcValue=0;
		$this->totalConfirmedWithdrawalRandValue=0;
		$this->totalConfirmedWithdrawalBtcValue=0;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$withdraw_item=array(
					"AmountSent" => $AmountSent,
					"ExchangeRate" => $ExchangeRate,
					"Status" => $Status
				);
				
				$itemRandValue = $withdraw_item['AmountSent'] * $withdraw_item['ExchangeRate']; 
				$itemBtcValue = $withdraw_item['AmountSent']; 

				if($withdraw_item['Status']=='PENDING'){
					$this->totalPendingWithdrawalRandValue += $itemRandValue;
					$this->totalPendingWithdrawalBtcValue += $itemBtcValue;
				}else{
					$this->totalConfirmedWithdrawalRandValue += $itemRandValue;
					$this->totalConfirmedWithdrawalBtcValue += $itemBtcValue;					
				}
			}
			$message = 'Calculated.';
		}else{
			$withdraw_item=array("message" => 'Cannot calculate, no records found');
			$message = $withdraw_item['message'];
		}
	}
	
	function CalculateUserDeposits($AUID){
		$deposit = new Deposit();

		$stmt = $deposit->SelectDepositByUser($AUID);
		$num = $stmt->rowCount();

		$this->totalUserPendingDepositRandValue=0;
		$this->totalUserPendingDepositBtcValue=0;
		$this->totalUserConfirmedDepositRandValue=0;
		$this->totalUserConfirmedDepositBtcValue=0;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$deposit_item=array(
					"AmountReceived" => $AmountReceived,
					"ExchangeRate" => $ExchangeRate,
					"Status" => $Status
				);
				
				$itemBtcValue = $deposit_item['AmountReceived']; 
				$itemRandValue = $deposit_item['AmountReceived'] * $deposit_item['ExchangeRate']; 

				if($deposit_item['Status'] == 'PENDING'){
					$this->totalUserPendingDepositRandValue += $itemRandValue;
					$this->totalUserPendingDepositBtcValue += $itemBtcValue;
				}else{
					$this->totalUserConfirmedDepositRandValue += $itemRandValue;
					$this->totalUserConfirmedDepositBtcValue += $itemBtcValue;
				}
			}
		}else{
			$deposit_item=array("message" => 'record not found');

		}
	}

	
	function CalculateUserWithdrawals($AUID){
		$Withdrawal = new Withdrawal();

		$stmt = $Withdrawal->selectWithdrawalsByUser($AUID);
		$num = $stmt->rowCount();

		$this->totalPendingUserWithdrawalRandValue=0;
		$this->totalPendingUserWithdrawalBtcValue=0;
		$this->totalConfirmedUserWithdrawalRandValue=0;
		$this->totalConfirmedUserWithdrawalBtcValue=0;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$withdraw_item=array(
					"AmountSent" => $AmountSent,
					"ExchangeRate" => $ExchangeRate,
					"Status" => $Status
				);
				
				$itemBtcValue = $withdraw_item['AmountSent'] / $withdraw_item['ExchangeRate']; 
				$itemRandValue = $withdraw_item['AmountSent']; 

				if($withdraw_item['Status'] == 'PENDING'){
					$this->totalPendingUserWithdrawalRandValue += $itemRandValue;

				}else{
					$this->totalConfirmedUserWithdrawalRandValue += $itemRandValue;

				}
				$message = 'Calculated.';
			}
		}else{
			$withdraw_item=array("message" => 'record not found');
			$message = $withdraw_item['message'];
		}
	}

	//Count Users
	public function calculateUsers(){
		$user = new User();
		$userCount = 0;
		$user_item = array();
		$this->unVerifiedEmailCount = 0;
		$this->verifiedEmailCount = 0;
		
		$stmt = $user->selectAllUsers();
		$num = $stmt->rowCount();
	 
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
					$user_item=array(
					"Name" => $Name,
					"Surname" => $Surname,
					"Email" => $Email,
					"GUID" => $GUID,
					"VerifyEmail" => $VerifyEmail,
					"VerifyKyc" => $VerifyKyc,
					"Message" => "record found."
				);
				
				if($user_item['VerifyEmail'] == 'true'){
					$this->verifiedEmailCount++;
				}else{
					$this->unVerifiedEmailCount++;
				}
				$message = 'Calculated';

			}
		}else{
				$user_item =array(
					"Message" => "no users found."
			);
				$message = $user_item['Message'];
		}
			return $message;
	}

	function calculateTotalEarnedPerDeposit($TxDate, $TxAmount){

		$CalculationHandler = new CalculationHandler();
		//Interest rate
		$interestRate = $CalculationHandler ->GetInterestRate(1);

		//months invested
		$MonthsInvested = $CalculationHandler->getMonthsDiff($TxDate, date('Y-m-d'));
		
		//Amount invested
		$investmentAmount = $TxAmount;
		//Earnings calculation
		$totalEarned = $investmentAmount * $interestRate * $MonthsInvested;
		return $totalEarned;
	}

	function calculatePotentialEarnings($tier, $monthsInvested, $TxAmount){

		$CalculationHandler = new CalculationHandler();
		//Interest rate
		$interestRate = $CalculationHandler ->GetInterestRate($tier);

		//Amount invested
		$investmentAmount = $TxAmount;
		//Earnings calculation
		$totalEarned = $investmentAmount * $interestRate * $monthsInvested;
		return $totalEarned;
	}
	
	function calculateGlobalDepositEarnings(){
		// initialize object
		$deposit = new Deposit();

		// query deposits
		$stmt = $deposit->SelectAllDeposits();
		$num = $stmt->rowCount();

		$this->globalPendingBtcAmountEarned = 0;
		$this->globalPendingZarAmountEarned = 0;
		$this->globalConfirmedBtcAmountEarned = 0;
		$this->globalConfirmedZarAmountEarned = 0;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$deposit_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"Status" => $Status,
					"ExchangeRate" => $ExchangeRate,
					"AmountReceived" => $AmountReceived
				);
				
				$AmountReceived = $deposit_item['AmountReceived']; 
				$ExchangeRate = $deposit_item['ExchangeRate'];
				
				$itemRandValue = $AmountReceived * $ExchangeRate; 
				$itemBtcValue = $AmountReceived; 
				
				$CalculationHandler = new CalculationHandler();
				$totalZarEarnedPerDeposit = $CalculationHandler->calculateTotalEarnedPerDeposit($deposit_item['TxDate'], $itemRandValue);
				$totalBtcEarnedPerDeposit = $CalculationHandler->calculateTotalEarnedPerDeposit($deposit_item['TxDate'], $itemBtcValue);

				//pending earnings
				if($deposit_item['Status'] == 'PENDING'){
					$this->globalPendingBtcAmountEarned += $totalBtcEarnedPerDeposit;
					$this->globalPendingZarAmountEarned += $totalZarEarnedPerDeposit;	
				}else{
					//confirmed earnings
					$this->globalConfirmedBtcAmountEarned += $totalBtcEarnedPerDeposit;
					$this->globalConfirmedZarAmountEarned += $totalZarEarnedPerDeposit;						
				}
			}
			return $message = 'calculated';
		}else{
			$this->globalPendingBtcAmountEarned = 0;
			$this->globalPendingZarAmountEarned = 0;
			$this->globalConfirmedBtcAmountEarned = 0;
			$this->globalConfirmedZarAmountEarned = 0;
			return $message = 'earnings failed to calculate';
		}
	}
	function calculateTotalUserDepositEarnings($AUID){
		// initialize object
		$deposit = new Deposit();

		// query deposits
		$stmt = $deposit->SelectDepositByUser($AUID);
		$num = $stmt->rowCount();

		$this->totalPendingBtcAmountEarned = 0;
		$this->totalPendingZarAmountEarned = 0;
		$this->totalConfirmedBtcAmountEarned = 0;
		$this->totalConfirmedZarAmountEarned = 0;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$deposit_item=array(
					"AUID" => $AUID,
					"TXID" => $TXID,
					"TxDate" => $TxDate,
					"Status" => $Status,
					"ExchangeRate" => $ExchangeRate,
					"AmountReceived" => $AmountReceived
				);
				
				$AmountReceived = $deposit_item['AmountReceived']; 
				$ExchangeRate = $deposit_item['ExchangeRate'];
				
				$itemRandValue = $AmountReceived * $ExchangeRate; 
				$itemBtcValue = $AmountReceived;
				
				$CalculationHandler = new CalculationHandler();
				$totalZarEarnedPerDeposit = $CalculationHandler->calculateTotalEarnedPerDeposit($deposit_item['TxDate'], $itemRandValue);
				$totalBtcEarnedPerDeposit = $CalculationHandler->calculateTotalEarnedPerDeposit($deposit_item['TxDate'], $itemBtcValue);
				//pending earnings
				if($deposit_item['Status'] == 'PENDING'){
					$this->totalPendingBtcAmountEarned += $totalBtcEarnedPerDeposit;
					$this->totalPendingZarAmountEarned += $totalZarEarnedPerDeposit;	
				}else{
					//confirmed earnings
					$this->totalConfirmedBtcAmountEarned += $totalBtcEarnedPerDeposit;
					$this->totalConfirmedZarAmountEarned += $totalZarEarnedPerDeposit;						
				}
			}
			return $message = 'calculated';
		}else{
			$this->totalPendingBtcAmountEarned = 0;
			$this->totalPendingZarAmountEarned = 0;
			$this->totalConfirmedBtcAmountEarned = 0;
			$this->totalConfirmedZarAmountEarned = 0;
			return $message = 'earnings failed to calculate';
		}
	}

	
	public $totalUserCredit;
	function calculateUserCredit($AUID){

		$CalculationHandler = new CalculationHandler();
		$VictaCalculationHandler = new VictaCalculationHandler($AUID);
		
		//calculate confirmed deposits
		$CalculationHandler->CalculateUserDeposits($AUID);
		$totalUserConfirmedDeposit=$CalculationHandler->getTotalUserConfirmedDepositRandValue();
		
		//calculate victa pruchases
		$VictaCalculationHandler->CalculateUserVictaPurchases($AUID);
		$UserVictaPurchases=$VictaCalculationHandler->getUserVictaPurchases();
		
		$this->totalUserCredit = $totalUserConfirmedDeposit - $UserVictaPurchases;
		
	}
	function getUserCredit(){
		return $this->totalUserCredit;
	}

	//Get confirmed current account
	function getTotalConfirmedZarCurrentAccount(){
		return $this->totalConfirmedZarCurrentAccount;
	}	

	//Get user pending earnings
	function getUserPendingZarAmountEarned(){
		return $this->totalPendingZarAmountEarned;
	}	

	//Get user confirmed earnings
	function getUserConfirmedZarAmountEarned(){
		return $this->totalConfirmedZarAmountEarned;
	}	
	
	//Get global pending earnings
	function getGlobalPendingZarAmountEarned(){
		return $this->globalPendingZarAmountEarned;
	}

	//Get global confirmed earnings
	function getGlobalConfirmedZarAmountEarned(){
		return $this->globalConfirmedZarAmountEarned;
	}
	
	//Get Difference between two dates in months 
	function getMonthsDiff($timeStart, $timeEnd){
		$timeStart = date("Y-m-d", strtotime($timeStart));
		$timeEnd = date("Y-m-d", strtotime($timeEnd));
		
		$this->MonthsDiff = floor((strtotime($timeEnd) - strtotime($timeStart))/(60*60*24*30.5));
		return floor($this->MonthsDiff);
	}
	
	//Get Difference between two dates in days 
	function getDaysDiff($timeStart, $timeEnd){
		$timeStart = date("Y-m-d", strtotime($timeStart));
		$timeEnd = date("Y-m-d", strtotime($timeEnd));		
		$this->DaysDiff= floor((strtotime($timeEnd) - strtotime($timeStart))/(60*60*24));
		return $this->DaysDiff;
	}
	
	//Get interest rate
	//tiered for the different victa options
		function GetInterestRate($tier){
		if($tier == 1){
			return 0.05;
		}elseif($tier == 2){
			return 0.07;
		}elseif($tier == 3){
			return 0.09;
			
		}
	}
	
	//Count Verified/unverified users ZAR
	function getVerifiedEmailCount(){
		return $this->verifiedEmailCount;
	}
	function getUnverifiedEmailCount(){
		return $this->unVerifiedEmailCount;
	}

	//Global Deposits ZAR
	function getTotalPendingDepositRandValue(){
		return $this->totalPendingDepositRandValue;
	}
	function getTotalConfirmedDepositRandValue(){
		return $this->totalConfirmedDepositRandValue;
	}


	//User Deposits ZAR
	function getTotalUserPendingDepositRandValue(){
		return $this->totalUserPendingDepositRandValue;
	}
	function getTotalUserConfirmedDepositRandValue(){
		return $this->totalUserConfirmedDepositRandValue;
	}
	
	//Global Withdrawals ZAR
	function getTotalPendingWithdrawalRandValue(){
		return $this->totalPendingWithdrawalRandValue;
	}
	function getTotalPendingWithdrawalBtcValue(){
		return $this->totalPendingWithdrawalBtcValue;
	}
	function getTotalConfirmedWithdrawalRandValue(){
		return $this->totalConfirmedWithdrawalRandValue;
	}
	function getTotalConfirmedWithdrawalBtcValue(){
		return $this->totalConfirmedWithdrawalBtcValue;
	}
	//User Withdrawals ZAR
	function getTotalUserPendingWithdrawalRandValue(){
		return $this->totalPendingUserWithdrawalRandValue;
	}
	function getTotalUserConfirmedWithdrawalRandValue(){
		return $this->totalConfirmedUserWithdrawalRandValue;
	}
}
?>