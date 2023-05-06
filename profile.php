<?php
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
        header("location: login.php");
        exit();
    }
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("location: index.php");
        exit();
    }

    require("./php/UIHandler.php");
    $ui = new UIHandler();
    require("./php/APIHandler.php");
    $api = new APIHandler();
    $user_info = $api->getUserInfo($_GET['id']);
    if ($user_info == 1) {
        header("location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Profile - Presence v1.0</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.js"></script>
    <script src="./assets/js/profile.js"></script>
    <link rel="stylesheet" href="./assets/css/datatables.css">
    <link rel="stylesheet" href="css/nav.css">
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

    <div id="services" class="section lb">
        <div class="container">
            <div class="section-title text-center">
                <h3>Edit Profile</h3>
                <p><?php echo $user_info['name']; ?>'s profile</p>
            </div><!-- end title -->
            <div>
            <form id="form_edit_user">
                <input type="hidden" name="user_id" value="<?php echo $user_info['id']; ?>">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" value="<?php echo $user_info['username']; ?>">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="<?php echo $user_info['name']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $user_info['email']; ?>">
                </div>
                <button type="button" class="btn btn-primary" id="save_info">Save Changes</button>
            </form>
            </div>
        </div><!-- end container -->
    </div><!-- end section -->

    <?php echo $ui->getFooter(); ?>

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <script src="js/all.js"></script>
    <script src="js/jquery.easing.1.3.js"></script> 
    <script src="js/parallaxie.js"></script>
    <script src="js/headline.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.vide.js"></script>
    <script src="./assets/js/datatables.js"></script>

</body>
</html>