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

    // EVENT CSS
    wp_enqueue_style('event-style', get_template_directory_uri() . '/assets/css/event.css');
    
    wp_enqueue_style('home-style', get_template_directory_uri() . '/assets/css/home.css');
    wp_enqueue_style('search-style', get_template_directory_uri() . '/assets/css/search.css');


    // ticket CSS
    wp_enqueue_style('ticket-style', get_template_directory_uri() . '/assets/css/ticket.css');
   





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

function miuzy_load_scripts() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'miuzy_load_scripts');

function miuzy_save_previous_search() {
    if (!is_user_logged_in()) return;

    $user_id = get_current_user_id();

    // Search parameters
    $search_entry = [
        'query'    => isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '',
        'country'  => isset($_GET['country']) ? sanitize_text_field($_GET['country']) : '',
        'style'    => isset($_GET['style']) ? sanitize_text_field($_GET['style']) : '',
        'date'     => isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '',
        'timestamp'=> time(),
    ];

    // Load old searches
    $old_searches = get_user_meta($user_id, 'miuzy_previous_searches', true);

    if (!is_array($old_searches)) {
        $old_searches = [];
    }

    // Add new search at the top
    array_unshift($old_searches, $search_entry);

    // Limit to the last 5 or 10 searches
    $old_searches = array_slice($old_searches, 0, 5);

    update_user_meta($user_id, 'miuzy_previous_searches', $old_searches);
}
add_action('wp', 'miuzy_save_previous_search');

// AJAX handler – clear previous searches
function miuzy_clear_previous_searches() {
    if (!is_user_logged_in()) wp_send_json_error('not_logged_in');

    check_ajax_referer('miuzy_clear_history_nonce', 'nonce');

    $user_id = get_current_user_id();
    delete_user_meta($user_id, 'miuzy_previous_searches');

    wp_send_json_success('cleared');
}
add_action('wp_ajax_miuzy_clear_history', 'miuzy_clear_previous_searches');

function miuzy_search_history_script() {
    ?>
    <script>
    jQuery(function($) {

        $('#clear-search-history').on('click', function () {

            if (!confirm("Voulez-vous vraiment effacer votre historique ?")) return;

            $.post(
                "<?php echo admin_url('admin-ajax.php'); ?>",
                {
                    action: 'miuzy_clear_history',
                    nonce: "<?php echo wp_create_nonce('miuzy_clear_history_nonce'); ?>"
                },
                function(response) {
                    if (response.success) {
                        // Remove previous search section visually
                        $('.event-card-modern').remove();
                        $('.section-subtitle:contains("Précédente")').remove();
                        $('#clear-search-history').remove();

                        alert("Historique effacé !");
                    }
                }
            );
        });

    });
    </script>
    <?php
}
add_action('wp_footer', 'miuzy_search_history_script');

function miuzy_load_icons() {
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        [],
        '6.5.0'
    );
}
add_action('wp_enqueue_scripts', 'miuzy_load_icons');



// Allow uploading custom avatar
function miuzy_upload_custom_avatar() {

    if (!is_user_logged_in()) {
        wp_send_json_error("not_logged_in");
    }

    check_ajax_referer('miuzy_avatar_nonce', 'nonce');

    if (!isset($_FILES['avatar'])) {
        wp_send_json_error("no_file");
    }

    $file = $_FILES['avatar'];

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    $upload = wp_handle_upload($file, ['test_form' => false]);

    if (isset($upload['error'])) {
        wp_send_json_error($upload['error']);
    }

    // Save avatar URL in usermeta
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'custom_avatar', $upload['url']);

    wp_send_json_success(['url' => $upload['url']]);
}
add_action('wp_ajax_miuzy_upload_avatar', 'miuzy_upload_custom_avatar');


//no acces functions //
// Rediriger les utilisateurs non connectés vers la page "no access"
function miuzy_redirect_guests_to_noaccess() {
    // Si l'utilisateur est connecté → on ne fait rien
    if ( is_user_logged_in() ) {
        return;
    }

    // Slugs des pages protégées
    $protected_pages = array( 'reservation', 'favoris', 'panier', 'compte' );

    // Si on est sur une des pages protégées
    if ( is_page( $protected_pages ) ) {

        // Redirige vers la page "no access"
        wp_redirect( home_url( '/noacces/' ) ); // remplace /noacces/ si ton slug est différent
        exit;
    }
}
add_action( 'template_redirect', 'miuzy_redirect_guests_to_noaccess' );


















