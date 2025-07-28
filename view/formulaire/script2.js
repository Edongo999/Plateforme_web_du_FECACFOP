document.addEventListener("DOMContentLoaded", function () {
    // Loader Spinner
    const loader = document.getElementById("loader");
    const container = document.querySelector(".container");

    // Simuler un chargement de 1 seconde
    loader.style.display = "block";
    setTimeout(() => {
        loader.style.display = "none";
        container.style.display = "block";
    }, 1000); // Temps de chargement simulé

    // Animation des lignes dans le tableau (fade-in)
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach((row, index) => {
        setTimeout(() => {
            row.classList.add("visible");
        }, index * 150); // Espacement entre les animations
    });

    // Pagination active et surbrillance
    const paginationLinks = document.querySelectorAll(".pagination a");
    paginationLinks.forEach(link => {
        link.addEventListener("click", function () {
            paginationLinks.forEach(link => link.classList.remove("active"));
            this.classList.add("active");
        });
    });
});
