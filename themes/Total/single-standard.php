<?php
/**
 * The Template for displaying standard post type content
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 */ ?>

<div id="content-wrap" class="container clr">

	<?php wpex_hook_primary_before(); ?>

	<div id="primary" class="content-area clr">

		<?php wpex_hook_content_before(); ?>

		<div id="content" class="site-content clr">

			<?php wpex_hook_content_top(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article class="single-blog-article clr"<?php wpex_schema_markup( 'blog_post' ); ?>>

					<?php get_template_part( 'partials/blog/blog-single-layout' ); ?>

				</article><!-- .entry -->

			<?php endwhile; ?>

			<?php wpex_hook_content_bottom(); ?>

		</div><!-- #content -->

		<?php wpex_hook_content_after(); ?>

	</div><!-- #primary -->

	<?php wpex_hook_primary_after(); ?>

</div><!-- .container -->