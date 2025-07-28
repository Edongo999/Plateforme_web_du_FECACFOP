<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Offre d'Emploi</title>
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
        #formMessage {
            text-align: center;
            font-size: 16px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        #modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        #modal img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 10px;
        }
        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .modal-close:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modifier une Offre d'Emploi</h2>
        <div id="formMessage" style="display: none; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;"></div>
        <?php
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("ID de l'offre non spécifié !");
        }
        $id = $_GET['id'];
        $conn = new mysqli("localhost", "root", "", "rapcefop");
        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }
        $result = $conn->query("SELECT * FROM emplois WHERE id='$id'");
        if ($result->num_rows === 0) {
            die("Aucune offre trouvée pour l'ID donné !");
        }
        $emploi = $result->fetch_assoc();
        ?>
        <form id="modifierEmploiForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $emploi['id'] ?>">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($emploi['titre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($emploi['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="media">Média :</label>
                <input type="file" id="media" name="media" accept="image/*">
                <small>Fichier actuel : <?= htmlspecialchars($emploi['media']); ?></small>
                <button type="button" id="previewButton" class="btn btn-save" style="background-color: #007bff;">Aperçu</button>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-save">Enregistrer</button>
                <button type="button" onclick="window.location.href='tableau.php#emploi';" class="btn btn-cancel">Annuler</button>
            </div>
        </form>
    </div>
    <!-- Modal pour afficher l'aperçu de l'image -->
    <div id="modal">
        <button class="modal-close" onclick="closeModal()">Fermer</button>
        <img id="modalImage" alt="Aperçu de l'image">
    </div>
    <script>
        // Gérer l'aperçu de l'image
        document.getElementById('previewButton').addEventListener('click', function () {
            const fileInput = document.getElementById('media');
            const file = fileInput.files[0];
            const modal = document.getElementById('modal');
            const modalImage = document.getElementById('modalImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    modalImage.src = e.target.result;
                    modal.style.display = 'flex';
                };
                reader.readAsDataURL(file);
            } else {
                alert("Veuillez sélectionner un fichier avant d'utiliser l'aperçu.");
            }
        });

        // Fermer le modal
        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }

        document.getElementById('modifierEmploiForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Empêche le rechargement de la page

            const form = event.target;
            const formData = new FormData(form);

            fetch('modifier_emploi_traitement.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                const messageBox = document.getElementById('formMessage');
                messageBox.style.display = 'block';
                messageBox.style.backgroundColor = '#d4edda'; // Vert clair
                messageBox.style.color = '#155724'; // Texte vert foncé
                messageBox.textContent = "✔️ Offre d'emploi modifiée avec succès !";

                // Faire disparaître le message après 5 secondes
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 5000); // 5000 millisecondes = 5 secondes
            })
            .catch(error => {
                const messageBox = document.getElementById('formMessage');
                messageBox.style.display = 'block';
                messageBox.style.backgroundColor = '#f8d7da'; // Rouge clair
                messageBox.style.color = '#721c24'; // Texte rouge foncé
                messageBox.textContent = "❌ Une erreur s'est produite. Veuillez réessayer.";

                // Faire disparaître le message après 5 secondes
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 5000);
                console.error("Erreur :", error);
            });
        });
    </script>
</body>
</html>
