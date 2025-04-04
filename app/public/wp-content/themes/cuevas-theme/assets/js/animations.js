/**
 * Global animations for Cuevas Western Wear theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize common animations
    initializeCommonAnimations();
    
    // Initialize header animations
    initializeHeaderAnimations();
    
    // Initialize footer animations
    initializeFooterAnimations();
});

/**
 * Initialize common animations used across the site
 */
function initializeCommonAnimations() {
    // Animate headings with text reveal
    const headings = document.querySelectorAll('h1, h2.section-title');
    headings.forEach(heading => {
        createTextReveal(heading, {
            y: 50,
            opacity: 0,
            duration: 1
        });
    });

    // Animate images with fade and scale
    const images = document.querySelectorAll('.fade-in-image');
    createStaggerAnimation(images, {
        opacity: 0,
        scale: 0.95,
        y: 30
    });

    // Animate buttons with hover effect
    const buttons = document.querySelectorAll('.wp-block-button__link, .woocommerce-button');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
        
        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
    });
}

/**
 * Initialize header animations
 */
function initializeHeaderAnimations() {
    const header = document.querySelector('.site-header');
    const logo = header.querySelector('.custom-logo');
    const menuItems = header.querySelectorAll('.primary-menu > li');
    
    // Header scroll animation
    ScrollTrigger.create({
        start: 'top -100',
        onUpdate: (self) => {
            const scrolled = self.getVelocity() > 0;
            gsap.to(header, {
                yPercent: scrolled ? -100 : 0,
                duration: 0.3,
                ease: 'power3.out'
            });
        }
    });

    // Initial header animation
    gsap.from(header, {
        y: -100,
        opacity: 0,
        duration: 1,
        ease: 'power3.out'
    });

    // Logo animation
    gsap.from(logo, {
        scale: 0.8,
        opacity: 0,
        duration: 1,
        delay: 0.2,
        ease: 'power3.out'
    });

    // Menu items stagger animation
    gsap.from(menuItems, {
        y: -20,
        opacity: 0,
        duration: 0.5,
        stagger: 0.1,
        delay: 0.5,
        ease: 'power3.out'
    });
}

/**
 * Initialize footer animations
 */
function initializeFooterAnimations() {
    const footer = document.querySelector('.site-footer');
    const footerWidgets = footer.querySelectorAll('.widget');
    
    // Animate footer widgets on scroll
    createStaggerAnimation(footerWidgets, {
        y: 50,
        opacity: 0
    }, {
        scrollTrigger: {
            trigger: footer,
            start: 'top 80%'
        }
    });
}

/**
 * Utility function to check if element is in viewport
 */
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

/**
 * Handle smooth scroll to anchor links
 */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            gsap.to(window, {
                duration: 1,
                scrollTo: {
                    y: target,
                    offsetY: 100
                },
                ease: 'power3.inOut'
            });
        }
    });
}); 