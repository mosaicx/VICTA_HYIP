 <?php
	session_start();
	// session_unset();
	include_once '../phpObjects/KYC_AML.php';
	include_once '../phpViews/Handler_AdminUsers.php';
	include_once '../phpViews/Handler_NavMenus.php';

	
	$AdminUID;
	$AdminUserHandler = new AdminUserHandler();
	
	$AUID;
	$NAME;
	$SURNAME;
	$ID_BACK;
	$ID_FRONT;
	$BANK_NAME;
	$ACCOUNT_NO;
	$BANK_CARD_IMG;
	$ACCOUNT_HOLDER;
	$recordCount = '';
	$NavigationHandler =  new NavigationHandler();
	$statusMsg = '';

	if(isset($_SESSION["ADMIN_ID"])){
		$AdminUserHandler ->selectAdminUserByAuid($_SESSION["ADMIN_ID"]);
		 if($AdminUserHandler->getRecordCount() > 0){
			$NavigationHandler -> inSessionAdminNav();			 
			$navMenu = $NavigationHandler->getMenu();
			
			$AdminUID = $_SESSION["ADMIN_ID"];
			$Kyc_Aml = new Kyc_Aml();
			$Kyc_Aml->selectPendingKycDetails();
			if($Kyc_Aml->getRecordCount() > 0){

				$AUID=$Kyc_Aml->getAUID();
				$NAME=$Kyc_Aml->getNAME();
				$ID_PASSPORT=$Kyc_Aml->getID_PASSPORT();
				$SURNAME=$Kyc_Aml->getSURNAME();
				$ID_BACK=$Kyc_Aml->getID_BACK();
				$ID_FRONT=$Kyc_Aml->getID_FRONT();
				$BANK_NAME=$Kyc_Aml->getBANK_NAME();
				$ACCOUNT_NO=$Kyc_Aml->getACCOUNT_NO();
				$BANK_CARD_IMG=$Kyc_Aml->getBANK_CARD_IMG();
				$ACCOUNT_HOLDER=$Kyc_Aml->getACCOUNT_HOLDER();
				$recordCount = $Kyc_Aml->getRecordCount();
			}else{
				$AUID=$Kyc_Aml->getAUID();
				$NAME=$Kyc_Aml->getNAME();
				$ID_PASSPORT=$Kyc_Aml->getID_PASSPORT();
				$SURNAME=$Kyc_Aml->getSURNAME();
				$ID_BACK=$Kyc_Aml->getID_BACK();
				$ID_FRONT=$Kyc_Aml->getID_FRONT();
				$BANK_NAME=$Kyc_Aml->getBANK_NAME();
				$ACCOUNT_NO=$Kyc_Aml->getACCOUNT_NO();
				$BANK_CARD_IMG=$Kyc_Aml->getBANK_CARD_IMG();
				$ACCOUNT_HOLDER=$Kyc_Aml->getACCOUNT_HOLDER();

			}
			
		}else{
			unset($_SESSION["ADMIN_ID"]);
			header("Location: logout.php");
		}
	 }else{
			unset($_SESSION["ADMIN_ID"]);
			header("Location: logout.php");
	}

	if(isset($_GET["submitAccept"])){
		$Kyc_Aml = new Kyc_Aml();
		if($recordCount > 0){
			if($AdminUserHandler ->getClearance() >= 3){
				if($Kyc_Aml->updateKycAcceptStatus($AUID, $_GET['commentText'])){
					header("Location: manage_kyc.php");
				}
			}else{
				$statusMsg = 'Clearance level does not allow the attempted operation.';
			}
		}
	}
	
	if(isset($_GET["submitReject"])){
		if($recordCount > 0){
			if($AdminUserHandler ->getClearance() >= 3){
				$Kyc_Aml = new Kyc_Aml();
				if($Kyc_Aml->updateKycRejectStatus($AUID, $_GET['commentText'])){
					header("Location: manage_kyc.php");
				}
			}else{
				$statusMsg = 'Clearance level does not allow the attempted operation.';
			}
		}
	}


