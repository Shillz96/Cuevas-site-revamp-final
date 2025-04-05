<?php
/**
 * Cuevas Western Wear - Front Page
 * New design with 4 full-screen sections and GSAP animations
 */

// Remove admin bar and clean up head
add_filter('show_admin_bar', '__return_false');
add_filter('pre_get_document_title', '__return_empty_string');
add_filter('body_class', 'cuevas_fullpage_body_class');

function cuevas_fullpage_body_class($classes) {
    $classes[] = 'fullpage-layout';
    return $classes;
}

get_header();

// Get customizer settings
$hero_settings = array(
    'banner_image' => get_theme_mod('homepage_banner_image', ''),
    'heading' => get_theme_mod('homepage_banner_heading', "IT'S RODEO SEASON"),
    'subheading' => get_theme_mod('homepage_banner_subheading', 'Quality western wear for the modern cowboy and cowgirl')
);

// Get gallery images from featured products
$gallery_images = cuevas_get_featured_product_gallery_images();

// Get featured products
$featured_products = cuevas_get_featured_products();

// Get product categories
$product_categories = cuevas_get_main_product_categories();
?>

<div id="fullpage">
    <!-- HOME SECTION -->
    <section class="section home-section" id="section-home">
        <div class="home-background" style="background-image: url('<?php echo esc_url($hero_settings['banner_image']); ?>')">
            <div class="overlay"></div>
        </div>
        <div class="section-content home-content">
            <h1 class="slide-up"><?php echo esc_html($hero_settings['heading']); ?></h1>
            <p class="slide-up"><?php echo esc_html($hero_settings['subheading']); ?></p>
            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="btn slide-up">Shop Now</a>
        </div>
    </section>

    <!-- GALLERY SECTION -->
    <section class="section gallery-section" id="section-gallery">
        <div class="section-content gallery-content">
            <div class="gallery-slider">
                <?php if (!empty($gallery_images)): ?>
                    <?php foreach ($gallery_images as $index => $image): ?>
                        <div class="gallery-slide <?php echo ($index === 0) ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                            <div class="inner-slide">
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                                <div class="slide-caption">
                                    <h3><?php echo esc_html($image['title']); ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="gallery-empty">
                        <p>No gallery images available</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($gallery_images)): ?>
                <div class="gallery-controls">
                    <button class="gallery-arrow prev" aria-label="Previous image">&larr;</button>
                    <div class="gallery-dots">
                        <?php foreach ($gallery_images as $index => $image): ?>
                            <button class="gallery-dot <?php echo ($index === 0) ? 'active' : ''; ?>" 
                                    data-index="<?php echo $index; ?>" 
                                    aria-label="Go to image <?php echo $index+1; ?>">
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <button class="gallery-arrow next" aria-label="Next image">&rarr;</button>
                </div>
                <div class="scroll-tip">
                    <span>Scroll to navigate gallery</span>
                    <div class="scroll-indicator"></div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FEATURED PRODUCTS SECTION -->
    <section class="section products-section" id="section-products">
        <div class="section-content products-content">
            <h2 class="fade-in">Featured Products</h2>
            <div class="products-grid">
                <?php
                if ($featured_products->have_posts()):
                    while ($featured_products->have_posts()): 
                        $featured_products->the_post();
                        wc_get_template_part('content', 'product');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- CATEGORIES SECTION -->
    <section class="section categories-section" id="section-categories">
        <div class="categories-background"></div>
        <div class="section-content categories-content">
            <h2 class="fade-in">Shop By Category</h2>
            <div class="categories-grid">
                <?php
                if (!empty($product_categories)):
                    $category_labels = ['Men', 'Women', 'Hats'];
                    foreach ($product_categories as $index => $category):
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                        $label = isset($category_labels[$index]) ? $category_labels[$index] : $category->name;
                ?>
                    <div class="category-card fade-in">
                        <a href="<?php echo get_term_link($category); ?>">
                            <div class="category-image" <?php if ($image): ?>style="background-image: url('<?php echo esc_url($image); ?>');"<?php endif; ?>>
                                <div class="category-overlay"></div>
                                <div class="category-title">Shop <?php echo esc_html($label); ?></div>
                            </div>
                        </a>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
</div>

<!-- Navigation dots -->
<div class="section-nav">
    <button data-section="0" class="active" aria-label="Home Section"></button>
    <button data-section="1" aria-label="Gallery Section"></button>
    <button data-section="2" aria-label="Products Section"></button>
    <button data-section="3" aria-label="Categories Section"></button>
</div>

<?php
/**
 * Helper function to get featured product gallery images
 */
function cuevas_get_featured_product_gallery_images() {
    $gallery_images = array();
    $max_images = 4; // Define the maximum number of images
    
    $featured_products_query = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'meta_key' => '_featured',
        'meta_value' => 'yes'
    ));

    if ($featured_products_query->have_posts()) {
        while ($featured_products_query->have_posts()) {
            $featured_products_query->the_post();
            $product = wc_get_product(get_the_ID());
            
            if (has_post_thumbnail()) {
                $gallery_images[] = array(
                    'url' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    'title' => get_the_title(),
                    'link' => get_permalink()
                );
            }
            
            $attachment_ids = $product->get_gallery_image_ids();
            foreach ($attachment_ids as $attachment_id) {
                $gallery_images[] = array(
                    'url' => wp_get_attachment_image_url($attachment_id, 'large'),
                    'title' => get_the_title(),
                    'link' => get_permalink()
                );
            }
            
            // Stop adding images if we've reached the limit
            if (count($gallery_images) >= $max_images) break; 
        }
        wp_reset_postdata();
    }
    
    // If fewer than max images were found, you might want to add placeholders or duplicate
    // For now, just return what we have, up to the max.
    return array_slice($gallery_images, 0, $max_images); 
}

/**
 * Helper function to get featured products
 */
function cuevas_get_featured_products() {
    return new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        'meta_key' => '_featured',
        'meta_value' => 'yes'
    ));
}

/**
 * Helper function to get main product categories
 */
function cuevas_get_main_product_categories() {
    return get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => 0,
        'number' => 3
    ));
}

get_footer();
?>