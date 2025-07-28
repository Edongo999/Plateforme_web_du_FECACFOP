

<?php
// Scripts JS chargés correctement
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
function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.classList.add("show");
}
window.openModal = openModal;

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.classList.remove("show");
}
window.closeModal = closeModal;

document.addEventListener("DOMContentLoaded", function () {
  const orientationForm = document.getElementById("orientation-form");
  if (orientationForm) {
    orientationForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const data = new FormData(this);

      fetch("orientation_submit.php", {
        method: "POST",
        body: data
      })
        .then(res => res.text())
        .then(msg => {
          alert(msg);
          this.reset();
          closeModal("orientation-modal");
        })
        .catch(() => alert("❌ Une erreur est survenue. Veuillez réessayer."));
    });
  }
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const formSteps = document.querySelectorAll(".form-step");
    const nextButtons = document.querySelectorAll(".next-btn");
    const prevButtons = document.querySelectorAll(".prev-btn");
    const progressBar = document.getElementById("progress-bar");
    const progressText = document.getElementById("progress-text");
    let currentStep = 0;

    // 🔹 Gestion des custom-dropdown pour bien enregistrer la sélection
    document.querySelectorAll(".dropdown-menu li").forEach(item => {
        item.addEventListener("click", function(event) {
            event.stopPropagation();

            const parent = this.closest(".custom-dropdown");
            parent.querySelector(".dropdown-toggle").textContent = this.textContent;
            const hiddenInput = parent.querySelector("input[type='hidden']");
            hiddenInput.value = this.dataset.value;

            // ✅ Supprime l'erreur visuelle si une sélection est faite
            if (hiddenInput.value.trim()) {
                hiddenInput.classList.remove("error");
            }

            // ✅ Ferme le menu dropdown
            setTimeout(() => {
                parent.querySelector(".dropdown-menu").style.display = "none";
            }, 200);
        });
    });

    // 🔹 Fonction pour afficher l'étape actuelle
    const updateStep = () => {
        formSteps.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);
        });

        let progressPercentage = (currentStep / (formSteps.length - 1)) * 100;
        progressBar.style.width = `${progressPercentage}%`;
        progressText.textContent = `${Math.round(progressPercentage)}% complété`;
    };

    // 🔹 Vérification des champs obligatoires avant de passer à l'étape suivante
    const isStepValid = () => {
        const requiredFields = formSteps[currentStep].querySelectorAll("input[required], textarea[required]");
        let allFilled = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
                field.classList.add("error");
            } else {
                field.classList.remove("error");
            }
        });

        // ✅ Vérification des dropdowns obligatoires
        const requiredDropdowns = formSteps[currentStep].querySelectorAll(".custom-dropdown input[type='hidden']");
        requiredDropdowns.forEach(hiddenInput => {
            if (!hiddenInput.value.trim()) {
                allFilled = false;
                hiddenInput.classList.add("error");
            } else {
                hiddenInput.classList.remove("error");
            }
        });

        return allFilled;
    };

    // 🔹 Activation/désactivation du bouton suivant
    nextButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            if (!isStepValid()) {
                event.preventDefault();
                showModal("modal-mandatory", "Veuillez remplir tous les champs avant de continuer !");
                return;
            }
            currentStep++;
            updateStep();
        });
    });

    // 🔹 Gestion des boutons "Précédent"
    prevButtons.forEach(button => {
        button.addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                updateStep();
            }
        });
    });

    // 🔹 Assurer que le dropdown se ferme quand on clique ailleurs
    document.addEventListener("click", function(event) {
        document.querySelectorAll(".dropdown-menu").forEach(menu => {
            if (!menu.contains(event.target) && !event.target.classList.contains("dropdown-toggle")) {
                menu.style.display = "none";
            }
        });
    });

    // 🔹 Initialisation des étapes et de la barre de progression
    updateStep();
});

// 🔹 Fonction pour afficher les modales
function showModal(modalId, message) {
    const modal = document.getElementById(modalId);
    const modalText = document.getElementById(modalId + "-text");

    if (modal && modalText) {
        modalText.textContent = message;
        modal.style.display = "flex";
        modal.style.zIndex = "10000";
        modal.style.position = "fixed";
        modal.scrollIntoView({ behavior: "smooth", block: "center" });
    } else {
        console.error("Modale introuvable ou texte absent :", modalId);
    }
}

</script>
<script>
document.querySelectorAll(".dropdown-menu li").forEach(item => {
    item.addEventListener("click", function(event) {
        event.preventDefault();

        const parent = this.closest(".custom-dropdown");
        const toggleButton = parent.querySelector(".dropdown-toggle");
        const hiddenInput = parent.querySelector("input[type='hidden']");
        const menu = parent.querySelector(".dropdown-menu");

        // ✅ Met à jour la valeur du dropdown
        toggleButton.textContent = this.textContent;
        hiddenInput.value = this.dataset.value;

        console.log("✅ Sélection enregistrée :", hiddenInput.value); // Vérification console

        // ✅ Fermeture immédiate du dropdown après sélection
        menu.style.display = "none";
    });
});

// 🔹 Vérification si un menu est ouvert et le ferme après sélection
document.addEventListener("click", function(event) {
    document.querySelectorAll(".dropdown-menu").forEach(menu => {
        if (!menu.contains(event.target) && !event.target.classList.contains("dropdown-toggle")) {
            menu.style.display = "none";
        }
    });
});



