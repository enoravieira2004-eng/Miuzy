<?php
/* Template Name: Connexion */
get_header();
?>
<div class="container">

    <div class="login-box">

        <div class="logo">MIUZY</div>

        <p class="tagline">
            Bienvenue sur la plateforme de miuzy,<br>
            là où les évènements locaux prennent vie !
        </p>

        <form method="POST">

            <div class="form-group">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required>
            </div>

            <a href="#" class="forgot-link">Mot de passe oublié ?</a>

            <button type="submit" class="btn-submit" name="login_submit">
                Se connecter
            </button>

            <?php wp_nonce_field('login_action', 'login_nonce'); ?>

        </form>

        <p class="signup-text">
            Vous n'avez pas de compte ?
            <a href="/signup">Inscrivez-vous</a>.
        </p>

    </div>

</div>

<?php get_footer(); ?>
