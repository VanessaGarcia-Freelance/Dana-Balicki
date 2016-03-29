<?php
/**
 * Title Date Visibile Overlay
 *
 * @package Total WordPress Theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only used for inside position
if ( 'inside_link' != $position ) {
	return;
} ?>

<div class="overlay-title-date-visible theme-overlay">
	<div class="overlay-title-date-visible-inner clr">
		<div class="overlay-title-date-visible-text clr">
			<div class="overlay-title-date-visible-title">
				<?php the_title(); ?>
			</div><!-- .overlay-title-date-visible-title -->
			<div class="overlay-title-date-visible-date">
				<?php echo get_the_date( 'F j, Y' ); ?>
			</div><!-- .overlay-title-date-visible-date -->
		</div><!-- .overlay-title-date-visible-text -->
	</div><!-- .overlay-title-date-visible-inner -->
</div><!-- .overlay-title-date-visible -->