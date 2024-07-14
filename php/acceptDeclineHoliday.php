<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = $_POST['user_id'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $status = $_POST['status'];

    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    $result = $api->acceptDeclineHoliday($user_id, $year, $month, $day, $status, $_SESSION['user_id'], $session_user_info['name']);

    echo json_encode($result);
?>