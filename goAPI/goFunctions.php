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

            $contentMessage = "<!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                        }
                        .email-container {
                            max-width: 600px;
                            margin: 20px auto;
                            background: #ffffff;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            overflow: hidden;
                        }
                        .header {
                            background-color: #0073e6;
                            color: white;
                            padding: 20px;
                            text-align: center;
                            font-size: 24px;
                            font-weight: bold;
                        }
                        .content {
                            padding: 20px;
                        }
                        .content p {
                            margin: 0 0 10px;
                        }
                        .footer {
                            background-color: #f4f4f4;
                            text-align: center;
                            padding: 15px;
                            font-size: 12px;
                            color: #666;
                            border-top: 1px solid #ddd;
                        }
                        .footer a {
                            color: #0073e6;
                            text-decoration: none;
                        }
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='header'>
                            $subject
                        </div>
                        <div class='content'>
                            $message
                        </div>
                        <div class='footer'>
                            <p>Development Hub &copy; ".date("Y").". All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>";
            $mail->Body    = $contentMessage;

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