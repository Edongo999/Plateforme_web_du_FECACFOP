<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class PasswordController {
  private $userModel;
  private $config;

  public function __construct($db) {
    $this->userModel = new UserModel($db);
    $configPath = __DIR__ . '/../config/config.php';
    $this->config = file_exists($configPath) ? include($configPath) : [];
  }

  public function showRequestForm() {
    require './views/password/request_reset.php';
  }

  public function sendResetLink() {
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $messageErreur = '';
    $messageSucces = '';

    if (!$email) {
      $messageErreur = "Adresse e-mail invalide.";
    } else {
      $token = bin2hex(random_bytes(50));
      $expire = date("Y-m-d H:i:s", strtotime("+15 minutes"));

      $this->userModel->storeResetToken($email, $token, $expire);
      $link = "http://127.0.0.1/Plateforme_web_du_FECACFOP/index.php?page=reset&token=$token";

      try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $this->config['SMTP_USER'];
        $mail->Password = $this->config['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom($this->config['SMTP_USER'], 'FECACFOP Sécurité');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = '🔐 Réinitialisation du mot de passe';
        $mail->Body = "
          <h3>Bonjour,</h3>
          <p>Clique sur ce lien pour réinitialiser ton mot de passe :</p>
          <p><a href='$link'>$link</a></p>
          <p><em>Ce lien expire dans 15 minutes.</em></p>
        ";
        $mail->send();
        $messageSucces = "Lien envoyé avec succès à <strong>$email</strong>. Vérifie ta boîte mail.";
      } catch (Exception $e) {
        $messageErreur = "Erreur : " . $mail->ErrorInfo;
      }
    }

    require './views/password/request_reset.php';
  }
}