?>
<html lang="zxx">
   <head>
      <title>Make Over an Interior Category Bootstrap Responsive Web Template | Home :: w3layouts</title>
      <!--meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="keywords" content="Make Over Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
         Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
      <script>
         addEventListener("load", function () {
         	setTimeout(hideURLbar, 0);
         }, false);
         
         function hideURLbar() {
         	window.scrollTo(0, 1);
         }
      </script>
      <!--//meta tags ends here-->
      <!--booststrap-->
      <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
      <!--//booststrap end-->
      <!-- font-awesome icons -->
      <link href="css/font-awesome.css" rel="stylesheet">
      <!-- //font-awesome icons -->
      <link href="css/easy-responsive-tabs.css" rel='stylesheet' type='text/css' />
      <!-- easy-responsive-tabs -->
      <link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />
      <!--stylesheets-->
      <link href="css/style.css" rel='stylesheet' type='text/css' media="all">
      <!--//stylesheets-->
      <link href="//fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">
      <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
   </head>
   <body>
      <div class="header-outs">
			<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav ">
				<?php 
					echo $navMenu;
				?>
			</ul>
        </div >

      <!--service -->
      <div class="services" id="services">
         <div class="container">
            <h3 class="title clr">KYC Manager</span></h3>
            <div class="top_tabs_agile">
				<form action="#" method="get" name='UserLoginForm' id='UserLoginFrmId'>
				   <div id="verticalTab" class="top_tabs_agile">
					  <ul class="resp-tabs-list">
						 <li class="resp-tab-item resp-tab-active">
							<span class="fa fa-random" aria-hidden="true"></span>Front ID Image
						 </li>
						 <li class="resp-tab-item" >
							<span class="fa fa-anchor" aria-hidden="true"></span> Back ID Image
						 </li>
						 <li class="resp-tab-item" >
							<span class="fa fa-angellist" aria-hidden="true"></span> Proof of Residence Image
						 </li>
					  </ul>
					  <div class="resp-tabs-container">
						 <div class="tab1">
							<div class="services-right-agileits">
							   <div class="col-md-5 col-sm-5 col-xs-5 img-left">
								  <img <?php echo 'src="'.$ID_FRONT.'"';?>" alt="" class="img-r">
							   </div>

							   <div class="col-md-7 col-sm-7 col-xs-7 ser-img-wthree">
								  <h4>Front ID Image</h4>
								  <p>
								  <?php 
									  echo 			"Name: $NAME<br/>";
									  echo 			"Surname: $SURNAME<br/>";
									  echo 			"ID: $ID_PASSPORT<br/>";
									  ?>
								  </p>
							   </div>
							   <div class="clearfix"> </div>
							</div>
						 </div>
						 <div class="tab2" >
							<div class="services-right-agileits">
							   <div class="col-md-5 col-sm-5 col-xs-5 img-left">
								  <img <?php echo 'src="'.$ID_BACK.'"';?>" alt="" class="img-r">
							   </div>
							   <div class="col-md-7 col-sm-7 col-xs-7 ser-img-wthree">
								  <h4>Back ID Image</h4>
								  <p>
								  <?php 
									  echo 			"Name: $NAME<br/>";
									  echo 			"Surname: $SURNAME<br/>";
									  echo 			"ID: $ID_PASSPORT<br/>";
									  ?>
								  </p>
							   </div>
							</div>
						 </div>
						 <div class="tab3" >
							<div class="services-right-agileits">
							   <div class="col-md-5 col-sm-5 col-xs-5 img-left">
								  <img <?php echo 'src="'.$BANK_CARD_IMG.'"';?>" alt="" class="img-r">
							   </div>
							   <div class="col-md-7 col-sm-7 col-xs-7 ser-img-wthree">
								  <h4>Proof of residence Image</h4>
								  <p>
								  <?php 
									  echo 			"Bank Name: $BANK_NAME<br/>";
									  echo 			"Account Number: $ACCOUNT_NO<br/>";
									  echo 			"Account Holder: $ACCOUNT_HOLDER<br/>";
									  ?>
								  </p>
							   </div>
							</div>
						 </div>
					  </div>
				   </div>
				   <?php 
						if($recordCount == 0){
							echo "<br/><textarea name='commentText' placeholder='Leave comments'></textarea><br/><br/><br/>
   							<input type='submit' name='submitAccept' value='Accept' enabled='false' /><br/><br/>
							<input type='submit' name='submitReject' value='Reject' enabled='false' /><br/>";
						}else{
							echo "<br/><textarea name='commentText' placeholder='Leave comments'></textarea><br/><br/><br/>
   							<input type='submit' name='submitAccept' value='Accept' enabled='true' /><br/><br/>
							<input type='submit' name='submitReject' value='Reject' enabled='true' /><br/>";

						}
						echo "<br/><div class='col-md-7 col-sm-7 col-xs-7 ser-img-wthree'><h4>".$statusMsg."</h4></div>";
				   ?>
			   </form>
               <div class="clearfix"> </div>
            </div>
         </div>
      </div>
      <!-- //service -->
      <!-- counter-->
      <div class="auto-bar" id="auto-bar">
         <div class="container">
            <div class="w3l_about_bottom_grid_right bar-grids">
               <h6>Projects<span> 100% </span></h6>
               <div class="progress">
                  <div class="progress-bar progress-bar-striped active" style="width: 100%">
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--footer-->
      <footer>
         <div class="container">
            <div class="col-md-7 header-side">
               <p>© 
                  2018 Make Over. All Rights Reserved | Design by <a href="http://www.W3Layouts.com" target="_blank">W3Layouts</a>
               </p>
            </div>
            <div class="col-md-5 header-side">
               <div class="buttom-social-grd text-center">
                  <ul>
                     <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                     <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                     <li><a href="#"><span class="fa fa-rss"></span></a></li>
                     <li><a href="#"><span class="fa fa-vk"></span></a></li>
                  </ul>
               </div>
            </div>
         </div>
      </footer>
      <!-- //footer-->
      <!--js working-->
      <script src='js/jquery-2.2.3.min.js'></script>
      <!-- //js  working-->
      <script src="js/responsiveslides.min.js"></script>
      <script>
         // You can also use "$(window).load(function() {"
         $(function () {
         	// Slideshow 4
         	$("#slider4").responsiveSlides({
         		auto: true,
         		pager: true,
         		nav: false,
         		speed: 900,
         		namespace: "callbacks",
         		before: function () {
         			$('.events').append("<li>before event fired.</li>");
         		},
         		after: function () {
         			$('.events').append("<li>after event fired.</li>");
         		}
         	});
         
         });
      </script>
      <!--// banner-->
      <!-- service for responsive tabs -->
      <script src="js/easy-responsive-tabs.js"></script>
      <script>
         $(document).ready(function () {
         $('#verticalTab').easyResponsiveTabs({
         type: 'vertical',
         width: 'auto',
         fit: true
         });
         });
      </script>
      <!-- service for responsive tabs -->
      <!-- OnScroll-Number-Increase-JavaScript -->
      <script src="js/jquery.waypoints.min.js"></script>
      <script src="js/jquery.countup.js"></script>
      <script>
         $('.counter').countUp();
      </script>
      <!-- //OnScroll-Number-Increase-JavaScript -->
      <!-- Slide-To-Top JavaScript (No-Need-To-Change) -->
      <script >
         $(document).ready(function () {
         	var defaults = {
         		containerID: 'toTop', // fading element id
         		containerHoverID: 'toTopHover', // fading element hover id
         		scrollSpeed: 100,
         		easingType: 'linear'
         	};
         	$().UItoTop({
         		easingType: 'easeOutQuart'
         	});
         });
      </script>
      <a href="#" id="toTop" class="stuoyal3w stieliga" style="display: block;">
      <span id="toTopHover" style="opacity: 0;"> </span>
      </a>
      <!-- //Slide-To-Top JavaScript -->
      <!-- Smooth-Scrolling-JavaScript -->
      <script src="js/move-top.js"></script>
      <script src="js/easing.js"></script>
      <script>
         jQuery(document).ready(function ($) {
         	$(".scroll, .navbar li a, .footer li a").click(function (event) {
         		$('html,body').animate({
         			scrollTop: $(this.hash).offset().top
         		}, 1000);
         	});
         });
      </script>
      <!-- //Smooth-Scrolling-JavaScript -->
      <!--bootstrap-->
      <script src="js/bootstrap.js"></script>
      <!--// bootstrap-->
      <!-- jQuery-Photo-filter-lightbox-Gallery-plugin -->
      <script src="js/jquery-1.7.2.js"></script>
      <script src="js/jquery.quicksand.js"></script>
      <script src="js/script.js"></script>
      <script src="js/jquery.prettyPhoto.js" ></script>
      <!-- //jQuery-Photo-filter-lightbox-Gallery-plugin -->
   </body>
</html>