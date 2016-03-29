<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

// Get site header
get_header(); ?>

    <div id="content-wrap" class="container clr">

        <?php wpex_hook_primary_before(); ?>

        <div id="primary" class="content-area clr">

            <?php wpex_hook_content_before(); ?>

            <div id="content" class="clr site-content">

                <?php wpex_hook_content_top(); ?>

                <?php
                // Main page loop
                while ( have_posts() ) : the_post(); ?>

                    <article class="clr">

                        <?php
                        // Check if page should display featured image
                        if ( has_post_thumbnail() && wpex_get_mod( 'page_featured_image' ) ) : ?>

                            <div id="page-featured-img" class="clr">

                                <?php
                                // Dislpay full featured image
                                wpex_post_thumbnail( array(
                                    'size'  => 'full',
                                    'alt'   => wpex_get_esc_title(),
                                ) ); ?>
                                
                            </div><!-- #page-featured-img -->

                        <?php endif; ?>

                        <div class="entry-content entry clr">

                            <?php
                            // Output page content
                            the_content(); ?>

                            <?php
                            // Output page pagination
                            wp_link_pages( array(
                                'before'        => '<div class="page-links clr">',
                                'after'         => '</div>',
                                'link_before'   => '<span>',
                                'link_after'    => '</span>',
                            ) ); ?>

                        </div><!-- .entry-content -->

                        <?php
                        // Get social sharing template part
                        get_template_part( 'partials/social', 'share' ); ?>

                    </article><!-- #post -->

                    <?php
                    // Check if comments are enabled for pages
                    if ( wpex_get_mod( 'page_comments' ) ) : ?>
                    
                        <?php
                        // Display comments
                        comments_template(); ?>

                    <?php endif; ?>

                <?php
                // End main loop
                endwhile; ?>

                <?php wpex_hook_content_bottom(); ?>

            </div><!-- #content -->

            <?php wpex_hook_content_after(); ?>

        </div><!-- #primary -->

        <?php wpex_hook_primary_after(); ?>

    </div><!-- #content-wrap -->

<?php
// Get site footer
get_footer(); ?>