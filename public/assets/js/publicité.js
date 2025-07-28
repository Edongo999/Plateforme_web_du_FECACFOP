// Sélectionne toutes les images et vidéos dans le conteneur
const items = document.querySelectorAll('.carousel-container img, .carousel-container video');

// Index pour suivre l'élément actif
let currentIndex = 0;

// Fonction pour changer l'élément actif
function changeActiveItem() {
    // Retirer la classe active de l'élément actuel
    items[currentIndex].classList.remove('active');

    // Passer à l'élément suivant
    currentIndex = (currentIndex + 1) % items.length;

    // Ajouter la classe active au nouvel élément
    const currentItem = items[currentIndex];
    currentItem.classList.add('active');

    // Si l'élément actif est une vidéo, attendre sa fin
    if (currentItem.tagName === 'VIDEO') {
        currentItem.play(); // Démarrer la lecture de la vidéo
        currentItem.onended = () => {
            // Une fois la vidéo terminée, passer au prochain élément
            setTimeout(changeActiveItem, 1000); // Petit délai avant de continuer
        };
    } else {
        // Si c'est une image, passer au prochain élément après 3 secondes
        setTimeout(changeActiveItem, 3000);
    }
}

// Lancer le carrousel
changeActiveItem();
