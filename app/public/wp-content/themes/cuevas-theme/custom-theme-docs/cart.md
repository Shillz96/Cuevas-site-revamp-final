# My Cart Page Template

## Overview
The cart page is full-width, displaying the cart contents and checkout options, styled consistently with the theme.

## HTML Structure
Override `woocommerce/cart/cart.php` or use the default:

```php
<?php
get_header();
?>

<main class="full-width">
  <?php woocommerce_content(); ?>
</main>

<?php get_footer(); ?>
```

## CSS
```css
.woocommerce-cart .woocommerce {
  width: 100vw;
  padding: 20px;
  background-color: #F5F5DC;
  color: #3E2723;
}

.woocommerce-cart table.cart {
  border-color: #8B4513;
}

.woocommerce-cart .button {
  background-color: #A52A2A;
  color: white;
}
``` 