<?php
    session_start();
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];
    $username = $_REQUEST['username'];
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    
    $data = array(
        "username" => $username,
        "name" => $name,
        "email" => $email
    );

    $db->where("id", $user_id);
    $result = $db->update("users", $data);

    $err_message = 1;
    echo json_encode($err_message);
?>