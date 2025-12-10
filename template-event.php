<?php
/* Template Name: event */
get_header();
?>
<?php
/*
 * Template Name: Création d'évènement
 */
get_header();
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/event.css">

<div class="event-page">

    <!-- HERO -->
    <section class="event-hero" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/images/event-hero.jpg');">
        <div class="event-hero-overlay"></div>
        <div class="event-hero-content container">
            <h1>LÀ OÙ LES<br><span>ÉVÈNEMENTS LOCAUX</span><br>PRENNENT <strong>VIE !</strong></h1>
        </div>
    </section>

    <div class="container event-main py-5">

        <?php
        // SI FORMULAIRE ENVOYÉ → AFFICHAGE DU TICKET
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_submit'])) :

            $prenom       = esc_html($_POST['prenom']);
            $nom          = esc_html($_POST['nom']);
            $email        = esc_html($_POST['email']);
            $tel          = esc_html($_POST['telephone']);
            $artiste      = esc_html($_POST['artist_name']);
            $style        = esc_html($_POST['style']);
            $adresse      = esc_html($_POST['adresse']);
            $lieu         = esc_html($_POST['lieu']);
            $date         = esc_html($_POST['date']);
            $nb_personnes = intval($_POST['nombre_personnes']);
            $prix         = esc_html($_POST['prix']);
            $description  = esc_html($_POST['description']);
        ?>

            <!-- TICKET -->
            <section class="event-ticket-wrapper my-5">
                <div class="event-ticket d-flex align-items-center">
                    <div class="event-ticket-image">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/event-sample.jpg" alt="<?php echo $artiste; ?>">
                    </div>

                    <div class="event-ticket-body flex-grow-1">
                        <h2 class="ticket-title"><?php echo $artiste; ?></h2>
                        <p class="ticket-description"><?php echo $description; ?></p>

                        <p class="ticket-meta">
                            <strong>Adresse :</strong> <?php echo $adresse . ', ' . $lieu; ?><br>
                            <strong>Date :</strong> <?php echo $date; ?><br>
                            <strong>Prix :</strong> <?php echo $prix; ?> €
                        </p>
                    </div>

                    <div class="event-ticket-actions text-end">
                        <div class="ticket-heart">♡</div>

                        <a href="#" class="btn btn-outline-primary btn-ticket-more">
                            voir plus
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-new-event">
                        Créer un nouvel évènement
                    </a>
                </div>
            </section>

        <?php else : ?>

            <!-- FORMULAIRE -->
            <form id="eventForm" class="event-form" method="post">

                <!-- INFORMATION PERSONNELLE -->
                <div class="row mb-5">
                    <div class="col-md-4"><h2 class="event-section-title">Information personnelle</h2></div>
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6"><label>Nom</label><input type="text" name="nom" class="form-control event-input" required></div>
                            <div class="col-md-6"><label>Prénom</label><input type="text" name="prenom" class="form-control event-input" required></div>
                            <div class="col-md-6"><label>E-mail</label><input type="email" name="email" class="form-control event-input" required></div>
                            <div class="col-md-6"><label>Numéro de téléphone</label><input type="tel" name="telephone" class="form-control event-input" required></div>
                        </div>
                    </div>
                </div>

                <!-- INFORMATION EVENEMENT -->
                <div class="row mb-5">
                    <div class="col-md-4"><h2 class="event-section-title">Information de l'évènement</h2></div>

                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Nom de l'artiste</label>
                                <input type="text" name="artist_name" class="form-control event-input" required>
                            </div>

                            <div class="col-md-6">
                                <label>Style musical</label>
                                <select name="style" class="form-select event-input" required>
                                    <option value="">Choisir</option>
                                    <option>Rock</option><option>Pop</option><option>Indie</option>
                                    <option>Metal</option><option>R&B</option><option>Electro</option>
                                </select>
                            </div>

                            <div class="col-md-6"><label>Adresse</label><input type="text" name="adresse" class="form-control event-input" required></div>

                            <div class="col-md-6">
                                <label>Lieu</label>
                                <select name="lieu" class="form-select event-input" required>
                                    <option value="">Choisir</option>
                                    <option>Belgique, Bruxelles</option>
                                    <option>France, Paris</option>
                                    <option>Ecosse, Edinburgh</option>
                                    <option>Espagne, Madrid</option>
                                    <option>Royaume-Uni, Londres</option>
                                </select>
                            </div>

                            <div class="col-md-6"><label>Date</label><input type="date" name="date" class="form-control event-input" required></div>

                            <div class="col-md-6">
                                <label>Nombre de personnes</label>
                                <div class="d-flex align-items-center event-counter">
                                    <button type="button" class="btn counter-btn" data-target="#nbp" data-step="-1">−</button>
                                    <input id="nbp" name="nombre_personnes" type="number" class="form-control event-input text-center mx-2" value="0" min="0">
                                    <button type="button" class="btn counter-btn" data-target="#nbp" data-step="1">+</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Prix</label>
                                <div class="d-flex align-items-center event-counter">
                                    <button type="button" class="btn counter-btn" data-target="#prix" data-step="-1">−</button>
                                    <input id="prix" name="prix" type="number" class="form-control event-input text-center mx-2" value="0" min="0">
                                    <button type="button" class="btn counter-btn" data-target="#prix" data-step="1">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- DESCRIPTION -->
                <div class="row mb-5">
                    <div class="col-md-4"><h2 class="event-section-title">Description de l'artiste</h2></div>
                    <div class="col-md-8">
                        <textarea name="description" class="form-control event-input" rows="6" required></textarea>
                    </div>
                </div>

                <!-- RÈGLEMENTATION -->
                <div class="row mb-4">
                    <div class="col-md-4"><h2 class="event-section-title">Règlementation</h2></div>

                    <div class="col-md-8">
                        <div class="event-rules-box">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit...
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-see-more mt-3">voir plus</button>

                        <div class="form-check mt-3">
                            <input type="checkbox" id="accept_terms" required>
                            <label for="accept_terms">J'accepte les conditions d'utilisations.*</label>
                        </div>
                    </div>
                </div>

                <!-- BOUTON ENVOYER -->
                <div class="text-center mt-4">
                    <button type="submit" name="event_submit" class="btn btn-primary btn-submit-event">Envoyer</button>
                </div>

            </form>

        <?php endif; ?>

    </div>
</div>

<script>
jQuery(function($) {

    // Compteurs + -
    $('.counter-btn').on('click', function () {
        const input = $($(this).data('target'));
        let val = parseInt(input.val());
        val += parseInt($(this).data('step'));
        if (val < 0) val = 0;
        input.val(val);
    });

    // Voir plus
    $('.btn-see-more').on('click', function () {
        $('.event-rules-box').toggleClass('expanded');
    });

});
</script>

<?php get_footer(); ?>
























<?php
get_footer();
?>