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
	// Ensure $args is an array before processing
	if ( ! is_array( $args ) ) {
		$args = array(); // Initialize as empty array if not valid
	}

	$defaults = array(
		'posts_per_page' => 8, // Show 8 products (for a 2x4 grid)
		'columns'        => 4, // Display in 4 columns
	);

	// Merge defaults with incoming args
	$args = wp_parse_args( $args, $defaults );

	return $args;
}
// Re-enable the filter now that the function is safer
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

/**
 * Filter product classes to remove default WooCommerce classes if needed
 * and potentially add our own 'product-card'.
 * Note: We will wrap with product-card div instead, so removing default might not be needed.
 */
// function cuevas_filter_product_classes($classes, $class, $product_id) {
// 	// Example: Remove a default class
// 	// $classes = array_diff($classes, array('type-product'));
// 	// Example: Add our class
// 	$classes[] = 'product-card'; 
// 	return $classes;
// }
// add_filter('post_class', 'cuevas_filter_product_classes', 20, 3);

// --- Restructure Shop Loop Items conditionally ---

// Only run on main WooCommerce archive queries (Shop, Category, Tag)
if ( function_exists('is_woocommerce') && is_woocommerce() && ( is_shop() || is_product_category() || is_product_tag() ) && is_main_query() ) {
	// 1. Remove default actions
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
	// Ensure the default thumbnail is removed BEFORE we add ours
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10); // Already removed above, double check just in case
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

	// 2. Add opening wrappers and link
	function cuevas_product_card_open() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		echo '<div class="product-card">'; // Open product-card
		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">'; // Re-add link opening
		echo '<div class="product-image-container">'; // Open image container
		
		// Add badges (Sale/New) - using classes from product-card.css or default WC classes
		if ($product->is_on_sale()) {
			// Use the default WooCommerce sale flash hook if preferred, or output manually
			// woocommerce_show_product_loop_sale_flash(); 
			echo '<span class="onsale product-badge badge-sale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>';
		}
		// Add new badge for products less than 30 days old
		$post_date = get_the_time('U', $product->get_id());
		$time_diff = time() - $post_date;
		if ($time_diff < (30 * DAY_IN_SECONDS)) { // Check if less than 30 days old
			echo '<span class="new-badge product-badge badge-new">' . esc_html__( 'New', 'cuevas' ) . '</span>';
		}
	}
	add_action('woocommerce_before_shop_loop_item', 'cuevas_product_card_open', 5);

	// 3. Add product image - Run slightly later to ensure default is removed
	// Temporarily comment out to test for warnings
	add_action('woocommerce_before_shop_loop_item_title', 'cuevas_product_card_image', 11); // Changed priority to 11

	// 4. Close image container, open info container, add title - Run after image
	function cuevas_product_card_info_open() {
		echo '</div>'; // Close product-image-container
		echo '<div class="product-info">'; // Open product-info
		// Use the class from product-card.css
		echo '<h2 class="product-title">' . get_the_title() . '</h2>'; 
	}
	// Hook after the image (priority 11), before price/rating (default 5, 10)
	add_action('woocommerce_before_shop_loop_item_title', 'cuevas_product_card_info_open', 20); // Keep priority 20

	// 5. Add Price and Add to Cart Button
	function cuevas_product_card_price_button() {
		global $product;
		// Price - use class from product-card.css
		if ( $price_html = $product->get_price_html() ) {
			echo '<span class="product-price">' . $price_html . '</span>';
		}
		// Add to Cart Button - use class from product-card.css
		// We mimic the arguments of woocommerce_template_loop_add_to_cart
		woocommerce_template_loop_add_to_cart( array('class' => 'button add-to-cart-btn') );
	}
	// Temporarily comment out to test for warnings
	// add_action('woocommerce_after_shop_loop_item_title', 'cuevas_product_card_price_button', 10);

	// 6. Close wrappers and link
	function cuevas_product_card_close() {
		echo '</div>'; // Close product-info
		echo '</a>'; // Close product link
		echo '</div>'; // Close product-card
	}
	add_action('woocommerce_after_shop_loop_item', 'cuevas_product_card_close', 15);
} // End conditional check for is_product()

// --- End Restructure --- 