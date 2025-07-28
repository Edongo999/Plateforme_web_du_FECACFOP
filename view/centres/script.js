const centres = [
    { nom: "Centre Alpha", description: "Formation en informatique", image: "images/télécharger.jpg" },
    { nom: "Centre Beta", description: "Formation en ingénierie", image: "images/beta.jpg" }
];

// 🔹 Affichage dynamique des centres
const centresContainer = document.getElementById("centres-container");
centres.forEach(centre => {
    const div = document.createElement("div");
    div.classList.add("centre-card");
    div.innerHTML = `
        <img src="${centre.image}" alt="${centre.nom}">
        <h3>${centre.nom}</h3>
        <button onclick='openModal("${centre.nom}", "${centre.description}", "${centre.image}")'>Plus de détails</button>
    `;
    centresContainer.appendChild(div);
});

// 🔹 Gestion du modal
function openModal(title, description, image) {
    document.getElementById("modal-title").textContent = title;
    document.getElementById("modal-description").textContent = description;
    document.getElementById("modal-image").src = image;
    document.getElementById("modal").style.display = "flex";
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

// 🔹 Redirection vers la page d'inscription
function redirectToInscription() {
    window.location.href = "inscription.php";
}
