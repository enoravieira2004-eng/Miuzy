<?php
/* Template Name: Favoris */
get_header();

if (!is_user_logged_in()) {
    echo '<p style="text-align:center">Veuillez vous connecter pour voir vos favoris.</p>';
    get_footer();
    exit;
}

$user_id  = get_current_user_id();
$favorites = get_user_meta($user_id, 'favorite_events', true);
$has_favorites = is_array($favorites) && !empty($favorites);


$query = new WP_Query([
    'post_type'      => 'event',
    'post__in'       => $favorites,
    'posts_per_page' => -1,
]);

?>

<div class="container-wrapper">
    <h2>Mes favoris</h2>
    <br/>

    <div class="favorites-vide" id="favorites-vide" style="display:none">
        <p>Ohoh, il me semble que c’est <strong>vide</strong> par ici.</p>
    </div>

    <div id="results-container">
        <?php while ($query->have_posts()) : $query->the_post();

            $event_id = get_the_ID();
            $artist = get_post_meta($event_id, 'artist_name', true);
            $lieu   = get_post_meta($event_id, 'lieu', true);
            $date   = get_post_meta($event_id, 'date', true);
            $heure   = get_post_meta($event_id, 'heure', true);
            $price  = get_post_meta($event_id, 'prix', true);
            $image  = get_post_meta($event_id, 'artist_image_url', true);
        ?>
        
        <div class="ticket-card">
            <img class="ticket-image"
                 src="<?php echo esc_url($image ?: get_template_directory_uri() . '/assets/image/default-event.jpg'); ?>">

            <div class="ticket-info">
                <h3><?php echo esc_html($artist); ?></h3>
                <p><?php echo esc_html($lieu); ?></p>
                <p><?php echo $date . ' à ' . $heure; ?></p>
                <p><?php echo esc_html($price); ?> €</p>
            </div>

            <div class="ticket-actions">
                <div class="fav-btn active" 
                     data-event-id="<?php echo $event_id; ?>"
                     title="Retirer des favoris">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <a href="<?php echo site_url('/info?event_id=' . $event_id); ?>"
                   class="more-btn btn-main-miuzy">
                    Voir plus
                </a>
            </div>

        </div>

        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>


<style>
    
.favorites-vide{text-align:center;font-size:22px;margin:120px 0;}
.search-container {
    width: 80%;
    margin: 40px auto;
    text-align: center;
}

.filters {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.filters select,
.filters input[type="date"] {
    padding: 10px;
    border-radius: 20px;
    border: 1px solid #ccc;
    width: 180px;
}

.search-btn {
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.search-btn img {
    width: 28px;     /* ajuste selon ton SVG */
    height: 28px;
}

.filters select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding: 12px 45px 12px 20px;
    background-image: url("<?php echo get_template_directory_uri(); ?>/assets/image/fleche-bas.svg");
    background-position: right 15px center;
    background-repeat: no-repeat;
    background-size: 14px;
}

</style>

<script>
document.addEventListener("click", function (e) {

    const btn = e.target.closest(".fav-btn");
    if (!btn) return;

    const eventId = btn.dataset.eventId;

    fetch("<?php echo admin_url('admin-ajax.php'); ?>?action=toggle_favorite", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `event_id=${eventId}`
    })
    .then(res => res.json())
    .then(data => {
        
        // 🔥 Remove card instantly (Favorites page UX)
        const card = btn.closest(".ticket-card");
        if (card) card.remove();

        // Show empty message if no favorites left
        const remaining = document.querySelectorAll(".ticket-card");
        if (remaining.length === 0) {
            document.getElementById("favorites-vide").style.display = "block";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const hasCards = document.querySelectorAll(".ticket-card").length > 0;
    document.getElementById("favorites-vide").style.display = hasCards ? "none" : "block";
});

</script>


