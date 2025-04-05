# Home Page Template

## Overview
The home page is a visually engaging, full-width layout with four main sections: Hero, Gallery, Featured Products, and Shop Now. Each section occupies the full viewport height and width, snapping into view as the user scrolls. GSAP (GreenSock Animation Platform) powers seamless scroll-triggered animations, particularly in the Gallery section, using the free core library and ScrollTrigger plugin.

## Layout
- **Hero Section**: A full-screen hero image set via the WordPress admin panel.
- **Gallery Section**: A series of full-screen images that animate as the user scrolls through them.
- **Featured Products Section**: Displays six featured WooCommerce products in a 2x3 grid (adjusted from 3x3 for six items).
- **Shop Now Section**: Three large call-to-action buttons linking to shop categories.
- No footer is included on this page.

## HTML Structure
Create a custom page template in your theme, e.g., `page-home.php`:

```php
<?php
/*
Template Name: Home Page
*/
get_header();
?>

<div class="container">
  <!-- Hero Section -->
  <section class="full-screen hero" style="background-image: url('<?php echo esc_url(get_theme_mod('hero_image', '')); ?>');">
    <!-- Optional: Add overlay text or buttons if desired -->
  </section>

  <!-- Gallery Section -->
  <?php
  $gallery_images = get_theme_mod('gallery_images', []);
  foreach ($gallery_images as $index => $image) {
    echo '<section class="full-screen gallery-item" style="background-image: url(\'' . esc_url($image) . '\');" data-gallery-index="' . $index . '"></section>';
  }
  ?>

  <!-- Featured Products Section -->
  <section class="full-screen featured-products">
    <div class="products-grid">
      <?php
      $args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        'meta_query' => array(
          array(
            'key' => '_featured',
            'value' => 'yes',
          ),
        ),
      );
      $products = new WP_Query($args);
      if ($products->have_posts()) {
        while ($products->have_posts()) {
          $products->the_post();
          ?>
          <div class="product">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium'); ?>
              <h3><?php the_title(); ?></h3>
              <p><?php echo wc_price(get_post_meta(get_the_ID(), '_price', true)); ?></p>
            </a>
          </div>
          <?php
        }
        wp_reset_postdata();
      }
      ?>
    </div>
  </section>

  <!-- Shop Now Section -->
  <section class="full-screen shop-now">
    <div class="buttons">
      <a href="<?php echo esc_url(get_term_link('men', 'product_cat')); ?>" class="button">Shop Men's</a>
      <a href="<?php echo esc_url(get_term_link('women', 'product_cat')); ?>" class="button">Shop Women's</a>
      <a href="<?php echo esc_url(get_term_link('hats', 'product_cat')); ?>" class="button">Shop Hats</a>
    </div>
  </section>
</div>

<?php get_footer(); ?>
```

**Notes**:
- Replace 'men', 'women', and 'hats' with your actual WooCommerce category slugs.
- `gallery_images` and `hero_image` are custom fields set via the WordPress Customizer (see WordPress Integration below).

## CSS
Add to your theme's `style.css`:

```css
/* General Full-Screen Styling */
.full-screen {
  width: 100vw;
  height: 100vh;
  position: relative;
  background-size: cover;
  background-position: center;
  overflow: hidden;
}

/* Hero Section */
.hero {
  background-color: #F5F5DC; /* Fallback color */
}

/* Gallery Section */
.gallery-item {
  background-color: #F5F5DC; /* Fallback */
}

/* Featured Products Section */
.featured-products {
  background-color: #F5F5DC;
  display: flex;
  align-items: center;
  justify-content: center;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 2 rows of 3 = 6 products */
  gap: 20px;
  padding: 20px;
  max-width: 1200px;
  width: 100%;
}

.product {
  text-align: center;
  color: #3E2723;
}

.product img {
  max-width: 100%;
  height: auto;
  border: 2px solid #8B4513;
}

.product h3 {
  margin: 10px 0;
  font-size: 1.5em;
}

.product p {
  color: #A52A2A;
}

/* Shop Now Section */
.shop-now {
  background-color: #F5F5DC;
  display: flex;
  align-items: center;
  justify-content: center;
}

.buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.button {
  padding: 15px 30px;
  background-color: #A52A2A;
  color: white;
  text-decoration: none;
  font-size: 1.2em;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.button:hover {
  background-color: #D2691E;
}
```

