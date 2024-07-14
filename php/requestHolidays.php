<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $reason = $_POST['reason'];
    $holidays = json_decode($_POST['holidays']);

    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    $result = $api->requestHolidays($reason, $holidays, $_SESSION['user_id'], $session_user_info['name']);

    echo json_encode($result);
?>