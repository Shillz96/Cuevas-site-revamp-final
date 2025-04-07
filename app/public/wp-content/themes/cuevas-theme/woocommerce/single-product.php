<?php
/**
 * The Template for displaying all single products
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');

while (have_posts()) :
	the_post();
	
	global $product;
	?>
	<div class="single-product-wrapper">
		<div class="product-gallery-section">
			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 * 
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action('woocommerce_before_single_product_summary');
			?>
		</div>

		<div class="product-details-section">
			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 * 
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action('woocommerce_single_product_summary');
			?>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 * 
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action('woocommerce_after_single_product_summary');

endwhile; // end of the loop.

/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */ 