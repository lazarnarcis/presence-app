<?php
    session_start();
    require("../config.php");
    require("../goFunctions.php");
    $db = new Database();

    $name = $_REQUEST['name'];

    function generateUniqueId() {
        $uniqueId = uniqid('', true);
        $uniqueId .= '-' . bin2hex(random_bytes(5));
        return $uniqueId;
    }

    $uniqueid = generateUniqueId();

    $query = "select * from users where email='$name'";
    $user = $db->query($query);

    $err_message = 1;
    if (is_array($user) && count($user) > 0) {
        $user = $user[0];
        $user_id = $user['id'];
        $query_forgot = "select * from forgot_password where userid='$user_id'";
        $forgot_password = $db->query($query_forgot);

        if (is_array($forgot_password) && count($forgot_password) > 0) {
            $err_message = "You have already sent a request to reset your password <b>(valid for 15 MINUTES)</b>. Please <b>check your email</b>, including your Spam folder.";
        } else {
            $data = [
                'uniqueid' => $uniqueid,
                'userid' => $user_id
            ];
            $db->insert("forgot_password", $data);
    
            $uname = $user['name'];
            $subject_header = "Presence Dev-Hub";
            $subject = "Password reset for $uname"; 
    
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $currentUrl = $protocol . '://' . $host;
            $link = "$currentUrl/reset-password.php?uid=".$uniqueid;
            $reset_link = "<a href='$link' target='_blank'>$link</a>";
    
            $message = "Dear <b>$uname</b>,<br><br>This is the link for reset password: $reset_link (valid for <b>15 minutes</b>)<br><span style='color: red;'>If you did not make this request, you can easily ignore the e-mail!</span><br><br>Thank You!";
            sendMail($subject_header, $name, $subject, $message);
        }
    } else {
        $err_message = "User with this email doesn't exist!";
    }

    echo json_encode($err_message);
?>