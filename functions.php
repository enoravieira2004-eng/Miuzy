<?php
/**
 * Theme Functions — MIUZY
 * Stable & compatible PHP 7.2+
 */

/* =====================================================
   ASSETS (CSS / JS)
===================================================== */

add_action('init', function () { 
 
    register_post_type('reservation', [
        'labels' => [
            'name' => 'Reservations',
            'singular_name' => 'Reservation'
        ],
        'public' => false,
        'show_ui' => true, // visible in admin
        'menu_icon' => 'dashicons-tickets-alt',
        'supports' => ['title'],
    ]);

    register_post_type('event', [
        'labels' => [
            'name' => 'Events',
            'singular_name' => 'Event'
        ],
        'public' => false,
        'show_ui' => true, // visible in admin
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => ['title'],
    ]);
});



function miuzy_enqueue_assets() {

    /* ---------- Bootstrap ---------- */
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' 
    );

    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        [],
        null,
        true
    );

    /* ---------- Font Awesome ---------- heart */ 
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'
    );


    wp_enqueue_style(
        'miuzy-style', // Handle (unique name)
        get_stylesheet_uri(), // Automatically points to style.css
        [],
        filemtime(get_stylesheet_directory() . '/style.css') // Cache busting
    );

    
    /* ---------- CSS principal ---------- */
    if ( ! is_page('login') ) {

        $main_css = get_template_directory() . '/assets/css/main.css';

        wp_enqueue_style(
            'miuzy-main-css',
            get_template_directory_uri() . '/assets/css/main.css',
            ['bootstrap-css'],
            file_exists($main_css) ? filemtime($main_css) : '1.0'
        );
    }

    /* ---------- LOGIN & REGISTER ---------- */
    if ( is_page(['login', 'register']) ) {

        $login_css = get_template_directory() . '/assets/css/login.css';

        wp_enqueue_style(
            'miuzy-auth-css',
            get_template_directory_uri() . '/assets/css/login.css',
            [],
            file_exists($login_css) ? filemtime($login_css) : '1.0'
        );
    }

    /* ---------- PAGE PROFIL ---------- */
    if ( is_page_template('template-userprofil.php') ) {

        /* CSS PROFIL */
        $profile_css = get_template_directory() . '/assets/css/user-profile.css';

        wp_enqueue_style(
            'miuzy-user-profile-css',
            get_template_directory_uri() . '/assets/css/user-profile.css',
            ['miuzy-main-css'],
            file_exists($profile_css) ? filemtime($profile_css) : '1.0'
        );

        /* JS PROFIL (🔥 cache-proof) */
        $profile_js = get_template_directory() . '/assets/js/user-profile.js';

        wp_enqueue_script(
            'miuzy-user-profile',
            get_template_directory_uri() . '/assets/js/user-profile.js',
            ['jquery'],
            file_exists($profile_js) ? filemtime($profile_js) : '1.0',
            true
        );

        /* Variables AJAX */
        wp_localize_script('miuzy-user-profile', 'miuzyAjax', [
            'ajax_url'          => admin_url('admin-ajax.php'),
            'nonce_avatar'      => wp_create_nonce('miuzy_avatar_nonce'),
            'nonce_profile'     => wp_create_nonce('update_profile_nonce'),
            'nonce_password'    => wp_create_nonce('update_password_nonce'),
            'nonce_message'     => wp_create_nonce('send_message_nonce'),
            'nonce_preferences' => wp_create_nonce('update_preferences_nonce'),
        ]);
    }

    /* ---------- REGISTER ---------- */
    if ( is_page('register') ) {

        $register_css = get_template_directory() . '/assets/css/register.css';

        wp_enqueue_style(
            'miuzy-register-css',
            get_template_directory_uri() . '/assets/css/register.css',
            [],
            file_exists($register_css) ? filemtime($register_css) : '1.0'
        );
    }

    // EVENT CSS
    wp_enqueue_style('event-style', get_template_directory_uri() . '/assets/css/event.css');

    
    wp_enqueue_style('info-style', get_template_directory_uri() . '/assets/css/info.css');
}
add_action('wp_enqueue_scripts', 'miuzy_enqueue_assets');

function miuzy_enqueue_datepicker() {

    // jQuery UI core
    wp_enqueue_script('jquery-ui-datepicker');

    // jQuery UI CSS (official)
    wp_enqueue_style(
        'jquery-ui-css',
        'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css'
    );
}
add_action('wp_enqueue_scripts', 'miuzy_enqueue_datepicker');


/* =====================================================
   SUPPORTS DU THÈME
===================================================== */

