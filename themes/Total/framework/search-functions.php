<?php
/**
 * Core search functions
 *
 * @package Total WordPress theme
 * @subpackage Framework
 */

/**
 * Defines your default search results page style
 *
 * @since 1.5.4
 */
function wpex_search_results_style() {
	return apply_filters( 'wpex_search_results_style', wpex_get_mod( 'search_style', 'default' ) );
}

/**
 * Adds the search icon to the menu items
 *
 * @since 1.0.0
 */
function wpex_add_search_to_menu ( $items, $args ) {

	// Only used on main menu
	if ( 'main_menu' != $args->theme_location ) {
		return $items;
	}

	// Get search style
	$search_style = wpex_global_obj( 'menu_search_style' );

	// Return if disabled
	if ( ! $search_style || 'disabled' == $search_style ) {
		return $items;
	}

	// Get header style
	$header_style = wpex_global_obj( 'header_style' );
	
	// Get correct search icon class
	if ( 'overlay' == $search_style) {
		$class = ' search-overlay-toggle';
	} elseif ( 'drop_down' == $search_style ) {
		$class = ' search-dropdown-toggle';
	} elseif ( 'header_replace' == $search_style ) {
		$class = ' search-header-replace-toggle';
	} else {
		$class = '';
	}

	// Add search item to menu
	$items .= '<li class="search-toggle-li wpex-menu-extra">';
		$items .= '<a href="#" class="site-search-toggle'. $class .'">';
			$items .= '<span class="link-inner">';
				$items .= '<span class="fa fa-search"></span>';
				if ( 'six' == $header_style ) {
					$items .= '<span class="wpex-menu-search-text">'. _x( 'Search', 'Navbar Search Text For Vertical Nav', 'wpex' ) .'</span>';
				}
			$items .= '</span>';
		$items .= '</a>';
	$items .= '</li>';
	
	// Return nav $items
	return $items;

}
add_filter( 'wp_nav_menu_items', 'wpex_add_search_to_menu', 11, 2 );