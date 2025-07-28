<?php
header("Content-Type: application/javascript");
?>
 <script>
function toggleChat() {
  const chatWindow = document.getElementById("chat-window");
  chatWindow.style.display = (chatWindow.style.display === "none" || chatWindow.style.display === "") ? "block" : "none";
}

function sendMessage() {
  const msg = document.getElementById("chat-message").value;
  if (!msg.trim()) return;

  const chat = document.getElementById("chat-output");
  chat.innerHTML += `<p><strong>Moi:</strong> ${msg}</p>`;

  fetch("/Plateforme_web_du_FECACFOP/public/chatbot.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: "message=" + encodeURIComponent(msg)
  })
  .then(res => res.text())
  .then(rep => {
    chat.innerHTML += `<p><strong>Bot:</strong> ${rep}</p>`;
    chat.scrollTop = chat.scrollHeight;
    document.getElementById("chat-message").value = "";
  });
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/jquery-migrate-3.0.0.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/jquery-ui.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/easing.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/colors.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/popper.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/bootstrap-datepicker.js"></script>
<script src="/Plateforme_web_du_RAPFOPT/public/assets/js/jquery.nav.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/slicknav.min.js"></script>
<script src="/Plateforme_web_du_RAPFOPT/public/assets/js/jquery.scrollUp.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/niceselect.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/tilt.jquery.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/owl-carousel.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/jquery.counterup.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/steller.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/wow.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/jquery.magnific-popup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/bootstrap.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/main.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/publicite.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

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