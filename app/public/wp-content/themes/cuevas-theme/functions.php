<?php
/**
 * Cuevas Western Wear Theme Functions
 *
 * @package CuevasWesternWear
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
function cuevas_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'cuevas'),
        'footer'  => esc_html__('Footer Menu', 'cuevas'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Content width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'cuevas_theme_setup');

/**
 * Register widget areas
 */
function cuevas_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'cuevas'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in sidebar.', 'cuevas'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'cuevas'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in footer column 1.', 'cuevas'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-heading">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'cuevas'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in footer column 2.', 'cuevas'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-heading">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'cuevas'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in footer column 3.', 'cuevas'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-heading">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 4', 'cuevas'),
        'id'            => 'footer-4',
        'description'   => esc_html__('Add widgets here to appear in footer column 4.', 'cuevas'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-heading">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'cuevas_widgets_init');

/**
 * Enqueue scripts and styles
 */
function cuevas_enqueue_scripts() {
    // Styles
    wp_enqueue_style('cuevas-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap', array(), '1.0.0');
    
    // Scripts
    wp_enqueue_script('jquery');
    
    // GSAP Core and Plugins
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true);
    wp_enqueue_script('gsap-splittext', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/SplitText.min.js', array('gsap'), '3.12.5', true);
    
    // Theme Scripts
    wp_enqueue_script('cuevas-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('cuevas-animations', get_template_directory_uri() . '/assets/js/animations.js', array('gsap', 'gsap-scrolltrigger', 'gsap-splittext'), '1.0.0', true);

    // Page-specific scripts
    if (function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag() || is_product())) {
        wp_enqueue_script('cuevas-product-page', get_template_directory_uri() . '/assets/js/product-page.js', array('jquery', 'gsap'), '1.0.0', true);
    }

    if (is_front_page()) {
        wp_enqueue_script('cuevas-home-animations', get_template_directory_uri() . '/assets/js/home-animations.js', array('jquery', 'gsap', 'gsap-scrolltrigger'), '1.0.0', true);
    }

    if (is_page_template('page-about.php')) {
        wp_enqueue_script('cuevas-about-animations', get_template_directory_uri() . '/assets/js/about-animations.js', array('jquery', 'gsap', 'gsap-scrolltrigger'), '1.0.0', true);
    }

    // Localize script for GSAP configuration
    wp_localize_script('cuevas-animations', 'cuevasAnimConfig', array(
        'isMobile' => wp_is_mobile(),
        'breakpoints' => array(
            'mobile' => 768,
            'tablet' => 1024,
            'desktop' => 1200
        ),
        'animationDefaults' => array(
            'duration' => 0.8,
            'ease' => 'power2.out'
        )
    ));
}
add_action('wp_enqueue_scripts', 'cuevas_enqueue_scripts');

/**
 * Setup WooCommerce Support
 */
function cuevas_woocommerce_setup() {
    // Check if WooCommerce is active before adding support
    if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
}
add_action('after_setup_theme', 'cuevas_woocommerce_setup');

/**
 * Remove default WooCommerce styles
 */
// Only remove WooCommerce styles if WooCommerce is active
if (class_exists('WooCommerce')) {
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
}

/**
 * Change number of products displayed per page
 */
function cuevas_loop_shop_per_page($cols) {
    return 12; // Display 12 products per page
}
// Only add this filter if WooCommerce is active
if (class_exists('WooCommerce')) {
    add_filter('loop_shop_per_page', 'cuevas_loop_shop_per_page', 20);
}

/**
 * Change number of related products
 */
function cuevas_related_products_args($args) {
    $args['posts_per_page'] = 4; // 4 related products
    $args['columns'] = 4; // arranged in 4 columns
    return $args;
}
// Only add this filter if WooCommerce is active
if (class_exists('WooCommerce')) {
    add_filter('woocommerce_output_related_products_args', 'cuevas_related_products_args');
}

/**
 * Add custom body classes
 */
function cuevas_body_classes($classes) {
    // Add page slug as class
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }

    // If is shop page
    if (function_exists('is_shop') && is_shop()) {
        $classes[] = 'shop-page';
    }

    return $classes;
}
add_filter('body_class', 'cuevas_body_classes');

