<?php
/*
 * Template Name: Page d’inscription Miuzy
 */

if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

$register_error = "";
$register_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $prenom = sanitize_text_field($_POST["prenom"]);
    $nom = sanitize_text_field($_POST["nom"]);
    $date = sanitize_text_field($_POST["naissance"]);
    $genre = sanitize_text_field($_POST["genre"]);
    $email = sanitize_email($_POST["email"]);
    $password = $_POST["password"];

    if (email_exists($email)) {
        $register_error = "Cet e-mail est déjà utilisé.";
    } else {
        $user_id = wp_create_user($email, $password, $email);

        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, "first_name", $prenom);
            update_user_meta($user_id, "last_name", $nom);
            update_user_meta($user_id, "naissance", $date);
            update_user_meta($user_id, "genre", $genre);

            $register_success = true;
        } else {
            $register_error = "Une erreur est survenue, réessayez.";
        }
    }
}

get_header();
?>

<div class="miuzy-login-wrapper">

<div class="miuzy-login-box">

    <img class="miuzy-logo"
    src="<?php echo get_template_directory_uri(); ?>/assets/image/logo_miuzy.svg"
    alt="Miuzy">

    <?php if ($register_success): ?>
        <p class="miuzy-success">Compte créé ! Vous pouvez maintenant vous connecter.</p>
        <a href="<?php echo site_url('/connexion'); ?>" class="miuzy-btn" style="margin-top:20px;">Se connecter</a>

    <?php else: ?>

        <form method="POST" id="miuzy-register-form" class="miuzy-form">

            <?php if ($register_error): ?>
                <div class="miuzy-error"><?= $register_error; ?></div>
            <?php endif; ?>

            <label>Prénom
                <input type="text" name="prenom" required>
            </label>

            <label>Nom
                <input type="text" name="nom" required>
            </label>

            <label>Date de naissance
                <input type="date" name="naissance" required>
            </label>

            <label>Genre
                <select name="genre" required>
                    <option value="">Choisir</option>
                    <option value="femme">Femme</option>
                    <option value="homme">Homme</option>
                    <option value="autre">Autre</option>
                </select>
            </label>

            <label>E-mail
                <input type="email" name="email" required>
            </label>

            <label>Mot de passe
                <input type="password" name="password" required>
            </label>

            <button type="submit" class="miuzy-btn">S’inscrire</button>

            <p class="miuzy-register">
                Vous avez un compte ?
                <a href="<?php echo site_url('/connexion'); ?>">Connectez-vous.</a>
            </p>
        </form>

    <?php endif; ?>

</div>
</div>
<script>
jQuery(document).ready(function($){
    $('#miuzy-register-form').on('submit', function(){
        let ok = true;
        $(this).find('input,select').each(function(){
            if(!$(this).val().trim()){
                $(this).css('border-color','red');
                ok = false;
            } else {
                $(this).css('border-color','#ccc');
            }
        });
        return ok;
    });
});
</script>

<?php get_footer(); ?>