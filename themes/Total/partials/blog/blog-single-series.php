<?php
/**
 * Single related posts
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if taxonomy doesn't exist
if ( ! taxonomy_exists( 'post_series' ) ) {
	return;
}

// Get post ID
$post_id = get_the_ID();

// Return if pass protected
if ( post_password_required( $post_id ) ) {
	return;
}

// Get post terms
$terms = wp_get_post_terms( $post_id, 'post_series' );

// Return if not term found
if ( ! isset( $terms[0] ) ) {
	return;
}

// Get all posts in series
$wpex_query = new wp_query( array(
	'post_type'        => 'post',
	'posts_per_page'   => -1,
	'orderby'          => 'Date',
	'order'            => 'ASC',
	'no_found_rows'    => true,
	'tax_query'        => array( array(
			'taxonomy' => 'post_series',
			'field'    => 'id',
			'terms'    => $terms[0]->term_id
	) ),
) );

$wpex_query = apply_filters( 'wpex_post_series_query_args', $wpex_query );

// Display series if posts are found
if ( $wpex_query->have_posts() ) : ?>

	<section id="post-series" class="clr">

		<div id="post-series-title" class="clr">
			<?php echo wpex_get_mod( 'post_series_heading', __( 'Post Series:', 'wpex' ) ); ?> <a href="<?php echo get_term_link( $terms[0], 'post_series' ); ?>" title="<?php echo $terms[0]->name; ?>"><?php echo $terms[0]->name; ?></a>
		</div><!-- #post-series-title -->

		<ul id="post-series-list" class="clr">

			<?php
			// Define counter var
			$count=0; ?>
			
			<?php
			// Loop through posts
			foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
				
				<?php
				// Add to counter
				$count++; ?>

				<?php
				// Display current post
				$current_post_id = $post->ID;

				if ( $current_post_id == $post_id ) : ?>

					<li class="post-series-current">
						<span class="post-series-count"><?php echo $count; ?>.</span><?php the_title(); ?>
					</li>

				<?php
				// Display other posts
				else : ?>

					<li>
						<span class="post-series-count"><?php echo $count; ?>.</span><a href="<?php wpex_permalink(); ?>" title="<?php wpex_esc_title(); ?>"><?php the_title(); ?></a>
					</li>

				<?php endif; ?>

			<?php endforeach; ?>

		</ul><!-- #post-series-list -->

	</section><!-- #post-series -->

<?php endif; ?>

<?php
// Reset post data to prevent conflicts with other queries
wp_reset_postdata(); ?>