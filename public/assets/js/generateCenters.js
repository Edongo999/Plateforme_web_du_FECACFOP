const centers = [
    {
        name: 'Centre de Formation Douala',
        address: 'Douala, Cameroun',
        formations: 'Réseaux, Marketing Digital, Gestion de Projets.',
        image: 'img/souki.jpg' // Chemin réel de l'image
    },
    {
        name: 'Centre de Formation Yaoundé',
        address: 'Yaoundé, Cameroun',
        formations: 'Développement Web, Cybersécurité.',
        image: 'images/centre2.jpg'
    },
    {
        name: 'Centre de Formation Bafoussam',
        address: 'Bafoussam, Cameroun',
        formations: 'Bureautique, Comptabilité.',
        image: 'images/centre3.jpg'
    },
    {
        name: 'Centre de Formation Bafoussam',
        address: 'Bafoussam, Cameroun',
        formations: 'Bureautique, Comptabilité.',
        image: 'images/centre3.jpg'
    },
    {
        name: 'Centre de Formation Bafoussam',
        address: 'Bafoussam, Cameroun',
        formations: 'Bureautique, Comptabilité.',
        image: 'images/centre3.jpg'
    }
    
   
    // Ajoutez d'autres centres ici
];

document.addEventListener('DOMContentLoaded', function () {
    const centersSection = document.querySelector('.centers'); // Section cible

    centers.forEach(center => {
        const centerElement = document.createElement('div');
        centerElement.classList.add('center');

        // Ajouter l'image
        const image = document.createElement('img');
        image.src = center.image;
        image.alt = `Image de ${center.name}`;
        centerElement.appendChild(image);

        // Ajouter le nom
        const title = document.createElement('h3');
        title.textContent = center.name;
        centerElement.appendChild(title);

        // Ajouter l'adresse
        const address = document.createElement('p');
        address.textContent = `Adresse : ${center.address}`;
        centerElement.appendChild(address);

        // Ajouter les formations
        const formations = document.createElement('p');
        formations.textContent = center.formations;
        centerElement.appendChild(formations);

        // Ajouter un bouton "En savoir plus"
        const link = document.createElement('a');
        link.href = '#'; // Lien à personnaliser
        link.classList.add('btn');
        link.textContent = 'En savoir plus';
        centerElement.appendChild(link);

        // Ajouter ce centre à la section
        centersSection.appendChild(centerElement);
    });
});


