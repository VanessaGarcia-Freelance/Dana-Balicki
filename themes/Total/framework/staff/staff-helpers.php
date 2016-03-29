<?php
/**
 * Useful global functions for the staff
 *
 * @package Total WordPress Theme
 * @subpackage Staff Functions
 */

/**
 * Returns staff entry blocks
 *
 * @since 2.1.0
 */
function wpex_staff_entry_blocks() {

	// Defaults
	$defaults = array( 'media', 'title', 'content', 'read_more' );

	// Get layout blocks
	$blocks = wpex_get_mod( 'staff_entry_composer' );

	// If blocks are 100% empty return defaults
	$blocks = $blocks ? $blocks : $defaults;

	// Convert blocks to array so we can loop through them
	if ( ! is_array( $blocks ) ) {
		$blocks = explode( ',', $blocks );
	}

	// Apply filters to entry layout blocks
	$blocks = apply_filters( 'wpex_staff_entry_blocks', $blocks );

	// Return blocks
	return $blocks;

}

/**
 * Returns staff post blocks
 *
 * @since 2.1.0
 */
function wpex_staff_post_blocks() {

	// Defaults
	$defaults = array( 'content', 'related' );

	// Get layout blocks
	$blocks = wpex_get_mod( 'staff_post_composer' );

	// If blocks are 100% empty return defaults
	$blocks = $blocks ? $blocks : $defaults;

	// Convert blocks to array so we can loop through them
	if ( ! is_array( $blocks ) ) {
		$blocks = explode( ',', $blocks );
	}
					
	// Apply filters to entry layout blocks
	$blocks = apply_filters( 'wpex_staff_single_blocks', $blocks );

	// Return blocks
	return $blocks;

}

/**
 * Returns correct thumbnail HTML for the staff entries
 *
 * @since 2.0.0
 */
function wpex_get_staff_entry_thumbnail() {
	return wpex_get_post_thumbnail( apply_filters( 'wpex_get_staff_entry_thumbnail_args', array(
		'size'  => 'staff_entry',
		'class' => 'staff-entry-img',
		'alt'   => wpex_get_esc_title(),
	) ) );
}

/**
 * Returns correct thumbnail HTML for the staff posts
 *
 * @since 2.0.0
 */
function wpex_get_staff_post_thumbnail() {
	return wpex_get_post_thumbnail( apply_filters( 'wpex_get_staff_post_thumbnail_args', array(
		'size'          => 'staff_post',
		'class'         => 'staff-single-media-img',
		'alt'           => wpex_get_esc_title(),
		'schema_markup' => true,
	) ) );
}

/**
 * Returns correct classes for the staff wrap
 *
 * @since 1.5.3
 */
function wpex_get_staff_wrap_classes() {

	// Define main classes
	$classes = array( 'wpex-row', 'clr' );

	// Get grid style
	$grid_style = wpex_get_mod( 'staff_archive_grid_style' );
	$grid_style =  $grid_style ? $grid_style : 'fit-rows';

	// Add grid style
	$classes[] = 'staff-'. $grid_style;

	// Apply filters
	apply_filters( 'wpex_staff_wrap_classes', $classes );

	// Turninto space seperated string
	$classes = implode( " ", $classes );

	// Return
	return $classes;

}

/**
 * Returns staff archive columns
 *
 * @since 2.0.0
 */
function wpex_staff_archive_columns() {
	return wpex_get_mod( 'staff_entry_columns', '3' );
}

/**
 * Returns correct classes for the staff grid
 *
 * @since Total 1.5.2
 */
if ( ! function_exists( 'wpex_staff_column_class' ) ) {
	function wpex_staff_column_class( $query ) {
		if ( 'related' == $query ) {
			return wpex_grid_class( wpex_get_mod( 'staff_related_columns', '3' ) );
		} else {
			return wpex_grid_class( wpex_get_mod( 'staff_entry_columns', '3' ) );
		}
	}
}

/**
 * Checks if match heights are enabled for the staff
 *
 * @since 1.5.3
 */
if ( ! function_exists( 'wpex_staff_match_height' ) ) {
	function wpex_staff_match_height() {
		$grid_style = wpex_get_mod( 'staff_archive_grid_style', 'fit-rows' ) ? wpex_get_mod( 'staff_archive_grid_style', 'fit-rows' ) : 'fit-rows';
		$columns    = wpex_get_mod( 'staff_entry_columns', '4' ) ? wpex_get_mod( 'staff_entry_columns', '4' ) : '4';
		if ( 'fit-rows' == $grid_style && wpex_get_mod( 'staff_archive_grid_equal_heights' ) && $columns > '1' ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Staff Overlay
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_get_staff_overlay' ) ) {
	function wpex_get_staff_overlay( $id = NULL ) {
		$post_id  = $id ? $id : get_the_ID();
		$position = get_post_meta( get_the_ID(), 'wpex_staff_position', true );
		if ( ! $position ) {
			return;
		} ?>
		<div class="staff-entry-position">
			<span><?php echo $position; ?></span>
		</div><!-- .staff-entry-position -->
		<?php
	}
}

/**
 * Outputs the staff social options
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_get_staff_social' ) ) {
	function wpex_get_staff_social( $atts = NULL ) {

		// Extract staff social args
		extract( shortcode_atts( array(
			'link_target' => 'blank',
			'post_id' => '',
			'style' => 'minimal-round',
			'font_size' => '',
			'css' => '',
		),
		$atts ) );

		ob_start();

		// Get social profiles array
		$profiles = wpex_staff_social_array();

		// Define post_id
		$post_id = $post_id ? $post_id : get_the_ID();

		// Parse style to return correct classname
		$style = wpex_get_social_button_class( $style );

		// Wrap classes
		$wrap_classes = 'staff-social wpex-social-btns clr';
		if ( $css ) {
			$wrap_classes .= ' '. vc_shortcode_custom_css_class( $css );
		}

		// Font size
		$font_size = $font_size ? wpex_sanitize_data( $font_size, 'font_size' ) : '';
		$font_size = $font_size ? 'style="font-size:'. $font_size .'"' : '';

		$tooltip = apply_filters( 'wpex_tooltips_enabled', false );
		$tooltip = $tooltip ? ' tooltip-up' : ''; ?>

		<div class="<?php echo $wrap_classes; ?>"<?php echo $font_size; ?>>
			<?php
			// Loop through social options
			foreach ( $profiles as $profile ) {

				// Get meta
				$meta = $profile['meta'];

				// Get URl
				$url = get_post_meta( $post_id, $meta, true );

				// Escape URL for all items except skype
				if ( ! in_array( $meta, array( 'wpex_staff_skype', 'wpex_staff_phone_number' ) ) ) {
					$url = esc_url( $url );
				}

				// Display link
				if ( $url ) {

					// Add "tel" for phones
					if ( 'wpex_staff_phone_number' === $meta ) {
						$url    = str_replace( 'tel:', '', $url );
						$url    = 'tel:'. $url;
					} ?>

					<a href="<?php echo $url; ?>" title="<?php echo $profile['label']; ?>" class="wpex-<?php echo str_replace( '_', '-', $profile['key'] ); ?> <?php echo $style; ?><?php echo $tooltip; ?>" target="_<?php echo $link_target; ?>">
						<span class="<?php echo $profile['icon_class']; ?>"></span>
					</a>

				<?php }
			} ?>
		</div><!-- .staff-social -->

		<?php return ob_get_clean();
	}
}
add_shortcode( 'staff_social', 'wpex_get_staff_social' );