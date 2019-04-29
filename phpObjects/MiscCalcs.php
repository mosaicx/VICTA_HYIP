<?php
// include database and object files
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/Calculations.php';
 
 
 class MiscCalcs{

	public $seconds;
	public $minutes;
	public $hours ;
	public $days;
	public $weeks;
		
	function __construct(){
		
	}
	
	function calculateTimeDiff($timeStart, $timeEnd){
		$this->seconds = $timeEnd - $timeStart;
		$this->minutes = $this->seconds/60;
		$this->hours = $this->minutes/60;
		$this->days = $this->hours/24;
		$this->weeks = $this->days/7;
		$this->months = $this->weeks/4;
		$this->years = $this->months/12;
		
		// echo "<br/>".$seconds;
		// echo "<br/>".$minutes;
		// echo "<br/>".$hours;
		// echo "<br/>".$days;
		// echo "<br/>".$weeks;
		// echo "<br/>".$months;
		// echo "<br/>".$years;
	}

	function calculateDaysDiff($timeStart, $timeEnd){
		$timeStart = date("Y-m-d", strtotime($timeStart));
		$timeEnd = date("Y-m-d", strtotime($timeEnd));
		
		// echo " Time diff in days ". $timeDiff= floor((strtotime($timeEnd) - strtotime($timeStart))/(60*60*24));
		$timeDiff= floor((strtotime($timeEnd) - strtotime($timeStart))/(60*60*24));
		return $timeDiff;
	}

	function calculateMonthsDiff($timeStart, $timeEnd){
		$MiscCalcs = new MiscCalcs();
		$days = $MiscCalcs->calculateDaysDiff($timeStart, $timeEnd);
		$months = $days/30.5;
		
		// echo 'months '. floor($months);
		return floor($months);
	}
	
	function convertZarToBtcPrice($ZarVal, $ExchangeRate){
		return $ZarVal / $ExchangeRate;
	}
	
	function convertBtcToZarPrice($BtcVal, $ExchangeRate){
		return $BtcVal * $ExchangeRate;
	}
	
	function GetInterestRate($tier){
		if($tier == 1){
			return 0.05;
		}else{
			return 0.00;
		}
	}
	
	function getTimeDiffSecond(){
		return $this->seconds;
	}
	function getTimeDiffMinutes(){
		return $this->minutes;
	}
	function getTimeDiffHours(){
		return $this->hours;
	}
	function getTimeDiffDays(){
		return $this->days;
	}
}
// $MiscCalcs = new MiscCalcs();
// echo $MiscCalcs-> calculateTimeDiff('1523010020', '1523011820');
// echo $MiscCalcs-> getTimeDiffMinutes();
?>