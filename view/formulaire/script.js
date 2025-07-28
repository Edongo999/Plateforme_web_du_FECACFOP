document.addEventListener("DOMContentLoaded", function () {
    const formSteps = document.querySelectorAll(".form-step");
    const nextButtons = document.querySelectorAll(".next-btn");
    const prevButtons = document.querySelectorAll(".prev-btn");
    const progressBar = document.getElementById("progress-bar");
    const progressText = document.getElementById("progress-text");
    let currentStep = 0;

    // 🔹 Fonction pour afficher l'étape actuelle
    const updateStep = () => {
        formSteps.forEach((step, index) => {
            step.classList.toggle('active', index === currentStep);
        });
    
        // 🔹 Correction : Mise à jour dynamique de la barre de progression
        let progressPercentage = (currentStep / (formSteps.length - 1)) * 100;
    
        // 🔥 Met à jour visuellement la largeur de la barre
        progressBar.style.width = `${progressPercentage}%`; 
        progressText.textContent = `${Math.round(progressPercentage)}% complété`;
    
        console.log("🔹 Mise à jour barre :", progressPercentage); // 🔎 Vérifie la valeur en console
    };
    
    

    // 🔹 Vérification des champs avant de passer à l'étape suivante
    const isStepValid = () => {
        const inputs = formSteps[currentStep].querySelectorAll("input[required], select[required], textarea[required]");
        let allFilled = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                allFilled = false;
                input.classList.add("error"); 
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains("error-message")) {
                    let errorDiv = document.createElement("div");
                    errorDiv.classList.add("error-message");
                    errorDiv.textContent = "⚠️ Ce champ est obligatoire !";
                    input.parentNode.appendChild(errorDiv);
                }
            } else {
                input.classList.remove("error");
                if (input.nextElementSibling && input.nextElementSibling.classList.contains("error-message")) {
                    input.nextElementSibling.remove();
                }
            }
        });

        console.log("Validation du formulaire :", allFilled); // 🔎 Vérifie si le formulaire est valide
        return allFilled;
    };

    // 🔹 Activation/désactivation du bouton suivant
    nextButtons.forEach(button => {
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
    document.getElementById("inscription-form").addEventListener("submit", function(event) {
        if (!isStepValid()) {
            event.preventDefault(); 
            alert("⚠️ Veuillez remplir tous les champs avant d'envoyer !");
        } else {
            console.log("✅ Formulaire soumis !");
        }
    });

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
document.getElementById("email").addEventListener("input", function() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailError = document.getElementById("email-error");

    if (!emailRegex.test(this.value)) {
        this.classList.add("error"); // Ajoute une bordure rouge au champ
        emailError.textContent = "❌ Adresse e-mail invalide !";
    } else {
        this.classList.remove("error"); // Supprime la bordure rouge
        emailError.textContent = ""; // Efface le message d'erreur
    }
});
