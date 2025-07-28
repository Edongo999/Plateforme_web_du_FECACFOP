<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Actualité</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 95%;
            max-width: 550px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 16px;
            color: #555;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-group input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
        }
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-save {
            background-color: #4caf50;
        }
        .btn-save:hover {
            background-color: #43a047;
        }
        .btn-cancel {
            background-color: #f44336;
        }
        .btn-cancel:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modifier une Actualité</h2>
        <?php
        // Vérification de l'ID passé via l'URL
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("ID de l'actualité non spécifié !");
        }
        $id = $_GET['id'];

        // Connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "rapcefop");
        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        // Récupération des données pour pré-remplir le formulaire
        $result = $conn->query("SELECT * FROM actualites1 WHERE id='$id'");
        if ($result->num_rows === 0) {
            die("Aucune actualité trouvée pour l'ID donné !");
        }
        $row = $result->fetch_assoc();
        ?>
        <form action="modifier_actualites_traitement.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($row['titre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="contenu">Contenu :</label>
                <textarea id="contenu" name="contenu" rows="5" required><?php echo htmlspecialchars($row['contenu']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_publication">Date de publication :</label>
                <input type="text" id="date_publication" name="date_publication" value="<?php echo htmlspecialchars($row['date_publication']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="media">Média :</label>
                <input type="file" id="media" name="media">
                <small>Fichier actuel : <?php echo htmlspecialchars($row['media']); ?></small>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-save">Enregistrer</button>
                <button type="button" onclick="window.history.back();" class="btn btn-cancel">Annuler</button>
            </div>
        </form>
    </div>
</body>
</html>
