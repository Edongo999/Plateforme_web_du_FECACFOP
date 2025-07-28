<style>
.newsletter-container {
  display: flex;
  justify-content: center;
  gap: 24px;
  max-width: 1200px;
  margin: auto;
  align-items: stretch;
  flex-wrap: wrap;
}

.newsletter-box {
  flex: 1;
  padding: 30px 18px;
  text-align: center;
  border-radius: 10px;
  box-shadow: 0px 6px 18px rgba(255, 255, 255, 0.15);
  color: white;
  min-height: 280px;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.subscribe-section-alt {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.subscribe-text-alt {
  font-size: 17px;
  font-weight: 600;
  flex-grow: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 8px;
  line-height: 1.4;
  min-height: 100px;
  text-align: center;
}

.button-group-alt {
  margin-top: auto;
  display: flex;
  justify-content: center;
  gap: 12px;
}

.subscribe-button-alt {
  padding: 12px 22px;
  font-size: 16px;
  font-weight: 600;
  color: white;
  background: linear-gradient(90deg, #ff9800, #ff7700);
  border-radius: 6px;
  text-decoration: none;
  transition: all 0.3s ease;
  min-width: 180px;
  text-align: center;
}

.subscribe-button-alt:hover {
  background: linear-gradient(90deg, #ff7700, #ff5500);
  box-shadow: 0px 6px 16px rgba(255, 120, 0, 0.4);
  transform: scale(1.06);
}

@media (max-width: 900px) {
  .newsletter-container {
    flex-direction: column;
    align-items: center;
  }

  .newsletter-box {
    width: 92%;
    margin-bottom: 20px;
  }
}

.section-divider-container {
  padding: 40px 0;
  background-color: rgba(255, 0, 0, 0.05);
  display: flex;
  justify-content: center;
  align-items: center;
}

.section-divider {
  text-align: center;
  font-size: 20px;
  font-weight: 700;
  color: red;
  font-family: 'Segoe UI', sans-serif;
  letter-spacing: 1px;
}

.section-divider::before,
.section-divider::after {
  content: "";
  display: inline-block;
  width: 50px;
  height: 2px;
  background: red;
  margin: 0 12px;
  vertical-align: middle;
}

</style>
<div class="section-divider-container">
  <div class="section-divider">
    <span><i class="fa fa-star"></i> Ensemble, construisons l’avenir <i class="fa fa-star"></i></span>
  </div>
</div>
<div class="newsletter-container">
  <!-- Bloc 1 - Apprenants -->
  <section class="newsletter-box">
    <div class="subscribe-section-alt">
      <p class="subscribe-text-alt">
        Vous souhaitez vous former ? Accédez à des formations professionnelles innovantes pour bâtir un avenir solide.
      </p>
      <div class="button-group-alt">
        <a href="/Plateforme_web_du_FECACFOP/view/formulaire/index1.php" class="subscribe-button-alt">Je veux me former</a>
      </div>
    </div>
  </section>

  <!-- Bloc 2 - Centres de formation -->
<section class="newsletter-box">
  <div class="subscribe-section-alt">
    <p class="subscribe-text-alt">
      Vous êtes un centre de formation agréé ou en voie de l’être ? Rejoignez notre fédération pour bénéficier d’un accompagnement professionnel.
   </p>
      <div class="button-group-alt">
      <a href="/Plateforme_web_du_FECACFOP/view/formulaire/inscription_centres.php" class="subscribe-button-alt">Rejoindre la fédération</a>
    </div>
  </div>
</section>

<section class="newsletter-box">
  <div class="subscribe-section-alt">
    <p class="subscribe-text-alt">
    Vous représentez une entreprise, une association ou une structure engagée ? Collaborez avec nous pour accueillir des stagiaires, soutenir la formation ou co-créer des parcours adaptés à vos besoins.
    </p>
    <div class="button-group-alt">
      <a href="/Plateforme_web_du_FECACFOP/view/formulaire/inscription_entreprises.php" class="subscribe-button-alt">Proposer une collaboration</a>
    </div>
  </div>
</section>



  <!-- Bloc 3 - Entreprises -->
  
</div>
