<?php
// Vérification que l'ID est présent dans la requête
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("ID de la publicité non spécifié !");
}

$id = $_POST['id'];
$titre = $_POST['titre'];
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Validation des champs
if (empty($titre) || empty($date_debut) || empty($date_fin)) {
    die("Tous les champs obligatoires doivent être remplis !");
}

// Gestion de l'upload du média
$media_path = null;
if (!empty($_FILES['media']['name'])) {
    $media_name = basename($_FILES['media']['name']);
    $media_path = "uploads/publicites/" . uniqid() . "_" . $media_name;
    $media_type = $_FILES['media']['type'];

    // Vérification du type de fichier (image ou vidéo)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
    if (!in_array($media_type, $allowed_types)) {
        die("Type de fichier non autorisé !");
    }

    // Déplacement du fichier uploadé
    if (!move_uploaded_file($_FILES['media']['tmp_name'], $media_path)) {
        die("Erreur lors de l'upload du fichier média !");
    }

    // Suppression de l'ancien fichier si un nouveau est uploadé
    $result = $conn->query("SELECT media_path FROM publicites WHERE id='$id'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ancien_media = $row['media_path'];
        if (!empty($ancien_media) && file_exists($ancien_media)) {
            unlink($ancien_media); // Suppression du fichier
        }
    }
}

// Préparation de la requête de mise à jour
$sql = "UPDATE publicites SET 
            titre = ?, 
            date_debut = ?, 
            date_fin = ?, 
            media_path = IFNULL(?, media_path)
        WHERE id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erreur lors de la préparation de la requête : " . $conn->error);
}

// Liaison des paramètres
$stmt->bind_param("ssssi", $titre, $date_debut, $date_fin, $media_path, $id);

// Exécution de la requête
if ($stmt->execute()) {
    echo "✔️ Publicité mise à jour avec succès !";
} else {
    echo "❌ Erreur lors de la mise à jour de la publicité : " . $stmt->error;
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
?>
