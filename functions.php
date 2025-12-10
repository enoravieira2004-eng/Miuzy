<?php

/**
 * Theme Functions
 */

// Theme setup
function theme_setup()
{
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'theme_setup');

// Enqueue styles and scripts
function theme_scripts()
{
    // Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
    );

    // Ton CSS
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/main.css');
    
    // Header CSS
    wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/header.css');

    // Footer CSS
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/assets/css/footer.css');

    // INFO CSS
    wp_enqueue_style('info-style', get_template_directory_uri() . '/assets/css/info.css');

    // USER PROFIL CSS
    wp_enqueue_style('userprofil-style', get_template_directory_uri() . '/assets/css/userprofil.css');

    // USER PROFIL CSS
    wp_enqueue_style('userprofil-style', get_template_directory_uri() . '/assets/css/userprofil.css');

   





    // Bootstrap JS
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        array(),
        null,
        true
    );

    // Ton JS
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'theme_scripts');


// Handle user registration
function handle_user_registration()
{
    if (isset($_POST['register_submit']) && isset($_POST['register_nonce']) && wp_verify_nonce($_POST['register_nonce'], 'register_action')) {
        $username = sanitize_user($_POST['user_login']);
        $email = sanitize_email($_POST['user_email']);
        $password = $_POST['user_pass'];
        $password_confirm = $_POST['user_pass_confirm'];

        if ($password !== $password_confirm) {
            wp_redirect(home_url('/signup?registration=error'));
            exit;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Save custom fields as user meta
            if (isset($_POST['first_name'])) {
                update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
            }
            if (isset($_POST['last_name'])) {
                update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
            }
            if (isset($_POST['phone'])) {
                update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
            }
            if (isset($_POST['student_id'])) {
                update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
            }

            // Update display name
            $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
            $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
            if ($first_name || $last_name) {
                wp_update_user(array(
                    'ID' => $user_id,
                    'display_name' => trim($first_name . ' ' . $last_name),
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ));
            }

            wp_redirect(home_url('/signup?registration=success'));
            exit;
        } else {
            wp_redirect(home_url('/signup?registration=error'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_registration');

// Handle user login
function handle_user_login()
{
    if (isset($_POST['login_submit']) && isset($_POST['login_nonce']) && wp_verify_nonce($_POST['login_nonce'], 'login_action')) {
        $email = sanitize_email($_POST['email']);
        error_log("Login attempt for user: " . $email);
        $password = $_POST['password'];
        $remember = isset($_POST['rememberme']) ? true : false;

        if (empty($email) || empty($password)) {
            wp_redirect(home_url('/login?login=empty'));
            exit;
        }

        $creds = array(
            'user_login'    => $email,
            'user_password' => $password,
            'remember'      => $remember
        );

        $user = wp_signon($creds, false);

        if (!is_wp_error($user)) {
            wp_redirect(home_url());
            exit;
        } else {
            wp_redirect(home_url('/login?login=failed'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_user_login');

// Redirect after login
function redirect_after_login($redirect_to, $request, $user)
{
    if (!is_wp_error($user)) {
        return home_url();
    }
    return $redirect_to;
}
add_filter('login_redirect', 'redirect_after_login', 10, 3);

// Helper function to get user custom field
function get_user_custom_field($user_id, $field_name)
{
    return get_user_meta($user_id, $field_name, true);
}

// Add custom fields to user profile in admin
function add_custom_user_profile_fields($user)
{
?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td>
                <input type="tel" name="phone" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="student_id">Student ID</label></th>
            <td>
                <input type="text" name="student_id" id="student_id" value="<?php echo esc_attr(get_user_meta($user->ID, 'student_id', true)); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');

// Save custom fields in admin
function save_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }
    if (isset($_POST['student_id'])) {
        update_user_meta($user_id, 'student_id', sanitize_text_field($_POST['student_id']));
    }
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

// Add custom columns to users list table
function add_custom_user_columns($columns)
{
    $columns['phone'] = 'Phone';
    $columns['student_id'] = 'Student ID';
    return $columns;
}
add_filter('manage_users_columns', 'add_custom_user_columns');

// Display custom column data in users list
function show_custom_user_column_data($value, $column_name, $user_id)
{
    if ($column_name == 'phone') {
        return get_user_meta($user_id, 'phone', true) ?: '—';
    }
    if ($column_name == 'student_id') {
        return get_user_meta($user_id, 'student_id', true) ?: '—';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_custom_user_column_data', 10, 3);

// ========================================
// FONCTIONS AJAX POUR LE PROFIL UTILISATEUR
// ========================================

// Update user profile
add_action('wp_ajax_update_user_profile', 'update_user_profile_ajax');
function update_user_profile_ajax() {
    check_ajax_referer('update_profile_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error('Vous devez être connecté');
    }
    
    $user_id = get_current_user_id();
    $new_name = sanitize_text_field($_POST['name']);
    $new_email = sanitize_email($_POST['email']);
    
    // Validate email
    if (!is_email($new_email)) {
        wp_send_json_error('Email invalide');
    }
    
    // Check if email already exists
    if (email_exists($new_email) && email_exists($new_email) != $user_id) {
        wp_send_json_error('Cet email est déjà utilisé');
    }
    
    // Update user
    $user_data = array(
        'ID' => $user_id,
        'display_name' => $new_name,
        'user_email' => $new_email
    );
    
    $result = wp_update_user($user_data);
    
    if (is_wp_error($result)) {
        wp_send_json_error($result->get_error_message());
    }
    
    wp_send_json_success('Profil mis à jour');
}

// Update password
add_action('wp_ajax_update_user_password', 'update_user_password_ajax');
function update_user_password_ajax() {
    check_ajax_referer('update_password_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error('Vous devez être connecté');
    }
    
    $user = wp_get_current_user();
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    
    // Verify current password
    if (!wp_check_password($current_password, $user->user_pass, $user->ID)) {
        wp_send_json_error('Mot de passe actuel incorrect');
    }
    
    // Validate new password strength
    if (strlen($new_password) < 8) {
        wp_send_json_error('Le mot de passe doit contenir au moins 8 caractères');
    }
    
    // Update password
    wp_set_password($new_password, $user->ID);
    
    wp_send_json_success('Mot de passe modifié');
}

// Update preferences (language and currency)
add_action('wp_ajax_update_preferences', 'update_preferences_ajax');
function update_preferences_ajax() {
    check_ajax_referer('update_preferences_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error('Vous devez être connecté');
    }
    
    $user_id = get_current_user_id();
    $language = sanitize_text_field($_POST['language']);
    $currency = sanitize_text_field($_POST['currency']);
    
    // Save as user meta
    if (!empty($language)) {
        update_user_meta($user_id, 'user_language', $language);
    }
    
    if (!empty($currency)) {
        update_user_meta($user_id, 'user_currency', $currency);
    }
    
    wp_send_json_success('Préférences mises à jour');
}

// Send client message
add_action('wp_ajax_send_client_message', 'send_client_message_ajax');
function send_client_message_ajax() {
    check_ajax_referer('send_message_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error('Vous devez être connecté');
    }
    
    $user = wp_get_current_user();
    $message = sanitize_textarea_field($_POST['message']);
    
    if (empty($message)) {
        wp_send_json_error('Le message ne peut pas être vide');
    }
    
    // Get admin email
    $admin_email = get_option('admin_email');
    
    // Email subject
    $subject = 'Nouveau message du service client - ' . $user->display_name;
    
    // Email body
    $body = "Nouveau message de: " . $user->display_name . " (" . $user->user_email . ")\n\n";
    $body .= "Message:\n" . $message . "\n\n";
    $body .= "Date: " . date('d/m/Y H:i:s');
    
    // Send email
    $sent = wp_mail($admin_email, $subject, $body);
    
    if ($sent) {
        // Optionally save message in database
        $post_id = wp_insert_post(array(
            'post_type' => 'client_message',
            'post_title' => 'Message de ' . $user->display_name,
            'post_content' => $message,
            'post_status' => 'private',
            'post_author' => $user->ID
        ));
        
        wp_send_json_success('Message envoyé');
    } else {
        wp_send_json_error('Erreur lors de l\'envoi du message');
    }
}

// Register custom post type for client messages (optional)
add_action('init', 'register_client_message_post_type');
function register_client_message_post_type() {
    register_post_type('client_message', array(
        'labels' => array(
            'name' => 'Messages Clients',
            'singular_name' => 'Message Client'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'supports' => array('title', 'editor', 'author'),
        'menu_icon' => 'dashicons-email'
    ));
}

function event_enqueue_bootstrap() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'event_enqueue_bootstrap');
