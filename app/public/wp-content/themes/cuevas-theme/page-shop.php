<?php
/**
 * Template Name: Shop Page
 *
 * This is the template that displays the shop page.
 *
 * @package CuevasWesternWear
 */

get_header();
?>

<div class="shop-container">
    <div class="shop-header">
        <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
        <?php do_action('woocommerce_archive_description'); ?>
    </div>

    <?php if (class_exists('WooCommerce')) : ?>
        <?php 
        // Get any query args
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 12,
        );

        // Create a new query
        $products = new WP_Query($args);

        // If we have products, show them
        if ($products->have_posts()) : ?>
            <div class="products-grid">
                <?php while ($products->have_posts()) : $products->the_post(); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endwhile; ?>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="no-products-found">
                <h2>No Products Found</h2>
                <p>We're currently updating our inventory. Please check back soon!</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Return Home</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
get_footer(); 