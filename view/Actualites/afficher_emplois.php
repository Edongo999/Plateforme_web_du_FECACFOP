<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        if ($diff->y > 0) {
            return "il y a " . $diff->y . " " . ($diff->y > 1 ? "ans" : "an");
        } elseif ($diff->m > 0) {
            return "il y a " . $diff->m . " mois";
        } elseif ($diff->d >= 7) {
            $weeks = floor($diff->d / 7);
            return "il y a " . $weeks . " semaine" . ($weeks > 1 ? "s" : "");
        } elseif ($diff->d > 0) {
            return "il y a " . $diff->d . " jour" . ($diff->d > 1 ? "s" : "");
        } elseif ($diff->h > 0) {
            return "il y a " . $diff->h . "h" . ($diff->i > 0 ? $diff->i . "min" : "");
        } elseif ($diff->i > 0) {
            return "il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
        } elseif ($diff->s > 30) {
            return "il y a " . $diff->s . " secondes";
        } else {
            return "à l’instant";
        }
    }
}

// 🔄 Ici on change la requête pour afficher les emplois non archivés
$sql = "SELECT * FROM emplois WHERE archived = 0 ORDER BY date_publication DESC";
$result = $conn->query($sql);
?>

<?php include_once '../header1.php'; ?>
<div class="container-title">  
    <h6>Actualités & Nouvelles de la Plateforme</h6>  
    <p class="description">Explorez les dernières annonces, nouveautés techniques et événements marquants du FECACFOP</p>  
</div>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Actualités - Lire plus</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
          .actualite-unique-scope .actualites {
        background: #f9f9f9;
        padding: 40px 20px;
        max-width: 1200px;
        margin: 40px auto;
        border-radius: 14px;
        border: 1px solid #ddd;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
      }

  
    .actualite-unique-scope .actualite-card {
        background: #fff;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-start;
         flex-wrap: wrap;
       align-items: stretch;
 
    }
        .actualite-unique-scope .actualite-media {
      width: 100%;
      max-width: 200px;
      height: auto;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      border: 3px solid #f2f2f2
      flex-shrink: 0;
    }
    .actualite-unique-scope .actualite-content {
        flex: 1;
    }
    .actualite-unique-scope .actualite-titre {
        font-size: 20px;
        margin: 0 0 10px;
        color: #007bff;
    }
    .actualite-unique-scope .actualite-description {
        margin: 0 0 15px;
    }
    .actualite-unique-scope .btn-details-view,
    .actualite-unique-scope .btn-share-toggle {
        background: #007bff;
        border: none;
        color: white;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 5px;
        font-weight: bold;
        margin-right: 8px;
    }
    .actualite-unique-scope .btn-details-view:hover,
    .actualite-unique-scope .btn-share-toggle:hover {
        background: #0056b3;
    }
    .actualite-unique-scope .share-container {
        position: relative;
        display: inline-block;
        margin-top: 10px;
    }
    .actualite-unique-scope .share-icons {
        display: none;
        position: absolute;
        top: 42px;
        left: 0;
        background: white;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 6px 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        gap: 10px;
        z-index: 100;
    }
    .actualite-unique-scope .share-icons a i {
        font-size: 20px;
        transition: transform 0.2s;
    }
    .actualite-unique-scope .share-icons a i:hover {
        transform: scale(1.3);
    }
  .actualite-unique-scope .custom-modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.actualite-unique-scope #modal-description {
  text-align: justify;
  white-space: pre-wrap;
  line-height: 1.9;
  font-size: 17px;
  letter-spacing: 0.1px;
  padding: 16px;
  max-height: 320px;
  overflow-y: auto;
  border: 1px solid #eee;
  background: #fafafa;
  border-radius: 6px;
}

    .actualite-unique-scope #modal-title {
  font-size: 22px;
  font-weight: 600;
  color: #007bff;
  margin-bottom: 15px;
  word-break: break-word;
  line-height: 1.4;
  text-align: center;
}

    .actualite-unique-scope .custom-modal-content {
        background: white;
        padding: 20px;
        max-width: 600px;
        width: 90%;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        text-align: center;
        max-height: 90vh;
        overflow-y: auto;
    }
    .actualite-unique-scope #modal-media img,
    .actualite-unique-scope #modal-media video {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
        margin-bottom: 15px;
    }
    .actualite-unique-scope #modal-description {
       
        line-height: 1.6;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        text-align: justify;
    }
    .actualite-unique-scope .custom-modal-close-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 8px 12px;
        margin-top: 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        .actualite-unique-scope .actualite-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .actualite-unique-scope .actualite-media {
            width: 100%;
            max-height: 150px;
        }
        .actualite-unique-scope .share-icons {
            flex-direction: column;
            right: 0;
            left: auto;
        }
        .actualite-unique-scope .custom-modal-content {
            padding: 15px;
            max-height: 90vh;
        }
        .actualite-unique-scope #modal-description {
            max-height: 250px;
            font-size: 14px;
        }
    }
    .actualite-unique-scope .date-publiee {
  font-size: 13px;
  color: #888;
  margin: 6px 0;
}
.fade-up-on-scroll {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.fade-up-on-scroll.visible {
  opacity: 1;
  transform: translateY(0);
}

.media-wrapper {
  position: relative;
  display: inline-block;
  cursor: zoom-in;
}

.overlay-icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 32px;
  color: rgba(255, 255, 255, 0.9);
  opacity: 0;
  transition: opacity 0.3s ease;
  pointer-events: none;
}