add_theme_support('title-tag');
add_theme_support('post-thumbnails');


/* =====================================================
   REDIRECTIONS LOGIN / LOGOUT
===================================================== */

add_filter('login_redirect', function () {
    return home_url();
});

add_action('wp_logout', function () {
    wp_redirect(site_url('/login'));
    exit;
});


/* =====================================================
   AJAX — UPLOAD AVATAR
===================================================== */

add_action('wp_ajax_miuzy_upload_avatar', function () {

    if (
        ! is_user_logged_in() ||
        ! isset($_POST['nonce']) ||
        ! wp_verify_nonce($_POST['nonce'], 'miuzy_avatar_nonce')
    ) {
        wp_send_json_error('Non autorisé');
    }

    if ( empty($_FILES['avatar']) ) {
        wp_send_json_error('Aucun fichier');
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $attachment_id = media_handle_upload('avatar', 0);

    if ( is_wp_error($attachment_id) ) {
        wp_send_json_error($attachment_id->get_error_message());
    }

    $url = wp_get_attachment_url($attachment_id);
    update_user_meta(get_current_user_id(), 'custom_avatar', $url);

    wp_send_json_success(['url' => $url]);
});


/* =====================================================
   AJAX — UPDATE PROFIL
===================================================== */

add_action('wp_ajax_update_user_profile', function () {

    if (
        ! is_user_logged_in() ||
        ! isset($_POST['nonce']) ||
        ! wp_verify_nonce($_POST['nonce'], 'update_profile_nonce')
    ) {
        wp_send_json_error('Non autorisé');
    }

    $user_id = get_current_user_id();
    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');

    if ( ! $name || ! is_email($email) ) {
        wp_send_json_error('Données invalides');
    }

    $existing = email_exists($email);
    if ( $existing && $existing != $user_id ) {
        wp_send_json_error('Email déjà utilisé');
    }

    wp_update_user([
        'ID'           => $user_id,
        'display_name' => $name,
        'user_email'   => $email,
    ]);

    wp_send_json_success();
});


/* =====================================================
   AJAX — UPDATE PASSWORD
===================================================== */

add_action('wp_ajax_update_user_password', function () {

    if (
        ! is_user_logged_in() ||
        ! isset($_POST['nonce']) ||
        ! wp_verify_nonce($_POST['nonce'], 'update_password_nonce')
    ) {
        wp_send_json_error('Non autorisé');
    }

    $user = wp_get_current_user();

    if ( ! wp_check_password($_POST['current_password'], $user->user_pass, $user->ID) ) {
        wp_send_json_error('Mot de passe incorrect');
    }

    wp_set_password($_POST['new_password'], $user->ID);
    wp_send_json_success();
});


/* =====================================================
   AJAX — MESSAGE CLIENT
===================================================== */

add_action('wp_ajax_send_client_message', function () {

    if (
        ! is_user_logged_in() ||
        ! isset($_POST['nonce']) ||
        ! wp_verify_nonce($_POST['nonce'], 'send_message_nonce')
    ) {
        wp_send_json_error('Non autorisé');
    }

    wp_mail(
        get_option('admin_email'),
        'Message service client — Miuzy',
        sanitize_textarea_field($_POST['message'] ?? '')
    );

    wp_send_json_success();
});


/* =====================================================
   AJAX — LANGUE & DEVISE
===================================================== */

add_action('wp_ajax_update_preferences', function () {

    if (
        ! is_user_logged_in() ||
        ! isset($_POST['nonce']) ||
        ! wp_verify_nonce($_POST['nonce'], 'update_preferences_nonce')
    ) {
        wp_send_json_error('Non autorisé');
    }

    $user_id = get_current_user_id();

    update_user_meta($user_id, 'user_language', sanitize_text_field($_POST['language'] ?? ''));
    update_user_meta($user_id, 'user_currency', sanitize_text_field($_POST['currency'] ?? ''));

    wp_send_json_success();
});

function miuzy_load_scripts() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'miuzy_load_scripts');


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'search-js',
        get_template_directory_uri() . '/search.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('search-js', 'ajaxurl', [
        'url' => admin_url('admin-ajax.php')
    ]);
});


// partie INSAF
add_action('wp_ajax_search_events', 'handle_search_events');
add_action('wp_ajax_nopriv_search_events', 'handle_search_events');

