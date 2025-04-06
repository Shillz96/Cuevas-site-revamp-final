<?php
/**
 * Template part for displaying a full-screen 2x4 product grid
 *
 * @package Cuevas_Western_Wear
 */

// Only display if WooCommerce is active
if (!class_exists('WooCommerce')) {
    return;
}

// Get 8 products (2x4 grid)
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$products = new WP_Query($args);

// Only proceed if we have products
if ($products->have_posts()) :
?>

<section id="product-grid-section" class="homepage-section product-grid-section">
    <div class="product-grid">
        <?php 
        while ($products->have_posts()) : $products->the_post();
            global $product;
            
            // Skip if not a valid product
            if (!is_a($product, 'WC_Product')) continue;
        ?>
            <div class="product-card">
                <a href="<?php the_permalink(); ?>" class="product-link">
                    <div class="product-image-container">
                        <?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail'); ?>
                        <?php if ($product->is_on_sale()) : ?>
                            <div class="product-badge badge-sale"><?php _e('Sale', 'cuevas-theme'); ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</section><!-- #product-grid-section -->

<?php 
wp_reset_postdata();
endif;
?> 