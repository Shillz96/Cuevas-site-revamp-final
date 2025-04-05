# Shop Page Template

## Overview
The shop page displays WooCommerce products in a full-width grid layout, styled with the western theme aesthetic. It provides customers with a clean, organized view of available products with filtering and sorting options.

## Template Hierarchy
This template follows the WordPress template hierarchy for WooCommerce:
1. `woocommerce/archive-product.php` (primary template for shop page)
2. `archive-product.php` (alternate template in theme root)
3. `woocommerce.php` (fallback for all WooCommerce content)
4. `archive.php` (general archive template)
5. `index.php` (ultimate fallback)

For product categories:
1. `woocommerce/taxonomy-product_cat-{category-slug}.php`
2. `taxonomy-product_cat-{category-slug}.php`
3. `woocommerce/taxonomy-product_cat.php`
4. `taxonomy-product_cat.php`
5. (then follow the regular archive hierarchy)

## Template File
**Primary File**: `woocommerce/archive-product.php`

## Layout Components
1. **Page Header**: Category title and optional description
2. **Product Filters**: Sidebar with product filtering options
3. **Product Grid**: Full-width responsive grid of products
4. **Pagination**: Navigation between product pages

## Core Functionality
- Full-width product display
- Filter products by attributes, price, etc.
- Sort products by various criteria
- Display product images, titles, and prices
- Quick view functionality (optional)

## Technical Requirements
1. **Structure**:
   - WooCommerce template override
   - Full-width layout
   - Responsive grid design

2. **Animation**:
   - Subtle hover effects on product cards
   - No complex GSAP animations required

3. **WordPress/WooCommerce Integration**:
   - Standard WooCommerce hooks for product displays
   - Optional custom product query modifications
   - Category and attribute filtering

4. **Performance Considerations**:
   - Pagination for large product catalogs
   - Image optimization
   - Efficient product queries

## Template Code Example
```php
<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');
?>

<header class="woocommerce-products-header">
  <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
    <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
  <?php endif; ?>

  <?php
  /**
   * Hook: woocommerce_archive_description.
   */
  do_action('woocommerce_archive_description');
  ?>
</header>

<?php
if (woocommerce_product_loop()) {
  /**
   * Hook: woocommerce_before_shop_loop.
   */
  do_action('woocommerce_before_shop_loop');

  woocommerce_product_loop_start();

  if (wc_get_loop_prop('total')) {
    while (have_posts()) {
      the_post();

      /**
       * Hook: woocommerce_shop_loop.
       */
      do_action('woocommerce_shop_loop');

      wc_get_template_part('content', 'product');
    }
  }

  woocommerce_product_loop_end();

  /**
   * Hook: woocommerce_after_shop_loop.
   */
  do_action('woocommerce_after_shop_loop');
} else {
  /**
   * Hook: woocommerce_no_products_found.
   */
  do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>
```

## Customizing Individual Product Display
To customize how individual products appear in the grid, create or modify `woocommerce/content-product.php`:

```php
<?php
/**
 * The template for displaying product content within loops
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
  return;
}
?>
<li <?php wc_product_class('product-card', $product); ?>>
  <div class="product-image">
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     */
    do_action('woocommerce_before_shop_loop_item_title');
    ?>
  </div>
  
  <div class="product-details">
    <h2 class="woocommerce-loop-product__title"><?php echo esc_html($product->get_name()); ?></h2>
    
    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     */
    do_action('woocommerce_after_shop_loop_item_title');
    
    /**
     * Hook: woocommerce_after_shop_loop_item.
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
  </div>
</li>
```

## CSS Customization
```css
.woocommerce ul.products {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
  width: 100%;
  padding: 0;
}

.woocommerce ul.products li.product-card {
  background-color: #F5F5DC;
  border: 1px solid #8B4513;
  text-align: center;
  transition: transform 0.3s ease;
}

.woocommerce ul.products li.product-card:hover {
  transform: translateY(-5px);
}

.product-image img {
  width: 100%;
  height: auto;
  border-bottom: 1px solid #8B4513;
}

.product-details {
  padding: 15px;
}

.woocommerce-loop-product__title {
  color: #3E2723;
  font-size: 1.2em;
  margin-bottom: 10px;
}

.woocommerce ul.products li.product .price {
  color: #A52A2A;
  font-weight: bold;
}

.woocommerce ul.products li.product .button {
  background-color: #A52A2A;
  color: white;
  border-radius: 3px;
  font-weight: normal;
  text-transform: uppercase;
  letter-spacing: 1px;
}
```

## Testing Checklist
- [ ] Products display correctly in the grid layout
- [ ] Product filtering works properly
- [ ] Product sorting functions as expected
- [ ] Product images load properly and are optimized
- [ ] Layout is responsive and works on all device sizes
- [ ] WooCommerce hooks are maintained for compatibility
- [ ] Category pages follow the same design pattern 