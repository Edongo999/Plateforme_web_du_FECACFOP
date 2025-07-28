

function closeModal() {
    const modal = document.getElementById('modal');
    modal.style.display = "none";
}

function openModal(title, description, media, type) {
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const modalDescription = document.getElementById('modal-description');
    const modalMedia = document.getElementById('modal-media');

    // Remplir le contenu de la modal dynamiquement
    modalTitle.textContent = title;
    modalDescription.textContent = description;

    if (type === 'image') {
        modalMedia.innerHTML = `<img src="${media}" alt="${title}">`;
    } else if (type === 'video') {
        modalMedia.innerHTML = `
            <video controls>
                <source src="${media}" type="video/mp4">
                Votre navigateur ne prend pas en charge la vidéo.
            </video>`;
    }

    // Afficher la modal
    modal.style.display = "flex";
}

function closeModal() {
    // Masquer la modal
    const modal = document.getElementById('modal');
    modal.style.display = "none";
}


document.addEventListener('DOMContentLoaded', () => {
    const contenu = document.getElementById('contenu');
    const suggestionsBox = document.getElementById('suggestions');
    const dictionary = ['education', 'formation', 'professionnel', 'média', 'publication']; // Ajoutez vos propres mots

    contenu.addEventListener('input', () => {
        const userInput = contenu.value.toLowerCase();
        suggestionsBox.innerHTML = '';

        if (userInput.length > 2) {
            const matches = dictionary.filter(word => word.startsWith(userInput));
            matches.forEach(match => {
                const suggestion = document.createElement('span');
                suggestion.textContent = match;
                suggestion.addEventListener('click', () => {
                    contenu.value = match;
                    suggestionsBox.style.display = 'none';
                });
                suggestionsBox.appendChild(suggestion);
            });
            suggestionsBox.style.display = matches.length > 0 ? 'block' : 'none';
        } else {
            suggestionsBox.style.display = 'none';
        }
    });
});
