const textElement = document.getElementById("animated-text");
const textArray = [
    "SIMON DUPONG Fondateur et President National",
   
];

let textIndex = 0;
let charIndex = 0;

function typeText() {
    if (charIndex < textArray[textIndex].length) {
        textElement.textContent += textArray[textIndex].charAt(charIndex);
        charIndex++;
        setTimeout(typeText, 100); // Temps entre chaque lettre
    } else {
        setTimeout(eraseText, 2000); // Temps avant d'effacer le texte
    }
}

function eraseText() {
    if (charIndex > 0) {
        textElement.textContent = textElement.textContent.slice(0, -1);
        charIndex--;
        setTimeout(eraseText, 50); // Vitesse d'effacement
    } else {
        textIndex = (textIndex + 1) % textArray.length; // Passe au texte suivant
        setTimeout(typeText, 500); // Pause avant de réécrire
    }
}

typeText(); // Démarre l'animation
