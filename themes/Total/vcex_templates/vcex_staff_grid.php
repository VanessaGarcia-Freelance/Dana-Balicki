<?php
/**
 * Visual Composer Staff Grid
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Not needed in admin ever
if ( is_admin() ) {
    return;
}

// Deprecated Attributes
if ( ! empty( $atts['term_slug'] ) ) {
	$atts['include_categories'] = $atts['term_slug'];
}

// Get and extract shortcode attributes
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

// Extract shortcode atts
extract( $atts );

// Build the WordPress query
$atts['post_type'] = 'staff';
$atts['taxonomy']  = 'staff_category';
$atts['tax_query'] = '';
$wpex_query = vcex_build_wp_query( $atts );

// Output posts
if ( $wpex_query->have_posts() ) :

	// Sanitize data & declare main variables
	$inline_js          = array();
	$grid_data          = array();
	$is_isotope         = false;
	$title              = $title ? $title : 'true';
	$excerpt            = $excerpt ? $excerpt : 'true';
	$read_more          = $read_more ? $read_more : 'true';
	$excerpt_length     = $excerpt_length ? $excerpt_length : '30';
	$entry_media        = $entry_media ? $entry_media : 'true';
	$overlay_style      = $overlay_style ? $overlay_style : 'none';
	$css_animation      = $this->getCSSAnimation( $css_animation );
	$center_filter      = ( 'yes' == $center_filter ) ? ' center' : '';
	$css_animation      = ( 'true' == $filter ) ? false : $css_animation;
	$equal_heights_grid = ( 'true' == $equal_heights_grid ) ? true : false;
	$equal_heights_grid = ( $equal_heights_grid && $columns > '1' ) ? true : false;

	// Load lightbox scripts
	if ( 'lightbox' == $thumb_link ) {
		wpex_enqueue_ilightbox_skin( $lightbox_skin );
	}

	// Enable Isotope
	if ( 'true' == $filter || 'masonry' == $grid_style || 'no_margins' == $grid_style ) {
		$is_isotope         = true;
		$equal_heights_grid = false;
	}

	// No need for masonry if not enough columns and filter is disabled
	if ( 'true' != $filter && 'masonry' == $grid_style ) {
		$post_count = count( $wpex_query->posts );
		if ( $post_count <= $columns ) {
			$is_isotope = false;
		}
	}

	// Filter categories
	if ( 'true' == $filter && taxonomy_exists( $atts['taxonomy'] ) ) {

		// Get filter terms
		$filter_terms     = get_terms( $atts['taxonomy'], vcex_grid_filter_args( $atts, $wpex_query ) );
		$filter_terms_ids = wp_list_pluck( $filter_terms, 'term_id' );

		// Check if filter active cat exists on current page
		$filter_has_active_cat = in_array( $filter_active_category, $filter_terms_ids ) ? true : false;

		// Set filter to false if there aren't any terms
		if ( ! $filter_terms ) {
			$filter = false;
		}

	}

	// Add inline js
	if ( $is_isotope ) {
		$inline_js[] = 'isotope';
	}
	if ( 'lightbox' == $thumb_link ) {
		$inline_js[] = 'ilightbox';
	}
	if ( $readmore_hover_color || $readmore_hover_background ) {
		$inline_js[] = 'data_hover';
	}
	if ( $equal_heights_grid ) {
		$inline_js[] = 'equal_heights';
	}
	if ( $inline_js ) {
		vcex_inline_js( $inline_js );
	}

	// Wrap classes
	$wrap_classes = array( 'vcex-staff-grid-wrap', 'clr' );
	if ( $visibility ) {
		$wrap_classes[] = $visibility;
	}
	if ( $classes ) {
		$wrap_classes[] = vcex_get_extra_class( $classes );
	}

	// Grid classes
	$grid_classes = array( 'wpex-row', 'vcex-staff-grid', 'entries', 'clr' );
	if ( $columns_gap ) {
		$grid_classes[] = 'gap-'. $columns_gap;
	}
	if ( $is_isotope ) {
		$grid_classes[] = 'vcex-isotope-grid';
	}
	if ( 'no_margins' == $grid_style ) {
		$grid_classes[] = 'vcex-no-margin-grid';
	}
	if ( 'left_thumbs' == $single_column_style ) {
		$grid_classes[] = 'left-thumbs';
	}
	if ( $equal_heights_grid ) {
		$grid_classes[] = 'match-height-grid';
	}
	if ( 'true' == $filter && $filter_active_category ) {
		$grid_classes[] = 'wpex-show-on-load';
	}
	if ( 'true' == $thumb_lightbox_gallery ) {
		$grid_classes[] = ' lightbox-group';
		if ( $lightbox_skin ) {
			$grid_data[] = 'data-skin="'. $lightbox_skin .'"';
		}
		$lightbox_single_class = ' wpex-lightbox-group-item';
	} else {
		$lightbox_single_class = ' wpex-lightbox';
	}

	// Grid data attributes
	if ( 'true' == $filter ) {
		if ( 'fitRows' == $masonry_layout_mode ) {
			$grid_data[] = 'data-layout-mode="fitRows"';
		}
		if ( $filter_speed ) {
			$grid_data[] = 'data-transition-duration="'. $filter_speed .'"';
		}
		if ( 'true' == $filter && $filter_has_active_cat ) {
			$grid_data[] = 'data-filter=".cat-'. $filter_active_category .'"';
		}
	} else {
		$grid_data[] = 'data-transition-duration="0.0"';
	}

	// Media classes
	$media_classes = array( 'staff-entry-media', 'entry-media' );
	if ( $img_filter ) {
		$media_classes[] = wpex_image_filter_class( $img_filter );
	}
	if ( $img_hover_style ) {
		$media_classes[] = wpex_image_hover_classes( $img_hover_style );
	}
	if ( 'none' != $overlay_style ) {
		$media_classes[] = wpex_overlay_classes( $overlay_style );
	}
	$media_classes = implode( ' ', $media_classes );

	// Content Design
	$content_style = vcex_inline_style( array(
		'background' => $content_background,
		'padding'    => $content_padding,
		'margin'     => $content_margin,
		'border'     => $content_border,
		'color'      => $content_color,
		'opacity'    => $content_opacity,
		'text_align' => $content_alignment,
	) );

	// Heading Design
	if ( 'true' == $title ) {

		$heading_style = vcex_inline_style( array(
			'margin'         => $content_heading_margin,
			'font_size'      => $content_heading_size,
			'color'          => $content_heading_color,
			'font_weight'    => $content_heading_weight,
			'text_transform' => $content_heading_transform,
			'line_height'    => $content_heading_line_height,
		) );

	}

	// Heading Link style
	$heading_link_style = vcex_inline_style( array(
		'color' => $content_heading_color,
	) );

	// Position design
	if ( 'true' == $position ) {
		$position_style = vcex_inline_style( array(
			'font_size' => $position_size,
			'margin'    => $position_margin,
			'color'     => $position_color,
		) );
	}

	// Categories design
	if ( 'true' == $show_categories ) {
		$categories_style = vcex_inline_style( array(
			'margin'    => $categories_margin,
			'font_size' => $categories_font_size,
			'color'     => $categories_color,
		) );
		$categories_classes = 'staff-entry-categories wpex-clr';
		if ( $categories_color ) {
			$categories_classes .= ' wpex-child-inherit-color';
		}
	}

	// Excerpt style
	if ( 'true' == $excerpt ) {
		$excerpt_style = vcex_inline_style( array(
			'font_size' => $content_font_size,
		) );
	}

	// Social links style
	if ( 'true' == $social_links ) {
		$social_links_inline_css = vcex_inline_style( array(
			'margin' => $social_links_margin,
		) );
	}

	// Readmore design
	if ( 'true' == $read_more ) {

		// Readmore classes
		$readmore_classes   = array( 'theme-button', 'animate-on-hover' );
		if ( $readmore_hover_color || $readmore_hover_background ) {
			$readmore_classes[] = 'wpex-data-hover';
		}
		$readmore_classes[] = $readmore_style;
		$readmore_classes[] = $readmore_style_color;
		$readmore_classes   = implode( ' ', $readmore_classes );

		// Readmore style
		$readmore_style = vcex_inline_style( array(
			'background'    => $readmore_background,
			'color'         => $readmore_color,
			'font_size'     => $readmore_size,
			'padding'       => $readmore_padding,
			'border_radius' => $readmore_border_radius,
			'margin'        => $readmore_margin,
		) );

		// Readmore data
		$readmore_data = array();
		if ( $readmore_hover_color ) {
			$readmore_data[] = 'data-hover-color="'. $readmore_hover_color .'"';
		}
		if ( $readmore_hover_background ) {
			$readmore_data[] = 'data-hover-background="'. $readmore_hover_background .'"';
		}
		$readmore_data = ' '. implode( ' ', $readmore_data );
	}

	// Convert arrays into strings
	$wrap_classes  = implode( ' ', $wrap_classes );
	$grid_classes  = implode( ' ', $grid_classes );
	$grid_data     = implode( ' ', $grid_data ); ?>

	<div class="<?php echo $wrap_classes; ?>">
	
		<?php
		// Display filter links
		if ( 'true' == $filter ) {

			// Sanitize all text
			$all_text = $all_text ? $all_text : _x( 'All', 'Grid Filter All Button', 'wpex' );

			// Filter button classes
			$filter_button_classes = 'theme-button';
			$filter_button_classes .= ' '. $filter_button_style;
			if ( $filter_button_color ) {
				$filter_button_classes .= ' '. $filter_button_color;
			}

			// Filter font size
			$filter_style = vcex_inline_style( array(
				'font_size' => $filter_font_size,
			) ); ?>

			<ul class="vcex-staff-filter vcex-filter-links clr<?php echo $center_filter; ?>"<?php echo $filter_style; ?>>
				
				<?php if ( 'true' == $filter_all_link ) { ?>

					<li <?php if ( ! $filter_has_active_cat ) echo 'class="active"'; ?>><a href="#" data-filter="*" class="<?php echo $filter_button_classes; ?>"><span><?php echo $all_text; ?></span></a></li>

				<?php } ?>

				<?php foreach ( $filter_terms as $term ) : ?>

					<li class="filter-cat-<?php echo $term->term_id; ?><?php if ( $filter_active_category == $term->term_id ) echo ' active'; ?>"><a href="#" data-filter=".cat-<?php echo $term->term_id; ?>" class="<?php echo $filter_button_classes; ?>"><?php echo $term->name; ?></a></li>

				<?php endforeach; ?>

			</ul><!-- .vcex-staff-filter -->

		<?php } ?>

		<div class="<?php echo $grid_classes; ?>"<?php vcex_unique_id( $unique_id ); ?><?php echo $grid_data; ?>>
			<?php
			// Define counter var to clear floats
			$count = 0;

			// Start loop
			while ( $wpex_query->have_posts() ) :

				// Get post from query
				$wpex_query->the_post();

				// Create new post object
				$post = new stdClass();

				// Post Data
				$post->ID        = get_the_ID();
				$post->permalink = wpex_get_permalink( $post->ID );
				$post->excerpt   = '';

				// Post Excerpt
				if ( 'true' == $excerpt || 'true' == $thumb_lightbox_caption ) {
					$post->excerpt = wpex_get_excerpt( $excerpt_length );
				}

				// Add to the counter var
				$count++;

				// Add classes to the entries
				$entry_classes = array( 'staff-entry' );
				$entry_classes[] = 'span_1_of_'. $columns;
				if ( 'false' == $columns_responsive ) {
					$entry_classes[] = 'nr-col';
				} else {
					$entry_classes[] = 'col';
				}
				if ( $count ) {
					$entry_classes[] = 'col-'. $count;
				}
				if ( 'true' == $read_more ) {
					$entry_classes[] = 'has-readmore';
				}
				if ( $css_animation ) {
					$entry_classes[] = $css_animation;
				}
				if ( $is_isotope ) {
					$entry_classes[] = 'vcex-isotope-entry';
				}
				if ( 'no_margins' == $grid_style ) {
					$entry_classes[] = 'vcex-no-margin-entry';
				}
				if ( taxonomy_exists( 'staff_category' ) ) {
					$post_terms = get_the_terms( $post->ID, 'staff_category' );
					if ( $post_terms ) {
						foreach ( $post_terms as $post_term ) {
							$entry_classes[] = 'cat-'. $post_term->term_id;
						}
					}
				} ?>

				<div <?php post_class( $entry_classes ); ?>>

					<?php
					//Featured Image
					if ( 'true' == $entry_media && has_post_thumbnail() ) : ?>

						<div class="<?php echo $media_classes; ?>">
							<?php if ( ! in_array( $thumb_link, array( 'none', 'nowhere' ) ) ) : ?>
								
								<?php
								// Lightbox link
								if ( $thumb_link == 'lightbox' ) : ?>

									<?php
									// Lightbox data
									if ( 'lightbox' == $thumb_link ) {

										// Lightbox link
										$atts['lightbox_link'] = wpex_get_lightbox_image();

										// Lightbox data
										$atts['lightbox_data'] = array();
										if ( $lightbox_skin ) {
											$atts['lightbox_data'][] = 'data-skin="'. $lightbox_skin .'"';
										}
										if ( 'true' == $thumb_lightbox_title ) {
											$atts['lightbox_data'][] = 'data-title="'. wpex_get_esc_title() .'"';
										}
										if ( 'true' == $thumb_lightbox_caption && $post->excerpt ) {
											$atts['lightbox_data'][] = 'data-caption="'. str_replace( '"',"'", $post->excerpt ) .'"';
										}
										$lightbox_data = ' '. implode( ' ', $atts['lightbox_data'] );
									} ?>

									<a href="<?php echo $atts['lightbox_link']; ?>" title="<?php wpex_esc_title(); ?>" class="staff-entry-media-link<?php echo $lightbox_single_class; ?>"<?php echo $lightbox_data; ?>>

								<?php else : ?>

									<a href="<?php echo $post->permalink; ?>" title="<?php wpex_esc_title(); ?>" class="staff-entry-media-link"<?php echo vcex_html( 'target_attr', $link_target ); ?>>

								<?php endif; ?>
							
							<?php endif; ?>

								<?php
								// Output post thumbnail
								wpex_post_thumbnail( array(
									'size'   => $img_size,
									'crop'   => $img_crop,
									'width'  => $img_width,
									'height' => $img_height,
									'alt'    => wpex_get_esc_title(),
								) ); ?>

							<?php
							// Close link and output inside overlay HTML
							if ( ! in_array( $thumb_link, array( 'none', 'nowhere' ) ) ) : ?>

								<?php
								// Inner Overlay
								wpex_overlay( 'inside_link', $overlay_style, $atts ); ?>

								</a>

							<?php endif; ?>

							<?php
							// Outside Overlay
							wpex_overlay( 'outside_link', $overlay_style, $atts ); ?>

						</div><!-- .staff-media -->

					<?php endif; ?>

					<?php
					// Display details
					if ( 'true' == $title
						|| 'true' == $excerpt
						|| 'true' == $read_more
						|| 'true' == $position
						|| 'true' == $show_categories
						|| 'true' == $social_links
					) : ?>

						<div class="staff-entry-details entry-details clr" <?php echo $content_style; ?>>

							<?php
							// Equal height div
							if ( $equal_heights_grid && ! $is_isotope ) echo '<div class="match-height-content">'; ?>

							<?php
							// Display the title
							if ( 'true' == $title ) : ?>

								<h2 class="staff-entry-title entry-title"<?php echo $heading_style; ?>>

									<?php
									// Display title and link to post
									if ( 'post' == $title_link ) : ?>

										<a href="<?php echo $post->permalink; ?>" title="<?php wpex_esc_title(); ?>"<?php echo $heading_link_style; ?><?php echo vcex_html( 'target_attr', $link_target ); ?>><?php the_title(); ?></a>

									<?php
									// Display title and link to lightbox
									elseif ( 'lightbox' == $title_link ) : ?>

										<?php
										// Load lightbox script
										vcex_enque_style( 'ilightbox', $lightbox_skin ); ?>

										<a href="<?php wpex_lightbox_image(); ?>" title="<?php wpex_esc_title(); ?>"<?php echo $heading_link_style; ?> class="wpex-lightbox"><?php the_title(); ?></a>

									<?php
									// Display title without link
									else : ?>

										<?php the_title(); ?>

									<?php endif; ?>

								</h2><!-- .staff-entry-title -->

							<?php endif; ?>

							<?php
							// Display staff member position
							if ( 'true' == $position && $get_position = get_post_meta( $post->ID, 'wpex_staff_position', true ) ) : ?>

								<div class="staff-entry-position" <?php echo $position_style; ?>>
									<?php echo $get_position; ?>
								</div><!-- .staff-entry-position -->

							<?php endif; ?>

							<?php
							// Display categories
							if ( 'true' == $show_categories ) : ?>

								<div class="<?php echo $categories_classes; ?>"<?php echo $categories_style; ?>>
									<?php if ( $show_first_category_only ) { ?>
										<?php wpex_first_term_link( $post->ID, 'staff_category' ); ?>
									<?php } else { ?>
										<?php wpex_list_post_terms( 'staff_category', true, true ); ?>
									<?php } ?>
								</div><!-- .staff-entry-categories -->

							<?php endif; ?>

							<?php
							// Display excerpt and readmore
							if ( $post->excerpt ) : ?>

								<div class="staff-entry-excerpt clr"<?php echo $excerpt_style; ?>>
									<?php echo $post->excerpt; ?>
								</div><!-- .staff-entry-excerpt -->

							<?php endif; ?>

							<?php
							// Display social links
							if ( 'true' == $social_links ) : ?>

								<div class="sfaff-entry-social-links clr"<?php echo $social_links_inline_css; ?>>
									<?php echo wpex_get_staff_social( array(
										'style'     => $social_links_style,
										'font_size' => $social_links_size,
									) ); ?>
									</div><!-- .staff-entry-social-links -->

							<?php endif; ?>

							<?php
							// Display Readmore
							if ( 'true' == $read_more && $read_more_text ) : ?>

								<div class="staff-entry-readmore-wrap clr">

									<a href="<?php echo $post->permalink; ?>" title="<?php echo esc_attr( $read_more_text ); ?>" rel="bookmark" class="<?php echo $readmore_classes; ?>"<?php echo $readmore_style; ?><?php echo $readmore_data; ?><?php echo vcex_html( 'target_attr', $link_target ); ?>>
										<?php echo $read_more_text; ?>
										<?php if ( 'true' == $readmore_rarr ) { ?>
											<span class="vcex-readmore-rarr"><?php echo wpex_element( 'rarr' ); ?></span>
										<?php } ?>
									</a>

								</div><!-- .staff-entry-readmore-wrap -->

							<?php endif; ?>

							<?php
							// Close Equal height div
							if ( $equal_heights_grid && ! $is_isotope ) echo '</div>'; ?>

						</div><!-- .staff-entry-details -->

					<?php endif; // End staff entry details check ?>

				</div><!-- .staff-entry -->

				<?php
				// Reset counter
				if ( $count == $columns )  $count = ''; ?>

			<?php endwhile; ?>

		</div><!-- .vcex-staff-grid -->
					
		<?php
		// Display pagination if enabled
		if ( 'true' == $pagination ) : ?>

			<?php
			// Output pagination
			wpex_pagination( $wpex_query ); ?>

		<?php endif; ?>

	</div><!-- <?php echo $wrap_classes; ?> -->

	<?php
	// Remove post object from memory
	$post = null;

	// Reset the post data to prevent conflicts with WP globals
	wp_reset_postdata(); ?>

<?php
// If no posts are found display message
else : ?>

	<?php
	// Display no posts found error if function exists
	echo vcex_no_posts_found_message( $atts ); ?>

<?php
// End post check
endif; ?>