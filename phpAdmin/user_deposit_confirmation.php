<?php
	session_start();
	// session_unset();
	
	include_once '../phpViews/Handler_Calulator.php';
	include_once '../phpViews/Handler_Users.php';
	include_once '../phpViews/Handler_Deposits.php';
	include_once '../phpViews/Handler_AdminUsers.php';
	include_once '../phpViews/Handler_NavMenus.php';
	
	$bankDetailsMsg = '';
	$NavigationHandler =  new NavigationHandler();
	$AdminUserHandler = new AdminUserHandler();
	$DepositHandler = new DepositHandler(); 
	$pendingDeposits = '';
	$AdminUID = '';
	$navMenu = '';
	
	if(isset($_SESSION["ADMIN_ID"])){
		$DepositHandler->SelectGlobalPendingDeposits();
		$pendingDeposits = $DepositHandler->getRecordsTable();

		$AdminUserHandler ->selectAdminUserByAuid($_SESSION["ADMIN_ID"]);
		if($AdminUserHandler->getRecordCount() > 0){
			$AdminUID = $_SESSION["ADMIN_ID"];
			$NavigationHandler -> inSessionAdminNav();
			$navMenu = $NavigationHandler->getMenu();
			if(isset($_POST["confirmSubmit"])){
				if($DepositHandler -> UpdateDepositConfirmation($AdminUID, $_POST['tx_id']) == 'SUCCESS'){
					header("Location: user_deposit_confirmation.php");
					$bankDetailsMsg = 'Deposit confirmed. '. $_POST['tx_id'];
				}else{
					$bankDetailsMsg = 'Failed to confirm deposit';
				}
			}
		}else{
		}
	}else{
		header("Location: logout.php");
	}
?>
<html>
<!-- Head -->
<head>
	<title>Associate a Corporate Business Category Flat Bootstrap Responsive Website Template | Home :: W3layouts</title>
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
	<div class="w3l-banner">
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
								<h1><a class="navbar-brand" href="index.html">Associate</a></h1>
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
			<h3>Bank Deposit Confirmation</h3>
			<div class="border"> </div>
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Profile Information</a></li>
						<li role="presentation" class=""><a href="#Feature3" role="tab" id="Feature3-tab" data-toggle="tab" aria-controls="Feature3" aria-expanded="false">Security</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
							<div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left contact-w3-agileits">
									<h4>Confirm User Deposits</h4>
									<p>
										
											<table class="deposits_table" width="177">
												<tr><th> Transaction  Date </th><th > Transaction  Amount </th><th> Transaction  Status </th><th> Transaction  ID </th><th> Transaction  Reference </th><th> Admin Action</th></tr>
												<?php 
													echo $pendingDeposits;
												?>
											</table><br/>
												<?php 
													echo $bankDetailsMsg;
												?>
									</p>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature3" aria-labelledby="Feature3-tab"><div class="w3agile_tabs">
								<div class="col-md-7 w3agile_tab_left">
									<h4>faucibus consectetur </h4>
									<p> Cras consectetur tempus lectus id accumsan. Vivamus gravida justo mattis ex pretium, eu sollicitudin tortor ullamcorper. Quisque vitae diam molestie, tincidunt velit vitae, viverra nisl. Mauris ultrices commodo imperdiet. In urna odio, semper nec est non, pulvinar molestie quam. Etiam egestas varius nunc et rutrum. Curabitur tempor lacinia pharetra. Ut laoreet urna sed risus consequat laoreet. In volutpat sollicitudin volutpat. eget auctor eros 
										ultrices. Vestibulum non erat ut odio euismod accumsan. 
										Phasellus libero tellus, pulvinar vitae sem sit amet, 
										faucibus consectetur neque.</p>
									
								</div>
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right1">
									<img src="images/5.jpg" alt=" " class="img-responsive">
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
	<!-- //features-->
<!-- services-bottom -->
	<!-- footer -->
	<div class="footer-top">
		<div class="container">
		<div class="col-md-5 w3l-footer-top">
				<h3>NEWSLETTER</h3>
				<p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit reprehenderit qui in ea.</p>

					<form action="#" method="post" class="newsletter">
						<input class="email" type="email" placeholder="Your email..." required="">
						<input type="submit" class="submit" value="">
					</form>
					
			</div>
			
			<div class="col-md-5 wthree-footer-top">
				<h3>About</h3>
					<p>Cras consectetur tempus lectus id accumsan. Vivamus gravida justo mattis ex pretium, eu sollicitudin tortor ullamcorper. Quisque vitae diam molestie, tincidunt velit vitae, viverra nisl. Mauris ultrices commodo imperdiet. </p>
			</div>
			<div class="col-md-2 w3ls-footer-top">
				<h3>Options</h3>
					<ul>
						<li><a class='active' href='index.php'>Home</a>
						</li><li><a href='about.php'>About</a></li>
						<li><a href='profile.php'>Profile</a></li>
						<li><a href='dashboard.php'>Dashboard</a></li>
						<li><a href='transactions.php'>Transactions</a></li>
						<li><a href='register.php'>Register</a></li>
						<li><a href='login.php'>Login</a></li>
						</ul>
			</div>
			
				<div class="clearfix"></div>
			
		</div>
	</div>
	<div class="footer-w3layouts">
		<div class="container">
				<div class="agile-copy">
					<p>© 2016 Associate. All rights reserved | Design by <a href="http://w3layouts.com/">W3layouts</a></p>
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