<?php
/* Template name: User Profil */

// Vérifier si l'utilisateur est connecté
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
                    <div class="profile-image">
                        <?php echo get_avatar($current_user->ID, 80); ?>
                    </div>
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
                            <input type="password" id="current_password" name="current_password" class="form-input">
                        </div>
                        <div class="form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="password" id="new_password" name="new_password" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Vérification du mot de passe</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-input">
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
                    <textarea class="form-textarea" id="message" name="message" rows="6" placeholder="Votre message..."></textarea>
                    <button type="button" class="btn-send" onclick="sendMessage()">Envoyer</button>
                </form>
            </div>
        </section>

        <!-- AJOUT D'UN EVENEMENT -->
        <section class="profile-section">
            <h2 class="section-title">AJOUT D'UN EVENEMENT</h2>
            <div class="section-content">
                <p class="section-description">Vous souhaitez organiser un événement ? Introduisez les données nécessaire à la prochaine page</p>
                <a href="<?php echo home_url('/mon-evenement'); ?>" class="btn-event">Mon évènement</a>
            </div>
        </section>

        <!-- QUITTER VOTRE COMPTE -->
        <section class="profile-section">
            <h2 class="section-title">QUITTER VOTRE COMPTE</h2>
            <div class="section-content">
                <p class="section-description">Merci de votre visite, à bientôt chez Miuzy !</p>
                <a href="<?php echo wp_logout_url(home_url('/login')); ?>" class="btn-logout">Se déconnecter</a>
            </div>
        </section>

    </div>
</div>

<script>
jQuery(document).ready(function($) {
    
    // Toggle edit mode
    window.toggleEdit = function() {
        $('.display-name, .display-email').toggleClass('hidden');
        $('.edit-name, .edit-email').toggleClass('hidden');
        $('.btn-edit').toggleClass('hidden');
        $('.btn-save').toggleClass('hidden');
    }

    // Save profile
    window.saveProfile = function() {
        var newName = $('.edit-name').val();
        var newEmail = $('.edit-email').val();

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'update_user_profile',
                name: newName,
                email: newEmail,
                nonce: '<?php echo wp_create_nonce('update_profile_nonce'); ?>'
            },
            success: function(response) {
                if(response.success) {
                    $('.display-name').text(newName);
                    $('.display-email').text(newEmail);
                    toggleEdit();
                    alert('Profil mis à jour avec succès !');
                } else {
                    alert('Erreur: ' + response.data);
                }
            }
        });
    }

    // Validate password
    window.validatePassword = function() {
        var currentPass = $('#current_password').val();
        var newPass = $('#new_password').val();
        var confirmPass = $('#confirm_password').val();

        if(!currentPass || !newPass || !confirmPass) {
            alert('Veuillez remplir tous les champs');
            return;
        }

        if(newPass !== confirmPass) {
            alert('Les mots de passe ne correspondent pas');
            return;
        }

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'update_user_password',
                current_password: currentPass,
                new_password: newPass,
                nonce: '<?php echo wp_create_nonce('update_password_nonce'); ?>'
            },
            success: function(response) {
                if(response.success) {
                    alert('Mot de passe modifié avec succès !');
                    $('#password-form')[0].reset();
                } else {
                    alert('Erreur: ' + response.data);
                }
            }
        });
    }

    // Send message
    window.sendMessage = function() {
        var message = $('#message').val();

        if(!message) {
            alert('Veuillez saisir un message');
            return;
        }

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'send_client_message',
                message: message,
                nonce: '<?php echo wp_create_nonce('send_message_nonce'); ?>'
            },
            success: function(response) {
                if(response.success) {
                    alert('Message envoyé avec succès !');
                    $('#contact-form')[0].reset();
                } else {
                    alert('Erreur: ' + response.data);
                }
            }
        });
    }

    // Save language and currency on change
    $('#language, #currency').change(function() {
        var language = $('#language').val();
        var currency = $('#currency').val();

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'update_preferences',
                language: language,
                currency: currency,
                nonce: '<?php echo wp_create_nonce('update_preferences_nonce'); ?>'
            },
            success: function(response) {
                if(response.success) {
                    console.log('Préférences mises à jour');
                }
            }
        });
    });

    // Load saved preferences
    <?php 
    $user_id = get_current_user_id();
    $language = get_user_meta($user_id, 'user_language', true);
    $currency = get_user_meta($user_id, 'user_currency', true);
    ?>
    
    <?php if ($language): ?>
    $('#language').val('<?php echo esc_js($language); ?>');
    <?php endif; ?>
    
    <?php if ($currency): ?>
    $('#currency').val('<?php echo esc_js($currency); ?>');
    <?php endif; ?>
});
</script>

<?php
get_footer();
?>