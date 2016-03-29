<?php
/**
 * Main portfolio entry template part
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Counter for clearing floats and margins
if ( ! isset( $wpex_related_query ) ) {
	global $wpex_count;
	$query = 'archive';
} else {
	$query = 'related';
}

// Add Standard Classes
$classes	= array();
$classes[]	= 'portfolio-entry';
$classes[]	= 'col';
$classes[]	= wpex_portfolio_column_class( $query );
$classes[]	= 'col-'. $wpex_count;

// Get grid style
$wpex_grid_style = wpex_get_mod( 'portfolio_archive_grid_style', 'fit-rows' );

// Masonry Classes
if ( 'archive' == $query && in_array( $wpex_grid_style, array( 'masonry', 'no-margins' ) ) ) {
	$classes[] = ' isotope-entry';
} ?>

<article id="#post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="portfolio-entry-inner wpex-clr">
		<?php get_template_part( 'partials/portfolio/portfolio-entry-media' ); ?>
		<?php get_template_part( 'partials/portfolio/portfolio-entry-content' ); ?>
	</div><!-- .portfolio-entry-inner -->
</article><!-- .portfolio-entry -->