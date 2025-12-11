<?php
/* Template name: User Profil */

// Redirect user if not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

$current_user = wp_get_current_user();
get_header();
?>

<div class="user-profile-container">
    <div class="profile-content">
        
        <!-- PARAMETRES GENERALES -->
        <section class="profile-section">
            <h2 class="section-title">PARAMETRES GENERALES</h2>
            <div class="section-content">
                <div class="profile-header">

                    <!-- AVATAR -->
                    <div class="profile-image">
                        <?php
                        $custom_avatar = get_user_meta($current_user->ID, 'custom_avatar', true);

                        if ($custom_avatar) {
                            echo '<img src="' . esc_url($custom_avatar) . '" class="avatar-custom" width="80" height="80">';
                        } else {
                            echo get_avatar($current_user->ID, 80);
                        }
                        ?>

                        <!-- Hidden by default -->
                        <input type="file" id="avatar-upload" accept="image/*" class="hidden" onchange="uploadAvatar(this)">

                        <button type="button" class="avatar-edit-icon hidden"
                                onclick="document.getElementById('avatar-upload').click();">
                                <i class="fa-solid fa-camera"></i>
                        </button>
                    </div>

                    <!-- NAME + EMAIL -->
                    <div class="profile-info">
                        <div class="editable-field">
                            <span class="display-name"><?php echo esc_html($current_user->display_name); ?></span>
                            <input type="text" class="edit-name hidden" value="<?php echo esc_attr($current_user->display_name); ?>">
                        </div>

                        <div class="editable-field">
                            <span class="display-email"><?php echo esc_html($current_user->user_email); ?></span>
                            <input type="email" class="edit-email hidden" value="<?php echo esc_attr($current_user->user_email); ?>">
                        </div>

                        <button class="btn-edit" onclick="toggleEdit()">Modifier</button>
                        <button class="btn-save hidden" onclick="saveProfile()">Enregistrer</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECURITE -->
        <section class="profile-section">
            <h2 class="section-title">SECURITE</h2>
            <div class="section-content">
                <form id="password-form" class="password-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Mot de passe actuel</label>
                            <input type="password" id="current_password" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="password" id="new_password" class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Vérification du mot de passe</label>
                            <input type="password" id="confirm_password" class="form-input">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn-validate" onclick="validatePassword()">Valider</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- LANGUES & DEVISES -->
        <section class="profile-section">
            <h2 class="section-title">LANGUES & DEVISES</h2>
            <div class="section-content">
                <div class="form-row">
                    <div class="form-group">
                        <label>Langue</label>
                        <select class="form-select" id="language">
                            <option value="">choisir</option>
                            <option value="fr">Français</option>
                            <option value="en">English</option>
                            <option value="es">Español</option>
                            <option value="de">Deutsch</option>
                            <option value="it">Italiano</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Devise</label>
                        <select class="form-select" id="currency">
                            <option value="">choisir</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="USD">USD ($)</option>
                            <option value="GBP">GBP (£)</option>
                            <option value="CHF">CHF (Fr)</option>
                            <option value="JPY">JPY (¥)</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <!-- SERVICE CLIENT -->
        <section class="profile-section">
            <h2 class="section-title">SERVICE CLIENT</h2>
            <div class="section-content">
                <p class="section-description">Nous contacter ? écrivez nous via le service client...</p>
                <form id="contact-form" class="contact-form">
                    <textarea class="form-textarea" id="message" rows="6" placeholder="Votre message..."></textarea><br/>
                    <button type="button" class="btn-send" onclick="sendMessage()">Envoyer</button>
                </form>
            </div>
        </section>

        <!-- AJOUT EVENEMENT -->
        <section class="profile-section">
            <h2 class="section-title">AJOUT D'UN EVENEMENT</h2>
            <div class="section-content">
                <p class="section-description">Vous souhaitez organiser un événement ?</p>
                <a href="<?php echo home_url('/mon-evenement'); ?>" class="btn-event">Mon évènement</a>
            </div>
        </section>

        <!-- LOGOUT -->
        <section class="profile-section">
            <h2 class="section-title">QUITTER VOTRE COMPTE</h2>
            <div class="section-content">
                <p class="section-description">Merci de votre visite, à bientôt chez Miuzy !</p>
                <a href="<?php echo wp_logout_url(home_url('/login')); ?>" class="btn-logout">Se déconnecter</a>
            </div>
        </section>

    </div>
</div>

<?php get_footer(); ?>

<!-- ======================== JAVASCRIPT ============================= -->

