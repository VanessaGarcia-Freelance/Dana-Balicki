<?php
/**
 * Blog single post related heading
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get heading
$heading = wpex_blog_related_heading();

// Output heading
wpex_heading( array(
	'content'		=> $heading,
	'tag'			=> 'div',
	'classes'		=> array( 'related-posts-title' ),
	'apply_filters'	=> 'blog_related',
) );