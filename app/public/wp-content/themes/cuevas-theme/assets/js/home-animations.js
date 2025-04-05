/**
 * Cuevas Western Wear - Home Page Animations
 * Uses GSAP for animations with accessibility and performance optimizations
 */

// Configuration constants
const CONFIG = {
  ANIMATION_DURATION: 0.8,     // Standard animation duration in seconds
  ANIMATION_EASE: 'power2.inOut', // Standard easing function
  SCROLL_COOLDOWN: 800,        // Cooldown between scroll actions (ms)
  SWIPE_THRESHOLD: 50,         // Minimum distance for swipe detection (px)
  SECTION_SNAP_POINT: "top top" // ScrollTrigger snap alignment
};

// Store ScrollTrigger instances for cleanup
const scrollTriggers = [];

// GSAP context for proper cleanup
let ctx;

// State variables
let prefersReducedMotion = false;
let currentSection = 0;
let isScrolling = false;
let sections = [];
let navDots = [];
let scrollTimeout;

// Debug mode - set to true for console logs
const DEBUG = true;

// Helper function for conditional logging
function logDebug(message, data) {
  if (DEBUG) {
    if (data) {
      console.log(`[GSAP Scroll] ${message}:`, data);
    } else {
      console.log(`[GSAP Scroll] ${message}`);
    }
  }
}

// Force log to ensure debugging is working
console.clear(); // Clear console for better debugging visibility
console.log("===== GSAP SCROLLING IMPLEMENTATION =====");
console.log("[GSAP Scroll] Script loaded and debug enabled");

document.addEventListener("DOMContentLoaded", function() {
  // Prevent multiple initializations
  if (window.homeAnimationsInitialized) {
    console.log("[GSAP Scroll] Already initialized, skipping");
    return;
  }
  window.homeAnimationsInitialized = true;

  // Initialize GSAP plugins
  gsap.registerPlugin(ScrollTrigger);
  console.log("[GSAP] Plugins registered");

  // Get elements
  const sections = gsap.utils.toArray('.section');
  const navButtons = document.querySelectorAll('.section-nav button');
  let currentSection = 0;
  let isAnimating = false;

  // Initialize sections
  sections.forEach((section, i) => {
    if (i !== 0) {
      gsap.set(section, { yPercent: 100 });
    }
    
    // Set initial content state
    const content = section.querySelector('.section-content');
    if (content) {
      gsap.set(content, { opacity: 0, y: 30 });
    }
  });

  // Show first section content
  gsap.to(sections[0].querySelector('.section-content'), {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: 'power2.out'
  });

  // Function to go to section
  function goToSection(index) {
    if (isAnimating || index === currentSection) return;
    
    isAnimating = true;
    const direction = index > currentSection ? 1 : -1;
    const current = sections[currentSection];
    const next = sections[index];
    
    console.log(`[GSAP] Moving from section ${currentSection} to ${index}`);

    // Update navigation
    navButtons.forEach((btn, i) => {
      btn.classList.toggle('active', i === index);
    });

    // Animate current section out
    gsap.to(current, {
      yPercent: -100 * direction,
      duration: 1,
      ease: 'power2.inOut'
    });

    // Animate current section content out
    gsap.to(current.querySelector('.section-content'), {
      opacity: 0,
      y: -30 * direction,
      duration: 0.5,
      ease: 'power2.in'
    });

    // Prepare next section
    gsap.set(next, { yPercent: 100 * direction });

    // Animate next section in
    gsap.to(next, {
      yPercent: 0,
      duration: 1,
      ease: 'power2.inOut',
      onComplete: () => {
        isAnimating = false;
        currentSection = index;
      }
    });

    // Animate next section content in
    gsap.fromTo(next.querySelector('.section-content'),
      { opacity: 0, y: 30 * direction },
      { 
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 0.3,
        ease: 'power2.out'
      }
    );
  }

  // Handle navigation button clicks
  navButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
      if (!isAnimating && currentSection !== index) {
        goToSection(index);
      }
    });
  });

  // Handle keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (isAnimating) return;

    if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
      e.preventDefault();
      const direction = e.key === 'ArrowUp' ? -1 : 1;
      const nextSection = Math.max(0, Math.min(sections.length - 1, currentSection + direction));
      
      if (nextSection !== currentSection) {
        goToSection(nextSection);
      }
    }
  });

  // Handle wheel events
  let wheelTimeout;
  document.addEventListener('wheel', (e) => {
    e.preventDefault();
    
    if (isAnimating) return;

    clearTimeout(wheelTimeout);
    wheelTimeout = setTimeout(() => {
      const direction = e.deltaY > 0 ? 1 : -1;
      const nextSection = Math.max(0, Math.min(sections.length - 1, currentSection + direction));
      
      if (nextSection !== currentSection) {
        goToSection(nextSection);
      }
    }, 50);
  }, { passive: false });

  // Handle touch events
  let touchStartY = 0;
  let touchEndY = 0;
  const minSwipeDistance = 50;

  document.addEventListener('touchstart', (e) => {
    touchStartY = e.touches[0].clientY;
  }, { passive: true });

  document.addEventListener('touchmove', (e) => {
    if (isAnimating) {
      e.preventDefault();
    }
  }, { passive: false });

  document.addEventListener('touchend', (e) => {
    if (isAnimating) return;

    touchEndY = e.changedTouches[0].clientY;
    const swipeDistance = touchStartY - touchEndY;

    if (Math.abs(swipeDistance) > minSwipeDistance) {
      const direction = swipeDistance > 0 ? 1 : -1;
      const nextSection = Math.max(0, Math.min(sections.length - 1, currentSection + direction));
      
      if (nextSection !== currentSection) {
        goToSection(nextSection);
      }
    }
  }, { passive: true });

  // Check for reduced motion preference
  checkReducedMotion();
  window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', checkReducedMotion);
  
  // Create GSAP context for proper cleanup in WordPress
  ctx = gsap.context(() => {
    initSmoothScrolling();
    initHeroAnimations();
    initFeaturedSlider();
    initSectionAnimations();
  });
  
  // Cleanup on page unload
  window.addEventListener("beforeunload", cleanup);
  
  logDebug("Initialization complete");
});

