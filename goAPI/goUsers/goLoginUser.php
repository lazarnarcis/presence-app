<?php
    session_start();
    require("../config.php");
    $db = new Database();

    $name = $_REQUEST['name'];
    $password = $_REQUEST['password'];

    $db->where("username", $name);
    $result = $db->select("users");

    $err_message = "This account doesn't exists!";
    if (is_array($result) && count($result)){ 
        if ($password != $result[0]['password']) {
            $err_message = "Incorrect password!";
        } else {
            $err_message = $result;
        }
    } else {
        $err_message = "This account doesn't exists!";
    }

    echo json_encode($err_message);
?>