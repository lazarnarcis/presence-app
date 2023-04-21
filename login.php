<?php
    session_start();
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
        header("location: index.php");
        exit;
    }

    require("./php/UIHandler.php");
    $ui = new UIHandler();
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login - Presence v1.0</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="js/modernizr.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>
</head>
<body id="page-top" class="politics_version">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="text-center">
                        <form class="card" id="login_form">
                            <div class="form-data">
                                <h1 class="mb-3">Login - Presence v1.0</h1>
                                <div class="forms-inputs mb-4"> <span>Email or username</span> <input type="text" name="name" class="form-control"></div>
                                <div class="forms-inputs mb-4"> <span>Password</span> <input type="password" name="password" class="form-control"></div>
                                <div class="mb-3"> <button type="button" class="btn btn-dark w-100 btn_login">Login</button> </div>
                                <div class="mb-3"> <button type="button" class="btn w-100">Register</button> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/all.js"></script>
    <script src="js/jquery.easing.1.3.js"></script> 
    <script src="js/parallaxie.js"></script>
    <script src="js/headline.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.vide.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>