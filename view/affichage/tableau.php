<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface de Gestion des Publications</title>
    <style>
        /* Style général */
        /* Style général */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #1c2331;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 32px;
            font-weight: bold;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #2e4053;
            padding: 15px;
        }

        nav button {
            background-color: transparent;
            border: none;
            color: white;
            padding: 10px 25px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        nav button.active {
            color: #f39c12;
            border-bottom: 3px solid #f39c12;
        }
        nav button:hover {
            color: #f39c12;
        }
 
        .tab-content {
            display: none;
            margin: 20px auto;
            max-width: 90%;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 25px;
            animation: fadeIn 0.5s;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            font-size: 18px;
        }
        th {
            background-color: #2e4053;
            color: white;
        }
        td {
            background-color: #f8f9fa;
        }
        td:hover {
            background-color: #e9ecef;
        }
        .media-container img, .media-container video {
            max-width: 120px;
            max-height: 120px;
            margin: auto;
            display: block;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }
        .btn-edit {
            background-color: #3498db;
            color: white;
        }
        .btn-edit:hover {
            background-color: #217dbb;
        }
        .btn-archive {
            background-color: #e74c3c;
            color: white;
        }
        .btn-archive:hover {
            background-color: #c0392b;
        }
        /* Surbrillance pour les lignes modifiées */
        tr[style*='background-color: #e8f5e9'] {
            animation: fadeout 5s ease-in-out forwards;
        }

        @keyframes fadeout {
            from { background-color: #e8f5e9; }
            to { background-color: white; }
        }

        /* Badge Modifié */
        span[style*='color: #00796b'] {
            font-size: 12px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 10px;
            background-color: #e0f7fa;
            color: #00796b;
        }
                /* Permet au tableau de défiler horizontalement */
       /* Rendre le tableau défilable horizontalement sur petits écrans */
        .table-responsive {
            overflow-x: auto; /* Activer le défilement horizontal */
            -webkit-overflow-scrolling: touch; /* Support fluide pour iOS */
        }

        /* Style général pour petits écrans */
        @media screen and (max-width: 768px) {
            table {
                font-size: 12px; /* Réduire la taille des textes dans le tableau */
            }

            th, td {
                padding: 8px; /* Espacement réduit pour petits écrans */
            }

            td {
                word-wrap: break-word; /* Permet au texte long de revenir à la ligne */
                white-space: normal;
            }

            th {
                font-size: 14px; /* Réduire légèrement la taille des en-têtes */
            }
        }

        /* Style du tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
            white-space: nowrap; /* Évite les retours à la ligne inutiles */
        }

        thead {
            background-color: #f4f6f9;
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f9fbfd;
        }

        @media screen and (max-width: 768px) {
            th, td {
                font-size: 14px; /* Texte plus petit pour les petits écrans */
            }

            th, td:first-child {
                padding-left: 10px;
            }
        }

           /* Style de pagination responsive */
        .btn-pagination {
            display: inline-block; /* Les boutons seront alignés horizontalement */
            padding: 8px 12px;
            margin: 5px;
            border: 1px solid #ddd;
            background-color: #f4f4f4;
            color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            font-size: 14px; /* Ajuste la taille du texte */
        }

        .btn-pagination:hover {
            background-color: #007bff;
            color: white;
        }

        /* Responsive pagination pour petits écrans */
        @media screen and (max-width: 768px) {
            .btn-pagination {
                padding: 6px 10px; /* Boutons plus petits */
                font-size: 12px; /* Texte réduit pour petits écrans */
                margin: 2px; /* Réduire l'espacement entre les boutons */
            }

            /* Centrer les boutons sur petits écrans */
            div[style*="text-align: center;"] {
                display: flex;
                flex-wrap: wrap; /* Permet aux boutons de passer à la ligne si nécessaire */
                justify-content: center; /* Centre les boutons */
                gap: 5px; /* Espacement uniforme entre les boutons */
            }
        }

        .btn-pagination.active {
            background-color: #007bff; /* Fond bleu pour la page active */
            color: white; /* Texte blanc pour la page active */
            border: 1px solid #0056b3; /* Bordure légèrement plus foncée */
        }




    </style>
</head>
<body>
    <header>Modifications et Archivages des Publications</header>
    <nav>
        <button class="tab-button active" data-tab="actualite">Actualités</button>
        <button class="tab-button" data-tab="emploi">Offres d'Emploi</button>
        <button class="tab-button" data-tab="publicite">Publicités</button>
    </nav>

    <!-- Actualités -->

           <!-- Section Actualités -->
           <div class="table-responsive">
           <div id="actualite" class="tab-content active">
    <h2>Liste des Actualités</h2>
    <div style="overflow-x: auto; max-width: 100%;">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Média</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>



        <?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

// Définir les paramètres de pagination
$limite = 10; // Nombre de lignes par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page actuelle
$page_actualites = isset($_GET['page_actualites']) ? (int)$_GET['page_actualites'] : 1;
$debut_actualites = ($page_actualites - 1) * $limite;

// Filtrer par état de l'archivage

if (isset($_GET['view']) && $_GET['view'] === 'archived') {
    $result = $conn->query("SELECT * FROM actualites1 WHERE is_archived=TRUE LIMIT $debut_actualites, $limite");
} else {
    $result = $conn->query("SELECT * FROM actualites1 WHERE is_archived=FALSE LIMIT $debut_actualites, $limite");
}


$total = $conn->query("SELECT COUNT(*) AS total FROM actualites1 WHERE is_archived=FALSE")->fetch_assoc()['total'];
$total_pages = ceil($total / $limite);


while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['titre']}</td>
            <td>
                <span class='short-text'>" . htmlspecialchars(substr($row['contenu'], 0, 30)) . "...</span>
                <button class='btn-lire-plus' onclick='openModal(\"" . htmlspecialchars($row['contenu']) . "\")'>Lire plus</button>
            </td>
            <td class='media-container'>";
    if (pathinfo($row['media'], PATHINFO_EXTENSION) == "mp4") {
        echo "<video controls onclick='openMediaModal(\"{$row['media']}\", \"video\")'>
                <source src='{$row['media']}' type='video/mp4'>
              </video>";
    } else {
        echo "<img src='{$row['media']}' alt='Image' onclick='openMediaModal(\"{$row['media']}\", \"image\")'>";
    }
    echo "</td>
            <td>{$row['date_publication']}</td>
            <td>
                <div style='display: flex; justify-content: center; gap: 10px;'>
                    <a href='modifier_actualites.php?id={$row['id']}' class='btn btn-edit'>Modifier</a>
                   
                    <a href='#' class='btn btn-archive' onclick='confirmerArchivage({$row["id"]})'>Archiver</a>

                  
                </div>
            </td>
        </tr>";
}
$conn->close();
?>



        </tbody>
       
        </table>
        <div style="text-align: center; margin: 20px;">
    <?php if ($page_actualites > 1): ?>
        <a href="?page_actualites=<?= $page_actualites - 1 ?>" class="btn-pagination">Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page_actualites=<?= $i ?>" class="btn-pagination <?= ($i === $page_actualites) ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page_actualites < $total_pages): ?>
        <a href="?page_actualites=<?= $page_actualites + 1 ?>" class="btn-pagination">Suivant</a>
    <?php endif; ?>
