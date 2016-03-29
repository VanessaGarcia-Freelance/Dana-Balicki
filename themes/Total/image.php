<?php
/**
 * The template for displaying image attachments.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

get_header(); ?>

	<div class="container clr">

		<?php wpex_hook_primary_before(); ?>

		<div id="primary" class="content-area">

			<?php wpex_hook_content_before(); ?>

			<div id="content" class="site-content">

				<?php wpex_hook_content_top(); ?>

				<article <?php post_class( 'image-attachment' ); ?>>

					<?php echo wp_get_attachment_image( get_the_ID(), 'full' ); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<div class="entry clr">

							<?php the_content(); ?>

						</div><!-- .entry -->

					<?php endwhile ?>

				</article><!-- #post -->

				<?php wpex_hook_content_bottom(); ?>

			</div><!-- #content -->

			<?php wpex_hook_content_after(); ?>

		</div><!-- #primary -->

		<?php wpex_hook_primary_after(); ?>

	</div><!-- .container -->

<?php get_footer(); ?>