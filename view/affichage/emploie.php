
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "rapcefop");

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $media = $_FILES['media'];

    // Vérifiez si le fichier a été téléchargé correctement
    if (isset($media) && $media['error'] === 0) {
        $target_dir = "uploads/images/"; // Chemin uniquement pour les images
        $target_file = $target_dir . basename($media['name']); // Nom complet du fichier

        // Déplace le fichier dans le dossier approprié
        if (move_uploaded_file($media['tmp_name'], $target_file)) {
            echo "Image téléchargée avec succès !";

            $date_publication = date("Y-m-d H:i:s");

            // Préparation de la requête SQL avec bind_param pour éviter les erreurs
            $stmt = $conn->prepare("INSERT INTO emplois (titre, description, date_publication, media) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $titre, $contenu, $date_publication, $target_file);

            // Exécution de la requête
            if ($stmt->execute()) {
                echo "Offre d'emploi publiée avec succès !";
            } else {
                echo "Erreur : " . $stmt->error;
            }

            // Fermeture de la requête
            $stmt->close();
        } else {
            echo "Erreur lors du déplacement du fichier.";
        }
    } else {
        // Affiche un message d'erreur spécifique
        $error_message = match ($media['error']) {
            UPLOAD_ERR_INI_SIZE => "Le fichier dépasse la taille maximale autorisée par le serveur.",
            UPLOAD_ERR_FORM_SIZE => "Le fichier dépasse la limite définie dans le formulaire HTML.",
            UPLOAD_ERR_PARTIAL => "Le fichier n'a été que partiellement téléchargé.",
            UPLOAD_ERR_NO_FILE => "Aucun fichier n'a été téléchargé.",
            default => "Erreur inconnue lors du téléchargement."
        };
        echo $error_message;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une Offre d'Emploi</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <header class="header">
        <h1>Publier une Offre d'Emploi</h1>
    </header>
    <main class="container">
        <form action="" method="POST" enctype="multipart/form-data" class="form-publier">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" placeholder="Entrez le titre de l'offre" required>
            </div>

            <div class="form-group">
                <label for="contenu">Description :</label>
                <textarea id="contenu" name="contenu" rows="5" placeholder="Détaillez l'offre d'emploi ici..." required></textarea>
            </div>

            <div class="form-group">
                <label for="media">Ajouter une image :</label>
                <input type="file" id="media" name="media" accept="image/*" required>
            </div>
            
            <button type="submit" class="btn-submit">Publier l'Offre</button>
        </form>
    </main>
</body>
</html>

