<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class Mailer {
    public static function sendEmail($to, $subject, $body) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'landryamengne@gmail.com';
            $mail->Password   = 'nsiz ixfk avcp esnc'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('landryamengne@gmail.com', 'Equipe Formation');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->send();

            return true;
        } catch (Exception $e) {
            error_log("Erreur d'envoi : {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>
