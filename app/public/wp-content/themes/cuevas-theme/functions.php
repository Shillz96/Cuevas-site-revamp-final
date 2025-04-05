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
 * *** THIS IS NOW ACTIVE ***
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

/* --- START: COMMENT OUT OLD ENQUEUE FUNCTION --- */
/*
 * Enqueue scripts and styles with consolidated GSAP loading
 */
/*
function cuevas_theme_scripts() {
// ... existing code ...
    }
}
// ... existing code ...
add_action('wp_enqueue_scripts', 'cuevas_theme_scripts');
*/
/* --- END: COMMENT OUT OLD ENQUEUE FUNCTION --- */

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
    if (is_admin() || is_customize_preview()) {
        return;
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Register GSAP plugins
            if (typeof gsap !== "undefined") {
                if (typeof ScrollTrigger !== "undefined") {
                    gsap.registerPlugin(ScrollTrigger);
                }
                if (typeof ScrollToPlugin !== "undefined") {
                    gsap.registerPlugin(ScrollToPlugin);
                }

                // Default GSAP configuration
                gsap.config({
                    nullTargetWarn: false,
                    autoSleep: 60,
                    force3D: true
                });

                // Default ScrollTrigger configuration
                if (typeof ScrollTrigger !== "undefined") {
                    ScrollTrigger.config({
                        autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load,resize'
                    });
                }

                // Utility functions
                window.createStaggerAnimation = function(elements, fromVars = {}, toVars = {}) {
                    if (!elements) return;

                    const defaults = {
                        duration: 0.8,
                        ease: "power2.inOut",
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

                window.createTextReveal = function(element, options = {}) {
                    if (!element) return;
                    
                    const defaults = {
                        duration: 0.8,
                        ease: 'power2.out',
                        y: 20,
                        opacity: 0
                    };

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
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'cuevas_initialize_gsap', 10);

/**
 * Add home page specific styles and initialization
 */
function cuevas_add_home_page_styles() {
    if (!is_front_page()) {
        return;
    }
    ?>
    <style>
    /* Initial styles to prevent FOUC */
    html, body { overflow-x: hidden; }
    
    .fullpage-wrapper {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    
    .fullpage-wrapper.initialized { opacity: 1; }
    .hero-title, .hero-subtitle { opacity: 1 !important; }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, <?php echo get_theme_mod('homepage_banner_overlay_opacity', '0.4'); ?>);
        z-index: 1;
    }

    .no-js .fullpage-wrapper { opacity: 1; }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize fullpage wrapper
        setTimeout(() => {
            const wrapper = document.querySelector('.fullpage-wrapper');
            if (wrapper) wrapper.classList.add('initialized');
        }, 100);

        // Ensure proper scrolling
        document.documentElement.style.overflowX = 'hidden';
        document.documentElement.style.overflowY = 'auto';
    });
    </script>
    <?php
}
add_action('wp_head', 'cuevas_add_home_page_styles', 5);

/**
 * Clean up WordPress defaults and optimize performance
 */
function cuevas_cleanup_wordpress() {
    // Remove emoji support
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', function($plugins) {
        return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : array();
    });

    // Remove unnecessary WP meta tags
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

    // Remove REST API links if not needed
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
}
add_action('init', 'cuevas_cleanup_wordpress');

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
    // Homepage Banner Section
    $wp_customize->add_section('cuevas_homepage_banner', array(
        'title'    => __('Homepage Hero Banner', 'cuevas'),
        'priority' => 130,
    ));
    
    // Banner settings
    $banner_settings = array(
        'homepage_banner_image' => array(
            'default' => '',
            'type' => 'image',
            'label' => __('Banner Background Image', 'cuevas'),
            'description' => __('Upload an image for the homepage hero banner background', 'cuevas')
        ),
        'homepage_banner_image_fit' => array(
            'default' => 'cover',
            'type' => 'select',
            'label' => __('Background Image Fit', 'cuevas'),
            'choices' => array(
                'cover'   => __('Cover (fills entire area, may crop)', 'cuevas'),
                'contain' => __('Contain (shows entire image, may leave space)', 'cuevas'),
                'auto'    => __('Auto (original size)', 'cuevas')
            )
        ),
        'homepage_banner_image_position' => array(
            'default' => 'center center',
            'type' => 'select',
            'label' => __('Background Image Position', 'cuevas'),
            'choices' => array(
                'center center' => __('Center (default)', 'cuevas'),
                'top center'    => __('Top', 'cuevas'),
                'bottom center' => __('Bottom', 'cuevas'),
                'center left'   => __('Left', 'cuevas'),
                'center right'  => __('Right', 'cuevas'),
                'top left'      => __('Top Left', 'cuevas'),
                'top right'     => __('Top Right', 'cuevas'),
                'bottom left'   => __('Bottom Left', 'cuevas'),
                'bottom right'  => __('Bottom Right', 'cuevas')
            )
        ),
        'homepage_banner_overlay_opacity' => array(
            'default' => '0.4',
            'type' => 'select',
            'label' => __('Banner Overlay Opacity', 'cuevas'),
            'choices' => array(
                '0'   => __('No Overlay', 'cuevas'),
                '0.2' => __('Very Light', 'cuevas'),
                '0.4' => __('Light', 'cuevas'),
                '0.6' => __('Medium', 'cuevas'),
                '0.8' => __('Dark', 'cuevas'),
                '0.9' => __('Very Dark', 'cuevas')
            )
        ),
        'homepage_banner_height' => array(
            'default' => '80vh',
            'type' => 'select',
            'label' => __('Banner Height', 'cuevas'),
            'choices' => array(
                '50vh'  => __('Short', 'cuevas'),
                '65vh'  => __('Medium', 'cuevas'),
                '80vh'  => __('Tall (Default)', 'cuevas'),
                '100vh' => __('Full Screen', 'cuevas')
            )
        ),
        'homepage_banner_heading' => array(
            'default' => "IT'S RODEO SEASON",
            'type' => 'text',
            'label' => __('Banner Heading', 'cuevas')
        ),
        'homepage_banner_subheading' => array(
            'default' => 'Quality western wear for the modern cowboy and cowgirl',
            'type' => 'text',
            'label' => __('Banner Subheading', 'cuevas')
        ),
        'homepage_primary_button_text' => array(
            'default' => 'Shop Now',
            'type' => 'text',
            'label' => __('Primary Button Text', 'cuevas')
        ),
        'homepage_secondary_button_text' => array(
            'default' => 'Our Story',
            'type' => 'text',
            'label' => __('Secondary Button Text', 'cuevas')
        )
    );

    // Register banner settings
    foreach ($banner_settings as $setting_id => $setting_data) {
        $wp_customize->add_setting($setting_id, array(
            'default'           => $setting_data['default'],
            'sanitize_callback' => $setting_data['type'] === 'image' ? 'esc_url_raw' : 'sanitize_text_field'
        ));

        if ($setting_data['type'] === 'image') {
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $setting_id, array(
                'label'       => $setting_data['label'],
                'description' => $setting_data['description'],
                'section'     => 'cuevas_homepage_banner'
            )));
        } else {
            $wp_customize->add_control($setting_id, array(
                'label'    => $setting_data['label'],
                'section'  => 'cuevas_homepage_banner',
                'type'     => $setting_data['type'],
                'choices'  => isset($setting_data['choices']) ? $setting_data['choices'] : null
            ));
        }
    }

    // Get product categories for dropdowns
    $product_cats = array('' => __('Select a category', 'cuevas'));
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

    // Promotional sections
    $promo_sections = array(
        'cuevas_promo_banner' => array(
            'title' => __('Promotional Banner', 'cuevas'),
            'description' => __('Settings for the promotional banner below the hero section.', 'cuevas'),
            'priority' => 131,
            'settings' => array(
                'promo_banner_heading' => array(
                    'default' => 'SHOP BY CATEGORY',
                    'type' => 'text',
                    'label' => __('Promotional Banner Heading', 'cuevas')
                ),
                'promo_banner_text' => array(
                    'default' => 'Explore our collection of premium western wear',
                    'type' => 'text',
                    'label' => __('Promotional Banner Text', 'cuevas')
                )
            )
        ),
        'cuevas_featured_products' => array(
            'title' => __('Featured Products Slider', 'cuevas'),
            'priority' => 132,
            'settings' => array()
        )
    );

    // Add featured product image settings
    for ($i = 1; $i <= 5; $i++) {
        $promo_sections['cuevas_featured_products']['settings']['featured_product_image_' . $i] = array(
            'default' => '',
            'type' => 'image',
            'label' => sprintf(__('Featured Product Image %d', 'cuevas'), $i),
            'description' => __('Upload a full-screen image for the featured products slider', 'cuevas')
        );
    }

    // Register promotional sections and settings
    foreach ($promo_sections as $section_id => $section_data) {
        $wp_customize->add_section($section_id, array(
            'title'       => $section_data['title'],
            'description' => isset($section_data['description']) ? $section_data['description'] : '',
            'priority'    => $section_data['priority']
        ));

        foreach ($section_data['settings'] as $setting_id => $setting_data) {
            $wp_customize->add_setting($setting_id, array(
                'default'           => $setting_data['default'],
                'sanitize_callback' => $setting_data['type'] === 'image' ? 'esc_url_raw' : 'sanitize_text_field'
            ));

            if ($setting_data['type'] === 'image') {
                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $setting_id, array(
                    'label'       => $setting_data['label'],
                    'description' => $setting_data['description'],
                    'section'     => $section_id
                )));
            } else {
                $wp_customize->add_control($setting_id, array(
                    'label'    => $setting_data['label'],
                    'section'  => $section_id,
                    'type'     => $setting_data['type']
                ));
            }
        }
    }
}
add_action('customize_register', 'cuevas_customize_register');

