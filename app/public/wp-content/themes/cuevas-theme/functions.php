<?php
/**
 * Cuevas Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cuevas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define theme version
if ( ! defined( 'CUEVAS_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'CUEVAS_VERSION', '1.1.0' ); // Use a specific version or wp_get_theme()->get('Version')
}

// Define theme paths
define( 'CUEVAS_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'CUEVAS_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );

/**
 * Load Theme Setup functions.
 */
// require_once CUEVAS_THEME_DIR . 'inc/theme-setup.php'; // TODO: Move setup code here

/**
 * Load Enqueue functions for scripts and styles.
 */
require_once CUEVAS_THEME_DIR . 'inc/enqueue.php';

/**
 * Load Custom Template Tags.
 */
// require_once CUEVAS_THEME_DIR . 'inc/template-tags.php'; // TODO: Move template tags here

/**
 * Load Helper Functions.
 */
// require_once CUEVAS_THEME_DIR . 'inc/helpers.php'; // TODO: Move helper functions here

/**
 * Load WooCommerce specific functions if WooCommerce is active.
 */
// if ( class_exists( 'WooCommerce' ) ) { // TODO: Move WooCommerce functions here
// 	require_once CUEVAS_THEME_DIR . 'inc/woocommerce.php';
// }

/**
 * Load WP-CLI commands if running via CLI.
 */
// if ( defined( 'WP_CLI' ) && WP_CLI ) { // TODO: Move WP-CLI commands here
// 	require_once CUEVAS_THEME_DIR . 'inc/wp-cli.php';
// }

/**
 * Load Debug functions (Optional: conditionally load based on WP_DEBUG).
 */
// if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) { // TODO: Move Debug functions here
//     require_once CUEVAS_THEME_DIR . 'inc/debug.php';
// }

// --- START: Keep existing functions until moved --- 

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


// --- REMOVE THE OLD enqueue function cuevas_theme_scripts() as it's handled by inc/enqueue.php ---
/* 
function cuevas_theme_scripts() { 
    // ... OLD ENQUEUE CODE WAS HERE ... 
}
add_action('wp_enqueue_scripts', 'cuevas_theme_scripts');
*/

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
 * Customize number of products displayed per page
 */
function cuevas_loop_shop_per_page($cols) {
    return 12; // Or your desired number
}
add_filter('loop_shop_per_page', 'cuevas_loop_shop_per_page', 20);

/**
 * Customize related products arguments
 */
function cuevas_related_products_args($args) {
    $args['posts_per_page'] = 4; // number of related products
    $args['columns'] = 4; // number of columns
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'cuevas_related_products_args');

/**
 * Add custom classes to the body tag
 */
function cuevas_body_classes($classes) {
    // Add class if sidebar is active
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }

    // Add class for specific pages/templates if needed
    if (is_front_page()) {
        $classes[] = 'cuevas-front-page';
    }
    
    if (is_singular('product')) {
        $classes[] = 'cuevas-product-page';
    }
    
    if (function_exists('is_woocommerce') && is_woocommerce()) {
        $classes[] = 'woocommerce-active';
        if (is_shop() || is_product_category() || is_product_tag()) {
            $classes[] = 'cuevas-archive-product';
        }
    }

    // Add fullpage class for front-page specific styles/scripts
    if (is_front_page()) {
        $classes[] = 'fullpage-layout'; // This class was added conditionally before, ensure it's here
    }

    return $classes;
}
add_filter('body_class', 'cuevas_body_classes');

/**
 * WooCommerce Wrapper functions
 */
function cuevas_woocommerce_wrapper_before() {
    echo '<div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
}
add_action('woocommerce_before_main_content', 'cuevas_woocommerce_wrapper_before');

function cuevas_woocommerce_wrapper_after() {
    echo '</main></div>';
}
add_action('woocommerce_after_main_content', 'cuevas_woocommerce_wrapper_after');

// Remove default WooCommerce sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/**
 * GSAP Initialization Logic (Keep this section or move relevant parts to inc/enqueue.php or specific JS files)
 * This might be redundant if JS files handle their own initialization.
 */
