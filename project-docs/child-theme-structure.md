# Child Theme Structure - Cuevas Western Wear

This document outlines the file structure and organization for the Hello Elementor child theme that will be used for the Cuevas Western Wear website.

## Directory Structure

```
hello-elementor-child/
├── assets/
│   ├── css/
│   │   ├── custom-styles.css
│   │   ├── woocommerce-custom.css
│   │   └── responsive.css
│   ├── js/
│   │   ├── animations/
│   │   │   ├── animations-global.js
│   │   │   ├── animations-home.js
│   │   │   ├── animations-products.js
│   │   │   └── animations-cart.js
│   │   ├── custom-scripts.js
│   │   ├── woocommerce-custom.js
│   │   └── gsap/
│   │       ├── gsap.min.js
│   │       ├── ScrollTrigger.min.js
│   │       ├── Draggable.min.js
│   │       └── CSSRulePlugin.min.js
│   ├── fonts/
│   │   ├── playfair-display/
│   │   ├── roboto/
│   │   └── fjalla-one/
│   └── images/
│       ├── icons/
│       ├── textures/
│       ├── patterns/
│       └── logo.svg
├── inc/
│   ├── custom-post-types.php
│   ├── woocommerce-hooks.php
│   ├── enqueue-scripts.php
│   ├── elementor-hooks.php
│   └── template-functions.php
├── template-parts/
│   ├── header/
│   ├── footer/
│   └── content/
├── woocommerce/
│   ├── single-product/
│   ├── archive-product.php
│   ├── cart/
│   └── checkout/
├── elementor-templates/
│   ├── product-template.json
│   ├── category-template.json
│   ├── homepage-template.json
│   └── checkout-template.json
├── screenshot.png
├── style.css
├── functions.php
└── README.md
```

## Key Files and Their Purpose

### 1. Root Files

#### `style.css`

Contains the theme's metadata and global CSS styles:

```css
/*
Theme Name: Hello Elementor Child Theme
Theme URI: https://github.com/elementor/hello-elementor
Description: Hello Elementor Child Theme for Cuevas Western Wear
Author: [Your Name]
Author URI: [Your Website]
Template: hello-elementor
Version: 1.0.0
Text Domain: hello-elementor-child
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Tags: flexible-header, custom-colors, custom-menu, custom-logo, editor-style, featured-images, rtl-language-support, theme-options, threaded-comments, translation-ready
*/

/* Import parent theme styles */
@import url('../hello-elementor/style.css');

/* Custom styles will be here or imported from assets/css files */
```

#### `functions.php`

The main functionality file for the child theme:

```php
<?php
/**
 * Hello Elementor Child Theme functions and definitions
 *
 * @package HelloElementorChild
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('HELLO_ELEMENTOR_CHILD_VERSION', '1.0.0');
define('HELLO_ELEMENTOR_CHILD_DIR', get_stylesheet_directory());
define('HELLO_ELEMENTOR_CHILD_URI', get_stylesheet_directory_uri());

/**
 * Include all required files
 */
$includes = [
    '/inc/enqueue-scripts.php',          // Enqueue styles and scripts
    '/inc/custom-post-types.php',        // Custom post types
    '/inc/woocommerce-hooks.php',        // WooCommerce customizations
    '/inc/elementor-hooks.php',          // Elementor customizations
    '/inc/template-functions.php',       // Template functions
];

foreach ($includes as $file) {
    if (file_exists(HELLO_ELEMENTOR_CHILD_DIR . $file)) {
        require_once HELLO_ELEMENTOR_CHILD_DIR . $file;
    }
}

/**
 * Theme setup function
 */
function hello_elementor_child_setup() {
    // Add theme support features
    add_theme_support('woocommerce');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register menu locations
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'hello-elementor-child'),
        'secondary' => esc_html__('Secondary Menu', 'hello-elementor-child'),
        'mobile' => esc_html__('Mobile Menu', 'hello-elementor-child'),
    ));
}
add_action('after_setup_theme', 'hello_elementor_child_setup');
```

### 2. CSS Organization

#### `assets/css/custom-styles.css`

Contains custom styling for the theme, separate from WooCommerce styles:

```css
/**
 * Custom styles for Cuevas Western Wear
 */

:root {
    /* Primary Colors */
    --color-brown: #5D4037;
    --color-beige: #D7CCC8;
    --color-red: #B71C1C;
    
    /* Secondary Colors */
    --color-blue: #37474F;
    --color-green: #7D8C7C;
    --color-gold: #FFC107;
    
    /* Typography */
    --font-heading: 'Playfair Display', serif;
    --font-body: 'Roboto', sans-serif;
    --font-accent: 'Fjalla One', sans-serif;
}

/* Global Styles */
body {
    font-family: var(--font-body);
    color: #333;
    line-height: 1.6;
}

h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-heading);
    font-weight: 700;
}

/* Custom Buttons */
.cw-button {
    background-color: var(--color-brown);
    color: white;
    border: none;
    padding: 12px 24px;
    font-family: var(--font-accent);
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.cw-button:hover {
    background-color: var(--color-red);
    transform: translateY(-2px);
}

/* Section Styles */
.cw-section {
    padding: 80px 0;
}

.cw-section-title {
    position: relative;
    margin-bottom: 40px;
}

.cw-section-title:after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background-color: var(--color-red);
    margin-top: 16px;
}
```

#### `assets/css/woocommerce-custom.css`

Contains custom styling specifically for WooCommerce elements:

```css
/**
 * WooCommerce Custom Styles for Cuevas Western Wear
 */

/* Product Cards */
.woocommerce ul.products li.product {
    border: 1px solid #eee;
    border-radius: 4px;
    padding: 15px;
    transition: all 0.3s ease;
}

.woocommerce ul.products li.product:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

/* Product Title */
.woocommerce ul.products li.product .woocommerce-loop-product__title {
    font-family: var(--font-heading);
    font-size: 18px;
    padding-top: 15px;
}

/* Product Price */
.woocommerce ul.products li.product .price {
    color: var(--color-brown);
    font-weight: 700;
    font-size: 16px;
}

/* Add to Cart Button */
.woocommerce ul.products li.product .button {
    background-color: var(--color-brown);
    color: white;
    font-family: var(--font-accent);
    text-transform: uppercase;
    font-weight: 400;
}

.woocommerce ul.products li.product .button:hover {
    background-color: var(--color-red);
}

/* Single Product Page */
.woocommerce div.product div.images .woocommerce-product-gallery__wrapper {
    border: 1px solid #eee;
    border-radius: 4px;
    overflow: hidden;
}

.woocommerce div.product .product_title {
    font-family: var(--font-heading);
    font-size: 32px;
}

/* Cart Page */
.woocommerce-cart table.cart td.actions .coupon .input-text {
    width: 150px;
    padding: 10px;
}

.woocommerce-cart .wc-proceed-to-checkout a.checkout-button {
    background-color: var(--color-brown);
    color: white;
    font-family: var(--font-accent);
}

/* Checkout Page */
.woocommerce-checkout #payment {
    background-color: #f9f9f9;
    border-radius: 4px;
}

.woocommerce-checkout #payment div.payment_box {
    background-color: white;
}
```

### 3. JavaScript Organization

#### `inc/enqueue-scripts.php`

Handles the enqueuing of all scripts and styles:

```php
<?php
/**
 * Enqueue scripts and styles for the child theme
 *
 * @package HelloElementorChild
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue child theme styles and scripts
 */
function hello_elementor_child_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;700&family=Fjalla+One&display=swap',
        array(),
        HELLO_ELEMENTOR_CHILD_VERSION
    );
    
    // Enqueue custom styles
    wp_enqueue_style(
        'hello-elementor-child-custom-styles',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/css/custom-styles.css',
        array(),
        HELLO_ELEMENTOR_CHILD_VERSION
    );
    
    // Enqueue WooCommerce custom styles
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'hello-elementor-child-woocommerce',
            HELLO_ELEMENTOR_CHILD_URI . '/assets/css/woocommerce-custom.css',
            array(),
            HELLO_ELEMENTOR_CHILD_VERSION
        );
    }
    
    // Enqueue responsive styles (load last)
    wp_enqueue_style(
        'hello-elementor-child-responsive',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/css/responsive.css',
        array('hello-elementor-child-custom-styles'),
        HELLO_ELEMENTOR_CHILD_VERSION
    );
    
    // Enqueue GSAP core
    wp_enqueue_script(
        'gsap-core',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/js/gsap/gsap.min.js',
        array(),
        '3.11.5',
        true
    );
    
    // Enqueue GSAP plugins
    wp_enqueue_script(
        'gsap-scroll-trigger',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/js/gsap/ScrollTrigger.min.js',
        array('gsap-core'),
        '3.11.5',
        true
    );
    
    wp_enqueue_script(
        'gsap-draggable',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/js/gsap/Draggable.min.js',
        array('gsap-core'),
        '3.11.5',
        true
    );
    
    wp_enqueue_script(
        'gsap-css-rule',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/js/gsap/CSSRulePlugin.min.js',
        array('gsap-core'),
        '3.11.5',
        true
    );
    
    // Enqueue custom animations
    wp_enqueue_script(
        'hello-elementor-child-animations-global',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/js/animations/animations-global.js',
        array('gsap-core', 'gsap-scroll-trigger'),
        HELLO_ELEMENTOR_CHILD_VERSION,
        true
    );
    
    // Conditionally load page-specific animations
    if (is_front_page()) {
        wp_enqueue_script(
            'hello-elementor-child-animations-home',
            HELLO_ELEMENTOR_CHILD_URI . '/assets/js/animations/animations-home.js',
            array('gsap-core', 'gsap-scroll-trigger'),
            HELLO_ELEMENTOR_CHILD_VERSION,
            true
        );
    }
    
    if (is_woocommerce()) {
        wp_enqueue_script(
            'hello-elementor-child-animations-products',
            HELLO_ELEMENTOR_CHILD_URI . '/assets/js/animations/animations-products.js',
            array('gsap-core'),
            HELLO_ELEMENTOR_CHILD_VERSION,
            true
        );
    }
    
    if (is_cart() || is_checkout()) {
        wp_enqueue_script(
            'hello-elementor-child-animations-cart',
            HELLO_ELEMENTOR_CHILD_URI . '/assets/js/animations/animations-cart.js',
            array('gsap-core'),
            HELLO_ELEMENTOR_CHILD_VERSION,
            true
        );
    }
    
    // Enqueue custom main script
    wp_enqueue_script(
        'hello-elementor-child-custom-scripts',
        HELLO_ELEMENTOR_CHILD_URI . '/assets/js/custom-scripts.js',
        array('jquery'),
        HELLO_ELEMENTOR_CHILD_VERSION,
        true
    );
    
    // Enqueue WooCommerce custom scripts
    if (class_exists('WooCommerce')) {
        wp_enqueue_script(
            'hello-elementor-child-woocommerce-scripts',
            HELLO_ELEMENTOR_CHILD_URI . '/assets/js/woocommerce-custom.js',
            array('jquery'),
            HELLO_ELEMENTOR_CHILD_VERSION,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_scripts');
```

