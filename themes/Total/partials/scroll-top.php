<?php
/**
 * The Scroll-Top Button
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get arrow
$arrow = wpex_get_mod( 'scroll_top_arrow' );
$arrow = $arrow ? $arrow : 'chevron-up'; ?>

<a href="#" id="site-scroll-top"><span class="fa fa-<?php echo $arrow; ?>"></span></a>