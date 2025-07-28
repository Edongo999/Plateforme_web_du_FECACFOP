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

// Récupération des actualités pour les images
$sql = "SELECT * FROM actualites1 WHERE type_media = 'image' ORDER BY date_publication DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publications - Images</title>
    <link rel="stylesheet" href="images.css">
</head>
<body>
    <header class="header">
        <h1>Archives Visuelles du Réseau</h1>
   
    </header>
    <main class="container">
        <div class="actualites">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='actualite-card'>";
                echo "<img src='" . $row['media'] . "' alt='Image' class='actualite-media'>";
                echo "<div class='actualite-content'>";
                echo "<h2 class='actualite-titre'>" . $row['titre'] . "</h2>";
                echo "<p class='actualite-date'>Publié : " . time_elapsed_string($row['date_publication']) . "</p>";
                echo "<p class='actualite-description'>" . substr($row['contenu'], 0, 100) . "...</p>";
                echo "<button class='btn btn-primary' onclick='openModal(\"" . $row['titre'] . "\", \"" . addslashes($row['contenu']) . "\", \"" . $row['media'] . "\", \"image\")'>Lire plus</button>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune publication d'images disponible.</p>";
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
</body>
</html>

<?php $conn->close(); ?>
