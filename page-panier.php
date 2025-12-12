<?php
/* Template Name: Panier */
get_header();
?>

<div class="panier-wrapper">

    <h1>Panier</h1>

    <!-- --------------------------
        FAUX TICKET (modifiable)
    --------------------------- -->
    <div class="ticket-card">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/The shamrock howlers.jpg" 
     alt="The Shamrock Howlers">

        <div class="ticket-info">
            <h3>The Shamrock Howlers</h3>
            <p>Né dans un port battu par les vents écossais, ce trio rock mêle riffs fougueux et énergie rugueuse...</p>

            <p><strong>Adresse :</strong> Edinburgh, Écosse</p>
            <p><strong>Prix :</strong> 13 £</p>

            <button class="btn-plus">Voir plus</button>
        </div>
    </div>


    <!-- --------------------------
          QUANTITY SELECTOR
    --------------------------- -->
    <div class="quantity-box">
        <button id="btn-minus">−</button>
        <span id="ticket-count" class="quantity-number">0</span>
        <button id="btn-plus">+</button>
    </div>


    <!-- --------------------------
          PAYMENT METHODS
    --------------------------- -->
    <p class="payment-title">Moyens de paiement</p>

    <div class="payment-container">
        <button class="payment-btn">Bancontact</button>
        <button class="payment-btn">Visa</button>
        <button class="payment-btn">Apple Pay</button>
        <button class="payment-btn">Google Pay</button>
    </div>

</div>

<style>
/* --- CONTAINER --- */
.panier-wrapper{
    width: 90%;
    max-width: 1200px;
    margin: 60px auto;
    font-family: Arial, sans-serif;
}

/* --- TICKET CARD --- */
.ticket-card{
    background: #fff;
    border: 1px solid #d9d9ff;
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

.ticket-info h3{
    margin: 0;
    font-size: 22px;
}

.ticket-info p{
    margin: 5px 0;
}

/* --- BUTTON: VOIR PLUS --- */
.btn-plus{
    background: none;
    border: 1px solid #7b5cff;
    color: #7b5cff;
    padding: 8px 18px;
    border-radius: 20px;
    cursor: pointer;
    transition: .2s;
}

.btn-plus:hover{
    background: #7b5cff;
    color: #fff;
}

/* --- QUANTITY BUTTONS --- */
.quantity-box{
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid #dadada;
    border-radius: 20px;
    padding: 5px 15px;
    width: fit-content;
}

.quantity-box button{
    border: none;
    background: none;
    cursor: pointer;
    font-size: 20px;
}

.quantity-number{
    font-size: 18px;
    width: 20px;
    text-align: center;
}

/* --- PAYMENT METHODS --- */
.payment-title{
    font-size: 22px;
    font-weight: bold;
    margin-top: 50px;
}

.payment-container{
    display: flex;
    gap: 25px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.payment-btn{
    border: 1px solid #7b5cff;
    color: #7b5cff;
    background: none;
    padding: 12px 30px;
    border-radius: 25px;
    font-size: 16px;
    cursor: pointer;
    transition: .2s;
}

.payment-btn:hover{
    background: #7b5cff;
    color: #fff;
}
</style>


<script>
/* -----------------------------
   SYSTEME + / -  (max 5)
----------------------------- */
let count = 0;
const countDisplay = document.getElementById("ticket-count");
const btnMinus = document.getElementById("btn-minus");
const btnPlus = document.getElementById("btn-plus");

btnPlus.addEventListener("click", () => {
    if(count < 5){
        count++;
        countDisplay.textContent = count;
    }
});

btnMinus.addEventListener("click", () => {
    if(count > 0){
        count--;
        countDisplay.textContent = count;
    }
});
</script>

<?php get_footer(); ?>
