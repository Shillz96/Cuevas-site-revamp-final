<?php
/**
 * The front page template file
 *
 * This is the homepage template for Cuevas Western Wear
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cuevas_Theme
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

<div class="fullpage-wrapper">
    <!-- Hero Section -->
    <section class="hero-section fullscreen-section" 
        <?php if($hero_settings['banner_image']): ?>
            style="background-image: url('<?php echo esc_url($hero_settings['banner_image']); ?>');"
        <?php endif; ?>>
        <div class="hero-content">
            <h1 class="hero-title split-text"><?php echo esc_html($hero_settings['heading']); ?></h1>
            <p class="hero-subtitle split-text"><?php echo esc_html($hero_settings['subheading']); ?></p>
        </div>
        <div class="scroll-indicator">
            <span class="scroll-text">Scroll Down</span>
            <span class="scroll-arrow"></span>
        </div>
    </section>

    <?php if (!empty($featured_images)): ?>
    <!-- Featured Products Slider -->
    <section class="featured-section fullscreen-section">
        <div class="featured-slider">
            <?php foreach ($featured_images as $index => $image): ?>
                <div class="featured-slide" style="background-image: url('<?php echo esc_url($image); ?>');">
                    <div class="slide-content">
                        <span class="slide-number"><?php echo sprintf('%02d', $index + 1); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Promotional Banner Section -->
    <?php get_template_part('template-parts/home/promo-banner'); ?>
    
    <!-- Featured Products Content Section -->
    <?php get_template_part('template-parts/home/featured-products'); ?>
    
    <!-- Category Highlights Section -->
    <?php get_template_part('template-parts/home/category-highlights'); ?>
    
    <!-- Bottom Promotional Section -->
    <?php get_template_part('template-parts/home/bottom-promo'); ?>
</div>

<?php
// Initialize GSAP animations for homepage
wp_enqueue_script('home-animations', get_template_directory_uri() . '/assets/js/home-animations.js', array('gsap', 'scrolltrigger'), null, true);
?>

<?php
get_footer(); 