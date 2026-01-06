<?php
/*
Template Name: Login
*/
get_header('login');

// Gestion du formulaire
$error = '';

if ( isset($_POST['login_submit']) ) {

    if ( ! isset($_POST['login_nonce']) || ! wp_verify_nonce($_POST['login_nonce'], 'login_action') ) {
        $error = 'Erreur de sécurité.';
    } else {

        $creds = array(
            'user_login'    => sanitize_text_field($_POST['email']),
            'user_password' => $_POST['password'],
            'remember'      => true
        );

        $user = wp_signon($creds, false);

        if ( is_wp_error($user) ) {
            $error = 'Email ou mot de passe incorrect.';
        } else {

            // 🔐 IMPORTANT
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true);

            wp_safe_redirect( home_url('/') );
            exit;
        }
    }
}
?>

<div class="login-page">
    <div class="login-card">

        <div class="logo">
            <img 
                src="<?php echo get_template_directory_uri(); ?>/assets/image/logo_miuzy.svg"
                alt="Miuzy"
            >
        </div>

        <p class="subtitle">
            Bienvenu sur la plateforme de Miuzy, là où les événements locaux prennent vie !
        </p>

        <?php if ($error): ?>
            <div class="login-error"><?php echo esc_html($error); ?></div>
        <?php endif; ?>

        <form method="post" class="login-form">

            <?php wp_nonce_field('login_action', 'login_nonce'); ?>

            <label for="email">E-mail</label>
            <input type="text" name="email" id="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>

            <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot">
                Mot de passe oublié ?
            </a>

            <button type="submit" name="login_submit" class="btn-login btn-main-miuzy">
                Se connecter
            </button>

        </form>

        <p class="register-link">
            Vous n’avez pas de compte ?
            <a href="<?php echo site_url('/register'); ?>">Inscrivez-vous</a>
        </p>

    </div>
</div>

<?php get_footer('login'); ?>
