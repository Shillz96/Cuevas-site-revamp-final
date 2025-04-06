<?php
/**
 * The front page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cuevas_Western_Wear
 */

// Output debugging information if function exists
if (function_exists('cuevas_debug_log')) {
    cuevas_debug_log('Loading front-page.php template');
}

get_header();
?>

<main id="primary" class="site-main">
    <?php
    // Debug section loading
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Starting to load homepage sections');
    }
    
    // 1. Hero Section
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading hero section');
    }
    get_template_part('template-parts/homepage/hero-section');
    
    // 2. Gallery Section (Split Slideshow)
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading split slideshow section');
    }
    get_template_part('template-parts/homepage/split-slideshow');
    
    // 3. Featured Products Section
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading featured products section');
    }
    get_template_part('template-parts/homepage/featured-products');
    
    // 4. Shop Categories Section
    if (function_exists('cuevas_debug_log')) {
        cuevas_debug_log('Loading shop categories section');
    }
    get_template_part('template-parts/homepage/shop-categories');
    
    // Additional page content from WordPress editor (if needed)
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            
            // Only display content if there is any
            $content = get_the_content();
            if (!empty($content)) :
                if (function_exists('cuevas_debug_log')) {
                    cuevas_debug_log('Loading additional content section');
                }
            ?>
            <section class="homepage-section additional-content-section">
                <div class="container">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
            <?php
            endif;
        endwhile;
    endif;
    ?>
</main><!-- #primary -->

<?php
// Add debugging info in the footer (for development only)
if (defined('WP_DEBUG') && WP_DEBUG) :
?>
<div class="debug-info" style="background: #f5f5f5; padding: 20px; margin: 20px 0; border: 1px solid #ddd;">
    <h3>Debug Information:</h3>
    <p>Template: front-page.php</p>
    <p>WooCommerce Active: <?php echo class_exists('WooCommerce') ? 'Yes' : 'No'; ?></p>
    <p>Current Time: <?php echo current_time('mysql'); ?></p>
    <p>Theme Directory: <?php echo get_template_directory(); ?></p>
    <p>Template Parts Directory: <?php echo get_template_directory() . '/template-parts'; ?></p>
</div>
<script>
console.log('Front page template loaded successfully');
console.log('Template Parts Path:', '<?php echo esc_js(get_template_directory() . '/template-parts'); ?>');

// Fix for any MutationObserver issues in other scripts
document.addEventListener('DOMContentLoaded', function() {
    // Define the safe observer creator function locally
    function createSafeObserver(target, config, callback) {
        if (!target || !callback || typeof MutationObserver === 'undefined') return null;
        
        try {
            // If target is a selector string, query for the element
            if (typeof target === 'string') {
                const element = document.querySelector(target);
                if (!element) {
                    console.warn(`Target element "${target}" not found for MutationObserver`);
                    return null;
                }
                target = element;
            }
            
            // Ensure target is a valid DOM Node
            if (!(target instanceof Node)) {
                console.warn('MutationObserver target must be a valid DOM Node');
                return null;
            }
            
            const observer = new MutationObserver(callback);
            observer.observe(target, config || { childList: true, subtree: true });
            return observer;
        } catch (error) {
            console.error('Error creating MutationObserver:', error);
            return null;
        }
    };
    
    // Make it globally available if other scripts *might* need it on this page, 
    // but keep it scoped to this page load.
    window.createSafeObserver = createSafeObserver;

    // Initialize homepage ScrollTrigger if available
    if (typeof ScrollTrigger !== 'undefined') {
        console.log('Initializing ScrollTrigger...');
        // Register the plugin if not already registered
        if (typeof gsap !== 'undefined' && typeof gsap.registerPlugin === 'function') {
            gsap.registerPlugin(ScrollTrigger);
        }
    }
});
</script>
<?php endif; ?>

<?php
get_footer();
?> 