/**
 * Fix navigation buttons positioning
 */
function fixNavigationButtons() {
  logDebug("Fixing navigation buttons positioning");
  
  const prevBtn = document.querySelector('.fixed-nav-btn.prev');
  const nextBtn = document.querySelector('.fixed-nav-btn.next');
  
  if (prevBtn && nextBtn) {
    // Create a container if it doesn't exist
    let container = document.querySelector('.fixed-nav-buttons');
    if (!container) {
      container = document.createElement('div');
      container.className = 'fixed-nav-buttons';
      container.style.position = 'fixed';
      container.style.right = '20px';
      container.style.bottom = '20px';
      container.style.zIndex = '100';
      document.body.appendChild(container);
      
      // Move buttons to the container
      container.appendChild(prevBtn);
      container.appendChild(nextBtn);
    }
    
    // Make sure the styles are applied
    prevBtn.style.marginRight = '10px';
    prevBtn.style.padding = '10px 15px';
    nextBtn.style.padding = '10px 15px';
  }
}

/**
 * Check for reduced motion preference
 */
function checkReducedMotion() {
  prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  
  logDebug(`Reduced motion preference: ${prefersReducedMotion}`);
  
  // Adjust animations based on preference
  if (prefersReducedMotion) {
    // Kill all active ScrollTrigger animations
    if (typeof ScrollTrigger !== "undefined") {
      ScrollTrigger.getAll().forEach(trigger => {
        trigger.kill();
      });
    }
    
    // Apply immediate styles without animations
    document.querySelectorAll('.hero-title, .hero-subtitle, .scroll-indicator').forEach(el => {
      gsap.set(el, { opacity: 1, y: 0, clearProps: 'transform' });
    });
  }
  
  return prefersReducedMotion;
}

/**
 * Initialize smooth scrolling with section snapping
 */
