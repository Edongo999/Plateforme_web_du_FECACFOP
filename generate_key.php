<?php
$secretKey = bin2hex(random_bytes(32)); // Génère une clé sécurisée
echo "Ta clé secrète : " . $secretKey;
?>
