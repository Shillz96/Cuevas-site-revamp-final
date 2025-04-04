<?php
/**
 * Template part for displaying the bottom promotional section on homepage
 *
 * @package Cuevas_Theme
 */

// Get background image from customizer
$promo_image = get_theme_mod('homepage_promo_image', '');
$bg_style = $promo_image ? 'style="background-image: url(\'' . esc_url($promo_image) . '\');"' : '';
?>

<section class="bottom-promo-section fullscreen-section" <?php echo $bg_style; ?>>
    <div class="container">
        <div class="promo-content">
            <h2 class="promo-title">Family Owned Since 1987</h2>
            <p class="promo-description">Quality western wear for the modern cowboy and cowgirl. Handcrafted with premium materials and attention to detail.</p>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>" class="btn btn-primary">Our Story</a>
        </div>
    </div>
</section> 