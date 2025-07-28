<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mettre à jour le statut is_archived
    $stmt = $conn->prepare("UPDATE actualites1 SET is_archived=TRUE WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Actualité archivée avec succès !');
                window.location.href = 'tableau.php';
              </script>";
    } else {
        echo "<script>
                alert('Une erreur est survenue lors de l\'archivage.');
                window.location.href = 'tableau.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('ID non spécifié.');
            window.location.href = 'tableau.php';
          </script>";
}
?>
