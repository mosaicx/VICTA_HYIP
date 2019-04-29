<?php
	session_start();
	//instantiation of classes
	include_once '../phpViews/Handler_Users.php';
	include_once '../phpViews/Handler_NavMenus.php';
	include_once '../phpViews/Handler_Session.php';
	
	$navMenu;

	$NavigationHandler = new	NavigationHandler();
	$NavigationHandler->footerMenu();
	$footerMenu= $NavigationHandler->getMenu();
	
	$UserHandler = new UserHandler();
	$SessionHandler = new SessionHandlers();
	if($SessionHandler->isValidSession()){
		$SessionHandler->unsetSession();
	}else{
		$NavigationHandler->loggedOutUserNav();
		$navMenu =	$NavigationHandler->getMenu();
	}

	$loginMessage = '';
	if(isset($_GET['sendNewPassword'])){
		if(!$SessionHandler->isValidSession()){
			$email = $_GET['email'];
			$UserHandler->selectUserByEmail($email);
			
			if($UserHandler->getRecordCount() > 0){
				$loginMessage = $UserHandler->resetPassword($email);
			}else{
				$loginMessage = "The email selected is not registered please try a different email or opt to <a href='login.php'>login</a> or <a href='register.php'>register</a>";
			}			
		}
	}
 ?>

	<html>
<!-- Head -->
<head>
	<title>Associate a Corporate Business Category Flat Bootstrap Responsive Website Template | Contact :: W3layouts</title>
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
	<div class="w3agile_services_grids">
		<div class="col-md-4 agileinfo_services_grid">
			<div class="agileinfo_services_grid1">
				<h4>Traditional deposit options</h4>
				<p>Deposits can be made via EFT or direct deposit</p>
				<div class="agileinfo_services_grid1_pos">
					<span class="glyphicon" aria-hidden="true"></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 agileinfo_services_grid">
			<div class="agileinfo_services_grid1">
				<h4>Convenient withdrawals</h4>
				<p>Request a withdrawal of your profits via the transactions panel</p>
				<div class="agileinfo_services_grid1_pos">
					<span class="glyphicon " aria-hidden="true"></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 agileinfo_services_grid">
			<div class="agileinfo_services_grid1">
				<h4>All the numbers that matter</h4>
				<p>Track your investments from the convenient dashboard</p>
				<div class="agileinfo_services_grid1_pos">
					<span class="glyphicon " aria-hidden="true"></span>
				</div>
			</div>
		</div>
	<div class="clearfix"> </div>
	</div>
	<div class="w3agile_services_grids">
		<div class="col-md-4 agileinfo_services_grid">
			<div class="agileinfo_services_grid1">
				<h4>Manage your profile</h4>
				<p>Manage KYC information, manage banking details and keepinhg track of balances and credits</p>
				<div class="agileinfo_services_grid1_pos">
					<span class="glyphicon " aria-hidden="true"></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 agileinfo_services_grid">
			<div class="agileinfo_services_grid1">
				<h4>Invest with ease</h4>
				<p>Investing with us is as easy as making a depositing and buying a Virtual Investment Contractual Tacit Agreement (VICTA)</p>
				<div class="agileinfo_services_grid1_pos">
					<span class="glyphicon" aria-hidden="true"></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 agileinfo_services_grid">
			<div class="agileinfo_services_grid1">
				<h4>Collective investments</h4>
				<p>We use client funds to crowd fund investment opportunities for income generation</p>
				<div class="agileinfo_services_grid1_pos">
					<span class="glyphicon " aria-hidden="true"></span>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
	
	<!-- //Header -->
	</div>
	<!-- //banner -->
	<!-- contact -->
	<div class="agileits-con">
		<div class="contact-w3-agileits">
			<div class="container">
				<h2 class="w3ls_head">Reset Password</h2>
					<div class="col-md-8 contact-w3layouts-left">
						<form action="#" method="get" name='UserLoginForm' id='UserLoginFrmId'>

							<p>Please provide your email address to receive a new password. This password can then be reset once logged in.</p>
							<br/>
							<p><input type="email" name="email" placeholder="Email*" required=""></p>
							<br/>
							<input type='submit' name='sendNewPassword' value='Reset Password' id='btnLoginID'/><br/>

							<?php echo $loginMessage; ?>
						</form>
					</div>	
					<div class="col-md-4 contact-w3layouts-right">
						<ul>
							<img src="images/g22.png" alt=""></li>
						</ul>
					</div>
					<div class="clearfix"></div>
			</div>
		</div>
	</div>

	<!-- //contact -->

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