</div>



    </div> 
</div>
<div id="emploi" class="tab-content">
    <h2>Liste des Offres d'Emploi</h2>
    <div style="overflow-x: auto; max-width: 100%;">
    <table id="emploisTable">

        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Media</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "rapcefop");
            $page_emplois = isset($_GET['page_emplois']) ? (int)$_GET['page_emplois'] : 1;
            $debut_emplois = ($page_emplois - 1) * $limite;
            $result = $conn->query("SELECT * FROM emplois WHERE archived = 0 LIMIT $debut_emplois, $limite");

            $total_emplois = $conn->query("SELECT COUNT(*) AS total FROM emplois")->fetch_assoc()['total'];
            $total_pages_emplois = ceil($total_emplois / $limite);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['titre']}</td>
                        <td>
                            <span class='short-text'>" . htmlspecialchars(substr($row['description'], 0, 30)) . "...</span>
                            <button class='btn-lire-plus' onclick='openModal(\"" . htmlspecialchars($row['description']) . "\")'>Lire plus</button>
                        </td>
                        <td class='media-container'>";
                if (pathinfo($row['media'], PATHINFO_EXTENSION) == "mp4") {
                    echo "<video controls onclick='openMediaModal(\"{$row['media']}\", \"video\")'>
                            <source src='{$row['media']}' type='video/mp4'>
                          </video>";
                } else {
                    echo "<img src='{$row['media']}' alt='Image' onclick='openMediaModal(\"{$row['media']}\", \"image\")'>";
                }
                echo "</td>
                        <td>{$row['date_publication']}</td>
                        <td>
                            <div style='display: flex; justify-content: center; gap: 10px;'>
                                <a href='modifier_emploi.php?id={$row['id']}' class='btn btn-edit'>Modifier</a>
                                <a href='archiver_emploi.php?id={$row['id']}' class='btn btn-archive'>Archiver</a>
                               


                            </div>
                        </td>
                    </tr>";
            }
            $conn->close();
            ?>
        </tbody>
            </table>
            <div style="text-align: center; margin: 20px;">
    <?php if ($page_emplois > 1): ?>
        <a href="?page_emplois=<?= $page_emplois - 1 ?>" class="btn-pagination">Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages_emplois; $i++): ?>
        <a href="?page_emplois=<?= $i ?>" class="btn-pagination <?= ($i === $page_emplois) ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page_emplois < $total_pages_emplois): ?>
        <a href="?page_emplois=<?= $page_emplois + 1 ?>" class="btn-pagination">Suivant</a>
    <?php endif; ?>
