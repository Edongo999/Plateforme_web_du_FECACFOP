<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapcefop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Échec de la connexion : " . $conn->connect_error);

// 🔍 Gestion du filtre de recherche
$filtre = "";
if (isset($_GET['localite']) && !empty($_GET['localite'])) {
    $localite = $conn->real_escape_string($_GET['localite']);
    $filtre = "WHERE localisation LIKE '%$localite%'";
}

$sql = "SELECT * FROM centres_inscrits $filtre ORDER BY date_inscription DESC";
$result = $conn->query($sql);
?>

<?php include_once '../header.php'; ?>

<div class="background">
  <h1 id="animated-title"></h1>
</div>

<!-- 🔎 Formulaire de recherche -->


<!-- ✅ SECTION CENTRES DE FORMATION -->
 <div class="container" style="margin-top: 30px;">

  <div class="centre-card-container">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="centre-card-container">
        <div class="centre-card-wrapper">
          <div class="centre-card shadow-sm">
            <?php 
            if (!empty($row['logo_path'])) {
              echo '<img src="' . htmlspecialchars($row['logo_path']) . '" class="centre-card-img-top" alt="' . htmlspecialchars($row['nom_centre']) . '">';
            } else {
              echo '<p style="color:red;">Image introuvable !</p>';
            }
            ?>
            <button class="btn-postuler" onclick="window.location.href='/Plateforme_web_du_FECACFOP/view/formulaire/index1.php?centre_id=<?php echo $row['id']; ?>'">
              S'inscrire maintenant
            </button>
          </div>
          <div class="centre-card-title"><?php echo htmlspecialchars($row['nom_centre']); ?></div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<div class="footer-separator"></div>
<footer id="footer" class="footer">
<?php include_once '../footer.php'; ?>
<?php include_once '../scripts.php'; ?>

<script>
const texts = [
  "Nos Centres de Formation Partenaire",
  "L'Excellence à portée de main",
  "Transformez votre avenir, formez-vous aujourd'hui",
  "Apprenez, progressez, réussissez",
  "Des formations adaptées à votre succès",
  "Éducation, Compétence, Réussite",
  "Votre avenir commence ici !",
  "Rejoignez un réseau de centres innovants",
  "La meilleure formation pour un métier d'avenir",
  "Parce que chaque talent mérite d'être développé"
];

let indexText = 0;
const title = document.getElementById("animated-title");

function typeEffect(text, callback) {
  title.textContent = "";
  let index = 0;
  function typeLetter() {
    if (index < text.length) {
      title.textContent += text[index++];
      setTimeout(typeLetter, 100);
    } else {
      setTimeout(callback, 2000);
    }
  }
  typeLetter();
}

function cycleTexts() {
  typeEffect(texts[indexText], () => {
    indexText = (indexText + 1) % texts.length;
    cycleTexts();
  });
}
setTimeout(cycleTexts, 500);
</script>
</body>
</html>

<?php $conn->close(); ?>


