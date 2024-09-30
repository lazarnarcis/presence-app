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

        $message = "Dear <b>$uname</b>,<br><br>[DevHub]: This is the link for reset password: $reset_link (valid for <b>15 minutes</b>)<br><br>If you did not make this request, you can easily ignore the e-mail!</b><br>Thank You!";
        sendMail($subject_header, $name, $subject, $message);
    } else {
        $err_message = "User with this email doesn't exist!";
    }

    echo json_encode($err_message);
?>