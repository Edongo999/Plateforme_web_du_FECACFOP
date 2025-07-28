const carousel = document.querySelector('.testimonials-carousel');
const testimonials = document.querySelectorAll('.testimonial-card');
const prevButton = document.getElementById('prev');
const nextButton = document.getElementById('next');

let currentIndex = 0;

// Fonction pour afficher un témoignage spécifique
function showTestimonial(index) {
    carousel.style.transform = `translateX(-${index * 100}%)`;
}

// Défilement automatique toutes les 5 secondes
function autoScroll() {
    currentIndex = (currentIndex + 1) % testimonials.length;
    showTestimonial(currentIndex);
}

let autoScrollInterval = setInterval(autoScroll, 5000);

// Navigation manuelle avec les boutons
prevButton.addEventListener('click', () => {
    clearInterval(autoScrollInterval);
    currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
    showTestimonial(currentIndex);
});

nextButton.addEventListener('click', () => {
    clearInterval(autoScrollInterval);
    currentIndex = (currentIndex + 1) % testimonials.length;
    showTestimonial(currentIndex);
});
