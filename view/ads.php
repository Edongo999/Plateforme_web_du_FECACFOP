<?php
echo "<p>Inclus depuis :</p>";
echo "<pre>";
debug_print_backtrace();
echo "</pre>";
?>

<section class="ads-section">
    <h2>Nos Publicités</h2>
    <div class="ads-container">
        <?php include 'Actualites/publicites.php'; ?>
    </div>
</section>
