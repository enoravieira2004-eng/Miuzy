<?php
/* Template Name: Panier */
get_header();
?>

<div class="container-wrapper">

    <h2>Panier</h2>
    <br/>
    <div id="panier-content"></div>
    <div class="panier-vide" id="panier-vide">
        <p>Ohoh, il me semble que c’est <strong>vide</strong> par ici.</p>
    </div>

    <div id="panier-actions" style="display:none">

        <!-- Quantité -->
        <div class="quantity-box">
            <button id="btn-minus">−</button>
            <span id="ticket-count" class="quantity-number">0</span>
            <button id="btn-plus">+</button>
        </div>

        <!-- Total -->
        <p class="total-price">
            Total : <span id="total-value">0</span> €
        </p>

        <!-- Paiement -->
        <p class="payment-title">Moyens de paiement</p>
        <div class="payment-container">
            <button class="payment-btn" onclick="openPaymentPopup('Bancontact')">Bancontact</button>
            <button class="payment-btn" onclick="openPaymentPopup('Visa')">Visa</button>
            <button class="payment-btn" onclick="openPaymentPopup('Apple Pay')">Apple Pay</button>
            <button class="payment-btn" onclick="openPaymentPopup('Google Pay')">Google Pay</button>
        </div>

    </div>

</div>

<!-- POPUP SUPPRESSION -->
<div class="popup-overlay" id="delete-popup">
    <div class="popup">
        <p>Êtes-vous sûr de vouloir supprimer cet article du panier ?</p>
        <div class="popup-actions">
            <button class="popup-cancel" id="cancel-delete">Continuer mon achat</button>
            <button class="popup-confirm" id="confirm-delete">Supprimer</button>
        </div>
    </div>
</div>

<!-- POPUP PAIEMENT -->
<div class="popup-overlay" id="payment-popup">
    <div class="popup">
        <h3>Paiement</h3>
        <p>Vous allez payer avec <strong id="payment-method"></strong>.</p>
        <div class="popup-actions">
            <button class="popup-cancel" onclick="closePaymentPopup()">Annuler</button>
            <button class="popup-confirm" onclick="confirmPayment()">Payer</button>
        </div>
    </div>
</div>

<!-- POPUP MERCI -->
<div class="popup-overlay" id="thanks-popup">
    <div class="popup">
        <h3>Merci pour votre achat 🎉</h3>
        <p>Votre paiement a bien été pris en compte.</p>
        <button class="popup-confirm" onclick="closeThanksPopup()">Continuer</button>
    </div>
</div>

