<?php
/**
 * WooCommerce specific functions and customizations
 *
 * @package Cuevas_Western_Wear
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WooCommerce setup function.
 */
function cuevas_woocommerce_setup() {
	// Add theme support for WooCommerce with various features
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Remove default WooCommerce styles
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}
add_action( 'after_setup_theme', 'cuevas_woocommerce_setup' );

/**
 * Add WooCommerce specific classes to the body tag
 */
function cuevas_woocommerce_body_classes( $classes ) {
	if ( is_woocommerce() ) {
		$classes[] = 'woocommerce-active';
	}
	
	return $classes;
}
add_filter( 'body_class', 'cuevas_woocommerce_body_classes' );

/**
 * Related Products Args.
 */
function cuevas_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'cuevas_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Add custom WooCommerce wrapper with western styling.
 */
if ( ! function_exists( 'cuevas_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 */
	function cuevas_woocommerce_wrapper_before() {
		?>
		<main id="primary" class="site-main woocommerce-content">
			<div class="woocommerce-wrapper">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'cuevas_woocommerce_wrapper_before' );

if ( ! function_exists( 'cuevas_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 */
	function cuevas_woocommerce_wrapper_after() {
		?>
			</div><!-- .woocommerce-wrapper -->
		</main><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'cuevas_woocommerce_wrapper_after' );

/**
 * Customize the product display on shop pages.
 */
function cuevas_woocommerce_loop_product_title() {
	echo '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
}
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'cuevas_woocommerce_loop_product_title', 10 );

/**
 * Customize the add to cart button text.
 */
function cuevas_woocommerce_product_add_to_cart_text( $text ) {
	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'cuevas_woocommerce_product_add_to_cart_text' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX.
 */
function cuevas_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<span class="cart-contents-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	<?php
	$fragments['span.cart-contents-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'cuevas_woocommerce_header_add_to_cart_fragment' );

/**
 * Customize the number of products displayed per page.
 */
function cuevas_woocommerce_products_per_page() {
	return 12; // Display 12 products per page
}
add_filter( 'loop_shop_per_page', 'cuevas_woocommerce_products_per_page' );

/**
 * Customize WooCommerce checkout fields.
 */
function cuevas_woocommerce_checkout_fields( $fields ) {
	// Make changes to the billing and shipping fields if needed
	return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'cuevas_woocommerce_checkout_fields' );

/**
 * Add custom order data to the order.
 */
function cuevas_woocommerce_checkout_update_order_meta( $order_id ) {
	// Add custom order data if needed
}
add_action( 'woocommerce_checkout_update_order_meta', 'cuevas_woocommerce_checkout_update_order_meta' ); 