<?php
    session_start();
    require("../config.php");
    $db = new Database();

    $name = $_REQUEST['name'];
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    
    $query = "SELECT * FROM users WHERE username='".$username."'";
    $result_user = $db->query($query);

    $err_message = 1;
    if (is_array($result_user) && count($result_user)){ 
        $err_message = "There is already an account with this username!";
    } else {
        $query = "SELECT * FROM users WHERE email='".$email."'";
        $result_email = $db->query($query);

        if (is_array($result_email) && count($result_email)){ 
            $err_message = "There is already an account with this email!";
        } else {
            $data = array(
                "username" => $username,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "name" => $name,
                "admin" => 0
            );
            $data = $db->insert("users", $data);
            if ($data) {
                $db->where("email", $email);
                $result = $db->select("users");
                $err_message = $result;
            } 
        }
    }

    echo json_encode($err_message);
?>