document.querySelectorAll(".dropdown-menu li").forEach(item => {
    item.addEventListener("click", function() {
        const parent = this.closest(".custom-dropdown");
        parent.querySelector(".dropdown-toggle").textContent = this.textContent;
        const hiddenInput = parent.nextElementSibling; // L'input caché
        hiddenInput.value = this.dataset.value;
    });
});
