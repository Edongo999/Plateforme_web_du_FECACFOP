<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$today = date('Y-m-d');

// 🔹 **Correction : Ajout de `media_type` dans la requête**
$sql = "SELECT titre, media_path, media_type FROM publicites WHERE statut = 'actif' AND date_debut <= '$today' AND date_fin >= '$today'";
$result = $conn->query($sql);

$publicites = [];
while ($row = $result->fetch_assoc()) {
    // 🔹 Vérification que `media_type` et `media_path` existent bien
    if (!isset($row['media_type']) || !isset($row['media_path'])) {
        echo "<p style='color: red;'>⚠ Erreur : `media_type` ou `media_path` manquant dans la base.</p>";
        continue;
    }

    $publicites[] = $row;
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicités Actuelles</title>
    <style>
        
        .publicites-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 6px 14px rgba(0, 0, 0, 0.15);
        }
        .publicites-carousel {
            width: 100%;
            height: 450px;
            overflow: hidden;
            position: relative;
            border-radius: 10px;
        }
        .publicites-item {
            width: 100%;
            height: 100%;
            opacity: 1;
            position: absolute;
            left: 0;
            top: 0;
        }
       .publicites-media {
    width: 100%;
    max-height: 350px; /* Réduction de la hauteur */
    object-fit: contain; /* Empêcher le rognage */
    border-radius: 8px;
    background: white;
}

    </style>
</head>
<body>
<section class="publicites-container">
    <h2>📢 Annonces en Vedette</h2>
    <div class="publicites-carousel">
        <?php foreach ($publicites as $index => $row) { 
    $media_path = htmlspecialchars($row['media_path']);
    $media_type = htmlspecialchars($row['media_type']);

    // 🔹 Définir le chemin d'accès correct
    if ($media_type === 'image') {
        $full_path = "/Plateforme_web_du_FECACFOP/uploads/publicites/images/" . basename($media_path);
    } elseif ($media_type === 'video') {
        $full_path = "/Plateforme_web_du_FECACFOP/uploads/publicites/videos/" . basename($media_path);
    } else {
        echo "<p>⚠ Type de média inconnu : " . $media_type . "</p>";
        continue; // ⛔ Si le type est invalide, ne pas afficher
    }
?>
    <div class="publicites-item" id="item-<?php echo $index; ?>">
        <?php if ($media_type === 'video') { ?>
            <video class="publicites-media" controls>
                <source src="<?php echo $full_path; ?>" type="video/mp4">
                Votre navigateur ne supporte pas la vidéo.
            </video>
        <?php } else { ?>
            <img src="<?php echo $full_path; ?>" alt="Publicité" class="publicites-media">
        <?php } ?>
    </div>
<?php } ?>

    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const items = document.querySelectorAll(".publicites-item");
    let index = 0;
    let interval;
    let isHovered = false; // ✅ Vérifie si le curseur est sur la publicité

    function changeMedia() {
        if (isHovered) return; // ✅ Empêche le changement si le curseur est sur l'image/vidéo

        items.forEach(item => item.style.opacity = "0");
        const currentItem = items[index];
        currentItem.style.opacity = "1";

        const video = currentItem.querySelector("video");
        if (video) {
            video.onplay = () => {
                console.log("Vidéo en cours... arrêt du changement automatique");
                clearInterval(interval);
            };
            video.onpause = () => {
                if (!isHovered) {
                    interval = setInterval(changeMedia, 5000);
                    changeMedia();
                }
            };
            video.onended = () => {
                if (!isHovered) {
                    interval = setInterval(changeMedia, 5000);
                    changeMedia();
                }
            };
        }

        index = (index + 1) % items.length;
    }

    // ✅ Détection du curseur sur la publicité
    document.querySelector(".publicites-carousel").addEventListener("mouseenter", () => {
        isHovered = true;
        clearInterval(interval); // ✅ Arrête le changement automatique
        console.log("Le curseur est sur la publicité, arrêt du défilement");
    });

    document.querySelector(".publicites-carousel").addEventListener("mouseleave", () => {
        isHovered = false;
        interval = setInterval(changeMedia, 5000); // ✅ Relance le défilement quand le curseur quitte
        console.log("Le curseur est sorti, reprise du défilement");
    });

    interval = setInterval(changeMedia, 5000);
    changeMedia();
});

</script>

</body>
</html>
