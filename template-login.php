<?php

/**
 * Template Name: Login Template
 */
get_header();
?>

<div class="login-container">
    <div class="login-box">
        <h1 class="logo">MIUZY</h1>
        <p class="tagline">Bienvenu sur la plateforme de miuzy, la où les<br>événements locaux prennent vie !</p>

        <?php
        if (isset($_GET['login']) && $_GET['login'] == 'failed') {
            echo '<div class="error-message">Invalid username or password.</div>';
        }
        if (isset($_GET['login']) && $_GET['login'] == 'empty') {
            echo '<div class="error-message">Please fill in all fields.</div>';
        }
        if (is_user_logged_in()) {
            echo '<div class="success-message">You are already logged in. <a href="' . wp_logout_url(home_url()) . '">Logout</a></div>';
        } else {
        ?>

            <form id="loginForm" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" class="login-form">
                <?php wp_nonce_field('login_action', 'login_nonce'); ?>

                    <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                    <a href="forgot-password.php" class="forgot-link">Mot de passe oublié ?</a>
                </div>
                
                <button type="submit" name="login_submit" class="btn-submit">Se connecter</button>
            </form>

            <p class="signup-text">
                Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous.</a>
            </p>
        <?php } ?>
    </div>
</div>

<?php
get_footer();
?>