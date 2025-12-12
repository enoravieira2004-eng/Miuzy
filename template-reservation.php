<?php
/* Template Name: Reservation */

// Empêcher l'accès aux non-connectés
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login')); // redirection vers page de connexion
    exit;
}

get_header();

?>
<div class="reservations-container">

    <h2 class="reserv-title">Mes réservations</h2>

    <!-- FILTRE -->
    <div class="filter-box">
        <label for="sortTickets">Trier mes tickets</label>
        
        <select id="sortTickets" class="miuzy-select">
            <option value="recent">Récentes</option>
            <option value="old">Anciennes</option>
        </select>
    </div>

    <!-- LISTE DES TICKETS -->
    <div id="ticketsList">

        <!-- Ticket 1 -->
        <div class="ticket-card" data-date="2025-02-18">
           <img src="<?php echo get_template_directory_uri(); ?>/assets/images/solarveins.jpg" 
     alt="Solar Veins">
            <div>
                <h3>Solar Veins</h3>
                <p>Electro–pop nordique mêlant synthés glacés, voix éthérées et rythmes inspirés des aurores boréales.</p>
                <p><strong>Adresse :</strong> Reykjavik, Islande</p>
                <p><strong>Prix :</strong> 10 €</p>
            </div>
        </div>

        <!-- Ticket 2 -->
        <div class="ticket-card" data-date="2024-11-03">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Los Caminantes del Viento.jpg" 
     alt="Los Caminantes del Viento">
            <div>
                <h3>Los Caminantes del Viento</h3>
                <p>Folk andin moderne avec flûtes traditionnelles, charango et influences indie.</p>
                <p><strong>Adresse :</strong> Salta, Argentine</p>
                <p><strong>Prix :</strong> 10 €</p>
            </div>
        </div>

        <!-- Ticket 3 -->
        <div class="ticket-card" data-date="2024-12-12">
           <img src="<?php echo get_template_directory_uri(); ?>/assets/images/The Neon Turtles.jpg" 
     alt="The Neon Turtles">
            <div>
                <h3>The Neon Turtles</h3>
                <p>Surf-rock alternatif aux riffs rétro et à l’énergie solaire des côtes australiennes.</p>
                <p><strong>Adresse :</strong> Melbourne, Australie</p>
                <p><strong>Prix :</strong> 10 €</p>
            </div>
        </div>

        <!-- Ticket 4 -->
        <div class="ticket-card" data-date="2023-08-27">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Cold River Saints.jpg" 
     alt="Cold River Saints">
            <div>
                <h3>Cold River Saints</h3>
                <p>Rock folk canadien avec guitares acoustiques et atmosphères hivernales.</p>
                <p><strong>Adresse :</strong> Québec, Canada</p>
                <p><strong>Prix :</strong> 10 €</p>
            </div>
        </div>

    </div>

    <a href="#" class="voir-plus">Voir plus…</a>

</div>



<style>
/* ===================== */
/*   CONTAINER + TITRES  */
/* ===================== */

.reservations-container {
    width: 85%;
    margin: 40px auto;
    font-family: inherit; /* On reprend la police Miüzy */
}

.reserv-title {
    font-size: 28px;
    margin-bottom: 25px;
    font-weight: bold;
}

/* ===================== */
/*       FILTRE TRI       */
/* ===================== */

.filter-box {
    margin-bottom: 20px;
    text-align: right;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

/* STYLE SELECT MIUZY (bleu + arrondi + flèche custom) */
.miuzy-select {
    font-family: inherit;
    color: #3D18D3;
    font-size: 16px;
    padding: 6px 35px 6px 16px;

    border: 1.5px solid #3D18D3;
    border-radius: 25px;

    background-color: transparent;
    cursor: pointer;

    appearance: none; /* remove native style */

    /* Flèche custom bleue */
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg fill='%233D18D3' height='22' viewBox='0 0 24 24' width='22' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
}

.miuzy-select:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(61,24,211,0.4);
}



/* ===================== */
/*     CARTE TICKETS     */
/* ===================== */

.ticket-card {
    display: flex;
    gap: 20px;
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.ticket-card img {
    width: 150px;
    height: 120px;
    border-radius: 10px;
    object-fit: cover;
}

.ticket-card h3 {
    margin-top: 0;
}

/* Voir plus */
.voir-plus {
    display: block;
    margin-top: 15px;
    color: black;
    font-size: 14px;
}

</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("sortTickets");
    const ticketsContainer = document.getElementById("ticketsList");

    function sortTickets(order) {
        const tickets = Array.from(document.querySelectorAll(".ticket-card"));

        tickets.sort((a, b) => {
            const dateA = new Date(a.dataset.date);
            const dateB = new Date(b.dataset.date);

            return order === "recent" ? dateB - dateA : dateA - dateB;
        });

        tickets.forEach(ticket => ticketsContainer.appendChild(ticket));
    }

    select.addEventListener("change", () => {
        sortTickets(select.value);
    });

    // tri par défaut : récentes
    sortTickets("recent");
});
</script>

<?php get_footer(); ?>
