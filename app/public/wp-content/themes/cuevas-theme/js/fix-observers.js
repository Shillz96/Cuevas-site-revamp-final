/**
 * Fix Observer errors (ResizeObserver and MutationObserver)
 * This script patches both observers to prevent errors with invalid nodes
 */
(function() {
    // Execute as soon as possible
    function patchObservers() {
        // Fix ResizeObserver
        if (typeof ResizeObserver !== 'undefined') {
            const originalResizeObserve = ResizeObserver.prototype.observe;
            ResizeObserver.prototype.observe = function(target, options) {
                if (target && target.nodeType === 1) {
                    originalResizeObserve.call(this, target, options);
                } else {
                    console.warn('Prevented ResizeObserver error with invalid target');
                }
            };
            console.log('ResizeObserver patched');
        }

        // Fix MutationObserver
        if (typeof MutationObserver !== 'undefined') {
            const originalMutationObserve = MutationObserver.prototype.observe;
            MutationObserver.prototype.observe = function(target, options) {
                if (target && target.nodeType === 1) {
                    originalMutationObserve.call(this, target, options);
                } else {
                    console.warn('Prevented MutationObserver error with invalid target');
                }
            };
            console.log('MutationObserver patched');
        }
    }

    // Try to patch immediately
    patchObservers();

    // Also patch on DOMContentLoaded as a backup
    document.addEventListener('DOMContentLoaded', patchObservers);

    // Fix fullscreen sections on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        // Fix fullscreen sections
        const sections = document.querySelectorAll('.fullscreen-section');
        if (sections.length > 0) {
            // Set each section to full viewport height
            sections.forEach(section => {
                section.style.minHeight = '100vh';
                section.style.width = '100%';
                section.style.position = 'relative';
            });

            // Initialize Lenis smooth scroll if available
            if (window.Lenis) {
                const lenis = new Lenis({
                    duration: 1.2,
                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    orientation: 'vertical',
                    gestureOrientation: 'vertical',
                    smoothWheel: true,
                    smoothTouch: false,
                    wheelMultiplier: 1,
                    touchMultiplier: 2
                });
                
                // Add scrolling functions
                const scrollToSection = (index) => {
                    if (sections[index]) {
                        const top = sections[index].offsetTop;
                        if (window.gsap && window.ScrollToPlugin) {
                            gsap.to(window, {
                                duration: 1, 
                                scrollTo: {y: top, autoKill: false},
                                ease: 'power2.inOut'
                            });
                        } else {
                            lenis.scrollTo(top, {duration: 1.2});
                        }
                    }
                };
                
                // Add navigation dots if they don't exist
                if (!document.querySelector('.section-nav-dots')) {
                    const navDots = document.createElement('div');
                    navDots.className = 'section-nav-dots';
                    navDots.style.cssText = `
                        position: fixed;
                        right: 20px;
                        top: 50%;
                        transform: translateY(-50%);
                        z-index: 100;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                    `;
                    
                    sections.forEach((section, index) => {
                        const dot = document.createElement('button');
                        dot.className = 'nav-dot';
                        dot.setAttribute('aria-label', `Scroll to section ${index + 1}`);
                        dot.style.cssText = `
                            width: 12px;
                            height: 12px;
                            border-radius: 50%;
                            background: rgba(255,255,255,0.5);
                            border: none;
                            cursor: pointer;
                            transition: all 0.3s ease;
                        `;
                        dot.addEventListener('click', () => scrollToSection(index));
                        navDots.appendChild(dot);
                    });
                    
                    document.body.appendChild(navDots);
                }
                
                // Integrate with GSAP ScrollTrigger if available
                if (window.gsap && window.ScrollTrigger) {
                    sections.forEach((section, index) => {
                        ScrollTrigger.create({
                            trigger: section,
                            start: 'top center',
                            end: 'bottom center',
                            onEnter: () => highlightDot(index),
                            onEnterBack: () => highlightDot(index)
                        });
                    });
                    
                    function highlightDot(index) {
                        const dots = document.querySelectorAll('.nav-dot');
                        dots.forEach((dot, i) => {
                            if (i === index) {
                                dot.style.background = '#ffffff';
                                dot.style.transform = 'scale(1.3)';
                            } else {
                                dot.style.background = 'rgba(255,255,255,0.5)';
                                dot.style.transform = 'scale(1)';
                            }
                        });
                    }
                }
                
                // Connect lenis to requestAnimationFrame
                function raf(time) {
                    lenis.raf(time);
                    requestAnimationFrame(raf);
                }
                requestAnimationFrame(raf);
                
                console.log('Fullscreen sections initialized with smooth scrolling');
            }
        }
    });
})(); 