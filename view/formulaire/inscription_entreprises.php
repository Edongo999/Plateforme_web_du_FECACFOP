




<?php include_once '../header.php'; ?>
<div class="container-title">
    <h6>Inscription des Entreprises,Association et Autres</h6>
    <p class="description">Rejoignez notre Fédération et développez des partenariats avec les centres de formation et les acteurs économiques du Cameroun.</p>
</div>

<link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/formulaire.css">

<main>
    <div class="progress-container">
        <div class="progress-bar" id="progress-bar"></div>
        <span class="progress-text" id="progress-text">0% complété</span>
    </div>

    <form id="inscription-entreprise" action="submit_entreprises.php" method="post" enctype="multipart/form-data">
        
        <div class="form-step active">
            <fieldset>
                <legend>Informations Générales</legend>

                <label for="nom_entreprise">Nom de l’Entreprise :</label>
                <input type="text" id="nom_entreprise" name="nom_entreprise" placeholder="Nom de l'entreprise" required>

                <label for="secteur">Secteur d’activité :</label>
                <input type="text" id="secteur" name="secteur" placeholder="Ex : Commerce, Industrie, Services..." required>

                <label for="statut_juridique">Statut Juridique :</label>
                <input type="text" id="statut_juridique" name="statut_juridique" placeholder="Ex : SARL, SA, Auto-Entrepreneur..." required>

                <label for="date_creation">Date de création :</label>
                <input type="date" id="date_creation" name="date_creation" required>
            </fieldset>
            <button type="button" class="next-btn">Suivant</button>
        </div>

        <div class="form-step">
            <fieldset>
                <legend>Coordonnées & Contact de l'entreprise</legend>
                <label for="adresse">Adresse complète :</label>
                <textarea id="adresse" name="adresse" rows="3" placeholder="Ville, quartier, région" required></textarea>

                <label for="telephone">Numéro de téléphone:</label>
                <input type="tel" id="telephone" name="telephone" placeholder="(+237) XXX XX XX XX" required>

                <label for="email">Email professionnel :</label>
                <input type="email" id="email" name="email" placeholder="contact@entreprise.com" required>
            </fieldset>
            <button type="button" class="prev-btn">Précédent</button>
            <button type="button" class="next-btn">Suivant</button>
        </div>

        <div class="form-step">
            <fieldset>
                <legend>Responsable de l’Entreprise</legend>
                <label for="nom_responsable">Nom du Responsable :</label>
                <input type="text" id="nom_responsable" name="nom_responsable" placeholder="Nom du dirigeant" required>

                <label for="fonction">Fonction :</label>
                <input type="text" id="fonction" name="fonction" placeholder="Ex : PDG, Directeur..." required>

                <label for="contact_responsable">Numéro de téléphone :</label>
                <input type="tel" id="contact_responsable" name="contact_responsable" placeholder="(+237) XXX XX XX XX" required>

                <label for="email_responsable">Email du Responsable :</label>
                <input type="email" id="email_responsable" name="email_responsable" required>
            </fieldset>
            <button type="button" class="prev-btn">Précédent</button>
            <button type="submit">Valider l'inscription</button>
        </div>
    </form>
</main>

<!-- ✅ Fenêtre modale de succès -->
<div id="success-overlay" class="success-overlay"></div>

<div id="success-check" class="success_check">
    ✅ **Félicitations, votre entreprise est inscrite !**  
    <p>Bienvenue sur la plateforme **FECACFOP** 🎉</p>
    <p>Votre inscription a été enregistrée avec succès et nous sommes ravis de vous compter parmi nous.</p>
    <p>Notre équipe vous contactera bientôt pour finaliser votre adhésion et vous fournir **toutes les informations essentielles**.</p>
    <p>**À très bientôt !**</p> 
    <button id="close-success-btn">OK</button>
</div>


<!-- 🔹 Loader pendant la soumission -->
<div id="loader" class="loader_formulaire" style="display: none;">
    <div class="spinner_formulaire"></div>
    <p>Veuillez patienter...</p>
</div>

<!-- Fenêtre modale pour le message de succès -->
<div id="modal-success" class="formulaire-modal" style="display: none;">
    <div class="formulaire-modal-content">
        <div class="formulaire-modal-icon">&#10004;</div>
        <p id="modal-success-text">Inscription réussie !</p>
        <button onclick="closeModal('modal-success')">OK</button>
    </div>
</div>

<!-- Fenêtre modale pour le message d'erreur -->
<div id="modal-error" class="formulaire-modal" style="display: none;">
    <div class="formulaire-modal-content">
        <div class="modal-icon">&#10060;</div>
        <p id="modal-error-text">Erreur : Cette entreprise est déjà enregistrée.</p>
        <button onclick="closeModal('modal-error')">OK</button>
    </div>
</div>

<!-- Modale pour les champs obligatoires -->
<div id="modal-mandatory" class="formulaire-modal" style="display: none;">
    <div class="formulaire-modal-content">
        <div class="modal-icon">&#9888;</div>
        <p id="modal-mandatory-text">Veuillez remplir tous les champs obligatoires.</p>
        <button onclick="closeModal('modal-mandatory')">OK</button>
    </div>
</div>

<footer id="footer-inscription" class="footer-inscription">
    <?php include_once '../footer.php'; ?>
     <?php include_once '../script_centres.php'; ?>
</footer>
