document.addEventListener("DOMContentLoaded", function() {

    const burger = document.getElementById("burgerBtn");
    const mobileMenu = document.getElementById("mobileMenu");

    burger.addEventListener("click", function () {
        mobileMenu.classList.toggle("active");
        burger.classList.toggle("open");
    });

});
