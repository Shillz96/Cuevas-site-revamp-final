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

document.addEventListener("DOMContentLoaded", function() {
  // Prevent multiple initializations
  if (window.homeAnimationsInitialized) return;
  window.homeAnimationsInitialized = true;
  
  // Check for GSAP and plugins
  if (typeof gsap === "undefined") {
    console.error("GSAP not found!");
    return;
  }
  
  if (typeof ScrollTrigger !== "undefined") {
    gsap.registerPlugin(ScrollTrigger);
  } else {
    console.warn("ScrollTrigger not available - scrolling functionality limited");
  }
  
  if (typeof ScrollToPlugin !== "undefined") {
    gsap.registerPlugin(ScrollToPlugin);
  }
  
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
});

/**
 * Check for reduced motion preference
 */
function checkReducedMotion() {
  prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  
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
  
  if (!sections.length || typeof ScrollTrigger === "undefined") return;
  
  // Set up initial state
  sections.forEach((section, i) => {
    // Add proper ARIA attributes
    if (!section.getAttribute('role')) {
      section.setAttribute('role', 'region');
    }
    
    if (!section.getAttribute('aria-label')) {
      section.setAttribute('aria-label', section.id || `Section ${i+1}`);
    }
    
    // Create ScrollTrigger for each section
    const trigger = ScrollTrigger.create({
      trigger: section,
      start: "top top",
      end: "bottom top",
      onEnter: () => updateActiveSection(i),
      onEnterBack: () => updateActiveSection(i),
      preventOverlaps: true,
      fastScrollEnd: true,
    });
    
    scrollTriggers.push(trigger);
  });
  
  // Create main ScrollTrigger for snapping
  if (sections.length > 1) {
    const mainTrigger = ScrollTrigger.create({
      snap: {
        snapTo: (progress, self) => {
          // Find section boundaries
          const snapPoints = [];
          sections.forEach((section, i) => {
            const rect = section.getBoundingClientRect();
            const scrollTop = window.pageYOffset;
            const top = rect.top + scrollTop;
            const height = rect.height;
            
            snapPoints.push(top / (document.scrollingElement.scrollHeight - window.innerHeight));
          });
          
          // Find the closest snap point
          let closest = snapPoints[0];
          let closestDistance = Math.abs(progress - snapPoints[0]);
          
          for (let i = 1; i < snapPoints.length; i++) {
            const distance = Math.abs(progress - snapPoints[i]);
            if (distance < closestDistance) {
              closest = snapPoints[i];
              closestDistance = distance;
            }
          }
          
          return closest;
        },
        duration: { min: 0.2, max: 0.6 },
        delay: 0.1,
        ease: "power2.inOut"
      },
      // Only snap when not scrolling via programmtic navigation
      onUpdate: self => {
        if (!isScrolling && !prefersReducedMotion) {
          self.snapTo(self.progress);
        }
      }
    });
    
    scrollTriggers.push(mainTrigger);
  }
  
  // Set up navigation buttons
  setupNavigationButtons();
  
  // Set up navigation dots
  setupNavigationDots();
  
  // Set up keyboard navigation
  setupKeyboardNavigation();
  
  // Update active section initially
  setTimeout(() => updateActiveSection(0), 100);
}

/**
 * Navigate to a specific section
 * @param {number} index - Section index to navigate to
 */
function goToSection(index) {
  if (isScrolling || index < 0 || index >= sections.length) return;
  
  isScrolling = true;
  currentSection = index;
  
  // Update ARIA states
  updateAriaStates();
  
  // Scroll to section with GSAP for smooth animation
  if (!prefersReducedMotion && typeof gsap !== "undefined" && 
      typeof ScrollToPlugin !== "undefined") {
    
    gsap.to(window, {
      duration: CONFIG.ANIMATION_DURATION,
      scrollTo: {
        y: sections[index],
        offsetY: 0,
        autoKill: false
      },
      ease: CONFIG.ANIMATION_EASE,
      onComplete: () => {
        isScrolling = false;
        announceSection();
      }
    });
  } else {
    // Fallback for browsers without GSAP or reduced motion
    sections[index].scrollIntoView({ behavior: prefersReducedMotion ? 'auto' : 'smooth' });
    
    setTimeout(() => {
      isScrolling = false;
      announceSection();
    }, prefersReducedMotion ? 100 : CONFIG.ANIMATION_DURATION * 1000);
  }
  
  // Update navigation
  updateActiveSection(index, false);
}

/**
 * Update the active section
 * @param {number} index - Index of the section to make active
 * @param {boolean} scroll - Whether to scroll to the section
 */
