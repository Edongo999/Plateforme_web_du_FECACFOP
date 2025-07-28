
<div id="chat-bubble" onclick="toggleChat()" style="
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #007bff;
  color: white;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  z-index: 99999;
">
💬
</div>
<div id="chat-window" style="
  position: fixed;
  bottom: 90px;
  right: 20px;
  width: 320px;
  max-height: 500px;
  background-color: white;
  border: 1px solid #ccc;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  overflow: hidden;
  display: none;
  z-index: 99999;
">
 <div style="
  background-color: #007bff;
  color: white;
  padding: 10px;
  font-weight: bold;
  text-align: center;       /* ✅ Centrage horizontal */
  font-size: 16px;          /* ✅ Taille de police équilibrée */
">
  Assistant FECACFOP
</div>


 <div id="chat-output" style="
  padding: 10px;
  height: 280px;
  overflow-y: auto;
  font-size: 14px;
  background-color: #f9f9f9;
  border-bottom: 1px solid #ccc;
"></div>

<form onsubmit="sendMessage(); return false;" style="
  display: flex;
  padding: 10px;
  background-color: #ffffff;
  align-items: center;
  gap: 6px;
">
  <input type="text" id="chat-message" placeholder="Tape ta question..." style="
    flex: 1;
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 13px;
  ">
  <button type="submit" style="
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 5px 12px;
    font-size: 12px;
    cursor: pointer;
  ">Envoyer</button>
</form>

</div>


<footer id="footer" class="footer ">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer">
							<h2>Restez Connectés</h2>
								
								<p>Suivez-nous sur nos réseaux sociaux pour nos dernières actualités et offres.</p>
								<!-- Social -->
								<ul class="social">
									<li><a href="#"><i class="icofont-facebook"></i></a></li>
									<li><a href="#"><i class="icofont-google-plus"></i></a></li>
									<li><a href="#"><i class="icofont-twitter"></i></a></li>
									<li><a href="#"><i class="icofont-vimeo"></i></a></li>
									<li><a href="#"><i class="icofont-pinterest"></i></a></li>
								</ul>
								<!-- End Social -->
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer f-link">
								<h2>Lien rapide</h2>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Accueil</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>A propos</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Centre de formation</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Inscription</a></li>		
										</ul>
									</div>
								
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-12">
							<div class="single-footer f-link">
								<h2>Lien rapide</h2>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-12">
										<ul>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Emplois disponible</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Actualites</a></li>
											<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i>Bourses d'etudes</a></li>				
										</ul>
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Footer Top -->
			<!-- Copyright -->
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-12">
							<div class="copyright-content">
                                <p>© Copyright 2025 | Tous droits réservés | Plate-forme Web du FECACFOP</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Copyright -->
		</footer>