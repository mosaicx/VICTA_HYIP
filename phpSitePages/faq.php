<?php
	include_once '../phpViews/Handler_Calulator.php';
	include_once '../phpViews/Handler_NavMenus.php';
	include_once '../phpViews/Handler_Users.php';
	include_once '../phpViews/Handler_Session.php';
	
	$SessionHandlers = new SessionHandlers();
	$navMenu;
	$submitVictaIntermidaMsg = '';
	$submitVictaPerpetuaMsg = '';
	$submitVictaMajorMsg = '';
	$submitVictaEntraMsg = '';
	$NavigationHandler = new	NavigationHandler();
	$NavigationHandler->footerMenu();
	$footerMenu= $NavigationHandler->getMenu();

	$UserHandler = new UserHandler();
	$CalculationHandler = new CalculationHandler();
	$CalculationHandler->calculateUsers();

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
	<title> FAQ VICTA</title>
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
					</div>
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
	<div class="agileits-abt">
		<div class="container">
			<h2 class="w3ls_head">FAQ</h2>
			<div class="insurance-info">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title asd">
								<a class="pa_italic" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><b>About VICTA Investments?</b><span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body panel_text">
								<div class="scrollbar" id="style-2">
									<div class="in-info">
										<div class="service1">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>What is VICTA Investments?</b></h4>
												<p>VICTA is an innovative, online, short- and mid-term investment platform that facilitates income generation for clients through crowd-funding property acquisitions, rentals and sales.</p>
												<p>Think of VICTA as a web-based "Super Stokvel" that makes use of technology to expand access, create additional community value, and grow the capacity of South Africans to generate passive income from collective investments.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service2">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How do I benefit from the VICTA platform?</b></h4>
												<p>When you, the client, purchase a VICTA contract, that VICTA entitles you to profits earned on income generated by VICTA Investments through its property holdings.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service3">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How do I keep track of profits earned from my VICTA contracts?</b></h4>
												<p>The VICTA platform has a dashboard facility that provides an insightful overview of the state of your personal VICTA account as well as the state of the overall VICTA platform.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How does VICTA ensure profit targets are achieved?</b></h4>
												<p>The VICTA team invests primarily in property. This means that most investments are made against physical property.</p>
												<p>Also, the VICTA team invests primarily in rental properties situated in busy cities and city districts; this ensures the highest occupancy rates, which, in turn, ensures maximized profits.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>What guarantees are there that investor funds will be safe?</b></h4>
												<p>As stated before, the VICTA team invests primarily in property purchases and rental incomes. Therefore investor funds are backed up by income-generating, physical property.</p>
												<p><b>While a VICTA contract  does not give clients rights of ownership over or rights to claim against VICTA porperties, VICTAs do entitle clients to incomes generated from those properties</b>.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How does VICTA generate profits?</b></h4>
												<p>VICTA invests in property that will ultimately generate rental income that will be used to secure investors’ VICTA purchases and agreements.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service6">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>When are profits generated, accrued and assigned to my account?</b></h4>
												<p>Profits are generated or accrued monthly and thus allocated to your account monthly according to your VICTA contract purchases.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service7">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>Can I withdraw my initial investment?</b></h4>
												<p>Once deposited to your VICTA account your initial investment can no longer be withdrawn. When you use your VICTA purchase credit is used to purchase a VICTA contract, the initial investment amount is earned back after 21 months. After 21 months, your VICTA contracts are generating profits.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service8">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How do I withdraw funds?</b></h4>
												<p>
												When you are logged in, go to the “Transactions” page. Under the “Withdraw” tab, you will see:<br/>
												- Your current balance available for withdrawal.<br/>
												- The banking details that you have provided, that any withdrawals will be directed to.<br/>
												- The amount field in which you enter the amount you wish to withdraw.<br/>
												
												Enter the amount of money you wish to withdraw and select the “Withdraw ZAR Amount” button. If the withdrawal amount requested is available in your account, then your withdrawal request will be processed.
												</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service9">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How do you calculate the profits on my VICTA contracts?</b></h4>
												<p>We calculate profits on VICTA contracts based on the VICTA contracts you have purchased. Taking the cost of a VICTA, multiplied by the stated profit margin percentage, will give you your monthly expected profits. Profits on VICTAS are calculated individually for each VICTA contract.</p>
												<p>Profits are calculated monthly and credited to your current account balance at the end of every 30.5 days (our calculation estimate of for a VICTA month.)</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service10">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>Are there any risks associated with VICTA investments?</b></h4>
												<p>When dealing with investments there is always some level of risk, just as there is always some level of risk with any business venture. 
													However, there are a few simple ways to reduce the risk of losing more than you can afford to. <br/>
													1.	Align your investments with your financial goals. <br/>
													2.	Never invest more money than you can afford to lose. <br/>
													3.	It's important for you to remember that Victa Investments invests primarily and almost exclusively in rent-generating property. This means that risk is minimized due to the stable nature of the investment type. <br/>
												</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title asd">
								<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><b>Buying and earning with VICTAs</b><span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" style="height: 0px;">
							<div class="panel-body panel_text">
								<div class="scrollbar" id="style-2">
									<div class="in-info">
										<div class="service1">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>Can I purchase more than one VICTA?<b></h4>
												<p>Yes. You can buy more than one VICTA at a time or over time. You can buy as many VICTAS as you wish, so long as your available purchase credit balance allows. </p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service2">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How do I purchase a VICTA?<b></h4>
												<p>	
													1.	To purchase a VICTA:<br/>
													2.	Go to the “Transactions” page<br/>
													3.	Select the “VICTAS” tab<br/>
													4.	Under the “VICTAS” tab, in the amount field, enter the amount of money you wish to spend on your purchase<br/>
													5.	Under the “Select VICTA Type” drop-down, select the VICTA contract you wish to purchase<br/>
													6.	Select the “BUY VICTAs” button<br/>
												</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service3">
											<div class="col-md-10 col-sm-10 s-text">
												<h4><b>How do I load VICTA purchasing credit?<b></h4>
												<p>
													1.	Please follow the steps below to load purchase credit to your VICTA account<br/>
													2.	Go to the “Profile” page and click on the “Deposit Information” tab.<br/>
													3.	Under “DEPOSIT DETAILS” tab, take note of the banking details provided (bank, bank account number, branch code, reference code).<br/>
													4.	Make a deposit via direct deposit or EFT to the bank details noted under “DEPOSIT DETAILS”.<br/>
													5.	Once the deposit is processed by the banks and reflects as per the bank details and reference code, your VICTA purchase credit account will be credited with the deposited amount and will be displayed under your profile information as well as on the dashboard.<br/>
													6.	You will now be able to make VICTA purchases equal to the amount deposited.<br/>
												</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
											<h4><b>How do I provide my banking details for withdrawals?<b></h4>
												<p>To provide the VICTA platform with your banking details for withdrawal purposes:<br/>
													1.	Go to the VICTA prolfe page<br/>
													2.	Under the “KYC Information” tab, provide your banking details, including:<br/>
													•	Front image of your SA ID<br/>
													•	Bank image of your SA ID<br/>
													•	Front image of your bank card<br/>
													•	Banking details (bank name, branch code, account number, account holder)<br/>
													3.	Select the submit button, all provided information will be saved<br/>
													<b>Please note: only personal accounts will be accepted, business accounts will not be accepted.</b><br/>
												</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
											<h4><b>What is the minimum and maximum withdrawal sum?<b></h4>
												<p>The minimum sum available for withdrawal is R100.00. There is no limit on the maximum withdrawal.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
											<h4><b>How long does it take for my deposit to be added to my account?<b></h4>
												<p>Your account will be updated promptly after the funds are received and confirmed by the bank.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
											<h4><b>What payment options are accepted to credit my purchase account balance?<b></h4>
												<p>Only payments/deposits made via EFT or direct deposit are accepted. And please remember to use your reference code as instructed to minimize delays.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
											<h4><b>After I make a withdrawal request, when will the funds be available in my private bank account?<b></h4>
												<p>Withdrawal requests are usually processed within several hours during work hours.
													However, in some cases, it may take between 2 and 3 business days for the funds to be credited to your account from successful request.</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
										<div class="service4">
											<div class="col-md-10 col-sm-10 s-text">
											<h4><b>Is there a minimum investment amount?<b></h4>
												<p>The minimum investment amount depends on the VICTA contract tiers made available form time to time. New VICTA contract tiers may be added 
													by management which may be lower than the current lowest VICTA contracts or may be higher than the current highest VICTA contracts. 
													To see what VICTA products are available, go to the about page and view what products are available</p>
											</div>
											<div class="clearfix"></div>
										</div><br/>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title asd">
									<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><b>Other VICTA Queries</b><span class="glyphicon glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
									</a>
								</h4>
							</div>
							<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body panel_text">
									<div class="scrollbar" id="style-2">
	                                    <div class="in-info">
											<div class="service1">
												<div class="col-md-10 col-sm-10 s-text">
													<h4><b>Can I create several accounts?<b></h4>
													<p>As a security and internal security standard, only one account is allowed per South African ID. </p>
												</div>
												<div class="clearfix"></div>
											</div><br/>
											<div class="service2">
												<div class="col-md-10 col-sm-10 s-text">
													<h4><b>Can I change my password after registration?<b></h4>
													<p>Yes, it is possible to change your password after registration. Go to the profile page, under settings, select the “Profile Information” tab, under the heading “RESET PASSWORD”.</p>
												</div>
												<div class="clearfix"></div>
											</div><br/>
											<div class="service3">
												<div class="col-md-10 col-sm-10 s-text">
													<h4><b>How do I change my password after registration?<b></h4>
													<p>
														1.	On the profile page, under “Settings”, select the “Profile Information” tab.<br/>
														2.	Under the heading “RESET PASSWORD”, enter the new desired password in the password field, then retype the password in the “retype password” field.<br/>
														3.	Once a new password has been entered and retyped, you must select the “Reset Password” button.<br/>
														4.	After selecting the “Reset Password” button, a verification code will be sent to your email.<br/>
														5. 	Enter the verification code you received in your email into the verification code field under the “Profile Information” tab, then select the “verify password” button.<br/>
														If the code is correct your new password will be successfully changed.<br/></p>
												</div>
												<div class="clearfix"></div>
											</div><br/>
											<div class="service4">
												<div class="col-md-10 col-sm-10 s-text">
												<h4><b>What if I forgot my password?<b></h4>
													<p>
														If you have lost or forgotten your password:<br/>
														1.	Click on the “forgot my password” link on the login page. <br/>
														2.	Provide the email address of the user in question.<br/>
														3.	A random-generated login password will be emailed to you.<br/>
														4.	Using this password emailed to you, you’ll be able to login.<br/>
													</p>
												</div>
												<div class="clearfix"></div>
											</div><br/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>			
	<!-- services-bottom -->
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
				 
				<h3>Total Deposited (BTC)</h3>
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
	</body>
<!-- //Body -->
</html>