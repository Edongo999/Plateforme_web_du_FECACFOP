<?php
header("Content-Type: application/json");
require_once '../controller/CentreController.php';

// Instancier le contrôleur des centres
$controller = new CentreController();
$centres = $controller->getRecommendedCentres();

// Construire la réponse JSON pour Dialogflow
$responseText = "Voici les centres recommandés : ";
foreach ($centres as $centre) {
    $responseText .= $centre['nom'] . ", ";
}

// Supprimer la dernière virgule
$responseText = rtrim($responseText, ", ");

echo json_encode([
    "fulfillmentText" => $responseText
]);
?>
