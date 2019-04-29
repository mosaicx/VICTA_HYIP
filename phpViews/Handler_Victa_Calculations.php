<?php
 
// include database and object files
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/Withdrawal.php';
include_once '../phpObjects/Deposit.php';
include_once '../phpViews/Handler_Calulator.php';
include_once '../phpObjects/Victa.php';
 
 class VictaCalculationHandler{
	 
	public $totalGlobalVictaValue;
	function CalculateGlobalVictaPurchases(){
		$Victa = new Victa();
		$stmt = $Victa->SelectAllVictas();
		$num = $stmt->rowCount();

		$this->totalGlobalVictaValue=0;
		
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);			
				$victa_item=array(
					"VictaPrice" => $VictaPrice,
					"Quantity" => $Quantity,
					"message" => 'Record found'
				);
				
				$victaPurchaseValue = $victa_item['VictaPrice'] * $victa_item['Quantity']; 
				$this->totalGlobalVictaValue+= $victaPurchaseValue;
			}
			$message = 'Calculated.';
		}else{
			$victa_item=array("message" => 'record not found');
			$message = $victa_item['message'];
		}
	}
	function getGlobalVictaPurchases(){
		return $this->totalGlobalVictaValue;
	}
	
	public $totalUserVictaValue;
	function CalculateUserVictaPurchases($AUID){
		$Victa = new Victa();

		$stmt = $Victa->SelectVictasByAuid($AUID);
		$num = $stmt->rowCount();

		$this->totalUserVictaValue=0;
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
				
				$victaPurchaseValue = $victa_item['VictaPrice'] * $victa_item['Quantity']; 
				$this->totalUserVictaValue += $victaPurchaseValue;
			}
		}else{
			$deposit_item=array("message" => 'record not found');
		}
	}
	function getUserVictaPurchases(){
		return $this->totalUserVictaValue;
	}
	
	public $totalEarningsPerVicta;
	function calculateTotalEarnedPerVicta($TxDate, $TxAmount, $VictaCode){
		$CalculationHandler = new CalculationHandler();
		//Interest rate
		$interestRate = $CalculationHandler ->GetInterestRate(1);

		//months invested
		$MonthsInvested = $CalculationHandler->getMonthsDiff($TxDate, date('Y-m-d'));
		if($VictaCode == 'entra'){
			if($MonthsInvested > 35){
				$MonthsInvested = 35;
			}
		}elseif($VictaCode == 'intermida'){
			if($MonthsInvested > 40){
				$MonthsInvested = 40;
			}
		}elseif($VictaCode == 'major'){
			if($MonthsInvested > 50){
				$MonthsInvested = 50;
			}
		}elseif($VictaCode == 'perpetua'){
			if($MonthsInvested > 60){
				$MonthsInvested = 60;
			}			
		}else{
			$MonthsInvested = 0;
		}
		
		//Amount invested
		$this->totalEarningsPerVicta = $TxAmount * $interestRate * $MonthsInvested;
	}
	function getTotalEarnedPerVicta(){
		return $this->totalEarningsPerVicta;
	}
	
	public $totalPotentialEarnings;
	function calculatePotentialEarnings($tier, $monthsInvested, $TxAmount){

		$CalculationHandler = new CalculationHandler();
		//Interest rate
		$interestRate = $CalculationHandler ->GetInterestRate($tier);

		//Amount invested
		$investmentAmount = $TxAmount;
		//Earnings calculation
		$totalPotentialEarnings = $investmentAmount * $interestRate * $monthsInvested;
	}
	function getPotentialEarnings(){
		return $this->totalPotentialEarnings;
		
	}
	
	public $totalGlobalVictaEarnings;
	function calculateGlobalVictaEarnings(){
		// initialize object
		$VictaCalculationHandler = new VictaCalculationHandler();
		$Victa = new Victa();

		// query deposits
		$stmt = $Victa->SelectAllVictas();
		$num = $stmt->rowCount();

		$this->totalGlobalVictaEarnings = 0;
		
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
				
				$VictaPrice = $victa_item['VictaPrice']; 
				$Quantity = $victa_item['Quantity'];
				
				$victaPurchaseValue = $VictaPrice * $Quantity;

				$VictaCalculationHandler->calculateTotalEarnedPerVicta($victa_item['TxDate'], $victaPurchaseValue, $victa_item['VictaCode']);
				$totalEarnedPerVictaPurchase = $VictaCalculationHandler->getTotalEarnedPerVicta();
				$this->totalGlobalVictaEarnings += $totalEarnedPerVictaPurchase;						
			}
			return $message = 'calculated';
		}else{
			return $message = 'earnings failed to calculate';
		}
	}
	function getGlobalVictaEarnings(){
		return $this->totalGlobalVictaEarnings;
	}
	
	public $totalUserVictaEarnings;
	function calculateTotalUserVictaEarnings($AUID){
		// initialize object
		$VictaCalculationHandler = new VictaCalculationHandler();
		$Victa = new Victa();

		// query deposits
		$stmt = $Victa->SelectVictasByAuid($AUID);
		$num = $stmt->rowCount();

		$this->totalUserVictaEarnings = 0;
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

				$VictaPrice = $victa_item['VictaPrice']; 
				$Quantity = $victa_item['Quantity'];
				
				$victaPurchaseValue = $VictaPrice * $Quantity; 
				
				$VictaCalculationHandler->calculateTotalEarnedPerVicta($victa_item['TxDate'], $victaPurchaseValue, $victa_item['VictaCode']);
				$totalEarnedPerVictaPurchase = $VictaCalculationHandler->getTotalEarnedPerVicta();
				$this->totalUserVictaEarnings += $totalEarnedPerVictaPurchase;						
			}
			return $message = 'calculated';
		}else{
			return $message = 'earnings failed to calculate';
		}
	}
	function getTotalUserVictaEarnings(){
		return $this->totalUserVictaEarnings;
	}
	
	public $userCurrentEarningsAccount;
	function calculateUserCurrentEarningsAccount($AUID){
		$CalculationHandler = new CalculationHandler();
		$VictaCalculationHandler = new VictaCalculationHandler();

		$VictaCalculationHandler->calculateTotalUserVictaEarnings($AUID);
		$CalculationHandler->CalculateUserWithdrawals($AUID);

		$UserVictaEarnings = $VictaCalculationHandler->getTotalUserVictaEarnings();
		$UserWithdrawals =  $CalculationHandler->getTotalUserConfirmedWithdrawalRandValue();
		$UserWithdrawals += $CalculationHandler->getTotalUserPendingWithdrawalRandValue();
		
		$this->userCurrentEarningsAccount = $UserVictaEarnings-$UserWithdrawals;
		
	}
	function getUserCurrentEarningsAccount(){
		return $this->userCurrentEarningsAccount;
	}

	public $totalConfirmedCurrentAccount;
	function calculateUserCurrAccounts($AUID){
		$VictaCalculationHandler = new VictaCalculationHandler();
		$CalculationHandler = new CalculationHandler();
		//calculate pending and confirmed withdrawals
		$CalculationHandler->CalculateUserWithdrawals($AUID);	
		
		//fetch and assign pending withdrawals
		$pendingWithdrawalZarAmount = $CalculationHandler->getTotalUserPendingWithdrawalRandValue();

		//fetch and assign confirmed withdrawals
		$confirmedWithdrawalZarAmount = $CalculationHandler->getTotalUserConfirmedWithdrawalRandValue();
		
		//calculate pending and confirmed victa earnings
		$VictaCalculationHandler->calculateTotalUserVictaEarnings($AUID);
		
		//Fetch and assign pending account earnings
		$userVictaAmountEarned = $VictaCalculationHandler->getUserVictaAmountEarned();

		//Calculate total current balance (pending and confirmed amounts)
		$this->totalConfirmedCurrentAccount = $userVictaAmountEarned - ($confirmedWithdrawalZarAmount + $pendingWithdrawalZarAmount);
	}
	//Get total current account
	function getUserCurrAccounts(){
		return $this->totalConfirmedCurrentAccount;
	}	

	//Get Difference between two dates in months 
	function getMonthsDiff($timeStart, $timeEnd){
		$timeStart = date("Y-m-d", strtotime($timeStart));
		$timeEnd = date("Y-m-d", strtotime($timeEnd));
		
		$this->MonthsDiff = floor((strtotime($timeEnd) - strtotime($timeStart))/(60*60*24*30.5));
		return floor($this->MonthsDiff);
	}
		
	//Get interest rate
		function GetInterestRate($tier){
		if($tier == 1){
			return 0.05;
		}elseif($tier == 2){
			return 0.07;
		}elseif($tier == 3){
			return 0.09;
			
		}
	}	
}
?>