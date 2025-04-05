# Product (Single Product) Page Template

## Overview
The single product page is a full-width layout with WooCommerce product details, styled to match the theme. A subtle GSAP animation enhances the product image on load.

## HTML Structure
Override `woocommerce/single-product.php`:

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
.woocommerce div.product {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  padding: 20px;
  background-color: #F5F5DC;
  color: #3E2723;
}

.woocommerce div.product .woocommerce-product-gallery__image img {
  border: 2px solid #8B4513;
}

.woocommerce div.product .price {
  color: #A52A2A;
  font-size: 1.5em;
}

.woocommerce div.product .button {
  background-color: #A52A2A;
  color: white;
}
```

## JavaScript (GSAP)
Add to `js/scripts.js`:

```javascript
// Product image animation
gsap.from('.woocommerce-product-gallery__image', {
  opacity: 0,
  scale: 0.9,
  duration: 1,
  ease: 'power2.out',
});
``` 