<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

// Vérification de la connexion
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
        echo "<img src='http://localhost{$centre['logo_path']}' alt='Logo du centre' class='img-fluid mb-3'>";
        echo "<h3>📍 Localisation</h3><p>" . $centre['localisation'] . "</p>";
        echo "<h3>🤝 Partenariats</h3><p>" . nl2br($centre['partenariats']) . "</p>";
        echo "<h3>💳 Modalités de financement</h3><p>" . nl2br($centre['modalites_financement']) . "</p>";
        echo "<h3>⭐ Témoignages</h3><p>" . nl2br($centre['temoignages']) . "</p>";
    } else {
        echo "<p>❌ Centre introuvable.</p>"; 
    }
} else { 
    echo "<p>❌ ID du centre non fourni.</p>"; 
}

$conn->close();
?>
