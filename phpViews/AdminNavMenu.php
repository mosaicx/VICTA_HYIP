<?php 
	class AdminNavMenu{
		public $navMenu;
		
		function LoginAdminNav(){
			$this->navMenu = "<li><a href='register.php'>Register</a></li>";
		}

		function RegAdminNav(){
			$this->navMenu = "<li><a href='login.php'>Login</a></li>";
		}
		

		function inSessionAdminNav(){
		$this->navMenu = "<li><a href='user_deposit_keying.php'>Deposit Keying</a>";
		$this->navMenu .= "</li><li><a href='user_deposit_confirmation.php'>Deposit Confirmation</a></li>";
		$this->navMenu .="<li><a href='user_withdraw_confirmation.php'>Withdrawal Confirmation</a></li>";
		$this->navMenu .="<li><a href='manage_kyc.php'>Manage KYC</a></li>";
		$this->navMenu .="<li><a href='register.php'>Register User</a></li>";		
		$this->navMenu .="<li><a href='logout.php'>Logout</a></li>";	
		}

		function getMenu(){
			return $this->navMenu; 
		}
	}
?>