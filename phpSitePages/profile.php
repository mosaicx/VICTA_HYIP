 <?php
	session_start();
	// session_unset();
	
	include_once '../phpViews/Handler_Calulator.php';
	include_once '../phpViews/Handler_Withdrawals.php';
	include_once '../phpViews/Handler_Victa_Calculations.php';
	include_once '../phpViews/Handler_Users.php';
	include_once '../phpViews/Handler_Verify.php';
	include_once '../phpViews/Handler_NavMenus.php';
	include_once '../phpObjects/Email.php';
	include_once '../phpObjects/FileUpload.php';
	include_once '../phpObjects/KYC_AML.php';
	include_once '../phpViews/Handler_Session.php';
	
	$SessionHandlers = new SessionHandlers();

	$navMenu;
	$Kyc_Aml;
	$Session_AUID;
	$verifyMessage='';
	$verifyMessage='';
	$passwordMessage='';
	$bankDetailsMsg = "";
	$emailVerCodeMessage = "";
	$UserHandler = new UserHandler();
	$EmailHandler = new EmailHandler();
	$VerifyHandler= new VerifyHandler();
	$CalculationHandler= new CalculationHandler();
	$CalculationHandler->calculateUsers();
	$WithdrawalHandler = new WithdrawalHandler();
	$CalculationHandler = new CalculationHandler();
	$VictaCalculationHandler = new VictaCalculationHandler();

	$NavigationHandler = new	NavigationHandler();
	$NavigationHandler->footerMenu();
	$footerMenu= $NavigationHandler->getMenu();
	
	if(!$SessionHandlers->isValidSession()){
		header("Location: logout.php");					
	}else{

		$Kyc_Aml = new Kyc_Aml();
		$Session_AUID = $_SESSION['AUID'];
		
		$Kyc_Aml->setKycDetails($Session_AUID);	

		$UserHandler ->selectUserByAuid($Session_AUID);
		$username = $UserHandler ->getUsername();
		$userEmail = $UserHandler ->getEmail();
		
		$NavigationHandler->loggedInUserNav();
		$navMenu =	$NavigationHandler->getMenu();
		$CalculationHandler->calculateUserCredit($Session_AUID);
		$CalculationHandler->CalculateUserDeposits($Session_AUID);
		$CalculationHandler->CalculateUserWithdrawals($Session_AUID);
		
		$VictaCalculationHandler->calculateUserCurrentEarningsAccount($Session_AUID);
		$VictaCalculationHandler->calculateTotalUserVictaEarnings($Session_AUID);			
		$WithdrawalHandler-> SelectPendingUserWithdrawals($Session_AUID);
	}

	if(isset($_GET["resetPassword"])){
		if(!$SessionHandlers->isValidSession()){
			header("Location: logout.php");
		}else{
			$RecordCount = '';
			if($_GET["password1"] === $_GET["password2"]){
				$UserPasswordHold = $_GET["password1"];
				if($UserHandler->updateUserPasswordHold($Session_AUID, sha1($UserPasswordHold))){
					if($VerifyHandler->SelectPassVerifyById($Session_AUID)){
						$RecordCount = $VerifyHandler->getRecordCount();
					}
					if($RecordCount > 0){
						$VerifyHandler->updatePassVerify($Session_AUID);
						$VerifyHandler->SelectPassVerifyById($Session_AUID);
						$verificationCode = $VerifyHandler->getVerificationCode();
						
						$UserHandler ->selectUserByAuid($Session_AUID);
						$userEmail = $UserHandler ->getEmail();
						$username = $UserHandler ->getUsername();
						
						$EmailHandler->sendPasswordVerificationCode($userEmail, $username, $verificationCode);
						$passwordMessage = 'Password verification code sent . Please check email for verification code';
					}else{
						$UserHandler ->selectUserByAuid($_SESSION["AUID"]);
						$username = $UserHandler ->getUsername();
						$userEmail = $UserHandler ->getEmail();
						
						$VerifyHandler->createPassVerify($Session_AUID);
						$VerifyHandler->SelectPassVerifyById($Session_AUID);
						$verificationCode = $VerifyHandler->getVerificationCode();
						
						$EmailHandler->sendPasswordVerificationCode($userEmail, $username, $verificationCode);
						$passwordMessage = 'Password verification code sent . Please check email for verification code';
					}				
				}
			}else{
				$passwordMessage = 'Passwords did not match';
			}			
		}
	}
	
	if(isset($_GET["submitPassVerify"])){
		
		if(!$SessionHandlers->isValidSession()){
			header("Location: logout.php");
		}else{
			$VerifyHandler->SelectPassVerifyById($Session_AUID);
			if($_GET["verifyPassword"] === $VerifyHandler->getVerificationCode()){
				$UserHandler->selectPassHoldByAuid($Session_AUID);
				$passwordHold = $UserHandler->getPasswordHold();
				if($UserHandler->updateUserPassword($Session_AUID, $passwordHold)){
					$VerifyHandler->updatePassVerify($Session_AUID);
					
					$UserHandler ->selectUserByAuid($_SESSION["AUID"]);
					$username = $UserHandler ->getUsername();
					$userEmail = $UserHandler ->getEmail();
					$EmailHandler->sendPasswordVerificationConfirmation($userEmail, $username);
					$verifyMessage = 'New password verified';
					$VerifyHandler->updatePassVerify($Session_AUID);
				}
			}else{
				$verifyMessage = 'Invalid Verify code';
			}
		}
	}

	if(isset($_GET["requestEmailVerCode"])){
		if(!$SessionHandlers->isValidSession()){
			header("Location: logout.php");
		}		
		$VerifyHandler->SelectEmailVerifyById($Session_AUID);
		$RecordCount = $VerifyHandler->getRecordCount();
		if($RecordCount > 0){
			if($VerifyHandler->updateEmailVerify($Session_AUID)){
				$VerifyHandler->SelectEmailVerifyById($Session_AUID);
				$UserHandler ->selectUserByAuid($_SESSION["AUID"]);

				$username = $UserHandler ->getUsername();
				$userEmail = $UserHandler ->getEmail();				
				$verificationCode = $VerifyHandler->getVerificationCode();
				
				$EmailHandler->sendEmailVerificationCode($userEmail, $username, $verificationCode);
				$emailVerCodeMessage = 'Email verification code sent, please check your email';
			}else{
				$emailVerCodeMessage = 'Email verification code could not be sent';
			}
		}else{
			if($VerifyHandler->createEmailVerify($Session_AUID)){
				$VerifyHandler->SelectEmailVerifyById($Session_AUID);
				$UserHandler ->selectUserByAuid($_SESSION["AUID"]);

				$username = $UserHandler ->getUsername();
				$userEmail = $UserHandler ->getEmail();
				$verificationCode = $VerifyHandler->getVerificationCode();

				$EmailHandler->sendEmailVerificationCode($userEmail, $username, $verificationCode);
				$emailVerCodeMessage = 'Email verification code sent, please check your email';
			}else{
				$emailVerCodeMessage = 'Email verification code could not be sent';
			}
		}
	}

	if(isset($_GET["submitEmailVerify"])){
		if(!$SessionHandlers->isValidSession()){
			header("Location: logout.php");
		}else{
			$VerifyHandler->SelectEmailVerifyById($Session_AUID);
			$emailConfirmationMessage = '';
			$emailVerCode = $VerifyHandler->getVerificationCode();
			if($_GET["verifyEmail"]===$emailVerCode){
				if($UserHandler->updateEmailVerifyStatus($Session_AUID)){
					$UserHandler ->selectUserByAuid($_SESSION["AUID"]);
					$emailConfirmationMessage = 'Email verified';
					$username = $UserHandler ->getUsername();
					$userEmail = $UserHandler ->getEmail();
					
					// $EmailHandler->sendEmailVerificationConfirmation($userEmail, $username);
					$emailVerCodeMessage = '';				
				}else{
					$emailConfirmationMessage = 'Email failed to verify';					
				}
			}else{
				$emailConfirmationMessage = 'Invalid Email verifiication code';
			}
		}
	}

	if(isset($_POST['kycSubmit'])){
		if(!$SessionHandlers->isValidSession()){
			header("Location: logout.php");
		}else{
			$Kyc_Aml->setKycDetails($Session_AUID);			
			
			if($Kyc_Aml->getRecordCount() < 1){			
				if($Kyc_Aml->createInitialKYC($Session_AUID,$_POST['Name'], $_POST['Surname'], $_POST['IdentityNumber'])){
					$bankDetailsMsg = "Success: createInitialKYC |";
				}
			}else{
				$Kyc_Aml->updateInitialKyc($Session_AUID, $_POST['Name'], $_POST['Surname'], $_POST['IdentityNumber']);
				$bankDetailsMsg = "Success: updateInitialKyc |";
			}
					
			if(isset($_POST["BankName"])){
				$Kyc_Aml->updateKycBankName($Session_AUID, $_POST["BankName"]);
				$bankDetailsMsg .= "Success: Bank name Update |";
			}
			if(isset($_POST["BankBranch"])){
				$Kyc_Aml->updateKycBankBranch($Session_AUID, $_POST['BankBranch']);
				$bankDetailsMsg .= "Success: Bank branch Update |";
			}
			if(isset($_POST["AccountNumber"])){
				$Kyc_Aml->updateKycAccNo($Session_AUID, $_POST['AccountNumber']);
				$bankDetailsMsg .= "Success: Acc no Update |";
			}
			if(isset($_POST["AccountHolder"])){
				$Kyc_Aml->updateKycAccHolder($Session_AUID, $_POST['AccountHolder']);
				$bankDetailsMsg .= "Success: AccountHolder Update |";
			}
			
			if($_FILES["id_front"]['error']!= null){
					$bankDetailsMsg .= "ID upload error: ".$_FILES["id_front"]['error']." |";
			}else{
				$FileUpload = new FileUpload();
				$targetPath= $FileUpload->UploadIdFront($_FILES["id_front"]['tmp_name'], 
					$_FILES["id_front"]['type'], $Session_AUID);
				$Kyc_Aml->updateKycIdFront($Session_AUID, $targetPath);
			}
			if($_FILES["id_back"]['error']!= null){
					$bankDetailsMsg .= "ID upload error: ".$_FILES["id_back"]['error']." |";
			}else{
				$FileUpload = new FileUpload();
				$targetPath= $FileUpload->UploadIdBack($_FILES["id_back"]['tmp_name'], 
					$_FILES["id_back"]['type'], $Session_AUID);
				$Kyc_Aml->updateKycIdBack($Session_AUID, $targetPath);
			}
			if($_FILES["bank_card_img"]['error']!= null){
					$bankDetailsMsg .= "ID upload error: ".$_FILES["bank_card_img"]['error']." |";
			}else{
				$FileUpload = new FileUpload();
				$targetPath= $FileUpload->UploadBankCardImg($_FILES["bank_card_img"]['tmp_name'], 
				$_FILES["bank_card_img"]['type'], $Session_AUID);
				$Kyc_Aml->updateKycBankImg($Session_AUID, $targetPath);
			}
			
		}		
	}	
	?>
