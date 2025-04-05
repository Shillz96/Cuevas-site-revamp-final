<?php
/**
 * The Template for displaying products in a product category.
 *
 * @package Cuevas_Theme
 */

get_header();

// Get the current category
$current_category = get_queried_object();
$category_image_id = get_term_meta($current_category->term_id, 'thumbnail_id', true);
$category_image = wp_get_attachment_url($category_image_id);
?>

<div class="category-container full-width">
    <?php if ($category_image) : ?>
    <div class="category-hero" style="background-image: url('<?php echo esc_url($category_image); ?>');">
        <div class="category-hero-content">
            <h1><?php echo esc_html($current_category->name); ?></h1>
            <?php if ($current_category->description) : ?>
                <div class="category-description">
                    <?php echo wp_kses_post($current_category->description); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="category-filters">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        do_action('woocommerce_before_shop_loop');
        ?>
    </div>

    <?php
    if (woocommerce_product_loop()) {
        echo '<div class="products-grid">';
        
        woocommerce_product_loop_start();

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();
                wc_get_template_part('content', 'product');
            }
        }

        woocommerce_product_loop_end();

        echo '</div>';

        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action('woocommerce_after_shop_loop');
    } else {
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action('woocommerce_no_products_found');
    }
    ?>

    <?php
    // Display subcategories if they exist
    $subcategories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => $current_category->term_id
    ]);

    if (!empty($subcategories) && !is_wp_error($subcategories)) : ?>
        <div class="subcategories-section">
            <h2>Shop By Category</h2>
            <div class="subcategories-grid">
                <?php foreach ($subcategories as $subcategory) :
                    $subcategory_image_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true);
                    $subcategory_image = wp_get_attachment_url($subcategory_image_id);
                    ?>
                    <a href="<?php echo esc_url(get_term_link($subcategory)); ?>" class="subcategory-card">
                        <?php if ($subcategory_image) : ?>
                            <img src="<?php echo esc_url($subcategory_image); ?>" alt="<?php echo esc_attr($subcategory->name); ?>">
                        <?php endif; ?>
                        <h3><?php echo esc_html($subcategory->name); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
// Add GSAP animations
add_action('wp_footer', function() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hero section animation
        gsap.from('.category-hero-content', {
            opacity: 0,
            y: 50,
            duration: 1,
            ease: 'power3.out'
        });

        // Products grid animation
        gsap.from('.products li', {
            opacity: 0,
            y: 30,
            duration: 0.8,
            stagger: {
                amount: 0.5,
                grid: 'auto'
            },
            scrollTrigger: {
                trigger: '.products',
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            }
        });

        // Subcategories animation
        gsap.from('.subcategory-card', {
            opacity: 0,
            y: 30,
            duration: 0.8,
            stagger: 0.2,
            scrollTrigger: {
                trigger: '.subcategories-grid',
                start: 'top 80%',
                toggleActions: 'play none none reverse'
            }
        });

        // Add hover animation for subcategory cards
        document.querySelectorAll('.subcategory-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, {
                    y: -10,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    y: 0,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });
    });
    </script>
    <?php
}, 20);

get_footer(); 