<?php
/*
Template Name: User Profil
*/

if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

$current_user = wp_get_current_user();
get_header();
?>

<div class="user-profile-page">

    <!-- ================= PARAMÈTRES GÉNÉRAUX ================= -->
    <section class="profile-block">
        <h2 class="profile-title">PARAMÈTRES GÉNÉRAUX</h2>

        <div class="profile-card profile-header">
            <div class="profile-avatar">
                <?php
                $custom_avatar = get_user_meta($current_user->ID, 'custom_avatar', true);
                echo $custom_avatar
                    ? '<img src="'.esc_url($custom_avatar).'">'
                    : get_avatar($current_user->ID, 90);
                ?>

                <input type="file" id="avatar-upload" class="hidden" onchange="uploadAvatar(this)">
                <button class="avatar-btn" onclick="document.getElementById('avatar-upload').click();">
                    <i class="fa-solid fa-camera"></i>
                </button>
            </div>

            <div class="profile-info">

    <!-- DISPLAY -->
    <div class="profile-display">
        <strong class="display-name"><?php echo esc_html($current_user->display_name); ?></strong>
        <span class="display-email"><?php echo esc_html($current_user->user_email); ?></span>
    </div>

    <!-- EDIT -->
    <div class="profile-edit hidden">
        <input type="text" class="edit-name" value="<?php echo esc_attr($current_user->display_name); ?>">
        <input type="email" class="edit-email" value="<?php echo esc_attr($current_user->user_email); ?>">
    </div>

    <div class="profile-actions">
        <button class="btn-outline btn-edit btn-main-miuzy" onclick="toggleEdit()">Modifier</button>
        <button class="btn-outline btn-save btn-main-miuzy hidden" onclick="saveProfile()">Enregistrer</button>
    </div>

    </div>
</section>

    <!-- ================= SÉCURITÉ ================= -->
    <section class="profile-block">
        <h2 class="profile-title">SÉCURITÉ</h2>

        <div class="profile-card grid-2">
            <div class="form-group">
                <label>Mot de passe actuel</label>
                <input type="password" id="current_password">
            </div>

            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" id="new_password">
            </div>

            <div class="form-group">
                <label>Vérification du mot de passe</label>
                <input type="password" id="confirm_password">
            </div>

            <div class="form-group align-end">
                <button class="btn-outline btn-main-miuzy full" onclick="validatePassword()">Valider</button>
            </div>
        </div>
    </section>

    <!-- ================= LANGUES & DEVISES ================= -->
   <section class="profile-block">
    <h2 class="profile-title">LANGUES & DEVISES</h2>

    <div class="profile-card">
        <div class="grid-2">

            <div class="form-group">
                <label for="language">Langue</label>
                <select id="language">
                <option value="">Choisir</option>
                <option value="ar">العربية (Arabic)</option>
                <option value="bn">বাংলা (Bengali)</option>
                <option value="zh">中文 (Chinese)</option>
                <option value="en">English</option>
                <option value="fr">Français</option>
                <option value="hi">हिन्दी (Hindi)</option>
                <option value="pt">Português</option>
                <option value="ru">Русский</option>
                <option value="es">Español</option>
                <option value="ur">اردو (Urdu)</option>
            </select>
        </div>

         <div class="form-group">
                <label for="currency">Devise</label>
                <select id="currency">
                <option value="">Choisir</option>
                <option value="AED">Dirham (د.إ)</option>
                <option value="BRL">Réal brésilien (R$)</option>
                <option value="CHF">Franc suisse (CHF)</option>
                <option value="CNY">Yuan (¥)</option>
                <option value="EUR">Euro (€)</option>
                <option value="GBP">Livre sterling (£)</option>
                <option value="INR">Roupie indienne (₹)</option>
                <option value="JPY">Yen (¥)</option>
                <option value="RUB">Rouble (₽)</option>
                <option value="USD">Dollar ($)</option>
            </select>
        </div>
    </div>
</section>

    <!-- ================= SERVICE CLIENT ================= -->
    <section class="profile-block">
        <h2 class="profile-title">SERVICE CLIENT</h2>

        <div class="profile-card">
            <p>Nous contacter ? écrivez nous via le service client…</p>
            <textarea id="message" rows="5" placeholder="Votre message…"></textarea>
            <button class="btn-outline btn-main-miuzy" onclick="sendMessage()">Envoyer</button>
        </div>
    </section>

    <!-- ================= ÉVÉNEMENT ================= -->
    <section class="profile-block">

    <h2 class="profile-title">AJOUT D’UN ÉVÈNEMENT</h2>

    <div class="profile-card">
        <div class="">
            <p>
                Vous souhaitez organiser un évènement ?
                Introduisez les données nécessaires à la prochaine page
            </p>
            <br/>
            <a href="<?php echo home_url('/mon-evenement'); ?>" class="btn-outline btn-main-miuzy">
                Mon évènement
            </a>
        </div>
    </div>

</section>


    <!-- ================= LOGOUT ================= -->
    <section class="profile-block">
        <h2 class="profile-title">QUITTER VOTRE COMPTE</h2>

        <div class="profile-card">
            <p>Merci de votre visite, à bientôt chez Miuzy !</p>
            <br/>
            <a class="btn-outline btn-secondary-miuzy" href="<?php echo wp_logout_url(home_url('/login')); ?>">
                Se déconnecter
            </a>
        </div>
    </section>

</div>

<?php get_footer(); ?>
