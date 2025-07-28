<?php
session_start();
$conn = new mysqli("localhost", "root", "", "rapcefop");

// S’assurer qu’au moins une entrée existe (tu peux adapter l'ID si besoin)
$offre = $conn->query("SELECT * FROM emplois WHERE archived = 0 ORDER BY id ASC LIMIT 1")->fetch_assoc();
if (!$offre) {
  die("⛔ Aucune offre disponible dans la table 'emplois'.");
}

$id = $offre['id'];
$titre = htmlspecialchars($offre['titre'], ENT_QUOTES);
$description = htmlspecialchars(substr($offre['description'], 0, 100) . "...", ENT_QUOTES);
$media = htmlspecialchars($offre['media'], ENT_QUOTES);
$vues = $offre['vues'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Test Vue - EMPLOIS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: sans-serif; max-width: 600px; margin: 50px auto; }
    img { width: 100%; border-radius: 10px; object-fit: cover; max-height: 240px; cursor: pointer; }
    h2 { color: #007bff; margin-bottom: 0; }
    .vues { font-size: 16px; color: #555; margin: 8px 0; display: flex; align-items: center; }
    .vues i { margin-right: 6px; color: #999; }
    button { background: #007bff; color: white; border: none; padding: 10px 14px; border-radius: 5px; margin-right: 10px; cursor: pointer; }
    button:hover { background: #0056b3; }
    .desc { margin: 12px 0; }
  </style>
</head>
<body>

<h2><?= $titre ?></h2>
<p class="vues"><i class="fas fa-eye"></i> <?= $vues ?> vues</p>
<p class="desc"><?= $description ?></p>

<img src="/Plateforme_web_du_FECACFOP/uploads/emplois/<?= basename($media) ?>" alt="Visuel" data-id="<?= $id ?>" onclick="compterVue(<?= $id ?>)">

<br><br>
<button onclick="compterVue(<?= $id ?>)">Lire plus</button>
<button onclick="compterVue(<?= $id ?>)">Postuler</button>

<script>
function compterVue(id) {
  fetch("/Plateforme_web_du_FECACFOP/view/Actualites/increment_vue.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + encodeURIComponent(id)
  })
  .then(res => {
    if (res.ok) {
      alert("✅ Vue enregistrée pour l'offre #" + id + " ! Recharge la page.");
      location.reload();
    } else {
      alert("❌ Échec de l'enregistrement de la vue.");
    }
  })
  .catch(() => alert("⚠️ Erreur de communication AJAX."));
}
</script>

</body>
</html>
