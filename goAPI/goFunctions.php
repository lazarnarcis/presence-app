<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../../PHPMailer-master/src/Exception.php';
    require '../../PHPMailer-master/src/PHPMailer.php';
    require '../../PHPMailer-master/src/SMTP.php';

    function sendMail($from_header, $to, $subject, $message) {
        global $gemail, $mail_host, $mail_port, $gpassword;
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
            $mail->Host = $mail_host;  
            $mail->Port = $mail_port; 
            $mail->Username = $gemail; 
            $mail->Password = $gpassword; 
            
            $mail->setFrom($gemail, $from_header);
            $mail->addAddress($to);

            $mail->isHTML(true); 
            $mail->Subject = $subject;

            $mail->Body    = $message;

            if ($mail->send()) {
                error_log("MAIL SEND!");
            } else {
                error_log("Error mail send: " . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            error_log("Error mail send: {$mail->ErrorInfo}");
        }
    }
?>