function initSmoothScrolling() {
  // Get all sections
  sections = document.querySelectorAll('.section');
  navDots = document.querySelectorAll('.nav-dot');
  
  logDebug(`Found ${sections.length} sections and ${navDots.length} navigation dots`);
  
  if (!sections.length || typeof ScrollTrigger === "undefined") {
    logDebug("No sections found or ScrollTrigger not available");
    return;
  }
  
  // Calculate section positions for snapping
  const sectionPositions = [];
  sections.forEach((section, i) => {
    // Add proper ARIA attributes
    if (!section.getAttribute('role')) {
      section.setAttribute('role', 'region');
    }
    
    if (!section.getAttribute('aria-label')) {
      section.setAttribute('aria-label', section.id || `Section ${i+1}`);
    }
    
    // Store section position for snap function
    const rect = section.getBoundingClientRect();
    const scrollTop = window.pageYOffset;
    const top = rect.top + scrollTop;
    
    sectionPositions.push(top);
    
    // Create ScrollTrigger for each section
    const trigger = ScrollTrigger.create({
      trigger: section,
      start: "top center",
      end: "bottom center",
      onEnter: () => updateActiveSection(i),
      onEnterBack: () => updateActiveSection(i),
      preventOverlaps: true,
      fastScrollEnd: true,
      markers: DEBUG // Add markers in debug mode
    });
    
    scrollTriggers.push(trigger);
  });
  
  logDebug(`Created ${scrollTriggers.length} section triggers`);
  logDebug(`Section positions for snapping:`, sectionPositions);
  
  // Create main ScrollTrigger for snapping
  if (sections.length > 1) {
    // Fix body scrolling
    document.body.style.overflow = "auto";
    document.documentElement.style.scrollBehavior = prefersReducedMotion ? "auto" : "smooth";
    
    const mainTrigger = ScrollTrigger.create({
      start: 0,
      end: "max",
      snap: {
        snapTo: (progress, self) => {
          const scrollTop = window.pageYOffset;
          const docHeight = document.documentElement.scrollHeight - window.innerHeight;
          
          // Find closest section
          let closest = 0;
          let closestDistance = Math.abs(scrollTop - sectionPositions[0]);
          
          for (let i = 1; i < sectionPositions.length; i++) {
            const distance = Math.abs(scrollTop - sectionPositions[i]);
            if (distance < closestDistance) {
              closest = i;
              closestDistance = distance;
            }
          }
          
          logDebug(`Snapping to section ${closest}`);
          return sectionPositions[closest] / docHeight;
        },
        duration: { min: 0.2, max: 0.5 },
        delay: 0.1,
        ease: CONFIG.ANIMATION_EASE
      },
      markers: DEBUG // Add markers in debug mode
    });
    
    scrollTriggers.push(mainTrigger);
    logDebug("Created main snap trigger");
  }
  
  // Set up navigation buttons
  setupNavigationButtons();
  
  // Set up navigation dots
  setupNavigationDots();
  
  // Set up keyboard navigation
  setupKeyboardNavigation();
  
  // Update active section initially
  setTimeout(() => updateActiveSection(0), 100);
  
  logDebug("Smooth scrolling initialized");
}

/**
 * Update which section is currently active
 * @param {number} index - Index of the active section
 * @param {boolean} preventScroll - If true, don't scroll to the section
 */
function updateActiveSection(index, preventScroll = true) {
  if (index < 0 || index >= sections.length) return;
  
  logDebug(`Updating active section to ${index}${preventScroll ? ' (without scrolling)' : ''}`);
  
  currentSection = index;
  
  // Update active class on sections
  sections.forEach((section, i) => {
    section.classList.toggle('active', i === index);
  });
  
  // Update active class on navigation dots
  navDots.forEach((dot, i) => {
    const isActive = i === index;
    dot.classList.toggle('active', isActive);
    dot.setAttribute('aria-current', isActive ? 'true' : 'false');
  });
  
  // Update ARIA states
  updateAriaStates();
  
  // Scroll to the section if needed
  if (!preventScroll) {
    goToSection(index);
  }
}

/**
 * Navigate to a specific section
 * @param {number} index - Section index to navigate to
 */
