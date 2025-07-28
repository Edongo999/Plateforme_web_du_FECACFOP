<?php

class ProfilController {
  private $userModel;

  public function __construct($db) {
    $this->userModel = new UserModel($db);
  }

  public function afficherProfil() {
    $username = $_SESSION['user'];
    $user = $this->userModel->getByUsername($username);
    require '/Plateforme_web_du_FECACFOP/dashboard/views/profil/profil.php';
  }

  public function mettreAJourProfil() {
    $oldUsername = $_SESSION['user'];
    $newUsername = $_POST['username'] ?? $oldUsername;
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? null;
    $photo = null;

    if (!empty($_FILES['photo']['name'])) {
      $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
      $allowed = ['jpg', 'jpeg', 'png'];
      $mime = mime_content_type($_FILES['photo']['tmp_name']);
      if (in_array($extension, $allowed) && str_starts_with($mime, 'image/')) {
        $photo = $newUsername . "_" . time() . "." . $extension;
        $uploadDir = __DIR__ . '/../uploads/';
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photo);
      }
    }

    $this->userModel->updateProfile($oldUsername, $newUsername, $email, $password, $photo);
    $_SESSION['user'] = $newUsername;
    header("Location: /Plateforme_web_du_FECACFOP/dashboard/settings/profil/profil?updated=1");
    exit();
  }
}
