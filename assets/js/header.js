document.addEventListener("DOMContentLoaded", function () {

    const burger = document.getElementById("burgerBtn");
    const mobileMenu = document.getElementById("mobileMenu");

    // Ouvrir / fermer le menu
    burger.addEventListener("click", function () {
        mobileMenu.classList.toggle("active");
        burger.classList.toggle("open");
        document.body.classList.toggle("no-scroll"); // Empêche le scroll
    });

    // Fermer quand on clique sur un lien du menu
    mobileMenu.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", () => {
            mobileMenu.classList.remove("active");
            burger.classList.remove("open");
            document.body.classList.remove("no-scroll");
        });
    });

    // Fermer quand on clique en dehors du menu
    document.addEventListener("click", function (e) {
        if (!mobileMenu.contains(e.target) && !burger.contains(e.target)) {
            mobileMenu.classList.remove("active");
            burger.classList.remove("open");
            document.body.classList.remove("no-scroll");
        }
    });

});
