<?php
/*
 * Template Name: Accueil Miuzy
 */
?>

<?php get_header(); ?>

<!-- ==================== -->
<!-- CARROUSEL BOOTSTRAP  -->
<!-- ==================== -->

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">

    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/confetti-2571539_1280.jpg" class="d-block w-100" alt="Slide 1">
        </div>

        <div class="carousel-item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/girl-band-4671537_1280.jpg" class="d-block w-100" alt="Slide 2">
        </div>

        <div class="carousel-item">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/artist-3480274_1280.jpg" class="d-block w-100" alt="Slide 3">
        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>



<!-- ==================== -->
<!-- SECTION TEXTE + CREATRICES -->
<!-- ==================== -->

<section class="miuzy-section">

    <h2 class="miuzy-title">
        Hello Emilie, Bienvenue sur la plateforme <strong>MIUZY</strong> !
    </h2>

    <div class="miuzy-grid">

        <!-- COLONNE GAUCHE -->
        <div class="miuzy-left">
            <h3 class="big-title">NOTRE<br>PLATEFORME</h3>

            <h3 class="big-title" style="margin-top:60px;">
                LES<br>CREATRICES<br>DU PROJET
            </h3>
        </div>

        <!-- COLONNE DROITE -->
        <div class="miuzy-right">

<!-- TEXTE PLATEFORME : VERSION MOBILE & DESKTOP -->
<div class="miuzy-plateforme-text">
    <p>
        Découvrez MIUZY, la plateforme qui connecte artistes, lieux et passionnés de musique.
        Réservez facilement de petits concerts locaux partout dans le monde, ou créez vos propres évènements
        dans des bars, cafés et scènes intimistes.
        Connectez-vous et rejoignez une communauté où chaque performance compte.
    </p>
</div>

<!-- TITRE MOBILE -->
<h3 class="mobile-creatrices-title">LES CREATRICES DU PROJET</h3>

<!-- CREATRICE 1 -->
<div class="creator-box">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/WhatsApp Image 2025-12-04 at 13.41.56.jpeg" alt="">
    <div>
        <h4>Insaf Karraz</h4>
        <p>Insaf est une des créatrices du Projet Miuzy</p>
    </div>
</div>

<!-- CREATRICE 2 -->
<div class="creator-box">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/image/WhatsApp Image 2025-12-04 at 13.44.34.jpeg" alt="">
    <div>
        <h4>Enora Vieira</h4>
        <p>Enora est une des créatrices du Projet Miuzy</p>
    </div>
</div>

</div>


    </div>

</section>

<?php get_footer(); ?>
