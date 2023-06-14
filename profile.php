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
    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
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
    <script src="./assets/js/profile.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="./assets/css/datatables.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	<script src="js/sweetalert.js"></script>
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
                <?php if ($session_user_info['admin'] == 1 && $_GET['id'] != $_SESSION['user_id']) { ?>
                <div class="form-group">
                    <label for="admin">Admin</label>
                    <select type="admin" class="form-control" name="admin" id="admin">
                        <option value="0" <?php if ($user_info['admin'] == 0) echo "selected"; ?>>No</option>
                        <option value="1" <?php if ($user_info['admin'] == 1) echo "selected"; ?>>Yes</option>
                    </select>
                </div>
                <?php } ?>
                <?php if ($session_user_info['admin'] == 1 || $_GET['id'] == $_SESSION['user_id']) { ?>
                    <button type="button" class="btn btn-primary open_user_modal" data-user-name="<?php echo $user_info['username']; ?>">Show Activity</button>
                <?php } ?>
                <?php if ($session_user_info['admin'] == 1 || $_GET['id'] == $_SESSION['user_id']) { ?>
                <div class="form-group">
                    <label for="change_password">Change Password</label>
                    <select type="change_password" class="form-control" name="change_password" id="change_password">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="form-group div_form_password" style="display: none;">
                    <label for="change_password_input">Type your new password</label>
                    <input type="password" class="form-control" name="change_password_input" id="change_password_input" placeholder="Enter password">
                </div>
                <?php } ?>
                <button type="button" class="btn btn-primary" id="save_info" <?php if ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) echo 'disabled'; ?>>Save Changes</button>
            </form>
            </div>
        </div><!-- end container -->
    </div><!-- end section -->

    <?php echo $ui->getFooter(); ?>
    <!-- Modal -->

    <div class="modal fade bd-example-modal-lg" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 30px;">
        <table id="user-activity" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>IP</th>
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