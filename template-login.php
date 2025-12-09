<?php
/* 
 * Template Name: Connexion Miuzy
 */

if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = sanitize_text_field($_POST['email']);
    $password = $_POST['password'];

    $user = wp_signon([
        'user_login'    => $email,
        'user_password' => $password,
        'remember'      => true
    ]);

    if (is_wp_error($user)) {
        $login_error = "E-mail ou mot de passe incorrect.";
    } else {
        wp_redirect(home_url());
        exit;
    }
}

get_header();
?>

<div class="miuzy-login-wrapper">

    <div class="miuzy-login-box">

    <img class="miuzy-logo"
     src="<?php echo get_template_directory_uri(); ?>/assets/image/logo_miuzy.svg"
     alt="Miuzy">

        <p class="miuzy-intro">
            Bienvenu sur la plateforme de miuzy, là où les<br>
            événements locaux prennent vie !
        </p>

        <?php if ($login_error): ?>
            <div class="miuzy-error"><?php echo $login_error; ?></div>
        <?php endif; ?>

        <form method="post" class="miuzy-form">

            <label>
                E-mail
                <input type="email" name="email" required>
            </label>

            <label>
                Mot de passe
                <input type="password" name="password" required>
            </label>

            <a href="<?php echo wp_lostpassword_url(); ?>" class="miuzy-lost">Mot de passe oublié ?</a>

            <button type="submit" class="miuzy-btn">Se connecter</button>

            <p class="miuzy-register">
                Vous n’avez pas de compte ?
                <a href="<?php echo site_url('/inscription'); ?>">Inscrivez-vous.</a>
            </p>

        </form>

    </div>

</div>

<?php get_footer(); ?>
