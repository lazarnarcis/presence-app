<?php
    $current_dir = __DIR__;

    while ($current_dir != '/' && !file_exists($current_dir . '/index.php')) {
        $current_dir = dirname($current_dir);
    }
    require_once $current_dir . '/vendor/autoload.php';
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable($current_dir);
    $dotenv->load();

    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
        header("location: login.php");
        exit();
    }

    require("./php/UIHandler.php");
    require("./php/APIHandler.php");
    $ui = new UIHandler();
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
    <title>Daily Presence - Presence v<?=$_ENV["VERSION"];?></title>
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
    <style>
        #start_date, #end_date {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 100%;
            height: 40px;
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
        <div class="container">
            <div class="section-title text-center">
                <h3>Daily Presence</h3>
                <p>Here you can see your daily presence in the job!</p>
            </div><!-- end title -->
            <div class="row">
                <div class="col-lg-9" id="myTable">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="contacts_div">
                                <div style="overflow-x: auto;">
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
                            </div>
                        </div><!-- /.body -->
                    </div><!-- /.panel -->
                </div><!-- /.col-lg-9 -->
                <div class="col-lg-3" id="myFilters">
                    <h3 class="m0 pb-lg">Filters</h3>
                    <form id="search_form">
                        <div class="all_callbacks_filters">
                            <div class="list_filter_div">
                                <div class="form-group">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                                <div class="form-group">
                                    <label for="channel">Discord Channel:</label>
                                    <select class="form-control" id="channel" name="channel">
                                        <option value="">Select a channel</option>
                                        <?php
                                            $discord_channels = explode(",",$_ENV['DISCORD_CHANNELS']);
                                            foreach ($discord_channels as $dc) {
                                                $disabled = NULL;
                                                if ($dc == "-") {
                                                    $disabled = " disabled ";
                                                }
                                                echo "<option value='$dc' $disabled>$dc</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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