<html>
<!-- Head -->
<head>
	<title>YOUR VICTA PROFILE</title>
	<!-- Meta-Tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="Associate a Responsive Web Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible Web Template, Smartphone Compatible Web Template, Free Webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //Meta-Tags -->
	<!-- Custom-Theme-Files -->
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/font-awesome.min.css" />

	<!-- //Custom-Theme-Files -->
	<!-- Web-Fonts -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" 	type="text/css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat:400,700" 				type="text/css">
	<!-- //Web-Fonts -->
	<!-- Default-JavaScript-File -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<!--FlexSlider-->
		<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
		<script defer src="js/jquery.flexslider.js"></script>
		<script type="text/javascript">
		$(window).load(function(){
		  $('.flexslider').flexslider({
			animation: "slide",
			start: function(slider){
			  $('body').removeClass('loading');
			}
		  });
		});
	  </script>
<!--End-slider-script-->

</head>
<!-- //Head -->
<!-- Body -->
<body>
	<!-- Header -->
	<!-- banner -->
	<div class="w3l-banner1">
		<div class="header">
		<!-- Top-Bar -->
				<div class="top-bar">
				<div class="container">
					<div class="header-nav">
						<nav class="navbar navbar-default">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<h1><a class="navbar-brand" href="index.html">VICTA</a></h1>
							</div>
							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav ">
								    <?php
									echo $navMenu;
									?>
								</ul>
							</div>
							<!-- /navbar-collapse -->

						</nav>
						<div class="cd-main-header">
									<a class="cd-search-trigger" href="#cd-search"> <span></span></a>
									<!-- cd-header-buttons -->
								</div>
								<div id="cd-search" class="cd-search">
									<form action="#" method="post">
										<input name="Search" type="search" placeholder="Search...">
									</form>
								</div>
					</div>
				</div>
			</div>
		</div>
		<!-- //Top-Bar -->
	</div>
		<!-- features -->
		<div class="features">
		<div class="container">
			<h3>Settings</h3>
			<div class="border"> </div>
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Profile Information</a></li>
						<li role="presentation" class=""><a href="#Feature1" role="tab" id="Feature1-tab" data-toggle="tab" aria-controls="Feature1" aria-expanded="false">KYC Information</a></li>
						<li role="presentation" class=""><a href="#Feature2" role="tab" id="Feature2-tab" data-toggle="tab" aria-controls="Feature2" aria-expanded="false">Account Information</a></li>
						<li role="presentation" class=""><a href="#Feature3" role="tab" id="Feature3-tab" data-toggle="tab" aria-controls="Feature3" aria-expanded="false">Deposit Information</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
							<div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left contact-w3-agileits">
									<h4>Profile Information</h4>
									<?php
										// $UserHandler ->selectUserByAuid($Session_AUID);
									?>
									<p> Email:<?php echo " ". $UserHandler ->getEmail(); ?></p>
									<p> First Name: <?php echo " ". $UserHandler ->getFirstName(); ?></p>
									<p> Last Name:  <?php echo " ". $UserHandler ->getSurname(); ?></p>
									<p> Password: Hidden 
								</div>
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right2">
									<form action="#" method="get" name='resetPasswordForm' id='resetPasswordFrmId'>
										<div class="col-md-7 w3agile_tab_left contact-w3-agileits">
											<h4> Reset Password</h4>
										</div>
										<br/>
										<br/>
										<p><input type="password" name="password1" placeholder="Password*" required=""></p>
										<br/>
										<p><input type="password" name="password2" placeholder="Retype Password*" required=""></p>
										<br/>
										<input type="submit" name="resetPassword" value="Reset Password"></p> 

										<?php echo $passwordMessage; ?>
									</form>
										<form action="#" method="get" name='passwordVerifyForm' id='passwordVerifyId'>
										<p><input type="text" name="verifyPassword" placeholder="Verification Code*" required=""></p><br/>
										<input type="submit" name="submitPassVerify" value="Verify Password"></p> 

										<?php echo $verifyMessage; ?>
									</form>
								</div>

								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature1" aria-labelledby="Feature1-tab">
							<div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left contact-w3-agileits">
									<h4>KYC / AML Compliance</h4>
									<p> Cras consectetur tempus lectus id accumsan. 
										Vivamus gravida justo mattis ex pretium, 
										eu sollicitudin tortor ullamcorper. Quisque vitae diam 
										molestie, tincidunt velit vitae, viverra nisl. </p>
									<form enctype="multipart/form-data" name="kycForm" method="post">
									<p><input type="name" name="Name" placeholder="Name*" required=""></p>
									<p><input type="Surname" name="Surname" placeholder="Surname*" required=""></p>
									<p><input type="ID" name="IdentityNumber" placeholder="ID/Passport Number*" required=""></p>
										<p>Upload ID front: </p><p><input type="file" name="id_front" /></p>
										<p>Upload ID back: </p><p><input type="file" name="id_back" /></p>
									<p><input type="text" name="BankName" placeholder="Bank Name*" required=""></p>
									<p><input type="text" name="BankBranch" placeholder="Branch Code*" required=""></p>
									<p><input type="text" name="AccountNumber" placeholder="Account Number*" required=""></p>
									<p><input type="text" name="AccountHolder" placeholder="Account Holder (Name on front of card)*" required=""></p>
										<p>Upload Proof of Residence In Image Format: </p><p><input type="file" name="bank_card_img" /></p>
										<p>
										<input type="Submit" name="kycSubmit" value="Submit"><br/>
										<?php echo $bankDetailsMsg; ?>
										</p>
									</form>
								</div>
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right1">
									<img src="images/3.png" alt=" " class="img-responsive"> 
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature2" aria-labelledby="Feature2-tab">
							<div class="w3agile_tabs">
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right2">
									 <img src="images/2.png" alt=" " class="img-responsive">
								</div>
								<div class="col-md-7 w3agile_tab_left">
									<h4>Account Information</h4>
										
										<b>Account Summary</b><br/>
										<p>
										Total deposits value (ZAR): 
										<?php 
											$UserZarDeposit = $CalculationHandler->getTotalUserConfirmedDepositRandValue();
											echo "R ".number_format($UserZarDeposit, 2, '.', ',');
										?>
										<br/>
										Purchase credit balance(ZAR): 
										<?php 
											$UserCredit = $CalculationHandler->getUserCredit();
											echo "R ".number_format($UserCredit, 2, '.', ',');
										?>
										<br/></p>
										
										<p>
										Confirmed Withdrawals (ZAR): 
										<?php										
											$UserZarWithdrawals = $CalculationHandler->getTotalUserConfirmedWithdrawalRandValue();
											echo "R ".number_format($UserZarWithdrawals, 2, '.', ',');
										?>
										<br/>
										Pending Withdrawals (ZAR): 
										<?php 
											$PendingUserWithdrawalAmount = $CalculationHandler->getTotalUserPendingWithdrawalRandValue();
											echo "R ". number_format($PendingUserWithdrawalAmount, 2, '.', ',');
										?>
										<br/></p>
										
										<p>
										Total earned to date (ZAR): 
										<?php 
											$UserVictaEarnings = $VictaCalculationHandler->getTotalUserVictaEarnings();
											echo "R ". number_format($UserVictaEarnings, 2, '.', ',');
										?><br/>
										Current earnings account (ZAR): 
										<?php 
											$UserZarCurrAccount =$VictaCalculationHandler->getUserCurrentEarningsAccount();
											echo "R ". number_format($UserZarCurrAccount , 2, '.', ',');	
										?>
										<br/></p>
										
										<p><b>Banking Details</b><br/>
										
										Bank: <?php echo $Kyc_Aml->getBANK_NAME();?><br/>
										Account no.: <?php echo $Kyc_Aml->getACCOUNT_NO();?><br/>
										Bank Branch: <?php echo $Kyc_Aml->getBANK_BRANCH();?></br>
										Account Holder: <?php echo $Kyc_Aml->getACCOUNT_HOLDER();?></p>

										<p><b>Verification</b><br>
										Email verified:
										<?php
											if($UserHandler->getEmailVerifyStatus() == 'false'){
												echo "No.";
												echo "
												<form action='#' method='get' name='requestEmailVerCodeForm'>
												<input type='submit' name='requestEmailVerCode' value='Request Email Verification'>
												</form><br/>
												<form action='#' method='get' name='submitEmailVerCodeForm'>
												<p><input type='text' name='verifyEmail' placeholder='Email Verification Code*' required=''></p>
												<input type='submit' name='submitEmailVerify' value='Verify Email'></p> 
												</form><br/>";
											}else{
												echo 'Yes';
												echo '<br/>KYC verified: ';
												$Kyc_Aml->setKycDetails($Session_AUID);
												if($Kyc_Aml->getKycStatus() == 'CONFIRMED'){
													echo 'Yes';
												}elseif($Kyc_Aml->getKycStatus() == 'PENDING'){
													echo "No. <br/>Expect Verification Confirmation within 5 working days. <b>Withdrawal requests may be delayed if KYC  information is not complete at time of request</b> <br/>";
												}elseif($Kyc_Aml->getKycStatus() == 'REJECTED'){
													echo "No. <br/>KYC Rejected. Comments: '".$Kyc_Aml->getCOMMENT()."'<br/>";
												}
											}
											echo $emailVerCodeMessage;
										?>
										</p>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature3" aria-labelledby="Feature3-tab"><div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left">
									<h4>Deposit Details</h4>
									<p> In order to make VICTA purchases, make a deposit using the below banking details. Once your deposit reflects, your account will be credited and you will be able to make purchases.</p>
									
									<p> Bank: FNB<br/>
										Account type: Business Current Account<br/>
										Account number: 62674337037<br/>
										Branch code: 254005<br/>
										Reference code: 
											<?php
												echo " ".$UserHandler->getEmail();
											?><br/>
										<b>Please note deposits transactions from non-FNB clients may take up to 2 working days to reflect</b></p>									
								</div>
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right1">
									<!-- <img src="images/3.jpg" alt=" " class="img-responsive"> -->
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	<!-- //features-->
	<!-- footer -->
	<div class="footer-top">
		<div class="container">
		<div class="col-md-5 w3l-footer-top">
			<h3>ABOUT VICTA</h3>
			<p>VICTA is an online investment platform that gives users access to fantastic investment opportunities. We create an environment that lets you buy virtual investment contracts.</p>
		</div>
			
			<div class="col-md-5 wthree-footer-top">
				<h3>VICTA INVESTING</h3>
					<p>VICTA Investing is for people looking to grow the value of their money over time, not over night. We put investor money to work. Making collective investments that benefit the investing masses. Bringing investments to the people</p>
			</div>
			<div class="col-md-2 w3ls-footer-top">
				<h3>
					MENU
				</h3>
				<p>
					<ul>
						<?php						
							echo $footerMenu;
						?>
					</ul>
				</p>
			</div>
				<div class="clearfix"></div>
			
		</div>
	</div>
	<div class="footer-w3layouts">
		<div class="container">
				<div class="agile-copy">
					<p>© 2014 Beit Solutions (Pty) Ltd. All rights reserved | Designed using <a href="http://w3layouts.com/">W3layouts</a> templates</p>
				</div>
				<div class="agileits-social">
					<ul>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-rss"></i></a></li>
							<li><a href="#"><i class="fa fa-vk"></i></a></li>
						</ul>
				</div>
					<div class="clearfix"></div>
			</div>
	</div>
	<!-- //footer -->					<div class="modal about-modal fade" id="myModal" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header"> 
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
								<h4 class="modal-title">Associate</h4>
							</div> 
							<div class="modal-body">
								<div class="agileits-w3layouts-info">
									<img src="images/g1.jpg" class="img-responsive" alt="" />
									<p>Duis venenatis, turpis eu bibendum porttitor, sapien quam ultricies tellus, ac rhoncus risus odio eget nunc. Pellentesque ac fermentum diam. Integer eu facilisis nunc, a iaculis felis. Pellentesque pellentesque tempor enim, in dapibus turpis porttitor quis. Suspendisse ultrices hendrerit massa. Nam id metus id tellus ultrices ullamcorper.  Cras tempor massa luctus, varius lacus sit amet, blandit lorem. Duis auctor in tortor sed tristique. Proin sed finibus sem.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- //modal -->  

</body>
<!-- //Body -->
</html>