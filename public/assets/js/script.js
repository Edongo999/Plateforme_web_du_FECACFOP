formationBtn.addEventListener('click', function (event) {
    event.preventDefault();

    // Affiche la fenêtre bleue
    loadingScreen.style.display = 'flex';

    // Lancer l'animation d'ouverture (facultatif si pertinent)
    setTimeout(function () {
        loadingScreen.classList.add('open-doors');
    }, 300); // Réduit à 300 ms pour un démarrage rapide

    // Rediriger plus rapidement vers la fenêtre cible
    setTimeout(function () {
        window.location.href = formationBtn.getAttribute('href'); // Redirige vers la page souhaitée
    }, 700); // Temps réduit à 1,5 seconde
});

