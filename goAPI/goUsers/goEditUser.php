<?php
    session_start();
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];
    $username = $_REQUEST['username'];
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $admin = $_REQUEST['admin'];
    $password = $_REQUEST['password'];
    
    $data = array(
        "username" => $username,
        "name" => $name,
        "email" => $email,
        "admin" => $admin
    );
    if ($password != NULL) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    $db->where("id", $user_id);
    $result = $db->update("users", $data);

    $err_message = 1;
    echo json_encode($err_message);
?>