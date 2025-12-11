<?php
/* 
 * Template Name: No Access
 */

get_header();

// Si l'utilisateur est connecté → on l'envoie vers son compte
if ( is_user_logged_in() ) {
    wp_redirect( home_url('/compte/') );
    exit;
}
?>

<div class="invited-access-container d-flex flex-column justify-content-center align-items-center text-center">
    <h2 class="mb-4">Ohoh, Il me semble que vous ne soyez pas connecté.</h2>

    <a href="<?php echo home_url('/login/'); ?>" class="btn btn-outline-primary px-4 py-2">
        Se connecter
    </a>
</div>

<style>
.invited-access-container {
    min-height: 70vh;
    background: #ffffff;
    color: #333;
    font-size: 1.2rem;
}

/* STYLE DU BOUTON */
.btn-outline-primary {
    border-radius: 25px;
    border-width: 2px;
    color: #3d18d3;
    border-color: #3d18d3;
    transition: all 0.25s ease;
}

/* HOVER */
.btn-outline-primary:hover {
    background-color: #3d18d3;
    color: #fff !important;
    border-color: #3d18d3;
}
</style>

<?php get_footer(); ?>
