# Cuevas Western Wear - WordPress Theme

A modern, responsive WordPress theme for Cuevas Western Wear e-commerce store. Designed for seamless WooCommerce integration with a focus on product display and user experience.

## Theme Structure

```
theme/
├── assets/
│   ├── css/
│   │   ├── main.css              # Main stylesheet
│   │   ├── homepage.css          # Homepage specific styles
│   │   ├── split-slideshow.css   # Hero slideshow styles
│   │   ├── product-card.css      # Product card component styles
│   │   ├── product-grid.css      # Product grid layout styles
│   │   ├── product-page.css      # Product page layout styles
│   │   ├── sidebar.css           # Sidebar and filter styles
│   │   ├── shop-categories.css   # Shop categories display
│   │   └── [other component css] # Various component styles
│   ├── js/
│   │   ├── animations.js         # Main animation scripts
│   │   ├── navigation.js         # Navigation functionality
│   │   ├── split-slideshow.js    # Homepage slideshow
│   │   ├── about-animations.js   # About page animations
│   │   ├── product-page.js       # Product page interactions
│   │   └── customizer.js         # Theme customizer
│   ├── images/                   # Theme images
│   └── img/                      # Additional image assets
├── inc/
│   ├── components/               # Component template parts
│   ├── widgets/                  # Custom widget code
│   ├── customizer.php            # Theme customization options
│   ├── template-tags.php         # Template helper functions
│   ├── woocommerce.php           # WooCommerce integration
│   └── enqueue.php               # Script/style registration
├── template-parts/               # Reusable template parts
│   ├── content.php               # Default content template
│   ├── content-none.php          # No content found template
│   ├── product-card.php          # Product card component
│   └── homepage/                 # Homepage section templates
│       ├── hero-section.php      # Hero section
│       ├── split-slideshow.php   # Slideshow component
│       ├── featured-products.php # Featured products section
│       ├── products-grid.php     # Products grid layout
│       └── shop-categories.php   # Shop categories section
├── woocommerce/                  # WooCommerce template overrides
├── .cursor/                      # Editor configuration
├── functions.php                 # Theme functions
├── style.css                     # Theme metadata
├── index.php                     # Main template file
├── header.php                    # Site header
├── footer.php                    # Site footer
├── sidebar.php                   # Sidebar template
├── front-page.php                # Homepage template
├── page.php                      # Default page template
├── page-about.php                # About page template
├── page-shop.php                 # Shop page template  
├── single.php                    # Single post template
├── archive.php                   # Archive template
├── search.php                    # Search results
└── 404.php                       # 404 error page
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

1. Create a new WordPress theme folder in `wp-content/themes/cuevas-theme`
2. Add the required theme files:
   - `style.css` (theme metadata)
   - `functions.php` (theme setup and functionality)
   - `index.php` (main template file)
   - `header.php` (site header)
   - `footer.php` (site footer)
   - `sidebar.php` (sidebar template)
   - `front-page.php` (homepage template)
   - `page.php` (default page template)
   - `single.php` (single post template) 
   - `archive.php` (archive template)
   - `search.php` (search results)
   - `404.php` (404 error page)

### 2. WooCommerce Templates

Override the following WooCommerce templates:

1. Create a `woocommerce` folder in your theme
2. Copy and modify these templates:
   - `content-product.php` (based on our product card)
   - `archive-product.php` (based on our product page)
   - `single-product.php`

### 3. Setup WooCommerce Support

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

### 4. Enqueue Scripts/Styles

The theme enqueues scripts and styles as configured in `functions.php`:

```php
function cuevas_scripts() {
    // Main stylesheet
    wp_enqueue_style('cuevas-style', get_stylesheet_uri(), array(), CUEVAS_VERSION);
    wp_enqueue_style('cuevas-main', get_template_directory_uri() . '/assets/css/main.css', array(), CUEVAS_VERSION);
    
    // Google fonts
    wp_enqueue_style('cuevas-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap', array(), null);
    
    // Slick Slider
    wp_enqueue_style('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
    wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
    
    // GSAP for animations
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true);
    
    // Main navigation functionality
    wp_enqueue_script('cuevas-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), CUEVAS_VERSION, true);
    
    // Conditional script loading for different templates
    if (is_front_page()) {
        wp_enqueue_script('cuevas-slideshow', get_template_directory_uri() . '/assets/js/split-slideshow.js', array('jquery', 'slick', 'gsap'), CUEVAS_VERSION, true);
    }
    
    if (is_page_template('page-about.php')) {
        wp_enqueue_script('cuevas-about', get_template_directory_uri() . '/assets/js/about-animations.js', array('gsap', 'gsap-scroll-trigger'), CUEVAS_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'cuevas_scripts');
```

## Customization Options

### Theme Colors

The theme uses CSS variables for easy color customization. You can modify these in the `main.css` file:

```css
:root {
  --primary: #8B4513;
  --primary-light: #A0522D;
  --primary-dark: #59331D;
  --secondary:rgb(247, 239, 239);
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