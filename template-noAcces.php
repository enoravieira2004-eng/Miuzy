<?php
/*
Template Name: No Access
*/

// Redirection si l'utilisateur est déjà connecté
if ( is_user_logged_in() ) {
    wp_redirect( site_url('/user-profil') );
    exit;
}

get_header();
?>

<main class="noacces-container">
    <div class="noacces-content">
        <h1 class="noacces-title">
            Ohoh, il me semble que vous ne soyez pas connecté.
        </h1>

        <a href="<?php echo esc_url( site_url('/login') ); ?>" class="btn-main-miuzy">
            Se connecter
        </a>
    </div>
</main>

<?php get_footer(); ?>