function cuevas_initialize_gsap() {
    // This function appears to be intended to set up defaults or configurations.
    // Consider if this logic is better placed within the JS files themselves
    // or passed via wp_localize_script in inc/enqueue.php.
    // Example: Setting default ease, registering plugins if not done via CDN enqueue.
    
    // If GSAP isn't loaded via CDN in enqueue.php, you might register/enqueue local files here.
    
    // Example of localizing data (should be in inc/enqueue.php):
    /*
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
    */
    // If this function isn't actually doing anything critical, it can likely be removed.
}
// add_action('wp_enqueue_scripts', 'cuevas_initialize_gsap', 20); // Maybe remove this hook call


/**
 * Add inline styles for the home page (Consider moving to home.css)
 */
function cuevas_add_home_page_styles() {
    if (is_front_page()) {
        $banner_image = get_theme_mod('homepage_banner_image', '');
        $custom_css = "
            .home-section .home-background {
                background-image: url(" . esc_url($banner_image) . ");
            }
        ";
        // Add other dynamic styles here...

        wp_add_inline_style('cuevas-style', $custom_css);
    }
}
add_action('wp_enqueue_scripts', 'cuevas_add_home_page_styles', 20);

/**
 * WordPress Cleanup functions (Consider moving to inc/theme-setup.php or inc/helpers.php)
 */
function cuevas_cleanup_wordpress() {
    // Remove WP version meta tag
    remove_action('wp_head', 'wp_generator');
    // Remove Windows Live Writer manifest link
    remove_action('wp_head', 'wlwmanifest_link');
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    // Remove adjacent posts links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    // Remove REST API link
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    // Remove oEmbed discovery links
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
    // Remove REST API header
    remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
    
    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');
}
add_action('init', 'cuevas_cleanup_wordpress');


/**
 * Add Custom Product Attributes Display (Consider moving to inc/woocommerce.php or inc/template-tags.php)
 */
function cuevas_add_product_attributes() {
    global $product;
    if ($product && $product->has_attributes()) {
        echo '<div class="product-attributes-section">';
        echo '<h4>Product Specifications</h4>';
        wc_display_product_attributes($product);
        echo '</div>';
    }
}
add_action('woocommerce_single_product_summary', 'cuevas_add_product_attributes', 25);

/**
 * Add custom columns to WooCommerce product importer (Consider moving to inc/woocommerce.php)
 */
function cuevas_add_custom_import_columns($columns) {
    $columns['custom_field_1'] = 'Custom Field 1';
    // Add more custom columns as needed
    return $columns;
}
// add_filter('woocommerce_csv_product_import_mapping_options', 'cuevas_add_custom_import_columns'); // Uncomment if using

/**
 * Process custom columns during WooCommerce product import (Consider moving to inc/woocommerce.php)
 */
function cuevas_process_custom_import_columns($object, $data) {
    if (isset($data['custom_field_1'])) {
        $object->update_meta_data('_custom_field_1', sanitize_text_field($data['custom_field_1']));
    }
    // Process more custom columns as needed
    return $object;
}
// add_filter('woocommerce_product_import_pre_insert_product_object', 'cuevas_process_custom_import_columns', 10, 2); // Uncomment if using

/**
 * Display custom fields on the product page (Consider moving to inc/woocommerce.php or inc/template-tags.php)
 */
function cuevas_display_custom_fields() {
    global $product;
    $custom_field_1 = $product->get_meta('_custom_field_1');

    if (!empty($custom_field_1)) {
        echo '<div class="custom-product-field">';
        echo '<strong>Custom Field 1:</strong> ' . esc_html($custom_field_1);
        echo '</div>';
    }
    // Display more custom fields as needed
}
// add_action('woocommerce_single_product_summary', 'cuevas_display_custom_fields', 35); // Uncomment if using

/**
 * Add Customizer settings (Consider moving relevant parts to a dedicated customizer file in inc/)
 */