</div>
</div>
</div>

<div id="publicite" class="tab-content">
    <h2>Liste des Publicités</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Media</th>
                <th>Dates</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "rapcefop");
            $page_publicites = isset($_GET['page_publicites']) ? (int)$_GET['page_publicites'] : 1;
            $debut_publicites = ($page_publicites - 1) * $limite;
            $result = $conn->query("SELECT * FROM publicites LIMIT $debut_publicites, $limite");
            $total_publicites = $conn->query("SELECT COUNT(*) AS total FROM publicites")->fetch_assoc()['total'];
            $total_pages_publicites = ceil($total_publicites / $limite);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['titre']}</td>
                        <td class='media-container'>";
                if (pathinfo($row['media_path'], PATHINFO_EXTENSION) == "mp4") {
                    echo "<video controls onclick='openMediaModal(\"{$row['media_path']}\", \"video\")'>
                            <source src='{$row['media_path']}' type='video/mp4'>
                          </video>";
                } else {
                    echo "<img src='{$row['media_path']}' alt='Image' onclick='openMediaModal(\"{$row['media_path']}\", \"image\")'>";
                }
                echo "</td>
                        <td>Début : {$row['date_debut']}<br>Fin : {$row['date_fin']}</td>
                        <td>
                            <div style='display: flex; justify-content: center; gap: 10px;'>
                                <a href='modifier_publicites.php?id={$row['id']}' class='btn btn-edit'>Modifier</a>
                                <a href='archiver_publicite.php?id={$row['id']}' class='btn btn-archive'>Archiver</a>
                            </div>
                        </td>
                    </tr>";
            }
            $conn->close();
            ?>
        </tbody>
        </table>
        <div style="text-align: center; margin: 20px;">
    <?php if ($page_publicites > 1): ?>
        <a href="?page_publicites=<?= $page_publicites - 1 ?>" class="btn-pagination">Précédent</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages_publicites; $i++): ?>
        <a href="?page_publicites=<?= $i ?>" class="btn-pagination <?= ($i === $page_publicites) ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page_publicites < $total_pages_publicites): ?>
        <a href="?page_publicites=<?= $page_publicites + 1 ?>" class="btn-pagination">Suivant</a>
    <?php endif; ?>
