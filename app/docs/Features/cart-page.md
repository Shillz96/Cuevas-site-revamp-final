# Cart Page Template

## Overview
The cart page is a full-width, responsive layout that displays the customer's selected products, quantities, and pricing. It allows for cart modifications and provides a pathway to checkout, all styled consistently with the western theme.

## Template Hierarchy
This template follows the WordPress template hierarchy for WooCommerce cart page:
1. `woocommerce/cart/cart.php` (primary template for the cart table)
2. `woocommerce/cart.php` (alternate template in woocommerce folder)
3. `page-cart.php` (custom page template)
4. `page.php` (general page template)
5. `singular.php` (template for all singular content)
6. `index.php` (ultimate fallback)

For additional cart components:
- Cart totals: `woocommerce/cart/cart-totals.php`
- Cross-sells: `woocommerce/cart/cross-sells.php`
- Empty cart: `woocommerce/cart/cart-empty.php`

## Template File
**Primary File**: `woocommerce/cart/cart.php`

## Layout Components
1. **Cart Table**: Product images, names, prices, quantities, and subtotals
2. **Cart Totals**: Subtotal, shipping, taxes, and total
3. **Cross-Sells**: Suggested products based on cart contents
4. **Update/Checkout Buttons**: Action buttons for cart management

## Core Functionality
- Display cart contents in a structured table
- Allow quantity adjustments
- Allow product removal
- Calculate and display totals
- Provide path to checkout
- Show cross-sell products

## Technical Requirements
1. **Structure**:
   - WooCommerce template override
   - Full-width layout
   - Responsive design for all screen sizes

2. **Animation**:
   - No complex animations required
   - Simple hover effects for buttons
   - Optional fade-in for cross-sells

3. **WordPress/WooCommerce Integration**:
   - Standard WooCommerce hooks for cart display
   - Cart update functionality
   - Cart total calculations
   - Cross-sell display

4. **Performance Considerations**:
   - Optimize ajax cart updates
   - Minimize unnecessary HTTP requests
   - Proper handling of cart sessions

## Template Code Example
```php
<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="woocommerce-cart-wrapper">
  <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
      <thead>
        <tr>
          <th class="product-remove">&nbsp;</th>
          <th class="product-thumbnail">&nbsp;</th>
          <th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
          <th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
          <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
          <th class="product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php do_action('woocommerce_before_cart_contents'); ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
          $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
          $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

          if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
            <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

              <td class="product-remove">
                <?php
                echo apply_filters(
                  'woocommerce_cart_item_remove_link',
                  sprintf(
                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                    esc_html__('Remove this item', 'woocommerce'),
                    esc_attr($product_id),
                    esc_attr($_product->get_sku())
                  ),
                  $cart_item_key
                );
                ?>
              </td>

              <td class="product-thumbnail">
                <?php
                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                if (!$product_permalink) {
                  echo $thumbnail; // PHPCS: XSS ok.
                } else {
                  printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                }
                ?>
              </td>

              <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                <?php
                if (!$product_permalink) {
                  echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                } else {
                  echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                }

                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                // Meta data.
                echo wc_get_formatted_cart_item_data($cart_item);

                // Backorder notification.
                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                  echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                }
                ?>
              </td>

              <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                <?php
                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                ?>
              </td>

              <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                <?php
                if ($_product->is_sold_individually()) {
                  $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                } else {
                  $product_quantity = woocommerce_quantity_input(
                    array(
                      'input_name'   => "cart[{$cart_item_key}][qty]",
                      'input_value'  => $cart_item['quantity'],
                      'max_value'    => $_product->get_max_purchase_quantity(),
                      'min_value'    => '0',
                      'product_name' => $_product->get_name(),
                    ),
                    $_product,
                    false
                  );
                }

                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                ?>
              </td>

              <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                <?php
                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                ?>
              </td>
            </tr>
            <?php
          }
        }
        ?>

        <?php do_action('woocommerce_after_cart_contents'); ?>
      </tbody>
    </table>

    <div class="cart-actions">
      <?php if (wc_coupons_enabled()) { ?>
        <div class="coupon">
          <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
          <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
          <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
          <?php do_action('woocommerce_cart_coupon'); ?>
        </div>
      <?php } ?>

      <button type="submit" class="button update-cart" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

      <?php do_action('woocommerce_cart_actions'); ?>

      <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
    </div>
    
    <?php do_action('woocommerce_after_cart_table'); ?>
  </form>

  <div class="cart-collaterals">
    <?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    do_action('woocommerce_cart_collaterals');
    ?>
  </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
```

## CSS Customization
```css
.woocommerce-cart-wrapper {
  width: 100%;
  padding: 20px;
  background-color: #F5F5DC;
  color: #3E2723;
}

.woocommerce table.shop_table {
  border: 1px solid #8B4513;
  background-color: white;
}

.woocommerce table.shop_table th {
  background-color: #8B4513;
  color: white;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.woocommerce-cart-form__cart-item td {
  padding: 12px !important;
  vertical-align: middle !important;
}

.woocommerce a.remove {
  color: #A52A2A !important;
}

.woocommerce a.remove:hover {
  background-color: #A52A2A !important;
  color: white !important;
}

.product-thumbnail img {
  width: 80px !important;
  height: auto !important;
  border: 1px solid #8B4513;
}

.product-name a {
  color: #3E2723;
  font-weight: bold;
}

.cart-actions {
  padding: 20px 0;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
}

.coupon {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: center;
}

.coupon label {
  margin-right: 10px;
}

.coupon input {
  padding: 8px;
  border: 1px solid #8B4513;
}

.button {
  background-color: #A52A2A !important;
  color: white !important;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: background-color 0.3s;
}

.button:hover {
  background-color: #D2691E !important;
}

.cart-collaterals {
  margin-top: 30px;
}

.cart_totals h2 {
  color: #3E2723;
  font-family: 'Playfair Display', serif;
  border-bottom: 2px solid #8B4513;
  padding-bottom: 10px;
}

.woocommerce .cart-collaterals .cart_totals, 
.woocommerce-page .cart-collaterals .cart_totals {
  width: 100%;
  max-width: 500px;
  float: right;
}

.wc-proceed-to-checkout .button {
  display: block;
  width: 100%;
  text-align: center;
  padding: 15px !important;
  font-size: 1.1em !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .woocommerce table.shop_table_responsive tr td::before, 
  .woocommerce-page table.shop_table_responsive tr td::before {
    color: #8B4513;
    font-weight: bold;
  }
  
  .cart-actions {
    flex-direction: column;
  }
  
  .coupon {
    width: 100%;
    margin-bottom: 15px;
  }
}
```

## Testing Checklist
- [ ] Cart table displays correctly with all products
- [ ] Product images load and display properly
- [ ] Quantity adjustments work correctly
- [ ] Product removal functions properly
- [ ] Cart updates correctly when changing quantities
- [ ] Coupon system works if enabled
- [ ] Cart totals calculate and display correctly
- [ ] Proceed to checkout button works
- [ ] Layout is responsive on all device sizes 