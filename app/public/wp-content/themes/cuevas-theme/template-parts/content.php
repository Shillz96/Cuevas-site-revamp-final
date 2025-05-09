<?php
/**
 * Template part for displaying posts
 *
 * @package CuevasWesternWear
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
            ?>
            <div class="entry-meta">
                <span class="posted-on">
                    <?php
                    echo esc_html__('Posted on ', 'cuevas');
                    echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_date() . '</a>';
                    ?>
                </span>
                <span class="posted-by">
                    <?php
                    echo esc_html__('by ', 'cuevas');
                    echo '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a>';
                    ?>
                </span>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php cuevas_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'cuevas'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'cuevas'),
                    'after'  => '</div>',
                )
            );
        else :
            the_excerpt();
            ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more-link">
                <?php echo esc_html__('Read More', 'cuevas'); ?> <i class="fas fa-arrow-right"></i>
            </a>
        <?php
        endif;
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php cuevas_entry_meta(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> --> 