//PAGE RECHERCHE//
/* --- AJAX Recherche Événements --- */
add_action('wp_ajax_search_events', 'search_events');
add_action('wp_ajax_nopriv_search_events', 'search_events');

function search_events() {

    $location = sanitize_text_field($_GET['location']);
    $date     = sanitize_text_field($_GET['date']);
    $style    = sanitize_text_field($_GET['style']);

    $args = [
        'post_type' => 'event', // ton custom post type
        'posts_per_page' => -1,
        'meta_query' => []
    ];

    if ($location) {
        $args['meta_query'][] = [
            'key' => 'event_location',
            'value' => $location,
            'compare' => 'LIKE'
        ];
    }

    if ($date) {
        $args['meta_query'][] = [
            'key' => 'event_date',
            'value' => $date,
            'compare' => '='
        ];
    }

    if ($style) {
        $args['meta_query'][] = [
            'key' => 'event_style',
            'value' => $style,
            'compare' => 'LIKE'
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();

            $price     = get_field('event_price');
            $address   = get_field('event_address');
            $img       = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            ?>

            <div class="ticket">
                <img src="<?php echo $img; ?>" alt="">
                <div class="ticket-content">
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_content(), 25); ?></p>
                    <p><strong>Adresse :</strong> <?php echo $address; ?></p>
                    <p><strong>Prix :</strong> <?php echo $price; ?> €</p>
                </div>

                <div class="ticket-actions">
                    <div class="fav-btn">♡</div>
                    <a href="<?php the_permalink(); ?>" class="more-btn">Voir plus</a>
                </div>
            </div>

        <?php
        endwhile;
    else :
        echo "<p>Aucun résultat trouvé…</p>";
    endif;

    wp_die();
}

// EVENT POST CREATION//
// custom post 
add_action('init', function () {

    $labels = array(
        'name'               => 'Events',
        'singular_name'      => 'Event',
        'add_new'            => 'Add Event',
        'add_new_item'       => 'Add New Event',
        'edit_item'          => 'Edit Event',
        'new_item'           => 'New Event',
        'view_item'          => 'View Event',
        'search_items'       => 'Search Events',
        'not_found'          => 'No events found',
        'not_found_in_trash' => 'No events found in Trash',
    );

    $args = array(
        'label'               => 'Events',
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'menu_icon'           => 'dashicons-calendar',
        'supports'            => array('title', 'editor', 'thumbnail'),
        'show_in_rest'        => true, // Enables Gutenberg + API
    );

    register_post_type('event', $args);
});


add_action('add_meta_boxes', function () {
    add_meta_box(
        'event_meta_display',
        'Event Details',
        'render_event_meta_display',
        'event',
        'normal',
        'default'
    );
});

function render_event_meta_display($post) {

    $fields = [
        'prenom'           => 'Prénom',
        'nom'              => 'Nom',
        'email'            => 'Email',
        'telephone'        => 'Téléphone',
        'artist_name'      => 'Artist',
        'style'            => 'Style',
        'description'      => 'Description',
        'adresse'          => 'Adresse',
        'lieu'             => 'Lieu',
        'date'             => 'Event Date',
        'nombre_personnes' => 'Number of People',
        'prix'             => 'Price',
        'artist_image_url' => 'Artist Image',
    ];

    echo '<table class="widefat striped">';

    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);

        if (empty($value)) {
            continue;
        }

        echo '<tr>';
        echo '<th style="width:200px;">' . esc_html($label) . '</th>';
        echo '<td>';

        if ($key === 'artist_image_url') {
            echo '<img src="' . esc_url($value) . '" style="max-width:150px;height:auto;" />';
        } else {
            echo esc_html($value);
        }

        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

// ticket css functions //
add_action('wp_enqueue_scripts', function () {

    // Charger le CSS sur les pages "event"
    if (is_singular('event')) {
        wp_enqueue_style(
            'ticket-css', // nom interne
            get_stylesheet_directory_uri() . '/ticket.css', // chemin du fichier
            [],
            '1.0'
        );
    }

    // Charger le CSS sur la page "Mes favoris"
    if (is_page('mes-favoris')) {
        wp_enqueue_style(
            'ticket-css',
            get_stylesheet_directory_uri() . '/ticket.css',
            [],
            '1.0'
        );
    }
});
