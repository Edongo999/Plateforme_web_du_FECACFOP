<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Publication</title>
    <style>
        /* Vos styles ici */
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modifier une Publication</h2>
        <?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $media = $_FILES['media'];

    // Gestion du média
    if ($media['error'] === 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($media["name"]);
        move_uploaded_file($media["tmp_name"], $target_file);
    } else {
        $target_file = $_POST['existing_media'];
    }

    // Mise à jour dans la base de données
    $stmt = $conn->prepare("UPDATE actualites1 SET titre=?, contenu=?, media=?, is_modified=TRUE WHERE id=?");
    $stmt->bind_param("sssi", $titre, $contenu, $target_file, $id);

    if ($stmt->execute()) {
        header("Location: tableau.php?modified_id=$id"); // Redirection avec l'ID modifié
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

        <form action="modifier_publication_traitement.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($row['titre'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="contenu">Contenu :</label>
                <textarea id="contenu" name="contenu" rows="5" required><?php echo htmlspecialchars($row['contenu'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_publication">Date de publication :</label>
                <input type="text" id="date_publication" name="date_publication" value="<?php echo htmlspecialchars(date('Y-m-d')); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="media">Média :</label>
                <input type="file" id="media" name="media">
                <small>Fichier actuel : <?php echo htmlspecialchars($row['media'] ?? 'Aucun fichier'); ?></small>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-save">Enregistrer</button>
                <button type="button" onclick="window.history.back();" class="btn btn-cancel">Annuler</button>
            </div>
        </form>
    </div>
</body>
</html>
