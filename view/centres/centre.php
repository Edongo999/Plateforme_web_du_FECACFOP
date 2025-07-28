<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rapcefop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$sql = "SELECT * FROM centres";
$result = $conn->query($sql);
?>

<?php include_once '../header.php'; ?>
</head>
<body>


<div class="background">
    <h1 id="animated-title"></h1>
</div>
            
    <!-- SECTION CENTRES DE FORMATION -->
    <div class="container mt-5">
        <div class="centre-card-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="centre-card shadow-sm">
                    <img src="<?php echo $row['logo']; ?>" class="centre-card-img-top" alt="<?php echo $row['nom']; ?>">
                    <div class="centre-card-body text-center">
                        <h5 class="centre-card-title"><?php echo $row['nom']; ?></h5>

                        <div class="specialites-container">
                            <div class="specialites-scroll">
                                <?php $specs = explode(", ", $row['specialite']); ?>
                                <?php foreach ($specs as $spec): ?>
                                    <span class="specialite-item"><?php echo $spec; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
						<div class="centre-card-footer">
							<a href="details_centre.php?id=<?php echo $row['id']; ?>" class="centre-btn centre-btn-info">En savoir plus</a>
							<a href="demande_formation.php?id=<?php echo $row['id']; ?>" class="centre-btn centre-btn-success">Demande de formation</a>
						</div>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

	<a href="https://api.whatsapp.com/send?phone=237697475573" target="_blank" class="whatsapp-link">
    <img src="../img/whatsapp.png" alt="WhatsApp">
</a>


<div class="footer-separator"></div>
<footer id="footer" class="footer">

<?php include_once '../footer.php'; ?>
<?php include_once '../script1.php'; ?>

	<script>
    // ✅ Liste des textes à afficher
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

    let indexText = 0; // Indice du texte actuel
    const title = document.getElementById("animated-title");

    function typeEffect(text, callback) {
        title.textContent = "";
        let index = 0;

        function typeLetter() {
            if (index < text.length) {
                title.textContent += text[index];
                index++;
                setTimeout(typeLetter, 100);
            } else {
                setTimeout(callback, 2000); // Attente avant le changement de texte
            }
        }

        typeLetter();
    }

    function cycleTexts() {
        typeEffect(texts[indexText], () => {
            indexText = (indexText + 1) % texts.length; // ✅ Passe au prochain texte
            cycleTexts();
        });
    }

    // ✅ Lancer l'animation
    setTimeout(cycleTexts, 500);
</script>
<?php $conn->close(); ?>