<?php
    require("../config.php");
    require("../goFunctions.php");

    $db = new Database();

    $reason = $_REQUEST['reason'];
    $type = $_REQUEST['type'];
    $holidays = json_decode($_REQUEST['holidays']);
    $session_user_id = $_REQUEST['session_user_id'];
    $session_user_name = $_REQUEST['session_user_name'];

    $query = 'select email,name from users where admin > 0';
    $admin_emails = $db->query($query);

    foreach ($holidays as $holiday) {
        $parts = explode('-', $holiday);
        $data = array(
            "user_id" => $session_user_id,
            "status" => "pending",
            "year" => $parts[0],
            "month" => $parts[1],
            "day" => $parts[2],
            "reason" => $reason,
            "type" => $type
        );
        $db->insert("request_holidays", $data);

        if (count($admin_emails)) {
            foreach ($admin_emails as $ae) {
                $send_to_email = $ae['email'];
                $send_to_name = $ae['name'];

                $subject_header = "Leave Request - HR";
                $subject = "Leave request for $session_user_name";
                $date = DateTime::createFromFormat('Y-n-j', $holiday);
                $formattedDate = $date->format('d F Y');
                $message = "Dear <b>$send_to_name</b>,<br><br>$session_user_name just want a leave request on $formattedDate [$type], reason: [$reason]<br><br>Thank You!";
                sendMail($subject_header, $send_to_email, $subject, $message);
            }
        }
    }
    
    $data = array(
        "response" => "success"
    );

    echo json_encode($data);
?>