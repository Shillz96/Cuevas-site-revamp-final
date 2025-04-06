<?php
/**
 * Template part for displaying the shop categories section on the homepage
 *
 * @package Cuevas_Western_Wear
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get theme customizer setting with fallback to default value
 * 
 * @param string $setting_name The theme mod setting name
 * @param mixed $default The default value if setting is not found
 * @return mixed The setting value or default
 */
function get_shop_category_setting($setting_name, $default = '') {
    $value = get_theme_mod($setting_name, $default);
    
    if (defined('WP_DEBUG') && WP_DEBUG && function_exists('cuevas_debug_log')) {
        cuevas_debug_log("Shop category setting {$setting_name}: " . print_r($value, true));
    }
    
    return $value;
}

// Section text content
$section_title = get_shop_category_setting('cuevas_shop_categories_title', 'Shop Categories');
$section_subtitle = get_shop_category_setting('cuevas_shop_categories_subtitle', 'Find your style in our collections');

// Background image
$background_image = get_shop_category_setting('cuevas_shop_categories_bg_image', '');
if (empty($background_image)) {
    $background_image = get_template_directory_uri() . '/assets/images/shop-categories-bg.jpg';
}

// Get category data from theme customizer
$categories = [
    [
        'name' => get_shop_category_setting('cuevas_shop_cta1_title', 'Boots'),
        'link' => get_shop_category_setting('cuevas_shop_cta1_url', '/product-category/boots/'),
        'icon' => 'boot'
    ],
    [
        'name' => get_shop_category_setting('cuevas_shop_cta2_title', 'Hats'),
        'link' => get_shop_category_setting('cuevas_shop_cta2_url', '/product-category/hats/'),
        'icon' => 'hat'
    ],
    [
        'name' => get_shop_category_setting('cuevas_shop_cta3_title', 'Clothing'),
        'link' => get_shop_category_setting('cuevas_shop_cta3_url', '/product-category/clothing/'),
        'icon' => 'tshirt'
    ],
    [
        'name' => 'Accessories',
        'link' => '/product-category/accessories/',
        'icon' => 'accessory'
    ]
];
?>

<section id="shop-categories" class="homepage-section shop-categories-section">
    <div class="section-background" style="background-image: url('<?php echo esc_url($background_image); ?>');">
        <div class="overlay"></div>
    </div>
    
    <div class="section-content container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
        </div>
        
        <div class="cta-buttons-container">
            <?php foreach ($categories as $category) : ?>
            <a href="<?php echo esc_url($category['link']); ?>" class="cta-button <?php echo esc_attr($category['icon']); ?>-button">
                <span class="category-icon <?php echo esc_attr($category['icon']); ?>-icon"></span>
                <span class="category-name"><?php echo esc_html($category['name']); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* Inline critical CSS for shop categories section layout */
.shop-categories-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}

.shop-categories-section .section-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    z-index: -2;
}

.shop-categories-section .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: -1;
}

.shop-categories-section .section-content {
    width: 100%;
    max-width: 1200px;
    padding: 20px;
    z-index: 1;
}

.shop-categories-section .section-header {
    margin-bottom: 40px;
}

.shop-categories-section .section-title {
    color: #fff;
    font-size: 3rem;
    margin-bottom: 15px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.shop-categories-section .section-subtitle {
    color: #fff;
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
}

.shop-categories-section .cta-buttons-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}

.shop-categories-section .cta-button {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: rgba(139, 69, 19, 0.8);
    color: #fff;
    padding: 20px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    min-width: 180px;
}

.shop-categories-section .category-icon {
    font-size: 24px;
    margin-bottom: 10px;
}

.shop-categories-section .category-name {
    font-size: 18px;
}

@media (max-width: 768px) {
    .shop-categories-section .cta-buttons-container {
        flex-direction: column;
        align-items: center;
    }
    
    .shop-categories-section .cta-button {
        width: 80%;
    }
}
</style> 