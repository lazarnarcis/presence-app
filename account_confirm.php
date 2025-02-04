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
  if ($session_user_info['account_confirm'] == 1) {
    header("location: index.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Restrict Account - Presence v<?=$_ENV['VERSION'];?></title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="assets/css/login.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	<script src="js/sweetalert.js"></script>
    <script src="./assets/js/jquery.js"></script>
</head> 
<body id="page-top" class="politics_version">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="text-center">
                        <div class="card" style="max-width: 100vw !important;">
                            <div>
                                <h1>Contact site Administrator</h1>
                                <hr>
                                <h3>Please contact site Administrator to authorize your account :></h3>
                                <div class="mb-3"> <a href="index.php" class="btn btn-dark w-100">Reload page</a> </div>
                                <div class="mb-3"> <button type="button" class="btn w-100 btn_logout">Logout</button> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".btn_logout", function() {
                window.location.href="logout.php";
            });
        });
    </script>
</body>
</html>