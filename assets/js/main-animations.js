// Main GSAP Animations for Cuevas Theme

document.addEventListener('DOMContentLoaded', () => {

    // Optional: Access localized data from PHP
    // console.log(cuevasData.some_value);

    // --- GSAP Context for Cleanup ---
    const ctx = gsap.context(() => {

        console.log('GSAP Initialized for Cuevas Theme');

        // --- Register GSAP Plugins (if needed beyond Core/ScrollTrigger) ---
        gsap.registerPlugin(ScrollTrigger);

        // --- Gallery Slideshow Animation ---
        const gallerySection = document.querySelector('#section-gallery');
        const galleryItems = gsap.utils.toArray('.gallery-slide'); // Use gsap.utils for robustness

        if (gallerySection && galleryItems.length > 0) {

            // Pin the gallery section
            const pin = ScrollTrigger.create({
                trigger: gallerySection,
                start: 'top top', // Pin starts when the top of the section hits the top of the viewport
                end: () => `+=${(galleryItems.length - 1) * window.innerHeight}`, // End after scrolling the height of all items
                pin: true,
                pinSpacing: true, // Add space below the pinned section
                scrub: 1,         // Smooth scrubbing (adjust 1 for more/less smoothing)
                snap: {           // Snap to each image section
                    snapTo: 1 / (galleryItems.length - 1),
                    duration: { min: 0.2, max: 0.6 },      // Control snap animation speed
                    ease: "power1.inOut"                   // Smooth snap easing
                },
                anticipatePin: 1, // Helps prevent jitter on pin start
                id: 'galleryPin', // Assign ID directly here
                // markers: true, // Uncomment for debugging trigger points
                invalidateOnRefresh: true // Recalculate on viewport resize
            });

            // Animate images within the pinned section
            galleryItems.forEach((item, index) => {
                const image = item.querySelector('.inner-slide img');
                const caption = item.querySelector('.inner-slide .slide-caption');

                // Parallax effect for images (move slightly slower than scroll)
                if (image) { // Check if image exists
                    gsap.to(image, {
                        yPercent: -20, // Adjust percentage for more/less parallax
                        ease: "none", // Linear ease for direct scroll correlation
                        scrollTrigger: {
                            trigger: item,
                            containerAnimation: pin, // Link to the pinning animation using the variable
                            start: 'top bottom', // Start when item enters viewport bottom
                            end: 'bottom top', // End when item leaves viewport top
                            scrub: true       // Smooth scrubbing tied to scroll
                        }
                    });
                }

                 // Fade in/out captions or other content if desired
                 if (caption) { // Check if caption exists
                     gsap.fromTo(caption,
                         { autoAlpha: 0, y: 20 }, // Start state (invisible, slightly down)
                         {
                             autoAlpha: 1, y: 0, // End state (visible, original position)
                             duration: 0.5,      // Faster fade duration
                             ease: "power2.out", // Smooth ease-out
                             scrollTrigger: {
                                 trigger: item,
                                 containerAnimation: pin, // Link to the pinning animation
                                 start: 'top center+=10%', // Trigger slightly past center
                                 end: 'bottom center-=10%', // End slightly before center on exit
                                 toggleActions: "play reverse play reverse", // Fade in/out on enter/exit
                                 // markers: true // Uncomment for debugging caption triggers
                             }
                         }
                     );
                 }
            });
        }

        // --- Add other GSAP Timelines and Tweens ---


    }); // --- End GSAP Context ---

    // Optional: Cleanup function if needed for SPAs or dynamic content removal
    // return () => ctx.revert();

});
