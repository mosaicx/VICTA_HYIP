<?php 
session_start();
$Session_AUID = $_SESSION["AUID"];

include_once '../phpViews/Handler_Wallets.php';
include_once '../phpViews/Handler_Users.php';
include_once '../phpViews/Handler_Victa_Calculations.php';
include_once '../phpViews/Handler_Calulator.php';
include_once '../phpViews/Handler_Withdrawals.php';
include_once '../phpViews/Handler_Victas.php';
include_once '../phpObjects/Email.php';
include_once '../phpViews/Handler_Deposits.php';
include_once '../phpViews/Handler_NavMenus.php';
include_once '../phpObjects/KYC_AML.php';
include_once '../phpViews/Handler_Session.php';
	
$SessionHandlers = new SessionHandlers();

$CalculateUserTotalEarned;
$SelectWithdrawalsByUser;
$SelectDepositByUser;
$SelectWalletByUser;
$submitVictaBuyMsg;
$userCurrAccount;
$NavigationHandler;
$Kyc_Aml;

$UserHandler;
$VictaHandler;
$WalletHandler;
$DepositHandler;
$WithdrawalHandler;
$CalculationHandler;
$VictaCalculationHandler;

$NavigationHandler = new NavigationHandler();
$NavigationHandler->footerMenu();
$footerMenu= $NavigationHandler->getMenu();
	

if($SessionHandlers->isValidSession()){
	$Session_AUID = $_SESSION['AUID'];
	
	$UserHandler = new UserHandler();
	$VictaHandler = new VictaHandler();
	$WalletHandler = new WalletHandler();
	$DepositHandler = new DepositHandler();
	$WithdrawalHandler = new WithdrawalHandler();
	$CalculationHandler = new CalculationHandler();
	$VictaCalculationHandler = new VictaCalculationHandler();

	$Kyc_Aml = new Kyc_Aml($Session_AUID);
	
	$WithdrawalHandler->SelectWithdrawalsByUser($Session_AUID);
	$DepositHandler->SelectDepositByAuid($Session_AUID);
	$VictaHandler->SelectVictasByAuid($Session_AUID);
	
	$NavigationHandler->loggedInUserNav();
	
	$CalculationHandler->calculateUserCredit($Session_AUID);

	$Kyc_Aml->setKycDetails($Session_AUID);
	
	$VictaCalculationHandler->calculateUserCurrentEarningsAccount($Session_AUID);
	$userCurrAccount = $VictaCalculationHandler->getUserCurrentEarningsAccount();

	$receivingAddress = "AccNo: ".$Kyc_Aml->getACCOUNT_NO()." | BankName: ".$Kyc_Aml->getBANK_NAME()." | Bank Branch:".$Kyc_Aml->getBANK_BRANCH();
	$withdrawMessage = "";
}else{
	header("Location: logout.php");
}
$navMenu =	$NavigationHandler->getMenu();

if(isset($_POST['submitWithdrawReq'])){
	if($SessionHandlers->isValidSession()){
		if($_POST['withdrawAmt'] <= $userCurrAccount){
			if($Kyc_Aml->getACCOUNT_NO() == '' || $Kyc_Aml->getBANK_NAME() == ''){
				$withdrawMessage = "Please ensure that bank details are provided before attempting a withdrawal";			
			}else{
				if($_POST['withdrawAmt'] >= 100){
					if($WithdrawalHandler->createWithdrawal($Session_AUID, $receivingAddress, $_POST['withdrawAmt'])== 'SUCCESS'){
							$EmailHandler = new EmailHandler();
							$UserHandler = new UserHandler();
							$UserHandler->selectUserByAuid($Session_AUID);
							
							$user_email = $UserHandler->getEmail();
							$withdrawal_amount = $_POST['withdrawAmt'];
							$bank_details = $receivingAddress;
							
							$EmailHandler->sendWithdrawalRequest($user_email, $withdrawal_amount, $bank_details);
							$withdrawMessage = "Thank you. Your requested is being processed.<br/>Details<br/>Receiving bank details: ".$receivingAddress."<br/>Withdrawal amount: R".$_POST['withdrawAmt'];
							header("Location: transactions.php");
							
					}else{
						$withdrawMessage = "Your requested failed due to internal issues please try again later.<br/>";				
					}
				}else{
					$withdrawMessage = "Please ensure withdrawal amount is greater than R100.<br/>";				
				}
			}
		}else{
			$withdrawMessage = "Requested amount is greater than current account balance";
		}
		
	}else{
		header("Location: logout.php");
	}
}