function handle_search_events() { 

    // Sanitize inputs
    $location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
    $date     = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';
    $dateObj = DateTime::createFromFormat('d/m/Y', $date);
    if ($dateObj) {
        $date = $dateObj->format('Y-m-d'); // ISO
    }
    $style    = isset($_GET['style']) ? sanitize_text_field($_GET['style']) : '';

    $meta_query = [];

    if ($location) {
        $meta_query[] = [
            'key'     => 'lieu',
            'value'   => $location,
            'compare' => 'LIKE',
        ];
    }

    if ($style) {
        $meta_query[] = [
            'key'     => 'style',
            'value'   => $style,
            'compare' => 'LIKE',
        ];
    }

    if ($date) {
        $meta_query[] = [
            'key'     => 'date',
            'value'   => $date,
            'compare' => '=',
        ];
    }

    $args = [
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => $meta_query,
    ];

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        echo '<p style="text-align:center;margin-top:30px;">Aucun évènement trouvé.</p>';
        wp_die();
    }

    while ($query->have_posts()) {
        $query->the_post();

        $event_id = get_the_ID();

        $artist = get_post_meta($event_id, 'artist_name', true);
        $style  = get_post_meta($event_id, 'style', true);
        $lieu   = get_post_meta($event_id, 'lieu', true);
        $adresse   = get_post_meta($event_id, 'adresse', true);
        $date   = get_post_meta($event_id, 'date', true);
        $heure   = get_post_meta($event_id, 'heure', true);
        $prix   = get_post_meta($event_id, 'prix', true);
        $image  = get_post_meta($event_id, 'artist_image_url', true);
        ?>

        <!-- RESULT TICKET -->
        <div class="ticket-card">
            <img class="ticket-image"
                 src="<?php echo esc_url($image ?: get_template_directory_uri() . '/assets/image/default-event.jpg'); ?>">

            <div class="ticket-info">
                <h3><?php echo esc_html($artist); ?></h3>
                <p><?php echo esc_html($style); ?> – <?php echo esc_html($adresse); ?></p>
                <p><strong> <?php echo date('d/m/Y', strtotime($date)) . ' à ' . $heure; ?></strong></p>
                <p><?php echo esc_html($prix); ?> €</p>
            </div>

            <div class="ticket-actions">
                <div class="fav-btn" data-event-id="<?php echo $event_id; ?>">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <a href="<?php echo site_url('/info?event_id=' . $event_id); ?>" class="more-btn btn-main-miuzy">
                    Voir plus
                </a>
            </div>
        </div>

        <?php
    }

    wp_reset_postdata();
    wp_die();
}


add_action('wp_ajax_get_panier_events', 'get_panier_events'); // récupère le panier de l'utilisateur ex 5
add_action('wp_ajax_nopriv_get_panier_events', 'get_panier_events');

function get_panier_events() {
    $raw = file_get_contents('php://input');
    $panier = json_decode($raw, true);

    if (!$panier) {
        wp_die();
    }

    foreach ($panier as $event_id => $item) {
        $event = get_post($event_id);
        if (!$event) continue;

        $artist = get_post_meta($event_id, 'artist_name', true);
        $prix   = get_post_meta($event_id, 'prix', true);
        $lieu   = get_post_meta($event_id, 'lieu', true);
        $adresse   = get_post_meta($event_id, 'adresse', true);
        $date   = get_post_meta($event_id, 'date', true);
        $heure   = get_post_meta($event_id, 'heure', true);
        $image  = get_post_meta($event_id, 'artist_image_url', true);
        $style  = get_post_meta($event_id, 'style', true);
        $qty    = intval($item['qty']);
        $available = (int) get_post_meta($event_id, 'nombre_personnes', true);
        $available = max(0, $available);
        ?>

        <div class="ticket-card" data-id="<?php echo $event_id; ?>" data-price="<?php echo esc_attr($prix); ?>" data-max="<?php echo esc_attr($available); ?>">
            <img class="ticket-image"
                 src="<?php echo esc_url($image ?: get_template_directory_uri() . '/assets/image/default-event.jpg'); ?>">

            <div class="ticket-info">
                <h3><?php echo esc_html($artist); ?></h3>
                <p><?php echo esc_html($style); ?> – <?php echo esc_html($adresse); ?></p>
                <p><strong> <?php echo date('d/m/Y', strtotime($date)) . ' à ' . $heure; ?></strong></p>
                <p><?php echo $qty * $prix; ?> €</p>
            </div>

            <button 
                class="delete-btn" 
                data-remove="<?php echo esc_attr($event_id); ?>"
                aria-label="Supprimer du panier">
                <i class="fa-solid fa-trash" style="font-size:22px"></i>
            </button>
        </div>

        <?php
    }

    wp_die();
}


add_action('wp_ajax_save_reservations', 'save_reservations'); //sauvegarde ce qu'il y a dans le panier 
add_action('wp_ajax_nopriv_save_reservations', 'save_reservations');

