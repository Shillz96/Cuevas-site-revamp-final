<?php
/**
 * Cuevas Western Wear Theme Functions
 *
 * @package CuevasWesternWear
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme version
if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
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
 * Enqueue scripts and styles.
 */
function cuevas_theme_scripts() {
	// Main stylesheet
	wp_enqueue_style( 'cuevas-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	
	// Main CSS file
	wp_enqueue_style( 'cuevas-main', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION );
	
	// Animation CSS
	wp_enqueue_style( 'cuevas-animations', get_template_directory_uri() . '/assets/css/animations.css', array(), _S_VERSION );
	
	// Product card styles for WooCommerce products
	wp_enqueue_style( 'cuevas-product-card', get_template_directory_uri() . '/assets/css/product-card.css', array(), _S_VERSION );
	
	// Page hero styles
	wp_enqueue_style( 'cuevas-page-hero', get_template_directory_uri() . '/assets/css/page-hero.css', array(), _S_VERSION );
	
	// WooCommerce specific styles
	wp_enqueue_style( 'cuevas-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), _S_VERSION );
	
	// Homepage specific styles (only on front page)
	if (is_front_page()) {
		wp_enqueue_style( 'cuevas-home', get_template_directory_uri() . '/assets/css/home.css', array(), _S_VERSION );
	}
	
	// Font Awesome
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
	
	// Google Fonts
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap', array(), '1.0.0');
	
	// jQuery
	wp_enqueue_script('jquery');
	
	// GSAP Core - from CDN for better performance
	wp_enqueue_script('gsap-core', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', array(), '3.12.7', true);
	
	// GSAP ScrollTrigger
	wp_enqueue_script('gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js', array('gsap-core'), '3.12.7', true);
	
	// GSAP ScrollTo Plugin
	wp_enqueue_script('gsap-scrollto', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollToPlugin.min.js', array('gsap-core'), '3.12.7', true);
	
	// Navigation script
	wp_enqueue_script('cuevas-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), _S_VERSION, true);
	
	// Main animations
	wp_enqueue_script('cuevas-animations', get_template_directory_uri() . '/assets/js/animations.js', array('gsap-core', 'gsap-scrolltrigger'), _S_VERSION, true);

    // Page-specific scripts
    if (function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag() || is_product())) {
        wp_enqueue_script('cuevas-product-page', get_template_directory_uri() . '/assets/js/product-page.js', array('jquery', 'gsap-core'), '1.0.0', true);
    }

    if (is_front_page()) {
        wp_enqueue_script('cuevas-home-animations', get_template_directory_uri() . '/assets/js/home-animations.js', array('jquery', 'gsap-core', 'gsap-scrolltrigger', 'gsap-scrollto'), '1.0.0', true);
        wp_enqueue_script('cuevas-hero-customizer', get_template_directory_uri() . '/assets/js/hero-customizer.js', array('gsap-core'), _S_VERSION, true);
    }

    if (is_page_template('page-about.php')) {
        wp_enqueue_script('cuevas-about-animations', get_template_directory_uri() . '/assets/js/about-animations.js', array('jquery', 'gsap-core', 'gsap-scrolltrigger'), '1.0.0', true);
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

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cuevas_theme_scripts' );

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
        gsap.registerPlugin(ScrollTrigger);

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

        // Utility function for text reveal animations (simplified, no SplitText)
        window.createTextReveal = function(element, options = {}) {
            if (!element) return;
            
            const defaults = {
                duration: 0.8,
                ease: 'power2.out',
                y: 20,
                opacity: 0
            };

            // Simple animation without SplitText
            return gsap.from(element, {
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

/**
 * Add custom product attributes for western wear
 */
function cuevas_add_product_attributes() {
    $attributes = array(
        'boot-style' => 'Boot Style',
        'material' => 'Material',
        'heel-height' => 'Heel Height',
        'toe-shape' => 'Toe Shape',
        'shaft-height' => 'Shaft Height',
        'sole-type' => 'Sole Type',
        'hat-style' => 'Hat Style',
        'brim-width' => 'Brim Width',
        'crown-height' => 'Crown Height',
        'size-range' => 'Size Range',
        'color-variations' => 'Color Variations'
    );

    foreach ($attributes as $slug => $name) {
        wc_create_attribute(array(
            'name' => $name,
            'slug' => $slug,
            'type' => 'select',
            'order_by' => 'menu_order',
            'has_archives' => true
        ));
    }
}
add_action('init', 'cuevas_add_product_attributes');

/**
 * Add custom columns to WooCommerce product import
 */
function cuevas_add_custom_import_columns($columns) {
    $columns['boot_style'] = 'Boot Style';
    $columns['material'] = 'Material';
    $columns['heel_height'] = 'Heel Height';
    $columns['toe_shape'] = 'Toe Shape';
    $columns['shaft_height'] = 'Shaft Height';
    $columns['sole_type'] = 'Sole Type';
    $columns['hat_style'] = 'Hat Style';
    $columns['brim_width'] = 'Brim Width';
    $columns['crown_height'] = 'Crown Height';
    return $columns;
}
add_filter('woocommerce_csv_product_import_mapping_options', 'cuevas_add_custom_import_columns');

/**
 * Process custom columns during import
 */
function cuevas_process_custom_import_columns($object, $data) {
    $custom_fields = array(
        'boot_style',
        'material',
        'heel_height',
        'toe_shape',
        'shaft_height',
        'sole_type',
        'hat_style',
        'brim_width',
        'crown_height'
    );

    foreach ($custom_fields as $field) {
        if (!empty($data[$field])) {
            $object->update_meta_data('_' . $field, sanitize_text_field($data[$field]));
        }
    }

    return $object;
}
add_filter('woocommerce_product_import_inserted_product_object', 'cuevas_process_custom_import_columns', 10, 2);

/**
 * Add custom fields to product display
 */
function cuevas_display_custom_fields() {
    global $product;
    
    $custom_fields = array(
        'boot_style' => 'Boot Style',
        'material' => 'Material',
        'heel_height' => 'Heel Height',
        'toe_shape' => 'Toe Shape',
        'shaft_height' => 'Shaft Height',
        'sole_type' => 'Sole Type',
        'hat_style' => 'Hat Style',
        'brim_width' => 'Brim Width',
        'crown_height' => 'Crown Height'
    );

    echo '<div class="product-custom-fields">';
    foreach ($custom_fields as $field => $label) {
        $value = $product->get_meta('_' . $field);
        if (!empty($value)) {
            echo '<div class="custom-field">';
            echo '<span class="label">' . esc_html($label) . ': </span>';
            echo '<span class="value">' . esc_html($value) . '</span>';
            echo '</div>';
        }
    }
    echo '</div>';
}
add_action('woocommerce_single_product_summary', 'cuevas_display_custom_fields', 25);

/**
 * Add Customizer Options for Homepage
 */
function cuevas_customize_register($wp_customize) {
    // Add Homepage Banner Section
    $wp_customize->add_section('cuevas_homepage_banner', array(
        'title'    => __('Homepage Hero Banner', 'cuevas'),
        'priority' => 130,
    ));
    
    // Add Banner Background Image Setting
    $wp_customize->add_setting('homepage_banner_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    // Add Banner Background Image Control
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'homepage_banner_image', array(
        'label'    => __('Banner Background Image', 'cuevas'),
        'description' => __('Upload an image for the homepage hero banner background', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'settings' => 'homepage_banner_image',
    )));
    
    // Add Image Fit Setting
    $wp_customize->add_setting('homepage_banner_image_fit', array(
        'default'           => 'cover',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Image Fit Control
    $wp_customize->add_control('homepage_banner_image_fit', array(
        'label'    => __('Background Image Fit', 'cuevas'),
        'description' => __('How the image should fit in the banner area', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'select',
        'choices'  => array(
            'cover'    => __('Cover (fills entire area, may crop)', 'cuevas'),
            'contain'  => __('Contain (shows entire image, may leave space)', 'cuevas'),
            'auto'     => __('Auto (original size)', 'cuevas'),
        ),
    ));
    
    // Add Image Position Setting
    $wp_customize->add_setting('homepage_banner_image_position', array(
        'default'           => 'center center',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Image Position Control
    $wp_customize->add_control('homepage_banner_image_position', array(
        'label'    => __('Background Image Position', 'cuevas'),
        'description' => __('Position of the image in the banner area', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'select',
        'choices'  => array(
            'center center' => __('Center (default)', 'cuevas'),
            'top center'    => __('Top', 'cuevas'),
            'bottom center' => __('Bottom', 'cuevas'),
            'center left'   => __('Left', 'cuevas'),
            'center right'  => __('Right', 'cuevas'),
            'top left'      => __('Top Left', 'cuevas'),
            'top right'     => __('Top Right', 'cuevas'),
            'bottom left'   => __('Bottom Left', 'cuevas'),
            'bottom right'  => __('Bottom Right', 'cuevas'),
        ),
    ));
    
    // Add Banner Overlay Opacity Setting
    $wp_customize->add_setting('homepage_banner_overlay_opacity', array(
        'default'           => '0.4',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Banner Overlay Opacity Control
    $wp_customize->add_control('homepage_banner_overlay_opacity', array(
        'label'    => __('Banner Overlay Opacity', 'cuevas'),
        'description' => __('Control the darkness of the overlay (0 = transparent, 1 = black)', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'select',
        'choices'  => array(
            '0'    => __('No Overlay', 'cuevas'),
            '0.2'  => __('Very Light', 'cuevas'),
            '0.4'  => __('Light', 'cuevas'),
            '0.6'  => __('Medium', 'cuevas'),
            '0.8'  => __('Dark', 'cuevas'),
            '0.9'  => __('Very Dark', 'cuevas'),
        ),
    ));
    
    // Add Banner Height Setting
    $wp_customize->add_setting('homepage_banner_height', array(
        'default'           => '80vh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Banner Height Control
    $wp_customize->add_control('homepage_banner_height', array(
        'label'    => __('Banner Height', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'select',
        'choices'  => array(
            '50vh'  => __('Short', 'cuevas'),
            '65vh'  => __('Medium', 'cuevas'),
            '80vh'  => __('Tall (Default)', 'cuevas'),
            '100vh' => __('Full Screen', 'cuevas'),
        ),
    ));
    
    // Add Banner Heading Setting
    $wp_customize->add_setting('homepage_banner_heading', array(
        'default'           => "IT'S RODEO SEASON",
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Banner Heading Control
    $wp_customize->add_control('homepage_banner_heading', array(
        'label'    => __('Banner Heading', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'text',
    ));
    
    // Add Banner Subheading Setting
    $wp_customize->add_setting('homepage_banner_subheading', array(
        'default'           => 'Quality western wear for the modern cowboy and cowgirl',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Banner Subheading Control
    $wp_customize->add_control('homepage_banner_subheading', array(
        'label'    => __('Banner Subheading', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'text',
    ));
    
    // Add Primary Button Text Setting
    $wp_customize->add_setting('homepage_primary_button_text', array(
        'default'           => 'Shop Now',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Primary Button Text Control
    $wp_customize->add_control('homepage_primary_button_text', array(
        'label'    => __('Primary Button Text', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'text',
    ));
    
    // Add Secondary Button Text Setting
    $wp_customize->add_setting('homepage_secondary_button_text', array(
        'default'           => 'Our Story',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Secondary Button Text Control
    $wp_customize->add_control('homepage_secondary_button_text', array(
        'label'    => __('Secondary Button Text', 'cuevas'),
        'section'  => 'cuevas_homepage_banner',
        'type'     => 'text',
    ));
    
    // Add Promotional Banner Section
    $wp_customize->add_section('cuevas_promo_banner', array(
        'title'    => __('Promotional Banner', 'cuevas'),
        'description' => __('Settings for the promotional banner below the hero section.', 'cuevas'),
        'priority' => 131,
    ));
    
    // Add Promo Banner Heading Setting
    $wp_customize->add_setting('promo_banner_heading', array(
        'default'           => 'SHOP BY CATEGORY',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Promo Banner Heading Control
    $wp_customize->add_control('promo_banner_heading', array(
        'label'    => __('Promotional Banner Heading', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'text',
    ));
    
    // Add Promo Banner Text Setting
    $wp_customize->add_setting('promo_banner_text', array(
        'default'           => 'Explore our collection of premium western wear',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    // Add Promo Banner Text Control
    $wp_customize->add_control('promo_banner_text', array(
        'label'    => __('Promotional Banner Text', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'text',
    ));
    
    // Button 1 Settings
    $wp_customize->add_setting('promo_banner_button1_text', array(
        'default'           => 'Men\'s',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('promo_banner_button1_text', array(
        'label'    => __('Button 1 Text', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'text',
    ));
    
    // Get all product categories for dropdown
    $product_cats = array('' => 'Select a category');
    if (taxonomy_exists('product_cat')) {
        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));
        
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $cat) {
                $product_cats[$cat->slug] = $cat->name;
            }
        }
    }
    
    $wp_customize->add_setting('promo_banner_button1_link', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('promo_banner_button1_link', array(
        'label'    => __('Button 1 Link (Category)', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'select',
        'choices'  => $product_cats,
    ));
    
    // Button 2 Settings
    $wp_customize->add_setting('promo_banner_button2_text', array(
        'default'           => 'Women\'s',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('promo_banner_button2_text', array(
        'label'    => __('Button 2 Text', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('promo_banner_button2_link', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('promo_banner_button2_link', array(
        'label'    => __('Button 2 Link (Category)', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'select',
        'choices'  => $product_cats,
    ));
    
    // Button 3 Settings
    $wp_customize->add_setting('promo_banner_button3_text', array(
        'default'           => 'Hats',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('promo_banner_button3_text', array(
        'label'    => __('Button 3 Text', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'text',
    ));
    
    $wp_customize->add_setting('promo_banner_button3_link', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('promo_banner_button3_link', array(
        'label'    => __('Button 3 Link (Category)', 'cuevas'),
        'section'  => 'cuevas_promo_banner',
        'type'     => 'select',
        'choices'  => $product_cats,
    ));
    
    // Add Bottom Promo Section
    $wp_customize->add_section('cuevas_bottom_promo', array(
        'title'    => __('Bottom Promotional Section', 'cuevas'),
        'priority' => 132,
    ));
    
    // Add Promotional Section Background Image Setting
    $wp_customize->add_setting('homepage_promo_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    // Add Promotional Section Background Image Control
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'homepage_promo_image', array(
        'label'    => __('Background Image', 'cuevas'),
        'description' => __('Upload an image for the bottom promotional section background', 'cuevas'),
        'section'  => 'cuevas_bottom_promo',
        'settings' => 'homepage_promo_image',
    )));

    // Add Featured Products Section
    $wp_customize->add_section('cuevas_featured_products', array(
        'title'    => __('Featured Products Slider', 'cuevas'),
        'priority' => 131,
    ));
    
    // Add up to 5 featured product image settings
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting('featured_product_image_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'featured_product_image_' . $i, array(
            'label'       => sprintf(__('Featured Product Image %d', 'cuevas'), $i),
            'description' => __('Upload a full-screen image for the featured products slider', 'cuevas'),
            'section'     => 'cuevas_featured_products',
            'settings'    => 'featured_product_image_' . $i,
        )));
    }
}
add_action('customize_register', 'cuevas_customize_register');

/**
 * Debugging function to verify featured images (only visible to admins)
 */
function cuevas_debug_featured_images() {
    if (!is_front_page() || !current_user_can('administrator')) {
        return;
    }
    
    // Get featured product images from customizer
    $featured_images = array();
    for ($i = 1; $i <= 5; $i++) {
        $image = get_theme_mod('featured_product_image_' . $i);
        if ($image) {
            $featured_images[$i] = $image;
        }
    }
    
    if (empty($featured_images)) {
        echo '<div style="position: fixed; bottom: 0; right: 0; background: red; color: white; padding: 10px; z-index: 9999; font-size: 12px;">
            No featured product images found in customizer. Add them in Customizer > Featured Products Slider.
        </div>';
    } else {
        echo '<div style="position: fixed; bottom: 0; right: 0; background: green; color: white; padding: 10px; z-index: 9999; font-size: 12px; max-width: 300px; overflow: auto;">';
        echo 'Found ' . count($featured_images) . ' featured product images.<br>';
        foreach ($featured_images as $key => $url) {
            echo "Image $key: " . basename($url) . "<br>";
        }
        echo '</div>';
    }
}
add_action('wp_footer', 'cuevas_debug_featured_images', 100);

/**
 * Add admin notice to help with featured slider setup
 */
function cuevas_featured_slider_admin_notice() {
    $screen = get_current_screen();
    
    // Only show on dashboard and customizer
    if (!($screen->id === 'dashboard' || $screen->id === 'customize')) {
        return;
    }
    
    // Count featured images
    $count = 0;
    for ($i = 1; $i <= 5; $i++) {
        if (get_theme_mod('featured_product_image_' . $i)) {
            $count++;
        }
    }
    
    // Show notice if less than 2 images
    if ($count < 2) {
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong>Cuevas Theme:</strong> For the featured product slider to work correctly, please add at least 2-3 images in <a href="<?php echo admin_url('customize.php?autofocus[section]=cuevas_featured_products'); ?>">Customizer &gt; Featured Products Slider</a>.</p>
            <p>Images should be high quality and at least 1920×1080px in size for best results.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'cuevas_featured_slider_admin_notice');

/**
 * Disable all GSAP animations in customizer preview to prevent errors
 */
function cuevas_disable_gsap_in_customizer() {
    // Only modify scripts in customizer preview
    if (is_customize_preview()) {
        // Remove all GSAP-related scripts in customizer preview
        wp_dequeue_script('gsap-core');
        wp_dequeue_script('gsap-scrolltrigger');
        wp_dequeue_script('gsap-scrollto');
        wp_dequeue_script('cuevas-animations');
        wp_dequeue_script('cuevas-home-animations');
        wp_dequeue_script('cuevas-about-animations');
        wp_dequeue_script('cuevas-product-page');
        wp_dequeue_script('cuevas-hero-customizer');
        
        // Add a simple CSS-only fallback for the customizer
        add_action('wp_head', 'cuevas_add_customizer_css');
    }
}
add_action('wp_enqueue_scripts', 'cuevas_disable_gsap_in_customizer', 100);

/**
 * Add simple CSS animations for customizer preview
 */
function cuevas_add_customizer_css() {
    if (!is_customize_preview()) {
        return;
    }
    ?>
    <style>
    /* Simple customizer animations */
    .hero-title, .hero-subtitle {
        opacity: 1 !important;
        transform: none !important;
    }
    
    /* Featured slider in customizer */
    .featured-slide {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 1.5s ease;
        transform: none !important;
    }
    
    /* Make first slide visible */
    .featured-slide:first-child {
        opacity: 1;
        z-index: 2;
    }
    
    /* Simple slide rotation */
    @keyframes slideFade {
        0%, 20% { opacity: 1; z-index: 2; }
        25%, 95% { opacity: 0; z-index: 1; }
        100% { opacity: 0; z-index: 1; }
    }
    
    /* Apply animation to each slide */
    .featured-section .featured-slide {
        animation: slideFade 16s infinite;
    }
    
    .featured-section .featured-slide:nth-child(2) {
        animation-delay: 4s;
    }
    
    .featured-section .featured-slide:nth-child(3) {
        animation-delay: 8s;
    }
    
    .featured-section .featured-slide:nth-child(4) {
        animation-delay: 12s;
    }
    
    .featured-section .featured-slide:nth-child(5) {
        animation-delay: 16s;
    }
    
    /* Progress bar animation */
    .progress-fill {
        animation: progressAnim 16s infinite linear;
        width: 0;
    }
    
    @keyframes progressAnim {
        0% { width: 0; }
        100% { width: 100%; }
    }
    
    /* Fix for slide content */
    .slide-number {
        opacity: 1 !important;
        transform: none !important;
    }
    </style>
    <script>
    // Simple script to make the customizer preview work without GSAP
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Simple customizer animation fallback loaded');
    });
    </script>
    <?php
}

/**
 * Clean up old functions that might be causing conflicts
 */
function cuevas_remove_conflicting_functions() {
    // Remove all potentially conflicting functions
    remove_action('wp_footer', 'cuevas_customizer_preview_scripts', 5);
    remove_action('wp_enqueue_scripts', 'cuevas_enqueue_gsap_with_fallback', 999);
}
add_action('init', 'cuevas_remove_conflicting_functions');

/**
 * Priority GSAP loading for homepage
 */
function cuevas_priority_gsap_loading() {
    // Check if we're on the front page
    if (is_front_page()) {
        // Remove the disable GSAP in customizer function for the front page
        remove_action('wp_enqueue_scripts', 'cuevas_disable_gsap_in_customizer', 100);
        
        // First deregister any existing GSAP scripts to avoid conflicts
        wp_deregister_script('gsap');
        wp_deregister_script('gsap-core');
        wp_deregister_script('gsap-scrolltrigger');
        wp_deregister_script('gsap-scrollto');
        
        // Register GSAP with both 'gsap' and 'gsap-core' handles to ensure compatibility
        wp_register_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', array(), '3.12.7', false);
        wp_register_script('gsap-core', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', array(), '3.12.7', false);
        
        // Register ScrollTrigger and ScrollToPlugin
        wp_register_script('scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js', array('gsap'), '3.12.7', false);
        wp_register_script('scrollto', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollToPlugin.min.js', array('gsap'), '3.12.7', false);
        
        // Also register with the gsap- prefix for backward compatibility
        wp_register_script('gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js', array('gsap'), '3.12.7', false);
        wp_register_script('gsap-scrollto', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollToPlugin.min.js', array('gsap'), '3.12.7', false);
        
        // Enqueue all scripts
        wp_enqueue_script('gsap');
        wp_enqueue_script('scrolltrigger');
        wp_enqueue_script('scrollto');
        
        // Re-register and enqueue home-animations.js with correct dependencies
        wp_deregister_script('cuevas-home-animations');
        wp_register_script('cuevas-home-animations', get_template_directory_uri() . '/assets/js/home-animations.js', array('jquery', 'gsap', 'scrolltrigger', 'scrollto'), '1.0.0', true);
        wp_enqueue_script('cuevas-home-animations');
    }
}
add_action('wp_enqueue_scripts', 'cuevas_priority_gsap_loading', 5);

/**
 * Add home page specific styles
 */
function cuevas_add_home_page_inline_styles() {
    if (!is_front_page()) {
        return;
    }
    
    ?>
    <style>
    /* Initial styles to prevent flash of unstyled content */
    html, body {
        overflow-x: hidden;
    }
    
    /* Initial state for transitions */
    .fullpage-wrapper {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    
    .fullpage-wrapper.initialized {
        opacity: 1;
    }
    
    /* Hero text visibility */
    .hero-title, .hero-subtitle {
        opacity: 1 !important;
    }
    
    /* Add overlay to hero section if needed */
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    /* When javascript is disabled */
    .no-js .fullpage-wrapper {
        opacity: 1;
    }
    </style>
    <script>
    // Initialize on DOMContentLoaded 
    document.addEventListener('DOMContentLoaded', function() {
        // Check if GSAP is available
        if (typeof gsap !== 'undefined') {
            console.log('GSAP found in early initialization');
            
            if (typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);
                console.log('ScrollTrigger registered early');
            }
            
            if (typeof ScrollToPlugin !== 'undefined') {
                gsap.registerPlugin(ScrollToPlugin);
                console.log('ScrollToPlugin registered early');
            }
        } else {
            console.error('GSAP not found! Check script loading.');
        }
    });
    
    // Full initialization on page load
    window.addEventListener('load', function() {
        // Fade in the page
        setTimeout(function() {
            var wrapper = document.querySelector('.fullpage-wrapper');
            if (wrapper) {
                wrapper.classList.add('initialized');
            }
        }, 100);

        // Ensure proper scrolling
        document.documentElement.style.overflowX = 'hidden';
        document.documentElement.style.overflowY = 'auto';
    });
    </script>
    <?php
}
add_action('wp_head', 'cuevas_add_home_page_inline_styles', 5); // Higher priority for earlier loading 

// Register WP-CLI commands if WP-CLI is available
if (defined('WP_CLI') && WP_CLI) {
    require_once get_template_directory() . '/cli/add-mock-products.php';
}

// Register WP-CLI commands
if (defined('WP_CLI') && WP_CLI) {
    require_once get_template_directory() . '/wp-cli-commands.php';
} 