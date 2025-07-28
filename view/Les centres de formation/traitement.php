

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapcefop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Sécurisation des données contre les erreurs SQL
$nom = mysqli_real_escape_string($conn, $_POST['nom']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$specialite = mysqli_real_escape_string($conn, $_POST['specialite']);

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["logo"]["name"]);

// Vérification de l'upload du fichier
if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
    die("Erreur lors de l'upload du logo !");
}

$sql = "INSERT INTO centres (nom, email, specialite, logo) VALUES ('$nom', '$email', '$specialite', '$target_file')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Centre ajouté avec succès !'); window.location.href='dashboard.php';</script>";
} else {
    echo "Erreur SQL : " . $conn->error;
}

$conn->close();
?>
