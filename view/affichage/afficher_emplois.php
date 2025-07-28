<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "rapcefop");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Fonction pour calculer le temps écoulé depuis une date
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $string = [
        'y' => 'année',
        'm' => 'mois',
        'd' => 'jour',
        'h' => 'heure',
        'i' => 'minute',
        's' => 'seconde',
    ];

    foreach ($string as $key => &$value) {
        if ($diff->$key) {
            $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
        } else {
            unset($string[$key]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . ' ago' : 'à l\'instant';
}

// Récupération des emplois
$sql = "SELECT * FROM emplois ORDER BY date_publication DESC";
$result = $conn->query($sql);
?>
<?php include_once '../header.php'; ?>
        <div class="background">
    <h1 id="animated-title"></h1>
</div>
    <main class="jobs-container">
         <div class="actualites">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='actualite-card'>";
                // Affichage de l'image si elle existe
                if (!empty($row['media'])) {
                    echo "<img src='" . htmlspecialchars($row['media']) . "' alt='Emploi' class='actualite-media'>";
                }
                
                echo "<div class='actualite-content'>";
                echo "<h2 class='actualite-titre'>" . htmlspecialchars($row['titre']) . "</h2>";
                echo "<p class='actualite-date'>Publié : " . time_elapsed_string($row['date_publication']) . "</p>";
                echo "<p class='actualite-description'>" . htmlspecialchars(substr($row['description'], 0, 100)) . "...</p>";
                
                echo "<button class='btn btn-lire' onclick='openModal(\"" . addslashes($row['titre']) . "\", \"" . addslashes($row['description']) . "\", \"" . htmlspecialchars($row['media']) . "\")'>Lire plus</button>"; // Bouton Lire plus
                
                echo "<button class='btn btn-postuler' data-title='" . addslashes($row['titre']) . "'>Postuler maintenant</button>";

                echo "</div>";
              
                echo "</div>";
             

            }
        } else {
            echo "<p>Aucun emploi disponible pour le moment.</p>";
        }
        ?>
        </div>
    </main>

<!-- Modal pour "Lire plus" -->
<div class="custom-modal" id="modal">
    <div class="custom-modal-content">
        <div id="modal-media"></div>
        <h2 id="modal-title"></h2>
        <p id="modal-description"></p>
        <button class="custom-btn custom-modal-close-btn" onclick="closeModal()">Fermer</button>
    </div>
</div>

<!-- Modal pour "Postuler" -->
<div id="applicationModal" class="custom-modal">
    <div class="custom-modal-content">
        <h2 id="application-title">Postuler à l'offre</h2>


        
        <form id="applicationForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return showLoadingMessage()">
            <input type="hidden" name="offre_id" value="1"> <!-- Dynamique selon l'offre sélectionnée -->

            <div class="custom-form-group">
                <label for="name">Nom complet :</label>
                <input type="text" id="name" name="name" placeholder="Votre nom" required>
            </div>
            <div class="custom-form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Votre email" required>
            </div>
            <div class="custom-form-group">
                <label for="pays">Pays :</label>
                <input type="text" id="pays" name="pays" placeholder="Votre pays" required>
            </div>
            <div class="custom-form-group">
                <label for="cv">Télécharger votre CV :</label>
                <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
            </div>

            <div id="formMessage" class="custom-message"></div>
            <div class="custom-form-buttons">
                <button type="submit" class="custom-btn custom-btn-primary">Envoyer ma candidature</button>
                <button type="button" class="custom-btn custom-modal-close-btn" onclick="closeApplicationModal()">Fermer</button>
            </div>
        </form>
    </div>
</div>

<a href="https://api.whatsapp.com/send?phone=237697475573" target="_blank" class="whatsapp-link">
    <img src="../img/whatsapp.png" alt="WhatsApp">
</a>
<!-- Modal de confirmation -->
<div class="custom-modal custom-confirmation-modal" id="confirmationModal">
    <div class="custom-modal-content">
        <p id="confirmationMessage" class="custom-message"></p>
        <button class="custom-modal-close-btn" onclick="closeConfirmationModal()">Fermer</button>
    </div>
</div>
<style>
           
          

           /* ✅ Styles pour les modals */
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.custom-modal-content {
    background: white;
    border-radius: 10px;
    padding: 20px;
    width: 70%;
    max-width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
}

/* ✅ Style des boutons */
.custom-btn {
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    border: none;
}

