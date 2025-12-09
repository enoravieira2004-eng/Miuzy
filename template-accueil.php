<?php
/*
 * Template Name: Accueil Miuzy
 */
get_header();
?>

<!-- HEADER RESPONSIVE -->
<header class="miuzy-header">

    <div class="miuzy-header-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/logo_miuzy.svg" class="miuzy-logo-header">
    </div>

    <nav class="miuzy-nav">
        <a href="#">Recherche</a>
        <a href="#">Réservation</a>
        <a href="#">Favoris</a>
        <a href="#">Panier</a>
        <a href="#">Compte</a>
    </nav>

    <!-- Icône hamburger pour mobile -->
    <div class="miuzy-burger">
        <span></span><span></span><span></span>
    </div>

</header>

<!-- MENU MOBILE -->
<div class="miuzy-mobile-menu">
    <a href="#">Recherche</a>
    <a href="#">Réservation</a>
    <a href="#">Favoris</a>
    <a href="#">Panier</a>
    <a href="#">Compte</a>
</div>

<!-- CARROUSEL BOOTSTRAP -->
<div id="miuzyCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    
    <div class="carousel-item active">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/image/confetti-2571539_1280.jpg" class="d-block w-100">
    </div>
    
    <div class="carousel-item">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/image/girl-band-4671537_1280.jpg" class="d-block w-100">
    </div>

    <div class="carousel-item">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/image/Designer.png" class="d-block w-100">
    </div>

  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#miuzyCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#miuzyCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>

</div>

<!-- SECTION TEXTE -->
<section class="miuzy-section">
    <h2>Hello, Bienvenue sur la plateforme <strong>MIUZY</strong> !</h2>

    <div class="miuzy-content">
        <div class="miuzy-left">
            <h3>NOTRE PLATEFORME</h3>
        </div>

        <div class="miuzy-right">
            <p>Miuzy est une plateforme dédiée à la découverte et au soutien des talents musicaux du monde entier...</p>
        </div>
    </div>

    <div class="miuzy-creatrices">
        <div class="creator-box">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/WhatsApp Image 2025-12-06 at 23.07.28.jpeg">
            <div>
                <h4>Insaf Karraz</h4>
                <p>Co-créatrice du projet</p>
            </div>
        </div>

        <div class="creator-box">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/WhatsApp Image 2025-12-07 at 22.00.59.jpeg">
            <div>
                <h4>Enora Vieira</h4>
                <p>Co-créatrice du projet</p>
            </div>
        </div>
    </div>
</section>
<script>
jQuery(document).ready(function($){
    $('.miuzy-burger').on('click', function() {
        $('.miuzy-mobile-menu').toggleClass('active');
    });
});
</script>
<?php get_footer(); ?>
