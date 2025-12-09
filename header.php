<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/header.css">

</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

<header class="miuzy-header">
    <div class="miuzy-container">

        <!-- Logo SVG à gauche -->
        <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_miuzy.svg" alt="Miuzy">
        </div>

        <!-- Menu à droite -->
        <nav class="menu">
            <a href="#" class="menu-btn">Recherche</a>
            <a href="#" class="menu-btn">Reservation</a>
            <a href="#" class="menu-btn">Favoris</a>
            <a href="#" class="menu-btn">Panier</a>
            <a href="#" class="menu-btn">Compte</a>
        </nav>

    </div>
</header>

    <main id="main-content">