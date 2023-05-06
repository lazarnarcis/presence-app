<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $result = $api->editUser($user_id, $username, $name, $email);

    $err_message = 1;

    echo json_encode($err_message);
?>