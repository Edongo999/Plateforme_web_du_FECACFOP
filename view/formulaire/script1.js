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
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur HTTP : " + response.status);
        }
        return response.json(); // Parse le JSON
    })
    .then(data => {
        loader.style.display = 'none'; // Masque le loader

        if (data.success) {
            // Redirige si une URL de redirection est présente
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                const modalSuccess = document.getElementById('modal-success');
                document.getElementById('modal-success-text').textContent = data.message;
                modalSuccess.style.display = 'flex';
            }
        } else {
            // Affiche une erreur si la réponse indique un échec
            const modalError = document.getElementById('modal-error');
            document.getElementById('modal-error-text').textContent = data.message;
            modalError.style.display = 'flex';
        }
    })
    .catch(error => {
        loader.style.display = 'none';
        const modalError = document.getElementById('modal-error');
        document.getElementById('modal-error-text').textContent = "Erreur technique : " + error.message;
        modalError.style.display = 'flex';
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
