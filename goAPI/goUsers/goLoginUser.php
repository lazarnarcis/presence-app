<?php
    session_start();
    require("../config.php");
    $db = new Database();

    $name = $_REQUEST['name'];
    $password = $_REQUEST['password'];
    
    $query = "SELECT * FROM users WHERE username='".$name."' OR email='".$name."'";
    $result = $db->query($query);

    $err_message = 1;
    if (is_array($result) && count($result)){ 
        if (password_verify($password, $result[0]['password'])) {
            $err_message = $result;
        } else {
            $err_message = "Incorrect password!";
        }
    } else {
        $err_message = "This account doesn't exists!";
    }

    echo json_encode($err_message);
?>