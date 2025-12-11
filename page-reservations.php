<?php
/* Template Name: Reservation */
get_header();
?>

<div class="reservations-container">

    <h2 class="reserv-title">Mes réservations</h2>

    <!-- FILTRE -->
    <div class="filter-box">
        <label for="sortTickets">Trier mes tickets</label>
        <select id="sortTickets">
            <option value="recent">Récentes</option>
            <option value="old">Anciennes</option>
        </select>
    </div>

    <!-- LISTE DES TICKETS -->
    <div id="ticketsList">

        <!-- Ticket 1 -->
        <div class="ticket-card" data-date="2025-02-18">
            <img src="https://via.placeholder.com/150x120" alt="Solar Veins">
            <div>
                <h3>Solar Veins</h3>
                <p>Electro–pop nordique mêlant synthés glacés, voix éthérées et rythmes inspirés des aurores boréales.</p>
                <p><strong>Adresse :</strong> Reykjavik, Islande</p>
                <p><strong>Prix :</strong> 10 €</p>
            </div>
        </div>

        <!-- Ticket 2 -->
        <div class="ticket-card" data-date="2024-11-03">
            <img src="https://via.placeholder.com/150x120" alt="Los Caminantes del Viento">
            <div>
                <h3>Los Caminantes del Viento</h3>
                <p>Folk andin moderne avec flûtes traditionnelles, charango et influences indie.</p>
                <p><strong>Adresse :</strong> Salta, Argentine</p>
                <p><strong>Prix :</strong> 10 €</p>
            </div>
        </div>

        <!-- Ticket 3 -->
        <div class="ticket-card" data-date="2024-12-12">
            <img src="https://via.placeholder.com/150x120" alt="The Neon Turtles">
            <div>
                <h3>The Neon Turtles</h3>
                <p>Surf-rock alternatif aux riffs rétro et à l’énergie solaire des côtes australiennes.</p>
                <p><strong>Adresse :</strong> Melbourne, Australie</p>
                <p><strong>Prix :</strong> 10 €</p>
            </div>
        </div>

        <!-- Ticket 4 -->
        <div class="ticket-card" data-date="2023-08-27">
            <img src="https://via.placeholder.com/150x120" alt="Cold River Saints">
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

<?php get_footer(); ?>

<style>
.reservations-container {
    width: 85%;
    margin: 40px auto;
    font-family: Arial, sans-serif;
}

.reserv-title {
    font-size: 28px;
    margin-bottom: 25px;
}

.filter-box {
    margin-bottom: 20px;
    text-align: right;
}

.filter-box select {
    padding: 6px 10px;
    border-radius: 20px;
}

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

.voir-plus {
    display: block;
    margin-top: 15px;
    color: black;
    font-size: 14px;
}

</style>