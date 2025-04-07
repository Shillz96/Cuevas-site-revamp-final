<?php
/**
 * The header for our theme
 *
 * @package CuevasWesternWear
 */

// Get navigation customizer settings
$nav_bg_color = get_theme_mod('cuevas_nav_bg_color', '#3E2723');
$nav_text_color = get_theme_mod('cuevas_nav_text_color', '#FFFFFF');
$nav_transparent = get_theme_mod('cuevas_nav_transparent', true);

// Set the header class based on whether we want transparency on homepage
$header_class = 'site-header';
$is_transparent_header_active = false; // Flag for body class
if (is_front_page() && $nav_transparent) {
    $header_class .= ' transparent-header';
    $is_transparent_header_active = true;
}
if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) {
    $header_class = 'compact-header';
}

// Function to add body class
function cuevas_body_classes_transparent_header( $classes ) {
    global $is_transparent_header_active;
    if ( $is_transparent_header_active ) {
        $classes[] = 'transparent-header-active';
    }
    return $classes;
}
add_filter( 'body_class', 'cuevas_body_classes_transparent_header' );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    
    <?php // Only output header styles if not the front page 
    if ( ! is_front_page() ) : ?>
    <!-- Custom navbar styles from Customizer -->
    <style>
        /* Styles for non-frontpage header */
        .site-header {
            background-color: <?php echo esc_attr($nav_bg_color); ?>;
            color: <?php echo esc_attr($nav_text_color); ?>;
            position: fixed; /* Or relative/static if not fixed on other pages */
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            height: var(--header-height, 80px); /* Ensure height for padding calculation */
        }
        
        .site-header .site-title a,
        .site-header .main-navigation a,
        .site-header .menu-toggle span {
            color: <?php echo esc_attr($nav_text_color); ?>;
        }
        
        /* Adjust mobile hamburger icon background */
        @media (max-width: 768px) {
             .site-header .menu-toggle span {
                  background-color: <?php echo esc_attr($nav_text_color); ?> !important;
             }
        }
    </style>
    <?php endif; ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'cuevas'); ?></a>

    <?php // Conditionally output the header
    if ( ! is_front_page() ) : ?>
    <header class="<?php echo esc_attr($header_class); ?>">
        <div class="container">
            <div class="header-inner">
                
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) :
                        the_custom_logo();
                    else :
                    ?>
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                        <?php
                        $cuevas_description = get_bloginfo('description', 'display');
                        if ($cuevas_description || is_customize_preview()) :
                        ?>
                            <p class="site-description"><?php echo $cuevas_description; // phpcs:ignore ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                    ));
                    ?>
                    <?php if (function_exists('wc_get_cart_url')) : ?>
                    <ul class="nav-extras">
                        <li><a href="<?php echo esc_url(wc_get_cart_url()); ?>"><i class="fas fa-shopping-cart"></i></a></li>
                    </ul>
                    <?php endif; ?>
                </nav><!-- #site-navigation -->
            </div>
        </div>
    </header>
    <?php endif; // End conditional header output ?>

    <?php
    // Display shop banner if on shop page
    if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) :
        $category_image = '';
        $category_title = '';
        
        if (is_product_category()) {
            $category = get_queried_object();
            $category_title = $category->name;
            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
            if ($thumbnail_id) {
                $category_image = wp_get_attachment_url($thumbnail_id);
            }
        } elseif (is_shop()) {
            $category_title = esc_html__('Shop', 'cuevas');
            if (function_exists('wc_get_page_id')) {
                $shop_page_id = wc_get_page_id('shop');
                if (has_post_thumbnail($shop_page_id)) {
                    $category_image = get_the_post_thumbnail_url($shop_page_id, 'full');
                }
            }
        }
    ?>
    <!-- Category Banner -->
    <section class="category-banner">
        <?php if ($category_image) : ?>
            <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category_title); ?>" class="banner-bg">
        <?php endif; ?>
        <div class="banner-content">
            <h1 class="category-title"><?php echo esc_html($category_title); ?></h1>
            <?php
            if (function_exists('woocommerce_breadcrumb')) {
                woocommerce_breadcrumb(array(
                    'wrap_before' => '<div class="breadcrumbs">',
                    'wrap_after'  => '</div>',
                    'before'      => '<div class="breadcrumb-item">',
                    'after'       => '</div>',
                    'delimiter'   => '',
                ));
            }
            ?>
        </div>
    </section>
    <?php endif; ?>

    <div id="content" class="site-content full-width-content">
        <?php // Adjust container logic slightly as header padding is now conditional 
        $needs_container = !is_front_page(); // Assume non-front pages need container
        if (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) {
             $needs_container = true; // Shop pages definitely need container
        }
        
        if ($needs_container): ?>
            <div class="<?php echo (function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag())) ? 'shop-container container' : 'container'; ?>">
        <?php endif; ?> 