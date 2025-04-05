<?php
/**
 * Template part for displaying shop categories on the homepage
 *
 * @package Cuevas_Western_Wear
 */

// Only display if WooCommerce is active
if (!class_exists('WooCommerce')) {
    return;
}

$section_title = get_theme_mod('cuevas_shop_categories_title', 'Shop Categories');
$section_subtitle = get_theme_mod('cuevas_shop_categories_subtitle', 'Browse our Western collections');

// Define the categories to display (customize as needed)
// Format: 'slug' => 'Title'
$featured_categories = array(
    'boots' => 'Western Boots',
    'hats' => 'Western Hats',
    'clothing' => 'Western Clothing'
);

// Default background images using placeholder service
$default_images = array(
    'boots' => 'https://placehold.co/600x400/8B4513/FFF?text=Western+Boots',
    'hats' => 'https://placehold.co/600x400/A52A2A/FFF?text=Western+Hats',
    'clothing' => 'https://placehold.co/600x400/D2691E/FFF?text=Western+Clothing'
);
?>

<section id="shop-categories" class="homepage-section shop-categories-section">
    <div class="section-header">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
        <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
    </div>
    
    <div class="categories-grid">
        <?php 
        foreach ($featured_categories as $slug => $title) :
            // Get the category term
            $category = get_term_by('slug', $slug, 'product_cat');
            
            // If category doesn't exist, create a placeholder card
            if (!$category) {
                $image = $default_images[$slug];
                $category_url = '#'; // Placeholder URL
            } else {
                // Get category image or use default
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : $default_images[$slug];
                
                // Get category URL
                $category_url = get_term_link($category);
            }
        ?>
            <div class="category-card">
                <a href="<?php echo esc_url($category_url); ?>" class="category-link">
                    <div class="category-image" style="background-image: url('<?php echo esc_url($image); ?>');">
                        <div class="category-overlay"></div>
                        <h3 class="category-title"><?php echo esc_html($title); ?></h3>
                    </div>
                </a>
                <div class="category-button-container">
                    <a href="<?php echo esc_url($category_url); ?>" class="category-button">
                        Shop <?php echo esc_html($title); ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section><!-- #shop-categories --> 