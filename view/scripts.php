
<!-- jQuery -->
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
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/jquery.nav.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/slicknav.min.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/jquery.scrollUp.min.js"></script>
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
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/avancement.js"></script>
 <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css_actualites/lightbox/js/lightbox.min.js">  
 <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css_actualites/lightbox/js/lightbox.js"> 

<script>
document.addEventListener("DOMContentLoaded", function() {
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        initialSlide: 2,
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 300,
            modifier: 1,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector(".carousel-container");
    const items = document.querySelectorAll(".carousel-item");
    let currentIndex = 0;

    function scrollCarousel() {
        currentIndex = (currentIndex + 1) % items.length;
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    setInterval(scrollCarousel, 5000);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll(".carousel-item");
    let currentIndex = 0;

    function showItem(index) {
        items.forEach((item, i) => {
            item.style.opacity = i === index ? "1" : "0";
            item.style.zIndex = i === index ? "1" : "0";
        });
    }

    setInterval(() => {
        currentIndex = (currentIndex + 1) % items.length;
        showItem(currentIndex);
    }, 5000);

    showItem(currentIndex);
});
</script>

<!-- Animation de chargement 
<div id="loadingScreen">
    <div class="left-panel"></div>
    <div class="right-panel"></div>
    <div class="arc-container">
        <p class="loading-message">Veuillez patienter pendant le chargement...</p>
        <div class="semi-arc arc-one"></div>
        <div class="semi-arc arc-two"></div>
        <div class="logo1"></div>
    </div>
</div>-->
<script>
				document.addEventListener("DOMContentLoaded", function() {
    const elements = document.querySelectorAll('.fade-in');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            } else {
                entry.target.classList.remove("visible"); // Supprime la classe quand il quitte la vue
            }
        });
    }, { threshold: 0.2 }); // Active quand 20% de l'élément est visible

    elements.forEach(el => observer.observe(el));
});

</script>
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
<script>
    function searchCentres() {
        let input = document.getElementById("searchBar").value.toLowerCase();
        let cards = document.querySelectorAll(".centre-card");

        cards.forEach(card => {
            let title = card.querySelector(".centre-card-title").textContent.toLowerCase();
            if (title.includes(input)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }
</script>
<script>
   document.getElementById('inscription-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // 🔹 Affiche le loader spécifique au formulaire
    const loader = document.getElementById('formulaire-loader');
    loader.style.display = 'flex';

    fetch(form.action, {
        method: form.method,
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur HTTP : " + response.status);
        }
        return response.json(); // 🔹 Parse la réponse en JSON
    })
    .then(data => {
        loader.style.display = 'none'; // 🔹 Masque le loader après l'envoi

        if (data.success) {
            // 🔹 Redirection en cas de succès
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                const modalSuccess = document.getElementById('formulaire-modal-success');
                document.getElementById('formulaire-modal-success-text').textContent = data.message;
                modalSuccess.style.display = 'flex';
            }
        } else {
            // 🔹 Affichage d’un message d’erreur
            const modalError = document.getElementById('formulaire-modal-error');
            document.getElementById('formulaire-modal-error-text').textContent = data.message;
            modalError.style.display = 'flex';
        }
    })
    .catch(error => {
        loader.style.display = 'none';
        const modalError = document.getElementById('formulaire-modal-error');
        document.getElementById('formulaire-modal-error-text').textContent = "Erreur technique : " + error.message;
        modalError.style.display = 'flex';
    });
});

// 🔹 Fonction pour fermer une modale spécifique au formulaire
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// 🔹 Ajoutez un listener sur la croix de fermeture des modales
document.querySelectorAll('.formulaire-close-button').forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.formulaire-modal'); // 🔹 Sélectionne la modale correspondante
        modal.style.display = 'none';
    });
});

</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    const formSteps = document.querySelectorAll(".formulaire-step");
    const nextButtons = document.querySelectorAll(".formulaire-next-btn");
    const prevButtons = document.querySelectorAll(".formulaire-prev-btn");
    const progressBar = document.getElementById("formulaire-progress-bar");
    const progressText = document.getElementById("formulaire-progress-text");
    let currentStep = 0;

    // 🔹 Fonction pour afficher l'étape actuelle
    const updateStep = () => {
        formSteps.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);
        });

        // 🔹 Mise à jour dynamique de la barre de progression
        let progressPercentage = (currentStep / (formSteps.length - 1)) * 100;
        progressBar.style.width = `${progressPercentage}%`;
        progressText.textContent = `${Math.round(progressPercentage)}% complété`;

        console.log("🔹 Mise à jour barre :", progressPercentage); // 🔎 Vérification en console
    };

    // 🔹 Vérification des champs avant de passer à l'étape suivante
    const isStepValid = () => {
        const inputs = formSteps[currentStep].querySelectorAll(
            ".formulaire-input[required], .formulaire-select[required], .formulaire-textarea[required]"
        );
        let allFilled = true;

        inputs.forEach((input) => {
            if (!input.value.trim()) {
                allFilled = false;
                input.classList.add("formulaire-error");
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains("formulaire-error-message")) {
                    let errorDiv = document.createElement("div");
                    errorDiv.classList.add("formulaire-error-message");
                    errorDiv.textContent = "⚠️ Ce champ est obligatoire !";
                    input.parentNode.appendChild(errorDiv);
                }
            } else {
                input.classList.remove("formulaire-error");
                if (input.nextElementSibling && input.nextElementSibling.classList.contains("formulaire-error-message")) {
                    input.nextElementSibling.remove();
                }
            }
        });

        console.log("Validation du formulaire :", allFilled); // 🔎 Vérification en console
        return allFilled;
    };

    // 🔹 Activation/désactivation du bouton suivant
    nextButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            if (!isStepValid()) {
                event.preventDefault();
                alert("⚠️ Veuillez remplir tous les champs avant de continuer !");
                return;
            }

            currentStep++;
            updateStep();
        });
    });

    // 🔹 Bouton "Valider l'inscription" - Autoriser l'envoi
    document.getElementById("inscription-form").addEventListener("submit", function (event) {
        if (!isStepValid()) {
            event.preventDefault();
            alert("⚠️ Veuillez remplir tous les champs avant d'envoyer !");
        } else {
            console.log("✅ Formulaire soumis !");
        }
    });

    // 🔹 Boutons "Précédent"
    prevButtons.forEach((button) => {
        button.addEventListener("click", () => {
            currentStep--;
            updateStep();
        });
    });

    // 🔹 Initialisation des étapes et de la barre de progression
    updateStep();
});

// 🔹 Vérification de l'email en temps réel
document.getElementById("email").addEventListener("input", function () {
    const emailRegex = /^[^\s@]+@[^\s@]+.[^\s@]+$/;
    const emailError = document.getElementById("formulaire-email-error");

    if (!emailRegex.test(this.value)) {
        this.classList.add("formulaire-error");
        emailError.textContent = "❌ Adresse e-mail invalide !";
    } else {
        this.classList.remove("formulaire-error");
        emailError.textContent = ""; // Efface le message d'erreur
    }
});

</script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/script.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/animation_titre.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/defilement.js"></script>
