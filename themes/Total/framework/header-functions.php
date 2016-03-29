<?php
/**
 * Site Header Helper Functions
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

/**
 * Returns page header overlay logo
 *
 * @since 2.0.0
 */
function wpex_header_overlay_logo() {

	// Return false if disabled
	if ( ! wpex_global_obj( 'has_overlay_header' ) ) {
		return false;
	}

	// No custom overlay logo by default
	$logo = false;

	// Get logo via custom field
	$logo = get_post_meta( wpex_global_obj( 'post_id' ), 'wpex_overlay_header_logo', true );

	// Check old method
	if ( is_array( $logo ) ) {
		if ( ! empty( $logo['url'] ) ) {
			$logo = $logo['url'];
		} else {
			$logo = false;
		}
	}

	// Apply filters for child theming
	$logo = apply_filters( 'wpex_header_overlay_logo', $logo );

	// Sanitize URL
	if ( is_numeric( $logo ) ) {
		$logo = wp_get_attachment_image_src( $logo, 'full' );
		$logo = $logo[0];
	} else {
		$logo = esc_url( $logo );
	}

	// Return logo
	return $logo;

}

/**
 * Add classes to the header wrap
 *
 * @since 1.5.3
 */
function wpex_header_classes() {

	// Vars
	$header_style = wpex_global_obj( 'header_style' );

	// Setup classes array
	$classes = array();

	// Main header style
	$classes['header_style'] = 'header-'. $header_style;

	// Full width header
	if ( wpex_get_mod( 'full_width_header' ) ) {
		$classes[] = 'wpex-full-width';
	}

	// Sticky Header
	if ( wpex_global_obj( 'has_fixed_header' )
		&& ( 'one' == $header_style || 'five' == $header_style )
	) {
		$classes['fixed_scroll'] = 'fixed-scroll';
		// Shrink header
		if ( wpex_global_obj( 'shrink_fixed_header' ) ) {
			$classes['wpex-shrink-sticky-header'] = 'wpex-shrink-sticky-header';
		}	
	}

	// Reposition cart and search dropdowns
	if ( 'three' == $header_style || 'five' == $header_style ) {
		$classes[] = 'wpex-reposition-cart-search-drops';
	}

	// Dropdown style (must be added here so we can target shop/search dropdowns)
	if ( $dropdown_style = wpex_get_mod( 'menu_dropdown_style' ) ) {
		$classes['wpex-dropdown-style-'. $dropdown_style] = 'wpex-dropdown-style-'. $dropdown_style;
	}

	// Header Overlay Style
	if ( wpex_global_obj( 'has_overlay_header' ) ) {

		// Dark dropdowns for overlay header
		unset( $classes['wpex-dropdown-style-'. $dropdown_style] );
		$classes[] = 'wpex-dropdown-style-black';

		// Remove fixed scroll class
		if ( wpex_global_obj( 'has_top_bar' )  ) {
			unset( $classes['fixed_scroll'] );
			unset( $classes['wpex-shrink-sticky-header'] );
		}

		// Add overlay header class
		$classes[] = 'overlay-header';

		// Add a fixed class for the overlay-header style only
		if ( wpex_global_obj( 'has_fixed_header' ) ) {
			$classes[] = 'fix-overlay-header';
		}

		// Add overlay header class
		$classes[] = 'overlay-header';

		// Add overlay header style class
		$overlay_style = wpex_global_obj( 'header_overlay_style' );
		$overlay_style = $overlay_style ? $overlay_style : 'light';
		$classes[] = $overlay_style .'-style';

	}


	// Clearfix class
	$classes[] = 'clr';

	// Set keys equal to vals
	$classes = array_combine( $classes, $classes );
	
	// Apply filters for child theming
	$classes = apply_filters( 'wpex_header_classes', $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	// return classes
	return $classes;

}

/**
 * Returns header logo icon
 *
 * @since 2.0.0
 */
function wpex_header_logo_icon() {

	// Get logo img from admin panel
	$icon = wpex_get_mod( 'logo_icon' );

	// Apply filter for child theming
	$icon = apply_filters( 'wpex_header_logo_icon', $icon );

	// Return icon
	if ( $icon && 'none' != $icon ) {
		return '<span id="site-logo-fa-icon" class="fa fa-'. $icon .'"></span>';
	} else {
		return NULL;
	}

}

/**
 * Returns header logo title
 *
 * @since 2.0.0
 */
function wpex_header_logo_title() {
	$title = get_bloginfo( 'name' );
	$title = apply_filters( 'wpex_logo_title', $title );
	return $title;
}

/**
 * Returns header logo URL
 *
 * @since 2.0.0
 */
function wpex_header_logo_url() {
	$url = esc_url( home_url( '/' ) );
	$url = apply_filters( 'wpex_logo_url', $url );
	return $url;
}

/**
 * Header logo classes
 *
 * @since 2.0.0
 */
function wpex_header_logo_classes() {

	// Define classes array
	$classes = array( 'site-branding', 'clr' );

	// Default class
	$classes[] = 'header-'. wpex_global_obj( 'header_style' ) .'-logo';

	// Get custom overlay logo
	if ( wpex_global_obj( 'has_overlay_header' ) && wpex_header_overlay_logo() ) {
		$classes[] = 'has-overlay-logo';
	}

	// Apply filters for child theming
	$classes = apply_filters( 'wpex_header_logo_classes', $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	// Return classes
	return $classes;

}


/**
 * Adds js for the retina logo
 *
 * @since 1.1.0
 */
function wpex_retina_logo() {

	// Get theme options
	$logo_url    = wpex_get_mod( 'retina_logo' );
	$logo_height = wpex_get_mod( 'retina_logo_height' );

	// Translate theme mods
	$logo_url    = wpex_translate_theme_mod( 'retina_logo', $logo_url );
	$logo_height = wpex_translate_theme_mod( 'retina_logo_height', $logo_height );

	// Header overlay Retina logo
	if ( wpex_header_overlay_logo() && wpex_global_obj( 'has_overlay_header' ) ) {
		$post_id = wpex_global_obj( 'post_id' );
		$overlay_retina_logo = get_post_meta( $post_id, 'wpex_overlay_header_logo_retina', true );
		$overlay_retina_logo_height = get_post_meta( $post_id, 'wpex_overlay_header_logo_retina_height', true );
		if ( $overlay_retina_logo && $overlay_retina_logo_height ) {
			if ( is_numeric( $overlay_retina_logo ) ) {
				$overlay_retina_logo = wp_get_attachment_image_src( $overlay_retina_logo, 'full' );
				$overlay_retina_logo = $overlay_retina_logo[0];
			} else {
				$overlay_retina_logo = esc_url( $overlay_retina_logo );
			}
			if ( $overlay_retina_logo ) {
				$logo_url = $overlay_retina_logo;
				$logo_height = $overlay_retina_logo_height;
			}
		}
	}

	// Apply filters
	$logo_url    = apply_filters( 'wpex_retina_logo_url', $logo_url );
	$logo_height = apply_filters( 'wpex_retina_logo_height', $logo_height );

	// Output JS for retina logo
	if ( $logo_url && $logo_height ) {
		$output = '<!-- Retina Logo -->
					<script type="text/javascript">
						var $wpexRetinaLogo = "'. $logo_url .'",
							$wpexRetinaLogoHeight = "'. intval( $logo_height ) .'";
						jQuery(function($){
							if ( window.devicePixelRatio >= 2 ) {
								$("#site-logo img").attr("src", "'. $logo_url .'");
								$("#site-logo img").css("max-height", "'. intval( $logo_height ) .'px");
							}
						});
					</script>';
		echo $output;
	}
}
add_action( 'wp_head', 'wpex_retina_logo' );