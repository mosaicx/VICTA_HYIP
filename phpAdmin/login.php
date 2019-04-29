<?php
	session_start();
	//instantiation of classes
	include_once '../phpViews/Handler_AdminUsers.php';
	include_once '../phpViews/AdminNavMenu.php';

	
	$AdminNavMenu =  new AdminNavMenu();
	$AdminUserHandler = new AdminUserHandler();
	$navMenu = '';
	$loginMessage = '';
	if(isset($_SESSION["ADMIN_ID"])){
		$AdminUserHandler ->selectAdminUserByAuid($_SESSION["ADMIN_ID"]);
		if($AdminUserHandler->getRecordCount() > 0){
			header("Location: user_deposit_keying.php");
			$AdminNavMenu -> LoginAdminNav();
			$navMenu = $AdminNavMenu->getMenu();
		}else{
			$AdminNavMenu -> LoginAdminNav();
			$navMenu = $AdminNavMenu->getMenu();
		}
	}else{
		$AdminNavMenu -> LoginAdminNav();
		$navMenu = $AdminNavMenu->getMenu();
	}
	
	if(isset($_GET['LoginUser'])){
		$Username = $_GET['Username'];
		$Password = $_GET['Password'];
		$AdminUserHandler->selectAdminUsernamePass($Username, sha1($Password));
		if($AdminUserHandler->getRecordCount() > 0){
			$_SESSION["ADMIN_ID"]= $AdminUserHandler->getUID();		
			if(isset($_SESSION["ADMIN_ID"]) && $_SESSION["ADMIN_ID"] == $AdminUserHandler->getUID()){
				header("Location: user_deposit_keying.php");
				$loginMessage = "Login Success";
			}
		 }else{
			$loginMessage = "The credentials provided do not match any records. Please try again or <a href='register.php'>Register</a>.";
		}
	}
	?>

<html>
<!-- Head -->
<head>
	<title>VICTA ADMIN | LOGIN</title>
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
				<h2 class="w3ls_head">Login</h2>
					<div class="col-md-8 contact-w3layouts-left">
						<form action="#" method="get" name='UserLoginForm' id='UserLoginFrmId'>

							<p>Login to access admin features and tools</p>
							<br/>
							<p><input type="text" name="Username" placeholder="Username*" required=""></p>
							<br/>
							<p><input type="password" name="Password" placeholder="Password*" required=""></p>
							<br/>
							<input type='submit' name='LoginUser' value='Login' id='btnLoginID'/><br/>

							<?php echo $loginMessage; ?>
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

	<!-- //contact -->

	<!-- footer -->

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