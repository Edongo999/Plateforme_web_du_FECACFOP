<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "❌ L'ID de l'offre d'emploi n'a pas été spécifié.";
    exit();
}

$id = (int)$_GET['id'];
$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) {
    echo "❌ Erreur de connexion à la base de données.";
    exit();
}

$sql = "UPDATE emplois SET archived = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "❌ Erreur lors de la préparation de la requête.";
    exit();
}

$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "✔️ Offre archivée avec succès !"; // Ce message sera capturé par JavaScript
} else {
    echo "❌ Erreur lors de l'archivage.";
}
$stmt->close();
$conn->close();
