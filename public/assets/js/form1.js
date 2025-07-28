document.addEventListener("DOMContentLoaded", function () {
    const formSteps = document.querySelectorAll(".form-step");
    const nextButtons = document.querySelectorAll(".next-btn");
    const prevButtons = document.querySelectorAll(".prev-btn");
    const modalError = document.getElementById("modal-error");
    let currentStep = 0;

    const updateStep = () => {
        formSteps.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);
        });
    };

    const isStepValid = () => {
        const inputs = formSteps[currentStep].querySelectorAll("input[required], select[required]");
        return Array.from(inputs).every(input => input.value.trim() !== "");
    };

    nextButtons.forEach(button => {
        button.addEventListener("click", () => {
            if (!isStepValid()) {
                modalError.style.display = "block";
                return;
            }
            currentStep++;
            updateStep();
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener("click", () => {
            currentStep--;
            updateStep();
        });
    });

    updateStep();
});

// Fermer la modale d'erreur
function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}
