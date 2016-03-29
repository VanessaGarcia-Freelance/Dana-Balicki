<?php
/**
 * Single Product Image
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     9.0.0 // this file should never need updating...
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

// Load lightbox
wpex_enqueue_ilightbox_skin();

// Get first image
$attachment_id  = get_post_thumbnail_id();
$attachment_url = wp_get_attachment_url( $attachment_id );

// Get gallery images
$attachments = $product->get_gallery_attachment_ids();
array_unshift( $attachments, $attachment_id );
$attachments = array_unique( $attachments );

// Conditional to show slider or not
$show_slider = true;
if ( $product->has_child() ) {
	$show_slider = false;
}
$show_slider = apply_filters( 'wpex_woo_product_slider', $show_slider ); ?>

<div class="images clr">

	<?php
	// Slider
	if ( $attachments && count( $attachments ) > 1 && $show_slider ) :

		// Slider data attributes
		$data_atributes                              = array();
		$data_atributes['animation-speed']           = 300;
		$data_atributes['auto-play']                 = 'false';
		$data_atributes['fade']                      = 'true';
		$data_atributes['buttons']                   = 'false';
		$data_atributes['loop']                      = 'false';
		$data_atributes['thumbnails-height']         = '70';
		$data_atributes['thumbnails-width']          = '70';
		$data_atributes['height-animation-duration'] = '0.0';
		$data_atributes                              = apply_filters( 'wpex_shop_single_slider_data', $data_atributes );
		$data_atributes_html                         = '';
		foreach ( $data_atributes as $key => $val ) {
			$data_atributes_html .= ' data-'. $key .'="'. $val .'"';
		} ?>

		<div class="wpex-slider-preloaderimg">
            <?php
            // Display first image as a placeholder while the others load
            wpex_post_thumbnail( array(
                'attachment' => $attachments[0],
                'alt'        => get_post_meta( $attachments[0], '_wp_attachment_image_alt', true ),
            ) ); ?>
        </div><!-- .wpex-slider-preloaderimg -->

		<div class="wpex-slider pro-slider woocommerce-single-product-slider lightbox-group"<?php echo $data_atributes_html; ?>>

			<div class="wpex-slider-slides sp-slides">

				<div class="slides">

					<?php
					// Loop through attachments and display in slider
					foreach ( $attachments as $attachment ) : ?>

						<?php
						// Get attachment alt
						$attachment_alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true ); ?>

						<?php
						// Get thumbnail
						$thumbnail = wpex_get_post_thumbnail( array(
							'attachment'    => $attachment,
							'size'          => 'shop_single',
						) ); ?>

						<?php if ( $thumbnail ) : ?>

							<div class="wpex-slider-slide sp-slide">

								<a href="<?php echo wpex_get_lightbox_image( $attachment ); ?>" title="<?php echo $attachment_alt; ?>" data-title="<?php echo $attachment_alt; ?>" data-type="image" class="wpex-lightbox-group-item">
									<?php echo $thumbnail; ?>
								</a>

							</div><!--. wpex-slider-slide -->

						<?php endif; ?>

					<?php endforeach; ?>

				</div><!-- .slides -->

				<div class="wpex-slider-thumbnails sp-thumbnails">

					<?php
					// Add slider thumbnails
					foreach ( $attachments as $attachment ) : ?>

						<?php
						// Display thumbnail
						wpex_post_thumbnail( array(
							'attachment'    => $attachment,
							'size'          => 'shop_single',
							'class'         => 'wpex-slider-thumbnail sp-thumbnail',
						) ); ?>

					<?php endforeach; ?>

				</div><!-- .wpex-slider-thumbnails -->

			</div><!-- .wpex-slider-slides -->

		</div><!-- .wpex-slider -->

	<?php elseif ( has_post_thumbnail() ) : ?>

		<?php
		$image_title    = esc_attr( get_the_title( get_post_thumbnail_id() ) );
		$image_link     = wp_get_attachment_url( get_post_thumbnail_id() );
		$image          = wpex_get_post_thumbnail( array(
			'size'  => 'shop_single',
			'title' => wpex_get_esc_title(),
		) );

		if ( $product->has_child() ) {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="woocommerce-main-image">%s</div>', $image ), $post->ID );
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image wpex-lightbox" title="%s" >%s</a>', $image_link, $image_title, $image ), $post->ID );
		}

		// Display variation thumbnails
		if ( $product->has_child() ) { ?>

			<div class="product-variation-thumbs clr lightbox-group">

				<?php foreach ( $attachments as $attachment ) : ?>
					
					<?php
					// Get attachment alt
					$attachment_alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );

					// Get thumbnail
					$args       = apply_filters( 'wpex_woo_variation_thumb_args', array(
						'attachment'    => $attachment,
						'size'          => 'shop_single',
					) );
					$thumbnail  = wpex_get_post_thumbnail( $args ); ?>

					<?php if ( $thumbnail ) : ?>

						<a href="<?php echo wpex_get_lightbox_image( $attachment ); ?>" title="<?php echo $attachment_alt; ?>" data-title="<?php echo $attachment_alt; ?>" data-type="image" class="wpex-lightbox-group-item">
							<?php echo $thumbnail; ?>
						</a>

					<?php endif; ?>

				<?php endforeach; ?>

			</div><!-- .product-variation-thumbs -->

		<?php } ?>

	<?php else : ?>

		<?php
		// Display placeholder image
		wpex_woo_placeholder_img(); ?>
		
	<?php endif; ?>

</div>