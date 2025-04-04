<?php
/**
 * The template for displaying the footer
 *
 * @package CuevasWesternWear
 */

?>
        <?php if (!is_front_page()): ?>
            </div><!-- .container or .shop-container -->
        <?php endif; ?>
    </div><!-- #content -->

    <footer class="site-footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-col">
                    <div class="footer-logo">
                        <?php
                        if (has_custom_logo()) :
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="footer-logo-img">';
                        else :
                            echo esc_html(get_bloginfo('name'));
                        endif;
                        ?>
                    </div>
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <p><?php echo esc_html__('Quality western wear for the modern cowboy and cowgirl. Family owned and operated since 1987.', 'cuevas'); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="footer-col">
                    <h3 class="footer-heading"><?php echo esc_html__('Shop', 'cuevas'); ?></h3>
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <ul class="footer-links">
                            <?php
                            $product_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'number' => 4,
                            ));

                            if ($product_categories && !is_wp_error($product_categories)) {
                                foreach ($product_categories as $category) {
                                    echo '<li><a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a></li>';
                                }
                            } else {
                                if (function_exists('wc_get_page_id')) {
                                    echo '<li><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' . esc_html__('All Products', 'cuevas') . '</a></li>';
                                } else {
                                    echo '<li><a href="' . esc_url(home_url('/shop')) . '">' . esc_html__('All Products', 'cuevas') . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <div class="footer-col">
                    <h3 class="footer-heading"><?php echo esc_html__('Customer Service', 'cuevas'); ?></h3>
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <ul class="footer-links">
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php echo esc_html__('Contact Us', 'cuevas'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/shipping-returns')); ?>"><?php echo esc_html__('Shipping & Returns', 'cuevas'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/faq')); ?>"><?php echo esc_html__('FAQs', 'cuevas'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/size-guide')); ?>"><?php echo esc_html__('Size Guide', 'cuevas'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <div class="footer-col">
                    <h3 class="footer-heading"><?php echo esc_html__('Connect', 'cuevas'); ?></h3>
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else : ?>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fab fa-facebook-f"></i> <?php echo esc_html__('Facebook', 'cuevas'); ?></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i> <?php echo esc_html__('Instagram', 'cuevas'); ?></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i> <?php echo esc_html__('Twitter', 'cuevas'); ?></a></li>
                            <li><a href="#"><i class="fab fa-pinterest"></i> <?php echo esc_html__('Pinterest', 'cuevas'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo esc_html__('All rights reserved.', 'cuevas'); ?></p>
            </div>
        </div>
    </footer><!-- .site-footer -->

    <?php if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) : ?>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay"></div>
    
    <!-- Sidebar Toggle Button (Mobile) -->
    <button class="sidebar-toggle" aria-label="<?php echo esc_attr__('Toggle filters', 'cuevas'); ?>">
        <div class="sidebar-toggle-icon"></div>
    </button>
    <?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html> 