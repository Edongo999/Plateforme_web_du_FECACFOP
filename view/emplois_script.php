
  <script>
  const cards = document.querySelectorAll('.fade-up-on-scroll');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, {
    threshold: 0.1
  });

  cards.forEach(card => {
    observer.observe(card);
  });
</script>

<script>
function openImageModal(media) {
  document.getElementById('image-modal').style.display = 'flex';
  document.getElementById('image-modal-content').src = media;
}

function closeImageModal() {
  document.getElementById('image-modal').style.display = 'none';
}
</script>
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
                const description = button.dataset.description || "Pas de description disponible";

              
                const media = card.querySelector(".actualite-media") ? card.querySelector(".actualite-media").src : "";

                openModal(title, description, media);
            });
        });
       


        // ✅ Attacher "Postuler maintenant" à chaque bouton
        const postulerButtons = document.querySelectorAll(".btn-candidature-unique");

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

        // Mise en forme fluide de la description
        modalDescription.innerHTML = description
            .split(/(?<=\.)\s+/)
            .map(phrase => `<p>${phrase.trim()}</p>`)
            .join('');

        modalMedia.innerHTML = media
            ? `<img src="${media}" alt="Image emploi" style="width: 100%; border-radius: 10px;">`
            : "";

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


  <script>
  function toggleShare(button) {
      const icons = button.nextElementSibling;
      icons.style.display = (icons.style.display === 'none' || icons.style.display === '') ? 'flex' : 'none';
  }
  document.addEventListener('click', function (e) {
  document.querySelectorAll('.share-icons').forEach(function (menu) {
    const toggle = menu.previousElementSibling;
    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
      menu.style.display = 'none';
    }
  });
});
  </script>

<script>
function compterVue(id) {
  fetch("/Plateforme_web_du_FECACFOP/view/Actualites/increment_vue.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + encodeURIComponent(id)
  }).then(res => {
    if (res.ok) {
      const compteur = document.querySelector(`.vue-counter[data-id='${id}']`);
      if (compteur) {
        let count = parseInt(compteur.dataset.count || "0");
        count++;
        compteur.dataset.count = count;

        // Formater comme '1.2k' ou '1M'
        let affichage;
        if (count >= 1000000) affichage = (count / 1000000).toFixed(1) + "M";
        else if (count >= 1000) affichage = (count / 1000).toFixed(1) + "k";
        else affichage = count;

        compteur.innerHTML = `<i class='fas fa-eye'></i> ${affichage} vues`;

        // (optionnel) petit effet visuel
        compteur.style.opacity = 0.5;
        setTimeout(() => { compteur.style.opacity = 1; }, 150);
      }
    }
  });
}
function handleModalClick(button) {
  const id = button.dataset.id;
  compterVue(id);
  // 👉 Ici tu peux ajouter ta logique pour ouvrir la modale de description
}

function handlePostuler(button) {
  const id = button.dataset.id;
  compterVue(id);
  // 👉 Ici tu peux déclencher le formulaire de candidature
}

function handleImageClick(div) {
  const id = div.dataset.id;
  compterVue(id);

  // 🔍 On récupère l’image cliquée et on l’affiche dans le modal
  const img = div.querySelector("img");
  if (img) {
    openImageModal(img.src); // ← ta fonction définie ailleurs
  }
}

</script>