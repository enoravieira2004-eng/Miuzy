<?php
get_header();

while (have_posts()) : the_post();

    // --- Favoris (user_meta) ---
    $user_id   = get_current_user_id();
    $favorites = $user_id ? get_user_meta($user_id, 'favorite_events', true) : [];
    if (!is_array($favorites)) $favorites = [];

    $is_favorite = $user_id && in_array(get_the_ID(), $favorites);

    // --- Champs publics ---
    $artist_name = get_post_meta(get_the_ID(), 'artist_name', true);
    $style       = get_post_meta(get_the_ID(), 'style', true);
    $description = get_post_meta(get_the_ID(), 'description', true);
    $adresse     = get_post_meta(get_the_ID(), 'adresse', true);
    $lieu        = get_post_meta(get_the_ID(), 'lieu', true);
    $date        = get_post_meta(get_the_ID(), 'date', true);
    $nb          = get_post_meta(get_the_ID(), 'nombre_personnes', true);
    $prix        = get_post_meta(get_the_ID(), 'prix', true);
    $image       = get_post_meta(get_the_ID(), 'artist_image_url', true);
?>

<main class="event-page">

    <article class="event-card">

        <div class="event-image">
            <?php if (!empty($image)) : ?>
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($artist_name ?: get_the_title()); ?>">
            <?php endif; ?>
        </div>

        <div class="event-content">

            <h1 class="event-title">
                <?php echo esc_html($artist_name ?: get_the_title()); ?>
            </h1>

            <?php if (!empty($description)) : ?>
                <p class="event-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>

            <?php if (!empty($adresse) || !empty($lieu)) : ?>
                <p class="event-address">
                    <strong>Adresse :</strong>
                    <?php echo esc_html(trim($adresse . ' ' . $lieu)); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($date)) : ?>
                <p class="event-date"><strong>Date :</strong> <?php echo esc_html($date); ?></p>
            <?php endif; ?>

            <?php if (!empty($nb)) : ?>
                <p class="event-people"><strong>Personnes :</strong> <?php echo esc_html($nb); ?></p>
            <?php endif; ?>

            <?php if (!empty($prix)) : ?>
                <p class="event-price"><strong>Prix :</strong> <?php echo esc_html($prix); ?> €</p>
            <?php endif; ?>

            <a class="event-button" href="<?php echo esc_url(home_url('/mes-favoris')); ?>">
                voir plus
            </a>
        </div>

        <?php if (is_user_logged_in()) : ?>
            <a
                class="event-favorite <?php echo $is_favorite ? 'is-favorite' : ''; ?>"
                href="<?php echo esc_url(add_query_arg(['toggle_favorite' => get_the_ID()])); ?>"
                title="<?php echo $is_favorite ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>"
                aria-label="<?php echo $is_favorite ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>"
            >
                ♥
            </a>
        <?php else : ?>
            <a class="event-favorite" href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" title="Connectez-vous pour ajouter en favoris">
                ♥
            </a>
        <?php endif; ?>

    </article>

</main>

<?php
endwhile;

get_footer();

