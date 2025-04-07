/**
 * Homepage Animations for Cuevas Western Wear
 * This file contains all GSAP animations for the homepage
 */

document.addEventListener('DOMContentLoaded', function() {
    // Register GSAP plugins
    gsap.registerPlugin(ScrollTrigger);

    // -------------------------------------------
    // Hero Section Animations
    // -------------------------------------------
    
    // Hero parallax effect
    gsap.to(".hero-background", {
        scrollTrigger: {
            trigger: ".hero-section",
            start: "top top", 
            end: "bottom top",
            scrub: true
        },
        y: 100,
        ease: "none"
    });
    
    // Hero content fade in
    gsap.from(".hero-content", {
        opacity: 0,
        y: 50,
        duration: 1,
        delay: 0.5,
        ease: "power3.out"
    });
    
    // Hero CTA button
    gsap.from(".hero-cta", {
        opacity: 0,
        y: 20,
        duration: 0.8,
        delay: 1,
        ease: "back.out(1.7)"
    });

    // -------------------------------------------
    // Category Showcases
    // -------------------------------------------
    
    // Staggered appearance of category items
    gsap.from(".category-item", {
        scrollTrigger: {
            trigger: ".categories-section",
            start: "top 80%"
        },
        opacity: 0,
        y: 30,
        stagger: 0.15,
        duration: 0.8,
        ease: "power2.out"
    });
    
    // Category hover animations
    const categoryItems = document.querySelectorAll('.category-item');
    
    categoryItems.forEach(item => {
        const image = item.querySelector('.category-image');
        const title = item.querySelector('.category-title');
        const overlay = item.querySelector('.category-overlay');
        
        let tl = gsap.timeline({ paused: true });
        
        tl.to(overlay, { 
            opacity: 0.7, 
            duration: 0.3 
        })
        .to(image, { 
            scale: 1.1, 
            duration: 0.5,
            ease: "power1.out" 
        }, 0)
        .to(title, { 
            y: -10, 
            duration: 0.4,
            ease: "power1.out" 
        }, 0);
        
        item.addEventListener('mouseenter', () => tl.play());
        item.addEventListener('mouseleave', () => tl.reverse());
    });

    // -------------------------------------------
    // Featured Products
    // -------------------------------------------
    
    // Reveal animation for section title
    gsap.from(".featured-products-title", {
        scrollTrigger: {
            trigger: ".featured-products",
            start: "top 80%"
        },
        opacity: 0,
        y: 20,
        duration: 0.6,
        ease: "power2.out"
    });
    
    // Staggered appearance of product cards
    gsap.from(".product-card", {
        scrollTrigger: {
            trigger: ".featured-products",
            start: "top 70%"
        },
        opacity: 0,
        y: 40,
        stagger: 0.1,
        duration: 0.6,
        ease: "power2.out"
    });
    
    // Product card hover animations
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        const image = card.querySelector('.product-image');
        const details = card.querySelector('.product-details');
        const button = card.querySelector('.add-to-cart-button');
        
        let tl = gsap.timeline({ paused: true });
        
        tl.to(image, { 
            scale: 1.05, 
            duration: 0.3,
            ease: "power1.out" 
        })
        .to(details, { 
            y: -10, 
            duration: 0.3,
            ease: "power1.out" 
        }, 0)
        .to(button, { 
            opacity: 1, 
            y: 0, 
            duration: 0.3,
            ease: "power1.out" 
        }, 0.1);
        
        card.addEventListener('mouseenter', () => tl.play());
        card.addEventListener('mouseleave', () => tl.reverse());
    });

    // -------------------------------------------
    // Special Offers Section
    // -------------------------------------------
    
    // Special offer banner animation
    gsap.from(".special-offer-banner", {
        scrollTrigger: {
            trigger: ".special-offers",
            start: "top 75%"
        },
        opacity: 0,
        scale: 0.95,
        duration: 0.8,
        ease: "power2.out"
    });
    
    // Countdown timer animation
    const countdownElements = document.querySelectorAll('.countdown-element');
    gsap.from(countdownElements, {
        scrollTrigger: {
            trigger: ".countdown-timer",
            start: "top 85%"
        },
        opacity: 0,
        scale: 0.5,
        stagger: 0.1,
        duration: 0.6,
        ease: "back.out(1.7)"
    });
    
    // CTA button pulse animation
    gsap.to(".special-offer-cta", {
        scrollTrigger: {
            trigger: ".special-offers",
            start: "top 70%"
        },
        keyframes: {
            "0%": { scale: 1 },
            "50%": { scale: 1.05 },
            "100%": { scale: 1 }
        },
        duration: 2,
        repeat: -1,
        ease: "sine.inOut"
    });

    // -------------------------------------------
    // Testimonials Section
    // -------------------------------------------
    
    // Testimonial carousel animation
    const testimonials = document.querySelectorAll('.testimonial-item');
    let currentTestimonial = 0;
    
    // Hide all testimonials except first one
    gsap.set(testimonials, { opacity: 0, display: 'none' });
    gsap.set(testimonials[0], { opacity: 1, display: 'block' });
    
    // Function to animate testimonial transition
    function rotateTestimonials() {
        gsap.to(testimonials[currentTestimonial], {
            opacity: 0,
            x: -20,
            duration: 0.5,
            onComplete: function() {
                gsap.set(testimonials[currentTestimonial], { display: 'none' });
                currentTestimonial = (currentTestimonial + 1) % testimonials.length;
                gsap.set(testimonials[currentTestimonial], { display: 'block', x: 20 });
                gsap.to(testimonials[currentTestimonial], {
                    opacity: 1,
                    x: 0,
                    duration: 0.5
                });
            }
        });
    }
    
    // Set interval for testimonial rotation
    setInterval(rotateTestimonials, 5000);
    
    // Animate quote icon
    gsap.from(".quote-icon", {
        scrollTrigger: {
            trigger: ".testimonials-section",
            start: "top 80%"
        },
        opacity: 0,
        scale: 0.5,
        duration: 0.8,
        ease: "back.out(1.7)"
    });

    // -------------------------------------------
    // Newsletter Section
    // -------------------------------------------
    
    // Newsletter form appearance
    gsap.from(".newsletter-form", {
        scrollTrigger: {
            trigger: ".newsletter-section",
            start: "top 80%"
        },
        opacity: 0,
        y: 30,
        duration: 0.8,
        ease: "power2.out"
    });
    
    // Submit button hover effect
    const submitButton = document.querySelector('.newsletter-submit');
    
    if (submitButton) {
        let submitTl = gsap.timeline({ paused: true });
        
        submitTl.to(submitButton, {
            backgroundColor: '#B71C1C',
            scale: 1.05,
            duration: 0.3,
            ease: "power1.out"
        });
        
        submitButton.addEventListener('mouseenter', () => submitTl.play());
        submitButton.addEventListener('mouseleave', () => submitTl.reverse());
    }

    // -------------------------------------------
    // Instagram Feed Section
    // -------------------------------------------
    
    // Instagram feed items staggered appearance
    gsap.from(".instagram-item", {
        scrollTrigger: {
            trigger: ".instagram-feed",
            start: "top 80%"
        },
        opacity: 0,
        scale: 0.8,
        stagger: 0.1,
        duration: 0.6,
        ease: "power2.out"
    });
    
    // Instagram hover effect
    const instagramItems = document.querySelectorAll('.instagram-item');
    
    instagramItems.forEach(item => {
        const overlay = item.querySelector('.instagram-overlay');
        
        let tl = gsap.timeline({ paused: true });
        
        tl.to(overlay, {
            opacity: 1,
            duration: 0.3,
            ease: "power1.out"
        });
        
        item.addEventListener('mouseenter', () => tl.play());
        item.addEventListener('mouseleave', () => tl.reverse());
    });

    // -------------------------------------------
    // Scroll-to-top Button
    // -------------------------------------------
    
    // Show/hide scroll-to-top button based on scroll position
    const scrollTopButton = document.querySelector('.scroll-top-button');
    
    if (scrollTopButton) {
        gsap.set(scrollTopButton, { opacity: 0, display: 'none' });
        
        ScrollTrigger.create({
            start: 400,
            onEnter: () => gsap.to(scrollTopButton, { opacity: 1, display: 'block', duration: 0.3 }),
            onLeaveBack: () => gsap.to(scrollTopButton, { opacity: 0, display: 'none', duration: 0.3 })
        });
        
        // Smooth scroll to top when clicked
        scrollTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            gsap.to(window, { duration: 1, scrollTo: 0, ease: "power2.inOut" });
        });
    }
}); 