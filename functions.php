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

    // 🔥 Script du menu hamburger
    wp_enqueue_script(
        'miuzy-header',
        get_template_directory_uri() . '/assets/js/header.js',
        array(),
        null,
        true
    );
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

/* ------------------------------------------------------ */
/* Redirection vers la page de connexion personnalisée     */
/* ------------------------------------------------------ */

function miuzy_login_url() {
    return home_url('/login/');
}

/*
add_filter('login_url', function() {
    return miuzy_login_url();
});

add_action('init', function() {

    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {

        if (isset($_GET['action']) && $_GET['action'] !== '') {
            return;
        }

        wp_redirect( miuzy_login_url() );
        exit;
    }

});
*/

function miuzy_enqueue_user_profile_css() {

    if (is_page_template('template-userprofil.php')) {

        wp_enqueue_style(
            'user-profile-css',
            get_template_directory_uri() . '/assets/css/userprofil.css',
            array(),
            '1.0'
        );
    }
}

add_action('wp_enqueue_scripts', 'miuzy_enqueue_user_profile_css');
/* ============================================================
   REDIRECTION DE wp-login.php → /login
   ============================================================ */

   function miuzy_force_custom_login() {
    $uri = $_SERVER['REQUEST_URI'];

    // Si on accède à wp-login.php directement
    if (strpos($uri, 'wp-login.php') !== false) {

        // Laisser WordPress gérer logout, reset password, etc.
        if (isset($_GET['action']) && $_GET['action'] !== 'login') {
            return;
        }

        // Redirection vers /login
        wp_redirect( home_url('/login/') );
        exit;
    }
}
add_action('init', 'miuzy_force_custom_login');


/* ============================================================
   REMPLACE TOUS LES LIENS DE CONNEXION WORDPRESS PAR /login
   ============================================================ */

function miuzy_replace_login_url($login_url, $redirect, $force_reauth) {
    return home_url('/login/');
}
add_filter('login_url', 'miuzy_replace_login_url', 10, 3);


/* ============================================================
   REDIRIGER LES INVITÉS VERS /noacces
   ============================================================ */

function miuzy_redirect_guests_to_noaccess() {

    // Si l'utilisateur est connecté → on ne fait rien
    if ( is_user_logged_in() ) {
        return;
    }

    // Pages protégées par leur SLUG
    $protected_slugs = array( 'compte', 'panier', 'favoris', 'reservation' );

    // Si on est sur une des pages protégées
    if ( is_page( $protected_slugs ) ) {

        // Redirection vers la page "noacces"
        // ⚠️ ici le chemin DOIT correspondre exactement au SLUG de ta page
        wp_redirect( home_url('/noacces/') );
        exit;
    }
}
add_action('template_redirect', 'miuzy_redirect_guests_to_noaccess', 1);
