/**
 * Cuevas Western Wear - Home Page Animations
 * Uses GSAP and ScrollTrigger for scroll-based animations
 */

// Wait until DOM is ready
document.addEventListener("DOMContentLoaded", function() {
  console.log("DOM loaded - GSAP animations initializing");
  
  // Register GSAP plugins
  gsap.registerPlugin(ScrollTrigger, SplitText, ScrollToPlugin);
  
  // Wait until all images, scripts, and assets are loaded
  window.addEventListener("load", function() {
    console.log("Window loaded - starting animations");
    initFullPageAnimations();
  });
});

/**
 * Initialize all animations for the full page layout
 */
function initFullPageAnimations() {
  // Initialize hero section animations
  initHeroSection();
  
  // Initialize featured product slider
  initFeaturedSlider();
  
  // Initialize section animations
  initSectionAnimations();
}

/**
 * Hero section text and element animations
 */
function initHeroSection() {
  console.log("Initializing hero section");
  
  // Split text for animation
  const heroTitle = document.querySelector('.hero-title');
  const heroSubtitle = document.querySelector('.hero-subtitle');
  
  if (heroTitle && heroSubtitle) {
    // Create split text instances
    const titleSplit = new SplitText(heroTitle, {
      type: "chars,words", 
      charsClass: "title-char"
    });
    
    const subtitleSplit = new SplitText(heroSubtitle, {
      type: "chars,words",
      charsClass: "subtitle-char"
    });
    
    // Create hero animation timeline
    const tl = gsap.timeline({
      delay: 0.2,
      defaults: { 
        ease: "power3.out",
        duration: 1.2
      }
    });
    
    // Animate hero elements
    tl.from(titleSplit.chars, {
      opacity: 0, 
      y: 100, 
      rotationX: -90,
      stagger: 0.03,
      duration: 1.2
    })
    .from(subtitleSplit.chars, {
      opacity: 0,
      y: 50,
      stagger: 0.02,
      duration: 0.8
    }, "-=0.8")
    .from(".scroll-indicator", {
      opacity: 0,
      y: 30,
      duration: 0.5
    }, "-=0.5");
    
    // Add scroll indicator animation
    gsap.to(".scroll-arrow", {
      y: 10,
      repeat: -1,
      yoyo: true,
      duration: 0.8,
      ease: "power1.inOut"
    });
    
    // Add click event for scroll indicator
    const scrollIndicator = document.querySelector('.scroll-indicator');
    const featuredSection = document.querySelector('.featured-section');
    
    if (scrollIndicator && featuredSection) {
      scrollIndicator.addEventListener('click', () => {
        gsap.to(window, {
          duration: 1,
          scrollTo: {
            y: featuredSection,
            offsetY: 0
          },
          ease: "power2.inOut"
        });
      });
    }
  }
}

/**
 * Featured products slider animations - each image takes a full scroll
 */
function initFeaturedSlider() {
  console.log("Initializing featured slider");
  
  const slides = document.querySelectorAll('.featured-slide');
  if (!slides.length) {
    console.log("No featured slides found");
    return;
  }
  
  console.log(`Found ${slides.length} featured slides`);
  
  // Get relevant sections
  const featuredSection = document.querySelector('.featured-section');
  const nextSection = document.querySelector('.category-highlights') || document.querySelector('.promo-banner');
  
  if (!featuredSection || !nextSection) return;
  
  // Create a timeline for the slides without ScrollTrigger initially
  const slidesTl = gsap.timeline({paused: true});
  
  // Set initial state - only first slide visible
  gsap.set(slides[0], {opacity: 1, scale: 1});
  gsap.set(slides.slice(1), {opacity: 0, scale: 0.8});
  
  // Create slide transitions
  slides.forEach((slide, i) => {
    if (i < slides.length - 1) {
      slidesTl.to(slide, {
        opacity: 0,
        scale: 0.8,
        duration: 0.5
      })
      .to(slides[i + 1], {
        opacity: 1,
        scale: 1,
        duration: 0.5
      }, "<");
    }
  });
  
  // Now create the ScrollTrigger to control the timeline
  ScrollTrigger.create({
    trigger: featuredSection,
    start: "top top",
    endTrigger: nextSection, 
    end: "top top",
    pin: true,
    pinSpacing: true,
    scrub: 1,
    anticipatePin: 1,
    markers: false, // Set to true for debugging
    onUpdate: (self) => {
      // Calculate the progress based on slides
      const progress = self.progress * slides.length;
      const slideProgress = Math.min(progress, slides.length - 1);
      
      // Update the timeline
      slidesTl.progress(slideProgress / (slides.length - 1));
      
      // Update progress bar
      gsap.to(".progress-fill", {
        width: `${(self.progress * 100)}%`,
        duration: 0.1
      });
      
      console.log(`Slider progress: ${self.progress.toFixed(2)}, Slide: ${Math.floor(slideProgress) + 1}`);
    }
  });
  
  // Add slide number animations
  slides.forEach((slide, i) => {
    const number = slide.querySelector('.slide-number');
    if (number) {
      gsap.from(number, {
        opacity: 0,
        scale: 0,
        duration: 0.5,
        scrollTrigger: {
          trigger: slide,
          start: "top center",
          toggleActions: "play none none reverse"
        }
      });
    }
  });
}

