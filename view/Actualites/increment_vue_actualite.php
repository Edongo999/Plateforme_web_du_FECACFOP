<?php
session_start();
$conn = new mysqli("localhost", "root", "", "rapcefop");

$id = intval($_POST['id'] ?? 0);

if ($id > 0 && !isset($_SESSION['vue_actualite_' . $id])) {
  $stmt = $conn->prepare("UPDATE actualites1 SET vues = vues + 1 WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  $_SESSION['vue_actualite_' . $id] = true;
}
?>