### 4. WooCommerce Integration

#### `inc/woocommerce-hooks.php`

Contains hooks and functions for customizing WooCommerce:

```php
<?php
/**
 * WooCommerce customization hooks and functions
 *
 * @package HelloElementorChild
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    return;
}

/**
 * WooCommerce specific setup
 */
function hello_elementor_child_woocommerce_setup() {
    // Add theme support for WooCommerce features
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
}
add_action('after_setup_theme', 'hello_elementor_child_woocommerce_setup');

/**
 * Modify number of products per row on shop page
 */
function hello_elementor_child_woocommerce_loop_columns() {
    return 3; // Show 3 products per row
}
add_filter('loop_shop_columns', 'hello_elementor_child_woocommerce_loop_columns');

/**
 * Modify number of related products
 */
function hello_elementor_child_related_products_args($args) {
    $args['posts_per_page'] = 3; // Number of related products
    $args['columns'] = 3; // Number of columns
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'hello_elementor_child_related_products_args');

/**
 * Add a custom badge to featured products
 */
function hello_elementor_child_featured_product_badge() {
    global $product;
    
    if ($product->is_featured()) {
        echo '<span class="featured-badge">Featured</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'hello_elementor_child_featured_product_badge', 10);

/**
 * Add a wrapper around the add to cart button for animation
 */
function hello_elementor_child_add_to_cart_wrapper_open() {
    echo '<div class="add-to-cart-wrapper">';
}
add_action('woocommerce_after_shop_loop_item', 'hello_elementor_child_add_to_cart_wrapper_open', 9);

function hello_elementor_child_add_to_cart_wrapper_close() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop_item', 'hello_elementor_child_add_to_cart_wrapper_close', 11);

/**
 * Modify checkout fields
 */
function hello_elementor_child_override_checkout_fields($fields) {
    // Add placeholder to first name field
    $fields['billing']['billing_first_name']['placeholder'] = 'First Name';
    $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
    $fields['billing']['billing_company']['placeholder'] = 'Company Name (Optional)';
    $fields['billing']['billing_email']['placeholder'] = 'Email Address';
    $fields['billing']['billing_phone']['placeholder'] = 'Phone Number';
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'hello_elementor_child_override_checkout_fields');
```

## Theme Configuration and Setup

To properly set up the child theme:

1. Create all directories and files according to the structure above
2. Install the Hello Elementor parent theme via the WordPress admin
3. Upload the child theme to `wp-content/themes/`
4. Activate the child theme in the WordPress admin
5. Configure Elementor to work with the child theme

## Child Theme Development Guidelines

1. Always maintain proper file organization
2. Document all custom functions and code blocks
3. Use WordPress coding standards
4. Implement responsive design for all custom styling
5. Keep performance in mind, especially with GSAP animations
6. Test all WooCommerce features thoroughly
7. Create reusable components where possible
8. Follow the visual design plan closely 