<?php
/**
 * Template part for displaying the split slideshow on the homepage
 *
 * @package Cuevas_Western_Wear
 */

// Get slideshow images from ACF repeater field if available, otherwise use defaults
$slides = array();
$has_acf = function_exists('get_field');

if ($has_acf && have_rows('slideshow_slides')) {
    while (have_rows('slideshow_slides')) : the_row();
        $slides[] = array(
            'image' => get_sub_field('slide_image'),
            'text' => get_sub_field('slide_text')
        );
    endwhile;
} else {
    // Default fallback slides using placeholder service
    $slides = array(
        array(
            'image' => 'https://placehold.co/1920x1080/8B4513/FFF?text=Authentic',
            'text' => 'Authentic'
        ),
        array(
            'image' => 'https://placehold.co/1920x1080/A52A2A/FFF?text=Western',
            'text' => 'Western'
        ),
        array(
            'image' => 'https://placehold.co/1920x1080/D2691E/FFF?text=Heritage',
            'text' => 'Heritage'
        ),
        array(
            'image' => 'https://placehold.co/1920x1080/CD853F/FFF?text=Tradition',
            'text' => 'Tradition'
        ),
    );
}

// Only show if we have slides
if (!empty($slides)) :
?>
<div class="split-slideshow">
    <div class="slideshow">
        <div class="slider">
            <?php foreach ($slides as $slide) : ?>
                <div class="item">
                    <?php if (isset($slide['image']) && !empty($slide['image'])) : 
                        // Handle both ACF image array and direct URL
                        $image_url = is_array($slide['image']) ? $slide['image']['url'] : $slide['image'];
                    ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($slide['text']); ?>" />
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="slideshow-text">
        <?php foreach ($slides as $slide) : ?>
            <div class="item"><?php echo esc_html($slide['text']); ?></div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?> 