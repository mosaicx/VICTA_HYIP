 <?php
	class FileUpload{
		
		public $post_date;
		public $target_path;
		public $file;
		public $IdFronMsg;
		public $bankDetailsMsg;
		
		function __construct(){
			
		}
		
		function UploadIdFront($tmp_name, $type, $Session_AUID){
			$_FILES["id_front"]['tmp_name'] = $tmp_name;
			if(isset($_FILES["id_front"]['tmp_name'])){
				
				$_FILES["id_front"]['type'] = $type;
				if($_FILES["id_front"]['type'] == 'image/jpeg'){
					
					$target_path = "../user_files/IdFront/".$Session_AUID.".jpg";
				}elseif($_FILES["id_front"]['type'] == 'image/png' ){
					
					$target_path = "../user_files/IdFront/".$Session_AUID.".png";
				}else{
					
					$this->bankDetailsMsg .= "Failure: Front ID uploaded not image file: ".$_FILES["id_front"]['type']." |";					
				}

				// $target_path = $target_path.basename($_FILES["id_front"]['name']);
				if(is_uploaded_file($_FILES['id_front']['tmp_name'])){
					$this->bankDetailsMsg .= "Success: Front ID uploaded to temp location |";					
					if(move_uploaded_file($_FILES["id_front"]['tmp_name'], $target_path)){
						$this->bankDetailsMsg .= "Success: Front ID upload |";
						$this->bankDetailsMsg = $target_path;
					}else{
						$this->bankDetailsMsg .= "Failure: Front ID upload |";
					}
				}else{
						$this->bankDetailsMsg .= "Failure: Front ID uploading to temp location |";					
				}				
			}
			return $this->bankDetailsMsg;
		}
		function UploadIdBack($tmp_name, $type, $Session_AUID){
			$_FILES["id_back"]['tmp_name'] = $tmp_name;
			if(isset($_FILES["id_back"]['tmp_name'])){
				
				$_FILES["id_back"]['type'] = $type;
				if($_FILES["id_back"]['type'] == 'image/jpeg'){
					
					$target_path = "../user_files/IdBack/".$Session_AUID.".jpg";
				}elseif($_FILES["id_back"]['type'] == 'image/png' ){
					
					$target_path = "../user_files/IdBack/".$Session_AUID.".png";
				}else{
					
					$this->bankDetailsMsg .= "Failure: Back ID uploaded not image file: ".$_FILES["id_back"]['type']." |";					
				}

				// $target_path = $target_path.basename($_FILES["id_front"]['name']);
				if(is_uploaded_file($_FILES['id_back']['tmp_name'])){
					$this->bankDetailsMsg .= "Success: Back ID uploaded to temp location |";					
					if(move_uploaded_file($_FILES["id_back"]['tmp_name'], $target_path)){
						$this->bankDetailsMsg .= "Success: Back ID upload |";
						$this->bankDetailsMsg = $target_path;
					}else{
						$this->bankDetailsMsg .= "Failure: Back ID upload |";
					}
				}else{
						$this->bankDetailsMsg .= "Failure: Back ID uploading to temp location |";					
				}				
			}
			return $this->bankDetailsMsg;
		}
		function UploadBankCardImg($tmp_name, $type, $Session_AUID){
			$_FILES["bank_card_img"]['tmp_name'] = $tmp_name;
			if(isset($_FILES["bank_card_img"]['tmp_name'])){
				
				$_FILES["bank_card_img"]['type'] = $type;
				if($_FILES["bank_card_img"]['type'] == 'image/jpeg'){
					
					$target_path = "../user_files/BankCardImg/".$Session_AUID.".jpg";
				}elseif($_FILES["bank_card_img"]['type'] == 'image/png' ){
					
					$target_path = "../user_files/BankCardImg/".$Session_AUID.".png";
				}else{
					
					$this->bankDetailsMsg .= "Failure: Bank card  uploaded not image file: ".$_FILES["bank_card_img"]['type']." |";					
				}

				// $target_path = $target_path.basename($_FILES["id_front"]['name']);
				if(is_uploaded_file($_FILES['bank_card_img']['tmp_name'])){
					$this->bankDetailsMsg .= "Success: Bank card  uploaded to temp location |";					
					if(move_uploaded_file($_FILES["bank_card_img"]['tmp_name'], $target_path)){
						$this->bankDetailsMsg = $target_path;
					}else{
						$this->bankDetailsMsg .= "Failure: Bank card upload |";
					}
				}else{
					$this->bankDetailsMsg .= "Failure: Bank card uploading to temp location |";					
				}				
			}
			return $this->bankDetailsMsg;
		}
	}
 
?>
