<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Publicité</title>
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
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .btn-save {
            background-color: #4caf50;
            color: white;
        }
        .btn-save:hover {
            background-color: #43a047;
        }
        .btn-cancel {
            background-color: #f44336;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #e53935;
        }
  
        #modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9); /* Arrière-plan clair et translucide */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

        #modal img, #modal video {
            max-width: 90%;
            max-height: 80%;
            border-radius: 5px;
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
        <h2>Modifier une Publicité</h2>
        <form id="modifierPubliciteForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" value="Exemple Titre" required>
            </div>
            <div class="form-group">
                <label for="media">Média :</label>
                <input type="file" id="media" name="media" accept="image/*,video/mp4">
                <button type="button" id="previewButton" class="btn btn-save">Aperçu</button>
            </div>
            <div class="form-group">
                <label for="date_debut">Date de début :</label>
                <input type="date" id="date_debut" name="date_debut" value="2025-04-09" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Date de fin :</label>
                <input type="date" id="date_fin" name="date_fin" value="2025-04-30" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-save">Enregistrer</button>
                <button type="button" class="btn btn-cancel" onclick="window.history.back()">Annuler</button>
            </div>
        </form>
    </div>

    <!-- Modal pour afficher l'aperçu -->
    <div id="modal">
        <button class="modal-close" onclick="closeModal()">Fermer</button>
        <img id="modalImage" alt="Aperçu du média" style="display: none;">
        <video id="modalVideo" controls style="display: none;"></video>
    </div>

    <script>
        const mediaInput = document.getElementById('media');
        const previewButton = document.getElementById('previewButton');
        const modal = document.getElementById('modal');
        const modalImage = document.getElementById('modalImage');
        const modalVideo = document.getElementById('modalVideo');

        // Gérer l'aperçu du fichier média
        previewButton.addEventListener('click', function () {
            const file = mediaInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const fileType = file.type;
                    if (fileType.startsWith('image')) {
                        modalImage.src = e.target.result;
                        modalImage.style.display = 'block';
                        modalVideo.style.display = 'none';
                    } else if (fileType.startsWith('video')) {
                        modalVideo.src = e.target.result;
                        modalVideo.style.display = 'block';
                        modalImage.style.display = 'none';
                    }
                    modal.style.display = 'flex';
                };
                reader.readAsDataURL(file);
            } else {
                alert('Veuillez sélectionner un fichier pour utiliser l’aperçu.');
            }
        });

        // Fermer le modal
        function closeModal() {
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