/**
 * Initialize animations for other sections
 */
function initSectionAnimations() {
  // Get all sections except hero and featured
  const sections = [
    document.querySelector('.promo-banner'),
    document.querySelector('.featured-products'),
    document.querySelector('.category-highlights'),
    document.querySelector('.bottom-promo-section')
  ].filter(Boolean);
  
  // Add animations for each section
  sections.forEach((section) => {
    // Animate headings
    const heading = section.querySelector('h2');
    if (heading) {
      gsap.from(heading, {
        y: 50,
        opacity: 0,
        duration: 1,
        scrollTrigger: {
          trigger: section,
          start: "top 80%",
          toggleActions: "play none none none"
        }
      });
    }
    
    // Animate content based on section type
    if (section.classList.contains('promo-banner')) {
      animatePromoBanner(section);
    } else if (section.classList.contains('featured-products')) {
      animateFeaturedProducts(section);
    } else if (section.classList.contains('category-highlights')) {
      animateCategoryCards(section);
    } else if (section.classList.contains('bottom-promo-section')) {
      animateBottomPromo(section);
    }
  });
}

function animatePromoBanner(section) {
  const buttons = section.querySelectorAll('.btn');
  const description = section.querySelector('.promo-description');
  
  if (description) {
    gsap.from(description, {
      y: 30,
      opacity: 0,
      duration: 0.8,
      scrollTrigger: {
        trigger: section,
        start: "top 70%",
        toggleActions: "play none none none"
      }
    });
  }
  
  if (buttons.length) {
    gsap.from(buttons, {
      y: 20,
      opacity: 0,
      duration: 0.6,
      stagger: 0.2,
      scrollTrigger: {
        trigger: section,
        start: "top 60%",
        toggleActions: "play none none none"
      }
    });
  }
}

function animateFeaturedProducts(section) {
  const products = section.querySelectorAll('.featured-product-slide');
  
  if (products.length) {
    gsap.from(products, {
      y: 50,
      opacity: 0,
      duration: 0.8,
      stagger: 0.2,
      scrollTrigger: {
        trigger: section,
        start: "top 70%",
        toggleActions: "play none none none"
      }
    });
  }
}

function animateCategoryCards(section) {
  const cards = section.querySelectorAll('.category-card');
  
  if (cards.length) {
    gsap.from(cards, {
      y: 50,
      opacity: 0,
      duration: 0.8,
      stagger: 0.2,
      scrollTrigger: {
        trigger: section,
        start: "top 70%",
        toggleActions: "play none none none"
      }
    });
  }
}

function animateBottomPromo(section) {
  const content = section.querySelector('.promo-content');
  
  if (content) {
    gsap.from(content, {
      y: 50,
      opacity: 0,
      duration: 1,
      scrollTrigger: {
        trigger: section,
        start: "top 70%",
        toggleActions: "play none none none"
      }
    });
  }
} 