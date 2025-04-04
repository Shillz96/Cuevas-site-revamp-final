/**
 * Hero Section Customization Script
 * Applies customizer settings to the hero section
 */
(function() {
    'use strict';

    function initHeroCustomizer() {
        const heroSection = document.querySelector('.hero-section');
        
        if (!heroSection) {
            return;
        }

        // Get the overlay opacity from data attribute
        const overlayOpacity = heroSection.dataset.overlayOpacity;
        
        // Set the CSS variable if opacity value exists
        if (overlayOpacity) {
            heroSection.style.setProperty('--overlay-opacity', overlayOpacity);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroCustomizer);
    } else {
        initHeroCustomizer();
    }
})(); 