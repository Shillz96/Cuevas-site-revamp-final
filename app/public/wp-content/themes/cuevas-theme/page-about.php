<?php
/**
 * Template Name: About Page
 * 
 * This is the template that displays the about page.
 * 
 * @package Cuevas_Theme
 */

get_header();
?>

<main class="site-main">
    <!-- Brand Story Component -->
    <section class="brand-section brand-pattern">
        <div class="container">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h2 class="section-title text-center"><?php the_title(); ?></h2>
                <?php if (has_excerpt()) : ?>
                    <p class="section-subtitle text-center"><?php echo wp_kses_post(get_the_excerpt()); ?></p>
                <?php endif; ?>

                <div class="brand-story">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>
        </div>
    </section>

    <!-- Craftsmanship Section -->
    <section class="craftsmanship-section">
        <div class="container">
            <div class="craft-item">
                <img src="<?php echo esc_url(get_theme_file_uri('assets/img/placeholder.jpg')); ?>" 
                     alt="Craftsmanship" 
                     class="craftsmanship-image">
                <h4>Quality Craftsmanship</h4>
                <p>Experience the finest in western wear craftsmanship, where every stitch tells a story of dedication and excellence.</p>
            </div>
        </div>
    </section>

    <!-- Trust Badges Section -->
    <section class="section trust-section">
        <div class="container">
            <div class="trust-badges">
                <?php
                $trust_badges = array(
                    array(
                        'icon' => 'fas fa-medal',
                        'title' => 'Quality Guaranteed',
                        'description' => 'All products backed by our satisfaction guarantee'
                    ),
                    array(
                        'icon' => 'fas fa-truck',
                        'title' => 'Free Shipping',
                        'description' => 'On all orders over $100 within the United States'
                    ),
                    array(
                        'icon' => 'fas fa-check-circle',
                        'title' => 'Authenticity',
                        'description' => 'Genuine western craftsmanship in every item'
                    ),
                    array(
                        'icon' => 'fas fa-headset',
                        'title' => 'Expert Support',
                        'description' => 'Our team is here to help you find the perfect fit'
                    )
                );

                foreach ($trust_badges as $badge) : ?>
                    <div class="trust-badge">
                        <i class="<?php echo esc_attr($badge['icon']); ?> trust-icon"></i>
                        <h4 class="trust-title"><?php echo esc_html($badge['title']); ?></h4>
                        <p><?php echo esc_html($badge['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php
// Enqueue GSAP animations for this page
add_action('wp_footer', function() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Timeline animation
        gsap.registerPlugin(ScrollTrigger);

        // Value cards animation
        gsap.from('.value-card', {
            opacity: 0,
            y: 40,
            stagger: 0.2,
            duration: 0.8,
            scrollTrigger: {
                trigger: '.brand-values',
                start: 'top 70%',
                toggleActions: 'play none none none'
            }
        });

        // Craftsmanship items animation
        gsap.from('.craft-item', {
            opacity: 0,
            scale: 0.9,
            stagger: 0.2,
            duration: 0.8,
            scrollTrigger: {
                trigger: '.craftsmanship-showcase',
                start: 'top 70%',
                toggleActions: 'play none none none'
            }
        });
    });
    </script>
    <?php
}, 20);

get_footer(); 