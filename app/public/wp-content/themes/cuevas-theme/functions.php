<?php
/**
 * Cuevas Western Wear Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cuevas_Western_Wear
 */

if ( ! defined( 'CUEVAS_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'CUEVAS_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function cuevas_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'cuevas', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'primary-menu' => esc_html__( 'Primary Menu', 'cuevas' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'cuevas' ),
		)
	);

	/*
	 * Switch default core markup to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cuevas_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'cuevas_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cuevas_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cuevas_content_width', 1200 );
}
add_action( 'after_setup_theme', 'cuevas_content_width', 0 );

/**
 * Register widget area.
 */
function cuevas_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'cuevas' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'cuevas' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'cuevas' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Add widgets here for the shop sidebar.', 'cuevas' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'cuevas_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cuevas_scripts() {
	// Main stylesheet
	wp_enqueue_style( 'cuevas-style', get_stylesheet_uri(), array(), CUEVAS_VERSION );
	wp_enqueue_style( 'cuevas-main', get_template_directory_uri() . '/assets/css/main.css', array(), CUEVAS_VERSION );
	
	// Google fonts
	wp_enqueue_style( 'cuevas-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap', array(), null );
	
	// Slick Slider
	wp_enqueue_style( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1' );
	wp_enqueue_script( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true );
	
	// GSAP for animations (Updated versions)
	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true );
	
	// Main navigation functionality
	wp_enqueue_script( 'cuevas-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), CUEVAS_VERSION, true );
	
	// Load custom site animations - depends on GSAP plugins
	wp_enqueue_script( 'cuevas-animations', get_template_directory_uri() . '/assets/js/animations.js', array('gsap', 'gsap-scroll-trigger'), CUEVAS_VERSION, true );
	
	// Specific scripts for homepage
	if ( is_front_page() ) {
		// Homepage specific styles
		wp_enqueue_style( 'cuevas-slideshow', get_template_directory_uri() . '/assets/css/split-slideshow.css', array(), CUEVAS_VERSION );
		wp_enqueue_style( 'cuevas-homepage', get_template_directory_uri() . '/assets/css/homepage.css', array(), CUEVAS_VERSION );
		wp_enqueue_style( 'cuevas-gallery', get_template_directory_uri() . '/assets/css/gallery.css', array(), CUEVAS_VERSION );
		wp_enqueue_style( 'cuevas-featured-products', get_template_directory_uri() . '/assets/css/featured-products.css', array(), CUEVAS_VERSION );
		wp_enqueue_style( 'cuevas-product-grid', get_template_directory_uri() . '/assets/css/product-grid.css', array(), CUEVAS_VERSION );
		wp_enqueue_style( 'cuevas-shop-categories', get_template_directory_uri() . '/assets/css/shop-categories.css', array(), CUEVAS_VERSION );
		
		// Slideshow script (depends on slick and GSAP)
		wp_enqueue_script( 'cuevas-slideshow', get_template_directory_uri() . '/assets/js/split-slideshow.js', array('jquery', 'slick', 'gsap'), CUEVAS_VERSION, true );
	}
	
	// About page specific script
	if ( is_page_template('page-about.php') ) {
		wp_enqueue_script( 'cuevas-about', get_template_directory_uri() . '/assets/js/about-animations.js', array('gsap', 'gsap-scroll-trigger'), CUEVAS_VERSION, true );
	}
	
	// WooCommerce product page script
	if ( function_exists('is_product') && is_product() ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script( 'cuevas-product', get_template_directory_uri() . '/assets/js/product-page.js', array('jquery', 'slick'), CUEVAS_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'cuevas_scripts' );

/**
 * Include additional required files
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';

// Check if WooCommerce is active
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Add debugging functionality
 */
function cuevas_debug_log($message) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('[Cuevas Theme] ' . $message);
        
        if (is_admin() || current_user_can('administrator')) {
            // Only show to admins
            echo '<script>console.log("[Cuevas Theme] ' . esc_js($message) . '");</script>';
        }
    }
}

/**
 * Debug template usage
 */
function cuevas_debug_template() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        global $template;
        cuevas_debug_log('Template file: ' . basename($template));
        
        // Add detailed template hierarchy info
        $templates = array();
        
        if (is_front_page()) {
            $templates[] = 'front-page.php';
        }
        
        if (is_home()) {
            $templates[] = 'home.php';
        }
        
        if (is_singular()) {
            $templates[] = 'single-' . get_post_type() . '.php';
            $templates[] = 'singular.php';
            $templates[] = 'single.php';
        }
        
        if (is_page()) {
            $id = get_queried_object_id();
            $template = get_page_template_slug();
            $pagename = get_query_var('pagename');
            
            if ($template) {
                $templates[] = $template;
            }
            
            if ($pagename) {
                $templates[] = "page-$pagename.php";
            }
            
            $templates[] = "page-$id.php";
            $templates[] = 'page.php';
        }
        
        $templates[] = 'index.php';
        
        cuevas_debug_log('Template hierarchy: ' . implode(' → ', $templates));
    }
}
add_action('wp_footer', 'cuevas_debug_template');
