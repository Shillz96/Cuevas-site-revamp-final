// Main GSAP Animations for Cuevas Theme

document.addEventListener('DOMContentLoaded', () => {
    console.log('[Cuevas Theme] main-animations.js Loaded!');
    
    if (typeof gsap !== 'undefined') {
        console.log('[Cuevas Theme] GSAP Core Found.');
        
        // Simple test: Fade body background slightly - Does *any* GSAP run?
        gsap.to('body', { duration: 0.5, backgroundColor: '#fafafa', ease: 'none' });
        console.log('[Cuevas Theme] Simple body background tween attempted.');

        if (typeof ScrollTrigger !== 'undefined') {
            console.log('[Cuevas Theme] ScrollTrigger Found.');
            gsap.registerPlugin(ScrollTrigger); // Ensure it's registered

            // --- GSAP Context for Cleanup ---
            const ctx = gsap.context(() => {
                console.log('[Cuevas Theme] GSAP Context created.');

                // --- Gallery Slideshow Animation ---
                const gallerySection = document.querySelector('#section-gallery');
                console.log('[Cuevas Theme] Searching for #section-gallery...', gallerySection);
                
                const galleryItems = gsap.utils.toArray('.gallery-slide');
                console.log(`[Cuevas Theme] Found ${galleryItems.length} elements with class .gallery-slide.`);

                if (gallerySection && galleryItems.length > 0) {
                    console.log('[Cuevas Theme] Gallery section and items found. Creating ScrollTrigger pin...');
                    
                    // Pin the gallery section
                    const pin = ScrollTrigger.create({
                        trigger: gallerySection,
                        start: 'top top',
                        end: () => `+=${(galleryItems.length - 1) * window.innerHeight}`, 
                        pin: true,
                        pinSpacing: true,
                        scrub: 1,
                        snap: {
                            snapTo: 1 / (galleryItems.length - 1),
                            duration: { min: 0.2, max: 0.6 },
                            ease: "power1.inOut"
                        },
                        anticipatePin: 1,
                        id: 'galleryPin',
                        // markers: true, // Uncomment for debugging trigger points
                        invalidateOnRefresh: true
                    });
                    console.log('[Cuevas Theme] Gallery Pin ScrollTrigger created:', pin);

                    // Animate images within the pinned section
                    galleryItems.forEach((item, index) => {
                        console.log(`[Cuevas Theme] Processing gallery item ${index + 1}.`);
                        const image = item.querySelector('.inner-slide img');
                        const caption = item.querySelector('.inner-slide .slide-caption');
                        console.log(`[Cuevas Theme] Item ${index + 1}: Image found?`, !!image, `Caption found?`, !!caption);

                        // Parallax effect for images
                        if (image) {
                            gsap.to(image, {
                                yPercent: -20,
                                ease: "none",
                                scrollTrigger: {
                                    trigger: item,
                                    containerAnimation: pin,
                                    start: 'top bottom',
                                    end: 'bottom top',
                                    scrub: true
                                }
                            });
                        }

                         // Fade in/out captions
                         if (caption) {
                             gsap.fromTo(caption,
                                 { autoAlpha: 0, y: 20 },
                                 {
                                     autoAlpha: 1, y: 0,
                                     duration: 0.5,
                                     ease: "power2.out",
                                     scrollTrigger: {
                                         trigger: item,
                                         containerAnimation: pin,
                                         start: 'top center+=10%',
                                         end: 'bottom center-=10%',
                                         toggleActions: "play reverse play reverse"
                                     }
                                 }
                             );
                         }
                    });
                    console.log('[Cuevas Theme] Finished processing all gallery items.');
                } else {
                    console.warn('[Cuevas Theme] Gallery section (#section-gallery) or items (.gallery-slide) not found. Skipping gallery animation.');
                }

                // --- Add other GSAP Timelines and Tweens --- 
                console.log('[Cuevas Theme] End of GSAP context setup.');

            }); // --- End GSAP Context ---

        } else {
            console.error('[Cuevas Theme] ScrollTrigger is NOT available! Cannot initialize animations.');
        }
    } else {
        console.error('[Cuevas Theme] GSAP Core is NOT available! Cannot initialize animations.');
    }
}); 