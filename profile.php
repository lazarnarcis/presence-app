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
$discord_members = $api->getDiscordMembers();
$discord_roles = $api->getDiscordRoles();
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
    <title><?=$user_info['name']?>'s profile - Presence v<?=$_ENV["VERSION"];?></title>
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
    <link href="./css/slimselect.css" rel="stylesheet">
    <script src="./js/slimselect.js"></script>
    <style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }
    .profile-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 25px 40px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .profile-header img {
        border-radius: 50%;
        width: 120px;
        height: 120px;
        margin-bottom: 1rem;
    }
    .profile-header h2 {
        margin: 0.5rem 0;
        font-size: 1.8rem;
        color: #333;
    }
    .profile-header p {
        color: #777;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .roles-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .role-badge {
        padding: 5px 10px;
        border-radius: 15px;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }
    .action-buttons .btn {
        display: flex;
        align-items: center;
        padding: 0.7rem 1.5rem;
        font-size: 1rem;
        border-radius: 12.5px;
    }
    .form-group label {
        font-weight: bold;
        color: #555;
    }
    .form-group input, 
    .form-group select {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 0.6rem;
        font-size: 1rem;
    }
    .form-group input:disabled, 
    .form-group select:disabled {
        background-color: #f9f9f9;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 8px;
        font-size: 1rem;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>
<?php
$button_authorize = NULL;
if( $_SESSION['user_id'] != $user_info['id']) {
     if ($user_info['account_confirm'] == 1) {
         $button_authorize = "<button type='button' class='btn btn-danger unauthorize_user' data-user-id='".$user_info['id']."'>Unauthorize</button>";
     } else {
         $button_authorize = "<button type='button' class='btn btn-success authorize_user' data-user-id='".$user_info['id']."'>Authorize</button>";
     }
 }
?>
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
            <div class="profile-header">
                <h2><small><i><?php echo $user_info['name']; ?></i></small><br><?php echo $user_info['username']; ?></h2>
                <?php 
                if ($user_info['roles']) {
                    $user_roles = json_decode($user_info['roles']);
                    if (count($user_roles)) {
                        echo '<div class="roles-container">';
                        foreach($user_roles as $ur) {
                            $color = null;
                            foreach ($discord_roles as $item) {
                                if ($item['name'] === $ur) {
                                    $color = $item['color'];
                                    break;  
                                }
                            }
                            echo '<span class="role-badge" style="background-color: '.$color.';">'.$ur.'</span>';
                        }
                        echo '</div>';
                    }
                } ?>
                
            </div>
            <form id="form_edit_user" class="form-horizontal">
                <input type="hidden" name="user_id" value="<?php echo $user_info['id']; ?>">
                <div style="display: flex; align-items: center; justify-content: center;">
                    <div class="form-group" style="width: 100%; margin-right: 10px;">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $user_info['username']; ?>" <?php echo ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) ? 'disabled' : ''; ?>>
                    </div>
                    <div class="action-buttons">
                        <?php if ($session_user_info['admin'] > 0 || $_GET['id'] == $_SESSION['user_id']) { ?>
                            <button type="button" class="btn btn-warning open_user_modal" style="color: white;" data-user-name="<?php echo $user_info['username']; ?>">Show Activity</button>
                        <?php } ?>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <div style="width:100%; margin-right: 10px;" class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $user_info['name']; ?>" <?php echo ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) ? 'disabled' : ''; ?>>
                    </div>
                    <?php if ($session_user_info['admin'] == 2 && $_SESSION['user_id'] != $user_info['id']) { echo "<div class='action-buttons'>".$button_authorize."</div>"; } ?>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $user_info['email']; ?>" <?php echo ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) ? 'disabled' : ''; ?>>
                </div>
                <?php if ($session_user_info['admin'] == 2 && $_GET['id'] != $_SESSION['user_id']) { ?>
                    <div class="form-group">
                        <label for="admin">Admin</label>
                        <select class="form-control" name="admin" id="admin">
                            <option value="0" <?php echo $user_info['admin'] == 0 ? 'selected' : ''; ?>>User</option>
                            <option value="1" <?php echo $user_info['admin'] == 1 ? 'selected' : ''; ?>>Admin</option>
                            <option value="2" <?php echo $user_info['admin'] == 2 ? 'selected' : ''; ?>>Full Access</option>
                        </select>
                    </div>
                <?php } ?>
                <?php if ($session_user_info['admin'] == 2) { ?> 
                    <div class="form-group">
                        <label for="discord_member">Discord Member</label>
                        <div style="display: flex;">
                            <select type="discord_member" name="discord_member" id="discord_member">
                                <option value="" disabled selected>Select member</option>
                                <?php
                                    if (count($discord_members)) {
                                        foreach ($discord_members as $dr) {
                                            $val = $dr['user_id'];
                                            $selected = NULL;
                                            $user = $dr['username'];
                                            if ($user_info['discord_user_id'] == $dr['user_id']) {
                                                $selected = "selected";
                                            }
                                            echo "<option value='".$val."' $selected>".$user."</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <?php if (isset($user_info['discord_user_id']) && !empty($user_info['discord_user_id'])) { ?>
                                <button type="button" target="_blank" style="margin-left: 10px;border-radius: 12.5px;height: 30px;" class="btn btn-info open_discord">Open Discord</button>
                            <?php } ?>
                        </div>
                    </div> 
                <?php } ?>
                <?php if ($session_user_info['admin'] > 0 || $_GET['id'] == $_SESSION['user_id']) { ?>
                    <div class="form-group">
                        <label for="change_password">Change Password</label>
                        <select class="form-control" name="change_password" id="change_password">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group div_form_password" style="display: none;">
                        <label for="change_password_input">Type your new password</label>
                        <input type="password" class="form-control" name="change_password_input" id="change_password_input" placeholder="Enter password">
                    </div>
                    <div class="form-group div_form_password" style="display: none;">
                        <label for="confirm_password">Confirm password</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password">
                    </div>
                <?php } ?>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-warning" style="color: white;" id="save_info" <?php echo ($_GET['id'] != $_SESSION['user_id'] && $session_user_info['admin'] == 0) ? 'disabled' : ''; ?>>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <?php echo $ui->getFooter(); ?>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 30px;">
                <div class="modal-header">
                    <h1 style="text-align: center;"><?php echo $user_info['username']; ?>'s logs</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-x: auto;">
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
    <script> 
        if ($("#discord_member").length > 0)
        {
            new SlimSelect({
                select: '#discord_member'
            });
        }
    </script>
</body>
</html>
