<?php
/**
 * Template Name: GSAP Debugger
 *
 * A special template for testing and debugging GSAP animations
 *
 * @package CuevasWesternWear
 */

get_header();
?>

<div class="fullpage-wrapper">
    <!-- Section Announcer for Accessibility -->
    <div id="section-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

    <!-- Hero Section -->
    <section id="hero" class="section hero-section active" aria-label="Welcome to Cuevas Western Wear">
        <div class="hero-content">
            <h1 class="hero-title">GSAP Debug Mode</h1>
            <p class="hero-subtitle">Testing ScrollTrigger and Section Animations</p>
            <div class="scroll-indicator">
                <span>Scroll Down</span>
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Test Section 1 -->
    <section id="section1" class="section" aria-label="Test Section 1">
        <div class="container">
            <h2>Section 1</h2>
            <p>This is a test section to verify scrolling and animations.</p>
            <p>Check the console for GSAP debug logs.</p>
            <div class="test-elements">
                <div class="test-card" style="background-color: #f5f5f5; padding: 20px; margin: 10px; border-radius: 5px;">Card 1</div>
                <div class="test-card" style="background-color: #f5f5f5; padding: 20px; margin: 10px; border-radius: 5px;">Card 2</div>
                <div class="test-card" style="background-color: #f5f5f5; padding: 20px; margin: 10px; border-radius: 5px;">Card 3</div>
            </div>
        </div>
    </section>

    <!-- Test Section 2 -->
    <section id="section2" class="section" aria-label="Test Section 2">
        <div class="container">
            <h2>Section 2</h2>
            <p>Another test section with different content.</p>
            <div class="featured-slider" style="position: relative; height: 200px; margin: 30px 0;">
                <div class="slide" style="position: absolute; background-color: #e9e9e9; padding: 30px; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">Slide 1</div>
                <div class="slide" style="position: absolute; background-color: #d9d9d9; padding: 30px; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">Slide 2</div>
                <div class="slide" style="position: absolute; background-color: #c9c9c9; padding: 30px; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">Slide 3</div>
                <button class="slider-prev" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); z-index: 10;">Previous</button>
                <button class="slider-next" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); z-index: 10;">Next</button>
            </div>
        </div>
    </section>

    <!-- Test Section 3 -->
    <section id="section3" class="section" aria-label="Test Section 3">
        <div class="container">
            <h2>Section 3</h2>
            <p>Final test section to verify full page scrolling.</p>
            <div class="debug-controls" style="margin-top: 30px;">
                <h3>Debug Controls</h3>
                <button id="debug-info" style="margin: 5px; padding: 10px;">Show Debug Info</button>
                <button id="toggle-debug" style="margin: 5px; padding: 10px;">Toggle Debug Mode</button>
                <button id="clear-logs" style="margin: 5px; padding: 10px;">Clear Console Logs</button>
            </div>
            <div id="debug-output" style="margin-top: 20px; padding: 15px; background-color: #f0f0f0; border-radius: 5px; max-height: 200px; overflow-y: auto;">
                <p>Debug information will appear here</p>
            </div>
        </div>
    </section>

    <!-- Fixed Navigation Controls -->
    <div class="section-nav" style="position: fixed; right: 20px; top: 50%; transform: translateY(-50%); z-index: 100;">
        <div class="nav-dots">
            <span class="nav-dot active" data-section="0"></span>
            <span class="nav-dot" data-section="1"></span>
            <span class="nav-dot" data-section="2"></span>
            <span class="nav-dot" data-section="3"></span>
        </div>
    </div>

    <div class="fixed-nav-buttons" style="position: fixed; right: 20px; bottom: 20px; z-index: 100;">
        <button class="fixed-nav-btn prev" aria-label="Previous Section">Prev</button>
        <button class="fixed-nav-btn next" aria-label="Next Section">Next</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug controls
    const debugOutput = document.getElementById('debug-output');
    
    document.getElementById('debug-info').addEventListener('click', function() {
        // Get debug info
        let info = {
            gsapLoaded: (typeof gsap !== 'undefined'),
            scrollTriggerLoaded: (typeof ScrollTrigger !== 'undefined'),
            scrollToLoaded: (typeof ScrollToPlugin !== 'undefined'),
            sections: document.querySelectorAll('.section').length,
            navDots: document.querySelectorAll('.nav-dot').length,
            windowHeight: window.innerHeight,
            documentHeight: document.documentElement.scrollHeight,
            reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches
        };
        
        // Display in debug output
        debugOutput.innerHTML = '<pre>' + JSON.stringify(info, null, 2) + '</pre>';
        
        // Also log to console
        console.log('[Debug] GSAP Status:', info);
    });
    
    document.getElementById('toggle-debug').addEventListener('click', function() {
        if (window.DEBUG === undefined) window.DEBUG = true;
        else window.DEBUG = !window.DEBUG;
        
        debugOutput.innerHTML = '<p>Debug mode ' + (window.DEBUG ? 'enabled' : 'disabled') + '</p>';
        console.log('[Debug] Debug mode ' + (window.DEBUG ? 'enabled' : 'disabled'));
    });
    
    document.getElementById('clear-logs').addEventListener('click', function() {
        console.clear();
        debugOutput.innerHTML = '<p>Console logs cleared</p>';
    });
});
</script>

<?php
get_footer(); 