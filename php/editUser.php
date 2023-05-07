<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $admin = $_POST['admin'];

    $result = $api->editUser($user_id, $username, $name, $email, $admin);

    $err_message = 1;

    echo json_encode($err_message);
?>