.media-wrapper:hover .overlay-icon {
  opacity: 1;
}

#image-modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.7);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

#image-modal img {
  max-width: 95%;
  max-height: 90vh;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
  </style>
  </head>
<body>

<div class="actualite-unique-scope">
  <div class="actualites">
    <?php
    $conn = new mysqli("localhost", "root", "", "rapcefop");
    $sql = "SELECT * FROM emplois WHERE archived = 0 ORDER BY date_publication DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $titre = htmlspecialchars($row['titre'], ENT_QUOTES);
            $contenu = htmlspecialchars($row['description'], ENT_QUOTES);
            $media = htmlspecialchars($row['media'], ENT_QUOTES);
            $url = "http://localhost/Plateforme_web_du_FECACFOP/view/Emplois/emploi.php?id={$id}";

            echo "<div class='actualite-card fade-up-on-scroll'>";

            if (!empty($media)) {
                echo "<div class='media-wrapper'>";
                echo "<img src='/Plateforme_web_du_FECACFOP/uploads/emplois/" . basename($media) . "' class='actualite-media' alt='Image emploi'>";
                echo "</div>";
            }

            echo "<div class='actualite-content'>";
            echo "<h2 class='actualite-titre'>{$titre}</h2>";
            echo "<p class='date-publiee'>Publié " . time_elapsed_string($row['date_publication']) . "</p>";
            echo "<p class='actualite-description'>" . substr($contenu, 0, 100) . "...</p>";

            echo "<button class='btn-details-view'
                    data-title=\"{$titre}\"
                    data-description=\"{$contenu}\"
                    data-media=\"{$media}\"
                    data-type=\"image\"
                    onclick=\"handleModalClick(this)\">Lire plus</button>";

            echo "<button class='btn-candidature' data-title=\"{$titre}\">Postuler maintenant</button>";

            echo "<div class='share-container'>
                    <button class='btn-share-toggle' onclick='toggleShare(this)'>
                        <i class='fas fa-share-alt'></i> Partager
                    </button>
                    <div class='share-icons'>
                        <a href='https://wa.me/?text=" . urlencode($url) . "' target='_blank'><i class='fab fa-whatsapp' style='color:#25D366;'></i></a>
                        <a href='https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url) . "' target='_blank'><i class='fab fa-facebook' style='color:#1877F2;'></i></a>
                        <a href='https://twitter.com/intent/tweet?url=" . urlencode($url) . "' target='_blank'><i class='fab fa-x-twitter' style='color:#000;'></i></a>
                        <a href='https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($url) . "' target='_blank'><i class='fab fa-linkedin' style='color:#0077B5;'></i></a>
                        <a href='mailto:?subject=Offre d’emploi&body=" . urlencode($url) . "' target='_blank'><i class='fas fa-envelope' style='color:#D44638;'></i></a>
                    </div>
                </div>";

            echo "</div></div>";
        }
    } else {
        echo "<p>Aucune offre d’emploi disponible.</p>";
    }
    ?>
  </div>
<div id="image-modal" class="custom-modal" onclick="closeImageModal()">
  <img id="image-modal-content" src="" alt="Zoom image">
