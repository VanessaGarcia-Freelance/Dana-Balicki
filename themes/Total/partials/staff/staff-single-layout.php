<?php
/**
 * Staff single layout
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Single layout blocks
$blocks = wpex_staff_post_blocks();

// Loop through blocks and get template part
foreach ( $blocks as $block ) {
	get_template_part( 'partials/staff/staff-single-'. $block );
}