## JavaScript (GSAP)
Enqueue GSAP and ScrollTrigger in your theme's `functions.php`:

```php
function theme_enqueue_scripts() {
  wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js', array(), null, true);
  wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js', array('gsap'), null, true);
  wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array('gsap', 'gsap-scrolltrigger'), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
```

Create `js/scripts.js` in your theme folder:

```javascript
document.addEventListener('DOMContentLoaded', () => {
  // Register ScrollTrigger
  gsap.registerPlugin(ScrollTrigger);

  // Snap scrolling between full-screen sections
  const sections = gsap.utils.toArray('.full-screen');
  const container = document.querySelector('.container');

  gsap.to(sections, {
    y: () => -(container.scrollHeight - window.innerHeight),
    ease: 'none',
    scrollTrigger: {
      trigger: container,
      pin: true,
      scrub: 1,
      snap: {
        snapTo: 1 / (sections.length - 1), // Snap to each section
        duration: { min: 0.2, max: 0.5 },
        ease: 'power1.inOut',
      },
      end: () => '+=' + (container.scrollHeight - window.innerHeight),
    },
  });

  // Gallery animations
  gsap.utils.toArray('.gallery-item').forEach((item, index) => {
    gsap.from(item, {
      opacity: 0,
      scale: 0.95,
      duration: 1,
      scrollTrigger: {
        trigger: item,
        start: 'top 80%',
        end: 'bottom 20%',
        toggleActions: 'play none none reverse',
      },
    });
  });

  // Featured Products animation
  gsap.from('.product', {
    opacity: 0,
    y: 50,
    duration: 0.8,
    stagger: 0.2,
    scrollTrigger: {
      trigger: '.featured-products',
      start: 'top 80%',
      toggleActions: 'play none none reverse',
    },
  });

  // Shop Now buttons animation
  gsap.from('.button', {
    opacity: 0,
    x: (index) => (index - 1) * 50, // Slide in from left/center/right
    duration: 0.8,
    stagger: 0.2,
    scrollTrigger: {
      trigger: '.shop-now',
      start: 'top 80%',
      toggleActions: 'play none none reverse',
    },
  });
});
```

**Explanation**:
- **Snap Scrolling**: The entire page uses ScrollTrigger to pin the container and snap to each full-screen section as the user scrolls. The `snapTo` value is calculated based on the number of sections.
- **Gallery Animations**: Each gallery image fades in and scales up slightly when entering the viewport, reversing when scrolled out.
- **Featured Products**: Products animate in with a staggered effect, sliding up from below.
- **Shop Now Buttons**: Buttons slide in from different directions (left, center, right) with a stagger for a dynamic effect.
- All effects use the free GSAP core library and ScrollTrigger plugin.

## WordPress Integration
Hero Image: Add to `functions.php` to allow customization:

```php
function theme_customizer($wp_customize) {
  $wp_customize->add_section('home_settings', array(
    'title' => 'Home Page Settings',
  ));
  $wp_customize->add_setting('hero_image');
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
    'label' => 'Hero Image',
    'section' => 'home_settings',
  )));
  $wp_customize->add_setting('gallery_images', array('default' => []));
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'gallery_images', array(
    'label' => 'Gallery Images',
    'section' => 'home_settings',
    'mime_type' => 'image',
    'multiple' => true,
  )));
}
add_action('customize_register', 'theme_customizer');
```

**Assign Template**: In the WordPress admin, create a page, set its template to "Home Page," and assign it as the front page. 