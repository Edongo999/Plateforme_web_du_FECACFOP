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

    // Utilisation directe des jours pour calculer les semaines
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
        $string = array_slice($string, 0, 1); // Limitez à la première unité de temps
    }

    return $string ? implode(', ', $string) . ' ago' : 'à l\'instant';
}

// Récupération des actualités
$sql = "SELECT * FROM actualites1 ORDER BY date_publication DESC";
$result = $conn->query($sql);
?>

<?php include_once '../header.php'; ?>
    <main class="container">
    <div class="actualites">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='actualite-card'>";
            
            // Affichage des médias
            if ($row['type_media'] === 'image') {
                echo "<img src='" . $row['media'] . "' alt='Image' class='actualite-media'>";
            } elseif ($row['type_media'] === 'video') {
                echo "<video controls class='actualite-media'>
                        <source src='" . $row['media'] . "' type='video/mp4'>
                        Votre navigateur ne prend pas en charge la vidéo.
                      </video>";
            }

            // Contenu de l'actualité
            echo "<div class='actualite-content'>";
            echo "<h2 class='actualite-titre'>" . $row['titre'] . "</h2>";
            echo "<p class='actualite-date'>Publié : " . time_elapsed_string($row['date_publication']) . "</p>";
            echo "<p class='actualite-description'>" . substr($row['contenu'], 0, 100) . "...</p>";
            echo "<button class='btn btn-primary' onclick='openModal(\"" . $row['titre'] . "\", \"" . addslashes($row['contenu']) . "\", \"" . $row['media'] . "\", \"" . $row['type_media'] . "\")'>Lire plus</button>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucune actualité disponible.</p>";
    }
    ?>
</div>



<!-- Structure HTML pour le modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <div id="modal-media"></div> <!-- Contiendra l'image ou la vidéo -->
        <h2 id="modal-title"></h2> <!-- Contiendra le titre de la publication -->
        <p id="modal-description"></p> <!-- Contiendra le texte de la description -->
        <button class="modal-close-btn" onclick="closeModal()">Fermer</button> <!-- Bouton Fermer -->
    </div>
</div>


    </main>
    <?php include_once '../footer.php'; ?>
<?php include_once '../script1.php'; ?>
    <script src="script.js"></script>

</body>
</html>

<?php $conn->close(); ?>