$submitVictaBuyMsg = '';
$UserCredit = $CalculationHandler->getUserCredit();
if(isset($_POST['submitBuyRequest'])){
	if($SessionHandlers->isValidSession()){
		if($_POST["buyAmt"]<=$UserCredit){
			if($_POST['victaList'] == 'entra'){
				if(($_POST["buyAmt"] % 500) == 0){
					$Quantity = $_POST['buyAmt'] / 500;
					$VictaHandler->createVictaTx($Session_AUID, $_POST['victaList'], $_POST['buyAmt'], $Quantity);
					header("Location: transactions.php");
					$submitVictaBuyMsg = 'bought '.$Quantity. 'Victas';			
				}else{
					$submitVictaBuyMsg = 'Please enter a valid amount. Multiples of 500. ';			
				}
			}elseif($_POST['victaList'] == 'intermida'){
				if(($_POST['buyAmt'] % 1500) == 0){
					$Quantity = $_POST['buyAmt'] / 1500;
					$VictaHandler->createVictaTx($Session_AUID, $_POST['victaList'], $_POST['buyAmt'], $Quantity);			
					$submitVictaBuyMsg = 'bought '.$Quantity. 'Victas';			
					header("Location: transactions.php");
				}else{
					$submitVictaBuyMsg = 'Please enter a valid amount. Multiples of 1500';			
				}
			}elseif($_POST['victaList'] == 'major'){
				if(($_POST['buyAmt'] % 5000) == 0){
					$Quantity = $_POST['buyAmt'] / 5000;
					$VictaHandler->createVictaTx($Session_AUID, $_POST['victaList'], $_POST['buyAmt'], $Quantity);			
					$submitVictaBuyMsg = 'bought '.$Quantity. 'Victas';			
					header("Location: transactions.php");
				}else{
					$submitVictaBuyMsg = 'Please enter a valid amount. Multiples of 5000';			
				}				
			}elseif($_POST['victaList'] == 'perpetua'){
				if(($_POST['buyAmt'] % 10000) == 0){
					$Quantity = $_POST['buyAmt'] / 10000;
					$VictaHandler->createVictaTx($Session_AUID, $_POST['victaList'], $_POST['buyAmt'], $Quantity);			
					$submitVictaBuyMsg = 'bought '.$Quantity. 'Victas';			
					header("Location: transactions.php");
				}else{
					$submitVictaBuyMsg = 'Please enter a valid amount. Multiples of 10000';			
				}		
			}
		}else{
			$submitVictaBuyMsg = "Purchase credit balance (".$UserCredit.") is less than the purchase amount requested (".$_POST['buyAmt']."). <br/>Please increase your purchase credit buy making a deposit or select a VICTA purchase within your available credit balance.";
		}
	}else{
		header("Location: logout.php");
	}
}
?>
<html>
<!-- Head -->
<head>
	<title>VICTA TRANSACTIONS</title>
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
		<!-- //Top-Bar -->
	</div>
	<!-- //Header -->
		<div class="container">
		</div>
	</div>	
		<!-- features -->
		<div class="features">
		<div class="container">
			<h3>Transactions</h3>
			<div class="border"> </div>
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">VICTAS</a></li>
						<li role="presentation" class=""><a href="#Feature1" role="tab" id="Feature1-tab" data-toggle="tab" aria-controls="Feature1" aria-expanded="false">Withdraw</a></li>
						<li role="presentation" class=""><a href="#Feature2" role="tab" id="Feature2-tab" data-toggle="tab" aria-controls="Feature2" aria-expanded="false">Trade Withdrawals</a></li>
						<li role="presentation" class=""><a href="#Feature3" role="tab" id="Feature3-tab" data-toggle="tab" aria-controls="Feature3" aria-expanded="false">Trade Deposits</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
							<div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left">
								<div>
									<h2>VICTAS</h2>
									<form action="#" method="post" name='BuyVictasForm' id='BuyVictasId'>
										<p>Purchase VICTAs. ( Available credit: R
										<?php 
											$CalculationHandler->calculateUserCredit($Session_AUID);
											$UserCredit = $CalculationHandler->getUserCredit();
											echo number_format($UserCredit, 2, '.', ','); 
										?>
										)
										<br/>
										Enter purchase amount<br/>
										<input type="text" name="buyAmt" placeholder="ZAR Amount"><br/>
										<br/>
										Select VICTA Type<br/>
											<select name='victaList'>
												<option value='entra'>VICTA ENTRA</option>
												<!--coming soon>
												<option value='intermida'>VICTA INTERMIDA</option>
												<option value='major'>VICTA MAJOR </option>
												<option value='perpetua'>VICTA PERPETUA </option>
												<coming soon-->
											</select>
										<input type="Submit" name="submitBuyRequest" value="Buy VICTAs">
										</p>
											<?php echo $submitVictaBuyMsg; ?>
												
									</form>								
									
									<table class="deposits_table">
										<tr><th> Transaction  Date </th><th > Transaction  ID</th><th> VICTA Type</th><th> Unit Price </th><th> Quantity </th><th>Total Purchase Price</th></tr>
										<?php echo $VictaHandler->getRecordsTable() ?>
									</table><br/>
								</div>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature1" aria-labelledby="Feature1-tab">
							<div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left contact-w3-agileits">
									<h4>Withdrawals</h4>	
									<p>Current Available ZAR Amount: R 
									<?php 
										echo number_format($userCurrAccount , 2, '.', ',');									
									?>: </p>
									<p>
										<b>Withdraw ZAR to</b>
										<br/>Bank Name: 
										<?php
											echo $Kyc_Aml->getBANK_NAME()
										?>
										<br/>  Bank Branch: 
										<?php
											echo $Kyc_Aml->getBANK_BRANCH();
										?> 
										<br/> Bank Account:
										<?php
											echo $Kyc_Aml->getACCOUNT_NO();
										?>
									</p>
									<p>
									<form action="#" method="post" name='WithdrawForm' id='UserLoginFrmId'>
										<p></p>
										<br/>
										<input type="text" name="withdrawAmt" placeholder="ZAR Amount"><b> </b><br/>
										<input type="Submit" name="submitWithdrawReq" value="Withdraw ZAR amount">
									</p>
												<?php echo $withdrawMessage; ?>
												
									</form>								
								</div>
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right1">
									<!--<img src="images/3.png" alt=" " class="img-responsive">-->
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature2" aria-labelledby="Feature2-tab">
							<div class="w3agile_tabs">
								<div >
									<h2>WITHDRAWALS</h2><br/>
									<table class="withdrawals_table">
										<tr><th> Transaction Date </th><th > Transaction  Amount </th><th> Transaction  Status </th><th> Transaction  ID </th></tr>
										<?php echo $WithdrawalHandler->getRecordsTable() ?>
									</table><br/>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature3" aria-labelledby="Feature3-tab"><div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left">
								<div>
									<h2>DEPOSITS</h2><br/>
									<table class="deposits_table">
										<tr><th> Transaction  Date </th><th > Transaction  Amount (BTC)</th><th> Transaction  Amount (ZAR)</th><th> Transaction  Status </th><th> Transaction  ID </th></tr>
										<?php echo $DepositHandler->getRecordsTable() ?>
									</table><br/>
								</div>
								<div class="clearfix"> </div>
							</div>
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
	<!-- //footer -->
	<div class="modal about-modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
				<h4 class="modal-title">Beit Solutions</h4>
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