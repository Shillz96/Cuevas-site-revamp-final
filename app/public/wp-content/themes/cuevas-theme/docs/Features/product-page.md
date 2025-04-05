# Product Page Template

## Overview
The product page (single product view) displays detailed information about a specific WooCommerce product. It features a full-width layout with product images, details, purchasing options, and related products. A subtle GSAP animation enhances the product image on load.

## Template Hierarchy
This template follows the WordPress template hierarchy for WooCommerce single product pages:
1. `woocommerce/single-product-{product-type}.php` (specific product type template)
2. `woocommerce/single-product.php` (primary template for all products)
3. `single-product.php` (alternate template in theme root)
4. `single.php` (general single post template)
5. `singular.php` (template for all singular content)
6. `index.php` (ultimate fallback)

For variations and specific tabs:
- Product gallery: `woocommerce/single-product/product-image.php`
- Add to cart: `woocommerce/single-product/add-to-cart/{product-type}.php`
- Tabs: `woocommerce/single-product/tabs/`

## Template File
**Primary File**: `woocommerce/single-product.php`

## Layout Components
1. **Product Gallery**: Product images with zoom functionality
2. **Product Information**: Title, price, description, and attributes
3. **Purchase Options**: Quantity selector and Add to Cart button 
4. **Product Tabs**: Description, additional information, and reviews
5. **Related Products**: Display of similar or related products

## Core Functionality
- Full-width product display
- Product image gallery with zoom
- Variable product options (sizes, colors, etc.)
- Add to cart functionality
- Product tabs for organized information
- GSAP animation for product image loading

## Technical Requirements
1. **Structure**:
   - WooCommerce template override
   - Full-width layout
   - Organized product information sections

2. **Animation**:
   - Subtle GSAP animation for product gallery
   - Hover effects for thumbnails and buttons
   - Optional zoom effect on product images

3. **WordPress/WooCommerce Integration**:
   - Standard WooCommerce hooks for product display
   - Gallery integration
   - Variable product handling
   - Add to cart process

4. **Performance Considerations**:
   - Optimized image loading
   - Efficient GSAP animations
   - Proper handling of product variations

## Template Code Example
```php
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
  
  global $product;
  ?>
  <div class="single-product-wrapper">
    <div class="product-gallery-section">
      <?php
      /**
       * Hook: woocommerce_before_single_product_summary.
       * 
       * @hooked woocommerce_show_product_sale_flash - 10
       * @hooked woocommerce_show_product_images - 20
       */
      do_action('woocommerce_before_single_product_summary');
      ?>
    </div>

    <div class="product-details-section">
      <?php
      /**
       * Hook: woocommerce_single_product_summary.
       * 
       * @hooked woocommerce_template_single_title - 5
       * @hooked woocommerce_template_single_rating - 10
       * @hooked woocommerce_template_single_price - 10
       * @hooked woocommerce_template_single_excerpt - 20
       * @hooked woocommerce_template_single_add_to_cart - 30
       * @hooked woocommerce_template_single_meta - 40
       * @hooked woocommerce_template_single_sharing - 50
       */
      do_action('woocommerce_single_product_summary');
      ?>
    </div>
  </div>

  <?php
  /**
   * Hook: woocommerce_after_single_product_summary.
   * 
   * @hooked woocommerce_output_product_data_tabs - 10
   * @hooked woocommerce_upsell_display - 15
   * @hooked woocommerce_output_related_products - 20
   */
  do_action('woocommerce_after_single_product_summary');

endwhile; // end of the loop.

/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>
```

## CSS Customization
```css
.single-product-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  padding: 30px;
  background-color: #F5F5DC;
  color: #3E2723;
}

.product-gallery-section {
  flex: 1;
  min-width: 300px;
}

.product-details-section {
  flex: 1;
  min-width: 300px;
}

.woocommerce div.product div.images img {
  border: 2px solid #8B4513;
}

.woocommerce div.product .product_title {
  color: #3E2723;
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
}

.woocommerce div.product p.price {
  color: #A52A2A;
  font-size: 1.5rem;
  font-weight: bold;
}

.woocommerce div.product form.cart .button {
  background-color: #A52A2A;
  color: white;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: background-color 0.3s;
}

.woocommerce div.product form.cart .button:hover {
  background-color: #D2691E;
}

.woocommerce div.product .woocommerce-tabs ul.tabs li {
  background-color: #F5F5DC;
  border-color: #8B4513;
}

.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
  background-color: white;
  border-bottom-color: white;
}

.woocommerce div.product .woocommerce-tabs .panel {
  background-color: white;
  padding: 20px;
  border: 1px solid #8B4513;
  border-top: none;
}
```

## GSAP Animation
```javascript
// Add to scripts.js
document.addEventListener('DOMContentLoaded', function() {
  if (document.querySelector('.woocommerce-product-gallery__image')) {
    gsap.from('.woocommerce-product-gallery__image', {
      opacity: 0,
      scale: 0.9,
      duration: 1,
      ease: 'power2.out',
    });
  }
});
```

## Additional WooCommerce Customizations
To customize specific elements of the product page, you can override additional templates:

### Product Gallery
Create `woocommerce/single-product/product-image.php` to customize the gallery layout.

### Add to Cart Button
Create `woocommerce/single-product/add-to-cart/simple.php` (or other product types) to customize the add to cart experience.

### Product Tabs
Create `woocommerce/single-product/tabs/description.php`, `tabs/additional-information.php`, etc. to customize tab content.

## Testing Checklist
- [ ] Product gallery displays and functions correctly
- [ ] GSAP animation plays smoothly
- [ ] Product information is displayed clearly
- [ ] Variable product options work correctly
- [ ] Add to cart functionality works properly
- [ ] Product tabs display and function correctly
- [ ] Related products are displayed appropriately
- [ ] Layout is responsive across all device sizes 