<?php if ( ! is_page_template('template-login.php') && ! is_page_template('template-register.php') ) : ?>
<footer class="miuzy-footer">
    <div class="container">
        <div class="row text-center text-md-start align-items-center">

            <!-- COLONNE 1 : LOGO -->
            <div class="col-md-3">
                <div class="logo">
                    <img
                        src="<?php echo get_template_directory_uri(); ?>/assets/image/logo_miuzy.svg"
                        alt="Logo Miuzy"
                        class="logo-img"
                    >
                </div>
            </div>

            <div class="col-md-3">
                <div class="footer-legal">
                    <p>Conditions générales</p>
                    <p>Politique de confidentialité</p>
                </div>
            </div>

            <!-- COLONNE 2 : RÉSEAUX SOCIAUX -->
            <div class="col-md-3 text-center">
                <p>Suivez nos réseaux sociaux</p>

                <div class="social-icons">
                    <a href="#" aria-label="Facebook">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/facebook.svg" alt="Facebook">
                    </a>

                    <a href="#" aria-label="Instagram">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/instagram.svg" alt="Instagram">
                    </a>

                    <a href="#" aria-label="YouTube">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/youtube.svg" alt="YouTube">
                    </a>

                    <a href="#" aria-label="X">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/image/tiktok.svg" alt="X">
                    </a>
                </div>
            </div>

            <!-- COLONNE 3 : CONTACT -->
            <div class="col-md-3">
                <p><strong>Contactez-nous</strong></p>
                <p>Rue de la poste<br>+32 412 34 56 78</p>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>

</div>

<?php wp_footer(); ?>

</div> <!-- /site-wrapper -->

</body>
</html>