.custom-btn-primary {
    background-color: #007bff;
    color: white;
    transition: background-color 0.3s ease-in-out;
}

.custom-btn-primary:hover {
    background-color: #0056b3;
}

.custom-modal-close-btn {
    background-color: #f44336;
    color: white;
}

.custom-modal-close-btn:hover {
    background-color: #d32f2f;
}

/* ✅ Formulaire */
.custom-form-group {
    margin-bottom: 15px;
}

.custom-form-group label {
    font-weight: bold;
    display: block;
}

.custom-form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.custom-form-buttons {
    display: flex;
    justify-content: space-between;
}

/* ✅ Message */
.custom-message {
    margin-top: 10px;
    color: blue;
}

/* ✅ Confirmation Modal */
.custom-confirmation-modal .custom-modal-content {
    width: 80%;
    max-width: 400px;
}

@media (max-width: 480px) {
    .custom-modal-content {
        transform: scale(0.75); /* ✅ Réduit légèrement le visuel */
    }
}

        </style>

<div class="footer-separator"></div>
<footer id="footer" class="footer">

<?php include_once '../footer.php'; ?>
<?php include_once '../script1.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Chargement des événements...");

        // ✅ Attacher "Lire plus" à chaque bouton
        const lirePlusButtons = document.querySelectorAll(".btn-lire");

        if (lirePlusButtons.length === 0) {
            console.warn("Aucun bouton 'Lire plus' trouvé !");
        } else {
            console.log(`${lirePlusButtons.length} boutons 'Lire plus' détectés`);
        }

        lirePlusButtons.forEach(button => {
            button.addEventListener("click", function () {
                console.log("Bouton Lire Plus cliqué !");
                const card = this.closest(".actualite-card");
                const title = card.querySelector(".actualite-titre") ? card.querySelector(".actualite-titre").textContent : "Titre inconnu";
                const description = card.querySelector(".actualite-description") ? card.querySelector(".actualite-description").textContent : "Pas de description disponible";
                const media = card.querySelector(".actualite-media") ? card.querySelector(".actualite-media").src : "";

                openModal(title, description, media);
            });
        });

        // ✅ Attacher "Postuler maintenant" à chaque bouton
        const postulerButtons = document.querySelectorAll(".btn-postuler");

        if (postulerButtons.length === 0) {
            console.warn("Aucun bouton 'Postuler maintenant' trouvé !");
        } else {
            console.log(`${postulerButtons.length} boutons 'Postuler maintenant' détectés`);
        }

        postulerButtons.forEach(button => {
            button.addEventListener("click", function () {
                console.log("Bouton Postuler cliqué !");
                const card = this.closest(".actualite-card");
                const jobTitleElement = card ? card.querySelector(".actualite-titre") : null;

                if (jobTitleElement) {
                    const jobTitle = jobTitleElement.textContent.trim();
                    console.log(`Ouverture du modal pour : ${jobTitle}`);
                    openApplicationModal(jobTitle);
                } else {
                    console.error("Erreur : titre du job introuvable !");
                }
            });
        });
    });

    // ✅ Fonction pour ouvrir "Lire plus"
    function openModal(title, description, media) {
        const modal = document.getElementById("modal");
        const modalTitle = document.getElementById("modal-title");
        const modalDescription = document.getElementById("modal-description");
        const modalMedia = document.getElementById("modal-media");

        if (modal && modalTitle && modalDescription) {
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalMedia.innerHTML = media ? `<img src="${media}" alt="Image emploi" style="width: 100%; border-radius: 10px;">` : "";
            modal.style.display = "flex";
            console.log("Modal 'Lire plus' ouvert !");
        } else {
            console.error("Erreur : le modal 'Lire plus' n'a pas été trouvé !");
        }
    }

    // ✅ Fonction pour fermer "Lire plus"
    function closeModal() {
        const modal = document.getElementById("modal");
        if (modal) {
            modal.style.display = "none";
            console.log("Modal 'Lire plus' fermé !");
        } else {
            console.error("Erreur : le modal 'Lire plus' n'a pas été trouvé !");
        }
    }

    // ✅ Fonction pour ouvrir "Postuler maintenant"
    function openApplicationModal(jobTitle) {
        const modal = document.getElementById("applicationModal");
        const title = document.getElementById("application-title");

        if (modal && title) {
            title.textContent = `Postuler à l'offre : ${jobTitle}`;
            modal.style.display = "flex";
            console.log("Modal 'Postuler' ouvert !");
        } else {
            console.error("Erreur : le modal ou le titre n'a pas été trouvé !");
        }
    }

    // ✅ Fonction pour fermer "Postuler maintenant"
    function closeApplicationModal() {
        const modal = document.getElementById("applicationModal");
        if (modal) {
            modal.style.display = "none";
            console.log("Modal 'Postuler' fermé !");
        } else {
            console.error("Erreur : le modal 'Postuler' n'a pas été trouvé !");
        }
    }