function goToSection(index) {
  if (isScrolling || index < 0 || index >= sections.length) return;
  
  logDebug(`Navigating to section ${index}`);
  isScrolling = true;
  currentSection = index;
  
  // Update ARIA states
  updateAriaStates();
  
  // Get the target section and its position
  const targetSection = sections[index];
  const rect = targetSection.getBoundingClientRect();
  const scrollTop = window.pageYOffset;
  const targetPosition = rect.top + scrollTop;
  
  // Scroll to section with GSAP for smooth animation
  if (!prefersReducedMotion && typeof gsap !== "undefined" && 
      typeof ScrollToPlugin !== "undefined") {
    
    logDebug("Using ScrollToPlugin for smooth scrolling");
    gsap.to(window, {
      duration: CONFIG.ANIMATION_DURATION,
      scrollTo: {
        y: targetPosition,
        autoKill: false
      },
      ease: CONFIG.ANIMATION_EASE,
      onComplete: () => {
        isScrolling = false;
        announceSection();
        logDebug(`Completed scrolling to section ${index}`);
      }
    });
  } else {
    // Fallback for browsers without GSAP or reduced motion
    logDebug("Using native scrollIntoView fallback");
    window.scrollTo({
      top: targetPosition,
      behavior: prefersReducedMotion ? 'auto' : 'smooth'
    });
    
    setTimeout(() => {
      isScrolling = false;
      announceSection();
      logDebug(`Completed scrolling to section ${index} with fallback`);
    }, prefersReducedMotion ? 100 : CONFIG.ANIMATION_DURATION * 1000);
  }
  
  // Update navigation
  updateActiveSection(index, true);
}

/**
 * Update ARIA states for accessibility
 */
function updateAriaStates() {
  logDebug("Updating ARIA states");
  
  // Update navigation buttons state
  const prevBtn = document.querySelector('.fixed-nav-btn.prev');
  const nextBtn = document.querySelector('.fixed-nav-btn.next');
  
  if (prevBtn) {
    const isFirst = currentSection === 0;
    prevBtn.setAttribute('aria-disabled', isFirst ? 'true' : 'false');
    prevBtn.setAttribute('tabindex', isFirst ? '-1' : '0');
    // Visual indication
    prevBtn.style.opacity = isFirst ? '0.5' : '1';
  }
  
  if (nextBtn) {
    const isLast = currentSection === sections.length - 1;
    nextBtn.setAttribute('aria-disabled', isLast ? 'true' : 'false');
    nextBtn.setAttribute('tabindex', isLast ? '-1' : '0');
    // Visual indication
    nextBtn.style.opacity = isLast ? '0.5' : '1';
  }
  
  logDebug(`Navigation buttons updated: first=${currentSection === 0}, last=${currentSection === sections.length - 1}`);
}

/**
 * Announce current section to screen readers
 */
function announceSection() {
  const announcer = document.getElementById('section-announcer');
  if (!announcer) {
    // Create announcer if it doesn't exist
    const newAnnouncer = document.createElement('div');
    newAnnouncer.id = 'section-announcer';
    newAnnouncer.className = 'sr-only';
    newAnnouncer.setAttribute('aria-live', 'polite');
    newAnnouncer.setAttribute('aria-atomic', 'true');
    newAnnouncer.style.position = 'absolute';
    newAnnouncer.style.width = '1px';
    newAnnouncer.style.height = '1px';
    newAnnouncer.style.padding = '0';
    newAnnouncer.style.margin = '-1px';
    newAnnouncer.style.overflow = 'hidden';
    newAnnouncer.style.clip = 'rect(0, 0, 0, 0)';
    newAnnouncer.style.whiteSpace = 'nowrap';
    newAnnouncer.style.border = '0';
    document.body.appendChild(newAnnouncer);
    
    logDebug("Created section announcer for accessibility");
    return;
  }
  
  const section = sections[currentSection];
  if (!section) return;
  
  const sectionName = section.getAttribute('aria-label') || 
                     section.querySelector('h1, h2, h3')?.textContent || 
                     `Section ${currentSection + 1}`;
  
  announcer.textContent = `Navigated to ${sectionName}`;
  logDebug(`Announced section: "${announcer.textContent}"`);
}

/**
 * Set up navigation buttons for moving between sections
 */
