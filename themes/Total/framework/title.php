<?php
/**
 * Returns the correct title to display for any post/page/archive
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

function wpex_title() {

	// Default title is null
	$title = NULL;
	
	// Get post ID from global object
	$post_id = wpex_global_obj( 'post_id' );
	
	// Homepage - display blog description if not a static page
	if ( is_front_page() && ! is_singular( 'page' ) ) {
		
		if ( get_bloginfo( 'description' ) ) {
			$title = get_bloginfo( 'description' );
		} else {
			return __( 'Recent Posts', 'wpex' );
		}

	// Homepage posts page
	} elseif ( is_home() && ! is_singular( 'page' ) ) {

		$title = get_the_title( get_option( 'page_for_posts', true ) );

	}

	// Search => NEEDS to go before archives
	elseif ( is_search() ) {
		global $wp_query;
		$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. __( 'Search Results Found', 'wpex' );
	}
		
	// Archives
	elseif ( is_archive() ) {

		// Author
		if ( is_author() ) {
			/*$title = sprintf(
				__( 'All posts by%s', 'wpex' ),': <span class="vcard">' . get_the_author() . '</span>'
			);*/
			$title = get_the_archive_title();
		}

		// Post Type archive title
		elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		// Daily archive title
		elseif ( is_day() ) {
			$title = sprintf( __( 'Daily Archives: %s', 'wpex' ), get_the_date() );
		}

		// Monthly archive title
		elseif ( is_month() ) {
			$title = sprintf( __( 'Monthly Archives: %s', 'wpex' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'wpex' ) ) );
		}

		// Yearly archive title
		elseif ( is_year() ) {
			$title = sprintf( __( 'Yearly Archives: %s', 'wpex' ), get_the_date( _x( 'Y', 'yearly archives date format', 'wpex' ) ) );
		}

		// Categories/Tags/Other
		else {

			// Get term title
			$title = single_term_title( '', false );

			// Fix for bbPress and other plugins that are archives but use pages
			if ( ! $title ) {
				global $post;
				$title = get_the_title( $post_id );
			}

		}

	} // End is archive check

	// 404 Page
	elseif ( is_404() ) {

		$title = wpex_get_mod( 'error_page_title' );
		$title = $title ? $title : __( '404: Page Not Found', 'wpex' );
		$title = wpex_translate_theme_mod( 'error_page_title', $title );

	}
	
	// Anything else with a post_id defined
	elseif ( $post_id ) {

		// Single posts custom text
		if ( is_singular( 'post' ) && 'custom_text' == wpex_get_mod( 'blog_single_header', 'custom_text' ) ) {
			$title = wpex_get_mod( 'blog_single_header_custom_text', __( 'Blog', 'wpex' ) );
		}
		
		// Post title
		else {
			$title = get_the_title( $post_id );
		}

	}

	// Backup
	$title = $title ? $title : get_the_title();

	// Apply filters
	$title = apply_filters( 'wpex_title', $title );

	// Return title
	return $title;
	
}