function updateActiveSection(index, scroll = true) {
  if (index < 0 || index >= sections.length) return;
  
  currentSection = index;
  
  // Update active classes
  sections.forEach((section, i) => {
    section.classList.toggle('active', i === index);
  });
  
  // Update navigation dots
  navDots.forEach((dot, i) => {
    dot.classList.toggle('active', i === index);
    dot.setAttribute('aria-current', i === index ? 'true' : 'false');
  });
  
  // Update navigation buttons
  const prevBtn = document.querySelector('.fixed-nav-btn.prev');
  const nextBtn = document.querySelector('.fixed-nav-btn.next');
  
  if (prevBtn) {
    prevBtn.disabled = index === 0;
    prevBtn.style.opacity = index === 0 ? '0.3' : '1';
    prevBtn.setAttribute('aria-disabled', index === 0 ? 'true' : 'false');
  }
  
  if (nextBtn) {
    nextBtn.disabled = index === sections.length - 1;
    nextBtn.style.opacity = index === sections.length - 1 ? '0.3' : '1';
    nextBtn.setAttribute('aria-disabled', index === sections.length - 1 ? 'true' : 'false');
  }
  
  // Scroll to section if needed
  if (scroll && !isScrolling) {
    goToSection(index);
  }
  
  // Update ARIA states
  updateAriaStates();
}

/**
 * Set up navigation buttons
 */
function setupNavigationButtons() {
  const prevBtn = document.querySelector('.fixed-nav-btn.prev');
  const nextBtn = document.querySelector('.fixed-nav-btn.next');
  
  if (!prevBtn || !nextBtn) return;
  
  // Set initial state
  prevBtn.disabled = currentSection === 0;
  prevBtn.style.opacity = currentSection === 0 ? '0.3' : '1';
  prevBtn.setAttribute('aria-disabled', currentSection === 0 ? 'true' : 'false');
  
  nextBtn.disabled = currentSection === sections.length - 1;
  nextBtn.style.opacity = currentSection === sections.length - 1 ? '0.3' : '1';
  nextBtn.setAttribute('aria-disabled', currentSection === sections.length - 1 ? 'true' : 'false');
  
  // Add click handlers
  prevBtn.addEventListener('click', () => {
    if (currentSection > 0 && !isScrolling) {
      goToSection(currentSection - 1);
    }
  });
  
  nextBtn.addEventListener('click', () => {
    if (currentSection < sections.length - 1 && !isScrolling) {
      goToSection(currentSection + 1);
    }
  });
  
  // Add keyboard support
  prevBtn.addEventListener('keydown', e => {
    if ((e.key === 'Enter' || e.key === ' ') && !prevBtn.disabled) {
      e.preventDefault();
      goToSection(currentSection - 1);
    }
  });
  
  nextBtn.addEventListener('keydown', e => {
    if ((e.key === 'Enter' || e.key === ' ') && !nextBtn.disabled) {
      e.preventDefault();
      goToSection(currentSection + 1);
    }
  });
}

/**
 * Set up navigation dots
 */
function setupNavigationDots() {
  if (!navDots.length) return;
  
  // Set initial state
  navDots.forEach((dot, i) => {
    // Set initial ARIA attributes
    dot.setAttribute('role', 'button');
    dot.setAttribute('aria-label', `Go to ${sections[i].getAttribute('aria-label') || `Section ${i+1}`}`);
    dot.setAttribute('aria-current', i === currentSection ? 'true' : 'false');
    
    // Add click handlers
    dot.addEventListener('click', () => {
      if (!isScrolling) {
        goToSection(i);
      }
    });
    
    // Add keyboard support
    dot.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        goToSection(i);
      }
    });
  });
  
  // Add ARIA relationship
  const navContainer = navDots[0].closest('.section-nav');
  if (navContainer) {
    navContainer.setAttribute('role', 'navigation');
    navContainer.setAttribute('aria-label', 'Section navigation');
  }
}

/**
 * Set up keyboard navigation
 */
function setupKeyboardNavigation() {
  document.addEventListener('keydown', e => {
    // Skip if scrolling
    if (isScrolling) return;
    
    // Handle gallery section separately
    if (currentSection === 1 && sections[currentSection].classList.contains('gallery-section')) {
      // Gallery already has its own keyboard handling
      return;
    }
    
    // Navigation keys
    if (e.key === 'ArrowDown' || e.key === 'PageDown') {
      if (currentSection < sections.length - 1) {
        e.preventDefault();
        goToSection(currentSection + 1);
      }
    } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
      if (currentSection > 0) {
        e.preventDefault();
        goToSection(currentSection - 1);
      }
    } else if (e.key === 'Home') {
      e.preventDefault();
      goToSection(0);
    } else if (e.key === 'End') {
      e.preventDefault();
      goToSection(sections.length - 1);
    }
  });
}

/**
 * Update ARIA states for accessibility
 */