/**
 * Add admin notice for featured slider setup
 */
function cuevas_featured_slider_admin_notice() {
    $screen = get_current_screen();
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

    if ($count < 2) {
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong><?php _e('Cuevas Theme:', 'cuevas'); ?></strong> 
               <?php _e('For the featured product slider to work correctly, please add at least 2-3 images in', 'cuevas'); ?> 
               <a href="<?php echo admin_url('customize.php?autofocus[section]=cuevas_featured_products'); ?>">
                   <?php _e('Customizer > Featured Products Slider', 'cuevas'); ?>
               </a>.
            </p>
            <p><?php _e('Images should be high quality and at least 1920×1080px in size for best results.', 'cuevas'); ?></p>
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

// Register WP-CLI commands if WP-CLI is available
if (defined('WP_CLI') && WP_CLI) {
    require_once get_template_directory() . '/cli/add-mock-products.php';
}

// Register WP-CLI commands
if (defined('WP_CLI') && WP_CLI) {
    require_once get_template_directory() . '/wp-cli-commands.php';
}

/* --- START: COMMENT OUT DUPLICATE EMOJI FUNCTIONS --- */
/*
 * Remove WordPress Emoji Scripts (Already included in inc/enqueue.php if loaded)
 */
/* 
function cuevas_disable_wp_emojis() {
    // Remove emoji-related actions and filters
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove from TinyMCE
    add_filter('tiny_mce_plugins', 'cuevas_disable_emojis_tinymce');
    add_filter( 'wp_resource_hints', 'cuevas_disable_emojis_remove_dns_prefetch', 10, 2 ); // Added missing filter call here
}
add_action('init', 'cuevas_disable_wp_emojis');

/**
 * Filter function to remove the emoji plugin from TinyMCE
 */
function cuevas_disable_emojis_tinymce($plugins) {
    return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : array();
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 */
function cuevas_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) { // Added this function definition
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/13.0.0/svg/' ); 
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}

/* --- END: COMMENT OUT DUPLICATE EMOJI FUNCTIONS --- */

// Include TGM Plugin Activation - If using this library
// ... rest of file ... 