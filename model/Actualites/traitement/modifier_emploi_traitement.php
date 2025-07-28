<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $titre = $conn->real_escape_string($_POST['titre']);
    $description = $conn->real_escape_string($_POST['description']);
    $ancien_media = isset($_POST['ancien_media']) ? $_POST['ancien_media'] : '';

    if (!empty($_FILES['media']['name'])) {
        $media_name = basename($_FILES['media']['name']);
        $media_path = "uploads/emplois/" . uniqid() . "_" . $media_name;

        if (!move_uploaded_file($_FILES['media']['tmp_name'], $media_path)) {
            die("Erreur lors du téléchargement du fichier média.");
        }

        if (!empty($ancien_media) && file_exists($ancien_media)) {
            unlink($ancien_media);
        }
    } else {
        $media_path = $ancien_media;
    }

    $query = "UPDATE emplois SET titre = '$titre', description = '$description', media = '$media_path', date_publication = NOW() WHERE id = $id";

    if ($conn->query($query)) {
        echo "Offre d'emploi modifiée avec succès !";
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}
$conn->close();
?>