function updateAriaStates() {
  // Update section ARIA states
  sections.forEach((section, i) => {
    section.setAttribute('aria-hidden', i === currentSection ? 'false' : 'true');
  });
  
  // Update navigation dots
  navDots.forEach((dot, i) => {
    dot.setAttribute('aria-current', i === currentSection ? 'true' : 'false');
    dot.tabIndex = i === currentSection ? 0 : -1;
  });
}

/**
 * Announce current section to screen readers
 */
function announceSection() {
  const section = sections[currentSection];
  if (!section) return;
  
  const sectionName = section.getAttribute('aria-label') || 
                     section.id || 
                     `Section ${currentSection + 1}`;
  
  // Create or get live region
  let liveRegion = document.getElementById('section-announcer');
  if (!liveRegion) {
    liveRegion = document.createElement('div');
    liveRegion.id = 'section-announcer';
    liveRegion.setAttribute('aria-live', 'polite');
    liveRegion.setAttribute('aria-atomic', 'true');
    liveRegion.className = 'sr-only';
    document.body.appendChild(liveRegion);
  }
  
  // Announce section
  liveRegion.textContent = `Navigated to ${sectionName} section`;
}

/**
 * Initialize hero section animations
 */
function initHeroAnimations() {
  const heroTitle = document.querySelector('.hero-title');
  const heroSubtitle = document.querySelector('.hero-subtitle');
  const scrollIndicator = document.querySelector('.scroll-indicator');
  
  if (!heroTitle || !heroSubtitle) return;
  
  // Create timeline for coordinated animations
  const tl = gsap.timeline({
    paused: prefersReducedMotion,
    defaults: {
      duration: CONFIG.ANIMATION_DURATION,
      ease: "power2.out"
    }
  });
  
  // Add animations to timeline
  tl.from(heroTitle, {
    opacity: 0,
    y: 30
  })
  .from(heroSubtitle, {
    opacity: 0,
    y: 20
  }, "-=0.4")
  .from(scrollIndicator, {
    opacity: 0,
    y: 20
  }, "-=0.3");
  
  // Play the timeline
  tl.play();
  
  // Add scroll indicator animation and functionality
  if (scrollIndicator) {
    // Set up pulsing animation for scroll arrow
    if (!prefersReducedMotion) {
      const scrollArrow = scrollIndicator.querySelector('.scroll-arrow');
      if (scrollArrow) {
        gsap.to(scrollArrow, {
          y: 10,
          repeat: -1,
          yoyo: true,
          duration: 0.8
        });
      }
    }
    
    // Add click handler
    scrollIndicator.addEventListener('click', () => {
      if (!isScrolling) {
        goToSection(1);
      }
    });
    
    // Add keyboard support
    scrollIndicator.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        goToSection(1);
      }
    });
  }
}

/**
 * Initialize the gallery slider
 */
