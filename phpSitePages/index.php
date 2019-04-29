<?php
	session_start();
	include_once '../phpViews/Handler_Calulator.php';
	include_once '../phpViews/Handler_NavMenus.php';
	include_once '../phpViews/Handler_Users.php';
	include_once '../phpViews/Handler_Session.php';
	
	$SessionHandlers = new SessionHandlers();
	$navMenu;
	$NavigationHandler = new NavigationHandler();
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
	<div class="agileits-abt">
		<div class="container">
			<h2 class="w3ls_head">Welcome To VICTA</h2>
			<p>The most convenient online investment platform catering for South Africans looking to grow the value of their money through collective, crowd-funded property investments.</p>
		</div>
	</div>
	<!-- //banner -->
	<!-- banner-bottom -->
	<div class="w3layouts-banner-bottom">
		<div class="container">
			<div class="col-md-3 agileits-bottom-top">
				<h3>Steady Returns<br><span></span><br></h3>
			</div>
			<div class="col-md-3 agileits-bottom-top">
				<h3>Guaranteed ROI<br><span></span><br></h3>
			</div>
			<div class="col-md-3 agileits-bottom-top">
				<h3>Intuitive Interface<br><span></span><br></h3>
			</div>
			<div class="col-md-3 agileits-bottom-top">
				<h3>Empowering Clients<br><span></span><br></h3>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- //banner-bottom -->
	<!-- welcome -->
	<div class="wthree-welcome">
		<div class="container">
			<h2>Investing For the Future</h2>
			<div class="border"> </div>
			
			<div class="col-md-6 wthree-welcome-left">
			<p>
				VICTA is an online investment platform that gives users access to fantastic investment opportunities. We create an environment that lets you buy virtual investment contracts.
			</p><br/>
			<p>
				Virtual Investment Contractual Tacit Agreements (VICTAs) are tacit agreements between the platform investment team (us) and its clients (you). These agreements ensure that the money you invest, along with the money other clients invest, 
				collectively goes to the establishment of investment vehicles that will generate profits for you while you eat, sleep and carry on with life as usual.
			</p><br/>
			<p>
				We are an investment innovation platform, not a Ponzi Scheme. VICTA business policy is that of making investments and managing portfolios and giving clients access to means of production via short-, mid- and long-term contracts designed to generate passive incomes for investors.
			</p>

			</div>
			<div class="col-md-6 wthree-welcome-right">
				<img class="img-responsive" src="images/1.png" alt=" ">
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- //welcome -->
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