/**
 * Custom template tags for this theme
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Create template-tags.php file if it doesn't exist
 */
if (!file_exists(get_template_directory() . '/inc/template-tags.php')) {
    if (!file_exists(get_template_directory() . '/inc')) {
        mkdir(get_template_directory() . '/inc', 0755, true);
    }
    
    $template_tags_content = '<?php
/**
 * Custom template tags for Cuevas theme
 *
 * @package CuevasWesternWear
 */

if (!defined(\'ABSPATH\')) {
    exit; // Exit if accessed directly
}

/**
 * Prints HTML with meta information for categories, tags and comments.
 */
function cuevas_entry_meta() {
    // Post meta implementation
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function cuevas_categorized_blog() {
    $all_cats = get_transient(\'cuevas_categories\');
    if (false === $all_cats) {
        $all_cats = get_categories(array(
            \'fields\'     => \'ids\',
            \'hide_empty\' => 1,
        ));
        
        // Count categories that have posts
        $all_cats = count($all_cats);
        
        set_transient(\'cuevas_categories\', $all_cats);
    }
    
    if ($all_cats > 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * Flush out the transients used in cuevas_categorized_blog.
 */
function cuevas_category_transient_flusher() {
    if (defined(\'DOING_AUTOSAVE\') && DOING_AUTOSAVE) {
        return;
    }
    delete_transient(\'cuevas_categories\');
}
add_action(\'edit_category\', \'cuevas_category_transient_flusher\');
add_action(\'save_post\', \'cuevas_category_transient_flusher\');
';
    
    file_put_contents(get_template_directory() . '/inc/template-tags.php', $template_tags_content);
}

/**
 * WooCommerce wrapper functions
 */
function cuevas_woocommerce_wrapper_before() {
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
    <?php
}
add_action('woocommerce_before_main_content', 'cuevas_woocommerce_wrapper_before', 10);

function cuevas_woocommerce_wrapper_after() {
    ?>
        </main><!-- #main -->
    </div><!-- #primary -->
    <?php
}
add_action('woocommerce_after_main_content', 'cuevas_woocommerce_wrapper_after', 10);

/**
 * Initialize GSAP animations
 */
function cuevas_initialize_gsap() {
    if (is_admin()) {
        return;
    }
    ?>
    <script>
        // Register GSAP plugins
        gsap.registerPlugin(ScrollTrigger, SplitText);

        // Default GSAP configuration
        gsap.config({
            nullTargetWarn: false,
            autoSleep: 60,
            force3D: true
        });

        // Default ScrollTrigger configuration
        ScrollTrigger.config({
            autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load,resize'
        });

        // Utility function for staggered animations
        window.createStaggerAnimation = function(elements, fromVars = {}, toVars = {}) {
            const defaults = {
                duration: cuevasAnimConfig.animationDefaults.duration,
                ease: cuevasAnimConfig.animationDefaults.ease,
                stagger: 0.2
            };

            return gsap.from(elements, {
                ...defaults,
                ...fromVars,
                scrollTrigger: {
                    trigger: elements,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse',
                    ...toVars.scrollTrigger
                }
            });
        };

        // Utility function for text reveal animations
        window.createTextReveal = function(element, options = {}) {
            const splitText = new SplitText(element, {
                type: 'lines,words,chars',
                linesClass: 'split-line'
            });

            const defaults = {
                duration: 0.8,
                ease: 'power2.out',
                stagger: 0.02
            };

            return gsap.from(splitText.chars, {
                ...defaults,
                ...options,
                scrollTrigger: {
                    trigger: element,
                    start: 'top 80%',
                    toggleActions: 'play none none reverse',
                    ...options.scrollTrigger
                }
            });
        };
    </script>
    <?php
}
add_action('wp_footer', 'cuevas_initialize_gsap', 10); 