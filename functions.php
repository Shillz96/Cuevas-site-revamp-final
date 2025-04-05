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
	define( 'CUEVAS_VERSION', wp_get_theme()->get( 'Version' ) );
}

// Define theme paths
define( 'CUEVAS_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'CUEVAS_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );

/**
 * Load Theme Setup functions.
 */
require_once CUEVAS_THEME_DIR . 'inc/theme-setup.php';

/**
 * Load Enqueue functions for scripts and styles.
 */
require_once CUEVAS_THEME_DIR . 'inc/enqueue.php';

/**
 * Load Custom Template Tags.
 */
require_once CUEVAS_THEME_DIR . 'inc/template-tags.php';

/**
 * Load Helper Functions.
 */
require_once CUEVAS_THEME_DIR . 'inc/helpers.php';

/**
 * Load WooCommerce specific functions if WooCommerce is active.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once CUEVAS_THEME_DIR . 'inc/woocommerce.php';
}

/**
 * Load WP-CLI commands if running via CLI.
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once CUEVAS_THEME_DIR . 'inc/wp-cli.php';
}

/**
 * Load Debug functions (Optional: conditionally load based on WP_DEBUG).
 */
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    require_once CUEVAS_THEME_DIR . 'inc/debug.php';
}

// --- IMPORTANT --- 
// You will now need to manually move the relevant code blocks 
// from the old functions.php (or a backup) into the corresponding 
// files within the 'inc/' directory (theme-setup.php, woocommerce.php, etc.).
// Also move code from debugger.php and wp-cli-commands.php etc. into inc/debug.php and inc/wp-cli.php respectively. 