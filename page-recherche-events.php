<?php
/*
Template Name: Recherche
*/
get_header();
?>

<div class="search-container">
    <h2>Réserve les meilleurs événements musicaux près de toi !</h2>

    <div class="filters">
        <!-- FILTRE LIEU -->
        <select id="filter-location">
            <option value="">Lieu</option>
            <option value="edinburgh">Écosse / Edinburgh</option>
            <option value="glasgow">Écosse / Glasgow</option>
            <option value="dublin">Irlande / Dublin</option>
        </select>

        <!-- FILTRE DATE -->
        <input type="date" id="filter-date">

        <!-- FILTRE STYLE MUSICAL -->
        <select id="filter-style">
            <option value="">Style musical</option>
            <option value="rock">Rock</option>
            <option value="folk">Folk</option>
            <option value="indie">Indie</option>
            <option value="rnb">RNB</option>
            <option value="electro">Electro</option>
        </select>

        <button id="filter-btn" class="search-btn">🔍</button>
    </div>
</div>


<!-- ZONE DES RÉSULTATS -->
<div id="results-container">
    <!-- Les résultats AJAX s’affichent ici -->
</div>

<?php get_footer(); ?>

<style>
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
    padding: 10px 18px;
    border-radius: 50%;
    background: white;
    border: 1px solid #000;
    cursor: pointer;
}

.ticket {
    display: flex;
    background: white;
    border-radius: 15px;
    padding: 15px;
    margin: 20px auto;
    width: 80%;
    align-items: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.ticket img {
    width: 120px;
    height: 120px;
    border-radius: 12px;
    object-fit: cover;
    margin-right: 20px;
}

.ticket-content {
    flex-grow: 1;
    text-align: left;
}

.ticket-actions {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.ticket-actions .fav-btn {
    font-size: 22px;
    cursor: pointer;
    margin-bottom: 12px;
    color: #d0d0d0;
    transition: 0.2s;
}

.ticket-actions .fav-btn.active {
    color: #ffb800;
}

.ticket-actions .more-btn {
    padding: 7px 15px;
    background: white;
    border: 1px solid #7a4dff;
    color: #7a4dff;
    border-radius: 18px;
    cursor: pointer;
}

</style>

<script>
document.getElementById("filter-btn").addEventListener("click", function () {

    const location = document.getElementById("filter-location").value;
    const date     = document.getElementById("filter-date").value;
    const style    = document.getElementById("filter-style").value;

    fetch(`/wp-admin/admin-ajax.php?action=search_events&location=${location}&date=${date}&style=${style}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("results-container").innerHTML = data;
        });
});


// Gestion des favoris (bouton cœur)
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("fav-btn")) {
        e.target.classList.toggle("active");
    }
});
</script>
