<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit();
}
$nom = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bienvenue</title>
  <style>
    body {
      background: linear-gradient(135deg, #0e1e40, #002244);
      color: #ffffff;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      text-align: center;
    }

    h1, p {
      margin: 0;
      padding: 10px 0;
    }

    h1 {
      font-size: 2.2rem;
      animation: fadeInDown 0.7s ease-out;
    }

    p {
      font-size: 1.1rem;
      opacity: 0.9;
      animation: fadeInUp 0.8s ease-in;
    }

    .spinner {
      margin-top: 30px;
      width: 55px;
      height: 55px;
      border: 6px solid #ffffff30;
      border-top: 6px solid #ffffff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <h1>Bienvenue, <?= htmlspecialchars($nom) ?></h1>
  <p>Nous nous occupons de tout, veuillez patienter...</p>
  <div class="spinner"></div>

  <script>
    setTimeout(() => {
      window.location.href = "/Plateforme_web_du_FECACFOP/dashboard/index.php";
    }, 3500); // redirection en 2.5 secondes
  </script>
</body>
</html>
