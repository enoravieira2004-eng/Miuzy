<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="site-wrapper">

<?php wp_body_open(); ?>
<?php if ( ! is_page_template('template-login.php') && ! is_page_template('template-register.php') ) : ?>

<header class="miuzy-header">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img
                    src="<?php echo get_template_directory_uri(); ?>/assets/image/logo_miuzy.svg"
                    alt="Logo Miuzy"
                    class="logo-img"
                >
            </a>
        </div>

        <nav class="d-none d-md-flex gap-4">
            <a href="<?php echo site_url('/recherche'); ?>">Recherche</a>

            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo site_url('/reservation'); ?>">Réservation</a>
                <a href="<?php echo site_url('/favoris'); ?>">Favoris</a>
                <a href="<?php echo site_url('/panier'); ?>">Panier</a>
                <a href="<?php echo site_url('/user-profil'); ?>" class="menu-compte">Compte</a>
            <?php else : ?>
                <a href="<?php echo site_url('/noacces'); ?>">Réservation</a>
                <a href="<?php echo site_url('/noacces'); ?>">Favoris</a>
                <a href="<?php echo site_url('/noacces'); ?>">Panier</a>
                <a href="<?php echo site_url('/noacces'); ?>" class="menu-compte">Compte</a>
            <?php endif; ?>

        </nav>

        <button class="btn btn-light d-md-none" data-bs-toggle="collapse" data-bs-target="#menuMobile">
            ☰
        </button>
    </div>

    <div class="collapse d-md-none" id="menuMobile">

    <nav class="mobile-nav">
        <a href="<?php echo site_url('/recherche'); ?>">Recherche</a>

        <?php if ( is_user_logged_in() ) : ?>
            <a href="<?php echo site_url('/reservation'); ?>">Réservation</a>
            <a href="<?php echo site_url('/favoris'); ?>">Favoris</a>
            <a href="<?php echo site_url('/panier'); ?>">Panier</a>
            <a href="<?php echo site_url('/user-profil'); ?>" class="menu-compte">Compte</a>
        <?php else : ?>
            <a href="<?php echo site_url('/noacces'); ?>">Réservation</a>
            <a href="<?php echo site_url('/noacces'); ?>">Favoris</a>
            <a href="<?php echo site_url('/noacces'); ?>">Panier</a>
            <a href="<?php echo site_url('/noacces'); ?>" class="menu-compte">Compte</a>
        <?php endif; ?>

    </nav>
</div>

</header>

<?php endif; ?>