<?php
	session_start();
	include_once '../phpViews/Handler_Calulator.php';
	include_once '../phpViews/Handler_NavMenus.php';
	include_once '../phpViews/Handler_Users.php';
	include_once '../phpViews/Handler_Session.php';
	
	$SessionHandlers = new SessionHandlers();
	$navMenu;
	$CalculationHandler = new CalculationHandler();
	$CalculationHandler->calculateUsers();

	$NavigationHandler = new NavigationHandler();
	$NavigationHandler->footerMenu();
	$footerMenu= $NavigationHandler->getMenu();

	
	if($SessionHandlers->isValidSession()){
		$NavigationHandler->loggedInUserNav();
	}else{
		$NavigationHandler->loggedOutUserNav();
	}
	$navMenu =	$NavigationHandler->getMenu();

?>
<html>
<!-- Head -->
<head>
	<title>WELCOME TO VICTA</title>
	<!-- Meta-Tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="Associate a Responsive Web Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible Web Template, Smartphone Compatible Web Template, Free Webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">
		<script type="application/x-javascript"> 
			addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
		</script>
	<!-- //Meta-Tags -->
	<!-- Custom-Theme-Files -->
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/font-awesome.min.css" />

	<!-- //Custom-Theme-Files -->
	<!-- Web-Fonts -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" type="text/css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat:400,700" type="text/css">
	<!-- //Web-Fonts -->
	<!-- Default-JavaScript-File -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/siteFunctions.js"></script>
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
							</div>
							<!-- /navbar-collapse -->
						</nav>
					</div>
				</div>
			</div>
		<!-- //Top-Bar -->
	</div>
	<!-- //Header -->
		<div class="container">
			<h2 class="w3ls_head">TERMS OF USE</h2>
			<p>
				VICTA Investments is the trading name of BEIT SOLUTIONS. Any reference to VICTA Investments will automatically refer to BEIT SOLUTIONS and vice versa in so far as these Terms of Use are concerned. 
				VICTA Investments will provide its services to you, which are subject to the conditions stated below in this document. 
				Every time you visit the VICTA website and/or use its services, you accept the following conditions. 
			</p>
		</div>
	<div class="wthree-welcome">
		<div class="container">
			<h2>Terms & Conditions</h2>
				<p>
					We urge you to read these Terms of Use (TOUs) carefully. The Rules set out the general procedure for interaction between the rights and obligations of the Client and VICTA Investments. 
					You have a right to accept and not to accept the offered conditions that later on will predetermine your participation or non-participation in program. 
					VICTA Investments reserves the right to change these Terms and Conditions at any time without notice to you. 
					You are therefore responsible for regularly reviewing these Terms and Conditions. 
					Continued use of this website following any such changes shall constitute your acceptance of such changes.
				</p><br/>
			<h2>Copyright authorship</h2>
				<p>
					Content published on this website including digital downloads, images, texts, graphics, logos is the property of VICTA Investments and/or its content creators and/or its content partners. 
					Such content is protected by international copyright laws unless otherwise advised. 
				</p><br/>
			<h2>General Provisions</h2>
				<p>
					Any person from any country who has reached the age of majority (under the laws of their country of residence but not less than 18 years of age) and has registered on the VICTA website is considered to be a Client.
					The opinions expressed on this website do not constitute investment advice and independent advice should be sought where appropriate. 
					The Client acknowledges that he/she carries out investment activities on their own discretion, independently and with their own personal funds, 
					and cannot lay a claim or institute a suit against BEIT SOLUTIONS in any cases where the investment actions could lead and/or led to negative results, subsidence and/or losses. 
					All transactions are made by the Parties in the 'private transaction' format. The Parties confirm the complete confidentiality of any transaction and any interaction in the framework of these terms of use.
				</p><br/>
			<h2>Rights & Obligations</h2>
				<p>
					BEIT SOLUTIONS (hereafter referred to as The Company) is obliged to provide a well-functioning and smoothly-running Website within the technical possibilities to the Client.
					The Company is obliged to indefinitely keep confidential any personal information provided by the Client during registration and in the course of further cooperation between 
					the Parties in strict compliance with the Privacy Policy. We ensure that information about the Clients will not be knowingly or intentionally disclosed to third parties. 
					The Company also undertakes to ensure secure exchange of data within the Website. If the Client provides false information or if the administration has reason to consider information 
					provided by the Client is incomplete or invalid, the administration has the full discretion to block, suspend or remove the Client's account. 
					The Company may voluntarily and freely manage investment funds deposited by the Client on his/her account in trust.
					The Company has the right to inform you about everything that happens on the Company website by sending information to your email. 
					The Company reserves the right to change the regulations, commissions and rates of the program at any time and at its sole discretion without prior notice to the participants.
					The Company may at any time implement, terminate or change the terms and conditions of any Affiliate Program without prior notice.
					The Client may make use of all the Website features, carry out investment activities, conduct financial transactions, receive profit on his active VICTA purchases, 
					and receive referral commissions within the framework and under the conditions of any Affiliate Program instituted on the website.
					The Clients are prohibited from using the Company's website for illegal or offensive purposes. 
					The use of the website is prohibited if it results to the decline of the website workability and distorts its content; 
					prevents the provision of VICTA Investments services to other Clients and infringes the rights of VICTA Investments to intellectual property.
					The Client is committed to provide only accurate and correct personal data (password, login and other details). 
					The Client is obliged to observe complete confidentiality while storing his/her password, login and other details used by the Client on the VICTA Investments website.
					The Client undertakes not to use SPAM techniques against any and all the participants in the investment process. 
					The Client undertakes not to use viruses, malware and/or phishing systems in any of their manifestations and/or combinations against the Website or against the accounts of other clients. 
					The Client agrees to communicate with The Company staff directly when there are issues he/she needs to address. 
					Discussion of issues publicly without first notifying us will be deemed damaging and potentially negligent to the safety and security of other clients and may be deemed to be sufficient cause for account suspension or system freeze.
				</p><br/>
			<h2>User Account</h2>
				<p>
					Account is a personal customer area designated for users which functions on the basis of user's personal data. Client is fully responsible for the state of his account, access to it and its control. 
					By going to your account you acknowledge that you are fully and wholly responsible for all transactions performed in system on behalf of your account.
				</p><br/>
			<h2>Financial Transactions</h2>
				<p>
					A deposit is considered active if it has been confirmed by the admin of the website and has been successfully credited to the Client’s account. <br/>
					A Virtual Investment Contractual Tacit Agreement (herein after referred to as a VICTA) is considered active if its term has not expired according to the relevant investment plan selected.  <br/>
					All accruals in the Client account are made according to the chosen VICTA investment package. The nominal initial purchase credit spent on a VICTA purchase cannot be withdrawn from the system.  <br/>
					Profit accruals and interest payouts to the Client are made only in the currency of the electronic payment system used by that Client to make deposit.  <br/>
					The Client acknowledges and agrees that his VICTA purchase options cannot be changed after the purchase has been made.
				</p><br/>
			<h2>Communications</h2>
				<p>
					The entire communication with us is electronic. Every time you send us an email or visit our website, you are going to be communicating with us. 
					You hereby consent to receive communications from us. We will continue to communicate with you by posting news and notices on our website and by sending you emails. 
					You also agree that all notices, disclosures, agreements and other communications we provide to you electronically meet the legal requirements that such communications be in writing.
				</p><br/>
			<h2>Force Majeure</h2>
				<p>
					The Company is not liable for any malfunction and failures on the Website if such were caused by force majeure or circumstances that could not and/or cannot be controlled by the Company. 
					We may suspend performance of our obligations in case of force majeure at any of the Parties for the period necessary to completely stop the action and/or address the impact of this force majeure.
					In case of rejection of the Rules, disagreement with the general doctrine of the Rules or any other differences of opinion, the user is obliged to stop the account registration and leave this website.
				</p>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="services-bottom">
		<div class="container">
			<div class="col-md-3 agileits_w3layouts_about_counter_left">
				<p class="counter">
					<?php
						$unverifiedUserCount = $CalculationHandler->getUnverifiedEmailCount();
						$verifiedUserCount = $CalculationHandler->getVerifiedEmailCount();
						$fullUserCount = $unverifiedUserCount + $verifiedUserCount;
						echo $fullUserCount;
					?>	
				</p> 
				<i class="glyphicon glyphicon-user" aria-hidden="true"></i>
				
				<h3>Total Users</h3>
			</div>
			<div class="col-md-3 agileits_w3layouts_about_counter_left">
				<p class="counter">
					<?php
						$CalculationHandler->CalculateGlobalWithdrawals();
						$totalPendingWithdrawalRandValue=$CalculationHandler->getTotalPendingWithdrawalRandValue();
						$totalConfirmedWithdrawalRandValue=$CalculationHandler->getTotalConfirmedWithdrawalRandValue();
						$globalWithdrawals = $totalPendingWithdrawalRandValue + $totalConfirmedWithdrawalRandValue;
						echo $globalWithdrawals;
					?>
				</p> 
				<i class="fa fa-file-text-o" aria-hidden="true"></i>
				
				<h3>Total Withdrawn (ZAR)</h3>
			</div>
			<div class="col-md-3 agileits_w3layouts_about_counter_left">
				<p class="counter">
					<?php
						$CalculationHandler->CalculateGlobalDeposits();
						$globalDeposits = $CalculationHandler->getTotalConfirmedDepositRandValue();
						echo $globalDeposits;
					?>
				</p>
				<i class="fa fa-calendar" aria-hidden="true"></i>
				 
				<h3>Total Deposited (ZAR)</h3>
			</div>
			<div class="clearfix"> </div>
			<!-- Stats-Number-Scroller-Animation-JavaScript -->
				<script src="js/waypoints.min.js"></script> 
				<script src="js/counterup.min.js"></script> 
				<script>
					jQuery(document).ready(function( $ ) {
						$('.counter').counterUp({
							delay: 100,
							time: 1000
						});
					});
				</script>
			<!-- //Stats-Number-Scroller-Animation-JavaScript -->

		</div>
	</div>
	<!-- //services-bottom -->
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