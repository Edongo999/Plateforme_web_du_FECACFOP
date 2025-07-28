<!DOCTYPE html>
<html class="no-js" lang="fr">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Site keywords here">
    <meta name="description" content="">
    <meta name='copyright' content=''>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Plate-forme Web du FECACFOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Favicon -->
    <link rel="icon" href="/Plateforme_web_du_FECACFOP/public/assets/img/logo1.jpg">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/bootstrap.min.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/nice-select.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/font-awesome.min.css">
    <!-- icofont CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/icofont.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/slicknav.min.css">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/owl-carousel.css">
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/datepicker.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/animate.min.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/magnific-popup.css">


  
    <!-- Medipro CSS -->
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/normalize.css">
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/style.css">
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/style1.css">
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/centres.css">
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css_actualites/images.css">  
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css_actualites/videos.css">  
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css_actualites/lightbox/css/lightbox.css">
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css_actualites/lightbox/css/lightbox.min.css">  
      
    <link rel="stylesheet" href="/Plateforme_web_du_FECACFOP/public/assets/css/responsive.css">

    <!-- Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">

</head>
<body>
<!-- Preloader -->
                <div class="preloader">
            <div class="loader">
                <div class="loader-outter"></div>
                <div class="loader-inner"></div>

                <div class="indicator"> 
                    <svg width="16px" height="12px">
                        <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                        <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    </svg>
                </div>
            </div>
        </div>
<!-- End Preloader -->


<ul class="pro-features">
    <a class="get-pro" href="#">Bourses de formations</a>
    <li class="big-title">Financement pour vos études et formations</li>
    <li class="title">Types de bourses disponibles</li>
    <li>Bourses académiques – Financements pour les étudiants</li>
    <li>Bourses professionnelles – Aides pour la formation continue</li>
    <li>Bourses entrepreneuriales – Soutien pour les porteurs de projets</li>
    
    <div class="button">
        <a href="/Plateforme_web_du_FECACFOP/view/Bourses/bourses.php" class="btn">Postuler maintenant</a>
    </div>
</ul>



<header class="header">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-5 col-12">
                    <ul class="top-link">
                        <li><a href="#">Douala, Bonapriso rue Koloko</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-7 col-12">
                    <ul class="top-contact">
                        <li><i class="fa fa-phone"></i>+237 697 47 55 73</li>
                        <li><i class="fa fa-envelope"></i><a href="mailto:support@yourmail.com">support@yourmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="header-inner">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="logo">
                            <a href=""><img src="/Plateforme_web_du_FECACFOP/public/assets/img/logo.jpg" alt="Logo"></a>
                        </div>
                        <div class="mobile-nav"></div>
                    </div>
                    <div class="col-lg-7 col-md-9 col-12">
                        <div class="main-menu">
                            <nav class="navigation">
                                <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
                                <ul class="nav menu">
                                    <li class="<?= ($current_page == 'index.php') ? 'active' : '' ?>"><a href="/Plateforme_web_du_FECACFOP/public/index.php">Accueil</a></li>
                                    <li class="<?= ($current_page == 'about.php') ? 'active' : '' ?>"><a href="/Plateforme_web_du_FECACFOP/public/about.php">À propos</a></li>
                                    
                                    <li class="<?= ($current_page == 'centre.php') ? 'active' : '' ?>"><a href="/Plateforme_web_du_FECACFOP/view/les centres de formation/centre.php">Centres De Formation</a></li>
                                    <li class="<?= ($current_page == 'index1.php' || $current_page == 'inscription_centres.php') ? 'active' : '' ?>">
                                   <li class="<?= ($current_page == 'index1.php' || $current_page == 'inscription_centres.php') ? 'active' : '' ?>">
                                    <a href="#">Inscription<i class="icofont-rounded-down"></i></a>
                                    <ul class="dropdown">
                                        <li><a href="/Plateforme_web_du_FECACFOP/view/formulaire/index1.php">Vous etes un apprenants ?</a></li>
                                         <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalSelection">Vous êtes un centre et autres ?</a></li>
          
                                        
                                           
                                    </ul>
   
                                </li>
                                    
                                   
                                    <li class="<?= ($current_page == 'afficher-images.php' || $current_page == 'afficher-videos.php') ? 'active' : '' ?>">
                                        <a href="#">Actualité<i class="icofont-rounded-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="/Plateforme_web_du_FECACFOP/view/Actualites/afficher-images.php">Nos Articles</a></li>
                                            <li><a href="/Plateforme_web_du_FECACFOP/view/Actualites/afficher-videos.php">Nos Images</a></li>
                                        </ul>
                                    </li>
                                    <li class="<?= ($current_page == 'afficher_emplois.php') ? 'active' : '' ?>"><a href="/Plateforme_web_du_FECACFOP/view/Actualites/afficher_emplois.php">Emplois Et Stage</a></li>
                                   

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Modal -->
<!-- Modal -->
<!-- Modal personnalisé -->
<div class="modal fade modal-selection" id="modalSelection" tabindex="-1" aria-labelledby="modalSelectionLabel" aria-hidden="true">
    <div class="modal-dialog modal-selection-dialog">
        <div class="modal-content modal-selection-content">
            <div class="modal-header modal-selection-header">
                <h5 class="modal-title modal-selection-title" id="modalSelectionLabel">Sélectionnez votre option</h5>
                <br><br>
                <button type="button" class="btn-close modal-selection-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body modal-selection-body"><br><br><br><br>
                
                <div class="modal-button-container">
                    <a href="/Plateforme_web_du_FECACFOP/view/formulaire/inscription_centres.php" class="btn btn-primary modal-btn">Centres de formations</a>
                    <a href="/Plateforme_web_du_FECACFOP/view/formulaire/inscription_entreprises.php" class="btn btn-secondary modal-btn">Devenir partenaire</a>
                </div>
            </div>
        </div>
    </div>
</div>



<a href="https://api.whatsapp.com/send?phone=237697475573" target="_blank" class="whatsapp-link">
    <img src="/Plateforme_web_du_FECACFOP/public/assets/img/whatsapp.png" alt="WhatsApp">
</a>