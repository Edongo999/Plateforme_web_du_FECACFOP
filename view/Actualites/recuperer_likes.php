<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

$article_id = $_GET['article_id'];

$stmt = $conn->prepare("SELECT COUNT(*) FROM likes_actualite WHERE article_id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();

echo $total;
?>
