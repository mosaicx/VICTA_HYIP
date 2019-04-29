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
	$UserHandler = new UserHandler();
	$CalculationHandler = new CalculationHandler();
	$CalculationHandler->calculateUsers();
	$NavigationHandler->footerMenu();
	$footerMenu= $NavigationHandler->getMenu();
	
	if($SessionHandlers->isValidSession()){
		$NavigationHandler->loggedInUserNav();
	}else{
		$NavigationHandler->loggedOutUserNav();
	}
	$navMenu =	$NavigationHandler->getMenu();
	
	if(isset($_POST["submitVictaEntra"])){
		if(isset($_POST["entraAmount"])){
			if($_POST["entraAmount"] % 500){
				$submitVictaEntraMsg = 'Please enter a valid amount. Multiples of 500';
			}else{
				$submitVictaEntraMsg = 'Expected returns: R';

				$investmentCalculation = $CalculationHandler->calculatePotentialEarnings(1, 35, $_POST["entraAmount"]);
				
				$submitVictaEntraMsg .= $investmentCalculation;
			}
		}
	}

	if(isset($_POST["submitVictaIntermida"])){
		if(isset($_POST["intermidaAmount"])){
			if($_POST["intermidaAmount"] % 1500){
				$submitVictaIntermidaMsg = 'Please enter a valid amount. Multiples of 1500';
			}else{
				$submitVictaIntermidaMsg = 'Expected returns: R';

				$investmentCalculation = $CalculationHandler->calculatePotentialEarnings(1, 40, $_POST["intermidaAmount"]);
				
				$submitVictaIntermidaMsg .= $investmentCalculation;
			}
		}
	}

	if(isset($_POST["submitVictaMajor"])){
		if(isset($_POST["majorAmount"])){
			if($_POST["majorAmount"] % 5000){
				$submitVictaMajorMsg = 'Please enter a valid amount. Multiples of 5000';
			}else{
				$submitVictaMajorMsg = 'Expected returns: R';

				$investmentCalculation = $CalculationHandler->calculatePotentialEarnings(1, 50, $_POST["majorAmount"]);
				
				$submitVictaMajorMsg .= $investmentCalculation;
			}
		}
	}

	if(isset($_POST["submitVictaPerpetua"])){
		if(isset($_POST["perpetuaAmount"])){
			if($_POST["perpetuaAmount"] % 10000){
				$submitVictaPerpetuaMsg = 'Please enter a valid amount. Multiples of 10000';
			}else{
				$submitVictaPerpetuaMsg = 'Expected returns: R';

				$investmentCalculation = $CalculationHandler->calculatePotentialEarnings(1, 60, $_POST["perpetuaAmount"]);
				
				$submitVictaPerpetuaMsg .= $investmentCalculation;
			}
		}
	}


