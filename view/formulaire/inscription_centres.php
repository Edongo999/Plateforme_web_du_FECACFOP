            <?php include_once '../header.php'; ?>
            <div class="container-title">
                <h6>Inscription des Centres de Formation</h6>
                <p class="description">Rejoignez notre Fédération et bénéficiez d’un réseau d’établissements accrédités.</p>
            </div>

            <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/formulaire.css">
                <main>
                    <!-- Barre de progression -->
                    <div class="progress-container">
                <div class="progress-bar" id="progress-bar"></div>
                <span class="progress-text" id="progress-text">0% complété</span>
            </div>

            <!-- Formulaire Multi-Étapes -->
            <!-- Formulaire Multi-Étapes -->
                <form id="inscription-centre" action="submit_centre.php" method="post" enctype="multipart/form-data">
                    
                    <!-- Étape 1 : Informations Générales -->
                    <div class="form-step active">
                        <fieldset>
                            <legend>Informations Générales</legend>
                            
                            <label for="nom_centre">Nom du Centre :</label>
                            <input type="text" id="nom_centre" name="nom_centre" placeholder="Nom du centre" required>
                            
                            <label for="secteur">Secteur d’activité :</label>
                            <input type="text" id="secteur" name="secteur" placeholder="Secteur du centre" required>

                            <label>Statut légal :</label>
                            <div class="status-selection">
                                <label class="status-option">
                                    <input type="radio" name="statut" value="privé" required>
                                    <span class="icon">🏠</span> <span class="text">Privé</span>
                                </label>

                                <label class="status-option">
                                    <input type="radio" name="statut" value="public" required>
                                    <span class="icon">🏛️</span> <span class="text">Public</span>
                                </label>

                                <label class="status-option">
                                    <input type="radio" name="statut" value="ong" required>
                                    <span class="icon">🌍</span> <span class="text">ONG</span>
                                </label>
                            </div>
                            <label for="date_creation">Date de création :</label>
                            <input type="date" id="date_creation" name="date_creation" required>

                        </fieldset>
                        <button type="button" class="next-btn">Suivant</button>
                    </div>
       <!-- Étape 2 : Coordonnées & Contact -->
        <div class="form-step">
            <fieldset>
                <legend>Coordonnées & Contact du centre</legend>
                
                <label for="adresse">Adresse complète :</label>
                <textarea id="adresse" name="adresse" rows="3" placeholder="Ville, quartier, région" required></textarea>

                <label for="telephone">Numéro de téléphone :</label>
                <input type="tel" id="telephone" name="telephone" placeholder="(+237) XXX XX XX XX" required>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="contact@centre.com" required>

                <label for="site_web">Site web(optionnel) :</label>
                <textarea id="site_web" name="site_web" rows="2" placeholder="Ex : https://www.centre.com"></textarea>  
            </fieldset>
            <button type="button" class="prev-btn">Précédent</button>
            <button type="button" class="next-btn">Suivant</button>
        </div>

    <!-- Étape 3 : Responsable du Centre -->
        <div class="form-step">
            <fieldset>
                <legend>Responsable du Centre</legend>

                <label for="nom_responsable">Nom du Responsable :</label>
                <input type="text" id="nom_responsable" name="nom_responsable" placeholder="Nom du directeur" required>

                <label for="fonction">Fonction :</label>
                <input type="text" id="fonction" name="fonction" placeholder="Directeur, Fondateur..." required>

                <label for="contact_responsable">Numéro de téléphone :</label>
                <input type="tel" id="contact_responsable" name="contact_responsable" placeholder="(+237) XXX XX XX XX" required>

                <label for="email_responsable">Email du Responsable :</label>
                <input type="email" id="email_responsable" name="email_responsable" required>
                
            </fieldset>
            <button type="button" class="prev-btn">Précédent</button>
            <button type="button" class="next-btn">Suivant</button>
        </div>
       <!-- Étape 4 : Informations Pédagogiques -->
        <div class="form-step">
            <fieldset>
                <legend>Informations Pédagogiques</legend>

                <label for="nombre_etudiants">Nombre d’apprenants :</label>
                <input type="number" id="nombre_etudiants" name="nombre_etudiants" placeholder="Ex : 150" required>

                <label for="nombre_formateurs">Nombre de formateurs :</label>
                <input type="number" id="nombre_formateurs" name="nombre_formateurs" placeholder="Ex : 10" required>

                <label for="types_formations">Types de formations proposées :</label>
                <textarea id="types_formations" name="types_formations" rows="3" placeholder="Diplômantes, courtes, longues..." required></textarea>

                <label>Langue d’enseignement :</label>
                <div class="status-selection">
                    <label class="status-option">
                        <input type="radio" name="langue_enseignement" value="francais" required>
                        <span class="icon">🇫🇷</span> <span class="text">Français</span>
                    </label>

                    <label class="status-option">
                        <input type="radio" name="langue_enseignement" value="anglais" required>
                        <span class="icon">🇬🇧</span> <span class="text">Anglais</span>
                    </label>

                    <label class="status-option">
                        <input type="radio" name="langue_enseignement" value="bilingue" required>
                        <span class="icon">🌍</span> <span class="text">Bilingue</span>
                    </label>
                </div>

            </fieldset>
            <button type="button" class="prev-btn">Précédent</button>
            <button type="button" class="next-btn">Suivant</button>
        </div>

        <div class="form-step">
            <fieldset>
                <legend>Certifications & Agréments(optionnel)</legend>

                <label for="certifications">Certifications :</label>
                <textarea id="certifications" name="certifications" rows="3" placeholder="Ex : Certifié Cisco, Microsoft..."></textarea>

                <label for="agrements">Agréments :</label>
                <textarea id="agrements" name="agrements" rows="3" placeholder="Ex : Agréé par l'État, Reconnu par le Ministère de l'Éducation..."></textarea>
            </fieldset>

            <button type="button" class="prev-btn">Précédent</button>
            <button type="submit">Valider l'inscription</button>
        </div>      
    </form>
    </main>
  <div id="success-overlay" class="success-overlay"></div> <!-- ✅ Fond semi-transparent -->

<div id="success-check" class="success_check">
    ✅ Inscription réussie !
    <p>Félicitations ! Votre centre de formation a été enregistré avec succès.</p>
    <p>Nous vous contacterons bientôt pour finaliser votre adhésion et vous fournir toutes les informations nécessaires.</p>
    <p>Si vous avez des questions, notre équipe est à votre disposition.</p>
    <p><strong>Bienvenue dans la Fédération des Centres de Formation !</strong></p>
    <button id="close-success-btn">OK</button> <!-- 🔹 Bouton pour fermer le modal -->
</div>
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
<div class="footer-separator-inscription"></div>
<footer id="footer-inscription" class="footer-inscription">
    <?php include_once '../footer.php'; ?>
    <?php include_once '../script_centres.php'; ?>
   
</footer>

