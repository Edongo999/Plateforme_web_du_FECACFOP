<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure les fichiers de PHPMailer
require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

// Créer une instance PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // Serveur SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'landryamengne@gmail.com';  // 🔹 Mets ici ton adresse email
    $mail->Password   = 'nsiz ixfk avcp esnc';  // 🔹 Mets ici ton mot de passe sécurisé
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // 🔹 Paramètres de base de l'expéditeur
    $mail->setFrom('landryamengne@gmail.com', 'Inscription pour une formation');

} catch (Exception $e) {
    error_log("Erreur de configuration PHPMailer : " . $mail->ErrorInfo);
}
?>
