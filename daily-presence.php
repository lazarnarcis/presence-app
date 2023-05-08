<?php
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
        header("location: login.php");
        exit();
    }

    require("./php/UIHandler.php");
    require("./php/APIHandler.php");
    $ui = new UIHandler();
    $api = new APIHandler();
    $users = $api->getUsers();
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daily Presence - Presence v1.0</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.js"></script>
    <script src="./assets/js/datatables.js"></script>
    <link rel="stylesheet" href="./assets/css/datatables.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="./assets/css/select2.css?v=<?php echo time(); ?>">
    <script src="./assets/js/select2.js?v=<?php echo time(); ?>"></script>
    <script src="./assets/js/daily-presence.js?v=<?php echo time(); ?>"></script>
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
                <h3>Daily Presence</h3>
                <p>Here you can see your daily presence in the job!</p>
            </div><!-- end title -->
            <div>
            <div class="d-flex mb-3">
                <input type="text" class="form-control flex-grow-1" id="search_user" placeholder="Name here">
                <button type="search_button" class="btn btn-default btn-info ms-2" id="search_button">Search</button>
            </div>
              <table id="daily-presence" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Presence</th>
                    </tr>
                </thead>
              </table>
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
</body>
</html>