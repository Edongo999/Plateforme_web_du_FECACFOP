
<?php include_once '../header.php'; ?>
 <div class="container-title">
    <h6>Formulaire D'inscription à Nos Formations</h6>
    <p class="description">Rejoignez notre Fédération et développez vos compétences en vous inscrivant à la formation qui correspond à vos ambitions.</p>
</div>
 <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/formulaire.css">

<div style="text-align: center; margin-top: 20px;">
  <button type="button" class="orientation-open-btn" onclick="openModal('orientation-modal')">
    Besoin d’aide pour choisir votre formation ?
  </button>
</div>

    <main>
        <!-- Barre de progression -->
        <div class="progress-container">
    <div class="progress-bar" id="progress-bar"></div>
    <span class="progress-text" id="progress-text">0% complété</span>
</div>
<!-- Formulaire Multi-Étapes -->
<form id="inscription-form" action="submit.php" method="post">
    <!-- Étape 1 : Informations personnelles -->
    <div class="form-step active">
        <fieldset>
            <legend>Informations personnelles</legend>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" placeholder="Votre nom de famille" required>

            <label for="date-naissance">Date de naissance :</label>
            <input type="date" id="date-naissance" name="date-naissance" required>
            
            <label>Sexe :</label>
            <div class="sex-selection">
                <label class="sex-option">
                    <input type="radio" name="sexe" value="homme" required>
                    <span class="icon">👨</span> <span class="text">Homme</span>
                </label>

                <label class="sex-option">
                    <input type="radio" name="sexe" value="femme" required>
                    <span class="icon">👩</span> <span class="text">Femme</span>
                </label>
            </div>

           <div class="search-dropdown">
        <label for="searchRegion">Région :</label>
        <input type="text" class="searchInput" id="searchRegion" placeholder="Recherchez une région..." autocomplete="off">
        <ul class="dropdown-menu">
            <li data-value="Adamaoua">Adamaoua</li>
            <li data-value="Centre">Centre</li>
            <li data-value="Est">Est</li>
            <li data-value="Extrême-Nord">Extrême-Nord</li>
            <li data-value="Littoral">Littoral</li>
            <li data-value="Nord">Nord</li>
            <li data-value="Nord-Ouest">Nord-Ouest</li>
            <li data-value="Ouest">Ouest</li>
            <li data-value="Sud">Sud</li>
            <li data-value="Sud-Ouest">Sud-Ouest</li>
        </ul>
        <input type="hidden" class="selectedValue" name="region">
    </div>
        </fieldset>
    <button type="button" class="next-btn">Suivant</button>

        </div>

        <!-- Étape 2 : Coordonnées -->
        <div class="form-step">
            <fieldset>
                <legend>Coordonnées</legend>
                <label for="email">Adresse email :</label>
                <input type="email" id="email" name="email" placeholder="votre.email@example.com" required>
                <div id="email-error" class="error-message"></div> <!-- Zone d'affichage de l'erreur -->

                <!-- <label for="email">Adresse email :</label>
                <input type="email" id="email" name="email" placeholder="votre.email@example.com" required>
                -->

                <label for="telephone">Numéro de téléphone :</label>
                <input type="tel" id="telephone" name="telephone" placeholder="(+237) 6XX XX XX XX" required>

                <label for="adresse">Adresse résidentielle :</label>
                <textarea id="adresse" name="adresse" rows="3" placeholder="Ville, quartier..." required></textarea>
            </fieldset>
            <button type="button" class="prev-btn">Précédent</button>
            <button type="button" class="next-btn">Suivant</button>
        </div>

    <!-- Étape 3 : Formation et centre -->
    <div class="form-step">
        <fieldset>
            <legend>Formation et centre</legend>
 <div class="search-dropdown">
    <label for="searchProgramme">Programme souhaité :</label>
    <input type="text" class="searchInput" id="searchProgramme" placeholder="Recherchez un programme..." autocomplete="off">
    <ul class="dropdown-menu">
        <li data-value="developpement-web">Développement Web</li>
        <li data-value="marketing-digital">Marketing Digital</li>
    </ul>
    <input type="hidden" class="selectedValue" name="programme">
</div>


<div class="search-dropdown">
    <label for="searchCentre">Centre que vous souhaitez intégrer :</label>
    <input type="text" class="searchInput" id="searchCentre" placeholder="Recherchez votre centre..." autocomplete="off">
    <ul class="dropdown-menu">
        <li data-value="Douala">Centre de Formation Douala</li>
        <li data-value="Yaoundé">Centre de Formation Yaoundé</li>
    </ul>
    <input type="hidden" class="selectedValue" name="centre">
