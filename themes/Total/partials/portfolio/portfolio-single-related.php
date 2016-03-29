<?php
/**
 * Portfolio single related posts template part
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if disabled or password protected or disabled via meta
if ( ! wpex_get_mod( 'portfolio_related', true )
	|| 'on' == get_post_meta( get_the_ID(), 'wpex_disable_related_items', true )
	|| post_password_required( get_the_ID() )
) {
	return;
}

// Get global $post
global $post;

// Create an array of current category ID's
$cats		= wp_get_post_terms( get_the_ID(), 'portfolio_category' ); 
$cats_ids	= array();
foreach( $cats as $wpex_related_cat ) {
	$cats_ids[] = $wpex_related_cat->term_id; 
}

// Set tax query if there are categories to relate to the current post
if ( ! empty( $cats_ids ) ) {
	$tax_query = array (
		array (
			'taxonomy' => 'portfolio_category',
			'field'    => 'id',
			'terms'    => $cats_ids,
			'operator' => 'IN',
		),
	);
} else {
	$tax_query = '';
}

// Related query arguments
$args = array(
	'post_type'      => 'portfolio',
	'posts_per_page' => wpex_get_mod( 'portfolio_related_count', '4' ),
	'orderby'        => 'rand',
	'post__not_in'   => array( get_the_ID() ),
	'no_found_rows'  => true,
	'tax_query'      => $tax_query,
);

// Add filter so you can alter the query via child theme without having to modify this file
$args = apply_filters( 'wpex_related_portfolio_args', $args );

// Create new Query
$wpex_related_query = new wp_query( $args );

// If posts were found display related items
if ( $wpex_related_query->have_posts() ) :

	// Define wrap classes
	$wrap_classes = array( 'related-portfolio-posts', 'clr' );

	// Add container to the wrap classes for full-screen layouts to center it
	if ( 'full-screen' == wpex_global_obj( 'post_layout' ) ) {
		$wrap_classes[] = 'container';
	}

	// Turn classes into a string
	$wrap_classes = implode( ' ', $wrap_classes ); ?>

	<section class="<?php echo $wrap_classes; ?>">

		<?php
		// Get heading template part
		get_template_part( 'partials/portfolio/portfolio-single-related', 'heading' ); ?>

		<div class="wpex-row clr">

			<?php
			// Define post counter
			$wpex_count = '0'; ?>

			<?php
			// Loop through posts
			foreach( $wpex_related_query->posts as $post ) : setup_postdata( $post ); ?>

				<?php
				// Add to counter
				$wpex_count++; ?>

				<?php
				// Define entry template part
				$template = locate_template( 'partials/portfolio/portfolio-entry.php' ); ?>

				<?php
				// Include template (use include to pass variables)
				if ( $template ) include( $template ); ?>

				<?php
				// Reset counter
				if ( $wpex_count == wpex_get_mod( 'portfolio_related_columns', '4' ) ) $wpex_count = '0'; ?>

			<?php
			// End loop
			endforeach; ?>

		</div><!-- .row -->
		
	</section><!-- .related-portfolio-posts -->
	
<?php
// End have_posts check
endif; ?>

<?php
// Reset the global $post data to prevent conflicts
wp_reset_postdata(); ?>