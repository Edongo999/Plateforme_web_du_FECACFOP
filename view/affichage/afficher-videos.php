<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "rapcefop");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Fonction pour calculer le temps écoulé depuis une date
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $string = [
        'y' => 'année',
        'm' => 'mois',
        'd' => 'jour',
        'h' => 'heure',
        'i' => 'minute',
        's' => 'seconde',
    ];

    foreach ($string as $key => &$value) {
        if ($diff->$key) {
            $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
        } else {
            unset($string[$key]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . ' ago' : 'à l\'instant';
}

// Récupération des actualités pour les vidéos
$sql = "SELECT * FROM actualites1 WHERE type_media = 'video' ORDER BY date_publication DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publications - Vidéos</title>
    <link rel="stylesheet" href="videos.css">
</head>
<body>
    <header class="header">
        <h1>Publications - Vidéos</h1>
        
    </header>
    <main class="container">
        <div class="actualites">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='actualite-card'>";
                echo "<video controls class='actualite-media'>
                        <source src='" . $row['media'] . "' type='video/mp4'>
                        Votre navigateur ne prend pas en charge la vidéo.
                      </video>";
                echo "<div class='actualite-content'>";
                echo "<h2 class='actualite-titre'>" . $row['titre'] . "</h2>";
                echo "<p class='actualite-date'>Publié : " . time_elapsed_string($row['date_publication']) . "</p>";
                echo "<p class='actualite-description'>" . substr($row['contenu'], 0, 100) . "...</p>";
                echo "<button class='btn btn-primary' onclick='openModal(\"" . $row['titre'] . "\", \"" . addslashes($row['contenu']) . "\", \"" . $row['media'] . "\", \"video\")'>Lire plus</button>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune publication de vidéos disponible.</p>";
        }
        ?>
        </div>
    </main>

    <!-- Structure HTML pour le modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div id="modal-media"></div>
            <h2 id="modal-title"></h2>
            <p id="modal-description"></p>
            <button class="modal-close-btn" onclick="closeModal()">Fermer</button>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        function closeModal() {
    document.getElementById("modal").style.display = "none";

    // ✅ Sélectionne la vidéo à l'intérieur du modal et arrête la lecture
    let video = document.querySelector("#modal-media video");
    if (video) {
        video.pause(); // ✅ Met la vidéo en pause
        video.currentTime = 0; // ✅ Réinitialise la vidéo au début
    }
}

    </script>
</body>
</html>

<?php $conn->close(); ?>