function setupNavigationButtons() {
  const prevBtn = document.querySelector('.fixed-nav-btn.prev');
  const nextBtn = document.querySelector('.fixed-nav-btn.next');
  
  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      if (currentSection > 0) {
        logDebug("Previous button clicked");
        goToSection(currentSection - 1);
      }
    });
  }
  
  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      if (currentSection < sections.length - 1) {
        logDebug("Next button clicked");
        goToSection(currentSection + 1);
      }
    });
  }
  
  logDebug(`Navigation buttons initialized: prev=${!!prevBtn}, next=${!!nextBtn}`);
}

/**
 * Set up navigation dots for jumping to specific sections
 */
function setupNavigationDots() {
  navDots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      logDebug(`Navigation dot ${i} clicked`);
      goToSection(i);
    });
    
    // Add proper ARIA attributes
    dot.setAttribute('role', 'button');
    dot.setAttribute('aria-label', `Go to section ${i+1}`);
    dot.setAttribute('tabindex', '0');
    
    // Add keyboard support
    dot.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        logDebug(`Navigation dot ${i} activated by keyboard`);
        goToSection(i);
      }
    });
  });
  
  logDebug(`Navigation dots initialized: count=${navDots.length}`);
}

/**
 * Set up keyboard navigation for sections
 */
function setupKeyboardNavigation() {
  document.addEventListener('keydown', (e) => {
    // Only handle if not in an input field
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || 
        e.target.isContentEditable) {
      return;
    }
    
    if (e.key === 'ArrowDown' || e.key === 'PageDown') {
      if (currentSection < sections.length - 1) {
        e.preventDefault();
        logDebug("Keyboard navigation: down arrow");
        goToSection(currentSection + 1);
      }
    } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
      if (currentSection > 0) {
        e.preventDefault();
        logDebug("Keyboard navigation: up arrow");
        goToSection(currentSection - 1);
      }
    } else if (e.key === 'Home') {
      e.preventDefault();
      logDebug("Keyboard navigation: home key");
      goToSection(0);
    } else if (e.key === 'End') {
      e.preventDefault();
      logDebug("Keyboard navigation: end key");
      goToSection(sections.length - 1);
    }
  });
  
  logDebug("Keyboard navigation initialized");
}

/**
 * Initialize hero section animations
 */
function initHeroAnimations() {
  if (prefersReducedMotion) {
    logDebug("Skipping hero animations due to reduced motion preference");
    return;
  }
  
  const hero = document.querySelector('.hero-section');
  if (!hero) {
    logDebug("Hero section not found");
    return;
  }
  
  const title = hero.querySelector('.hero-title');
  const subtitle = hero.querySelector('.hero-subtitle');
  const scrollIndicator = hero.querySelector('.scroll-indicator');
  
  const tl = gsap.timeline();
  
  if (title) {
    tl.from(title, {
      y: 30, 
      opacity: 0, 
      duration: CONFIG.ANIMATION_DURATION, 
      ease: CONFIG.ANIMATION_EASE
    });
  }
  
  if (subtitle) {
    tl.from(subtitle, {
      y: 20, 
      opacity: 0, 
      duration: CONFIG.ANIMATION_DURATION, 
      ease: CONFIG.ANIMATION_EASE
    }, "-=0.3");
  }
  
  if (scrollIndicator) {
    tl.from(scrollIndicator, {
      opacity: 0, 
      duration: CONFIG.ANIMATION_DURATION
    }, "-=0.2");
    
    // Create pulse animation for scroll indicator
    gsap.to(scrollIndicator, {
      y: 10,
      opacity: 0.7, 
      duration: 1.5, 
      repeat: -1, 
      yoyo: true, 
      ease: "power1.inOut"
    });
    
    // Fix missing SVG
    const downArrow = scrollIndicator.querySelector('i.fa-chevron-down');
    if (!downArrow) {
      const arrowIcon = document.createElement('i');
      arrowIcon.className = 'fas fa-chevron-down';
      scrollIndicator.appendChild(arrowIcon);
    }
    
    // Add click handler to go to next section
    scrollIndicator.addEventListener('click', () => {
      if (currentSection < sections.length - 1) {
        goToSection(currentSection + 1);
      }
    });
  }
  
  logDebug("Hero animations initialized");
}

/**
 * Initialize animations for the featured slider
 */
