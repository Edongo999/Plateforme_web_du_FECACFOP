<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");
$sql = "SELECT * FROM centres_inscrits ORDER BY date_inscription DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()): ?>
<div class="modal fade" id="modal-<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modalLabel-<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $row['nom_centre']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent-<?php echo $row['id']; ?>">
                <p>Chargement des informations...</p> <!-- Le contenu sera chargé dynamiquement ici -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