function cuevas_customize_register($wp_customize) {

    // --- Home Page Section ---
    $wp_customize->add_section('cuevas_homepage_settings', array(
        'title' => __('Home Page Settings', 'cuevas'),
        'priority' => 30,
    ));

    // Banner Image
    $wp_customize->add_setting('homepage_banner_image', array(
        'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'homepage_banner_image', array(
        'label' => __('Hero Banner Image', 'cuevas'),
        'section' => 'cuevas_homepage_settings',
        'settings' => 'homepage_banner_image',
    )));

    // Banner Heading
    $wp_customize->add_setting('homepage_banner_heading', array(
        'default' => 'IT\'S RODEO SEASON',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('homepage_banner_heading', array(
        'label' => __('Hero Banner Heading', 'cuevas'),
        'section' => 'cuevas_homepage_settings',
        'type' => 'text',
    ));

    // Banner Subheading
    $wp_customize->add_setting('homepage_banner_subheading', array(
        'default' => 'Quality western wear for the modern cowboy and cowgirl',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('homepage_banner_subheading', array(
        'label' => __('Hero Banner Subheading', 'cuevas'),
        'section' => 'cuevas_homepage_settings',
        'type' => 'textarea',
    ));

    // --- Footer Section ---
    $wp_customize->add_section('cuevas_footer_settings', array(
        'title' => __('Footer Settings', 'cuevas'),
        'priority' => 120,
    ));

    // Copyright Text
    $wp_customize->add_setting('footer_copyright_text', array(
        'default' => '© ' . date('Y') . ' Cuevas Western Wear. All Rights Reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_copyright_text', array(
        'label' => __('Footer Copyright Text', 'cuevas'),
        'section' => 'cuevas_footer_settings',
        'type' => 'text',
    ));

    // Show Social Media Icons
    $wp_customize->add_setting('footer_show_social', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('footer_show_social', array(
        'label' => __('Show Social Media Icons', 'cuevas'),
        'section' => 'cuevas_footer_settings',
        'type' => 'checkbox',
    ));

    // Social Media URLs (Example for Facebook)
    $wp_customize->add_setting('social_facebook_url', array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_facebook_url', array(
        'label' => __('Facebook URL', 'cuevas'),
        'section' => 'cuevas_footer_settings',
        'type' => 'url',
    ));
    // Add similar settings/controls for Instagram, Twitter, etc.

    // --- Theme Options Section ---
    $wp_customize->add_section('cuevas_theme_options', array(
        'title' => __('Theme Options', 'cuevas'),
        'priority' => 130,
    ));

    // Example Option: Accent Color
    $wp_customize->add_setting('accent_color', array(
        'default' => '#a0522d', // Sienna color
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => __('Accent Color', 'cuevas'),
        'section' => 'cuevas_theme_options',
    )));

    // Example Option: Enable Preloader
    $wp_customize->add_setting('enable_preloader', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('enable_preloader', array(
        'label' => __('Enable Site Preloader', 'cuevas'),
        'section' => 'cuevas_theme_options',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'cuevas_customize_register');


/**
 * Admin notice for featured slider (Seems specific, keep or remove based on need)
 */
function cuevas_featured_slider_admin_notice() {
    // This seems related to a specific slider plugin or feature.
    // If this slider is no longer used or relevant, this notice can be removed.
    global $pagenow;
    if ( 'index.php' == $pagenow ) { // Only show on dashboard
        // Add logic here to check if the slider needs attention
        // Example check:
        // $slider_posts = get_posts(['post_type' => 'featured_slide', 'posts_per_page' => 1]);
        // if (empty($slider_posts)) {
        //    echo '<div class="notice notice-warning is-dismissible"><p>Please add slides to the Featured Slider.</p></div>';
        // }
    }
}
// add_action('admin_notices', 'cuevas_featured_slider_admin_notice'); // Uncomment if needed

/**
 * Disable GSAP in Customizer preview to prevent conflicts (Good practice)
 */
function cuevas_disable_gsap_in_customizer() {
    if (is_customize_preview()) {
        // Dequeue GSAP scripts if they were enqueued earlier
        wp_dequeue_script('gsap-core');
        wp_dequeue_script('gsap-scrolltrigger');
        wp_dequeue_script('gsap-scrollto');
        // Dequeue theme animation scripts that depend on GSAP
        wp_dequeue_script('cuevas-animations');
        wp_dequeue_script('cuevas-home-animations');
        wp_dequeue_script('cuevas-about-animations');
        wp_dequeue_script('cuevas-product-page');
    }
}
add_action('wp_enqueue_scripts', 'cuevas_disable_gsap_in_customizer', 100); // High priority to run after others

/**
 * Add Customizer CSS (Handles dynamic styles based on Customizer settings)
 */
function cuevas_add_customizer_css() {
    ?>
    <style type="text/css">
        /* Accent Color */
        a,
        .widget-title,
        .footer-heading,
        .entry-title a:hover,
        .woocommerce ul.products li.product .woocommerce-loop-product__title:hover,
        .woocommerce nav.woocommerce-pagination ul li a:focus,
        .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li span.current {
            color: <?php echo sanitize_hex_color(get_theme_mod('accent_color', '#a0522d')); ?>;
        }

        button,
        input[type="button"],
        input[type="reset"],
        input[type="submit"],
        .button,
        .woocommerce #respond input#submit,
        .woocommerce a.button,
        .woocommerce button.button,
        .woocommerce input.button,
        .woocommerce #respond input#submit.alt,
        .woocommerce a.button.alt,
        .woocommerce button.button.alt,
        .woocommerce input.button.alt,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-range {
            background-color: <?php echo sanitize_hex_color(get_theme_mod('accent_color', '#a0522d')); ?>;
            border-color: <?php echo sanitize_hex_color(get_theme_mod('accent_color', '#a0522d')); ?>;
            color: #ffffff; /* Assuming white text on accent color */
        }

        button:hover,
        input[type="button"]:hover,
        input[type="reset"]:hover,
        input[type="submit"]:hover,
        .button:hover,
        .woocommerce #respond input#submit:hover,
        .woocommerce a.button:hover,
        .woocommerce button.button:hover,
        .woocommerce input.button:hover,
        .woocommerce #respond input#submit.alt:hover,
        .woocommerce a.button.alt:hover,
        .woocommerce button.button.alt:hover,
        .woocommerce input.button.alt:hover {
            background-color: #8B4513; /* Darker shade of sienna for hover */
            border-color: #8B4513;
            color: #ffffff;
        }

        /* Add more dynamic styles based on Customizer settings here */

    </style>
    <?php
}
add_action('wp_head', 'cuevas_add_customizer_css');

/**
 * Remove potentially conflicting theme/plugin functions (Use with caution)
 */
function cuevas_remove_conflicting_functions() {
    // Example: Remove a function added by a plugin that interferes
    // if (function_exists('plugin_conflicting_function')) {
    //     remove_action('hook_name', 'plugin_conflicting_function', priority);
    // }
}
// add_action('init', 'cuevas_remove_conflicting_functions', 15); // Run after most things are loaded

/**
 * Adjust script loading priority if needed (Example: ensure GSAP loads early)
 */
function cuevas_priority_gsap_loading() {
    // This might be necessary if other scripts conflict or need GSAP available earlier
    // than the default footer loading allows. However, footer loading is generally preferred.
    
    // Example: Move GSAP to head (Not recommended unless necessary)
    /*
    if (!is_admin()) {
        wp_dequeue_script('gsap-core');
        wp_dequeue_script('gsap-scrolltrigger');
        wp_enqueue_script('gsap-core', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', array(), '3.12.7', false); // false = load in head
        wp_enqueue_script('gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js', array('gsap-core'), '3.12.7', false);
    }
    */
}
// add_action('wp_enqueue_scripts', 'cuevas_priority_gsap_loading', 5); // Very early priority

/**
 * Remove WordPress Emoji Scripts (Already included in inc/enqueue.php if loaded)
 */
/* 
function cuevas_disable_wp_emojis() {
    // ... Emoji disabling code ...
}
add_action('init', 'cuevas_disable_wp_emojis');

function cuevas_disable_emojis_tinymce($plugins) {
    // ... tinymce filter ...
}
// Filter already added in the main function call
*/

// Include TGM Plugin Activation - If using this library
// require_once dirname(__FILE__) . '/inc/tgm-plugin-activation/class-tgm-plugin-activation.php';
// add_action('tgmpa_register', 'cuevas_register_required_plugins');
/*
function cuevas_register_required_plugins() {
    $plugins = array(
        // Example:
        array(
            'name'      => 'Advanced Custom Fields',
            'slug'      => 'advanced-custom-fields',
            'required'  => true,
        ),
    );
    $config = array(
        'id'           => 'cuevas',              // Unique ID for hashing notices
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
    tgmpa($plugins, $config);
}
*/ 