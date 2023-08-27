<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $admin = NULL;
    if (isset($_POST['admin'])) {
        $admin = $_POST['admin'];
    }
    $change_password = $_POST['change_password'];
    $change_password_input = NULL;
    if ($change_password == "1") {
        $change_password_input = $_POST['change_password_input'];
    }

    $result = $api->editUser($user_id, $username, $name, $email, $admin, $change_password_input);

    echo json_encode($result);
?>