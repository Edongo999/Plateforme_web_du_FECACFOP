<?php
session_start();
$conn = new mysqli("localhost", "root", "", "rapcefop");

$id = intval($_POST['id'] ?? 0);

if ($id > 0 && !isset($_SESSION['vue_enregistree_'.$id])) {
  $conn->query("UPDATE emplois SET vues = vues + 1 WHERE id = $id");
  $_SESSION['vue_enregistree_'.$id] = true;
}
?>
