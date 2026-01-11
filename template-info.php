<?php

/**
 * Template Name: Info
 */

get_header();

    // Validate parameter
    $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

    if (!$event_id) {
        echo '<p>Évènement introuvable.</p>';
        get_footer();
        exit;
    }

    // Get post
    $event = get_post($event_id);

    if (!$event || $event->post_type !== 'event') {
        echo '<p>Évènement invalide.</p>';
        get_footer();
        exit;
    }

    // Get meta (récuperer les champs dans la base de données)
    $artist      = get_post_meta($event_id, 'artist_name', true);
    $style       = get_post_meta($event_id, 'style', true);
    $adresse     = get_post_meta($event_id, 'adresse', true);
    $lieu        = get_post_meta($event_id, 'lieu', true);
    $date        = get_post_meta($event_id, 'date', true);
    $heure        = get_post_meta($event_id, 'heure', true);
    $prix        = get_post_meta($event_id, 'prix', true);
    $image       = get_post_meta($event_id, 'artist_image_url', true);
    $description = $event->post_content;
?>

<main class="event-container"> 
    <div class="event-content">
        <div class="event-row">
            <!-- Image Section -->
            <div class="image-section">
                <img src="<?php echo esc_url($image ?: get_template_directory_uri() . '/assets/image/default-event.jpg'); ?>" 
                    alt="<?php echo esc_html($artist); ?>" 
                    class="event-image">
                
                <!-- Dropdown Menu -->
                <div class="dropdown-menu-custom">
                    <button class="dots-button" id="dropdownBtn">⋮</button>
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="#" id="signalerBtn">
                            <i class="fas fa-flag"></i> Signaler
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-section">
                <h1 class="event-title"><?php echo esc_html($artist); ?></h1>

                <div class="info-item">
                    <span class="info-label">Style :</span>
                    <span class="info-text"><?php echo esc_html($style); ?></span>
                </div>

                <div class="info-item">
                    <span class="info-label">Ville d'origine :</span>
                    <span class="info-text"><?php echo esc_html($lieu); ?></span>
                </div>

                <div class="histoire-section">
                    <p class="info-label">Description :</p>
                    <p class="info-text">
                        <?php echo nl2br(esc_html($description)); ?>
                    </p>
                </div>

                <div class="event-details">
                    <p><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($date))  . ' à ' . $heure; ?></p>
                    <p><strong>Adresse :</strong> <?php echo esc_html($adresse . ', ' . $lieu); ?></p>
                    <p><strong>Prix :</strong> <?php echo esc_html($prix); ?> €</p>
                </div>

                <button class="panier-btn btn-main-miuzy" data-event-id="<?php echo $event_id; ?>">
                    Panier
                </button>

                
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('dropdownBtn');
        const menu = document.getElementById('dropdownContent');

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            menu.classList.toggle('show');
        });

        // Close when clicking outside
        document.addEventListener('click', function () {
            menu.classList.remove('show');
        });
    });

    document.getElementById('signalerBtn').addEventListener('click', function (e) { //signalement
        e.preventDefault();
        alert('Merci de votre signalement.');
    });

    document.addEventListener('click', function(e) { //bouton panier
        if (!e.target.classList.contains('panier-btn')) return;

        if (!"<?php echo is_user_logged_in()?>") { //pas loger
            window.location.href = "<?php echo site_url('/noacces'); ?>";
            return;
        }

        const eventId = e.target.dataset.eventId;
        let panier = JSON.parse(localStorage.getItem('panier') || '{}');

        panier[eventId] = panier[eventId] || { qty: 0 };
        panier[eventId].qty += 1;

        localStorage.setItem('panier', JSON.stringify(panier));

        window.location.href = "<?php echo site_url('/panier'); ?>"; //redirection page panier
    });
</script>
