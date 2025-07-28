<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Vérifier si un ID de centre est fourni
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM centres_inscrits WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $centre = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title><?php echo $centre['nom_centre']; ?> - Détails</title>
            <link rel="stylesheet" href="assets/css/styles.css">
        </head>
        <body>
            <div class="container">
                <h1><?php echo $centre['nom_centre']; ?></h1>
                <img src="http://localhost<?php echo $centre['logo_path']; ?>" alt="Logo du centre" class="img-fluid mb-3">
                
                <h3>📍 Localisation</h3>
                <p><?php echo $centre['localisation']; ?></p>

                <h3>📚 Formations disponibles</h3>
                <p><?php echo nl2br($centre['formations']); ?></p>

                <h3>📅 Année de création</h3>
                <p><?php echo $centre['annee_creation']; ?></p>

                <h3>👨‍🏫 Directeur</h3>
                <p><?php echo $centre['directeur_nom']; ?></p>
                <img src="http://localhost<?php echo $centre['directeur_photo']; ?>" alt="Directeur" class="img-fluid rounded">

                <h3>⭐ Historique</h3>
                <p><?php echo nl2br($centre['temoignages']); ?></p>

                <!-- 🔹 Nouvelle section : Photos des locaux -->
              

                <a href="/Plateforme_web_du_FECACFOP/public/index.php" class="btn btn-primary">Retour</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p>❌ Centre introuvable.</p>";
    }
} else {
    echo "<p>❌ ID du centre non fourni.</p>";
}

$conn->close();
?>
<style>



body {
    font-family: "Poppins", sans-serif; /* ✅ Police plus élégante */
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    max-width: 850px;
    margin: 50px auto;
    padding: 25px;
    background: white;
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    transition: 0.3s;
}

.container:hover {
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* ✅ Effet subtil */
}

h1 {
    text-align: center;
    color: #007bff;
    font-size: 2rem;
}
img {
    display: block;
    margin: 20px auto;
    width: 100%;
    max-width: 450px; /* ✅ Limite la taille max pour un rendu équilibré */
    height: auto;
    border-radius: 10px;
    object-fit: cover; /* ✅ Assure un cadrage esthétique */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

img:hover {
    transform: scale(1.05); /* ✅ Zoom subtil */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

h3 {
    color: #0056b3;
    border-bottom: 3px solid #007bff;
    padding-bottom: 8px;
    margin-top: 20px;
    font-size: 1.3rem;
    transition: 0.3s;
}

h3:hover {
    color: #007bff;
    cursor: pointer; /* ✅ Interaction */
}

p {
    font-size: 17px;
    line-height: 1.7;
    color: #444;
}

.btn {
    display: block;
    width: 180px;
    text-align: center;
    margin: 20px auto;
    padding: 12px;
    background-color: #007bff;
    color: white;
    font-weight: bold;
    text-decoration: none;
    border-radius: 7px;
    transition: 0.3s;
}

.btn:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* ✅ Assurer que tout est bien responsive */
@media (max-width: 768px) {
    .container {
        max-width: 95%;
        padding: 20px;
    }

    h1 {
        font-size: 1.8rem;
    }

    h3 {
        font-size: 1.2rem;
    }

    p {
        font-size: 16px;
    }
}




.photo-locaux {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* ✅ Grille flexible */
    gap: 15px;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.photo-locaux img {
    width: 100%;
    height: 200px; /* ✅ Taille uniforme */
    object-fit: cover; /* ✅ Assure que l’image garde ses proportions */
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.photo-locaux img:hover {
    transform: scale(1.08); /* ✅ Zoom léger au survol */
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.3);
}

</style>