<?php
if (!isset($_GET['ip'])) die("IP manquante");

$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) die("Erreur de connexion.");

$ip = $_GET['ip'];

// Supprimer les échecs de cette IP des 15 dernières minutes
$stmt = $conn->prepare("DELETE FROM login_logs WHERE ip_address = ? AND statut = 'échec' AND date_connexion > (NOW() - INTERVAL 15 MINUTE)");
$stmt->bind_param("s", $ip);
$stmt->execute();

session_start();
unset($_SESSION['ip_alert_sent']);
header("Location: admin_logs.php");
exit();
?>
