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

$current_dir = __DIR__;

while ($current_dir != '/' && !file_exists($current_dir . '/index.php')) {
    $current_dir = dirname($current_dir);
}
require_once $current_dir . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable($current_dir);
$dotenv->load();

require("./php/UIHandler.php");
$ui = new UIHandler();
require("./php/APIHandler.php");
$api = new APIHandler();
$user_info = $api->getUserInfo($_GET['id']);
$session_user_info = $api->getUserInfo($_SESSION['user_id']);
if ($session_user_info['account_confirm'] != 1) {
    header("location: account_confirm.php");
    exit();
}
if ($user_info == 1) {
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
    <title>Profile - Presence v<?=$_ENV["VERSION"];?></title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="./assets/css/datatables.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
    <script src="js/sweetalert.js"></script>
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.js"></script>
    <script src="./assets/js/profile.js?v=<?php echo time(); ?>"></script>
    <style>
        .profile-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 2rem;
        }
        .profile-card {
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            margin-top: 1rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
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
        <div class="container profile-container">
            <div class="profile-card">
                <div style="display: flex; align-items: center; justify-content: center;">
                    <h2 style="margin: 0; display: flex; align-items: center; margin-top: 20px;"><b><?php echo $user_info['name']; ?></b></h2>
                    <?php if ($session_user_info['admin'] > 0 || $_GET['id'] == $_SESSION['user_id']) { ?>
                        <button type="button" class="btn btn-primary open_user_modal" data-user-name="<?php echo $user_info['username']; ?>" style="margin-left: 10px; font-size: 1rem; display: flex; align-items: center;">Show Activity</button>
                    <?php } ?>
                </div>
                <form id="form_edit_user" class="form-horizontal">
                    <input type="hidden" name="user_id" value="<?php echo $user_info['id']; ?>"> 
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" value="<?php echo $user_info['username']; ?>" <?php if ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) echo 'disabled'; ?>>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="<?php echo $user_info['name']; ?>" <?php if ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) echo 'disabled'; ?>>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $user_info['email']; ?>" <?php if ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) echo 'disabled'; ?>>
                    </div>
                    <?php if ($session_user_info['admin'] == 2 && $_GET['id'] != $_SESSION['user_id']) { ?>
                    <div class="form-group">
                        <label for="admin">Admin</label>
                        <select type="admin" class="form-control" name="admin" id="admin">
                            <option value="0" <?php if ($user_info['admin'] == 0) echo "selected"; ?>>User</option>
                            <option value="1" <?php if ($user_info['admin'] == 1) echo "selected"; ?>>Admin</option>
                            <option value="2" <?php if ($user_info['admin'] == 2) echo "selected"; ?>>Full Access</option>
                        </select>
                    </div>
                    <?php } ?>
                    <?php if ($session_user_info['admin'] > 0 || $_GET['id'] == $_SESSION['user_id']) { ?>
                    <div class="form-group">
                        <label for="change_password">Change Password</label>
                        <select type="change_password" class="form-control" name="change_password" id="change_password">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="div_form_password" style="display: none;">
                        <div class="form-group">
                            <label for="change_password_input">Type your new password</label>
                            <input type="password" class="form-control" name="change_password_input" id="change_password_input" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm password</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary" id="save_info" <?php if ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) echo 'disabled'; ?>>Save Changes</button>
                    </div>
                </form>
            </div>
        </div><!-- end container -->
    </div><!-- end section -->

    <?php echo $ui->getFooter(); ?>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 30px;">
                <h1 style="text-align: center;"><?php echo $user_info['username']; ?>'s logs</h1>
                <table id="user-activity" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>IP</th>
                            <th>Text</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

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
