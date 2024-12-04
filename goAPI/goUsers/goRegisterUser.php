<?php
    session_start();
    require("../config.php");
    require("../goFunctions.php");
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
                "user" => $username,
                "type" => "REGISTER",
                "date" => date("Y-m-d H:i:s"),
                "address_ip" => $_SERVER['REMOTE_ADDR'],
                "text" => "Just register!"
            );
            $db->insert("activity", $data);

            $data = array(
                "username" => $username,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "name" => $name,
                "admin" => 0,
                "account_confirm" => 0,
                "date" => date("Y-m-d H:i:s"),
                "roles" => json_encode([])
            );
            $data = $db->insert("users", $data);

            $query = 'select email from users where admin > 0';
            $all_users = $db->query($query);
            $subject_header = "New account created";
            $subject = $subject_header;
            $message = "<b>$username</b> ($name) just created an account with email $email<br><br>Go to <a href='https://presence.dev-hub.ro/'>https://presence.dev-hub.ro/</a> to authorize his account!<br><br>Thanks!";
            if (count($all_users)) {
                foreach ($all_users as $user) {
                    $send_to_email = $user['email'];
                    sendMail($subject_header, $send_to_email, $subject, $message);
                }
            }

            if ($data) {
                $db->where("email", $email);
                $result = $db->select("users");
                $err_message = $result;
            } 
        }
    }

    echo json_encode($err_message);
?>