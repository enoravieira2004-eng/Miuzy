<?php

/**
 * Template Name: Info
 */

get_header();
?>

<main class="event-container"> 
    <div class="event-content">
        <div class="event-row">
            <!-- Image Section -->
            <div class="image-section">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/The shamrock howlers.jpg" alt="The Shamrock Howlers" class="event-image">
                
                <!-- Dropdown Menu -->
                <div class="dropdown-menu-custom">
                    <button class="dots-button" id="dropdownBtn">⋮</button>
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="#" id="favoriBtn">
                            <i class="far fa-heart"></i> Favoris
                        </a>
                        <a href="#" id="signalerBtn">
                            <i class="fas fa-flag"></i> Signaler
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-section">
                <h1 class="event-title">The Shamrock Howlers</h1>

                <div class="info-item">
                    <span class="info-label">Style :</span>
                    <span class="info-text">Rock écossais</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Ville d'origine :</span>
                    <span class="info-text">Highlands (Écosse)</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Membres :</span>
                    <ul class="members-list">
                        <li>Tomas – batterie</li>
                        <li>Fiona – chanteuse, basse</li>
                        <li>Liam – guitare électrique</li>
                    </ul>
                </div>

                <div class="histoire-section">
                    <p class="info-label">Histoire :</p>
                    <p class="info-text">
                        Il est né dans une petite ville écossaise. Deux amis passionnés de guitare et de batterie rencontrent Fiona, une chanteuse au talent brut. Ils forment un trio et répètent dans un vieux hangar près du port. Leur premier morceau, inspiré par les paysages écossais, séduit vite le public.
                    </p>
                    <p class="info-text">
                        Ils enchaînent concerts et festivals locaux avec énergie et passion. Rapidement, The Shamrock Howlers deviennent un groupe de rock incontournable.
                    </p>
                </div>

                <div class="event-details">
                    <p><strong>Date :</strong> 5/12/2025</p>
                    <p><strong>Adresse :</strong> 2-8 High St, Edinburgh EH11TB, Écosse.</p>
                    <p><strong>Prix :</strong> 13 £</p>
                </div>

                <button class="panier-btn">Panier</button>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>