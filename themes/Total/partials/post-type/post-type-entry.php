<?php
/**
 * Custom Post Type Entry
 * Provides the output for custom post types not built-into or supported by the theme
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Should we check for the more tag?
$check_more_tag = apply_filters( 'wpex_check_more_tag', true ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'custom-posttype-entry' ) ); ?>>

	<?php
	// Check if post has a thumbnail
	if ( has_post_thumbnail() ) : ?>

		<div class="custom-posttype-entry-media">

			<a href="<?php wpex_permalink(); ?>" title="<?php wpex_esc_title(); ?>" rel="bookmark" class="custom-posttype-entry-media-link <?php wpex_entry_image_animation_classes(); ?>">
				<?php
				// Output post thumbnail
				wpex_post_thumbnail( array(
					'size' => 'full',
					'alt'  => wpex_get_esc_title(),
				) ); ?>
			</a>
			
		</div><!-- .custom-posttype-entry-media -->

	<?php endif; ?>

	<div class="custom-posttype-entry-content clr">

		<header class="custom-posttype-entry-header clr">

			<h2 class="custom-posttype-entry-title entry-title">
				<a href="<?php wpex_permalink(); ?>" title="<?php wpex_esc_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2><!-- .custom-posttype-entry-title -->

			<?php
			// Get post meta, you can create a new file called meta-posttype.php for your custom post type
			get_template_part( 'partials/meta/meta', get_post_type() ); ?>

		</header><!-- .custom-posttype-entry-header -->

		<div class="custom-posttype-entry-excerpt entry">

			<?php
			// Check if post has a "more" tag
			if ( $check_more_tag && strpos( get_the_content(), 'more-link' ) ) : ?>

				<?php
				// Display entry content up to the more tag
				the_content( '', '&hellip;' ); ?>

			<?php
			// Generate custom excerpt
			else : ?>

				<?php
				// Output excerpt with length of 40
				wpex_excerpt( array(
					'length' => '40',
				) ); ?>

			<?php endif; ?>

		</div><!-- .custom-posttype-entry-excerpt -->

		<div class="custom-posttype-entry-readmore clr">

			<a href="<?php wpex_permalink(); ?>" class="theme-button" title="<?php wpex_esc_title(); ?>">
				<?php _e( 'Read more', 'wpex' ); ?><span class="wpex-hidden readmore-rarr">&rarr;</span>
			</a><!-- .theme-button -->

		</div><!-- .custom-posttype-entry-readmore -->

		<?php
		// Get social sharing template part
		//get_template_part( 'partials/social', 'share' ); ?>

	</div><!-- .custom-posttype-entry-content -->

</article><!-- .custom-posttype-entry-entry -->