</div>


            <label for="motivations">Motivations (facultatif) :</label>
            <textarea id="motivations" name="motivations" rows="3" placeholder="Parlez-nous de vos motivations..."></textarea>
        </fieldset>
        <button type="button" class="prev-btn">Précédent</button>
        <button type="submit">Valider l'inscription</button>

    </div>

</form>
    </main>
  
<div id="orientation-modal" class="orientation-modal-wrapper">
  <div class="orientation-modal-box">
    <h3 class="orientation-modal-title">
        Formulaire d'orientation
        </h3>
        <p class="orientation-subtitle">
         Dites-nous qui vous êtes pour qu’on vous guide vers la bonne formation
        </p>
    <form id="orientation-form">
      <label for="profil">Décrivez votre profil :</label>
      <textarea id="profil" name="profil" required
  placeholder="Ex. Je suis Daniel, j’ai 25 ans, j’ai une passion pour les ordinateurs mais je ne sais pas encore vers quel métier m’orienter...">
</textarea>

      <label for="niveau">Niveau d’études :</label>
      <input type="text" id="niveau" name="niveau" required placeholder="Ex: Bac, BEPC, CEP, Sans diplôme...">

      <label for="telephone-orientation">Téléphone :</label>
      <input type="tel" id="telephone-orientation" name="telephone" required placeholder="+237 6XX XX XX XX">

      <label for="email-orientation">Email :</label>
      <input type="email" id="email-orientation" name="email" required placeholder="votre.email@example.com">

      <button type="submit">Envoyer</button>
      <button type="button" onclick="closeModal('orientation-modal')" class="btn-cancel">Annuler</button>
    </form>
  </div>
</div>

    <!-- Animation de chargement -->
<div id="loader" class="loader_formulaire" style="display: none;">
    <div class="spinner_formulaire"></div>
    <p>Veuillez patienter...</p>
</div>

<div id="success-check" style="display: none; text-align: center; margin-top: 20px;">
  <div style="font-size: 48px; color: green;">✔️</div>
  <p style="color: green;">Votre demande a été envoyée avec succès.</p>
</div>

<!-- Fenêtre modale pour le message de succès -->
<div id="modal-success" class="formulaire-modal" style="display: none;">
    <div class="formulaire-modal-content">
        <div class="formulaire-modal-icon">&#10004;</div>
        <p id="modal-success-text">Inscription réussie !</p>
        <button onclick="closeModal('modal-success')">OK</button>
    </div>
</div>
<div id="modal-error" class="formulaire-modal" style="display: none;">
    <div class="formulaire-modal-content">
      
        <div class="modal-icon">&#10060;</div>
        <p id="modal-error-text">Erreur : Nous avons remarqué que vous êtes déjà inscrit avec ce nom et prénom. Si vous pensez qu'il s'agit d'une erreur, n'hésitez pas à nous contacter pour vérifier vos informations.</p>
        <button onclick="closeModal('modal-error')">OK</button>
    </div>
</div>
<!-- Fenêtre modale pour le message d'erreur -->

<!-- Modale pour les champs obligatoires -->
<div id="modal-mandatory" class="formulaire-modal" style="display: none;">
    <div class="formulaire-modal-content">
        <div class="modal-icon">&#9888;</div> <!-- Icône d'avertissement -->
        <p id="modal-mandatory-text">Veuillez remplir tous les champs obligatoires avant de soumettre le formulaire.</p>
        <button onclick="closeModal('modal-mandatory')">OK</button>
    </div>
</div>




<script>
function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.add("show");
    modal.scrollIntoView({ behavior: "smooth" });
  }
}
window.openModal = openModal;

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.remove("show");
  }
}
window.closeModal = closeModal;

document.addEventListener("DOMContentLoaded", function () {
  const orientationForm = document.getElementById("orientation-form");
  const loader = document.getElementById("loader");

  if (orientationForm) {
    orientationForm.addEventListener("submit", function (e) {
      e.preventDefault();

      loader.style.display = "flex";

      const formData = new FormData(this);

      fetch("orientation_submit.php", {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          loader.style.display = "none";

          if (data.success) {
            window.location.href = data.redirect || "orientation-confirmation.php";
          } else {
            showModal("modal-error", data.message || "Une erreur est survenue.");
          }
        })
        .catch(() => {
          loader.style.display = "none";
          showModal("modal-error", "Erreur réseau : impossible de contacter le serveur.");
        });
    });
  }
});
</script>















<div class="footer-separator-inscription"></div>
<footer id="footer-inscription" class="footer-inscription">
    <?php include_once '../footer.php'; ?>
    <?php include_once '../script1.php'; ?>


</footer>