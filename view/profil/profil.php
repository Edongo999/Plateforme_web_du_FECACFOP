<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon profil</title>

  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .box {
      max-width: 450px;
      margin: 60px auto;
      padding: 30px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 0 18px rgba(0,0,0,0.08);
    }

    .avatar {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #007bff;
      margin: 0 auto 20px;
      display: block;
    }

    .input-group-text {
      background-color: #007bff;
      color: #fff;
      border: none;
    }
  </style>
</head>
<body>

<div class="box">
  <h4 class="text-center mb-4">👤 Modifier mon profil</h4>

  <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success text-center">✅ Profil mis à jour avec succès</div>
  <?php endif; ?>

  <img class="avatar" src="/uploads/<?php echo $user['photo'] ?? 'default.jpg'; ?>" alt="Photo">

  <form method="POST" action="/Plateforme_web_du_FECACFOP/dashboard/settings/profil/update" enctype="multipart/form-data">
    
    <!-- Nom d'utilisateur -->
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-user"></i></span>
      </div>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
    </div>

    <!-- Email -->
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
      </div>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required>
    </div>

    <!-- Photo -->
    <div class="form-group">
      <label for="photo"><i class="fas fa-image text-primary"></i> Photo de profil</label>
      <input type="file" name="photo" id="photo" class="form-control-file">
    </div>

    <!-- Mot de passe -->
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-lock"></i></span>
      </div>
      <input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe">
    </div>

    <button type="submit" class="btn btn-primary btn-block">💾 Mettre à jour</button>
  </form>
</div>

</body>
</html>
