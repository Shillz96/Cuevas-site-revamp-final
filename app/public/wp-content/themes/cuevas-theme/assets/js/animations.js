/**
 * Main Animations for Cuevas Western Wear Theme
 * Handles scrolling behavior, entrance animations, and section transitions
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing animations and scrolling behavior');
    
    // Add CSS for smooth scrolling transitions
    const style = document.createElement('style');
    style.textContent = `
        body.is-animated-scrolling {
            overflow: hidden !important;
        }
        
        .split-slideshow.transitioning {
            pointer-events: none !important;
        }
        
        /* Only hide section indicators created in previous page loads */
        .section-nav-indicators:not(.current-indicators) {
            display: none !important;
        }
    `;
    document.head.appendChild(style);
    
    // Remove any existing indicators from previous page loads - gentle approach
    document.querySelectorAll('.section-nav-indicators').forEach(function(indicator) {
        // Add a data attribute to mark for removal
        indicator.setAttribute('data-obsolete', 'true');
    });
    
    // Check if GSAP exists before trying to run animations
    if (typeof gsap === 'undefined') {
        console.warn('GSAP not loaded, animations disabled');
        return;
    }
    
    // Register necessary plugins
    initializePlugins();
    
    // Initialize page behavior based on page type
    if (document.body.classList.contains('home') || document.body.classList.contains('page-template-front-page')) {
        // Only run on homepage/front page
        console.log('Homepage detected, initializing section scrolling');
        initializePageScrolling();
    } else {
        // For all other pages
        console.log('Regular page detected, initializing basic animations');
        initializeBasicAnimations();
    }
    
    // Initialize common animations
    initializeHeaderBehavior();
    initializeEntranceAnimations();
    initializeSmoothScroll();
});

/**
 * Register GSAP plugins
 */
function initializePlugins() {
    // Register ScrollTrigger plugin if available
    if (typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        console.log('ScrollTrigger registered successfully');
    } else {
        console.warn('ScrollTrigger not available, some animations disabled');
    }
    
    // Register ScrollToPlugin if available
    if (typeof ScrollToPlugin !== 'undefined') {
        gsap.registerPlugin(ScrollToPlugin);
        console.log('ScrollToPlugin registered successfully');
    } else {
        console.warn('ScrollToPlugin not available, smooth scrolling may not work');
    }
}

/**
 * Initialize smooth scrolling and section snapping for the homepage
 */
function initializePageScrolling() {
    // Remove obsolete indicators, but keep the existing ones that might still be in use
    document.querySelectorAll('.section-nav-indicators[data-obsolete="true"]').forEach(function(indicator) {
        indicator.remove();
    });
    
    // Get all homepage sections
    const sections = document.querySelectorAll('.homepage-section');
    
    // Hide footer if present (as requested)
    const footer = document.querySelector('.site-footer');
    if (footer) {
        footer.style.display = 'none';
    }
    
    // Exit if no sections found
    if (!sections || sections.length < 2) {
        console.warn('Not enough sections found for section scrolling');
        return;
    }
    
    console.log(`Found ${sections.length} homepage sections`);
    
    // Find the slideshow section specifically
    const slideshowSection = document.querySelector('.split-slideshow');
    const slideshowIndex = slideshowSection ? Array.from(sections).indexOf(slideshowSection) : -1;
    
    console.log(`Slideshow is section #${slideshowIndex + 1}`);
    
    // Only create section indicators if they don't already exist
    let indicatorContainer = document.querySelector('.section-nav-indicators:not([data-obsolete="true"])');
    if (!indicatorContainer) {
        indicatorContainer = createSectionIndicators(sections);
    }
    
    // Setup section navigation system
    setupSectionNavigation(sections, slideshowIndex, indicatorContainer);
    
    // Setup keyboard navigation
    setupKeyboardNavigation();
    
    // Setup touch/swipe navigation for mobile
    setupTouchNavigation();
}

/**
 * Setup section navigation system
 */
