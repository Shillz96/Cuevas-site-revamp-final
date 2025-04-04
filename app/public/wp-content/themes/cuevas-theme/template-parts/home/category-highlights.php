<?php
/**
 * Template part for displaying the category highlights section on homepage
 *
 * @package Cuevas_Theme
 */

// Get top product categories
$product_categories = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'number'     => 4,
    'orderby'    => 'count',
    'order'      => 'DESC',
));
?>

<section class="category-highlights fullscreen-section">
    <div class="container">
        <h2 class="section-title">Shop By Category</h2>
        
        <?php if (!empty($product_categories) && !is_wp_error($product_categories)) : ?>
            <div class="category-grid">
                <?php foreach ($product_categories as $category) :
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $image = wp_get_attachment_url($thumbnail_id);
                ?>
                    <div class="category-card">
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-link">
                            <div class="category-image" <?php if ($image) : ?>style="background-image: url('<?php echo esc_url($image); ?>');"<?php endif; ?>>
                                <div class="category-overlay"></div>
                                <div class="category-content">
                                    <h3 class="category-title"><?php echo esc_html($category->name); ?></h3>
                                    <span class="category-count"><?php echo sprintf(_n('%s product', '%s products', $category->count, 'cuevas'), number_format_i18n($category->count)); ?></span>
                                    <span class="shop-now-btn">Shop Now</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="no-categories">No product categories found</p>
        <?php endif; ?>
    </div>
</section> 