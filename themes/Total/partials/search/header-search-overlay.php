<?php
/**
 * Site header search dropdown HTML
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<section id="searchform-overlay" class="header-searchform-wrap clr">
	<div id="searchform-overlay-title"><?php _e( 'Search', 'wpex' ); ?></div>
	<?php get_search_form( true ); ?>
</section><!-- #searchform-overlay -->