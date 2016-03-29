<?php
/**
 * Staff single related template part
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if disabled
if ( ! wpex_get_mod( 'staff_related', true ) ) {
	return;
}

// Vars
global $post, $wpex_theme;
$post_id	= $wpex_theme->post_id;
$post_count	= wpex_get_mod( 'staff_related_count', '3' );

// Return if pass required
if ( post_password_required() ) {
	return;
}

// Disabled via meta setting - goodbye
if ( 'on' == get_post_meta( $post_id, 'wpex_disable_related_items', true ) ) {
	return;
}

// Create an array of current category ID's
$cats     = wp_get_post_terms( $post_id, 'staff_category' ); 
$cats_ids = array();  
foreach( $cats as $wpex_related_cat ) {
	$cats_ids[] = $wpex_related_cat->term_id; 
}
if ( ! empty( $cats_ids ) ) {
	$tax_query = array (
		array (
			'taxonomy' => 'staff_category',
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
	'post_type'      => 'staff',
	'posts_per_page' => $post_count,
	'orderby'        => 'rand',
	'post__not_in'   => array( $post_id ),
	'no_found_rows'  => true,
	'tax_query'      => $tax_query,
);
$args				= apply_filters( 'wpex_related_staff_args', $args );
$wpex_related_query = new wp_query( $args );

// If posts were found display related items
if ( $wpex_related_query->have_posts() ) :

	// Wrap classes
	$wrap_classes = 'related-staff-posts clr';
	if ( 'full-screen' == $wpex_theme->post_layout ) {
		$wrap_classes .= ' container';
	} ?>

	<section class="<?php echo $wrap_classes; ?>">

		<?php
		// Get heading text
		$heading = wpex_get_mod( 'staff_related_title', __( 'Related Staff', 'wpex' ) );

		// Fallback
		$heading = $heading ? $heading : __( 'Related Staff', 'wpex' );

		// Translate heading with WPML
		$heading = wpex_translate_theme_mod( 'staff_related_title', $heading );

		// If Heading text isn't empty
		if ( $heading ) : ?>
			<?php
			// Display heading
			wpex_heading( array(
				'content'		=> $heading,
				'tag'			=> 'h2',
				'classes'		=> array( 'related-staff-posts-heading' ),
				'apply_filters'	=> 'staff_related',
			) ); ?>
		<?php endif; ?>

		<div class="wpex-row clr">
			<?php $wpex_count = 0; ?>
			<?php foreach( $wpex_related_query->posts as $post ) : setup_postdata( $post ); ?>
				<?php $wpex_count++; ?>
				<?php $template = locate_template( 'partials/staff/staff-entry.php' ); ?>
				<?php if ( $template ) include( $template ); ?>
				<?php if ( $wpex_count == $post_count ) $wpex_count = 0; ?>
			<?php endforeach; ?>
		</div><!-- .wpex-row -->

	</section><!-- .related-staff-posts -->

<?php endif; ?>
<?php wp_reset_postdata(); ?>