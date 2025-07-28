<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$config = include(__DIR__ . '/../config/config.php');
$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) die("Erreur DB");

function getIpAddress() {
  return $_SERVER['HTTP_CLIENT_IP']
    ?? $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR'];
}

$ip = getIpAddress();
$username = '';
$messageErreur = '';
$connexionReussie = false;
$bloque = false;
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Blocage IP
$stmt = $conn->prepare("SELECT MAX(date_connexion) as last_fail FROM login_logs WHERE ip_address = ? AND statut = 'échec'");
$stmt->bind_param("s", $ip);
$stmt->execute();
$lastFail = strtotime($stmt->get_result()->fetch_assoc()['last_fail'] ?? '');
$now = time();

$stmt = $conn->prepare("SELECT COUNT(*) FROM login_logs WHERE ip_address = ? AND statut = 'échec' AND date_connexion > (NOW() - INTERVAL 15 MINUTE)");
$stmt->bind_param("s", $ip);
$stmt->execute();
$stmt->bind_result($nbFails);
$stmt->fetch();
$stmt->close();

if ($nbFails >= 5 && ($now - $lastFail) < 900) {
  $bloque = true;
  $messageErreur = "🚫 Trop de tentatives. Réessayez dans 15 minutes.";
  if (!isset($_SESSION['ip_alert_sent'])) {
    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = $config['SMTP_USER'];
      $mail->Password = $config['SMTP_PASS'];
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;
      $mail->setFrom($config['SMTP_USER'], 'FECACFOP Sécurité');
      $mail->addAddress($config['ADMIN_EMAIL']);

      $heure = date("Y-m-d H:i:s");
      $mail->isHTML(true);
      $mail->Subject = '🚨 Tentatives excessives détectées';
      $mail->Body = "<p><strong>IP :</strong> $ip</p><p><strong>Heure :</strong> $heure</p><p><strong>Navigateur :</strong><br>{$_SERVER['HTTP_USER_AGENT']}</p>";

      $mail->send();
      $_SESSION['ip_alert_sent'] = true;
    } catch (Exception $e) {
      error_log("Alerte non envoyée : " . $mail->ErrorInfo);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$bloque) {
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Requête non autorisée.");
  }

  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  $navigateur = $_SERVER['HTTP_USER_AGENT'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['username'];
    $_SESSION['role'] = $user['role'] ?? 'utilisateur';
    session_regenerate_id(true);
    $_SESSION['ip_alert_sent'] = false;
    $connexionReussie = true;
    $status = 'succès';
  } else {
    $status = 'échec';
    $messageErreur = "Nom d'utilisateur ou mot de passe incorrect.";
  }

  $log = $conn->prepare("INSERT INTO login_logs (ip_address, username, statut, navigateur) VALUES (?, ?, ?, ?)");
  $log->bind_param("ssss", $ip, $username, $status, $navigateur);
  $log->execute();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion FECACFOP</title>
  <link rel="stylesheet" href="style1.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <style>

    .login-error, .login-success {
      padding: 12px 16px;
      border-radius: 6px;
      font-weight: bold;
      margin: 10px 0 20px;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 14.5px;
    }
    .login-error {
      background-color: #ffe6e6;
      color: #b20000;
      border: 1px solid #ffcccc;
    }
    .login-success {
      background-color: #e6ffe6;
      color: #006600;
      border: 1px solid #b3ffb3;
    }
    .form-group {
      margin-bottom: 15px;
      position: relative;
    }
    .form-group.with-icon input {
      padding-right: 32px;
    }
    .field-icon, .toggle-password {
      position: absolute;
      right: 10px;
      top: 38px;
      cursor: pointer;
    }
    .separator {
      text-align: center;
      margin: 15px 0;
    }
    .social-login {
      display: flex;
      justify-content: center;
      gap: 15px;
    }
    .social-login a {
      font-size: 20px;
      color: #444;
    }
    .reset-form {
      display: none;
    }
    .reset-form.active, .login-form.active {
      display: block;
    }
    .login-form:not(.active), .reset-form:not(.active) {
      display: none;
    }
    input[type="text"],
input[type="password"],
input[type="email"] {
  pointer-events: auto !important;
  opacity: 1 !important;
  z-index: 1 !important;
}
.form-group input {
  position: relative;
  z-index: 2;
}
.field-icon {
  z-index: 1;
}


  </style>
</head>
<body>
  <div class="login-container">

    <!-- Connexion -->
    <?php if (!$bloque) : ?>
    <form class="login-form active" id="loginForm" method="post" action="">
      <h2 class="animated-title">Authentification FECACFOP</h2>

      <?php if (!empty($messageErreur)) : ?>
        <div class="login-error"><i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($messageErreur) ?></div>
      <?php endif; ?>

      <?php if ($connexionReussie) : ?>
        <div class="login-success"><i class="bi bi-check-circle-fill"></i> Connexion réussie ! Redirection...</div>
        <script>setTimeout(() => window.location.href = 'welcome.php', 2000);</script>
      <?php endif; ?>

      <div class="form-group with-icon">
        <label>Nom d'utilisateur</label>
        <input type="text" name="username" required autofocus>

       
        <i class="bi bi-person field-icon"></i>
      </div>

      <div class="form-group with-icon">
        <label>Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <i class="bi bi-eye toggle-password" id="togglePassword"></i>
      </div>

      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

      <div class="form-footer">
        <a href="#" id="showReset">Mot de passe oublié ?</a>
      </div>

      <button type="submit" class="btn">Connexion</button>

      <div class="separator">ou continuez avec</div>
      <div class="social-login">
        <a href="#"><i class="bi bi-google"></i></a>
        <a href="#"><i class="bi bi-facebook"></i></a>
        <a href="#"><i class="bi bi-github"></i></a>
        <a href="#"><i class="bi bi-linkedin"></i></a>
      </div>
    </form>
    <?php else : ?>
      <div class="login-error">
        <i class="bi bi-shield-lock-fill"></i>
        Formulaire bloqué pour raisons de sécurité.<br>Réessayez dans quelques minutes.
      </div>
    <?php endif; ?>

    <!-- Réinitialisation -->
    <form class="reset-form" id="resetForm" method="post" action="reset_password.php">
      <h2 class="animated-title">Réinitialiser le mot de passe</h2>
      <p class="reset-text">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>

      <div class="form-group with-icon">
        <label>Adresse email</label>
        <input type="email" name="email" required />
        <i class="bi bi-envelope field-icon"></i>
      </div>

      <div class="form-footer">
        <a href="#" id="backToLogin">← Retour à la connexion</a>
      </div>
      <button type="submit" class="btn">Envoyer le lien</button>
    </form>
  </div>

  <script>
    const loginForm = document.getElementById("loginForm");
    const resetForm = document.getElementById("resetForm");
    const showReset = document.getElementById("showReset");
    const backToLogin = document.getElementById("backToLogin");
    const toggle = document.getElementById("togglePassword");
    const pwdField = document.getElementById("password");

    if (showReset) {
      showReset.addEventListener("click", (e) => {
        e.preventDefault();
        loginForm?.classList.remove("active");
        resetForm.classList.add("active");
      });
    }

    if (backToLogin) {
      backToLogin.addEventListener("click", (e) => {
        e.preventDefault();
        resetForm.classList.remove("active");
        loginForm?.classList.add("active");
      });
    }

    if (toggle && pwdField) {
      toggle.addEventListener("click", () => {
        const type = pwdField.getAttribute("type") === "password" ? "text" : "password";
        pwdField.setAttribute("type", type);
        toggle.classList.toggle("bi-eye");
        toggle.classList.toggle("bi-eye-slash");
      });
    }
  </script>


</body>
</html>
