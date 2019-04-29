<?php
	session_start();
	// session_unset();
	
	include_once '../phpViews/Handler_Calulator.php';
	include_once '../phpViews/Handler_NavMenus.php';
	include_once '../phpViews/Handler_AdminUsers.php';
	include_once '../phpViews/Handler_Users.php';
	include_once '../phpObjects/KYC_AML.php';
	

	$AdminUID;
	$bankDetailsMsg = '';
	$NavigationHandler =  new NavigationHandler();
	$CalculationHandler = new CalculationHandler();
	$AdminUserHandler = new AdminUserHandler();
	$NavigationHandler -> inSessionAdminNav();
	$navMenu = $NavigationHandler->getMenu();

	if(isset($_SESSION["ADMIN_ID"])){
		$AdminUserHandler ->selectAdminUserByAuid($_SESSION["ADMIN_ID"]);
		if($AdminUserHandler->getRecordCount() > 0){
			$AdminUID = $_SESSION["ADMIN_ID"];


			$CalculationHandler->CalculateUserDeposits($AdminUID);
			$CalculationHandler->CalculateUserWithdrawals($AdminUID);
			$CalculationHandler->calculateTotalUserDepositEarnings($AdminUID);
		}else{
			unset($_SESSION["ADMIN_ID"]);
			header("Location: logout.php");
		}
	}else{
			unset($_SESSION["ADMIN_ID"]);
			header("Location: logout.php");
	}
	
	if(isset($_POST['kycSubmit'])){
		if($Kyc_Aml->getRecordCount() < 1){			
		$Kyc_Aml->createInitialKYC($_POST['Name'], $_POST['Surname'], $_POST['IdentityNumber']);
		}else{
			$Kyc_Aml->updateInitialKyc($_POST['Name'], $_POST['Surname'], $_POST['IdentityNumber']);
		}
		if(isset($_POST["BankName"])&&isset($_POST["BankBranch"])&&
			isset($_POST["AccountNumber"])&&isset($_POST["AccountHolder"])){
		//update bank details
			$Kyc_Aml->updateKycBankName($_POST["BankName"]);
			$Kyc_Aml->updateKycBankBranch($_POST['BankBranch']);
			$Kyc_Aml->updateKycAccNo($_POST['AccountNumber']);
			$Kyc_Aml->updateKycAccHolder($_POST['AccountHolder']);

			$bankDetailsMsg = "Success";
			}else{
				$bankDetailsMsg = "Bank details incomplete";
			}

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
			<h3>Settings</h3>
			<div class="border"> </div>
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Profile Information</a></li>
						<li role="presentation" class=""><a href="#Feature1" role="tab" id="Feature1-tab" data-toggle="tab" aria-controls="Feature1" aria-expanded="false">KYC Information</a></li>
						<li role="presentation" class=""><a href="#Feature2" role="tab" id="Feature2-tab" data-toggle="tab" aria-controls="Feature2" aria-expanded="false">Account Information</a></li>
						<li role="presentation" class=""><a href="#Feature3" role="tab" id="Feature3-tab" data-toggle="tab" aria-controls="Feature3" aria-expanded="false">Security</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
							<div class="w3agile_tabs">
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right2">
									<img src="images/2.jpg" alt=" " class="img-responsive">
								</div>
								<div class="col-md-7 w3agile_tab_left contact-w3-agileits">
									<h4>Profile Information</h4>
									<?php
									?>
									<p> Email:
									<?php 
									?>
									</p>
									<p> First Name: 
									<?php 
									?>
									</p>
									<p> Last Name:  
									<?php 
									?></p>
									<p> Password: Hidden <input type="submit" value="Reset Password"></p> 
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
										<p>Upload ID front: <input type="hidden" name="MAX_FILE_SIZE" value="50000*" /></p>
										<p><input type="file" name="id_front" /></p>
										<p>Upload ID back: <input type="hidden" name="MAX_FILE_SIZE" value="50000*" /></p>
										<p><input type="file" name="id_back" /></p>
									<p><input type="text" name="BankName" placeholder="Bank Name*" required=""></p>
									<p><input type="text" name="BankBranch" placeholder="Branch Code*" required=""></p>
									<p><input type="text" name="AccountNumber" placeholder="Account Number*" required=""></p>
									<p><input type="text" name="AccountHolder" placeholder="Account Holder (Name on front of card)*" required=""></p>
										<p>Upload Bank Card Image:<input type="hidden" name="MAX_FILE_SIZE" value="50000*" /></p>
										<p><input type="file" name="id_selfie" /></p>
										<p>
										<input type="Submit" name="kycSubmit" value="Submit"><br/>
										<?php echo $bankDetailsMsg; ?>
										</p>
									</form>
								</div>
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right1">
									<img src="images/3.jpg" alt=" " class="img-responsive">
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="Feature2" aria-labelledby="Feature2-tab">
							<div class="w3agile_tabs">
								<div class="col-md-5 w3agile_tab_right w3agile_tab_right2">
									<img src="images/4.jpg" alt=" " class="img-responsive">
								</div>
								<div class="col-md-7 w3agile_tab_left">
									<h4>Account Information</h4>
									
									<p> erat ut odio euismod accumsan. 
										Phasellus libero tellus, pulvinar vitae sem sit amet, 
										faucibus consectetur neque.</p>
										
										<p><b>Verification</b><br/>
										Email verified: Yes<br/>
										Compliance verified: Yes</p>
										
										<b>Account Summary</b><br/>
										<p>
										Total deposits value (BTC): 
										<?php
										?><br/>
										Total deposits value (ZAR): <?php
										?><br/></p>
										
										<p>
										<!--Total withdrawals value (BTC): 
										<?php 
										//echo $CalculateUserWithdrawals->getUserBtcWithdrawals()." BTC";
										?><br/>-->
										Total withdrawals value (ZAR): <?php ?>
										<br/></p>
										
										<p>
										<!--Total earned to date (BTC): 
										<?php 
										//echo $CalculateUserTotalEarned->getBtcUserDepositEarnings()."BTC";
										?><br/>-->
										Total earned to date (ZAR): 
										<?php 
										?><br/></p>

										<p>
										<!--Current account (BTC): 
										<?php
										?><br/>-->
										Current account (ZAR): 
										<?php 
										?><br/></p>
										
										<p><b>Banking Details</b><br/>
										
										Bank: 
										<?php 
										?><br/>
										Account no.: 
										<?php
										?><br/>
										Bank Branch: 
										<?php
										?></br>
										Account Holder: 
										<?php
										?></p>
									
								</div>
								<div class="clearfix"> </div>
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
	<div class="services-bottom">
		<div class="container">
						<div class="col-md-3 agileits_w3layouts_about_counter_left">
				<p class="counter">
					<?php
					
						$CalculateUsers = new CalculateUsers();
					?>	
				</p> 
				<i class="glyphicon glyphicon-user" aria-hidden="true"></i>
				
				<h3>Total Users</h3>
			</div>
			<div class="col-md-3 agileits_w3layouts_about_counter_left">
				<p class="counter">
					<?php
						$CalculateGlobalWithdrawals = new CalculateGlobalWithdrawals();
					?>
				</p> 
				<i class="fa fa-file-text-o" aria-hidden="true"></i>
				
				<h3>Total Withdrawn (BTC)</h3>
			</div>
			<div class="col-md-3 agileits_w3layouts_about_counter_left">
				<p class="counter">
					<?php
					$CalculateGlobalDeposits = new CalculateGlobalDeposits();
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