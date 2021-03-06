<?php
/**
 * Used to display the portfolio slider
 *
 * @package Total WordPress Theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Get attachments
$attachments = wpex_get_gallery_ids( get_the_ID() );

// Check if lightbox is enabled
$lightbox_enabled = wpex_gallery_is_lightbox_enabled() ? true : false;

// Load lightbox skin stylesheet
if ( $lightbox_enabled ) {
	wpex_enqueue_ilightbox_skin();
}

/**
 * Slider args
 *
 * You can easily tweak your slider via a child theme using the wpex_portfolio_single_gallery filter
 * defined below in the args attribute. Please referance the theme docs for more info
 */
$args = array(
	'filter_tag' => 'wpex_portfolio_single_gallery',
); ?>

<div class="portfolio-post-slider clr">

	<div class="wpex-slider-preloaderimg">
		<?php
		// Display first image as a placeholder while the others load
		wpex_get_portfolio_post_thumbnail( array(
			'attachment'    => $attachments[0],
			'alt'           => get_post_meta( $attachments[0], '_wp_attachment_image_alt', true ),
			'schema_markup' => true,
		) ); ?>
	</div><!-- .wpex-slider-preloaderimg -->

	<div class="wpex-slider slider-pro" <?php wpex_slider_data( $args ); ?>>

		<div class="wpex-slider-slides sp-slides <?php if ( $lightbox_enabled ) echo 'lightbox-group'; ?>">

			<?php
			// Loop through attachments
			foreach ( $attachments as $attachment ) : ?>

				<?php
				// Get attachment data
				$lightbox_url       = $lightbox_enabled ? wpex_get_lightbox_image( $attachment ) : '';
				$attachment_data    = wpex_get_attachment_data( $attachment );
				$attachment_alt     = $attachment_data['alt'];
				$attachment_video   = $attachment_data['video'];
				$attachment_caption = $attachment_data['caption'];

				// Get image output
				$attachment_html = wpex_get_portfolio_post_thumbnail( array(
					'attachment'    => $attachment,
					'alt'           => $attachment_alt,
					'schema_markup' => false,
				) ); ?>

				<div class="wpex-slider-slide sp-slide">

					<?php
					// Display attachment video
					if ( $attachment_video && ! is_wp_error( $attachment_video = wp_oembed_get( $attachment_video ) ) ) : ?>

						<div class="wpex-slider-video responsive-video-wrap">
							<?php echo $attachment_video; ?>
						</div><!-- .wpex-slider-video -->

					<?php
					// Display attachment image
					else : ?>

						<div class="wpex-slider-media clr">

							<?php
							// Display with lightbox
							if ( $lightbox_enabled ) : ?>

								<a href="<?php echo $lightbox_url; ?>" title="<?php echo $attachment_alt; ?>" data-title="<?php echo $attachment_alt; ?>" data-type="image" class="wpex-lightbox-group-item"><?php echo $attachment_html; ?></a>

							<?php
							// Display single image
							else : ?>

								<?php echo $attachment_html; ?>

								<?php if ( $attachment_caption ) : ?>
									<div class="wpex-slider-caption sp-layer sp-black sp-padding clr" data-position="bottomCenter" data-show-transition="up" data-hide-transition="down" data-width="100%" data-show-delay="500">
										<?php echo $attachment_caption; ?>
									</div><!-- .wpex-slider-caption -->
								<?php endif; ?>

							<?php endif; ?>

						</div><!-- .wpex-slider-media -->

					<?php endif; ?>

				</div><!-- .wpex-slider-slide sp-slide -->

			<?php endforeach; ?>

		</div><!-- .wpex-slider-slides .sp-slides -->

		<div class="wpex-slider-thumbnails sp-thumbnails">

			<?php
			// Loop through attachments
			foreach ( $attachments as $attachment ) : ?>

				<?php
				// Display image thumbnail
				wpex_get_portfolio_post_thumbnail( array(
					'attachment'    => $attachment,
					'class'         => 'wpex-slider-thumbnail sp-thumbnail',
					'alt'           => get_post_meta( $attachments, '_wp_attachment_image_alt', true ),
					'schema_markup' => false,
				) ); ?>

			<?php endforeach; ?>

		</div><!-- .wpex-slider-thumbnails -->

	</div><!-- .wpex-slider .slider-pro -->

</div><!-- .gallery-format-post-slider -->