<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cuevas_Western_Wear
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-widgets">
				<div class="footer-widget">
					<h3><?php esc_html_e( 'About Cuevas Western Wear', 'cuevas' ); ?></h3>
					<p><?php echo wp_kses_post( get_theme_mod( 'cuevas_footer_about', 'Family-owned and operated since 1985, bringing quality western wear to our community for generations.' ) ); ?></p>
				</div>
				<div class="footer-widget">
					<h3><?php esc_html_e( 'Quick Links', 'cuevas' ); ?></h3>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'menu_id'        => 'footer-menu',
							'depth'          => 1,
							'fallback_cb'    => false, // Don't show anything if menu isn't set
						)
					);
					?>
				</div>
				<div class="footer-widget">
					<h3><?php esc_html_e( 'Contact Us', 'cuevas' ); ?></h3>
					<p>
						<?php echo nl2br( wp_kses_post( get_theme_mod( 'cuevas_footer_address', "123 Western Avenue\nSan Antonio, TX 12345" ) ) ); ?><br>
						<?php esc_html_e( 'Phone:', 'cuevas' ); ?> <?php echo esc_html( get_theme_mod( 'cuevas_footer_phone', '(123) 456-7890' ) ); ?><br>
						<?php esc_html_e( 'Email:', 'cuevas' ); ?> <a href="mailto:<?php echo esc_attr( get_theme_mod( 'cuevas_footer_email', 'info@cuevaswestern.com' ) ); ?>"><?php echo esc_html( get_theme_mod( 'cuevas_footer_email', 'info@cuevaswestern.com' ) ); ?></a>
					</p>
				</div>
				<div class="footer-widget">
					<h3><?php esc_html_e( 'Follow Us', 'cuevas' ); ?></h3>
					<div class="social-icons">
						<?php
						$social_networks = array('facebook', 'instagram', 'twitter', 'pinterest');
						foreach ($social_networks as $network) {
							$url = get_theme_mod("cuevas_social_{$network}", '#');
							if ( ! empty( $url ) && '#' !== $url ) {
								printf( '<a href="%1$s" class="social-icon" target="_blank" rel="noopener noreferrer"><i class="fab fa-%2$s"></i><span class="screen-reader-text">%3$s</span></a>',
									esc_url( $url ),
									esc_attr( $network ),
									sprintf( esc_html__( '%s Profile', 'cuevas' ), ucfirst( $network ) )
								);
							}
						}
						?>
					</div>
				</div>
			</div>
			<div class="site-info">
				<p>&copy; <?php echo date('Y'); ?> Cuevas Western Wear. All rights reserved.</p>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html> 