?>
<html>
<!-- Head -->
<head>
	<title> ABOUT VICTA</title>
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
	<!-- //banner -->
	<!-- about -->
	<div class="agileits-abt">
		<div class="container">
			<h2 class="w3ls_head">About</h2>
			<div class="ab-top">
				<div class="col-md-6 ab-w3ls-left">
					<img src="images/9.png" class="img-responsive" alt="img">
				</div>
				<div class="col-md-6 ab-w3ls-right">
					<h4>A NEW WAY OF INVESTING</h4>
					<p>Virtual Investment Contractual Tacit Agreements (or VICTAs) are an innovation based on mutual trust, relationship building and ethical well-meaning.</p>
					<p>You choose the VICTA you wish to invest in, you make a deposit to your account using the relevant reference used to identify your account. Select the VICTA you wish to invest in. Buy your VICTA of choice. Watch your investment grow. There is no limit to the number of VICTAs you can buy.</p>
				</div>
				<div class="clearfix"></div>
			</div>
			<!-- team -->
			<div class="team agileits">
				<div class="team-info">
					<h3 class="w3ls_head">Products</h3>  
						<div class="team-row">
							<div class="col-md-3 team-grids">
								<div class="team-agile-img"> 
									<a href="#"><img src="images/t1.pNg" alt="img"></a>
										<div class="view-caption">
												<ul>
													<li><span></span></a></li>
												</ul>
										</div> 
							
								</div>
									<form action="#" method="post" name='VictaEntraForm' id='VictaEntraFormId'>
									
									<h4>VICTA ENTRA <br/>(Available Now)</h4>
									<p>Average 5% returns per month</p>
									<p>Investment period of 35 months</p>
									<p>R500 per VICTA</p>
									<p>Minimum of 1 VICTA</p>
									<p>
										<input type="text" name="entraAmount" placeholder="ZAR Amount"><b> </b><br/><br/>
										<input type="Submit" name="submitVictaEntra" value="Calculate Returns">
									</p>
									<?php echo $submitVictaEntraMsg; ?>
												
									</form>								
							</div>					
							<div class="col-md-3 team-grids">
								<div class="team-agile-img"> 
									<a href="#"><img src="images/t2.png" alt="img"></a>
									<div class="view-caption">
										<ul>
											<li><span></span></a></li>
										</ul>
									</div>    
								</div>
								<form action="#" method="post" name='VictaIntermidaForm' id='VictaIntermidaFormId'>
									
									<h4>VICTA INTERMIDA <br/>(Coming Soon)</h4>
									<p>Average 5% returns per month</p>
									<p>Investment period of 40 months</p>
									<p>R1500 per VICTA</p>
									<p>Minimum of 2 VICTAs</p>
									<p>
										<input type="text" name="intermidaAmount" placeholder="ZAR Amount"><b> </b><br/><br/>
										<input type="Submit" name="submitVictaIntermida" value="Calculate Returns">
									</p>
									<?php echo $submitVictaIntermidaMsg; ?>		
								</form>
							</div>
							<div class="col-md-3 team-grids">
								<div class="team-agile-img"> 
									<a href="#"><img src="images/t3.png" alt="img"></a>
									<div class="view-caption">
										<ul>
											<li><span></span></a></li>
										</ul>
									</div>    
								</div>
								<form action="#" method="post" name='VictaMajorForm' id='VictaMajorFormId'>
									
									<h4>VICTA MAJOR <br/>(Coming Soon)</h4>
									<p>Average 5% returns per month</p>
									<p>Investment period of 50 months</p>
									<p>R5000 per VICTA</p>
									<p>Minimum of 3 VICTAs</p>
									<p>
										<input type="text" name="majorAmount" placeholder="ZAR Amount"><b> </b><br/><br/>
										<input type="Submit" name="submitVictaMajor" value="Calculate Returns">
									</p>
									<?php echo $submitVictaMajorMsg; ?>
												
								</form>
							</div>
							<div class="col-md-3 team-grids">
								<div class="team-agile-img"> 
									<a href="#"><img src="images/t4.png" alt="img"></a>
									<div class="view-caption">
										<ul>
											<li><span></span></a></li>
										</ul>
									</div>    
								</div>
								<form action="#" method="post" name='VictaPerpetuaForm' id='VictaPerpetuaFormId'>
									
									<h4>VICTA PERPETUA <br/>(Coming Soon)</h4>
									<p>Average 5% returns per month</p>
									<p>Investment period of 60 months</p>
									<p>R10000 per VICTA</p>
									<p>Minimum of 1 VICTA</p>
									<p>
										<input type="text" name="perpetuaAmount" placeholder="ZAR Amount"><b> </b><br/><br/>
										<input type="Submit" name="submitVictaPerpetua" value="Calculate Returns">
									</p>
									<?php echo $submitVictaPerpetuaMsg; ?>
												
								</form>
							</div>
						</div>
				</div>
			</div>
		<!-- //team -->
		</div>
	</div>
	<!-- //about -->
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