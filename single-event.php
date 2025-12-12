<?php
get_header();

while (have_posts()) : the_post();

    $public_fields = [
        'artist_name'      => 'Artist',
        'style'            => 'Style',
        'description'      => 'Description',
        'adresse'          => 'Address',
        'lieu'             => 'Location',
        'date'             => 'Event Date',
        'nombre_personnes' => 'Number of People',
        'prix'             => 'Price',
        'artist_image_url' => 'Artist Image',
    ];
?>

<main class="event-single">

    <h1><?php the_title(); ?></h1>

    <?php if (has_post_thumbnail()) : ?>
        <div class="event-thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </div>
    <?php endif; ?>

    <section class="event-meta">

        <h2>Event Information</h2>

        <ul>
            <?php foreach ($public_fields as $key => $label) :

                $value = get_post_meta(get_the_ID(), $key, true);

                if (empty($value)) {
                    continue;
                }
            ?>
                <li>
                    <strong><?php echo esc_html($label); ?>:</strong>

                    <?php if ($key === 'artist_image_url') : ?>
                        <br>
                        <img src="<?php echo esc_url($value); ?>" style="max-width:300px;height:auto;">
                    <?php else : ?>
                        <?php echo esc_html($value); ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

    </section>

</main>

<?php
endwhile;

get_footer();
