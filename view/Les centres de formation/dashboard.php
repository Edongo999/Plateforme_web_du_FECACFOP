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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Centres de Formation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-primary">Tableau de Bord - Centres de Formation</h1>
        <a href="add_centre.php" class="btn btn-success mb-4">Ajouter un Centre</a>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="<?php echo $row['logo']; ?>" class="card-img-top" alt="<?php echo $row['nom']; ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center text-primary"><?php echo $row['nom']; ?></h5>
                            <p class="card-text text-center"><strong>Spécialité :</strong> <?php echo $row['specialite']; ?></p>
                            <p class="card-text text-center"><strong>Email :</strong> <?php echo $row['email']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
