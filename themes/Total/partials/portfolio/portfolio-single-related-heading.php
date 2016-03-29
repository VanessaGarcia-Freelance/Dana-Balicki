<?php
/**
 * Portfolio single post related heading
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Output heading
wpex_heading( array(
	'content'		=> wpex_portfolio_related_heading(),
	'tag'			=> 'h2',
	'classes'		=> array( 'related-portfolio-posts-heading' ),
	'apply_filters'	=> 'portfolio_related',
) );