function save_reservations() {

    $raw = file_get_contents('php://input');
    $panier = json_decode($raw, true);

    if (!$panier || !is_array($panier)) {
        wp_send_json_error('Invalid panier');
    }

    $created = [];

    foreach ($panier as $event_id => $item) { // boucle (création de la reservation dans la bdd)

        $event = get_post($event_id);
        if (!$event || $event->post_type !== 'event') continue;

        $reservation_id = wp_insert_post([
            'post_type'   => 'reservation',
            'post_status' => 'publish',
            'post_title'  => 'Reservation – ' . get_post_meta($event_id, 'artist_name', true),
        ]);

        if (is_wp_error($reservation_id)) continue;

        update_post_meta($reservation_id, 'event_id', $event_id);
        $qty = max(1, (int) ($item['qty'] ?? 1));
        update_post_meta($reservation_id, 'qty', $qty);
        update_post_meta($reservation_id, 'price', get_post_meta($event_id, 'prix', true));
        update_post_meta($reservation_id, 'event_date', get_post_meta($event_id, 'date', true));
        update_post_meta($reservation_id, 'heure', get_post_meta($event_id, 'heure', true));
        update_post_meta($reservation_id, 'lieu', get_post_meta($event_id, 'lieu', true));
        update_post_meta($reservation_id, 'adresse', get_post_meta($event_id, 'adresse', true));
        update_post_meta($reservation_id, 'artist', get_post_meta($event_id, 'artist_name', true));
        update_post_meta($reservation_id, 'user_id', get_current_user_id());
        update_post_meta($reservation_id, 'created_at', current_time('mysql'));

        $created[] = $reservation_id;
    }

    wp_send_json_success($created);
}


add_action('wp_ajax_get_reservations_db', 'get_reservations_db'); // récuperer les réservations qui existe 
add_action('wp_ajax_nopriv_get_reservations_db', 'get_reservations_db');

function get_reservations_db() {

    $args = [ //ajout d'un paramètre user id
        'post_type'      => 'reservation',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        wp_die();
    }

    while ($query->have_posts()) {
        $query->the_post();

        $event_id = get_post_meta(get_the_ID(), 'event_id', true);
        $artist   = get_post_meta($event_id, 'artist', true);
        $lieu     = get_post_meta($event_id, 'lieu', true);
        $adresse   = get_post_meta($event_id, 'adresse', true);
        $date     = get_post_meta($event_id, 'date', true);
        $heure   = get_post_meta($event_id, 'heure', true);
        $price    = get_post_meta($event_id, 'prix', true);
        $qty    = get_post_meta($event_id, 'qty', true);
        $image    = get_post_meta($event_id, 'artist_image_url', true);
        $qty = (int) ($qty ?: 1);
        ?>

        <div class="ticket-card" data-date="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
            <img class="ticket-image"
                 src="<?php echo esc_url($image ?: get_template_directory_uri() . '/assets/image/default-event.jpg'); ?>">
            <div class="ticket-info">
                <h3><?php echo esc_html($artist); ?></h3>
                <p><strong>Adresse :</strong> <?php echo esc_html($adresse); ?></p>
                <p><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($date)) . ' à ' . $heure; ?></p>
                <p><strong>Prix :</strong> <?php echo esc_html($price); ?> €</p>
                <p><strong>Quantité :</strong> <?php echo esc_html($qty); ?></p>
            </div>
        </div>

        <?php

    }

    wp_reset_postdata();
    wp_die();
}

// Favorites loger/pas loger  ensuite favoris rajouter/enlever
add_action('wp_ajax_toggle_favorite', 'toggle_favorite');
add_action('wp_ajax_nopriv_toggle_favorite', 'toggle_favorite');

function toggle_favorite() {

    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'not_logged_in']);
    }

    $event_id = intval($_POST['event_id']);
    $user_id  = get_current_user_id();

    if (!$event_id) {
        wp_send_json_error();
    }

    $favorites = get_user_meta($user_id, 'favorite_events', true); // récupérer les favoris //
    if (!is_array($favorites)) {
        $favorites = [];
    }

    if (in_array($event_id, $favorites)) {
        // REMOVE
        $favorites = array_diff($favorites, [$event_id]);
        update_user_meta($user_id, 'favorite_events', $favorites);

        wp_send_json_success(['status' => 'removed']);
    } else {
        // ADD
        $favorites[] = $event_id;
        update_user_meta($user_id, 'favorite_events', array_unique($favorites));

        wp_send_json_success(['status' => 'added']);
    }
}


