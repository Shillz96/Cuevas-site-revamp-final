<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Cuevas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue scripts and styles.
 */
function cuevas_scripts() {
	// Enqueue the main theme stylesheet
	wp_enqueue_style('cuevas-style', get_stylesheet_uri(), array(), defined('CUEVAS_VERSION') ? CUEVAS_VERSION : false);
	
	// Load main.css if it exists
	$main_css_path = get_template_directory() . '/assets/css/main.css';
	if (file_exists($main_css_path)) {
		wp_enqueue_style('cuevas-main-style', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime($main_css_path));
	}
	
	// Load WooCommerce styles if WooCommerce is active
	if (class_exists('WooCommerce')) {
		$woo_css_path = get_template_directory() . '/assets/css/woocommerce.css';
		if (file_exists($woo_css_path)) {
			wp_enqueue_style('cuevas-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('cuevas-main-style'), filemtime($woo_css_path));
		}
	}
	
	// Load home-styles.css on front page
	if (is_front_page()) {
		$home_css_path = get_template_directory() . '/assets/css/home-styles.css';
		if (file_exists($home_css_path)) {
			wp_enqueue_style('cuevas-home-styles', get_template_directory_uri() . '/assets/css/home-styles.css', array('cuevas-main-style'), filemtime($home_css_path));
		}
	}
	
	// Custom animation style
	$animations_css_path = get_template_directory() . '/assets/css/animations.css';
	if (file_exists($animations_css_path)) {
		wp_enqueue_style('cuevas-animations', get_template_directory_uri() . '/assets/css/animations.css', array(), filemtime($animations_css_path));
	}
	
	// Load product page CSS if on a product page
	if (function_exists('is_product') && is_product()) {
		$product_css_path = get_template_directory() . '/assets/css/product-page.css';
		if (file_exists($product_css_path)) {
			wp_enqueue_style('cuevas-product-page', get_template_directory_uri() . '/assets/css/product-page.css', array('cuevas-main-style'), filemtime($product_css_path));
		}
	}
	
	// Make sure jQuery is loaded
	wp_enqueue_script('jquery');
	
	// Add GSAP libraries (important for animations)
	wp_enqueue_script('gsap-core', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', array(), '3.12.2', false);
	wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', array('gsap-core'), '3.12.2', false);
	wp_enqueue_script('gsap-scrollto', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js', array('gsap-core'), '3.12.2', false);
	
	// Load common scripts
	wp_enqueue_script('cuevas-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), defined('CUEVAS_VERSION') ? CUEVAS_VERSION : false, true);
	
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'cuevas_scripts');

/**
 * NOTE: The GSAP initialization is now in front-page.php
 * to avoid conflicts between multiple initializations
 */

/**
 * NOTE: emoji disabling functions are now in functions.php
 * This section is now commented out to avoid conflicts.
 */
/* 
// Remove WordPress Emoji Scripts function is in functions.php - do not duplicate here
function cuevas_enqueue_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'cuevas_enqueue_disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'cuevas_enqueue_disable_emojis_remove_dns_prefetch', 10, 2 );
}

// Do not duplicate emoji disabling functions that are in functions.php
function cuevas_enqueue_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

// Do not duplicate emoji disabling functions that are in functions.php
function cuevas_enqueue_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/13.0.0/svg/' );
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}
*/
