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
	
	/** 
	 * Renders the content-single-product.php template 
	 * which contains the main product structure (images, summary, tabs, etc.)
	 * The necessary hooks and layout CSS should apply within that template or globally.
	 */
	wc_get_template_part( 'content', 'single-product' );

endwhile; // end of the loop.

/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
