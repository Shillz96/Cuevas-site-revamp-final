# Cuevas Western Wear - WordPress Theme

A modern, responsive WordPress theme for Cuevas Western Wear e-commerce store. Designed for seamless WooCommerce integration with a focus on product display and user experience.

## Theme Structure

```
theme/
├── assets/
│   ├── css/
│   │   ├── main.css              # Main stylesheet (imports component CSS)
│   │   ├── product-card.css      # Product card component styles
│   │   ├── sidebar.css           # Sidebar and filter styles
│   │   └── product-page.css      # Product page layout styles
│   ├── js/
│   │   └── product-page.js       # Product page interactions
│   └── images/                   # Theme images
├── includes/
│   └── components/
│       └── product-card.html     # Product card component template
└── product-page.html            # Example product page
```

## Theme Features

- **Modern Product Card Design**: Clean, visually appealing product cards that match the design in the reference image.
- **Collapsible Sidebar**: Responsive sidebar with filters that collapses on mobile devices.
- **Compact Header**: Smaller header for product pages to maximize product visibility.
- **Responsive Grid Layout**: Fully responsive product grid that adapts to different screen sizes.
- **GSAP Animations**: Smooth animations for enhanced user experience.
- **Modular CSS**: Component-based CSS structure for easier maintenance.
- **WordPress/WooCommerce Ready**: Structured for easy integration with WordPress and WooCommerce.

## ScrollTrigger Animations

The theme incorporates GSAP ScrollTrigger for dynamic scroll-based animations:

### Home Page Animations
- **Hero Section**: Text elements fade in with staggered animation as you scroll
- **Header Transformation**: Header shrinks and becomes more compact when scrolling
- **Featured Products**: Products animate into view with a staggered sequence
- **Category Showcase**: Parallax effect with background images moving at different rates
- **Testimonials**: Text reveals word by word as you scroll into the section

### Implementation Details
```javascript
// Example ScrollTrigger implementation for the header
gsap.to(".site-header", {
  scrollTrigger: {
    trigger: "body",
    start: "top top",
    end: "50px top",
    scrub: true
  },
  height: "70px",
  padding: "10px 40px",
  backgroundColor: "rgba(89, 51, 29, 0.95)",
  boxShadow: "0 4px 12px rgba(0,0,0,0.1)"
});

// Example product reveal animation
gsap.from(".product-card", {
  scrollTrigger: {
    trigger: ".products-section",
    start: "top 80%",
    toggleActions: "play none none none"
  },
  y: 50,
  opacity: 0,
  duration: 0.8,
  stagger: 0.1
});
```

## WordPress Integration Guide

### 1. Theme Setup

1. Create a new WordPress theme folder in `wp-content/themes/cuevas-western`
2. Add the required theme files:
   - `style.css` (based on main.css)
   - `functions.php`
   - `index.php`
   - `header.php`
   - `footer.php`
   - `sidebar.php`
   - `screenshot.png`

### 2. WooCommerce Templates

Override the following WooCommerce templates:

1. Create a `woocommerce` folder in your theme
2. Copy and modify these templates:
   - `content-product.php` (based on our product card)
   - `archive-product.php` (based on our product page)
   - `single-product.php`

### 3. Enqueue Styles and Scripts

In `functions.php`:

```php
function cuevas_enqueue_scripts() {
    // Styles
    wp_enqueue_style('cuevas-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // Scripts
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true);
    wp_enqueue_script('cuevas-product-page', get_template_directory_uri() . '/assets/js/product-page.js', array('jquery', 'gsap'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'cuevas_enqueue_scripts');
```

### 4. Setup WooCommerce Support

In `functions.php`:

```php
function cuevas_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'cuevas_woocommerce_setup');
```

### 5. Create Product Card Template Part

Create `template-parts/product-card.php`:

```php
<div class="product-card">
  <div class="product-image-container">
    <?php the_post_thumbnail('shop_catalog', ['class' => 'product-image']); ?>
    <div class="quick-view-btn"><?php esc_html_e('Quick View', 'cuevas'); ?></div>
    <?php if ( $product->is_on_sale() ) : ?>
      <div class="product-badge badge-sale"><?php esc_html_e('Sale', 'cuevas'); ?></div>
    <?php endif; ?>
  </div>
  
  <div class="product-info">
    <h3 class="product-title"><?php the_title(); ?></h3>
    <?php if ( $product->get_short_description() ) : ?>
      <p class="product-subtitle"><?php echo wp_trim_words( $product->get_short_description(), 10 ); ?></p>
    <?php endif; ?>
    <div class="product-price"><?php echo $product->get_price_html(); ?></div>
    <button class="add-to-cart-btn"><?php esc_html_e('Add to Cart', 'cuevas'); ?></button>
  </div>
</div>
```

## Customization Options

### Theme Colors

The theme uses CSS variables for easy color customization. You can modify these in the `main.css` file:

```css
:root {
  --primary: #8B4513;
  --primary-light: #A0522D;
  --primary-dark: #59331D;
  --secondary: #3a3a3a;
  /* etc. */
}
```

### Product Grid Layout

To change the number of products per row, modify the following in `product-card.css`:

```css
.products-grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
}
```

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- IE11 (basic support)

## Performance Considerations

- CSS files are modular and can be combined/minified for production
- Images should be optimized and use WebP format where possible
- Consider using a caching plugin for WordPress
- JavaScript is loaded with defer attribute for better page load performance

## Credits

- Font Awesome for icons
- GSAP for animations
- Google Fonts for typography 