function initFeaturedSlider() {
  const slides = document.querySelectorAll('.slide');
  const sliderDots = document.querySelectorAll('.slider-dot');
  
  if (!slides.length) return;
  
  let currentSlide = 0;
  
  // Set up slide animations
  function goToSlide(index) {
    if (index < 0 || index >= slides.length || index === currentSlide) return;
    
    // Hide current slide
    slides[currentSlide].classList.remove('active');
    slides[currentSlide].setAttribute('aria-hidden', 'true');
    
    if (sliderDots.length) {
      sliderDots[currentSlide].classList.remove('active');
      sliderDots[currentSlide].setAttribute('aria-selected', 'false');
      sliderDots[currentSlide].tabIndex = -1;
    }
    
    // Show new slide
    currentSlide = index;
    slides[currentSlide].classList.add('active');
    slides[currentSlide].setAttribute('aria-hidden', 'false');
    
    if (sliderDots.length) {
      sliderDots[currentSlide].classList.add('active');
      sliderDots[currentSlide].setAttribute('aria-selected', 'true');
      sliderDots[currentSlide].tabIndex = 0;
    }
    
    // Announce slide change
    const liveRegion = document.getElementById('slider-announcer') || (() => {
      const el = document.createElement('div');
      el.id = 'slider-announcer';
      el.className = 'sr-only';
      el.setAttribute('aria-live', 'polite');
      document.body.appendChild(el);
      return el;
    })();
    
    liveRegion.textContent = `Slide ${currentSlide + 1} of ${slides.length}`;
  }
  
  // Set up slider dots
  sliderDots.forEach((dot, i) => {
    dot.addEventListener('click', () => goToSlide(i));
    
    // Add keyboard support
    dot.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        goToSlide(i);
      } else if (e.key === 'ArrowRight' && currentSlide < slides.length - 1) {
        e.preventDefault();
        goToSlide(currentSlide + 1);
      } else if (e.key === 'ArrowLeft' && currentSlide > 0) {
        e.preventDefault();
        goToSlide(currentSlide - 1);
      }
    });
  });
  
  // Use GSAP for slide transitions
  slides.forEach((slide, i) => {
    // Set initial state
    if (i === 0) {
      slide.classList.add('active');
      slide.setAttribute('aria-hidden', 'false');
    } else {
      slide.classList.remove('active');
      slide.setAttribute('aria-hidden', 'true');
    }
    
    // Enhance CSS transitions with GSAP for smoother animations
    if (!prefersReducedMotion) {
      slide.addEventListener('transitionend', function(e) {
        if (e.propertyName !== 'opacity' || !slide.classList.contains('active')) return;
        
        // Add subtle entrance animation after CSS transition
        gsap.fromTo(slide.querySelector('.slide-number'), 
          { opacity: 0, y: 20 },
          { opacity: 1, y: 0, duration: 0.4, ease: "power2.out" }
        );
      });
    }
  });
  
  // Check if we're in the gallery section
  const gallerySection = document.querySelector('.gallery-section');
  if (gallerySection) {
    // Handle keyboard navigation in gallery section
    gallerySection.addEventListener('keydown', e => {
      if (e.key === 'ArrowRight') {
        e.preventDefault();
        if (currentSlide < slides.length - 1) {
          goToSlide(currentSlide + 1);
        } else if (currentSection < sections.length - 1) {
          // If on last slide, go to next section
          goToSection(currentSection + 1);
        }
      } else if (e.key === 'ArrowLeft') {
        e.preventDefault();
        if (currentSlide > 0) {
          goToSlide(currentSlide - 1);
        } else if (currentSection > 0) {
          // If on first slide, go to previous section
          goToSection(currentSection - 1);
        }
      }
    });
    
    // Touch swipe support
    let touchStartX, touchStartY;
    
    gallerySection.addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].screenX;
      touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });
    
    gallerySection.addEventListener('touchend', e => {
      const touchEndX = e.changedTouches[0].screenX;
      const touchEndY = e.changedTouches[0].screenY;
      
      const deltaX = touchStartX - touchEndX;
      const deltaY = touchStartY - touchEndY;
      
      // Determine if primarily horizontal swipe
      if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > CONFIG.SWIPE_THRESHOLD) {
        if (deltaX > 0 && currentSlide < slides.length - 1) {
          // Swipe left - next slide
          goToSlide(currentSlide + 1);
        } else if (deltaX < 0 && currentSlide > 0) {
          // Swipe right - previous slide
          goToSlide(currentSlide - 1);
        }
      }
    }, { passive: true });
  }
}

/**
 * Initialize section animations
 */
function initSectionAnimations() {
  // Skip if ScrollTrigger not available or reduced motion preferred
  if (typeof ScrollTrigger === "undefined" || prefersReducedMotion) return;
  
  // Animate products section
  const productsSection = document.querySelector('#products');
  if (productsSection) {
    const productItems = productsSection.querySelectorAll('.product-item');
    
    if (productItems.length) {
      gsap.from(productItems, {
        opacity: 0,
        y: 30,
        stagger: 0.1,
        duration: 0.6,
        ease: "power2.out",
        scrollTrigger: {
          trigger: productsSection,
          start: "top 70%",
          toggleActions: "play none none reverse"
        }
      });
    }
  }
  
  // Animate shop section
  const shopSection = document.querySelector('#shop');
  if (shopSection) {
    const categoryItems = shopSection.querySelectorAll('.category-item');
    
    if (categoryItems.length) {
      gsap.from(categoryItems, {
        opacity: 0,
        y: 30,
        stagger: 0.1,
        duration: 0.6,
        ease: "power2.out",
        scrollTrigger: {
          trigger: shopSection,
          start: "top 70%",
          toggleActions: "play none none reverse"
        }
      });
    }
  }
}

/**
 * Add hidden styles for screen readers
 */
function addScreenReaderOnly() {
  const style = document.createElement('style');
  style.textContent = `
    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }
  `;
  document.head.appendChild(style);
}

/**
 * Clean up all animations and event listeners
 */
function cleanup() {
  // Revert GSAP context
  if (ctx) {
    ctx.revert();
  }
  
  // Kill all ScrollTrigger instances
  if (typeof ScrollTrigger !== "undefined") {
    scrollTriggers.forEach(trigger => {
      if (trigger && trigger.kill) {
        trigger.kill();
      }
    });
    
    ScrollTrigger.getAll().forEach(trigger => {
      trigger.kill();
    });
  }
  
  // Reset state
  window.homeAnimationsInitialized = false;
}

// Add screen reader styles
addScreenReaderOnly(); 