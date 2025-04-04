<?php
/**
 * Template part for displaying the promotional banner section on homepage
 *
 * @package Cuevas_Theme
 */

// Get customizer settings
$promo_heading = get_theme_mod('promo_banner_heading', 'SHOP BY CATEGORY');
$promo_text = get_theme_mod('promo_banner_text', 'Explore our collection of premium western wear');

// Button 1
$button1_text = get_theme_mod('promo_banner_button1_text', 'Men\'s');
$button1_link = get_theme_mod('promo_banner_button1_link', '');
$button1_url = '#';

if (!empty($button1_link)) {
    // Check if term exists and create link
    if (taxonomy_exists('product_cat') && term_exists($button1_link, 'product_cat')) {
        $term_link = get_term_link($button1_link, 'product_cat');
        if (!is_wp_error($term_link)) {
            $button1_url = $term_link;
        }
    }
}

// Button 2
$button2_text = get_theme_mod('promo_banner_button2_text', 'Women\'s');
$button2_link = get_theme_mod('promo_banner_button2_link', '');
$button2_url = '#';

if (!empty($button2_link)) {
    // Check if term exists and create link
    if (taxonomy_exists('product_cat') && term_exists($button2_link, 'product_cat')) {
        $term_link = get_term_link($button2_link, 'product_cat');
        if (!is_wp_error($term_link)) {
            $button2_url = $term_link;
        }
    }
}

// Button 3
$button3_text = get_theme_mod('promo_banner_button3_text', 'Hats');
$button3_link = get_theme_mod('promo_banner_button3_link', '');
$button3_url = '#';

if (!empty($button3_link)) {
    // Check if term exists and create link
    if (taxonomy_exists('product_cat') && term_exists($button3_link, 'product_cat')) {
        $term_link = get_term_link($button3_link, 'product_cat');
        if (!is_wp_error($term_link)) {
            $button3_url = $term_link;
        }
    }
}
?>

<section class="promo-banner fullscreen-section">
    <div class="container">
        <div class="promo-banner-content">
            <div class="promo-banner-text">
                <h2 class="promo-heading"><?php echo esc_html($promo_heading); ?></h2>
                <p class="promo-description"><?php echo esc_html($promo_text); ?></p>
            </div>
            <div class="promo-banner-buttons">
                <a href="<?php echo esc_url($button1_url); ?>" class="btn btn-outline"><?php echo esc_html($button1_text); ?></a>
                <a href="<?php echo esc_url($button2_url); ?>" class="btn btn-outline"><?php echo esc_html($button2_text); ?></a>
                <a href="<?php echo esc_url($button3_url); ?>" class="btn btn-outline"><?php echo esc_html($button3_text); ?></a>
            </div>
        </div>
    </div>
</section> 