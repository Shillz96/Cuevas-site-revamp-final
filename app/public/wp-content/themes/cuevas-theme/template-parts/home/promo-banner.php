<?php
/**
 * Template part for displaying the promotional banner section on the home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cuevas_Theme
 */

// Get promo banner settings
$promo_banner_image = get_theme_mod('promo_banner_image', '');
$promo_banner_heading = get_theme_mod('promo_banner_heading', 'Shop By Category');
$promo_banner_text = get_theme_mod('promo_banner_text', 'Find the perfect western wear for your needs. Browse our collections by category and discover quality products for every cowboy and cowgirl.');
$promo_button_text = get_theme_mod('promo_button_text', 'View All Categories');
$promo_button_url = get_theme_mod('promo_button_url', '#');
$promo_button_text_2 = get_theme_mod('promo_button_text_2', 'Shop All');
$promo_button_url_2 = get_theme_mod('promo_button_url_2', '#');
?>

<div class="promo-banner-content">
    <div class="promo-banner-text">
        <h2 class="promo-heading"><?php echo esc_html($promo_banner_heading); ?></h2>
        <p class="promo-description"><?php echo esc_html($promo_banner_text); ?></p>
    </div>
    
    <div class="promo-banner-buttons">
        <?php if (!empty($promo_button_text)) : ?>
            <a href="<?php echo esc_url($promo_button_url); ?>" class="btn btn-primary"><?php echo esc_html($promo_button_text); ?></a>
        <?php endif; ?>
        
        <?php if (!empty($promo_button_text_2)) : ?>
            <a href="<?php echo esc_url($promo_button_url_2); ?>" class="btn btn-outline"><?php echo esc_html($promo_button_text_2); ?></a>
        <?php endif; ?>
    </div>

    <div class="category-grid">
        <?php
        // Get up to 4 product categories
        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'number' => 4,
            'orderby' => 'count',
            'order' => 'DESC',
        ));

        if (!is_wp_error($categories) && !empty($categories)) :
            foreach ($categories as $category) :
                $category_link = get_term_link($category);
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnail_id);
                ?>
                <div class="category-card" <?php if ($image) echo 'style="background-image: url(' . esc_url($image) . ');"'; ?>>
                    <div class="category-content">
                        <h3 class="category-title"><?php echo esc_html($category->name); ?></h3>
                        <a href="<?php echo esc_url($category_link); ?>" class="btn btn-secondary">View Products</a>
                    </div>
                </div>
                <?php
            endforeach;
        else:
            // Fallback categories if WooCommerce is not active
            $fallback_categories = array(
                array('name' => 'Boots', 'image' => get_template_directory_uri() . '/assets/images/category-boots.jpg'),
                array('name' => 'Hats', 'image' => get_template_directory_uri() . '/assets/images/category-hats.jpg'),
                array('name' => 'Belts', 'image' => get_template_directory_uri() . '/assets/images/category-belts.jpg'),
                array('name' => 'Apparel', 'image' => get_template_directory_uri() . '/assets/images/category-apparel.jpg')
            );
            
            foreach ($fallback_categories as $category) :
                ?>
                <div class="category-card" <?php if (!empty($category['image'])) echo 'style="background-image: url(' . esc_url($category['image']) . ');"'; ?>>
                    <div class="category-content">
                        <h3 class="category-title"><?php echo esc_html($category['name']); ?></h3>
                        <a href="#products" class="btn btn-secondary">View Products</a>
                    </div>
                </div>
                <?php
            endforeach;
        endif;
        ?>
    </div>
</div> 