<?php
/*
Template Name: Recherche
*/
get_header();
?>

<section class="event-hero" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/assets/image/pexels-thibault-trillet-44912-167636.jpg">
    <div class="event-hero-overlay"></div>
    <div class="event-hero-content container">
        <h1>Réserve les meilleurs événements musicaux près de toi !</h1>
    </div>
</section>

<div class="container-wrapper">
    <div class="filters-wrapper">
        <div class="filters">
            <!-- FILTRE LIEU -->
            <select id="filter-location">
                <option value="">Lieu</option>
                <option>Belgique, Bruxelles</option>
                <option>France, Paris</option>
                <option>Ecosse, Edinburgh</option>
                <option>Espagne, Madrid</option>
                <option>Royaume-Uni, Londres</option>
                <option>Islande, Reykjavík</option>
                <option>Argentine, Salta</option>
                <option>Australie, Melbourne</option>
                <option>Canada, Québec</option>
                <option>Maroc, Marrakech</option>
                <option>Groenland, Nuuk</option>
                <option>USA, Portland</option>
                <option>Japon, Tokyo</option>

            </select>

            <!-- FILTRE DATE -->
            <input
                type="text"
                id="filter-date"
                class="event-input"
                placeholder="jj/mm/aaaa"
                required
            >

            <!-- FILTRE STYLE MUSICAL -->
            <select id="filter-style">
                <option value="">Style musical</option>
                <option>Rock</option>
                <option>Pop</option>
                <option>Indie</option>
                <option>R&B</option>
                <option>Metal</option>
                <option>Électro</option>
                <option>Afro</option>
                <option>Folk</option>
                <option>Punk</option>
                <option>Traditionel</option>
                <option>Contemporain</option>
                <option>Country</option>
                <option>Jazz</option>
            </select>

            <button id="filter-btn" class="search-btn">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/image/loupe.svg" width="30" alt="Rechercher">
            </button>

        </div>
    </div>

    <br/>
    <br/>

    <!-- ZONE DES RÉSULTATS -->
    <div id="results-container">
        <!-- Les résultats AJAX s’affichent ici -->
    </div>

</div>
<?php get_footer(); ?>

<style>
/* ================================
   FILTERS – RESPONSIVE
================================ */

.filters-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
}

.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    width: 100%;
    max-width: 1000px;
    justify-content: center;
    padding: 10px;
}

/* Inputs */
.filters select,
.filters input {
    padding: 12px 18px;
    border-radius: 20px;
    border: 1px solid #ccc;
    width: 100%;
    max-width: 220px;
    font-size: 16px;
}

/* Date input */
.event-input {
    border-radius: 20px;
}

/* Select arrow */
.filters select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 45px;
    background-image: url("<?php echo get_template_directory_uri(); ?>/assets/image/fleche-bas.svg");
    background-position: right 15px center;
    background-repeat: no-repeat;
    background-size: 14px;
}

/* Search button */
.search-btn {
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.search-btn img {
    width: 50px;
    height: 50px;
}

.event-hero-content h1 {
    font-size: 3rem;        /* Desktop */
    line-height: 1.2;
    
    margin: 0;
    padding: 0 15px;
}

/* Tablet */
@media (max-width: 1024px) {
    .event-hero-content h1 {
        font-size: 2.4rem;
    }
}

/* Mobile */
@media (max-width: 768px) {
    .event-hero-content h1 {
        font-size: 1.8rem;
        line-height: 1.3;
    }
}

/* Small mobile */
@media (max-width: 480px) {
    .event-hero-content h1 {
        font-size: 1.5rem;
    }
}

/* ================================
   MOBILE
================================ */
@media (max-width: 768px) {

    .filters {
        flex-direction: column;
        align-items: stretch;
    }

    .filters select,
    .filters input,
    .search-btn {
        max-width: 100%;
        width: 100%;
    }

    .search-btn {
        border-radius: 30px;
        height: 48px;
    }
}

/* ================================
   RESULTS
================================ */
#results-container {
    width: 100%;
    margin-top: 30px;
}
</style>

<script>
document.getElementById("filter-btn").addEventListener("click", function () {

    const location = document.getElementById("filter-location").value;
    const date     = document.getElementById("filter-date").value;
    const style    = document.getElementById("filter-style").value;

    fetch(`${ajaxurl.url}?action=search_events&location=${location}&date=${date}&style=${style}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById("results-container").innerHTML = html;
        });
});


// Gestion des favoris (bouton cœur)
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("fav-btn")) {
        e.target.classList.toggle("active");
    }
});
</script>


<script>
document.addEventListener("click", function(e) {
    const btn = e.target.closest(".fav-btn");
    if (!btn) return;

    const eventId = btn.dataset.eventId;
    console.log(eventId);

    fetch("<?php echo admin_url('admin-ajax.php'); ?>?action=toggle_favorite", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `event_id=${eventId}`
    })
    .then(res => res.json())
    .then(data => {

        if (!data.success) {
            alert("Vous devez être connecté.");
            return;
        }

        btn.classList.toggle("active");
        
        const icon = btn.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-solid');
            icon.classList.toggle('fa-regular');
        }
    });

});
</script>
<script>
jQuery(function ($) {

    $("#filter-date").datepicker({
        dateFormat: "dd/mm/yy",
        firstDay: 1,        // Monday
        changeMonth: true,
        changeYear: true,
        yearRange: "2024:2035"
    });

});
</script>