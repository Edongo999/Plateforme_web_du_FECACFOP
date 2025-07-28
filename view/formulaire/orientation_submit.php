<?php
header('Content-Type: application/json');
require_once 'connexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 🔹 Chargement sécurisé de config
$configPath = __DIR__ . '/../../config/config.php';
if (!file_exists($configPath)) {
    die(json_encode(["success" => false, "message" => "config.php introuvable."]));
}
$config = include($configPath);
if (!is_array($config)) {
    die(json_encode(["success" => false, "message" => "config.php invalide."]));
}

// 🔹 Vérifie la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(["success" => false, "message" => "Méthode non autorisée."]));
}

// 🔹 Récupération et validation
$profil    = htmlspecialchars(trim($_POST['profil'] ?? ''));
$niveau    = htmlspecialchars(trim($_POST['niveau'] ?? ''));
$telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
$email     = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

if (!$profil || !$niveau || !$telephone || !$email) {
    echo json_encode(["success" => false, "message" => "Tous les champs sont requis."]);
    exit;
}

// 🔹 Insertion dans la base
$stmt = $conn->prepare("INSERT INTO orientation_requests (profil, niveau, telephone, email) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $profil, $niveau, $telephone, $email);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "✅ Votre demande a été enregistrée."]);
    ob_flush();
    flush();
    ignore_user_abort(true); // poursuis l’exécution même si le navigateur ferme

    // 🔸 Email à l’administrateur
    try {
        $mailAdmin = new PHPMailer(true);
        $mailAdmin->isSMTP();
        $mailAdmin->Host = 'smtp.gmail.com';
        $mailAdmin->SMTPAuth = true;
        $mailAdmin->Username = $config['SMTP_USER'];
        $mailAdmin->Password = $config['SMTP_PASS'];
        $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailAdmin->Port = 587;

        $mailAdmin->setFrom($config['SMTP_USER'], 'Plateforme Orientation');
        $mailAdmin->addAddress($config['ADMIN_EMAIL']);

        $mailAdmin->isHTML(true);
        $mailAdmin->Subject = '🧭 Nouvelle demande d’orientation';
        $mailAdmin->Body = "
            <h3>Nouvelle demande reçue :</h3>
            <p><strong>Profil :</strong> $profil</p>
            <p><strong>Niveau :</strong> $niveau</p>
            <p><strong>Téléphone :</strong> $telephone</p>
            <p><strong>Email :</strong> $email</p>
        ";
        $mailAdmin->send();
    } catch (Exception $e) {
        error_log("❌ Email admin : {$mailAdmin->ErrorInfo}");
    }

    // 🔸 Email à l’utilisateur
    try {
        $mailUser = new PHPMailer(true);
        $mailUser->isSMTP();
        $mailUser->Host = 'smtp.gmail.com';
        $mailUser->SMTPAuth = true;
        $mailUser->Username = $config['SMTP_USER'];
        $mailUser->Password = $config['SMTP_PASS'];
        $mailUser->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailUser->Port = 587;

        $mailUser->setFrom($config['SMTP_USER'], 'Équipe Orientation FECACFOP');
        $mailUser->addAddress($email);

        $mailUser->isHTML(true);
        $mailUser->Subject = '✅ Nous avons bien reçu votre demande';
        $mailUser->Body = "
            <p>Bonjour,</p>
            <p>Merci pour votre demande d’orientation. Un conseiller vous contactera très bientôt.</p>
            <p><strong>Votre profil :</strong> $profil</p>
            <p><strong>Niveau :</strong> $niveau</p>
            <p>— L’équipe FECACFOP</p>
        ";
        $mailUser->send();
    } catch (Exception $e) {
        error_log("❌ Email utilisateur : {$mailUser->ErrorInfo}");
    }

} else {
    error_log("❌ Erreur MySQL : " . $stmt->error);
            echo json_encode([
        "success" => true,
        "redirect" => "orientation-confirmation.php"
        ]);

   
}

$stmt->close();
$conn->close();
