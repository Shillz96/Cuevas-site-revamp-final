<?php
/**
 * Cuevas Western Wear - Front Page
 */
get_header();

// Get hero section customizer settings
$hero_settings = array(
    'banner_image' => get_theme_mod('homepage_banner_image', ''),
    'heading' => get_theme_mod('homepage_banner_heading', "IT'S RODEO SEASON"),
    'subheading' => get_theme_mod('homepage_banner_subheading', 'Quality western wear for the modern cowboy and cowgirl')
);

// Get gallery images from featured products
$gallery_images = array();
$featured_products_query = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 6,
    'meta_key' => '_featured',
    'meta_value' => 'yes'
));

if ($featured_products_query->have_posts()) {
    while ($featured_products_query->have_posts()) {
        $featured_products_query->the_post();
        $product = wc_get_product(get_the_ID());
        
        // Get product gallery images
        $attachment_ids = $product->get_gallery_image_ids();
        
        // Add featured image first if exists
        if (has_post_thumbnail()) {
            $gallery_images[] = array(
                'url' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                'title' => get_the_title(),
                'link' => get_permalink()
            );
        }
        
        // Add gallery images
        foreach ($attachment_ids as $attachment_id) {
            $gallery_images[] = array(
                'url' => wp_get_attachment_image_url($attachment_id, 'large'),
                'title' => get_the_title(),
                'link' => get_permalink()
            );
        }
        
        // Limit to 6 images total
        if (count($gallery_images) >= 6) {
            break;
        }
    }
    wp_reset_postdata();
}

// Get featured products for products section
$featured_products = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'meta_key' => '_featured',
    'meta_value' => 'yes'
));

// Get product categories
$product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'parent' => 0
));
?>

<style>
/* Critical CSS for fullscreen sections */
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow: hidden;
}

.sections-container {
    height: 100vh;
    overflow: hidden;
    position: relative;
}

.section {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    will-change: transform;
}

/* Section-specific styles */
#home {
    background-color: #1a1a1a;
    color: white;
    z-index: 1;
}

#gallery {
    background-color: #2a2a2a;
    color: white;
    z-index: 2;
}

#products {
    background-color: #3a3a3a;
    color: white;
    z-index: 3;
}

#categories {
    background-color: #4a4a4a;
    color: white;
    z-index: 4;
}

.section-content {
    position: relative;
    z-index: 5;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
    opacity: 0;
    transform: translateY(30px);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.home-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
}

/* Navigation dots */
.section-nav {
    position: fixed;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1000;
}

.section-nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.section-nav li {
    margin: 15px 0;
}

.section-nav button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.7);
    background: transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.section-nav button.active {
    background: white;
    transform: scale(1.2);
}

/* Section content styles */
.section h2 {
    font-size: 3.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
    text-transform: uppercase;
}

.section p {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    max-width: 1200px;
    padding: 20px;
}

.gallery-item {
    position: relative;
    display: block;
    text-decoration: none;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-title {
    color: white;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    text-align: center;
    padding: 0 10px;
}

.gallery-view {
    color: #ffd700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.gallery-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 50px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.gallery-empty p {
    margin: 0;
    color: rgba(255, 255, 255, 0.7);
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    max-width: 1200px;
    padding: 20px;
}

.product-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-10px);
}

.product-card img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

.product-card h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.product-card .price {
    font-size: 1.25rem;
    color: #ffd700;
    margin-bottom: 15px;
}

/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    max-width: 1200px;
    padding: 20px;
}

.category-card {
    position: relative;
    aspect-ratio: 16/9;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
}

.category-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-card .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
}

.category-card:hover .overlay {
    background: rgba(0, 0, 0, 0.7);
}

.category-card h3 {
    color: white;
    font-size: 2rem;
    text-transform: uppercase;
}

.btn {
    display: inline-block;
    padding: 15px 30px;
    background: #ffd700;
    color: #1a1a1a;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    text-transform: uppercase;
    transition: all 0.3s ease;
    margin-top: 20px;
}

.btn:hover {
    background: #fff;
    transform: translateY(-2px);
}
</style>

<!-- Main container for all sections -->
<div class="sections-container">
    <!-- Home Section -->
    <section id="home" class="section active" data-section="0">
        <?php if ($hero_settings['banner_image']): ?>
            <img src="<?php echo esc_url($hero_settings['banner_image']); ?>" alt="" class="home-bg">
        <?php endif; ?>
        <div class="section-content">
            <h2><?php echo esc_html($hero_settings['heading']); ?></h2>
            <p><?php echo esc_html($hero_settings['subheading']); ?></p>
            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>" class="btn">Shop Now</a>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section" data-section="1">
        <div class="section-content">
            <h2>Our Gallery</h2>
            <p>Take a look at our latest collection and customer highlights</p>
            <div class="gallery-grid">
                <?php 
                if (!empty($gallery_images)):
                    foreach ($gallery_images as $image): 
                ?>
                    <a href="<?php echo esc_url($image['link']); ?>" class="gallery-item">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                        <div class="gallery-overlay">
                            <span class="gallery-title"><?php echo esc_html($image['title']); ?></span>
                            <span class="gallery-view">View Product</span>
                        </div>
                    </a>
                <?php 
                    endforeach;
                else:
                ?>
                    <div class="gallery-empty">
                        <p>No gallery images available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="section" data-section="2">
        <div class="section-content">
            <h2>Featured Products</h2>
            <p>Check out our most popular western wear</p>
            <div class="products-grid">
                <?php
                if ($featured_products->have_posts()):
                    while ($featured_products->have_posts()): $featured_products->the_post();
                        global $product;
                ?>
                    <div class="product-card">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                        <div class="price"><?php echo $product->get_price_html(); ?></div>
                        <a href="<?php the_permalink(); ?>" class="btn">View Product</a>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="section" data-section="3">
        <div class="section-content">
            <h2>Shop Categories</h2>
            <p>Find exactly what you're looking for</p>
            <div class="categories-grid">
                <?php
                if (!empty($product_categories)):
                    foreach ($product_categories as $category):
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                ?>
                    <a href="<?php echo get_term_link($category); ?>" class="category-card">
                        <?php if ($image): ?>
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                        <?php endif; ?>
                        <div class="overlay">
                            <h3><?php echo esc_html($category->name); ?></h3>
                        </div>
                    </a>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
</div>

<!-- Navigation Dots -->
<nav class="section-nav">
    <ul>
        <li><button data-section="0" class="active" aria-label="Home Section">Home</button></li>
        <li><button data-section="1" aria-label="Gallery Section">Gallery</button></li>
        <li><button data-section="2" aria-label="Products Section">Products</button></li>
        <li><button data-section="3" aria-label="Categories Section">Categories</button></li>
    </ul>
</nav>

<?php get_footer(); ?>