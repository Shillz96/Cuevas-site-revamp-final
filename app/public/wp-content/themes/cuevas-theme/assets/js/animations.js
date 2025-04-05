/**
 * Global animations for Cuevas Western Wear theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if GSAP exists before trying to run animations
    if (typeof gsap === 'undefined') {
        console.warn('GSAP not loaded, animations disabled');
        return;
    }
    
    // Define createTextReveal globally if it doesn't exist
    if (typeof window.createTextReveal === 'undefined') {
        window.createTextReveal = function(element, options = {}) {
            if (!element) return;
            
            // Simple fallback if SplitText isn't available
            return gsap.from(element, {
                opacity: 0,
                y: options.y || 20,
                duration: options.duration || 0.8,
                ease: "power2.out",
                scrollTrigger: options.scrollTrigger
            });
        };
    }
    
    // Define createStaggerAnimation globally if it doesn't exist
    if (typeof window.createStaggerAnimation === 'undefined') {
        window.createStaggerAnimation = function(elements, fromVars = {}, toVars = {}) {
            if (!elements || elements.length === 0) return;
            
            return gsap.from(elements, {
                opacity: 0,
                y: 20,
                duration: 0.8,
                stagger: 0.2,
                ease: "power2.out",
                ...fromVars,
                scrollTrigger: {
                    trigger: elements,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse',
                    ...toVars.scrollTrigger
                }
            });
        };
    }
    
    // Initialize animations
    try {
        // Initialize common animations
        initializeCommonAnimations();
        
        // Initialize header animations
        initializeHeaderAnimations();
        
        // Initialize footer animations
        initializeFooterAnimations();
    } catch (error) {
        console.error('Error initializing animations:', error);
    }
});

/**
 * Initialize common animations used across the site
 */
function initializeCommonAnimations() {
    // Safely check for GSAP
    if (typeof gsap === 'undefined') return;
    
    try {
        // Animate headings with text reveal
        const headings = document.querySelectorAll('h1, h2.section-title');
        headings.forEach(heading => {
            if (typeof createTextReveal === 'function') {
                createTextReveal(heading, {
                    y: 50,
                    opacity: 0,
                    duration: 1
                });
            }
        });

        // Animate images with fade and scale
        const images = document.querySelectorAll('.fade-in-image');
        if (typeof createStaggerAnimation === 'function' && images.length > 0) {
            createStaggerAnimation(images, {
                opacity: 0,
                scale: 0.95,
                y: 30
            });
        }

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
    } catch (error) {
        console.error('Error in common animations:', error);
    }
}

/**
 * Initialize header animations
 */
function initializeHeaderAnimations() {
    // Safely check for GSAP and required elements
    if (typeof gsap === 'undefined') return;
    
    const header = document.querySelector('.site-header');
    if (!header) return;
    
    try {
        const logo = header.querySelector('.custom-logo');
        const menuItems = header.querySelectorAll('.primary-menu > li');
        
        // Header scroll animation - only if ScrollTrigger exists
        if (typeof ScrollTrigger !== 'undefined') {
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
        }

        // Initial header animation
        gsap.from(header, {
            y: -100,
            opacity: 0,
            duration: 1,
            ease: 'power3.out'
        });

        // Logo animation (if logo exists)
        if (logo) {
            gsap.from(logo, {
                scale: 0.8,
                opacity: 0,
                duration: 1,
                delay: 0.2,
                ease: 'power3.out'
            });
        }

        // Menu items stagger animation (if menu items exist)
        if (menuItems.length > 0) {
            gsap.from(menuItems, {
                y: -20,
                opacity: 0,
                duration: 0.5,
                stagger: 0.1,
                delay: 0.5,
                ease: 'power3.out'
            });
        }
    } catch (error) {
        console.error('Error in header animations:', error);
    }
}

/**
 * Initialize footer animations
 */
function initializeFooterAnimations() {
    // Safely check for GSAP and required elements
    if (typeof gsap === 'undefined') return;
    
    const footer = document.querySelector('.site-footer');
    if (!footer) return;
    
    try {
        const footerWidgets = footer.querySelectorAll('.widget');
        
        // Only animate if footer widgets exist and createStaggerAnimation is defined
        if (footerWidgets.length > 0 && typeof createStaggerAnimation === 'function') {
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
    } catch (error) {
        console.error('Error in footer animations:', error);
    }
}

/**
 * Utility function to check if element is in viewport
 */
function isInViewport(element) {
    if (!element) return false;
    
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
document.addEventListener('DOMContentLoaded', function() {
    // Only add smooth scroll if GSAP exists
    if (typeof gsap === 'undefined') return;
    
    try {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (!href || href === '#') return;
                
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    // Use ScrollToPlugin if available
                    if (typeof ScrollToPlugin !== 'undefined') {
                        gsap.to(window, {
                            duration: 1,
                            scrollTo: {
                                y: target,
                                offsetY: 100
                            },
                            ease: 'power3.inOut'
                        });
                    } else {
                        // Fallback to native smooth scroll
                        target.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    } catch (error) {
        console.error('Error in smooth scroll:', error);
    }
}); 