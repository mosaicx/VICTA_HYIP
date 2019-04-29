<?php

include_once '../phpDatabase/Database.php';

class Kyc_Aml{
 
    // database connection and table name
    private $conn;
    private $table_name = "kyc_aml";
 
    // object properties
    public $AUID; 
    public $NAME; 
    public $SURNAME;
    public $ID_PASSPORT;
    public $ID_FRONT;
    public $ID_BACK;
    public $BANK_NAME;
    public $BANK_BRANCH;
    public $ACCOUNT_NO;
    public $ACCOUNT_HOLDER;
    public $BANK_CARD_IMG;
    public $COMMENT;
    public $KYC_STATUS;
    public $recordCount;
 
    function __construct(){
		$database = new Database();
		$db = $database->getConnection();

        $this->conn = $db;

	}
		
	// create initial kyc_aml record *done
	function createInitialKYC($AUID, $NAME, $SURNAME, $ID_PASSPORT){
		$this->KYC_STATUS='PENDING';
		// query to insert record
		$query = "INSERT INTO kyc_aml SET AUID=:AUID, NAME=:NAME, SURNAME=:SURNAME, ID_PASSPORT=:ID_PASSPORT, KYC_STATUS=:KYC_STATUS";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		$this->NAME=htmlspecialchars(strip_tags($NAME));
		$this->SURNAME=htmlspecialchars(strip_tags($SURNAME));
		$this->ID_PASSPORT=htmlspecialchars(strip_tags($ID_PASSPORT));
		$this->KYC_STATUS=htmlspecialchars(strip_tags($this->KYC_STATUS));
	 
		// bind values
		$stmt->bindParam(":AUID", $this->AUID);
		$stmt->bindParam(":NAME", $this->NAME);
		$stmt->bindParam(":SURNAME", $this->SURNAME);
		$stmt->bindParam(":ID_PASSPORT", $this->ID_PASSPORT);
		$stmt->bindParam(":KYC_STATUS", $this->KYC_STATUS);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	//Updates the ID field of the kyc record matching the provided AUID *done
	function updateInitialKyc($AUID, $NAME, $SURNAME, $ID_PASSPORT){
	 	// update query
		$this->KYC_STATUS='PENDING';		
		$query = "UPDATE kyc_aml SET NAME = :NAME, SURNAME = :SURNAME, ID_PASSPORT = :ID_PASSPORT, KYC_STATUS = :KYC_STATUS WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		$this->NAME=htmlspecialchars(strip_tags($NAME));
		$this->SURNAME=htmlspecialchars(strip_tags($SURNAME));
		$this->KYC_STATUS=htmlspecialchars(strip_tags($this->KYC_STATUS));
		$this->ID_PASSPORT=htmlspecialchars(strip_tags($ID_PASSPORT));

	 
		// bind new values
		$stmt->bindParam(':AUID', $this->AUID);
		$stmt->bindParam(':NAME', $this->NAME);
		$stmt->bindParam(':SURNAME', $this->SURNAME);
		$stmt->bindParam(":KYC_STATUS", $this->KYC_STATUS);
		$stmt->bindParam(':ID_PASSPORT', $this->ID_PASSPORT);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	//Updates the ID field of the kyc record matching the provided AUID *done
	function updateKycId($AUID, $ID_PASSPORT){
	 	// update query
		$query = "UPDATE kyc_aml SET ID_PASSPORT = :ID_PASSPORT WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->ID_PASSPORT=htmlspecialchars(strip_tags($ID_PASSPORT));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':ID_PASSPORT', $this->ID_PASSPORT);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	//Updates the ID- front image string field of the kyc record matching the provided AUID *done
	function updateKycIdFront($AUID, $ID_FRONT){
	 	// update query
		$query = "UPDATE kyc_aml SET ID_FRONT = :ID_FRONT WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->ID_FRONT=htmlspecialchars(strip_tags($ID_FRONT));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':ID_FRONT', $ID_FRONT);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	//pending
	function updateKycIdBack($AUID, $ID_BACK){
	 	// update query
		$query = "UPDATE kyc_aml SET ID_BACK = :ID_BACK WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->ID_BACK=htmlspecialchars(strip_tags($ID_BACK));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':ID_BACK', $this->ID_BACK);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	//pending
	function updateKycBankName($AUID, $BANK_NAME){
	 	// update query
		$query = "UPDATE kyc_aml SET BANK_NAME = :BANK_NAME WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->BANK_NAME=htmlspecialchars(strip_tags($BANK_NAME));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':BANK_NAME', $this->BANK_NAME);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	//pending
	function updateKycBankBranch($AUID, $BANK_BRANCH){
	 	// update query
		$query = "UPDATE kyc_aml SET BANK_BRANCH = :BANK_BRANCH WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->BANK_BRANCH=htmlspecialchars(strip_tags($BANK_BRANCH));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':BANK_BRANCH', $this->BANK_BRANCH);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	//pending
	function updateKycAccNo($AUID, $ACCOUNT_NO){
	 	// update query
		$query = "UPDATE kyc_aml SET ACCOUNT_NO = :ACCOUNT_NO WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->ACCOUNT_NO=htmlspecialchars(strip_tags($ACCOUNT_NO));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':ACCOUNT_NO', $this->ACCOUNT_NO);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	//pending
	function updateKycAccHolder($AUID, $ACCOUNT_HOLDER){
	 	// update query
		$query = "UPDATE kyc_aml SET ACCOUNT_HOLDER = :ACCOUNT_HOLDER WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->ACCOUNT_HOLDER=htmlspecialchars(strip_tags($ACCOUNT_HOLDER));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':ACCOUNT_HOLDER', $this->ACCOUNT_HOLDER);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	//pending
	function updateKycAcceptStatus($AUID, $COMMENT){
	 	// update query
		$query = "UPDATE kyc_aml SET KYC_STATUS = :KYC_STATUS, COMMENT = :COMMENT WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		$COMMENT=htmlspecialchars(strip_tags($COMMENT));
		$this->KYC_STATUS=htmlspecialchars(strip_tags('CONFIRMED'));
	 
		// bind new values
		$stmt->bindParam(':KYC_STATUS', $this->KYC_STATUS);
		$stmt->bindParam(':AUID', $this->AUID);;
		$stmt->bindParam(':COMMENT', $COMMENT);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	//pending
	function updateKycRejectStatus($AUID, $COMMENT){
	 	// update query
		$query = "UPDATE kyc_aml SET KYC_STATUS = :KYC_STATUS, COMMENT = :COMMENT WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->AUID=htmlspecialchars(strip_tags($AUID));
		$COMMENT=htmlspecialchars(strip_tags($COMMENT));
		$this->KYC_STATUS=htmlspecialchars(strip_tags('REJECTED'));
	 
		// bind new values
		$stmt->bindParam(':KYC_STATUS', $this->KYC_STATUS);
		$stmt->bindParam(':AUID', $this->AUID);;
		$stmt->bindParam(':COMMENT', $COMMENT);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	//pending
	function updateKycBankImg($AUID, $BANK_CARD_IMG){
	 	// update query
		$query = "UPDATE kyc_aml SET BANK_CARD_IMG = :BANK_CARD_IMG WHERE AUID = :AUID";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->BANK_CARD_IMG=htmlspecialchars(strip_tags($BANK_CARD_IMG));
		$this->AUID=htmlspecialchars(strip_tags($AUID));
	 
		// bind new values
		$stmt->bindParam(':BANK_CARD_IMG', $this->BANK_CARD_IMG);
		$stmt->bindParam(':AUID', $this->AUID);;

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
		//Select kyc_aml detail by Tx ID
	function selectPendingKyc(){
	
		$query = "SELECT AUID, NAME, SURNAME, ID_PASSPORT, ID_FRONT, ID_BACK, COMMENT, BANK_NAME, BANK_BRANCH, 
			ACCOUNT_NO, ACCOUNT_HOLDER, BANK_CARD_IMG, KYC_STATUS FROM kyc_aml 
			where KYC_STATUS = 'PENDING'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
	

	//Select kyc_aml detail by Tx ID
	function selectKycDetailsByUser($AUID){
	
	$this->AUID = $AUID;
		$query = "SELECT NAME, SURNAME, ID_PASSPORT, ID_FRONT, ID_BACK, BANK_NAME, BANK_BRANCH, 
			ACCOUNT_NO, ACCOUNT_HOLDER, BANK_CARD_IMG, KYC_STATUS, COMMENT FROM kyc_aml where AUID = '".$this->AUID."'";
			
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		return $stmt;
	}
	
	//Select Deposit by User ID
	function selectPendingKycDetails(){
		$Kyc_Aml = new Kyc_Aml();
		$stmt = $Kyc_Aml->selectPendingKyc();
		
		$num = $stmt->rowCount();
		$this->recordCount = $num ;

		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$kyc_aml_item=array(
					"AUID" => $AUID,
					"NAME" => $NAME,
					"SURNAME" => $SURNAME,
					"ID_BACK" => $ID_BACK,
					"ID_FRONT" => $ID_FRONT,
					"BANK_NAME" => $BANK_NAME,
					"ACCOUNT_NO" => $ACCOUNT_NO,
					"KYC_STATUS" => $KYC_STATUS,
					"ID_PASSPORT" => $ID_PASSPORT,
					"BANK_BRANCH" => $BANK_BRANCH,
					"COMMENT" => $COMMENT,
					"ACCOUNT_HOLDER" => $ACCOUNT_HOLDER,
					"message" => 'record not found',
					"BANK_CARD_IMG" => $BANK_CARD_IMG
				);
				    $this->AUID=$AUID; 
				    $this->NAME=$NAME; 
					$this->ID_BACK=$ID_BACK;
					$this->SURNAME=$SURNAME;
					$this->ID_FRONT=$ID_FRONT;
					$this->BANK_NAME=$BANK_NAME;
					$this->KYC_STATUS=$KYC_STATUS;
					$this->ACCOUNT_NO=$ACCOUNT_NO;
					$this->BANK_BRANCH=$BANK_BRANCH;
					$this->COMMENT=$COMMENT;
					$this->ID_PASSPORT=$ID_PASSPORT;
					$this->BANK_CARD_IMG=$BANK_CARD_IMG;
					$this->ACCOUNT_HOLDER=$ACCOUNT_HOLDER;		
			}
		}else{
				$kyc_aml_item=array("message" => 'record not found');
			} 		
		}

		//Select Deposit by User ID
	function setKycDetails($AUID){
		$Kyc_Aml = new Kyc_Aml();
		$this->AUID = $AUID;
		$stmt = $Kyc_Aml->selectKycDetailsByUser($this->AUID);
		
		$num = $stmt->rowCount();
		$this->recordCount = $num ;

		if($num>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
			
				$kyc_aml_item=array(
					"NAME" => $NAME,
					"SURNAME" => $SURNAME,
					"ID_PASSPORT" => $ID_PASSPORT,
					"ID_FRONT" => $ID_FRONT,
					"ID_BACK" => $ID_BACK,
					"BANK_NAME" => $BANK_NAME,
					"BANK_BRANCH" => $BANK_BRANCH,
					"KYC_STATUS" => $KYC_STATUS,
					"ACCOUNT_NO" => $ACCOUNT_NO,
					"COMMENT" => $COMMENT,
					"ACCOUNT_HOLDER" => $ACCOUNT_HOLDER,
					"BANK_CARD_IMG" => $BANK_CARD_IMG
				);
				    $this->NAME=$NAME; 
					$this->SURNAME=$SURNAME;
					$this->ID_PASSPORT=$ID_PASSPORT;
					$this->ID_FRONT=$ID_FRONT;
					$this->ID_BACK=$ID_BACK;
					$this->BANK_NAME=$BANK_NAME;
					$this->BANK_BRANCH=$BANK_BRANCH;
					$this->ACCOUNT_NO=$ACCOUNT_NO;
					$this->KYC_STATUS=$KYC_STATUS;
					$this->COMMENT=$COMMENT;
					$this->ACCOUNT_HOLDER=$ACCOUNT_HOLDER;
					$this->BANK_CARD_IMG=$BANK_CARD_IMG;
					
			}
		}else{
				$kyc_aml_item=array("message" => 'record not found');
			} 		
		}
	
	 function getKycStatus(){
		return $this->KYC_STATUS;
	}
	 function getRecordCount(){
		return $this->recordCount;
	}
	 function getCOMMENT(){
		return $this->COMMENT;
	}
	 function getAUID(){
		return $this->AUID;
	}
	 function getNAME(){
		return $this->NAME;
	}
	 function getSURNAME(){
		return $this->SURNAME;
	}
	 function getID_PASSPORT(){
		return $this->ID_PASSPORT;
	}
	 function getID_FRONT(){
		return $this->ID_FRONT;
	}
	 function getID_BACK(){
		return $this->ID_BACK;
	}
	 function getBANK_NAME(){
		return $this->BANK_NAME;
	}
	 function getBANK_BRANCH(){
		return $this->BANK_BRANCH;
	}
	 function getACCOUNT_NO(){
		return $this->ACCOUNT_NO;
	}
	 function getACCOUNT_HOLDER(){
		return $this->ACCOUNT_HOLDER;
	}
     function getBANK_CARD_IMG(){
		return $this->BANK_CARD_IMG;
	}
}

	// $Kyc_Aml = new Kyc_Aml('9d1de31bc311');
	// $Kyc_Aml->setKycDetails('NAME', 'SURNAME', 'ID_PASSPORT');
	// $Kyc_Aml->updateInitialKyc('NAME', 'SURNAME', 'ID_PASSPORT');
	
	// echo $Kyc_Aml->getNAME();
	// echo $Kyc_Aml->getSURNAME();
	// echo $Kyc_Aml->getID_PASSPORT();
	// echo $Kyc_Aml->getID_FRONT();
	// echo $Kyc_Aml->getID_BACK();
	// echo $Kyc_Aml->getBANK_NAME();
	// echo $Kyc_Aml->getBANK_BRANCH();
	// echo $Kyc_Aml->getACCOUNT_NO();
	// echo $Kyc_Aml->getACCOUNT_HOLDER();
	// echo $Kyc_Aml->getBANK_CARD_IMG();
	
  // $Kyc_Aml->  updateKycIdFront('ID_PASSPORT123Front');
  // $Kyc_Aml->  updateKycIdBack('ID_PASSPORT123Back');
  // $Kyc_Aml->  updateKycBankName('ABSA BANK NAME');
  // $Kyc_Aml->  updateKycBankBranch ('ABSA BRANCH 1');
  // $Kyc_Aml->  updateKycAccNo('0000000000');
  // $Kyc_Aml->  updateKycAccHolder('updateKycAccHolder');
  // $Kyc_Aml->  updateKycBankImg('updateKycBankImg');
  // $Kyc_Aml->  updateKycId('ID_PASSPORT123');
// $Kyc_Aml->  createInitialKYC('NAME', 'SURNAME', 'ID_PASSPORT');
?>