function setupSectionNavigation(sections, slideshowIndex, indicatorContainer) {
    // Determine current section based on scroll position
    function getCurrentSectionIndex() {
        const scrollPosition = window.scrollY;
        
        for (let i = 0; i < sections.length; i++) {
            const section = sections[i];
            const sectionTop = section.offsetTop - 100; // Some tolerance
            const sectionBottom = sectionTop + section.offsetHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                return i;
            }
        }
        
        return 0; // Default to first section if not found
    }
    
    // Function to move to a specific section
    window.moveToSection = function(index) {
        if (index < 0 || index >= sections.length) return;
        
        console.log(`Moving to section ${index + 1}`);
        
        // Prevent any ongoing animations from interfering
        document.body.classList.add('is-animated-scrolling');
        
        // Scroll to target section
        gsap.to(window, {
            duration: 1, 
            scrollTo: {
                y: sections[index],
                offsetY: 0,
                autoKill: false
            },
            ease: "power3.out",
            onComplete: function() {
                // Update active section indicator
                updateActiveSection(index);
                
                // Wait a bit before allowing more scrolling to prevent accidental scrolls
                setTimeout(function() {
                    document.body.classList.remove('is-animated-scrolling');
                    
                    // If we moved to slideshow section, reset it to first slide
                    if (index === slideshowIndex && window.splitSlideshow && typeof window.splitSlideshow.goToSlide === 'function') {
                        console.log('Resetting slideshow to first slide');
                        window.splitSlideshow.goToSlide(0);
                    }
                }, 300);
            }
        });
    };
    
    // Function to move to next section
    window.moveToNextSection = function() {
        const currentIndex = getCurrentSectionIndex();
        if (currentIndex < sections.length - 1) {
            moveToSection(currentIndex + 1);
        }
    };
    
    // Function to move to previous section
    window.moveToPrevSection = function() {
        const currentIndex = getCurrentSectionIndex();
        if (currentIndex > 0) {
            moveToSection(currentIndex - 1);
        }
    };
    
    // Update active section indicator
    function updateActiveSection(index) {
        if (!indicatorContainer) return;
        
        const indicators = indicatorContainer.querySelectorAll('.section-indicator');
        
        indicators.forEach(function(indicator, i) {
            if (i === index) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }
    
    // Handle wheel-based scrolling
    function handleScrolling(event) {
        // Do nothing if we're in an animation transition
        if (document.body.classList.contains('is-animated-scrolling')) {
            event.preventDefault();
            return;
        }
        
        // Get current section
        const currentSectionIndex = getCurrentSectionIndex();
        
        // Special handling for slideshow section
        if (slideshowIndex >= 0 && currentSectionIndex === slideshowIndex) {
            // Let the slideshow handle its own internal scrolling
            return;
        }
        
        // General section scrolling
        if (event.deltaY > 0) {
            // Scrolling down - go to next section
            if (currentSectionIndex < sections.length - 1) {
                event.preventDefault();
                moveToSection(currentSectionIndex + 1);
            }
        } else if (event.deltaY < 0) {
            // Scrolling up - go to previous section
            if (currentSectionIndex > 0) {
                event.preventDefault();
                moveToSection(currentSectionIndex - 1);
            }
        }
    }
    
    // Use a safer way to remove/add event listeners
    const scrollHandlerRef = function(e) { handleScrolling(e); };
    window.removeEventListener('wheel', scrollHandlerRef);
    window.addEventListener('wheel', scrollHandlerRef, { passive: false });
    
    // Initial update of active section
    updateActiveSection(getCurrentSectionIndex());
}

/**
 * Setup keyboard navigation for section scrolling
 */
function setupKeyboardNavigation() {
    function handleKeyDown(event) {
        // Ignore if in input field
        if (event.target.tagName.toLowerCase() === 'input' || 
            event.target.tagName.toLowerCase() === 'textarea' || 
            event.target.isContentEditable) {
            return;
        }
        
        // Skip if already animating
        if (document.body.classList.contains('is-animated-scrolling')) {
            return;
        }
        
        // Arrow down or Page Down
        if (event.key === 'ArrowDown' || event.key === 'PageDown') {
            event.preventDefault();
            window.moveToNextSection();
        }
        
        // Arrow up or Page Up
        if (event.key === 'ArrowUp' || event.key === 'PageUp') {
            event.preventDefault();
            window.moveToPrevSection();
        }
        
        // Home key - go to first section
        if (event.key === 'Home') {
            event.preventDefault();
            window.moveToSection(0);
        }
        
        // End key - go to last section
        if (event.key === 'End') {
            event.preventDefault();
            const sections = document.querySelectorAll('.homepage-section');
            window.moveToSection(sections.length - 1);
        }
    }

    // Remove any existing handlers then add ours
    const keyDownHandlerRef = function(e) { handleKeyDown(e); };
    document.removeEventListener('keydown', keyDownHandlerRef);
    document.addEventListener('keydown', keyDownHandlerRef);
}

/**
 * Setup touch/swipe navigation for mobile devices
 */
function setupTouchNavigation() {
    // Only initialize if we have jQuery
    if (typeof jQuery === 'undefined') return;
    
    // Remove existing handlers first
    jQuery('body').off('touchstart.sectionNav touchend.sectionNav');
    
    let touchStartY = 0;
    const minSwipeDistance = 100; // Minimum distance required for a swipe
    
    // Add swipe event handlers to body
    jQuery('body').on('touchstart.sectionNav', function(event) {
        // Skip if in animated scrolling mode
        if (document.body.classList.contains('is-animated-scrolling')) return;
        
        // Store the start position
        touchStartY = event.originalEvent.touches[0].clientY;
    });
    
    jQuery('body').on('touchend.sectionNav', function(event) {
        // Skip if in animated scrolling mode
        if (document.body.classList.contains('is-animated-scrolling')) return;
        
        // Store the end position
        const touchEndY = event.originalEvent.changedTouches[0].clientY;
        
        // Calculate the distance
        const swipeDistance = touchEndY - touchStartY;
        
        // Check if the swipe was long enough
        if (Math.abs(swipeDistance) < minSwipeDistance) return;
        
        // Handle the swipe
        if (swipeDistance > 0) {
            // Swipe down - go to previous section
            window.moveToPrevSection();
        } else {
            // Swipe up - go to next section
            window.moveToNextSection();
        }
    });
}

/**
 * Create visual indicators for sections
 * Returns the indicator container for later reference
 */
function createSectionIndicators(sections) {
    // Create container for indicators
    const indicatorContainer = document.createElement('div');
    indicatorContainer.className = 'section-nav-indicators current-indicators';
    
    // Style for indicators
    const style = document.createElement('style');
    style.textContent = `
        .section-nav-indicators.current-indicators {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 8px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.1);
        }
        .section-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            border: 2px solid rgba(139, 69, 19, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .section-indicator:hover {
            transform: scale(1.2);
            background: rgba(255, 255, 255, 0.8);
        }
        .section-indicator.active {
            background: rgba(139, 69, 19, 0.9);
            transform: scale(1.3);
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        @media (max-width: 768px) {
            .section-nav-indicators.current-indicators {
                right: 10px;
                gap: 12px;
                padding: 6px;
            }
            .section-indicator {
                width: 10px;
                height: 10px;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Add indicator for each section
    sections.forEach(function(section, index) {
        const indicator = document.createElement('div');
        indicator.className = 'section-indicator';
        indicator.setAttribute('title', `Section ${index + 1}`);
        indicator.setAttribute('data-section-index', index);
        indicator.addEventListener('click', function() {
            window.moveToSection(index);
        });
        
        indicatorContainer.appendChild(indicator);
    });
    
    document.body.appendChild(indicatorContainer);
    
    // Return the container for later reference
    return indicatorContainer;
}

/**
 * Initialize basic animations for non-homepage pages
 */
function initializeBasicAnimations() {
    // Only run if GSAP is available
    if (typeof gsap === 'undefined') return;
    
    try {
        // Animate headings with fade in
        const headings = document.querySelectorAll('h1, h2.section-title');
        if (headings && headings.length > 0) {
            gsap.from(headings, {
                opacity: 0,
                y: 30,
                duration: 1,
                stagger: 0.2,
                ease: 'power3.out'
            });
        }

        // Animate images with fade and scale
        const images = document.querySelectorAll('.fade-in-image, .wp-post-image');
        if (images && images.length > 0) {
            gsap.from(images, {
                opacity: 0,
                scale: 0.95,
                y: 30,
                duration: 0.8,
                stagger: 0.2,
                ease: 'power3.out'
            });
        }

        // Animate buttons with hover effect
        const buttons = document.querySelectorAll('.wp-block-button__link, .woocommerce-button, .button');
        if (buttons && buttons.length > 0) {
            buttons.forEach(function(button) {
                button.addEventListener('mouseenter', function() {
                    gsap.to(this, {
                        scale: 1.05,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
                
                button.addEventListener('mouseleave', function() {
                    gsap.to(this, {
                        scale: 1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });
            });
        }
    } catch (error) {
        console.error('Error in basic animations:', error);
    }
}

/**
 * Initialize entrance animations for homepage sections and elements
 */
function initializeEntranceAnimations() {
    // Only run if GSAP is available
    if (typeof gsap === 'undefined') return;
    
    try {
        // Animation for hero section elements
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            const heroTitle = heroSection.querySelector('.hero-title');
            const heroSubtitle = heroSection.querySelector('.hero-subtitle');
            const heroButton = heroSection.querySelector('.hero-button');
            
            // Create timeline for hero elements
            const tl = gsap.timeline({ delay: 0.5 });
            
            if (heroTitle) {
                tl.from(heroTitle, {
                    opacity: 0,
                    y: 50,
                    duration: 1,
                    ease: "power3.out"
                });
            }
            
            if (heroSubtitle) {
                tl.from(heroSubtitle, {
                    opacity: 0,
                    y: 30,
                    duration: 1,
                    ease: "power3.out"
                }, "-=0.6");
            }
            
            if (heroButton) {
                tl.from(heroButton, {
                    opacity: 0,
                    y: 20,
                    duration: 0.8,
                    ease: "power3.out"
                }, "-=0.4");
            }
        }
        
        // Animate featured products section
        animateSection('.featured-products-section');
        
        // Animate shop categories section
        animateSection('.shop-categories-section');
    } catch (error) {
        console.error('Error in entrance animations:', error);
    }
}

/**
 * Create animation for a section
 */
function animateSection(selector) {
    const section = document.querySelector(selector);
    if (!section) return;
    
    const title = section.querySelector('.section-title');
    const subtitle = section.querySelector('.section-subtitle');
    const grid = section.querySelector('.products-grid, .categories-grid');
    const items = grid ? grid.querySelectorAll('.product-card, .category-card') : [];
    
    // Create timeline with ScrollTrigger
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: section,
            start: 'top 75%',
            toggleActions: 'play none none none',
            once: true
        }
    });
    
    // Animate title
    if (title) {
        tl.from(title, {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: "power3.out"
        });
    }
    
    // Animate subtitle
    if (subtitle) {
        tl.from(subtitle, {
            opacity: 0,
            y: 20,
            duration: 0.8,
            ease: "power3.out"
        }, "-=0.5");
    }
    
    // Animate grid
    if (grid) {
        tl.from(grid, {
            opacity: 0,
            duration: 0.6
        }, "-=0.3");
    }
    
    // Animate grid items with stagger
    if (items.length > 0) {
        tl.from(items, {
            opacity: 0,
            y: 30,
            duration: 0.8,
            stagger: 0.15,
            ease: "power3.out"
        }, "-=0.3");
    }
}

/**
 * Initialize header scroll behavior
 */
function initializeHeaderBehavior() {
    const header = document.querySelector('.site-header');
    if (!header) return;
    
    try {
        // Make header background opaque on scroll
        function updateHeaderOnScroll() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
        
        // Remove existing handlers first
        window.removeEventListener('scroll', updateHeaderOnScroll);
        window.addEventListener('scroll', updateHeaderOnScroll);
        
        // Animate header elements
        const logo = header.querySelector('.custom-logo');
        const menuItems = header.querySelectorAll('.primary-menu > li');
        
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
        
        // Manually trigger the scroll event to set initial state
        window.dispatchEvent(new Event('scroll'));
    } catch (error) {
        console.error('Error in header animations:', error);
    }
}

/**
 * Initialize smooth scrolling for anchor links
 */
function initializeSmoothScroll() {
    // Only add smooth scroll if GSAP exists
    if (typeof gsap === 'undefined') return;
    
    try {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (!href || href === '#') return;
                
                const target = document.querySelector(href);
                if (!target) return;
                
                e.preventDefault();
                
                // Use ScrollToPlugin if available
                if (typeof ScrollToPlugin !== 'undefined') {
                    gsap.to(window, {
                        duration: 1,
                        scrollTo: {
                            y: target,
                            offsetY: 50
                        },
                        ease: 'power3.out'
                    });
                } else {
                    // Fallback to native scroll
                    const offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 50;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    } catch (error) {
        console.error('Error in smooth scroll:', error);
    }
}