</script>


<script>
function showModal(modalId, message) {
    const modal = document.getElementById(modalId);
    const modalText = document.getElementById(modalId + "-text");

    if (modal && modalText) {
        modalText.textContent = message; // 🔹 Met à jour le message

        // 🔹 Supprime toutes les icônes de croix en trop avant d'afficher la modale
        const existingIcons = modal.querySelectorAll(".modal-icon");
        if (existingIcons.length > 1) {
            existingIcons.forEach((icon, index) => {
                if (index > 0) icon.remove(); // 🔹 Supprime les croix supplémentaires
            });
        }

        modal.style.display = "flex"; // 🔹 Affiche correctement la modale
    } else {
        console.error("Modale introuvable ou texte absent :", modalId);
    }
}

// 🔹 Ajoute la gestion de la fermeture des modales
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// 🔹 Intègre cette fonction AVANT l’envoi du formulaire
document.getElementById('inscription-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    let allFilled = true;

    // 🔹 Vérification stricte des champs obligatoires
    const requiredFields = form.querySelectorAll(".form-step.active input[required], .form-step.active textarea[required]");
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            allFilled = false;
            field.classList.add("error");
        } else {
            field.classList.remove("error");
        }
    });

    if (!allFilled) {
        showModal("modal-mandatory", "Veuillez remplir tous les champs obligatoires avant d'envoyer !");
        return;
    }

    // 🔹 Affiche le loader pendant l'envoi
    const loader = document.getElementById('loader');
    loader.style.display = 'flex';

    fetch(form.action, {
        method: form.method,
        body: new FormData(form),
    })
    .then(response => response.json())
    .then(data => {
        loader.style.display = 'none';

        if (data.success) {
            window.location.href = data.redirect || "confirmation.php";
        } else {
            showModal("modal-error", "" + data.message);
        }
    })
    .catch(error => {
        loader.style.display = 'none';
        showModal("modal-error", "Erreur technique : " + error.message);
    });
});

</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const closeSuccessBtn = document.getElementById("close-loader-btn");
    const successCheck = document.getElementById("success-check");

    if (closeSuccessBtn && successCheck) {
        closeSuccessBtn.addEventListener("click", function () {
            console.log("Bouton OK cliqué, fermeture du check !");
            successCheck.style.display = "none"; // ✅ Masquer proprement le check
        });
    } else {
        console.error("Erreur : Bouton ou check non trouvé !");
    }
});

</script>
<script>
document.querySelectorAll(".search-dropdown").forEach(dropdown => {
    let searchInput = dropdown.querySelector(".searchInput");
    let dropdownMenu = dropdown.querySelector(".dropdown-menu");
    let options = dropdownMenu.querySelectorAll("li");
    let hiddenInput = dropdown.querySelector(".selectedValue");

    // 🔹 Affichage dynamique du menu en fonction de la recherche
    searchInput.addEventListener("input", function() {
        let filter = this.value.toLowerCase();
        let found = false;

        options.forEach(option => {
            let text = option.textContent.toLowerCase();
            if (text.includes(filter)) {
                option.style.display = "block";
                found = true;
            } else {
                option.style.display = "none";
            }
        });

        dropdownMenu.style.display = found ? "block" : "none";
    });

    // 🔹 Sélection et mise à jour du champ caché
    options.forEach(option => {
        option.addEventListener("click", function() {
            searchInput.value = this.textContent;
            hiddenInput.value = this.dataset.value;
            dropdownMenu.style.display = "none"; // ✅ Ferme la liste après sélection

            console.log("✅ Option sélectionnée :", hiddenInput.value);
        });
    });

    // 🔹 Fermeture du menu si on clique ailleurs
    document.addEventListener("click", function(event) {
        if (!dropdown.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    });
});

</script>
<script>
document.querySelectorAll(".sex-option").forEach(option => {
    option.addEventListener("click", function() {
        let radioInput = this.querySelector("input");
        radioInput.checked = true; // ✅ Force l'activation du bouton radio

        // ✅ Ajoute un effet visuel sur la sélection
        document.querySelectorAll(".sex-option").forEach(opt => opt.classList.remove("selected"));
        this.classList.add("selected");

        console.log("✅ Sexe sélectionné :", radioInput.value); // 🔍 Vérification console
    });
});

// 🔹 Vérification avant l’envoi du formulaire
document.getElementById("inscription-form").addEventListener("submit", function(e) {
    let sexe = document.querySelector('input[name="sexe"]:checked');

    if (!sexe) {
        e.preventDefault(); // ✅ Empêche l’envoi si aucun choix n’est fait
        alert("❌ Veuillez sélectionner votre sexe avant d'envoyer !");
        return;
    }

    console.log("✅ Sexe envoyé :", sexe.value); // 🔍 Vérification console
});

</script>
<script>
window.openModal = function(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.add("show");
    modal.scrollIntoView({ behavior: "smooth" });
  }
};

window.closeModal = function(id) {
  const modal = document.getElementById(id);
  if (!modal) return;

  // Si c’est une modale gérée par style.display (ex : .style.display = 'flex')
  if (modal.style.display === "flex") {
    modal.style.display = "none";
  }

  // Si c’est une modale gérée par la classe .show
  if (modal.classList.contains("show")) {
    modal.classList.remove("show");
  }
};

</script>



<script src="/Plateforme_web_du_FECACFOP/public/assets/js/script.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/animation_titre.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/defilement.js"></script>
