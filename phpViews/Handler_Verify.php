<?php
include_once '../phpDatabase/Database.php';
include_once '../phpObjects/Verify.php';
// include_once '../phpViews/SelectUser.php';
 
class VerifyHandler{
    public $UID;
    public $RecordCount;
    public $DateModified;
    public $VerificationCode;
	
	//update verification code *works*
	function updateEmailVerify($UID){
		$Verify = new Verify();
		if($Verify->updateEmailVerify($UID)){
			return 'update successful';
		}
		else{
			return 'update unsuccessful';
		}
	}
	
	//create VerificationCode record
	function createEmailVerify($UID){
		$Verify = new Verify();
		
		if($Verify->createEmailVerify($UID)){
			return $message= "Verification code was created.";
		}else{
		 // if unable to create the product, tell the user
			return $message= "Unable to create Verification code.";
		}
	}
	
	//select verification for email by ID **works**
	function SelectEmailVerifyById($UID){ 
		$Verify = new Verify();

		$stmt = $Verify->selectEmailVerificationByUID($UID);
		$num = $stmt->rowCount();
		$this->RecordCount =$num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$verify_item=array(
					"UID" => $UID,
					"VerificationCode" => $VerificationCode,
					"VerifyType" => $VerifyType,
					"DateModified" => $DateModified,
				);
				$message= 'record found';
				
			$this->UID =$UID;
			$this->VerificationCode =$VerificationCode;
			$this->VerifyType =$VerifyType;
			$this->DateModified =$DateModified;
			}
		}else{
			$message= 'record not found';
		}
		return $message;
	}

	//updating users email verification status by based on GUID/AUID **works**
	function updatePassVerify($GUID){
		$Verify = new Verify();
		$this->GUID = $GUID;
		if($Verify->updatePassVerify($this->GUID)){
			return "Email Verification status updated";
		}else{
			return "unable to update email verification status.";
		}
	}

		//select verification for email by ID **works**
	function SelectPassVerifyById($UID){ 
		$Verify = new Verify();

		$stmt = $Verify->selectPassVerificationByUID($UID);
		$num = $stmt->rowCount();
		$this->RecordCount =$num;
		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$verify_item=array(
					"UID" => $UID,
					"VerificationCode" => $VerificationCode,
					"VerifyType" => $VerifyType,
					"DateModified" => $DateModified,
				);
				$message= 'record found';
				
			$this->UID =$UID;
			$this->VerificationCode =$VerificationCode;
			$this->VerifyType =$VerifyType;
			$this->DateModified =$DateModified;
			}
		}else{
			$message= 'record not found';
		}
		return $message;
	}

	//create VerificationCode record
	function createPassVerify($UID){
		$Verify = new Verify();
		
		if($Verify->createPassVerify($UID)){
			return $message= "Verification code was created.";
		}else{
		 // if unable to create the product, tell the user
			return $message= "Unable to create Verification code.";
		}
	}
	
	//updating users KYC verification status by based on GUID/AUID **works**
	function updateKycVerifyStatus($GUID){
		$user = new User();		
		$this->GUID = $GUID;
		if($user->updateKycVerifyStatus($this->GUID)){
			return "KYC Verification status updated";
		}else{
			return "unable to update KYC verification status.";
		}
	}	

	//fetch email verification records by UID
	function getUID(){
		return $this->UID =$UID;
	}
	function getVerificationCode(){
		return $this->VerificationCode;
	}
	function getVerifyType(){
		return $this->VerifyType;
	}
	function getDateModified(){
		return $this->DateModified;
	}
	function getRecordCount(){
		return $this->RecordCount;
	}
}
?>