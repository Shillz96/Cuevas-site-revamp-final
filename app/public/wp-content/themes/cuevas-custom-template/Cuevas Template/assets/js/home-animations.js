/**
 * Cuevas Western Wear - Home Page Animations
 * Uses GSAP and ScrollTrigger for scroll-based animations
 */

(function() {
  'use strict';

  // Wait for DOM to be ready
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize GSAP and register plugins
    gsap.registerPlugin(ScrollTrigger);

    // Initialize animations when page is loaded
    window.addEventListener('load', function() {
      initHeaderAnimation();
      initHeroAnimation();
      initFeaturedProductsAnimation();
      initCategoriesAnimation();
      initTestimonialsAnimation();
      initBrandsAnimation();
    });
  });

  /**
   * Header transformation on scroll
   */
  function initHeaderAnimation() {
    // Header shrink effect
    gsap.to('.site-header', {
      scrollTrigger: {
        trigger: 'body',
        start: 'top top',
        end: '150px top',
        scrub: true
      },
      height: '70px',
      padding: '10px 40px',
      backgroundColor: 'rgba(89, 51, 29, 0.95)',
      boxShadow: '0 4px 12px rgba(0,0,0,0.1)'
    });

    // Logo resize
    gsap.to('.logo', {
      scrollTrigger: {
        trigger: 'body',
        start: 'top top',
        end: '150px top',
        scrub: true
      },
      scale: 0.8
    });
  }

  /**
   * Hero section animations
   */
  function initHeroAnimation() {
    // Hero section parallax effect
    gsap.to('.hero-section', {
      scrollTrigger: {
        trigger: '.hero-section',
        start: 'top top',
        end: 'bottom top',
        scrub: true
      },
      backgroundPosition: '50% 30%'
    });

    // Hero text reveal on page load
    const heroTimeline = gsap.timeline();
    
    heroTimeline
      .from('.hero-title .reveal-text span', {
        y: 100,
        opacity: 0,
        duration: 1,
        stagger: 0.1,
        ease: 'power3.out'
      })
      .from('.hero-subtitle', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out'
      }, '-=0.4')
      .from('.cw-button', {
        y: 20,
        opacity: 0,
        duration: 0.5,
        ease: 'power3.out'
      }, '-=0.2');
  }

  /**
   * Featured products animations
   */
  function initFeaturedProductsAnimation() {
    // Section title animation
    gsap.from('.featured-products .section-title', {
      scrollTrigger: {
        trigger: '.featured-products',
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      y: 30,
      opacity: 0,
      duration: 0.8
    });
    
    // Products staggered reveal
    gsap.from('.featured-products .product-card', {
      scrollTrigger: {
        trigger: '.featured-products',
        start: 'top 70%',
        toggleActions: 'play none none none'
      },
      y: 50,
      opacity: 0,
      duration: 0.8,
      stagger: 0.1
    });
  }

  /**
   * Categories section animation
   */
  function initCategoriesAnimation() {
    // Categories parallax effect
    document.querySelectorAll('.category-card').forEach((card, index) => {
      const direction = index % 2 === 0 ? -1 : 1;
      
      gsap.from(card, {
        scrollTrigger: {
          trigger: card,
          start: 'top 85%',
          end: 'bottom 15%',
          toggleActions: 'play none none none'
        },
        x: 50 * direction,
        opacity: 0,
        duration: 0.9
      });
      
      // Background parallax
      gsap.to(card.querySelector('.card-image'), {
        scrollTrigger: {
          trigger: card,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true
        },
        y: 30,
        scale: 1.1
      });
    });
  }

  /**
   * Testimonials section animation
   */
  function initTestimonialsAnimation() {
    // Testimonial reveal animation
    gsap.from('.testimonials-section .section-title', {
      scrollTrigger: {
        trigger: '.testimonials-section',
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      y: 30,
      opacity: 0,
      duration: 0.8
    });
    
    // Quote marks animation
    gsap.from('.testimonial-quote-mark', {
      scrollTrigger: {
        trigger: '.testimonials-section',
        start: 'top 75%',
        toggleActions: 'play none none none'
      },
      scale: 0,
      opacity: 0,
      duration: 0.6,
      stagger: 0.2
    });
    
    // Testimonial text animation - word by word
    const testimonialText = document.querySelectorAll('.testimonial-text');
    
    testimonialText.forEach(quote => {
      const words = quote.textContent.split(' ');
      quote.textContent = '';
      
      words.forEach(word => {
        const span = document.createElement('span');
        span.className = 'testimonial-word';
        span.textContent = word + ' ';
        quote.appendChild(span);
      });
      
      gsap.from(quote.querySelectorAll('.testimonial-word'), {
        scrollTrigger: {
          trigger: quote,
          start: 'top 80%',
          toggleActions: 'play none none none'
        },
        opacity: 0,
        y: 20,
        duration: 0.05,
        stagger: 0.05
      });
    });
    
    // Rating stars animation
    gsap.from('.testimonial-rating .star', {
      scrollTrigger: {
        trigger: '.testimonials-section',
        start: 'top 70%',
        toggleActions: 'play none none none'
      },
      scale: 0,
      opacity: 0,
      duration: 0.3,
      stagger: 0.1
    });
  }

  /**
   * Brands section animation
   */
  function initBrandsAnimation() {
    // Brands section title
    gsap.from('.brands-section .section-title', {
      scrollTrigger: {
        trigger: '.brands-section',
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      y: 30,
      opacity: 0,
      duration: 0.8
    });
    
    // Brand logos staggered fade in
    gsap.from('.brand-logo', {
      scrollTrigger: {
        trigger: '.brands-section',
        start: 'top 75%',
        toggleActions: 'play none none none'
      },
      opacity: 0,
      y: 20,
      duration: 0.6,
      stagger: {
        each: 0.1,
        from: 'center'
      }
    });
  }
})(); 