</script>
    <script>

// Fonction pour afficher le modal avec animation des points
function showConfirmationModal() {
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmationMessage = document.getElementById('confirmationMessage');

    // Affiche le modal
    confirmationModal.style.display = 'flex';
    confirmationMessage.textContent = 'Veuillez patienter, nous traitons votre candidature';
    confirmationMessage.style.color = 'blue'; // Couleur initiale

    // Animation des points
    let dots = 0;
    const interval = setInterval(() => {
        dots = (dots + 1) % 4; // Alterne entre 0, 1, 2 et 3 points
        confirmationMessage.textContent = `Veuillez patienter, nous traitons votre candidature${'.'.repeat(dots)}`;
    }, 500); // Mise à jour toutes les 500 ms

    return interval; // Renvoie l'identifiant de l'interval pour l'arrêter plus tard
}

// Gestion de la soumission du formulaire
document.getElementById('applicationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche le rechargement de la page

    const formData = new FormData(this); // Récupère les données du formulaire
    const interval = showConfirmationModal(); // Démarre l'animation des points

    // Augmente le délai avant d'envoyer la requête pour rendre l'animation plus visible
    setTimeout(() => {
        // Envoie des données via Fetch API
        fetch('api/candidature.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Analyse la réponse JSON
        .then(data => {
            clearInterval(interval); // Arrête l'animation des points
            const confirmationMessage = document.getElementById('confirmationMessage');
            confirmationMessage.textContent = 'Votre candidature a été envoyée avec succès ! Nous vous contacterons bientôt.';
            confirmationMessage.style.color = 'green'; // Change la couleur pour indiquer le succès
            this.reset(); // Réinitialise le formulaire
        })
        .catch(error => {
            clearInterval(interval); // Arrête l'animation des points
            const confirmationMessage = document.getElementById('confirmationMessage');
            confirmationMessage.textContent = 'Une erreur est survenue. Veuillez réessayer.';
            confirmationMessage.style.color = 'red'; // Change la couleur pour indiquer une erreur
        });
    }, 5000); // Augmente le délai à 5 secondes
});

// Fonction pour fermer le modal
function closeConfirmationModal() {
    const confirmationModal = document.getElementById('confirmationModal');
    confirmationModal.style.display = 'none'; // Ferme le modal

    // Redirection vers la page des offres d'emploi
    window.location.href = 'afficher_emplois.php'; // Change l'URL selon le chemin de ton fichier
}


</script>
<script>

// L'email du candidat doit être récupéré dynamiquement (par session ou autre méthode)
const candidatEmail = "exemple@gmail.com"; // Remplace par l'email dynamique

fetch(`verifier_candidature.php?email=${encodeURIComponent(candidatEmail)}`)
    .then(response => response.json())
    .then(data => {
        const offresPostulees = data.offres_postulees; // Liste des IDs des offres déjà postulées

        offresPostulees.forEach(offreId => {
            // Désactive le bouton correspondant à l'ID de l'offre
            const boutonPostuler = document.getElementById(`postuler_btn_${offreId}`);
            if (boutonPostuler) {
                boutonPostuler.disabled = true; // Désactive le bouton
                boutonPostuler.textContent = "Déjà postulé"; // Change le texte
                boutonPostuler.style.backgroundColor = "gray"; // Change le style visuel
            }
        });
    });


</script>
<script>
    // ✅ Liste des textes à afficher
    const texts = [
        "Découvrez nos offres d'emploi",
        "Trouvez votre prochaine opportunité professionnelle",
        "Des postes disponibles pour tous les talents",
        "Rejoignez une entreprise qui vous correspond",
        "Votre avenir professionnel commence ici",
        "De nouvelles opportunités chaque jour",
        "Construisez votre carrière avec nous",
        "Postulez et faites évoluer votre parcours",
        "Les meilleures offres pour votre métier",
        "Parce que votre talent mérite la meilleure entreprise"
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

</body>
</html>

<?php $conn->close(); ?>
