<?php
/**
 * Searchform for the mobile sidebar menu
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="mobile-menu-search" class="clr wpex-hidden">
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-menu-searchform">
		<input type="search" name="s" autocomplete="off" placeholder="<?php echo apply_filters( 'wpex_mobile_searchform_placeholder', __( 'Search', 'wpex' ) ); ?>" />
		<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) { ?>
			<input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>"/>
		<?php } ?>
		<button type="submit" class="searchform-submit">
			<span class="fa fa-search"></span>
		</button>
	</form>
</div><!-- .mobile-menu-search -->