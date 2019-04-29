<?php
session_start();
	//instantiation of classes
include_once '../phpViews/Handler_AdminUsers.php';
include_once '../phpViews/Handler_NavMenus.php';

	$NavigationHandler =  new NavigationHandler();

	$navMenu = '';
	$registerMessage = '';
	if(isset($_SESSION["ADMIN_ID"])){
		$AdminUserHandler = new AdminUserHandler();
		$AdminUserHandler ->selectAdminUserByAuid($_SESSION["ADMIN_ID"]);
		if($AdminUserHandler->getRecordCount() > 0){
			// header("Location: UserDepositKeying.php");
			$NavigationHandler -> inSessionAdminNav();
			$navMenu = $NavigationHandler->getMenu();
		}else{
			session_unset();
			$NavigationHandler -> RegAdminNav();	
			$navMenu = $NavigationHandler->getMenu();
		}
	}else{
		unset($_SESSION["ADMIN_ID"]);
		$NavigationHandler -> RegAdminNav();
		$navMenu = $NavigationHandler->getMenu();

	}

	if(isset($_GET['RegisterUser'])){
		//checked?
		$AdminUserHandler = new AdminUserHandler();
		$AdminUserHandler->selectAdminUserByUsername($_GET['username']);
		
		if($AdminUserHandler->getRecordCount() > 0){
			$registerMessage = "The username selected is already in use, please try a different username or <a href='login.php'>Login</a>";
		}else{
			$registerMessage = $AdminUserHandler->CreateAdminUser($_GET['name'], $_GET['surname'], $_GET['username'], sha1($_GET['password']), $_GET['clearance_level']);
		}
	}
	?>
<html>
<!-- Head -->
<head>
	<title>VICTA ADMIN | REGISTER</title>
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
						<h1><a class="navbar-brand" href="index.html">VICTA ADMIN</a></h1>
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
	
		<div class="clearfix"> </div>
	</div>
	
	<!-- //Header -->
	</div>
	<!-- //banner -->
	<!-- contact -->
	<div class="agileits-con">
		<div class="contact-w3-agileits">
			<div class="container">
				<h2 class="w3ls_head">Register</h2>
					<div class="col-md-8 contact-w3layouts-left">
						<form action="#" method="get" name='AdminRegForm' id='AdminRegFrmId'>

							<p>Register to access admin features and tools</p>
							<br/>
							<p><input type="name" name="name" placeholder="First name*" required=""></p>
							<br/>
							<p><input type="surname" name="surname" placeholder="Last name*" required=""></p>
							<br/>
							<p><input type="text" name="username" placeholder="Username*" required=""></p>
							<br/>
							<p><input type="password" name="password" placeholder="User password*" required=""></p>
							<br/>
							<p>
							Clearance level <select name="clearance_level">
								<option value="1">1 (Low)</option>
								<option value="2">2 (Mid)</option>
								<option value="3">3 (High)</option>
								<option value="4">4 (Executive)</option>
							</select>
							</p>
							<br/>
							<input type='submit' name='RegisterUser' value='Register' id='btnRegID'/><br/>
							<?php echo $registerMessage; ?>
						</form>
					</div>	
					<div class="col-md-4 contact-w3layouts-right">
						<ul>
							<img src="images/g2.jpg" alt=""></li>
						</ul>
					</div>
					<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="footer-w3layouts">
		<div class="container">
				<div class="agile-copy">
					<p>© 2016 Associate. All rights reserved | Designed using <a href="http://w3layouts.com/">W3layouts</a> templates</p>
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