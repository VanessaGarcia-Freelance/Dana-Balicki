<?php
/**
 * The template used for single testimonial posts.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

get_header(); ?>

    <?php
    // If testimonials is disabled use single-other.php template instead
    if ( ! WPEX_TESTIMONIALS_IS_ACTIVE ) {
        get_template_part( 'single-other' );
        return;
    } ?>
    
    <div id="content-wrap" class="container clr">

        <?php wpex_hook_primary_before(); ?>

        <div id="primary" class="content-area clr">

            <?php wpex_hook_content_before(); ?>

            <div id="content" class="clr site-content">

                <?php wpex_hook_content_top(); ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <article class="clr">

                        <div class="entry-content entry clr">

                            <?php if ( 'blockquote' == wpex_get_mod( 'testimonial_post_style', 'blockquote' ) ) : ?>

                                <?php get_template_part( 'partials/testimonials/testimonials-entry' ); ?>

                            <?php else : ?>

                                <?php the_content(); ?>

                            <?php endif; ?>

                        </div><!-- .entry-content -->

                    </article><!-- #post -->

                    <?php
                    // Displays comments if enabled
                    if ( wpex_get_mod( 'testimonials_comments' ) && comments_open() ) : ?>

                        <section id="testimonials-post-comments" class="clr">
                            <?php comments_template(); ?>
                        </section><!-- #testimonials-post-comments -->

                    <?php endif; ?>

                <?php endwhile; ?>

                <?php wpex_hook_content_bottom(); ?>

            </div><!-- #content -->

            <?php wpex_hook_content_after(); ?>

        </div><!-- #primary -->

        <?php wpex_hook_primary_after(); ?>

    </div><!-- .container -->

<?php get_footer();?>