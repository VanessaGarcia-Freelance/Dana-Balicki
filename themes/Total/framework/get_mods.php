<?php
/**
 * Gets and stores all theme mods for use with the theme.
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

/**
 * Returns global mods
 *
 * @since 2.1.0
 */
function wpex_get_mods() {
	global $wpex_theme_mods;
	return $wpex_theme_mods;
}

/**
 * Returns theme mod from global var
 *
 * @since 2.1.0
 */
function wpex_get_mod( $id, $default = '' ) {

	// Return get_theme_mod on customize_preview
	if ( is_customize_preview() ) {
		return get_theme_mod( $id, $default );
	}
   
	// Get global object
	global $wpex_theme_mods;

	// Return data from global object
	if ( ! empty( $wpex_theme_mods ) ) {

		// Return value
		if ( isset( $wpex_theme_mods[$id] ) ) {
			return $wpex_theme_mods[$id];
		}

		// Return default
		else {
			return $default;
		}

	}

	// Global object not found return using get_theme_mod
	else {
		return get_theme_mod( $id, $default );
	}

}