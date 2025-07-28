<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "rapcefop");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupération des données du candidat (par email ou autre identification)
$email = $_GET['email']; // Email du candidat (récupéré dynamiquement)
$sql = "SELECT offre_id FROM candidatures WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$offres_postulees = [];
while ($row = $result->fetch_assoc()) {
    $offres_postulees[] = $row['offre_id']; // Stocke les ID des offres déjà postulées
}

echo json_encode(["offres_postulees" => $offres_postulees]);

$stmt->close();
$conn->close();
?>
