<?php 
	class NavigationHandler{
		public $navMenu;
		
		function loggedOutUserNav(){
			$this->navMenu = "<li><a href='index.php'>Home</a></li><li><a href='about.php'>About</a></li>";
			$this->navMenu .="<li><a href='login.php'>Login</a></li>";
			$this->navMenu .="<li><a href='register.php'>Register</a></li>";
			
		}

		function loggedInUserNav(){
			$this->navMenu = "<li><a href='index.php'>Home</a></li><li><a href='about.php'>About</a></li>";
			$this->navMenu .="<li><a href='profile.php'>Profile</a></li>";
			$this->navMenu .="<li><a href='dashboard.php'>Dashboard</a></li>";
			$this->navMenu .="<li><a href='transactions.php'>Transactions</a></li>";
			$this->navMenu .="<li><a href='logout.php'>Logout</a></li>";

		}

		function inSessionAdminNav(){
		$this->navMenu = "<li><a href='user_deposit_keying.php'>Deposit Keying</a>";
		$this->navMenu .= "</li><li><a href='user_deposit_confirmation.php'>Deposit Confirmation</a></li>";
		$this->navMenu .="<li><a href='user_withdraw_confirmation.php'>Withdrawal Confirmation</a></li>";
		$this->navMenu .="<li><a href='manage_kyc.php'>Manage KYC</a></li>";
		$this->navMenu .="<li><a href='register.php'>Register User</a></li>";		
		$this->navMenu .="<li><a href='logout.php'>Logout</a></li>";	
		}

		function LoginAdminNav(){
			$this->navMenu = "<li><a href='register.php'>Register</a></li>";
		}

		function RegAdminNav(){
			$this->navMenu = "<li><a href='login.php'>Login</a></li>";
		}

		function footerMenu(){
			$this->navMenu = "<li><a href='index.php'>Home</a></li>";
			$this->navMenu .= "<li><a href='about.php'>About</a></li>";
			$this->navMenu .="<li><a href='faq.php'>FAQ</a></li>";
			$this->navMenu .="<li><a href='TermsOfUse.php'>Terms of Use</a></li>";
		}

		function getMenu(){
			return $this->navMenu; 
		}
	}
?>