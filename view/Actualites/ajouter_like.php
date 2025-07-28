<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

$article_id = $_POST['article_id'];
$ip = $_SERVER['REMOTE_ADDR'];

$check = $conn->prepare("SELECT id FROM likes_actualite WHERE article_id = ? AND adresse_ip = ?");
$check->bind_param("is", $article_id, $ip);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Déjà liké → on annule
    $delete = $conn->prepare("DELETE FROM likes_actualite WHERE article_id = ? AND adresse_ip = ?");
    $delete->bind_param("is", $article_id, $ip);
    $delete->execute();
    echo "unliked";
} else {
    // Pas encore liké → on ajoute
    $insert = $conn->prepare("INSERT INTO likes_actualite (article_id, adresse_ip) VALUES (?, ?)");
    $insert->bind_param("is", $article_id, $ip);
    $insert->execute();
    echo "liked";
}
?>
