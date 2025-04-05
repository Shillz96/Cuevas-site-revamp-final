<?php
/**
 * Cuevas Western Wear - Front Page
 */
get_header();

// Get hero section customizer settings
$hero_settings = array(
    'banner_image' => get_theme_mod('homepage_banner_image', ''),
    'heading' => get_theme_mod('homepage_banner_heading', "IT'S RODEO SEASON"),
    'subheading' => get_theme_mod('homepage_banner_subheading', 'Quality western wear for the modern cowboy and cowgirl')
);

// Get featured product images from customizer
$featured_images = array();
for ($i = 1; $i <= 5; $i++) {
    $image = get_theme_mod('featured_product_image_' . $i);
    if ($image) {
        $featured_images[] = $image;
    }
}
?>

<style>
/* Critical CSS for fullscreen sections */
html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

body {
    overflow: hidden; /* Hide scrollbars initially */
}

.fullpage-wrapper {
    width: 100%;
    height: 100%;
    position: relative;
}

.section {
    width: 100vw;
    height: 100vh;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-size: cover;
    background-position: center;
}

/* Hero section styles */
.hero-section {
    background-color: #333;
    color: white;
    text-align: center;
}

.hero-content {
    max-width: 80%;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    margin-bottom: 20px;
    opacity: 0;
}

.hero-subtitle {
    font-size: 1.5rem;
    opacity: 0;
}

.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    text-align: center;
    opacity: 0;
    cursor: pointer;
}

.scroll-arrow {
    display: block;
    width: 30px;
    height: 30px;
    margin: 10px auto;
    background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/down-arrow.svg');
    background-size: contain;
    background-repeat: no-repeat;
}

/* Navigation dots */
.section-nav {
    position: fixed;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1000;
}

.section-nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.section-nav li {
    margin: 15px 0;
}

.section-nav button {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.7);
    background: transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.section-nav button.active {
    background: white;
    transform: scale(1.2);
}

/* Fixed navigation arrows */
.fixed-nav-btn {
    position: fixed;
    right: 30px;
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1000;
    transition: background 0.3s ease;
}

.fixed-nav-btn:hover {
    background: rgba(255,255,255,0.4);
}

.fixed-nav-btn.prev {
    top: 30px;
}

.fixed-nav-btn.next {
    bottom: 30px;
}

/* Featured slider */
.slider-container {
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: scale(0.9);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.slide.active {
    opacity: 1;
    transform: scale(1);
    z-index: 1;
}

.slide-number {
    position: absolute;
    bottom: 30px;
    right: 30px;
    font-size: 2rem;
    color: white;
    font-weight: bold;
}

.slider-nav {
    position: absolute;
    bottom: 30px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    z-index: 2;
}

.slider-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    margin: 0 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slider-dot.active {
    background: white;
    transform: scale(1.2);
}

/* Reduced motion preferences */
@media (prefers-reduced-motion: reduce) {
    .slide, .slide.active,
    .section-nav button, .section-nav button.active,
    .slider-dot, .slider-dot.active,
    .scroll-arrow {
        transition: none !important;
        animation: none !important;
        transform: none !important;
    }
}
</style>

<!-- Main wrapper - add accessibility improvements -->
<div class="fullpage-wrapper" role="main">
    <!-- Section 1: Home/Hero -->
    <section id="home" class="section hero-section" 
        <?php if($hero_settings['banner_image']): ?>
            style="background-image: url('<?php echo esc_url($hero_settings['banner_image']); ?>');"
        <?php endif; ?>
        role="region" aria-label="Home">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html($hero_settings['heading']); ?></h1>
            <p class="hero-subtitle"><?php echo esc_html($hero_settings['subheading']); ?></p>
        </div>
        <div class="scroll-indicator" role="button" tabindex="0" aria-label="Scroll to next section">
            <span>Scroll Down</span>
            <span class="scroll-arrow" aria-hidden="true"></span>
        </div>
    </section>

    <!-- Section 2: Gallery -->
    <?php if (!empty($featured_images)): ?>
    <section id="gallery" class="section gallery-section" role="region" aria-label="Gallery">
        <div class="slider-container" role="region" aria-roledescription="carousel" aria-label="Featured Images">
            <?php foreach ($featured_images as $index => $image): ?>
                <div class="slide <?php echo ($index === 0) ? 'active' : ''; ?>" 
                     style="background-image: url('<?php echo esc_url($image); ?>');"
                     role="group" aria-roledescription="slide" 
                     aria-label="Slide <?php echo $index + 1; ?> of <?php echo count($featured_images); ?>" 
                     aria-hidden="<?php echo ($index === 0) ? 'false' : 'true'; ?>">
                    <div class="slide-number" aria-hidden="true"><?php echo sprintf('%02d', $index + 1); ?></div>
                </div>
            <?php endforeach; ?>
            
            <div class="slider-nav" role="tablist" aria-label="Gallery navigation">
                <?php foreach ($featured_images as $index => $image): ?>
                    <div class="slider-dot <?php echo ($index === 0) ? 'active' : ''; ?>" 
                         data-index="<?php echo $index; ?>"
                         role="tab" tabindex="<?php echo ($index === 0) ? '0' : '-1'; ?>"
                         aria-label="Go to slide <?php echo $index + 1; ?>"
                         aria-selected="<?php echo ($index === 0) ? 'true' : 'false'; ?>"></div>
            <?php endforeach; ?>
        </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Section 3: Products -->
    <section id="products" class="section products-section" role="region" aria-label="Featured Products">
        <?php get_template_part('template-parts/home/featured-products'); ?>
    </section>
    
    <!-- Section 4: Shop By Category -->
    <section id="shop" class="section shop-section" role="region" aria-label="Shop By Category">
    <?php get_template_part('template-parts/home/promo-banner'); ?>
    </section>
</div>

<!-- Section navigation - add accessibility improvements -->
<nav class="section-nav" role="navigation" aria-label="Page sections">
    <ul>
        <li><button class="nav-dot active" data-section="home" aria-label="Navigate to Home section" aria-current="true"></button></li>
        <li><button class="nav-dot" data-section="gallery" aria-label="Navigate to Gallery section" aria-current="false"></button></li>
        <li><button class="nav-dot" data-section="products" aria-label="Navigate to Products section" aria-current="false"></button></li>
        <li><button class="nav-dot" data-section="shop" aria-label="Navigate to Shop By Category section" aria-current="false"></button></li>
    </ul>
</nav>

<!-- Fixed navigation buttons - add accessibility improvements -->
<button class="fixed-nav-btn prev" aria-label="Navigate to previous section"><i class="fas fa-chevron-up" aria-hidden="true"></i></button>
<button class="fixed-nav-btn next" aria-label="Navigate to next section"><i class="fas fa-chevron-down" aria-hidden="true"></i></button>

<!-- Screen reader announcer for accessibility -->
<div id="section-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>
<div id="slider-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

<?php
// Footer is removed as requested
?>