<?php
require_once '../view/header.php';  // ✅ Inclure l'en-tête

$controller = new CentreController();
$centres = $controller->getCentres();
$recommendedCentres = $controller->getRecommendedCentres();
?>
<div class="background">
    <h1 id="animated-title"></h1>
</div>
<!-- SECTION CENTRES DE FORMATION -->
<div class="container mt-5">
    <div class="centre-card-container">
        <?php foreach ($centres as $centre) : ?>
            <div class="centre-card shadow-sm">
                <img src="../view/centres/uploads/<?php echo $centre['logo']; ?>" class="centre-card-img-top" alt="<?php echo htmlspecialchars($centre['nom']); ?>">
                <div class="centre-card-body text-center">
                    <h5 class="centre-card-title"><?php echo htmlspecialchars($centre['nom']); ?></h5>

                    <div class="specialites-container">
                        <div class="specialites-scroll">
                            <?php $specs = explode(", ", $centre['specialite']); ?>
                            <?php foreach ($specs as $spec): ?>
                                <span class="specialite-item"><?php echo htmlspecialchars($spec); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="centre-card-footer">
                        <a href="details_centre.php?id=<?php echo $centre['id']; ?>" class="centre-btn centre-btn-info">En savoir plus</a>
                        <a href="demande_formation.php?id=<?php echo $centre['id']; ?>" class="centre-btn centre-btn-success">Demande de formation</a>
                    </div>
                </div>
              <!-- SECTION CHATBOT -->
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Lien WhatsApp -->
<a href="https://api.whatsapp.com/send?phone=237697475573" target="_blank" class="whatsapp-link">
    <img src="../img/whatsapp.png" alt="WhatsApp">
</a>

<?php require_once '../view/footer.php'; 
include __DIR__ . '/../view/scripts.php'; ?>
