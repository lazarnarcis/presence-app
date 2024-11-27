<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : $_GET['user_id'];
    $year = isset($_POST['year']) ? $_POST['year'] : $_GET['year'];
    $month = isset($_POST['month']) ? $_POST['month'] : $_GET['month'];
    $day = isset($_POST['day']) ? $_POST['day'] : $_GET['day'];
    $status = isset($_POST['status']) ? $_POST['status'] : $_GET['status'];

    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    $result = $api->acceptDeclineHoliday($user_id, $year, $month, $day, $status, $_SESSION['user_id'], $session_user_info['name']);

    if (isset($_POST['user_id'])) {
        echo json_encode($result);
    } elseif (isset($_GET['user_id']) && $result['response'] == "success") {
        echo '<!DOCTYPE html>
                <html lang="en">
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
                    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
                    <link rel="stylesheet" href="../css/bootstrap.min.css">
                    <link rel="stylesheet" href="../style.css">
                    <link rel="stylesheet" href="../css/responsive.css">
                    <link rel="stylesheet" href="../css/custom.css">
                    <link rel="stylesheet" href="../assets/css/login.css?v=<?php echo time(); ?>">
                    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
                    <script src="../js/sweetalert.js"></script>
                </head>
                <body id="page-top" class="politics_version">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                                    <div class="text-center">
                                            <div class="card" style="max-width: 100vw !important;">
                                                <div>
                                                    <h1>Successful operation :></h1>
                                                    <hr>
                                                    <h3>The holiday '.$day.'.'.$month.'.'.$year.' has been '.$status.'!</h3>
                                                    <div class="mt-3"> <a href="../holidays.php" class="btn btn-dark w-100">Go to holidays</a> </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
                </html>';
    }
?>