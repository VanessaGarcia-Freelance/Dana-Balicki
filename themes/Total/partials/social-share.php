<?php
/**
 * The Scroll-Top / Back-To-Top Scrolling Button
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disabled if post is password protected
if ( post_password_required() ) {
	return;
}

// Return if disabled
if ( ! wpex_global_obj( 'has_social_share' ) && 'post' !== get_post_type() ) {
	return;
}

// Get sharing sites
$sites = wpex_social_share_sites();

// Return if there aren't any sites enabled
if ( empty( $sites ) ) {
	return;
}

// Get current post id
$post_id = wpex_global_obj( 'post_id' );

// Get sharing settings
$position = wpex_social_share_position();
$style    = wpex_social_share_style();

// Get heading
$heading = wpex_social_share_heading();

// Get and encode permalink
$permalink = get_permalink( $post_id );
$url       = urlencode( $permalink );
$url       = apply_filters( 'wpex_social_share_url', $url );

// Get and encode title
$args = array(
	'before' => false,
	'after' => false,
	'echo' => false,
	'post' => $post_id,
);
$title = urlencode( esc_attr( the_title_attribute( $args ) ) );

// Get and encode summary
$args = array(
	'length' => '40',
	'echo' => false,
	'ignore_more_tag' => true,
);
$summary = urlencode( wpex_get_excerpt( $args ) );

// Get image
$img = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
$img = esc_url( $img );

// Source URL
$source = home_url(); ?>

<div class="wpex-social-share-wrap clr position-<?php echo $position; ?><?php if ( 'full-screen' == wpex_global_obj( 'post_layout' ) ) echo ' container'; ?>">

	<?php
	// Display heading if enabled
	if ( wpex_get_mod( 'social_share_heading_enable', true ) && 'horizontal' == $position ) : ?>

		<?php wpex_heading( array(
			'content'		=> $heading,
			'tag'			=> 'div',
			'classes'		=> array( 'social-share-title' ),
			'apply_filters'	=> 'social_share',
		) ); ?>

	<?php endif; ?>

	<ul class="wpex-social-share position-<?php echo $position; ?> style-<?php echo $style; ?> clr">

		<?php foreach ( $sites as $site ) : ?>

			<?php
			// Twitter
			if ( 'twitter' == $site ) {

				// Get SEO meta and use instead if they exist
				if ( defined( 'WPSEO_VERSION' ) ) {
					if ( $meta = get_post_meta( $post_id, '_yoast_wpseo_twitter-title', true ) ) {
						$title = urlencode( $meta );
					}
					if ( $meta = get_post_meta( $post_id, '_yoast_wpseo_twitter-description', true ) ) {
						$title = $title .': '. $meta;
						$title = urlencode( $title );
					}
				} ?>

				<li class="share-twitter">
					<a href="http://twitter.com/share?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>" target="_blank" title="<?php _e( 'Share on Twitter', 'wpex' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<span class="fa fa-twitter"></span>
						<span class="social-share-button-text"><?php _e('Tweet','wpex'); ?></span>
					</a>
				</li>

			<?php }
			// Facebook
			elseif ( 'facebook' == $site ) { ?>

				<li class="share-facebook">
					<a href="http://www.facebook.com/share.php?u=<?php echo $url; ?>" target="_blank" title="<?php _e( 'Share on Facebook', 'wpex' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<span class="fa fa-facebook"></span>
						<span class="social-share-button-text"><?php _e('Share','wpex'); ?></span>
					</a>
				</li>

			<?php }
			// Google+
			elseif ( 'google_plus' == $site ) { ?>

				<li class="share-googleplus">
					<a href="https://plus.google.com/share?url=<?php echo $url; ?>" title="<?php _e( 'Share on Google+', 'wpex' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<span class="fa fa-google-plus"></span>
						<span class="social-share-button-text"><?php _e('Plus one','wpex'); ?></span>
					</a>
				</li>

			<?php }
			// Pinterest
			elseif ( 'pinterest' == $site ) { ?>

				<li class="share-pinterest">
					<a href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&amp;media=<?php echo $img; ?>&amp;description=<?php echo $summary; ?>" target="_blank" title="<?php _e( 'Share on Pinterest', 'wpex' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<span class="fa fa-pinterest"></span>
						<span class="social-share-button-text"><?php _e('Pin It','wpex'); ?></span>
					</a>
				</li>

			<?php }
			// LinkedIn
			elseif ( 'linkedin' == $site ) { ?>

				<li class="share-linkedin">
					<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>&amp;summary=<?php echo $summary; ?>&amp;source=<?php echo $source; ?>" title="<?php _e( 'Share on LinkedIn', 'wpex' ); ?>" target="_blank" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<span class="fa fa-linkedin"></span>
						<span class="social-share-button-text"><?php _e('Share','wpex'); ?></span>
					</a>
				</li>

			<?php } ?>

		<?php endforeach; ?>

	</ul><!-- .wpex-social-share -->

</div>