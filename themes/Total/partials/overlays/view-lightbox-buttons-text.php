<?php
/**
 * Lightbox Buttons + Text Overlay
 *
 * @package Total WordPress Theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only used for outside position
if ( 'outside_link' != $position ) {
	return;
}

// Load lightbox skin stylesheet
wpex_enqueue_ilightbox_skin();

// Lightbox
$lightbox_link = ! empty( $args['lightbox_link'] ) ? $args['lightbox_link'] : wpex_get_lightbox_image();
$lightbox_data = ! empty( $args['lightbox_data'] ) ? implode( ' ', $args['lightbox_data'] ) : '';

// Link
$link = isset( $args['overlay_link'] ) ? $args['overlay_link'] : wpex_get_permalink();
$link = apply_filters( 'wpex_lightbox_buttons_text_overlay_link', $link );

// Define link target
$target = '';
if ( isset( $args['link_target'] ) ) {
    if ( 'blank' == $args['link_target'] || '_blank' == $args['link_target'] ) {
        $target = 'blank';
    }
}
$target = apply_filters( 'wpex_button_overlay_target', $target );
$target = 'blank' == $target ? ' target="_blank"' : ''; ?>

<div class="overlay-view-lightbox-text overlay-hide theme-overlay">
	<div class="overlay-view-lightbox-text-inner clr">
		<div class="overlay-view-lightbox-text-buttons clr">
			<a href="<?php echo $lightbox_link; ?>" class="wpex-lightbox" title="<?php wpex_esc_title(); ?>"<?php echo $lightbox_data; ?>><?php _e( 'Zoom', 'wpex' ); ?><span class="fa fa-search"></span></a>
			<a href="<?php echo $link; ?>" class="view-post" title="<?php wpex_esc_title(); ?>"<?php echo $target; ?>><?php _e( 'View', 'wpex' ); ?><span class="fa fa-arrow-right"></span></a>
		</div><!-- .overlay-view-lightbox-text-buttons -->
	</div><!-- .overlay-view-lightbox-text-inner -->
</div><!-- .overlay-view-lightbox-text -->