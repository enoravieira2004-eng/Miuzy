<?php
/*
Template Name: Register
*/
get_header('login'); // même header que login

// Sécurité : déjà connecté
// if ( is_user_logged_in() ) {
//     wp_redirect( home_url('/') );
//     exit;
// }

$error = '';

if ( isset($_POST['register_submit']) ) {

    if (
        ! isset($_POST['register_nonce']) ||
        ! wp_verify_nonce($_POST['register_nonce'], 'register_action')
    ) {
        $error = 'Erreur de sécurité.';
    } else {

        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name  = sanitize_text_field($_POST['last_name'] ?? '');
        $birthdate  = sanitize_text_field($_POST['birthdate'] ?? '');
        $gender     = sanitize_text_field($_POST['gender'] ?? '');
        $email      = sanitize_email($_POST['email'] ?? '');
        $password   = $_POST['password'] ?? '';

        if ( ! $first_name || ! $last_name || ! $email || ! $password ) {
            $error = 'Veuillez remplir tous les champs obligatoires.';
        } elseif ( email_exists($email) ) {
            $error = 'Cet email est déjà utilisé.';
        } else {

            $user_id = wp_create_user($email, $password, $email);

            if ( is_wp_error($user_id) ) {
                $error = 'Erreur lors de la création du compte.';
            } else {

                wp_update_user([
                    'ID'         => $user_id,
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                ]);

                update_user_meta($user_id, 'birthdate', $birthdate);
                update_user_meta($user_id, 'gender', $gender);

                wp_safe_redirect( home_url('/login') );
                exit;
            }
        }
    }
}
?>

<div class="login-page">
    <div class="login-card">

        <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/image/logo_miuzy.svg" alt="Miuzy">
        </div>

        <?php if ($error): ?>
            <div class="login-error"><?php echo esc_html($error); ?></div>
        <?php endif; ?>

        <form method="post" class="login-form">

            <?php wp_nonce_field('register_action', 'register_nonce'); ?>

            <label>Prénom</label>
            <input type="text" name="first_name" required>

            <label>Nom</label>
            <input type="text" name="last_name" required>

            <label>Date de naissance</label>
            <input type="date" name="birthdate">

            <label>Genre</label>
            <select name="gender" class="register-select">
                <option value="">Choisir</option>
                <option value="femme">Femme</option>
                <option value="homme">Homme</option>
                <option value="autre">Autre</option>
            </select>

            <label>E-mail</label>
            <input type="email" name="email" required>

            <label>Mot de passe</label>
            <input type="password" name="password" required>

            <button type="submit" name="register_submit" class="btn-login btn-main-miuzy">
                S’inscrire
            </button>

        </form>

        <p class="register-link">
            Vous avez déjà un compte ?
            <a href="<?php echo site_url('/login'); ?>">Connectez-vous</a>
        </p>

    </div>
</div>

<?php get_footer(); ?>
