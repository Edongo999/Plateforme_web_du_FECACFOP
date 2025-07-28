 <script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".btn-details").forEach(button => {
        button.addEventListener("click", function() {
            let centreId = this.getAttribute("data-id"); // Récupère l'ID du centre
            fetch("getCentreDetails.php?id=" + centreId) // Envoie une requête AJAX
                .then(response => response.text())
                .then(data => {
                    document.querySelector("#modalContent-" + centreId).innerHTML = data; 
                    let modal = new bootstrap.Modal(document.querySelector("#modal-" + centreId));
                    modal.show();
                })
                .catch(error => console.error("Erreur :", error)); 
        });
    });
});

 
</script>