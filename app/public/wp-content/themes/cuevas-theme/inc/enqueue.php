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
	// Enqueue Theme Stylesheet
	wp_enqueue_style( 'cuevas-style', get_stylesheet_uri(), array(), defined('CUEVAS_VERSION') ? CUEVAS_VERSION : false );

	// Enqueue GSAP Core Library (CDN example)
    wp_enqueue_script('gsap-core', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', array(), '3.12.5', true);

    // Enqueue GSAP ScrollTrigger Plugin (CDN example)
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', array('gsap-core'), '3.12.5', true);

	// Enqueue Custom Animation Styles (Optional: if animations.css exists and has styles)
    // Check if the file exists before enqueueing
    $animation_css_path = get_template_directory() . '/assets/css/animations.css';
    if ( file_exists( $animation_css_path ) ) {
        wp_enqueue_style( 'cuevas-animations-style', get_template_directory_uri() . '/assets/css/animations.css', array('cuevas-style'), time() );
    }

	// Enqueue Custom Animation Script
    // Check if the file exists before enqueueing
    $animation_js_path = get_template_directory() . '/assets/js/main-animations.js';
    if ( file_exists( $animation_js_path ) ) {
        wp_enqueue_script(
            'cuevas-animations',
            get_template_directory_uri() . '/assets/js/main-animations.js',
            array('gsap-core', 'gsap-scrolltrigger'), // Dependencies
            time(), // Use current time for cache busting
            true // Load in footer
        );
    }

	// Example: Localize script if data needs to be passed from PHP to JS
	/*
	$script_data = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'some_value' => 'Hello from PHP!'
	);
	wp_localize_script( 'cuevas-animations', 'cuevasData', $script_data );
	*/

	// Add other theme scripts and styles here (e.g., from original functions.php)...

}
add_action( 'wp_enqueue_scripts', 'cuevas_scripts' );

/**
 * Remove WordPress Emoji Scripts (Often causes console errors if not needed)
 */
function cuevas_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'cuevas_disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'cuevas_disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'cuevas_disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 */
function cuevas_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 */
function cuevas_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/13.0.0/svg/' ); // Use a recent version number
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}
