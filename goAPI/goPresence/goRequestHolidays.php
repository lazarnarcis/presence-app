<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../../PHPMailer-master/src/Exception.php';
    require '../../PHPMailer-master/src/PHPMailer.php';
    require '../../PHPMailer-master/src/SMTP.php';
    require("../config.php");

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
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
                    $mail->Host = $mail_host;  
                    $mail->Port = $mail_port; 
                    $mail->Username = $gemail; 
                    $mail->Password = $gpassword; 
                    
                    $mail->setFrom($gemail, "Leave Request - HR");
                    $mail->addAddress($send_to_email);
        
                    $mail->isHTML(true); 
                    $mail->Subject = "Leave request for $session_user_name";

                    $date = DateTime::createFromFormat('Y-n-j', $holiday);
                    $formattedDate = $date->format('d F Y');

                    $mail->Body    = "Dear <b>$send_to_name</b>,<br><br>$session_user_name just want a leave request on $formattedDate [$type], reason: [$reason]<br><br>Thank You!";
        
                    if ($mail->send()) {
                        error_log("MAIL SEND!");
                    } else {
                        error_log("Error mail send: " . $mail->ErrorInfo);
                    }
                } catch (Exception $e) {
                    error_log("Error mail send: {$mail->ErrorInfo}");
                }
            }
        }
    }
    
    $data = array(
        "response" => "success"
    );

    echo json_encode($data);
?>