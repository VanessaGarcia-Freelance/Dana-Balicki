<?php
/**
 * The template used for single staff posts.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */

get_header(); ?>

	<?php
	// If staff is disabled use single-other.php template instead
	if ( ! WPEX_STAFF_IS_ACTIVE ) {
		get_template_part( 'single-other' );
		return;
	} ?>

	<div id="content-wrap" class="container clr">

		<?php wpex_hook_primary_before(); ?>

		<div id="primary" class="content-area clr">

			<?php wpex_hook_content_before(); ?>

			<div id="content" class="site-content clr">

				<?php wpex_hook_content_top(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'partials/staff/staff-single-layout' ); ?>

					<?php endwhile; ?>

				<?php wpex_hook_content_bottom(); ?>

			</div><!-- #content -->

			<?php wpex_hook_content_after(); ?>

		</div><!-- #primary -->

		<?php wpex_hook_primary_after(); ?>

	</div><!-- .container -->

<?php get_footer();?>