</div>





</div>
<!-- Modal pour afficher le contenu complet -->
<div id="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background-color: white; padding: 20px; border-radius: 10px; max-width: 600px; width: 90%; position: relative;">
        <h3>Contenu complet</h3>
        <p id="modal-content" style="font-size: 16px; line-height: 1.5;"></p>
        <button onclick="closeModal()" style="position: absolute; top: 10px; right: 10px; background-color: #e74c3c; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">Fermer</button>
    </div>
</div>

<!-- Modal pour afficher les médias -->
<div id="media-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background-color: white; padding: 20px; border-radius: 10px; max-width: 800px; width: 90%; position: relative;">
        <button onclick="closeMediaModal()" style="position: absolute; top: 10px; right: 10px; background-color: #e74c3c; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">Fermer</button>
        <div id="media-content" style="text-align: center;"></div>
    </div>
</div>
<script>
    // Fonction pour ouvrir le modal pour afficher le texte complet
    function openModal(content) {
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modal-content');
        modalContent.textContent = content;
        modal.style.display = 'flex';
    }

    // Fonction pour fermer le modal du texte complet
    function closeModal() {
        const modal = document.getElementById('modal');
        modal.style.display = 'none';
    }

    // Fonction pour ouvrir le modal pour les médias
    function openMediaModal(mediaPath, type) {
        const modal = document.getElementById('media-modal');
        const mediaContent = document.getElementById('media-content');
        mediaContent.innerHTML = ''; // Réinitialiser le contenu précédent

        if (type === 'video') {
            mediaContent.innerHTML = `<video controls style="max-width: 100%; max-height: 500px;">
                                          <source src="${mediaPath}" type="video/mp4">
                                      </video>`;
        } else if (type === 'image') {
            mediaContent.innerHTML = `<img src="${mediaPath}" alt="Image" style="max-width: 100%; max-height: 500px;">`;
        }

        modal.style.display = 'flex';
    }

    // Fonction pour fermer le modal des médias
    function closeMediaModal() {
        const modal = document.getElementById('media-modal');
        modal.style.display = 'none';
    }
</script>

    <script>
        // Gestion des onglets
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab-button');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(btn => btn.classList.remove('active'));
                    contents.forEach(content => content.classList.remove('active'));

                    tab.classList.add('active');
                    document.getElementById(tab.dataset.tab).classList.add('active');
                });
            });
        });
    </script>
    <script>
    function confirmerArchivage(id) {
        if (confirm("Voulez-vous vraiment archiver cette publication ?")) {
            // Redirige vers la page de traitement
            window.location.href = `archiver_actualites_traitement.php?id=${id}`;
            alert("Publication archivée avec succès !");
        } else {
            alert("Action annulée.");
        }
    }
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-button');
    const contents = document.querySelectorAll('.tab-content');
    const urlParams = new URLSearchParams(window.location.search);

    // Vérifier quel tableau est actif (actualites, emplois, publicites)
    if (urlParams.has('page_actualites')) {
        activateTab('actualite');
    } else if (urlParams.has('page_emplois')) {
        activateTab('emploi');
    } else if (urlParams.has('page_publicites')) {
        activateTab('publicite');
    } else {
        // Par défaut, afficher les actualités
        activateTab('actualite');
    }

    function activateTab(tabId) {
        tabs.forEach(tab => tab.classList.remove('active'));
        contents.forEach(content => content.classList.remove('active'));

        document.querySelector(`button[data-tab="${tabId}"]`).classList.add('active');
        document.getElementById(tabId).classList.add('active');
    }
});

