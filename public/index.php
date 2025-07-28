
<?php
require_once '../config/connexion.php';


// 1️⃣ Chargement du header **en premier**
include __DIR__ . '/../view/header.php';

// 2️⃣ Contenu principal
include __DIR__ . '/../view/slider.php';
include __DIR__ . '/../view/schedule.php';
include __DIR__ . '/../view/about.php';
include __DIR__ . '/../view/impact.php';
include __DIR__ . '/../view/publicites.php';
// 3️⃣ Chargement des publicités **à leur bon emplacement**



// 4️⃣ Suite du contenu


include __DIR__ . '/../view/contact.php';
include __DIR__ . '/../view/portfolio.php';
include __DIR__ . '/../view/partners.php';
include __DIR__ . '/../view/leaders.php';
include __DIR__ . '/../view/team.php';
include __DIR__ . '/../view/testimonials.php';
include __DIR__ . '/../view/newsletter.php';

// 5️⃣ Pied de page et scripts
include __DIR__ . '/../view/footer.php';
include __DIR__ . '/../view/scripts.php';

?>

