# Shop Page Template

## Overview
The shop page uses WooCommerce's default shop template, customized to be full-width and styled with the western theme. No custom GSAP animations are required beyond the hamburger menu.

## Layout
Full-width product listing with WooCommerce's standard grid.

## HTML Structure
Override the WooCommerce shop template by copying `woocommerce/archive-product.php` to `your-theme/woocommerce/archive-product.php`. Ensure it's full-width:

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
.full-width {
  width: 100vw;
  margin: 0;
  padding: 20px;
  background-color: #F5F5DC;
}

.woocommerce ul.products {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.woocommerce ul.products li.product {
  text-align: center;
  color: #3E2723;
}

.woocommerce ul.products li.product a img {
  border: 2px solid #8B4513;
}

.woocommerce ul.products li.product .price {
  color: #A52A2A;
}
```

## Notes
- Remove sidebars via CSS or by setting the page template to full-width in WordPress.
- No additional GSAP animations are specified for this page. 