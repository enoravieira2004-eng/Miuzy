<?php
/* Template name: User Profil */

if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
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
                        echo $custom_avatar 
                            ? '<img src="' . esc_url($custom_avatar) . '" class="avatar-custom" width="80" height="80">'
                            : get_avatar($current_user->ID, 80);
                        ?>

                        <input type="file" id="avatar-upload" accept="image/*" class="hidden" onchange="uploadAvatar(this)">
                        <button type="button" class="avatar-edit-icon hidden" onclick="document.getElementById('avatar-upload').click();">
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
                        <option value="AR">Arabe</option>
                        <option value="BN">Bengali</option>
                        <option value="ZH">Chinois</option>
                        <option value="KO">Coréen</option>
                        <option value="DE">Allemand</option>
                        <option value="EN">Anglais</option>
                        <option value="ES">Espagnol </option>
                        <option value="FR">Français</option>
                        <option value="HI">Hindi</option>
                        <option value="IT">Italien</option>
                        <option value="JA">Japonais</option>
                        <option value="PL">Polonais</option>
                        <option value="PT">Portugais</option>
                        <option value="RU">Russe</option>
                        <option value="SW">Swahili</option>
                        <option value="TA">Tamoul</option>
                        <option value="TR">Turc</option>
                        <option value="UR">Ourdou</option>
                        <option value="VI">Vietnamien</option>
                        </select>
                    </div>

                    <div class="form-group">
    <label>Devise</label>
    <select class="form-select" id="currency">
        <option value="">choisir</option>

        <option value="EUR">EUR (€) — Allemand</option>
        <option value="USD">USD ($) — Anglais</option>
        <option value="SAR">SAR (﷼) — Arabe</option>
        <option value="BDT">BDT (৳) — Bengali</option>
        <option value="CNY">CNY (¥) — Chinois</option>
        <option value="KRW">KRW (₩) — Coréen</option>
        <option value="EUR">EUR (€) — Espagnol</option>
        <option value="EUR">EUR (€) — Français</option>
        <option value="INR">INR (₹) — Hindi</option>
        <option value="EUR">EUR (€) — Italien</option>
        <option value="JPY">JPY (¥) — Japonais</option>
        <option value="PKR">PKR (₨) — Ourdou</option>
        <option value="PLN">PLN (zł) — Polonais</option>
        <option value="EUR">EUR (€) — Portugais</option>
        <option value="RUB">RUB (₽) — Russe</option>
        <option value="KES">KES (KSh) — Swahili</option>
        <option value="INR">INR (₹) — Tamoul</option>
        <option value="TRY">TRY (₺) — Turc</option>
        <option value="VND">VND (₫) — Vietnamien</option>
    </select>
</div>


                </div>
            </div>
        </section>

    </div>
</div>

<?php get_footer(); ?>

<!-- ======================== JAVASCRIPT ============================= -->

<script>

document.addEventListener("DOMContentLoaded", function() {

    /* ==========================
       SAUVEGARDE DES PREFERENCES
    =========================== */

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

    /* ==========================
       CHARGEMENT DES PREFERENCES
    =========================== */

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
