<?php
/* Template Name: Reservation */
get_header();
?>

<div class="container-wrapper">

    <h2>Mes réservations</h2>

    <!-- FILTRE -->
    <div class="filter-box">
        <label for="sortTickets">Trier mes tickets</label> 
        <select id="sortTickets" class="miuzy-select">
            <option value="recent">Récentes</option>
            <option value="old">Anciennes</option>
        </select>
    </div>

    <!-- LISTE DES TICKETS -->
    <div id="ticketsList"></div>

    <p id="no-reservation" style="display:none;">Aucune réservation.</p>

</div>


<style>
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

/* Voir plus */
.voir-plus {
    display: block;
    margin-top: 15px;
    color: black;
    font-size: 14px;
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_reservations_db') //récupérer les reservations depuis la base de données et les afficher ici
        .then(res => res.text())
        .then(html => {
            if (html.trim() === '') {
                document.getElementById('no-reservation').style.display = 'block';
            } else {
                document.getElementById('ticketsList').innerHTML = html;
            }
        });
});
</script>

<script>

document.addEventListener("DOMContentLoaded", () => { //trier
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
