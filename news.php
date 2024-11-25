<?php
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
        header("location: login.php");
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
    <title>News - Presence v<?=$_ENV["VERSION"];?></title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.js"></script>
    <script src="./assets/js/news.js?v=<?=time();?>"></script>
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
                <h3>News</h3>
                <p id="text-news"></p>
                <?php if ($session_user_info['admin'] > 0) { ?>
                    <button type="button" class="btn btn-warning edit_news" style="color: white;">Edit News</button>
                    <button type="button" class="btn btn-info show_all_news">Show All News</button>
                <?php } ?>
        </div><!-- end container -->
    </div><!-- end section -->
    
    <div class="modal fade bd-example-modal-lg" id="editNewsModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 30px;">
                <div class="modal-header">
                    <h1 style="text-align: center;">News section</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control" id="edit-news-input" id="exampleFormControlTextarea1" rows="3"><?php echo "test"; ?></textarea>
                        <input type="button" class="btn btn-success pull-right mt-2" id="save-news-data" value="Save">
                        <input type="button" class="btn btn-danger pull-right mt-2 mr-2 cancel_edit_news_modal" value="Cancel">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="lastNewsModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 30px;">
                <div class="modal-header">
                    <h1 style="text-align: center;">All News</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="last-news-table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Created At</th>
                                <th>Text</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

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