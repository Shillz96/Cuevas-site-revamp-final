<?php
/**
 * Template part for displaying the featured products section on homepage
 *
 * @package Cuevas_Theme
 */

// Get featured products
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 6,
    'meta_query'     => array(
        array(
            'key'   => '_featured',
            'value' => 'yes'
        )
    )
);
$featured_query = new WP_Query($args);
?>

<section class="featured-products fullscreen-section">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        
        <?php if ($featured_query->have_posts()) : ?>
            <div class="product-carousel">
                <?php 
                while ($featured_query->have_posts()) : 
                    $featured_query->the_post();
                    
                    // Get product image
                    $image_id = get_post_thumbnail_id();
                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                    $product = wc_get_product(get_the_ID());
                    
                    if ($product) :
                    ?>
                    <div class="featured-product-slide" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                        <div class="product-info">
                            <h3 class="product-title"><?php the_title(); ?></h3>
                            <div class="product-price"><?php echo $product->get_price_html(); ?></div>
                            <div class="product-buttons">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
                                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="btn btn-secondary">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                    endif;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <div class="slider-controls">
                <div class="slider-dots"></div>
                <div class="slider-nav">
                    <button class="prev-slide"><i class="fas fa-chevron-left"></i></button>
                    <button class="next-slide"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        <?php else : ?>
            <p class="no-products">No featured products found</p>
        <?php endif; ?>
    </div>
</section> 