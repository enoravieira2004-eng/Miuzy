<?php
/*
Template Name: Front Page
*/
get_header();
?>

<section class="miuzy-carousel">
    <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/image/confetti-2571539_1280.jpg"
                     class="d-block w-100" alt="">
            </div>

            <div class="carousel-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/image/girl-band-4671537_1280.jpg"
                     class="d-block w-100" alt="">
            </div>

            <div class="carousel-item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/image/photography-2449748_1280.jpg"
                     class="d-block w-100" alt="">
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</section>

<main class="miuzy-home container">

  <h1 class="miuzy-title">
    Hello, Bienvenue sur la plate forme <span>Miuzy</span> !
  </h1>

  <!-- Bloc Notre Plateforme -->
  <section class="row miuzy-section">
    <div class="col-12 col-md-3">
      <h2 class="miuzy-left-title">NOTRE<br>PLATEFORME</h2>
    </div>

    <div class="col-12 col-md-9">
      <p class="miuzy-paragraph">
        Muzy est une plateforme dédiée à la découverte et au soutien des talents musicaux du monde entier.
        Notre mission est de connecter les passionnés de musique aux concerts de groupes et d’artistes locaux,
        où qu’ils se trouvent. Grâce à Miuzy, vous pouvez facilement acheter vos billets et explorer des événements
        uniques près de chez vous ou à l’étranger. Nous mettons en avant la scène locale pour offrir des expériences
        authentiques et inoubliables. Rejoignez Miuzy et vivez la musique autrement, au plus près des artistes.
      </p>
    </div>
  </section>

  <!-- Bloc Créatrices -->
  <section class="row miuzy-section align-items-start">
    <div class="col-12 col-md-3">
      <h2 class="miuzy-left-title">LES<br>CREATRICES<br>DU PROJET</h2>
    </div>

    <div class="col-12 col-md-9">
      <!-- Créatrice 1 -->
      <div class="miuzy-creator">
        <img
          class="miuzy-creator-img"
          src="<?php echo get_template_directory_uri(); ?>/assets/image/WhatsApp Image 2025-12-04 at 13.41.56.jpeg"
          alt="Insaf Karraz"
        >
        <div class="miuzy-creator-text">
          <h3>Insaf Karraz</h3>
          <p>Pour le projet de cette année, nous avons dû créer un site internet de A à Z.
Cela comprenait la conception, le développement et la mise en ligne du site.
Une fois terminé, le site a été déployé sur le serveur de l’école.
Ce projet nous a permis de mettre en pratique nos compétences web.</p>
        </div>
      </div>

      <!-- Créatrice 2 -->
      <div class="miuzy-creator">
        <img
          class="miuzy-creator-img"
          src="<?php echo get_template_directory_uri(); ?>/assets/image/WhatsApp Image 2025-12-04 at 13.44.34.jpeg"
          alt="Enora Vieira"
        >
        <div class="miuzy-creator-text">
          <h3>Enora Vieira</h3>
           <p>Pour le projet de cette année, nous avons dû créer un site internet de A à Z.
Cela comprenait la conception, le développement et la mise en ligne du site.
Une fois terminé, le site a été déployé sur le serveur de l’école.
Ce projet nous a permis de mettre en pratique nos compétences web.</p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
