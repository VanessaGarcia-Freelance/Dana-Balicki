<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

get_header(); ?>

    <?php
    // Standard post template file
    if ( is_singular( 'post' ) ) : ?>
    
        <?php get_template_part( 'single-standard' ); ?>

    <?php
    /**
     * Third party post type template file
     * You can create a file called single-post_type.php in your child theme and it will use that instead
     */
    else : ?>

        <?php get_template_part( 'single-other' ); ?>

    <?php endif; ?>

<?php get_footer(); ?>