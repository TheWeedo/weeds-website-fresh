
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'wellnessbyweedo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@wellnessbyweedo.com';
    $mail->Password   = '14Rbusiness2Thrive!';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('info@wellnessbyweedo.com', 'Wellness By Weedo');
    $mail->addAddress('info@wellnessbyweedo.com');

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body    = "Name: {$_POST['name']}<br>Email: {$_POST['email']}<br>Message:<br>{$_POST['message']}";

    $mail->send();
    http_response_code(200);
    echo "Message sent successfully.";
} catch (Exception $e) {
    http_response_code(500);
    echo "Mailer Error: {$mail->ErrorInfo}";
}
?>
