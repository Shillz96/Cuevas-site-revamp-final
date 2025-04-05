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
					<h3>About Cuevas Western Wear</h3>
					<p>Family-owned and operated since 1985, bringing quality western wear to our community for generations.</p>
				</div>
				<div class="footer-widget">
					<h3>Quick Links</h3>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'menu_id'        => 'footer-menu',
							'depth'          => 1,
						)
					);
					?>
				</div>
				<div class="footer-widget">
					<h3>Contact Us</h3>
					<p>123 Western Avenue<br>
					San Antonio, TX 12345<br>
					Phone: (123) 456-7890<br>
					Email: info@cuevaswestern.com</p>
				</div>
				<div class="footer-widget">
					<h3>Follow Us</h3>
					<div class="social-icons">
						<a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
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