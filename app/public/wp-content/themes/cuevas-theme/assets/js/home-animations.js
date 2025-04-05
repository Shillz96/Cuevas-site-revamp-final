/**
 * Cuevas Western Wear - Home Page Animations
 * Modular implementation of fullscreen section-based layout with GSAP animations
 */

// Configuration object
const CONFIG = {
    debug: false,
    breakpoints: {
        mobile: 768,
        tablet: 992,
        desktop: 1200
    },
    animation: {
        duration: 0.8,
        ease: "power2.inOut",
        stagger: 0.2
    },
    gallery: {
        maxScrolls: 4,
        autoplayDelay: 5000
    }
};

// State management
const State = {
    sections: [],
    navButtons: [],
    currentSection: 0,
    isAnimating: false,
    isScrolling: false,
    touchStartY: 0,
    lastScrollTime: 0,
    windowHeight: window.innerHeight,
    windowWidth: window.innerWidth,
    isMobile: window.innerWidth < CONFIG.breakpoints.mobile,
    isTablet: window.innerWidth < CONFIG.breakpoints.tablet && window.innerWidth >= CONFIG.breakpoints.mobile,
    prefersReducedMotion: false,
    galleryInterval: null
};

// Utility functions
const Utils = {
    log(message, data) {
        if (CONFIG.debug) {
            console.log(`[GSAP] ${message}${data ? ':' : ''}`, data || '');
        }
    },

    debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    },

    checkReducedMotion() {
        const query = window.matchMedia('(prefers-reduced-motion: reduce)');
        State.prefersReducedMotion = query.matches;
        query.addEventListener('change', () => {
            State.prefersReducedMotion = query.matches;
            Animations.updateSettings();
        });
    },

    updateDeviceClasses() {
        if (document.body) {
            document.body.classList.toggle('is-mobile', State.isMobile);
            document.body.classList.toggle('is-tablet', State.isTablet);
            document.body.classList.toggle('reduced-motion', State.prefersReducedMotion);
        }
    },

    safeQuerySelector(selector) {
        try {
            return document.querySelector(selector);
        } catch (e) {
            Utils.log('Error in querySelector:', e);
            return null;
        }
    },

    safeQuerySelectorAll(selector) {
        try {
            return Array.from(document.querySelectorAll(selector) || []);
        } catch (e) {
            Utils.log('Error in querySelectorAll:', e);
            return [];
        }
    }
};

