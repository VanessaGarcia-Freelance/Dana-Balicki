<?php
/**
 * This is an old outdated file, doesn't really do anything else but provide a fallback
 * for people that had been using the theme before version 1.6.0
 *
 * WILL BE REMOVED AT SOME POINT, SO DO NOT USE IT.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Search entry
if ( is_search() ) :
	get_template_part( 'partials/search/search', 'entry' );
	return;

// Prevent issues with post types incorrectly trying to load this template file
elseif ( in_array( get_post_type(), array( 'portfolio', 'staff', 'testimonials' ) ) ) :
	get_template_part( 'partials/' . get_post_type() .'/'. get_post_type(), 'entry' );
	return;

// Get single format (fallback for changes made in 1.6.0 )
elseif ( is_singular() && 'post' == get_post_type() ) :
	$post_format = get_post_format() ? get_post_format() : 'thumbnail';
	get_template_part( 'partials/blog/formats/blog-single', $post_format );
	return;

// Standard blog entries
elseif( 'post' == get_post_type() ) :
	get_template_part( 'partials/blog/blog-entry', 'layout' );
	return;

// Other post types
else :
	get_template_part( 'partials/post-type/post-type-entry', get_post_type() );
	return;
endif;