<style>
/* (CSS identique au tien, inchangé) */
.btn-plus,.payment-btn{border:2px solid #3D18D3;background:none;color:#3D18D3;padding:10px 22px;border-radius:30px;cursor:pointer;transition:.2s;}
.btn-plus:hover,.payment-btn:hover{background:#3D18D3;color:#fff;}
.quantity-box{display:flex;align-items:center;gap:15px;border:2px solid #3D18D3;border-radius:30px;padding:8px 25px;width:fit-content;margin:30px 0;}
.quantity-box button{background:none;border:none;font-size:22px;color:#3D18D3;cursor:pointer;}
.total-price{font-size:20px;font-weight:bold;color:#3D18D3;}
.payment-container{display:flex;gap:20px;flex-wrap:wrap;}
.panier-vide{text-align:center;font-size:22px;margin:120px 0;}
.popup-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);justify-content:center;align-items:center;z-index:999;}
.popup{background:#fff;padding:30px;border-radius:15px;text-align:center;max-width:400px;}
.popup-actions{margin-top:25px;display:flex;justify-content:space-between;}
.popup-cancel{background:none;border:2px solid #3D18D3;color:#3D18D3;padding:10px 18px;border-radius:25px;cursor:pointer;}
.popup-confirm{background:#3D18D3;color:#fff;border:none;padding:10px 18px;border-radius:25px;cursor:pointer;}
</style>

<script>

let selectedPayment = "";
let itemToDelete = null;

const countDisplay = document.getElementById("ticket-count");
const totalDisplay = document.getElementById("total-value");

const popup = document.getElementById("delete-popup");
const paymentPopup = document.getElementById("payment-popup");
const thanksPopup = document.getElementById("thanks-popup");

const panierContent = document.getElementById("panier-content");
const panierVide = document.getElementById("panier-vide");

let quantity = 1;

document.getElementById("btn-plus").onclick = () => { // bouton +
    const max_quantity = getMaxQuantity();
    if (quantity < max_quantity) {
        quantity++;
        calculateTotal();
    }
};

document.getElementById("btn-minus").onclick = () => { // bouton - 
    if (quantity > 1) {
        quantity--;
        calculateTotal();
    }
};

function calculateTotal() { 
    let baseTotal = 0;
    let itemCount = 0;

    document.querySelectorAll('.ticket-card').forEach(card => {
        const price = parseFloat(card.dataset.price || 0);
        baseTotal += price;
        itemCount++;
    });

    document.getElementById("ticket-count").textContent = quantity;
    document.getElementById("total-value").textContent = (baseTotal * quantity).toFixed(2);
}

function getMaxQuantity() { // nombre de personne (sold out)
    const card = document.querySelector('.ticket-card');
    if (!card) return 1;

    const max = parseInt(card.dataset.max, 10);
    return isNaN(max) || max < 1 ? 1 : max;
}

// SUPPRESSION

document.getElementById("cancel-delete").onclick = () => popup.style.display = "none"; // bouton poubelle
document.getElementById("confirm-delete").onclick = () => {
    if (!itemToDelete) return;

    let panier = JSON.parse(localStorage.getItem('panier') || '{}'); 
    delete panier[itemToDelete];
    localStorage.setItem('panier', JSON.stringify(panier));

    popup.style.display = "none";
    itemToDelete = null;

    refreshPanier(); 
};

function refreshPanier() { // recharge la page pour afficher ce qu'il faut

    const panier = JSON.parse(localStorage.getItem('panier') || '{}');

    if (Object.keys(panier).length === 0) {
        panierContent.innerHTML = "";
        panierVide.style.display = "block";
        document.getElementById("panier-actions").style.display = "none";
        totalDisplay.textContent = "0";
        countDisplay.textContent = "0";
        return;
    }

    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_panier_events', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(panier)
    })
    .then(res => res.text())
    .then(html => {
        panierContent.innerHTML = html;
        calculateTotal();
    });
}


// PAIEMENT FAKE
function openPaymentPopup(method){
    selectedPayment = method;
    document.getElementById("payment-method").textContent = method;
    paymentPopup.style.display = "flex";
}

function closePaymentPopup(){
    paymentPopup.style.display = "none";
}

function confirmPayment(){    
    const panier = JSON.parse(localStorage.getItem('panier') || '{}');

    if (Object.keys(panier).length === 0) {
        alert('Panier vide');
        return;
    }

    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=save_reservations', { //garder en tant que reservation après achat
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(panier)
    })
    .then(res => res.json())
    .then(response => {

        if (!response.success) {
            alert('Erreur lors de la réservation');
            return;
        }

        // Clear basket
        localStorage.removeItem('panier');

        // Display thanks popup
        closePaymentPopup();
        thanksPopup.style.display = "flex";
    });
}

function closeThanksPopup(){
    // Redirect to reservations
    window.location.href = "<?php echo site_url('/reservation'); ?>";
}

document.addEventListener('DOMContentLoaded', () => {
    
    const panier = JSON.parse(localStorage.getItem('panier') || '{}');
    const container = document.getElementById('panier-content');
    const empty = document.getElementById('panier-vide');
    const actions = document.getElementById('panier-actions');

    if (Object.keys(panier).length === 0) {
        empty.style.display = 'block';
        actions.style.display = 'none';
        return;
    } else{
        empty.style.display = 'none';
        actions.style.display = '';
    }

    fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=get_panier_events', { //récupération des éléments du panier
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(panier)
    })
    .then(res => res.text())
    .then(html => {
        container.innerHTML = html;
        calculateTotal();

    });
});

</script>

<?php get_footer(); ?>
