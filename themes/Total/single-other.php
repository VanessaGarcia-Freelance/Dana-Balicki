<?php
/**
 * The Template for displaying all non-theme post type content
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */
?>

<div id="content-wrap" class="container clr">

	<?php wpex_hook_primary_before(); ?>

	<div id="primary" class="content-area clr">

		<?php wpex_hook_content_before(); ?>

		<div id="content" class="site-content clr">

			<?php wpex_hook_content_top(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				// Display featured image
				if ( has_post_thumbnail() ) : ?>

					<div id="post-media" class="clr">

						<?php
						// Dislpay full featured image
						wpex_post_thumbnail( array(
							'size'          => 'full',
							'alt'           => wpex_get_esc_title(),
							'schema_markup' => true
						) ); ?>
						
					</div><!-- #post-media -->

				<?php endif; ?>
				
				<h1 class="single-post-title entry-title"<?php wpex_schema_markup( 'heading' ); ?>><?php the_title(); ?></h1><!-- .single-post-title -->

				<?php
				// Post meta
				get_template_part( 'partials/meta/meta', get_post_type() ); ?>

				<article class="entry clr"<?php wpex_schema_markup( 'entry_content' ); ?>>
					<?php the_content(); ?>
				</article><!-- .entry -->

				<?php
				// Link pages when using <!--nextpage-->
				wp_link_pages( array(
					'before'      => '<div class="page-links clr">',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );

				// Social share, enabled by default
				get_template_part( 'partials/social-share' );
				
				// Get the post comments & comment_form
				comments_template(); ?>

				<?php wpex_hook_content_bottom(); ?>

			<?php endwhile; ?>

		</div><!-- #content -->

		<?php wpex_hook_content_after(); ?>

	</div><!-- #primary -->

	<?php wpex_hook_primary_after(); ?>

</div><!-- .container -->