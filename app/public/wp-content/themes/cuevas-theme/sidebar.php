<?php
/**
 * The sidebar containing the main widget area
 *
 * @package CuevasWesternWear
 */

if (!is_active_sidebar('sidebar-1') && !function_exists('is_woocommerce')) {
    return;
}
?>

<?php if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) : ?>
<!-- Shop Sidebar (Collapsible on Mobile) -->
<aside class="shop-sidebar">
    <button class="sidebar-close" aria-label="<?php echo esc_attr__('Close sidebar', 'cuevas'); ?>">&times;</button>
    
    <?php if (function_exists('woocommerce_price_slider')) : ?>
    <!-- Filter by Price -->
    <div class="filter-section">
        <h3 class="filter-title"><?php echo esc_html__('Filter by Price', 'cuevas'); ?></h3>
        <?php woocommerce_price_filter(); ?>
    </div>
    <?php endif; ?>
    
    <?php if (function_exists('woocommerce_product_categories')) : ?>
    <!-- Filter by Categories -->
    <div class="filter-section">
        <h3 class="filter-title"><?php echo esc_html__('Categories', 'cuevas'); ?></h3>
        <ul class="category-list">
            <?php
            woocommerce_product_categories(array(
                'hierarchical' => true,
                'show_count' => true,
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
            ));
            ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <?php if (is_active_sidebar('sidebar-1')) : ?>
    <!-- Additional Filters from Widgets -->
    <?php dynamic_sidebar('sidebar-1'); ?>
    <?php endif; ?>

    <?php 
    // Check if WooCommerce attribute filter widget is available
    if (class_exists('WC_Widget_Layered_Nav')) : 
        $color_taxonomy = 'pa_color'; // Adjust this to match your attribute taxonomy
        $size_taxonomy = 'pa_size'; // Adjust this to match your attribute taxonomy
        
        // Check if these taxonomies exist
        $color_terms = get_terms(array('taxonomy' => $color_taxonomy, 'hide_empty' => true));
        $size_terms = get_terms(array('taxonomy' => $size_taxonomy, 'hide_empty' => true));
    ?>
        
        <?php if (!is_wp_error($color_terms) && !empty($color_terms)) : ?>
        <!-- Filter by Color -->
        <div class="filter-section">
            <h3 class="filter-title"><?php echo esc_html__('Color', 'cuevas'); ?></h3>
            <div class="color-options">
                <?php foreach ($color_terms as $term) : 
                    // Get color value from term meta or use a default color mapping
                    $color_value = get_term_meta($term->term_id, 'color', true);
                    if (!$color_value) {
                        // Fallback color mapping based on common color names
                        $color_map = array(
                            'black' => '#000000',
                            'brown' => '#8B4513',
                            'tan' => '#D2B48C',
                            'burgundy' => '#A52A2A',
                            'beige' => '#F5F5DC',
                            'gray' => '#808080',
                        );
                        $color_value = isset($color_map[strtolower($term->name)]) ? $color_map[strtolower($term->name)] : '#cccccc';
                    }
                    
                    $current_term = isset($_GET['filter_color']) ? sanitize_title($_GET['filter_color']) : '';
                    $link = add_query_arg('filter_color', $term->slug, remove_query_arg('filter_color', wc_get_page_permalink('shop')));
                    $active_class = ($current_term === $term->slug) ? ' active' : '';
                ?>
                    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($term->name); ?>">
                        <div class="color-option<?php echo esc_attr($active_class); ?>" style="background-color: <?php echo esc_attr($color_value); ?>"></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (!is_wp_error($size_terms) && !empty($size_terms)) : ?>
        <!-- Filter by Size -->
        <div class="filter-section">
            <h3 class="filter-title"><?php echo esc_html__('Size', 'cuevas'); ?></h3>
            <div class="size-options">
                <?php foreach ($size_terms as $term) : 
                    $current_term = isset($_GET['filter_size']) ? sanitize_title($_GET['filter_size']) : '';
                    $link = add_query_arg('filter_size', $term->slug, remove_query_arg('filter_size', wc_get_page_permalink('shop')));
                    $active_class = ($current_term === $term->slug) ? ' active' : '';
                ?>
                    <a href="<?php echo esc_url($link); ?>">
                        <div class="size-option<?php echo esc_attr($active_class); ?>"><?php echo esc_html($term->name); ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
    <?php endif; ?>
</aside>
<?php else : ?>
<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside><!-- #secondary -->
<?php endif; ?> 