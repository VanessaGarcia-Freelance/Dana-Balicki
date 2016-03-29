<?php
/**
 * Top Bar Functions
 *
 * @package Total WordPress Theme
 * @subpackage FrameWork
 */

/**
 * Topbar style
 *
 * @since 2.0.0
 */
function wpex_top_bar_style() {
	return apply_filters( 'wpex_top_bar_style', wpex_get_mod( 'top_bar_style', 'one' ) );
}

/**
 * Topbar classes
 *
 * @since 2.0.0
 */
function wpex_top_bar_classes( $classes = array() ) {

	// Check for content
	if ( wpex_top_bar_content() ) {
		$classes[] = 'has-content';
	}

	// Add clearfix class
	$classes[] = 'clr';

	// Get topbar style
	$style = wpex_top_bar_style();

	// Add classes based on top bar style
	if ( 'one' == $style ) {
		$classes[] = 'top-bar-left';
	} elseif( 'two' == $style ) {
		$classes[] = 'top-bar-right';
	} elseif( 'three' == $style ) {
		$classes[] = 'top-bar-centered';
	}

	// Apply filters for child theming
	$classes = apply_filters( 'wpex_top_bar_classes', $classes );

	// Turn classes array into space seperated string
	$classes = implode( ' ', $classes );

	// Return classes
	return esc_attr( $classes );

}