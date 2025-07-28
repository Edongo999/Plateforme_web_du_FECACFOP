

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
            const hiddenInput = parent.nextElementSibling;
            hiddenInput.value = this.dataset.value;

            if (hiddenInput.value.trim()) {
                hiddenInput.classList.remove("error");
            }

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
        const requiredFields = formSteps[currentStep].querySelectorAll("input[required], textarea[required], select[required]");
        let allFilled = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
                field.classList.add("error");
            } else {
                field.classList.remove("error");
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

    // 🔹 Boutons "Précédent"
    prevButtons.forEach(button => {
        button.addEventListener("click", () => {
            currentStep--;
            updateStep();
        });
    });

    // 🔹 Initialisation des étapes et de la barre de progression
    updateStep();
});


</script>
<script>
document.querySelectorAll(".dropdown-toggle").forEach(button => {
    button.addEventListener("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        // 🔹 Ferme tous les autres dropdowns avant d'ouvrir celui-ci
        document.querySelectorAll(".dropdown-menu").forEach(menu => {
            if (menu !== this.nextElementSibling) {
                menu.style.display = "none";
            }
        });

        const menu = this.nextElementSibling;
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });
});

document.querySelectorAll(".dropdown-menu li").forEach(item => {
    item.addEventListener("click", function(event) {
        event.preventDefault();

        const parent = this.closest(".custom-dropdown");
        parent.querySelector(".dropdown-toggle").textContent = this.textContent;
        const hiddenInput = parent.nextElementSibling;
        hiddenInput.value = this.dataset.value;

        // 🔹 Ferme le menu immédiatement après la sélection
        setTimeout(() => {
            parent.querySelector(".dropdown-menu").style.display = "none";
        }, 100);
    });
});

// 🔹 Ferme le menu si on clique ailleurs sur la page
document.addEventListener("click", function() {
    document.querySelectorAll(".dropdown-menu").forEach(menu => {
        menu.style.display = "none";
    });
});

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></scrip>
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
            const hiddenInput = parent.nextElementSibling;
            hiddenInput.value = this.dataset.value;

            if (hiddenInput.value.trim()) {
                hiddenInput.classList.remove("error");
            }

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
        const requiredFields = formSteps[currentStep].querySelectorAll("input[required], textarea[required], select[required]");
        let allFilled = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
                field.classList.add("error");
            } else {
                field.classList.remove("error");
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

    // 🔹 Boutons "Précédent"
    prevButtons.forEach(button => {
        button.addEventListener("click", () => {
            currentStep--;
            updateStep();
        });
    });

    // 🔹 Initialisation des étapes et de la barre de progression
    updateStep();
});


</script>
<script>
document.querySelectorAll(".dropdown-toggle").forEach(button => {
    button.addEventListener("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        // 🔹 Ferme tous les autres dropdowns avant d'ouvrir celui-ci
        document.querySelectorAll(".dropdown-menu").forEach(menu => {
            if (menu !== this.nextElementSibling) {
                menu.style.display = "none";
            }
        });

        const menu = this.nextElementSibling;
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });
});

document.querySelectorAll(".dropdown-menu li").forEach(item => {
    item.addEventListener("click", function(event) {
        event.preventDefault();

        const parent = this.closest(".custom-dropdown");
        parent.querySelector(".dropdown-toggle").textContent = this.textContent;
        const hiddenInput = parent.nextElementSibling;
        hiddenInput.value = this.dataset.value;

        // 🔹 Ferme le menu immédiatement après la sélection
        setTimeout(() => {
            parent.querySelector(".dropdown-menu").style.display = "none";
        }, 100);
    });
});

// 🔹 Ferme le menu si on clique ailleurs sur la page
document.addEventListener("click", function() {
    document.querySelectorAll(".dropdown-menu").forEach(menu => {
        menu.style.display = "none";
    });
});

</script>
<script>

function showModal(modalId, message) {
    const modal = document.getElementById(modalId);
    const modalText = document.getElementById(modalId + "-text");

    if (modal && modalText) {
        modalText.textContent = message;

        // 🔹 Supprime les icônes de croix en trop avant d'afficher la modale
        const existingIcons = modal.querySelectorAll(".modal-icon");
        if (existingIcons.length > 1) {
            existingIcons.forEach((icon, index) => {
                if (index > 0) icon.remove();
            });
        }

        modal.style.display = "flex";
        modal.style.zIndex = "10000";
        modal.style.position = "fixed";
        modal.scrollIntoView({ behavior: "smooth", block: "center" });
    } else {
        console.error("Modale introuvable ou texte absent :", modalId);
    }
}

