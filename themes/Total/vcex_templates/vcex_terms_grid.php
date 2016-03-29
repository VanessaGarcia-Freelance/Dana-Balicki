<?php
/**
 * Visual Composer Terms Grid
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Not needed in admin ever
if ( is_admin() ) {
	return;
}

// Get and extract shortcode attributes
extract( vc_map_get_attributes( $this->getShortcode(), $atts ) );

// Taxonomy is required
if ( ! $taxonomy ) {
	return;
}

// Sanitize data
$title_typo = vcex_parse_typography_param( $title_typo );
$title_tag = ! empty( $title_typo['tag'] ) ? $title_typo['tag'] : 'h2';
$description_typo = vcex_parse_typography_param( $description_typo );

// Get terms
if ( $parent_terms ) {
	$terms = get_terms( $taxonomy, array( 'parent' => 0 ) );
} else {
	$terms = get_terms( $taxonomy );
}

// Get term thumbnails
$term_data = wpex_get_term_data();

// Define post type based on the taxonomy
$taxonomy  = get_taxonomy( $taxonomy );
$post_type = $taxonomy->object_type[0];

// Grid classes
$grid_classes = array( 'vcex-terms-grid', 'wpex-row', 'clr' );
if ( $columns_gap ) {
	$grid_classes[] = 'gap-'. $columns_gap;
}
if ( $visibility ) {
	$grid_classes[] = $visibility;
}
if ( $classes ) {
	$grid_classes[] = vcex_get_extra_class( $classes );
}
$grid_classes = implode( ' ', $grid_classes );

// Entry classes
$entry_classes = array( 'vcex-terms-grid-entry', 'clr' );
$entry_classes[] = 'span_1_of_'. $columns;
if ( 'false' == $columns_responsive ) {
	$entry_classes[] = 'nr-col';
} else {
	$entry_classes[] = 'col';
} 
if ( $css_animation ) {
	$entry_classes[] = $this->getCSSAnimation( $css_animation );
}
$entry_classes = implode( ' ', $entry_classes );

// Entry CSS wrapper
if ( $entry_css ) {
	$entry_css_class = vc_shortcode_custom_css_class( $entry_css );
}

// Image classes
$media_classes = array( 'vcex-terms-grid-entry-image', 'margin-bottom-15px', 'clr' );
if ( $img_filter ) {
	$media_classes[] = wpex_image_filter_class( $img_filter );
}
if ( $img_hover_style ) {
	$media_classes[] = wpex_image_hover_classes( $img_hover_style );
}
$media_classes = implode( ' ', $media_classes );

// Title style
$title_style       = vcex_inline_style( $title_typo );
$description_style = vcex_inline_style( $description_typo ); ?>

<div class="<?php echo $grid_classes; ?>">
		
	<?php
	// Start counter
	$counter = 0;

	// Loop through terms
	foreach( $terms as $term ) :

		// Add to counter
		$counter++; ?>

		<div class="<?php echo $entry_classes; ?> term-<?php echo $term->term_id; ?> <?php echo $term->slug; ?> col-<?php echo $counter; ?>">

			<?php if ( $entry_css && $entry_css_class ) { ?>
				<div class="<?php echo $entry_css_class; ?>">
			<?php } ?>

				<?php
				// Check meta for featured image
				$image_id = '';

				// Check wpex_term_thumbnails option for custom category image
				if ( ! empty( $term_data[$term->term_id]['thumbnail'] ) ) {

					$image_id = $term_data[$term->term_id]['thumbnail'];

				}

				// Get woo product image
				elseif ( 'product' == $post_type && function_exists( 'get_woocommerce_term_meta' ) ) {
					$image_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
				}

				// Image not defined via meta, display image from first post in term
				if ( ! $image_id ) : ?>

					<?php
					// Query first post in term
					$my_query = new WP_Query( array(
						'post_type'      => $post_type,
						'posts_per_page' => '1',
						'no_found_rows'  => true,
						'tax_query'      => array(
							array(
								'taxonomy' => $term->taxonomy,
								'field'    => 'id',
								'terms'    => $term->term_id,
							)
						),
					) );

					// Get featured image of first post
					if ( $my_query->have_posts() ) {

						while ( $my_query->have_posts() ) : $my_query->the_post(); ?>

							<?php $image_id = get_post_thumbnail_id(); ?>

						<?php endwhile;

					}

					// Reset query
					wp_reset_postdata(); ?>

				<?php endif; ?>

				<?php if ( $image_id ) : ?>

					<div class="<?php echo $media_classes; ?>">
						<a href="<?php echo get_term_link( $term, $taxonomy ); ?>" title="<?php echo $term->name; ?>">
							<?php
							// Display post thumbnail
							wpex_post_thumbnail( array(
								'attachment' => $image_id,
								'width'      => $img_width,
								'height'     => $img_height,
								'crop'       => $img_crop,
								'alt'        => $term->name,
								'size'       => $img_size,
							) ); ?>
						</a>
					</div><!-- .image -->

				<?php endif; ?>

				<?php
				// Display term title
				if ( 'true' == $title && ! empty( $term->name ) ) : ?>

					<<?php echo $title_tag; ?> class="vcex-terms-grid-entry-title entry-title"<?php echo $title_style; ?>>
						<a href="<?php echo get_term_link( $term, $taxonomy ); ?>" title="<?php echo $term->name; ?>">
							<?php echo $term->name; ?>
						</a>
					</<?php echo $title_tag; ?>>

				<?php endif; ?>

				<?php
				// Display term description
				if ( 'true' == $description && ! empty( $term->description ) ) : ?>

					<div class="vcex-terms-grid-entry-excerpt clr"<?php echo $description_style; ?>>
						<?php echo $term->description; ?>
					</div><!-- .vcex-terms-grid-entry-excerpt -->

				<?php endif; ?>

			</div><!-- .vcex-terms-grid-entry -->

		<?php if ( $entry_css && $entry_css_class ) { ?>
			</div>
		<?php } ?>

		<?php
		// Clear counter
		if ( $counter == $columns ) $counter = 0; ?>

	<?php endforeach; ?>

</div><!-- .vcex-terms-grid -->