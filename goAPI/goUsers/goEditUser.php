<?php
    function isEmail($text) {
        $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
        if (preg_match($pattern, $text)) {
            return true; 
        } else {
            return false; 
        }
    }
    session_start();
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];
    $username = $_REQUEST['username'];
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $admin = $_REQUEST['admin'];
    $discord_member = $_REQUEST['discord_member'];
    $password = $_REQUEST['password'];
    $err_message = 1;

    if (isEmail($email)) {
        $query = "SELECT * FROM users WHERE username='".$username."' and id!='".$user_id."'";
        $result_user = $db->query($query);

        if (is_array($result_user) && count($result_user)){ 
            $err_message = "There is already an account with this username!";
        } else {
            $query = "SELECT * FROM users WHERE email='".$email."' and id!='".$user_id."'";
            $result_email = $db->query($query);

            if (is_array($result_email) && count($result_email)){ 
                $err_message = "There is already an account with this email!";
            } else {
                $query = "SELECT admin FROM users WHERE id='$user_id'";
                $result = $db->query($query);
                if (!$admin && $admin != 0) {
                    $admin = $result[0]['admin'];
                }
                $data = array(
                    "username" => $username,
                    "name" => $name,
                    "email" => $email,
                    "admin" => $admin,
                );
                if ($discord_member) {
                    $data['discord_user_id'] = $discord_member;
                }
                if ($password != NULL) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
            
                $db->where("id", $user_id);
                $result = $db->update("users", $data);

                if ($discord_member) {
                    $db->where("user_id", $discord_member);
                    $role = $db->getOne("discord_members");
                    $roles = $role['roles'];

                    $data = array(
                        "roles" => json_encode(explode(",",$roles))
                    );
                    $db->where("discord_user_id", $discord_member);
                    $result = $db->update("users", $data);
                }
            }
        }
    } else {
        $err_message = "This is not the actual format of an email!";
    }

    echo json_encode($err_message);
?>