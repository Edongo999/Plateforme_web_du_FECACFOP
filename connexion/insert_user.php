<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

if ($conn->connect_error) {
    die("❌ Erreur de connexion : " . $conn->connect_error);
}

// Mise à jour avec ton nom complet
$username = "EDONGO FRANK";
$email = "frankamengne@gmail.com";
$password = password_hash("motdepasse123", PASSWORD_DEFAULT);
$role = "admin";

$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $role);

if ($stmt->execute()) {
    echo "✅ Utilisateur EDONGO AMENGNE inséré avec succès dans la base.";
} else {
    echo "❌ Erreur : " . $stmt->error;
}
?>