</script>
<script>
 // Ouvrir la modale pour modifier une offre d'emploi
function ouvrirModifierEmploiModal(id, titre, description, media) {
    const modal = document.getElementById('modifierEmploiModal');
    modal.style.display = 'flex';

    // Pré-remplir les champs avec les données existantes
    document.getElementById('emploiId').value = id;
    document.getElementById('titre').value = titre;
    document.getElementById('description').value = description;
    document.getElementById('media').value = media;
}

// Fermer la modale
function fermerModifierEmploiModal() {
    const modal = document.getElementById('modifierEmploiModal');
    modal.style.display = 'none';
}

</script>
<script>
    function archiveEmploi(id) {
        if (!confirm("Êtes-vous sûr de vouloir archiver cette offre ?")) {
            return; // Action annulée
        }

        // Envoi de la requête AJAX à `archiver_emploi.php`
        fetch(`archiver_emploi.php?id=${id}`)
            .then(response => response.text()) // Capture la réponse au format texte
            .then(data => {
                showMessage(data, data.includes("✔️") ? "success" : "error"); // Affiche le message
                refreshTable(); // Recharge le tableau
            })
            .catch(error => {
                console.error("Erreur :", error);
                showMessage("Une erreur est survenue.", "error");
            });
    }

    function refreshTable() {
        const table = document.getElementById('emploisTable'); // Sélectionne le tableau
        table.innerHTML = "<tr><td colspan='6'>Chargement...</td></tr>"; // Message temporaire

        // Rechargement du tableau avec `tableau_emplois.php`
        fetch('tableau_emplois.php')
            .then(response => response.text())
            .then(html => {
                table.innerHTML = html; // Remplace le contenu du tableau
            })
            .catch(error => console.error("Erreur lors du rafraîchissement du tableau :", error));
    }

    function showMessage(message, type) {
        const messageBox = document.createElement("div"); // Crée une boîte de message
        messageBox.textContent = message; // Insère le texte du message
        messageBox.style.padding = "10px";
        messageBox.style.margin = "10px 0";
        messageBox.style.borderRadius = "5px";
        messageBox.style.textAlign = "center";

        // Styles selon le type
        if (type === "success") {
            messageBox.style.backgroundColor = "#d4edda"; // Vert clair pour succès
            messageBox.style.color = "#155724"; // Texte vert foncé
        } else {
            messageBox.style.backgroundColor = "#f8d7da"; // Rouge clair pour erreur
            messageBox.style.color = "#721c24"; // Texte rouge foncé
        }

        // Insère le message au-dessus du tableau
        const emploiSection = document.getElementById('emploi');
        emploiSection.insertBefore(messageBox, emploiSection.firstChild);

        // Supprime automatiquement le message après 5 secondes
        setTimeout(() => messageBox.remove(), 5000);
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Vérifie si une section active est enregistrée
        const savedSection = localStorage.getItem("activeSection");
        if (savedSection) {
            // Cache toutes les sections
            document.querySelectorAll(".tab-content").forEach((section) => {
                section.style.display = "none";
            });
            // Affiche uniquement la section enregistrée
            document.getElementById(savedSection).style.display = "block";
        } else {
            // Par défaut, affiche les actualités
            document.querySelector("#actualites").style.display = "block";
        }

        // Écoute les clics sur les onglets pour sauvegarder l'état actif
        document.querySelectorAll(".tab-link").forEach((tabLink) => {
            tabLink.addEventListener("click", function () {
                const targetSection = this.getAttribute("data-target");
                // Sauvegarde la section active
                localStorage.setItem("activeSection", targetSection);
            });
        });
    });
</script>


</div>
</body>
</html>