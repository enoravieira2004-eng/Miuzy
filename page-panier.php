<?php
/* Template Name: Panier */
get_header();
?>

<div class="panier-wrapper">

    <h1>Panier</h1>

    <!-- =====================
        CONTENU PANIER
    ====================== -->
    <div id="panier-content">

        <div class="ticket-card" id="ticket-item">

            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/The shamrock howlers.jpg" 
            alt="The Shamrock Howlers">

            <div class="ticket-info">
                <h3>The Shamrock Howlers</h3>
                <p>Né dans un port battu par les vents écossais, ce trio rock mêle riffs fougueux et énergie rugueuse...</p>

                <p><strong>Adresse :</strong> Edinburgh, Écosse</p>
                <p><strong>Prix :</strong> <span id="ticket-price">13</span> £</p>

                <button class="btn-plus">Voir plus</button>
            </div>

            <button class="delete-btn" id="delete-ticket">🗑️</button>
        </div>

        <!-- Quantité -->
        <div class="quantity-box">
            <button id="btn-minus">−</button>
            <span id="ticket-count" class="quantity-number">0</span>
            <button id="btn-plus">+</button>
        </div>

        <!-- Total -->
        <p class="total-price">
            Total : <span id="total-value">0</span> £
        </p>

        <!-- Paiement -->
        <p class="payment-title">Moyens de paiement</p>
        <div class="payment-container">
            <button class="payment-btn">Bancontact</button>
            <button class="payment-btn">Visa</button>
            <button class="payment-btn">Apple Pay</button>
            <button class="payment-btn">Google Pay</button>
        </div>

    </div>


    <!-- =====================
        PANIER VIDE
    ====================== -->
    <div class="panier-vide" id="panier-vide">
        <p>Ohoh, il me semble que c’est <strong>vide</strong> par ici.</p>
    </div>

</div>


<!-- =====================
        POPUP CONFIRMATION
====================== -->
<div class="popup-overlay" id="popup">
    <div class="popup">
        <p>Êtes-vous sûr de vouloir supprimer cet article du panier ?</p>
        <div class="popup-actions">
            <button class="popup-cancel" id="cancel-delete">Continuer mon achat</button>
            <button class="popup-confirm" id="confirm-delete">Supprimer</button>
        </div>
    </div>
</div>


<style>
.panier-wrapper{
    width: 90%;
    max-width: 1200px;
    margin: 60px auto;
    font-family: Arial, sans-serif;
}

.ticket-card{
    background: #fff;
    border: 1px solid #e6e0ff;
    padding: 20px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    margin-bottom: 40px;
}

.ticket-card img{
    width: 120px;
    height: 120px;
    border-radius: 12px;
    object-fit: cover;
}

.btn-plus,
.payment-btn{
    border: 2px solid #3D18D3;
    background: none;
    color: #3D18D3;
    padding: 10px 22px;
    border-radius: 30px;
    cursor: pointer;
    transition: .2s;
}

.btn-plus:hover,
.payment-btn:hover{
    background: #3D18D3;
    color: #fff;
}

.delete-btn{
    margin-left: auto;
    background: none;
    border: none;
    font-size: 26px;
    cursor: pointer;
    color: #000;
}

.quantity-box{
    display: flex;
    align-items: center;
    gap: 15px;
    border: 2px solid #3D18D3;
    border-radius: 30px;
    padding: 8px 25px;
    width: fit-content;
    margin: 30px 0;
}

.quantity-box button{
    background: none;
    border: none;
    font-size: 22px;
    color: #3D18D3;
    cursor: pointer;
}

.total-price{
    font-size: 20px;
    font-weight: bold;
    color: #3D18D3;
}

.payment-container{
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

/* PANIER VIDE */
.panier-vide{
    display: none;
    text-align: center;
    font-size: 22px;
    margin: 120px 0;
}

/* POPUP */
.popup-overlay{
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.4);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.popup{
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    max-width: 400px;
}

.popup-actions{
    margin-top: 25px;
    display: flex;
    justify-content: space-between;
}

.popup-cancel{
    background: none;
    border: 2px solid #3D18D3;
    color: #3D18D3;
    padding: 10px 18px;
    border-radius: 25px;
    cursor: pointer;
}

.popup-confirm{
    background: #3D18D3;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 25px;
    cursor: pointer;
}
</style>


<script>
let count = 0;
const price = 13;

const countDisplay = document.getElementById("ticket-count");
const totalDisplay = document.getElementById("total-value");

const popup = document.getElementById("popup");
const deleteBtn = document.getElementById("delete-ticket");
const cancelBtn = document.getElementById("cancel-delete");
const confirmBtn = document.getElementById("confirm-delete");

const panierContent = document.getElementById("panier-content");
const panierVide = document.getElementById("panier-vide");

document.getElementById("btn-plus").onclick = () => {
    if(count < 5){ count++; update(); }
};

document.getElementById("btn-minus").onclick = () => {
    if(count > 0){ count--; update(); }
};

function update(){
    countDisplay.textContent = count;
    totalDisplay.textContent = count * price;
}

// ouvrir popup
deleteBtn.onclick = () => {
    popup.style.display = "flex";
};

// continuer achat
cancelBtn.onclick = () => {
    popup.style.display = "none";
};

// supprimer
confirmBtn.onclick = () => {
    popup.style.display = "none";
    panierContent.style.display = "none";
    panierVide.style.display = "block";
};
</script>

<?php get_footer(); ?>