// 🔹 Gestion de la fermeture des modales
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// 🔹 Validation et soumission du formulaire des centres
document.getElementById('inscription-centre').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    let allFilled = true;

    // 🔹 Vérification stricte des champs obligatoires pour les centres
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
            // ✅ Afficher le check sans redirection
            const successCheck = document.getElementById("success-check");
            successCheck.style.display = "block";
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
document.getElementById("inscription-centre").addEventListener("submit", function(event) {
    let siteWeb = document.getElementById("site_web").value;
    
    if (siteWeb && !siteWeb.match(/^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\w .-]*)*\/?$/)) {
        alert("L'URL du site web n'est pas valide. Assurez-vous de bien entrer une adresse correcte !");
        event.preventDefault(); // Empêche l'envoi du formulaire uniquement si l’URL est mauvaise
    }
});
</script>
<script>
document.querySelectorAll(".status-option").forEach(option => {
    option.addEventListener("click", function() {
        let radioInput = this.querySelector("input");
        radioInput.checked = true; // ✅ Force l'activation du bouton radio

        // ✅ Ajoute un effet visuel sur la sélection
        document.querySelectorAll(".status-option").forEach(opt => opt.classList.remove("selected"));
        this.classList.add("selected");

        console.log("✅ Statut sélectionné :", radioInput.value); // 🔍 Vérification console
    });
});

// 🔹 Vérification avant l’envoi du formulaire
document.getElementById("inscription-form").addEventListener("submit", function(e) {
    let statut = document.querySelector('input[name="statut"]:checked');

    if (!statut) {
        e.preventDefault(); // ✅ Empêche l’envoi si aucun choix n’est fait
        alert("❌ Veuillez sélectionner votre statut légal avant d'envoyer !");
        return;
    }

    console.log("✅ Statut envoyé :", statut.value); // 🔍 Vérification console
});

</script>
<script>
document.getElementById("close-success-btn").addEventListener("click", function() {
    document.getElementById("success-check").style.display = "none"; // ✅ Masque la fenêtre
});
</script>
<script>
document.getElementById("inscription-centre").addEventListener("submit", function(e) {
    e.preventDefault(); // ✅ Empêche l'envoi classique du formulaire

    let formData = new FormData(this);

    fetch("submit_centre.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("success-overlay").style.display = "block";
            document.getElementById("success-check").style.display = "block"; // ✅ Affiche bien la modal
        } else {
            alert(data.message); // ✅ Affiche un message d'erreur si la soumission échoue
        }
    })
    .catch(error => console.error("❌ Erreur AJAX :", error));
});

// 🔹 Fermer la modal au clic sur "OK"
document.getElementById("close-success-btn").addEventListener("click", function() {
    document.getElementById("success-overlay").style.display = "none";
    document.getElementById("success-check").style.display = "none";
});

</script>





<script>
















document.getElementById('inscription-entreprise').addEventListener('submit', function(e) {
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

    // 🔹 Affiche le loader pendant la soumission
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
            // ✅ Afficher le check sans redirection
            document.getElementById("success-overlay").style.display = "block";
            document.getElementById("success-check").style.display = "block";
        } else {
            showModal("modal-error", "" + data.message);
        }
    })
    .catch(error => {
        loader.style.display = 'none';
        showModal("modal-error", "Erreur technique : " + error.message);
    });
});

// 🔹 Fermer la modal au clic sur "OK", réinitialiser le formulaire et rafraîchir la page via redirection
document.getElementById("close-success-btn").addEventListener("click", function() {
    document.getElementById("success-overlay").style.display = "none";
    document.getElementById("success-check").style.display = "none";

    // 🔹 Réinitialisation complète des champs
    document.getElementById("inscription-entreprise").reset();

  

    // 🔹 Redirection vers la même page après un court délai
    setTimeout(() => {
        window.location.href = window.location.href; // 🔥 Recharge la page via redirection
    }, 500);

    // 🔹 Remise à zéro de la barre de progression
    document.getElementById("progress-bar").style.width = "0%";
    document.getElementById("progress-text").textContent = "0% complété";

    // 🔹 Active le preloader avant la redirection
    document.querySelector(".preloader").style.display = "flex";
});




</script>

<script src="/Plateforme_web_du_FECACFOP/public/assets/js/script.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/animation_titre.js"></script>
<scrip src="/Plateforme_web_du_FECACFOP/public/assets/js/defilement.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/script.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/animation_titre.js"></script>
<script src="/Plateforme_web_du_FECACFOP/public/assets/js/defilement.js"></script>