function initFeaturedSlider() {
  const slider = document.querySelector('.featured-slider');
  if (!slider) {
    logDebug("Featured slider not found");
    return;
  }
  
  const slides = slider.querySelectorAll('.slide');
  if (!slides.length) {
    logDebug("No slides found in featured slider");
    return;
  }
  
  logDebug(`Featured slider initialized with ${slides.length} slides`);
  
  // Set up initial state
  gsap.set(slides, { opacity: 0, x: 30 });
  gsap.set(slides[0], { opacity: 1, x: 0 });
  
  // Handle slider navigation
  const nextBtn = slider.querySelector('.slider-next');
  const prevBtn = slider.querySelector('.slider-prev');
  
  let currentSlide = 0;
  
  function goToSlide(index) {
    if (index < 0) index = slides.length - 1;
    if (index >= slides.length) index = 0;
    
    logDebug(`Transitioning to slide ${index}`);
    
    gsap.to(slides[currentSlide], {
      opacity: 0, 
      x: -30, 
      duration: 0.5, 
      ease: "power2.inOut"
    });
    
    gsap.fromTo(slides[index], 
      { opacity: 0, x: 30 },
      { opacity: 1, x: 0, duration: 0.5, ease: "power2.inOut" }
    );
    
    currentSlide = index;
    
    // Update ARIA attributes
    slides.forEach((slide, i) => {
      slide.setAttribute('aria-hidden', i !== index ? 'true' : 'false');
    });
  }
  
  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      logDebug("Slider next button clicked");
      goToSlide(currentSlide + 1);
    });
  }
  
  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      logDebug("Slider previous button clicked");
      goToSlide(currentSlide - 1);
    });
  }
  
  // Set up auto-rotation if more than one slide
  if (slides.length > 1 && !prefersReducedMotion) {
    let sliderInterval = setInterval(() => {
      goToSlide(currentSlide + 1);
    }, 5000);
    
    // Pause on hover
    slider.addEventListener('mouseenter', () => {
      logDebug("Slider hover - pausing auto-rotation");
      clearInterval(sliderInterval);
    });
    
    slider.addEventListener('mouseleave', () => {
      logDebug("Slider hover end - resuming auto-rotation");
      clearInterval(sliderInterval);
      sliderInterval = setInterval(() => {
        goToSlide(currentSlide + 1);
      }, 5000);
    });
  }
}

/**
 * Initialize animations for each section
 */
function initSectionAnimations() {
  if (prefersReducedMotion) {
    logDebug("Skipping section animations due to reduced motion preference");
    return;
  }
  
  if (typeof ScrollTrigger === "undefined") {
    logDebug("ScrollTrigger not available - skipping section animations");
    return;
  }
  
  logDebug("Initializing section animations");
  
  sections.forEach((section, index) => {
    if (index === 0) return; // Skip hero section, already animated
    
    const heading = section.querySelector('h1, h2, h3');
    const content = section.querySelectorAll('p, .btn, .card, .product-card, img:not(.bg-image)');
    
    if (!heading && (!content || !content.length)) return;
    
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
        onEnter: () => logDebug(`Section ${index} animation triggered`),
        markers: DEBUG
      }
    });
    
    if (heading) {
      tl.from(heading, {
        y: 30,
        opacity: 0,
        duration: CONFIG.ANIMATION_DURATION,
        ease: CONFIG.ANIMATION_EASE
      });
    }
    
    if (content && content.length) {
      tl.from(content, {
        y: 30,
        opacity: 0,
        duration: CONFIG.ANIMATION_DURATION,
        ease: CONFIG.ANIMATION_EASE,
        stagger: 0.1
      }, "-=0.4");
    }
  });
}

/**
 * Clean up all GSAP animations and event listeners
 */
function cleanup() {
  logDebug("Cleaning up GSAP animations and events");
  
  // Kill all ScrollTriggers
  if (scrollTriggers.length && typeof ScrollTrigger !== "undefined") {
    scrollTriggers.forEach(trigger => trigger.kill());
  }
  
  // Kill all GSAP animations
  if (ctx) {
    ctx.revert();
  }
  
  // Remove event listeners
  window.removeEventListener("beforeunload", cleanup);
  
  logDebug("Cleanup complete");
} 