<?php
    require("../config.php");
    require("../goFunctions.php");

    $db = new Database();

    $user_id = $_REQUEST['user_id'];
    $year = $_REQUEST['year'];
    $month = $_REQUEST['month'];
    $day = $_REQUEST['day'];
    $status = $_REQUEST['status'];
    $session_user_id = $_REQUEST['session_user_id'];
    $session_user_name = $_REQUEST['session_user_name'];

    if ($status == "accepted") {
        $query = "update users set holidays_left=holidays_left-1 where id='$user_id';";
        $db->query($query);
    }
    
    $query = "update request_holidays set status='$status' where user_id='$user_id' and year='$year' and month='$month' and day='$day' and status='pending';";
    $db->query($query);

    $query = "select * from users where id='$user_id'";
    $user_holiday = $db->query($query);

    if (count($user_holiday)) {
        $uemail = $user_holiday[0]['email'];
        $uname = $user_holiday[0]['name'];

        $subject_header = "Human Resources Team";
        $subject = "Leave request for $uname";

        $details_status = null;
        if ($status == "accepted") {
            $details_status = "<span style='color: green;'>$status</span>";
        } else {
            $details_status = "<span style='color: red;'>$status</span>";
        }
        $dateString = "$year-$month-$day";
        $date = DateTime::createFromFormat('Y-n-j', $dateString);
        $formattedDate = $date->format('d F Y');

        $message = "Dear <b>$uname</b>,<br><br>[HR Team]: $session_user_name just $details_status request on $formattedDate!<br><br>Thank You!";
        sendMail($subject_header, $uemail, $subject, $message);
    }
    
    $data = array(
        "response" => "success"
    );

    echo json_encode($data);
?>