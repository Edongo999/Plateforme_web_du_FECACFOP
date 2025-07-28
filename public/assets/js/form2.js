document.getElementById('inscription-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // Affiche le loader pendant l'envoi
    const loader = document.getElementById('loader');
    loader.style.display = 'flex';

    fetch(form.action, {
        method: form.method,
        body: formData,
    })
    .then(response => response.text()) // 🔥 Permet de voir la réponse brute du serveur
    .then(text => {
        console.log("🔹 Réponse brute du serveur :", text); // 🔎 Vérifier ce que le serveur renvoie
        
        try {
            const data = JSON.parse(text); // 🔄 Convertit en JSON si tout est OK
            console.log("✅ JSON Converti :", data);

            loader.style.display = 'none'; // Masque le loader

            if (data.success) {
                if (data.redirect) {
                    window.location.href = data.redirect; // 🔄 Redirection si nécessaire
                } else {
                    document.getElementById('modal-success-text').textContent = data.message;
                    document.getElementById('modal-success').style.display = 'flex';
                }
            } else {
                document.getElementById('modal-error-text').textContent = data.message;
                document.getElementById('modal-error').style.display = 'flex';
            }
        } catch (error) {
            console.error("❌ Erreur JSON :", error.message, text); // Affiche l'erreur
            document.getElementById('modal-error-text').textContent = "Erreur technique : " + error.message;
            document.getElementById('modal-error').style.display = 'flex';
        }
    })
    .catch(error => {
        loader.style.display = 'none';
        document.getElementById('modal-error-text').textContent = "Erreur technique : " + error.message;
        document.getElementById('modal-error').style.display = 'flex';
    });
});

// Fonction pour fermer la modale
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none'; // Masque la modale
    }
}

// Ajoutez un listener sur la croix de la modale
document.querySelectorAll('.close-button').forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal'); // Récupère la modale parente
        modal.style.display = 'none'; // Masque la modale
    });
});
