<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( !is_page( array( 'inscription', 'login' ) ) ) : ?>
<header class="miuzy-header">
    <div class="miuzy-container">

        <!-- LOGO -->
        <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_miuzy.svg" alt="Miuzy">
        </div>

        <!-- MENU DESKTOP -->
        <nav class="menu-desktop">
            <a href="#">Recherche</a>

            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo home_url('/reservation'); ?>">Réservation</a>
            <?php else : ?>
                <a href="<?php echo home_url('/noacces'); ?>">Réservation</a>
            <?php endif; ?>

            <a href="#">Favoris</a>
            <a href="#">Panier</a>
            <a href="<?php echo home_url('/compte'); ?>">Compte</a>
        </nav>

        <!-- BURGER BUTTON -->
        <div class="burger" id="burgerBtn">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </div>

    <!-- MENU MOBILE -->
    <nav class="menu-mobile" id="mobileMenu">
        <a href="#">Recherche</a>

        <?php if ( is_user_logged_in() ) : ?>
            <a href="<?php echo home_url('/reservation'); ?>">Réservation</a>
        <?php else : ?>
            <a href="<?php echo home_url('/noacces'); ?>">Réservation</a>
        <?php endif; ?>

        <a href="#">Favoris</a>
        <a href="#">Panier</a>
        <a href="<?php echo home_url('/compte'); ?>">Compte</a>
    </nav>

</header>
<?php endif; ?>