// Animation controller
const Animations = {
    ctx: null,

    init() {
        if (typeof gsap === "undefined") {
            console.error("GSAP is not loaded");
            return;
        }

        this.registerPlugins();
        this.setupDefaults();
        this.createContext();
    },

    registerPlugins() {
        if (typeof ScrollTrigger !== "undefined") {
            gsap.registerPlugin(ScrollTrigger);
        }
        if (typeof ScrollToPlugin !== "undefined") {
            gsap.registerPlugin(ScrollToPlugin);
        }
    },

    setupDefaults() {
        gsap.config({
            nullTargetWarn: false,
            autoSleep: 60,
            force3D: true
        });

        if (typeof ScrollTrigger !== "undefined") {
            ScrollTrigger.config({
                autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load,resize'
            });
        }
    },

    createContext() {
        try {
            this.ctx = gsap.context(() => {
                this.initUtilityFunctions();
                // Initialize core components after context is created
                Lifecycle.init();
                Navigation.init();
                // Gallery.init(); // Commented out old gallery init
                Responsive.init();
                Animations.updateSettings(); // Apply initial settings based on preference
                this.setupSectionAnimations(); // Setup initial section animations
                this.setupHorizontalGalleryScroll(); // ADDED: Setup new horizontal scroll gallery
            });
        } catch (e) {
            console.error("Error creating GSAP context:", e);
        }
    },

    initUtilityFunctions() {
        window.createStaggerAnimation = (elements, fromVars = {}, toVars = {}) => {
            if (!elements) return;

            return gsap.from(elements, {
                ...CONFIG.animation,
                ...fromVars,
                scrollTrigger: {
                    trigger: elements,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse',
                    ...toVars.scrollTrigger
                }
            });
        };

        window.createTextReveal = (element, options = {}) => {
            if (!element) return;

            return gsap.from(element, {
                duration: CONFIG.animation.duration,
                ease: CONFIG.animation.ease,
                y: 20,
                opacity: 0,
                ...options,
                scrollTrigger: {
                    trigger: element,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse',
                    ...options.scrollTrigger
                }
            });
        };
    },

    updateSettings() {
        const duration = State.prefersReducedMotion ? 0.1 : CONFIG.animation.duration;
        gsap.defaults({ duration, ease: "none" });
    },

    cleanup() {
        if (this.ctx) {
            this.ctx.revert();
        }
        if (State.galleryInterval) {
            clearInterval(State.galleryInterval);
        }
    },

    setupHorizontalGalleryScroll() {
        const gallerySection = Utils.safeQuerySelector('#section-gallery');
        const slider = Utils.safeQuerySelector('.gallery-slider');
        const slides = Utils.safeQuerySelectorAll('.gallery-slide');

        if (!gallerySection || !slider || slides.length <= 1) {
            Utils.log('Horizontal gallery elements not found or insufficient slides.');
            return;
        }

        const numSlides = slides.length;
        const singleSlideWidth = slides[0].offsetWidth; // Get width of a single slide

        Utils.log(`Setting up horizontal gallery scroll for ${numSlides} slides.`);

        let tl = gsap.timeline({
            scrollTrigger: {
                trigger: gallerySection,
                pin: true,
                scrub: 1, // Smooth scrubbing
                snap: {
                    snapTo: 1 / (numSlides - 1), // Snap to the start of each slide section
                    duration: { min: 0.2, max: 0.5 }, // Snap animation duration
                    delay: 0.1,
                    ease: "power1.inOut"
                },
                // Make the scroll distance longer to require multiple scrolls per slide
                // End after scrolling the equivalent distance of (numSlides - 1) slides' width
                // Or use a multiplier like 300% for 3 extra viewport scrolls
                end: "+=300%", // Alternative: Use viewport height multiplier
                invalidateOnRefresh: true, // Recalculate on resize/refresh
                markers: CONFIG.debug // Show markers if debug mode is true
            }
        });

        // Animate the slider horizontally based on the number of slides
        tl.to(slider, {
            xPercent: -100 * (numSlides - 1), // Move slider leftwards
            ease: "none" // Linear ease for scrub effect
        });

        Utils.log('Horizontal gallery scroll timeline created.');
    }
};

