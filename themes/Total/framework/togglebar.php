<?php
/**
 * Toggle Bar helpter Functions
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

/**
 * Returns correct togglebar classes
 *
 * @since Total 1.0.0
 */
function wpex_toggle_bar_classes() {

	// Add default classes
	$classes = array( 'clr' );

	// Add animation classes
	if ( $animation = wpex_get_mod( 'toggle_bar_animation', 'fade' ) ) {
		$classes[] = 'toggle-bar-'. $animation;
	}

	// Add visibility classes
	if ( $visibility = wpex_get_mod( 'toggle_bar_visibility', 'always-visible' ) ) {
		$classes[] = $visibility;
	}

	// Apply filters for child theming
	$classes = apply_filters( 'wpex_toggle_bar_active', $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	// Return classes
	return $classes;

}