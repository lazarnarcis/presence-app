<?php
  session_start();
  if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    header("location: login.php");
    exit();
  }

  require("./php/UIHandler.php");
  $ui = new UIHandler();
  require("./php/APIHandler.php");
  $api = new APIHandler();
  $session_user_info = $api->getUserInfo($_SESSION['user_id']);
  if ($session_user_info['account_confirm'] != 1) {
    header("location: account_confirm.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Home - Presence v1.0</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body id="page-top" class="politics_version">

    <!-- LOADER -->
    <div id="preloader">
        <div id="main-ld">
			<div id="loader"></div>  
		</div>
    </div><!-- end loader -->
    <!-- END LOADER -->
	
    <?php echo $ui->getNav(); ?>
	
	<section id="home" class="main-banner parallaxie" style="background: url('uploads/banner-01.jpg')">
		<div class="heading">
			<h1>Welcome to presence</h1>			
			<h3 class="cd-headline clip is-full-width">
				<span>Here you can see your </span>
				<span class="cd-words-wrapper">
					<b class="is-visible">daily presence.</b>
					<b>monthly presence.</b>
					<b>annual presence.</b>
				</span>
				<div class="btn-ber">
					<a class="get_btn hvr-bounce-to-top" href="daily-presence.php">See the presence</a>
				</div>
			</h3>
		</div>
	</section>

  <?php echo $ui->getFooter(); ?>

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <script src="js/all.js"></script>
    <script src="js/jquery.easing.1.3.js"></script> 
    <script src="js/parallaxie.js"></script>
    <script src="js/headline.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.vide.js"></script>

</body>
</html>