// Section navigation controller
const Navigation = {
    init() {
        this.setupSections();
        this.setupNavigation();
        this.setupEventListeners();
    },

    setupSections() {
        State.sections = Utils.safeQuerySelectorAll('.section');
        State.navButtons = Utils.safeQuerySelectorAll('.section-nav button');

        if (State.sections.length === 0) {
            console.error("No sections found");
    return;
  }
  
        this.activateFirstSection();
    },

    activateFirstSection() {
        const firstSection = State.sections[0];
        if (firstSection) {
            gsap.set(firstSection, { 
                y: 0, 
                opacity: 1, 
                visibility: "visible",
                display: "block"
            });

            firstSection.classList.add('active');
            if (State.navButtons[0]) {
                State.navButtons[0].classList.add('active');
            }
        }
    },

    setupNavigation() {
        State.navButtons.forEach((button, index) => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                if (!State.isAnimating && State.currentSection !== index) {
                    this.navigateToSection(index);
                }
            });
        });
    },

    setupEventListeners() {
        // Wheel event
        window.addEventListener('wheel', (e) => {
            e.preventDefault();
            this.handleScrollInput(e.deltaY > 0 ? 1 : -1);
        }, { passive: false });

        // Touch events
        document.addEventListener('touchstart', (e) => {
            if (e.touches?.[0]) {
                State.touchStartY = e.touches[0].clientY;
            }
        }, { passive: true });

        document.addEventListener('touchend', (e) => {
            if (!e.changedTouches?.[0]) return;
            
            const touchEndY = e.changedTouches[0].clientY;
            const deltaY = State.touchStartY - touchEndY;
            
            if (Math.abs(deltaY) > 50) {
                this.handleScrollInput(deltaY > 0 ? 1 : -1);
            }
        }, { passive: true });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                this.handleScrollInput(e.key === 'ArrowDown' ? 1 : -1);
            }
        });
    },

    handleScrollInput(direction) {
        const now = Date.now();
        if (!State.isScrolling && now - State.lastScrollTime > 800) {
            State.isScrolling = true;
            State.lastScrollTime = now;
            
            const nextSection = State.currentSection + direction;
            if (nextSection >= 0 && nextSection < State.sections.length) {
                this.navigateToSection(nextSection);
            } else {
                setTimeout(() => {
                    State.isScrolling = false;
                }, 200);
            }
        }
    },

    navigateToSection(index) {
        if (State.isAnimating || index === State.currentSection || 
            !State.sections?.[index]) return;

        State.isAnimating = true;
        const prevSection = State.currentSection;
        State.currentSection = index;

        this.updateNavigation(index);
        this.animateSectionTransition(prevSection, index);
    },

    updateNavigation(index) {
        State.navButtons.forEach((btn, i) => {
            btn.classList.toggle('active', i === index);
        });
    },

    animateSectionTransition(prevSection, newSection) {
        const outDirection = newSection > prevSection ? -1 : 1;
        const inDirection = newSection > prevSection ? 1 : -1;

        // Animate out current section
        gsap.to(State.sections[prevSection], {
            y: State.windowHeight * outDirection * -1,
            duration: State.prefersReducedMotion ? 0.1 : 0.8,
            ease: "power2.inOut",
      onComplete: () => {
                gsap.set(State.sections[prevSection], { 
                    y: State.windowHeight * inDirection 
                });
            }
        });

        // Animate in new section
        gsap.fromTo(State.sections[newSection],
            { y: State.windowHeight * inDirection },
            { 
                y: 0, 
                duration: State.prefersReducedMotion ? 0.1 : 0.8,
                ease: "power2.inOut",
                onComplete: () => {
                    this.onTransitionComplete(newSection);
                }
            }
        );
    },

    onTransitionComplete(index) {
        State.sections.forEach((section, i) => {
            section.classList.toggle('active', i === index);
        });

        if (!State.prefersReducedMotion) {
            this.animateSectionContent(index);
        }

        State.isAnimating = false;
        setTimeout(() => {
            State.isScrolling = false;
        }, 200);
    },

    animateSectionContent(index) {
        const section = State.sections[index];
  if (!section) return;
  
        const slideElements = section.querySelectorAll('.slide-up');
        if (slideElements.length) {
            gsap.to(slideElements, {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.15,
                ease: "power2.out"
            });
        }

        const fadeElements = section.querySelectorAll('.fade-in');
        if (fadeElements.length) {
            gsap.to(fadeElements, {
                opacity: 1,
                duration: 0.7,
                stagger: 0.1,
                ease: "power1.out"
            });
        }
    }
};

// Responsive handling
const Responsive = {
    init() {
        this.setupResizeHandler();
        this.setupOrientationHandler();
        Utils.updateDeviceClasses();
    },

    setupResizeHandler() {
        window.addEventListener('resize', Utils.debounce(() => {
            State.windowHeight = window.innerHeight;
            State.windowWidth = window.innerWidth;
            State.isMobile = State.windowWidth < CONFIG.breakpoints.mobile;
            State.isTablet = State.windowWidth < CONFIG.breakpoints.tablet && State.windowWidth >= CONFIG.breakpoints.mobile;

            this.repositionSections();
            Utils.updateDeviceClasses();
        }, 200));
    },

    setupOrientationHandler() {
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                State.windowHeight = window.innerHeight;
                State.windowWidth = window.innerWidth;
                this.repositionSections();
                Utils.updateDeviceClasses();
            }, 200);
        });
    },

    repositionSections() {
        State.sections.forEach((section, index) => {
            if (index === State.currentSection) {
                gsap.set(section, { y: 0 });
            } else if (index < State.currentSection) {
                gsap.set(section, { y: -State.windowHeight });
            } else {
                gsap.set(section, { y: State.windowHeight });
    }
  });
}
};

// Initialize everything
document.addEventListener("DOMContentLoaded", () => {
    Utils.checkReducedMotion();
    Animations.init();
    Navigation.init();
    // Gallery.init();
    Responsive.init();
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    Animations.cleanup();
}); 