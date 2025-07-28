<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapcefop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$sql = "SELECT * FROM centres";
$result = $conn->query($sql);
?>
	<a href="https://api.whatsapp.com/send?phone=237697475573" target="_blank" class="whatsapp-link">
    <img src="../img/whatsapp.png" alt="WhatsApp">
</a>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Centres de Formation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        /* ✅ Conteneur des cartes */
/* 📌 Conteneur des cartes */
.centre-card-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Affichage en 3 colonnes */
    gap: 30px;
    justify-content: center;
}

/* 🔹 Adaptation aux écrans plus petits */
@media (max-width: 1024px) {
    .centre-card-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .centre-card-container {
        grid-template-columns: repeat(1, 1fr);
    }
}

/* ✅ Style des cartes */
.centre-card {
    border-radius: 15px;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: linear-gradient(to right, #0056b3, #003366); /* 🔥 Dégradé bleu */
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* 🌟 Effet de survol */
.centre-card:hover {
    transform: translateY(-8px);
    box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.3);
}

/* ✅ Gestion des images */
.centre-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

/* ✅ Titre des centres */
.centre-card-title {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    color: #fff;
    padding: 12px;
    background: rgba(0, 0, 0, 0.7);
    border-radius: 10px;
    text-transform: uppercase;
}

/* ✅ Spécialités */
.specialites-container {
    width: 100%;
    overflow: hidden;
    position: relative;
    background-color: rgba(255, 255, 255, 0.1);
    padding: 10px;
    border-radius: 8px;
}

/* 🌀 Défilement fluide des spécialités */
.specialites-scroll {
    display: flex;
    gap: 12px;
    white-space: nowrap;
    animation: defilement 15s linear infinite;
}

.specialite-item {
    background: #ff9800;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    display: inline-block;
}

/* 🎭 Animation */
@keyframes defilement {
    from { transform: translateX(100%); }
    to { transform: translateX(-100%); }
}

/* ✅ Fixation des boutons en bas */
.centre-card-body {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
}

/* ✅ Espacement amélioré des boutons */
/* ✅ Isolation des boutons */
.centre-card-footer {
    margin-top: auto;
    width: 100%;
    text-align: center;
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* ✅ Correction des boutons */
.centre-btn {
    border-radius: 50px;
    padding: 14px 22px;
    font-size: 16px;
    width: 90%;
    display: block;
    text-align: center;
    transition: background 0.3s ease;
}

/* ✅ Bouton bleu */
.centre-btn-info {
    background: #2196F3 !important;
    color: white !important;
}

.centre-btn-info:hover {
    background: #1976D2 !important;
}

/* ✅ Bouton vert */
.centre-btn-success {
    background: #4CAF50 !important;
    color: white !important;
}

.centre-btn-success:hover {
    background: #388E3C !important;
}



    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="centre-card-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="centre-card shadow-sm">
                    <img src="<?php echo $row['logo']; ?>" class="centre-card-img-top" alt="<?php echo $row['nom']; ?>">
                    <div class="centre-card-body text-center">
                        <h5 class="centre-card-title"><?php echo $row['nom']; ?></h5>

                        <div class="specialites-container">
                            <div class="specialites-scroll">
                                <?php $specs = explode(", ", $row['specialite']); ?>
                                <?php foreach ($specs as $spec): ?>
                                    <span class="specialite-item"><?php echo $spec; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mt-3 centre-card-footer">
                            <a href="details_centre.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-custom">En savoir plus</a>
                            <a href="demande_formation.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-custom">Demande de formation</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>
