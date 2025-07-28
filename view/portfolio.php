<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");
$sql = "SELECT id, nom_centre, logo_path FROM centres_inscrits ORDER BY date_inscription DESC";
$result = $conn->query($sql);
?>

<section class="portfolio section">
    <div class="partners-title">
        <h2>Nos Centres de Formation Membres</h2>
        <p class="partners-description">Explorez les centres qui contribuent à la réussite et à l'impact de notre réseau.</p>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="owl-carousel portfolio-slider">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="single-pf">
                            <img src="http://localhost<?php echo $row['logo_path']; ?>" alt="<?php echo $row['nom_centre']; ?>">
                            <p><strong><?php echo $row['nom_centre']; ?></strong></p>
                            <a href="/Plateforme_web_du_FECACFOP/view/portfolio-details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Détails</a>

                           
                                Détails
                            </button>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="/script_detail.js"></script>

<?php $conn->close(); ?>