</div>


    
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
                <label for="pays">Regions :</label>
                <input type="text" id="pays" name="pays" placeholder="Votre régions" required>
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
 <style>
          .actualite-unique-scope .actualites {
        background: #f9f9f9;
        padding: 40px 20px;
        max-width: 1200px;
        margin: 40px auto;
        border-radius: 14px;
        border: 1px solid #ddd;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
      }

  
    .actualite-unique-scope .actualite-card {
        background: #fff;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-start;
         flex-wrap: wrap;
       align-items: stretch;
 
    }
        .actualite-unique-scope .actualite-media {
      width: 100%;
      max-width: 200px;
      height: auto;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      border: 3px solid #f2f2f2
      flex-shrink: 0;
    }
    .actualite-unique-scope .actualite-content {
        flex: 1;
    }
    .actualite-unique-scope .actualite-titre {
        font-size: 20px;
        margin: 0 0 10px;
        color: #007bff;
    }
    .actualite-unique-scope .actualite-description {
        margin: 0 0 15px;
    }
    .actualite-unique-scope .btn-details-view,
    .actualite-unique-scope .btn-share-toggle {
        background: #007bff;
        border: none;
        color: white;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 5px;
        font-weight: bold;
        margin-right: 8px;
    }
    .actualite-unique-scope .btn-details-view:hover,
    .actualite-unique-scope .btn-share-toggle:hover {
        background: #0056b3;
    }
    .actualite-unique-scope .share-container {
        position: relative;
        display: inline-block;
        margin-top: 10px;
    }
    .actualite-unique-scope .share-icons {
        display: none;
        position: absolute;
        top: 42px;
        left: 0;
        background: white;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 6px 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        gap: 10px;
        z-index: 100;
    }
    .actualite-unique-scope .share-icons a i {
        font-size: 20px;
        transition: transform 0.2s;
    }
    .actualite-unique-scope .share-icons a i:hover {
        transform: scale(1.3);
    }
  .actualite-unique-scope .custom-modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.actualite-unique-scope #modal-description {
  text-align: justify;
  white-space: pre-wrap;
  line-height: 1.9;
  font-size: 17px;
  letter-spacing: 0.1px;
  padding: 16px;
  max-height: 320px;
  overflow-y: auto;
  border: 1px solid #eee;
  background: #fafafa;
  border-radius: 6px;
}

    .actualite-unique-scope #modal-title {
  font-size: 22px;
  font-weight: 600;
  color: #007bff;
  margin-bottom: 15px;
  word-break: break-word;
  line-height: 1.4;
  text-align: center;
}

    .actualite-unique-scope .custom-modal-content {
        background: white;
        padding: 20px;
        max-width: 600px;
        width: 90%;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        text-align: center;
        max-height: 90vh;
        overflow-y: auto;
    }
    .actualite-unique-scope #modal-media img,
    .actualite-unique-scope #modal-media video {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
        margin-bottom: 15px;
    }
    .actualite-unique-scope #modal-description {
       
        line-height: 1.6;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        text-align: justify;
    }
    .actualite-unique-scope .custom-modal-close-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 8px 12px;
        margin-top: 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        .actualite-unique-scope .actualite-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .actualite-unique-scope .actualite-media {
            width: 100%;
            max-height: 150px;
        }
        .actualite-unique-scope .share-icons {
            flex-direction: column;
            right: 0;
            left: auto;
        }
        .actualite-unique-scope .custom-modal-content {
            padding: 15px;
            max-height: 90vh;
        }
        .actualite-unique-scope #modal-description {
            max-height: 250px;
            font-size: 14px;
        }
    }
    .actualite-unique-scope .date-publiee {
  font-size: 13px;
  color: #888;
  margin: 6px 0;
}
.fade-up-on-scroll {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.fade-up-on-scroll.visible {
  opacity: 1;
  transform: translateY(0);
}

.media-wrapper {
  position: relative;
  display: inline-block;
  cursor: zoom-in;
}

.overlay-icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 32px;
  color: rgba(255, 255, 255, 0.9);
  opacity: 0;
  transition: opacity 0.3s ease;
  pointer-events: none;
}

.media-wrapper:hover .overlay-icon {
  opacity: 1;
}

#image-modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.7);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

#image-modal img {
  max-width: 95%;
  max-height: 90vh;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
  </style>
<div class="footer-separator"></div>
<footer id="footer" class="footer">

<script>
    // ✅ Liste des textes à afficher
    const texts = [
    "Découvrez nos offres d'emploi et de stage",
    "Trouvez votre prochaine opportunité professionnelle ou académique",
    "Des postes et stages disponibles pour tous les talents",
    "Rejoignez une entreprise ou un centre de formation qui vous correspond",
    "Votre avenir commence ici, en entreprise ou en formation",
    "De nouvelles opportunités chaque jour, en emploi et en stage",
    "Construisez votre carrière avec un poste ou une expérience en entreprise",
    "Postulez et faites évoluer votre parcours avec un stage ou un emploi",
    "Les meilleures offres adaptées à votre profil",
    "Votre talent mérite la meilleure entreprise et la meilleure formation"
    ];

    let indexText = 0; // Indice du texte actuel
    const title = document.getElementById("animated-title-emploi");

    function typeEffect(text, callback) {
        title.textContent = ""; 
        let index = 0;

        function typeLetter() {
            if (index < text.length) {
                title.textContent += text[index];
                index++;
                setTimeout(typeLetter, 100);
            } else {
                setTimeout(callback, 2500); // Attente avant le changement de texte
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
    document.addEventListener("DOMContentLoaded", () => {
        setTimeout(cycleTexts, 500);
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Chargement des événements...");

        // ✅ Attacher "Lire plus" à chaque bouton
        const lirePlusButtons = document.querySelectorAll(".btn-details-view");

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
        const postulerButtons = document.querySelectorAll(".btn-candidature");

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
    }, 300); // Mise à jour toutes les 500 ms

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
 <footer id="footer-unique" class="footer-unique">
      <?php include_once '../footer.php'; ?>
      <?php include_once '../script_site.php'; ?>
  </footer>
</body>
</html>

<?php $conn->close(); ?>