<script>
// ---------------- AVATAR UPLOAD ----------------
function uploadAvatar(input) {
    if (input.files.length === 0) return;

    let formData = new FormData();
    formData.append('avatar', input.files[0]);
    formData.append('action', 'miuzy_upload_avatar');
    formData.append('nonce', '<?php echo wp_create_nonce("miuzy_avatar_nonce"); ?>');

    fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            document.querySelector(".profile-image img").src = response.data.url;
            alert("Votre avatar a été mis à jour !");
        } else {
            alert("Erreur: " + response.data);
        }
    });
}

// ---------------- EDIT MODE TOGGLE ----------------
function toggleEdit() {
    document.querySelector(".btn-edit").classList.add("hidden");
    document.querySelector(".btn-save").classList.remove("hidden");

    document.querySelector(".edit-name").classList.remove("hidden");
    document.querySelector(".display-name").classList.add("hidden");

    document.querySelector(".edit-email").classList.remove("hidden");
    document.querySelector(".display-email").classList.add("hidden");

    // Show small avatar icon
    document.querySelector(".avatar-edit-icon").classList.remove("hidden");
}

function saveProfile() {
    document.querySelector(".btn-edit").classList.remove("hidden");
    document.querySelector(".btn-save").classList.add("hidden");

    document.querySelector(".edit-name").classList.add("hidden");
    document.querySelector(".display-name").classList.remove("hidden");

    document.querySelector(".edit-email").classList.add("hidden");
    document.querySelector(".display-email").classList.remove("hidden");

    // Hide avatar icon again
    document.querySelector(".avatar-edit-icon").classList.add("hidden");

    // Send AJAX request
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'update_user_profile',
            name: jQuery('.edit-name').val(),
            email: jQuery('.edit-email').val(),
            nonce: '<?php echo wp_create_nonce('update_profile_nonce'); ?>'
        },
        success: function(response) {
            if(response.success) {
                jQuery('.display-name').text(jQuery('.edit-name').val());
                jQuery('.display-email').text(jQuery('.edit-email').val());
                alert('Profil mis à jour avec succès !');
            } else {
                alert('Erreur: ' + response.data);
            }
        }
    });
}

// ---------------- UPDATE PASSWORD ----------------
function validatePassword() {
    var currentPass = document.getElementById('current_password').value;
    var newPass = document.getElementById('new_password').value;
    var confirmPass = document.getElementById('confirm_password').value;

    if (!currentPass || !newPass || !confirmPass) {
        alert('Veuillez remplir tous les champs');
        return;
    }

    if (newPass !== confirmPass) {
        alert('Les mots de passe ne correspondent pas');
        return;
    }

    jQuery.ajax({
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        type: 'POST',
        data: {
            action: 'update_user_password',
            current_password: currentPass,
            new_password: newPass,
            nonce: '<?php echo wp_create_nonce("update_password_nonce"); ?>'
        },
        success: function(response) {
            if (response.success) {
                alert('Mot de passe modifié avec succès !');
                document.getElementById("password-form").reset();
            } else {
                alert('Erreur: ' + response.data);
            }
        }
    });
}

// ---------------- SEND CLIENT MESSAGE ----------------
function sendMessage() {
    var msg = document.getElementById('message').value;

    if (!msg) {
        alert('Veuillez saisir un message');
        return;
    }

    jQuery.ajax({
        url: '<?php echo admin_url("admin-ajax.php"); ?>',
        type: 'POST',
        data: {
            action: 'send_client_message',
            message: msg,
            nonce: '<?php echo wp_create_nonce("send_message_nonce"); ?>'
        },
        success: function(response) {
            if (response.success) {
                alert('Message envoyé avec succès !');
                document.getElementById("contact-form").reset();
            } else {
                alert('Erreur: ' + response.data);
            }
        }
    });
}

// ---------------- SAVE LANGUAGE & CURRENCY ----------------
document.addEventListener("DOMContentLoaded", function() {

    // On change → update via AJAX
    document.getElementById('language').addEventListener('change', updatePreferences);
    document.getElementById('currency').addEventListener('change', updatePreferences);

    function updatePreferences() {
        jQuery.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: {
                action: 'update_preferences',
                language: document.getElementById('language').value,
                currency: document.getElementById('currency').value,
                nonce: '<?php echo wp_create_nonce("update_preferences_nonce"); ?>'
            }
        });
    }

    // Load saved preferences
    <?php 
    $user_id = get_current_user_id();
    $language = get_user_meta($user_id, 'user_language', true);
    $currency = get_user_meta($user_id, 'user_currency', true);
    ?>

    <?php if ($language): ?>
        document.getElementById('language').value = '<?php echo esc_js($language); ?>';
    <?php endif; ?>

    <?php if ($currency): ?>
        document.getElementById('currency').value = '<?php echo esc_js($currency); ?>';
    <?php endif; ?>

});
</script>
