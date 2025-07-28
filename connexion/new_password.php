




<?php
session_start();
require_once(__DIR__ . '/../config/connexion.php');

// 1. Récupération du token depuis l'URL
$token = $_GET['token'] ?? '';
if (!$token) {
  die("<div style='color:red; font-weight:bold;'>❌ Lien invalide ou expiré.</div>");
}

// 2. Vérification du token dans la base de données
$stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// 3. Validation du token et de sa date d’expiration
if (!$user || strtotime($user['token_expire']) < time()) {
  die("<div style='color:red; font-weight:bold;'>❌ Lien expiré ou non valide.</div>");
}

// 4. Traitement du formulaire s’il est soumis
$erreur = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pwd1 = $_POST['password'] ?? '';
  $pwd2 = $_POST['confirm'] ?? '';

  if (strlen($pwd1) < 6) {
    $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
  } elseif ($pwd1 !== $pwd2) {
    $erreur = "Les mots de passe ne correspondent pas.";
  } else {
    $hashed = password_hash($pwd1, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expire = NULL WHERE id = ?");
    $stmt->bind_param("si", $hashed, $user['id']);
    $stmt->execute();
    $success = true;
// Redirection vers la page de connexion après succès
header("Location: http://127.0.0.1/Plateforme_web_du_FECACFOP/connexion/login1.php");
exit;

  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>FECACFOP — Nouveau mot de passe</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #005BAC, #0072cc);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .form-container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
      width: 460px;
      max-width: 90vw;
      text-align: center;
    }
    .form-container h1 {
      font-size: 20px;
      color: #0072cc;
      margin-bottom: 5px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .form-container .slogan {
      font-size: 13px;
      color: #777;
      margin-bottom: 20px;
    }
    h2 {
      font-size: 1.6em;
      color: #005BAC;
      margin-bottom: 25px;
    }
    .form-group {
      margin-bottom: 20px;
      position: relative;
      text-align: left;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #333;
    }
    input[type="password"] {
      width: 100%;
      padding: 14px 16px;
      padding-left: 42px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1em;
      outline: none;
      transition: 0.3s;
    }
    input[type="password"]:focus {
      border-color: #0072cc;
      box-shadow: 0 0 6px rgba(0, 114, 204, 0.3);
    }
    .field-icon {
      position: absolute;
      left: 12px;
      top: 41px;
      color: #888;
      font-size: 1.1em;
    }
    .btn {
      width: 100%;
      padding: 14px;
      background: #005BAC;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1em;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn:hover {
      background: #004080;
      transform: scale(1.03);
      box-shadow: 0 0 10px #0072cc55;
    }
    .success-msg {
      color: green;
      margin-bottom: 15px;
      font-weight: bold;
    }
    .error-msg {
      color: red;
      margin-bottom: 15px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>FECACFOP</h1>
    <div class="slogan">Fédération Camerounaise des Centres de Formation Professionnelle</div>
    <h2>🔐 Réinitialiser votre mot de passe</h2>

    <?php if ($success): ?>
      <div class="success-msg">✅ Mot de passe mis à jour avec succès.</div>
    <?php elseif (!empty($erreur)): ?>
      <div class="error-msg">❌ <?= $erreur ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="form-group">
        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" required />
        <i class="bi bi-lock-fill field-icon"></i>
      </div>

      <div class="form-group">
        <label for="confirm">Confirmer le mot de passe</label>
        <input type="password" id="confirm" name="confirm" required />
        <i class="bi bi-shield-lock-fill field-icon"></i>
      </div>

      <button type="submit" class="btn">Mettre à jour</button>
    </form>
  </div>
</body>
</html>
