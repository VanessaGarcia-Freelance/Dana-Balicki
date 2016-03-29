<?php
/**
 * Visual Composer Portfolio Grid
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
extract( $atts );

// Define non-vc attributes
$atts['post_type'] = 'portfolio';
$atts['taxonomy']  = 'portfolio_category';
$atts['tax_query'] = '';

// Build the WordPress query
$wpex_query = vcex_build_wp_query( $atts );

// Output posts
if ( $wpex_query->have_posts() ) :

	// Sanitize data & declare main variables
	$inline_js          = array();
	$grid_data          = array();
	$wrap_classes       = array( 'vcex-portfolio-grid-wrap', 'wpex-clr' );
	$grid_classes       = array( 'wpex-row', 'vcex-portfolio-grid', 'wpex-clr', 'entries' );
	$is_isotope         = false;
	$title              = $title ? $title : 'true';
	$excerpt            = $excerpt ? $excerpt : 'true';
	$read_more          = $read_more ? $read_more : 'true';
	$excerpt_length     = $excerpt_length ? $excerpt_length : '30';
	$entry_media        = $entry_media ? $entry_media : 'true';
	$featured_video     = $featured_video ? $featured_video : 'true';
	$css_animation      = $css_animation ? $this->getCSSAnimation( $css_animation ) : '';
	$css_animation      = ( 'true' == $filter ) ? false : $css_animation;
	$overlay_style      = $overlay_style ? $overlay_style : 'none';
	$equal_heights_grid = ( 'true' == $equal_heights_grid && $columns > '1' ) ? true : false;
	$title_tag          = $title_tag ? $title_tag : 'h2';
	$gallery_slider     = false;

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
	if ( 'lightbox' == $thumb_link ) {
		$inline_js[] = 'ilightbox';
	}
	if ( 'true' == $gallery_slider ) {
		$inline_js[] = 'slider_pro';
	}
	if ( $inline_js ) {
		vcex_inline_js( $inline_js );
	}

	// Wrap classes
	if ( $visibility ) {
		$wrap_classes[] = $visibility;
	}
	if ( $classes ) {
		$wrap_classes[] = vcex_get_extra_class( $classes );
	}

	// Main grid classes
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
	if ( 'true' == $filter && $filter_active_category ) {
		$grid_classes[] = 'wpex-show-on-load';
	}
	if ( $equal_heights_grid ) {
		$grid_classes[] = 'match-height-grid';
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
		if ( $filter_has_active_cat ) {
			$grid_data[] = 'data-filter=".cat-'. $filter_active_category .'"';
		}
	} else {
		$grid_data[] = 'data-transition-duration="0.0"';
	}

	// Media classes
	if ( 'true' == $entry_media ) {
		$media_classes = array( 'portfolio-entry-media', 'entry-media' );
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
	}

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

	// Heading style
	if ( 'true' == $title ) {

		// Heading Design
		$heading_style = vcex_inline_style( array(
			'margin'         => $content_heading_margin,
			'font_size'      => $content_heading_size,
			'color'          => $content_heading_color,
			'font_weight'    => $content_heading_weight,
			'text_transform' => $content_heading_transform,
			'line_height'    => $content_heading_line_height,
		) );

		// Heading Link style
		$heading_link_style = vcex_inline_style( array(
			'color' => $content_heading_color,
		) );

	}

	// Categories style
	if ( 'true' == $show_categories ) {
		$categories_style = vcex_inline_style( array(
			'margin'    => $categories_margin,
			'font_size' => $categories_font_size,
			'color'     => $categories_color,
		) );
		$categories_classes = 'portfolio-entry-categories wpex-clr';
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

	// Readmore design
	if ( 'true' == $read_more ) {

		// Read more text
		$read_more_text = $read_more_text ? $read_more_text : __( 'read more', 'wpex' );

		// Readmore classes
		$readmore_classes = array( 'theme-button', 'animate-on-hover' );
		if ( $readmore_hover_color || $readmore_hover_background ) {
			$readmore_classes[] = 'wpex-data-hover';
		}
		$readmore_classes[] = $readmore_style;
		$readmore_classes[] = $readmore_style_color;
		$readmore_classes = implode( ' ', $readmore_classes );

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
		$readmore_data = implode( ' ', $readmore_data );

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

			// Center filter links
			$center_filter = 'yes' == $center_filter ? ' center' : '';

			// Filter font size
			$filter_style = vcex_inline_style( array(
				'font_size' => $filter_font_size,
			) ); ?>

			<ul class="vcex-portfolio-filter vcex-filter-links wpex-clr<?php echo $center_filter; ?>"<?php echo $filter_style; ?>>

				<?php if ( 'true' == $filter_all_link ) { ?>

					<li <?php if ( ! $filter_has_active_cat ) echo 'class="active"'; ?>><a href="#" data-filter="*" class="<?php echo $filter_button_classes; ?>"><span><?php echo $all_text; ?></span></a></li>

				<?php } ?>

				<?php
				// Loop through terms to display filter links
				foreach ( $filter_terms as $term ) : ?>

					<li class="filter-cat-<?php echo $term->term_id; ?><?php if ( $filter_active_category == $term->term_id ) echo ' active'; ?>"><a href="#" data-filter=".cat-<?php echo $term->term_id; ?>" class="<?php echo $filter_button_classes; ?>"><?php echo $term->name; ?></a></li>

				<?php endforeach; ?>

			</ul><!-- .vcex-portfolio-filter -->

		<?php } ?>

		<div class="<?php echo esc_attr( $grid_classes ); ?>"<?php echo vcex_unique_id( $unique_id ); ?> <?php echo $grid_data; ?>>
			<?php
			// Define counter var to clear floats
			$count = 0;

			// Start loop
			while ( $wpex_query->have_posts() ) :

				// Get post from query
				$wpex_query->the_post();

				// Create new post object
				$post = new stdClass();

				// Get post data
				$get_post = get_post();

				// Post Data
				$post->ID           = $get_post->ID;
				$post->permalink    = wpex_get_permalink( $post->ID );
				$post->title        = $get_post->post_title;
				$post->video        = wpex_get_post_video( $post->ID );
				$post->video_output = wpex_get_post_video_html( $post->video );
				$post->excerpt      = '';

				// Post Excerpt
				if ( 'true' == $excerpt || 'true' == $thumb_lightbox_caption ) {
					$post->excerpt = wpex_get_excerpt( array (
						'length' => intval( $excerpt_length ),
					) );
				}

				// Add to the counter var
				$count++;

				// Add classes to the entries
				$entry_classes = array( 'portfolio-entry' );
				$entry_classes[] = 'span_1_of_'. $columns;
				if ( 'false' == $columns_responsive ) {
					$entry_classes[] = 'nr-col';
				} else {
					$entry_classes[] = 'col';
				}
				if ( $count ) {
					$entry_classes[] = 'col-'. $count;
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
				if ( taxonomy_exists( 'portfolio_category' ) ) {
					$post_terms = get_the_terms( $post->ID, 'portfolio_category' );
					if ( $post_terms ) {
						foreach ( $post_terms as $post_term ) {
							$entry_classes[] = 'cat-'. $post_term->term_id;
						}
					}
				} ?>

				<div <?php post_class( $entry_classes ); ?>>

					<div class="portfolio-entry-inner clr">

						<?php
						// Entry Media
						if ( 'true' == $entry_media ) : ?>
							
							<?php
							/* Video
							-------------------------------------------------------------------------------*/
							if ( 'true' == $featured_video && $post->video_output ) : ?>

								<div class="portfolio-entry-media portfolio-featured-video entry-media wpex-clr">
									<?php echo $post->video_output; ?>
								</div><!-- .portfolio-featured-video -->

							<?php
							/* Gallery: Still not sure if I am going to add this or not...too much bloat :(
							-------------------------------------------------------------------------------*/
							elseif ( 'true' == $gallery_slider && $gallery_attachments = wpex_get_gallery_ids( $post->ID ) ) :

								// Get only first x number of items
								$gallery_attachments = array_slice( $gallery_attachments, 0, 3 );

								// Slider args adds a filter so you can easily tweak the slider animation, etc for this slider
								$args = array(
									'filter_tag'                => 'vcex_portfolio_grid_slider_'. $unique_id,
									'fade'                      => 'true',
									'height-animation-duration' => '0.0'
								); ?>

								<div class="vcex-grid-entry-slider wpex-slider slider-pro clr"<?php wpex_slider_data( $args ); ?>>

									<div class="wpex-slider-slides sp-slides <?php if ( 'lightbox' == $thumb_link ) echo 'lightbox-group'; ?>">

										<?php
										// Loop through gallery images
										foreach ( $gallery_attachments as $attachment ) :

											// Get attachment data
											$attachment_data = wpex_get_attachment_data( $attachment ); ?>

											<div class="wpex-slider-slide sp-slide">

												<div class="<?php echo $media_classes; ?><?php if ( 'true' == $thumb_lightbox_gallery ) echo ' wpex-lightbox-group'; ?>">

													<?php
													// Open link tag if thumblink does not equal nowhere
													if ( 'nowhere' != $thumb_link ) : ?>

														<?php
														// Lightbox
														if ( 'lightbox' == $thumb_link ) : ?>

															<?php
															// Get lightbox link
															$atts['lightbox_link'] = wpex_get_lightbox_image( $attachment );

															// Add lightbox attributes
															$atts['lightbox_data'] = array();
															if ( $lightbox_skin ) {
																$atts['lightbox_data'][] = 'data-skin="'. $lightbox_skin .'"';
															}
															if ( 'true' == $thumb_lightbox_title ) {
																$atts['lightbox_data'][] = 'data-title="'. $attachment_data['alt'] .'"';
															}
															$lightbox_data = ' '. implode( ' ', $atts['lightbox_data'] ); ?>
															<a href="<?php echo $atts['lightbox_link']; ?>" title="<?php wpex_esc_title(); ?>" class="portfolio-entry-media-link wpex-lightbox"<?php echo $lightbox_data; ?>>

														<?php 
														// Standard post link
														else : ?>

															<a href="<?php echo $post->permalink; ?>" title="<?php wpex_esc_title(); ?>" class="portfolio-entry-media-link"<?php echo vcex_html( 'target_attr', $link_target ); ?>>

														<?php endif; ?>

													<?php endif; ?>

													<?php
													// Display post thumbnail
													wpex_post_thumbnail( array(
														'attachment' => $attachment,
														'width'      => $img_width,
														'height'     => $img_height,
														'crop'       => $img_crop,
														'alt'        => wpex_get_esc_title(),
														'class'      => 'portfolio-entry-img',
														'size'       => $img_size,
													) ); ?>

													<?php
													// Inner link overlay HTML
													wpex_overlay( 'inside_link', $overlay_style, $atts ); ?>

													<?php
													// Close link tag
													if ( 'nowhere' != $thumb_link ) echo '</a>'; ?>

													<?php
													// Outer link overlay HTML
													wpex_overlay( 'outside_link', $overlay_style, $atts ); ?>

												</div><!-- .<?php echo $media_classes; ?> -->

											</div><!-- .wpex-slider-slide -->

										<?php endforeach; ?>

									</div><!-- .wpex-slider-slides -->

								</div><!-- .wpex-slider-slier -->

							<?php 
							/* Featured Image
							-------------------------------------------------------------------------------*/
							elseif ( has_post_thumbnail( $post->ID ) ) : ?>

								<div class="<?php echo $media_classes; ?>">

									<?php
									// Open link tag if thumblink does not equal nowhere
									if ( 'nowhere' != $thumb_link ) : ?>

										<?php
										// Lightbox
										if ( 'lightbox' == $thumb_link ) :

											// Save correct lightbox class
											$lightbox_class = $lightbox_single_class;

											// Generate lightbox image
											$lightbox_image = wpex_get_lightbox_image();

											// Get lightbox link
											$atts['lightbox_link'] = $lightbox_image;

											// Define lightbox data attributes
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

											// Check for video
											if ( $post->video = get_post_meta( $post->ID, 'wpex_post_video', true ) ) {
												$embed_url = wpex_sanitize_data( $post->video, 'embed_url' );
												if ( $embed_url ) {
													$atts['lightbox_link'] = $post->video;
													$atts['lightbox_data'][] = 'data-type="iframe"';
													$atts['lightbox_data'][] = 'data-options="thumbnail:\''. $lightbox_image .'\',width:1920,height:1080"';
												}
											}

											// Implode lightbox data
											$lightbox_data = ' '. implode( ' ', $atts['lightbox_data'] ); ?>

											<a href="<?php echo $atts['lightbox_link']; ?>" title="<?php wpex_esc_title(); ?>" class="portfolio-entry-media-link<?php echo $lightbox_class; ?>"<?php echo $lightbox_data; ?>>

										<?php 
										// Standard post link
										else : ?>

											<a href="<?php echo $post->permalink; ?>" title="<?php wpex_esc_title(); ?>" class="portfolio-entry-media-link"<?php echo vcex_html( 'target_attr', $link_target ); ?>>

										<?php endif; ?>

									<?php endif; ?>

									<?php
									// Display post thumbnail
									wpex_post_thumbnail( array(
										'width'  => $img_width,
										'height' => $img_height,
										'crop'   => $img_crop,
										'alt'    => wpex_get_esc_title(),
										'class'  => 'portfolio-entry-img',
										'size'   => $img_size,
									) ); ?>

									<?php
									// Inner link overlay HTML
									wpex_overlay( 'inside_link', $overlay_style, $atts ); ?>

									<?php
									// Close link tag
									if ( 'nowhere' != $thumb_link ) echo '</a>'; ?>

									<?php
									// Outer link overlay HTML
									wpex_overlay( 'outside_link', $overlay_style, $atts ); ?>

								</div><!-- .<?php echo $media_classes; ?> -->

							<?php endif; ?>

						<?php endif; ?>

						<?php
						// Display content if needed
						if ( 'true' == $title
							|| 'true' == $show_categories
							|| ( 'true' == $excerpt && $post->excerpt )
							|| 'true' == $read_more
						) : ?>
						
							<div class="portfolio-entry-details entry-details wpex-clr"<?php echo $content_style; ?>>

								<?php
								// Equal height div
								if ( $equal_heights_grid && ! $is_isotope ) echo '<div class="match-height-content">'; ?>

								<?php
								// Display title
								if ( 'true' == $title ) : ?>

									<<?php echo $title_tag; ?> class="portfolio-entry-title entry-title"<?php echo $heading_style; ?>>

										<?php
										// Display title without link
										if ( 'nowhere' == $title_link ) : ?>

											<?php  echo $post->title; ?>

										<?php
										// Link title to lightbox
										elseif ( 'lightbox' == $title_link ) : ?>

											<?php
											$atts['lightbox_data'] = array();
											// Lightbox data
											if ( $lightbox_skin && 'true' !== $thumb_lightbox_gallery ) {
												$atts['lightbox_data'][] = 'data-skin="'. $lightbox_skin .'"';
											}
											if ( 'true' == $thumb_lightbox_title ) {
												$atts['lightbox_data'][] = 'data-title="'. wpex_get_esc_title() .'"';
											}
											// Display lightbox
											if ( 'true' == $thumb_lightbox_caption && $post->excerpt ) {
												$atts['lightbox_data'][] = 'data-caption="'. str_replace( '"',"'", $post->excerpt ) .'"';
											}
											$lightbox_data = ' '. implode( ' ', $atts['lightbox_data'] ); ?>

											<a href="<?php wpex_lightbox_image(); ?>" title="<?php wpex_esc_title(); ?>" class="wpex-lightbox"<?php echo $heading_link_style; ?><?php echo $lightbox_data; ?>>
												<?php echo $post->title; ?>
											</a>

										<?php
										// Link title to post
										else : ?>

											<a href="<?php echo $post->permalink; ?>" title="<?php wpex_esc_title(); ?>"<?php echo $heading_link_style; ?><?php echo vcex_html( 'target_attr', $link_target ); ?>>
												<?php echo $post->title; ?>
											</a>

										<?php endif ?>

									</<?php echo $title_tag; ?>>

								<?php endif; ?>

								<?php
								// Display categories
								if ( 'true' == $show_categories ) : ?>

									<div class="<?php echo $categories_classes; ?>"<?php echo $categories_style; ?>>
										<?php
										// Display categories
										if ( 'true' == $show_first_category_only ) {
											wpex_first_term_link( $post->ID, 'portfolio_category' );
										} else {
											wpex_list_post_terms( 'portfolio_category', true, true );
										} ?>
									</div><!-- .portfolio-entry-categories -->

								<?php endif; ?>

								<?php
								// Display excerpt
								if ( 'true' == $excerpt && $post->excerpt ) : ?>

									<div class="portfolio-entry-excerpt wpex-clr"<?php echo $excerpt_style; ?>>
										<?php echo $post->excerpt; ?>
									</div><!-- .portfolio-entry-excerpt -->

								<?php endif; ?>

								<?php
								// Display read more button
								if ( 'true' == $read_more ) : ?>

									<div class="portfolio-entry-readmore-wrap wpex-clr">

										<a href="<?php echo $post->permalink; ?>" title="<?php echo esc_attr( $read_more_text ); ?>" rel="bookmark" class="<?php echo $readmore_classes; ?>"<?php echo $readmore_style; ?><?php echo $readmore_data; ?><?php echo vcex_html( 'target_attr', $link_target ); ?>>
											<?php echo $read_more_text; ?>
											<?php if ( 'true' == $readmore_rarr ) : ?>
												<span class="vcex-readmore-rarr"><?php echo wpex_element( 'rarr' ); ?></span>
											<?php endif; ?>
										</a>

									</div><!-- .portfolio-entry-readmore-wrap -->

								<?php endif; ?>
								
								<?php
								// Close Equal height container
								if ( $equal_heights_grid && ! $is_isotope ) echo '</div>'; ?>

							</div><!-- .portfolio-entry-details -->

						<?php endif; ?>

					</div><!-- .portfolio-entry-inner -->

				</div><!-- .portfolio-entry -->

				<?php
				// Reset entry counter
				if ( $count == $columns ) $count = ''; ?>
			
			<?php
			// End post loop
			endwhile; ?>

		</div><!-- .vcex-portfolio-grid -->
		
		<?php
		// Display pagination if enabled
		if ( 'true' == $pagination ) {
			wpex_pagination( $wpex_query );
		} ?>

	</div><!-- <?php echo $wrap_classes; ?> -->

	<?php
	// Reset the post data to prevent conflicts with WP globals
	wp_reset_postdata(); ?>

<?php
// If no posts are found display message
else :

	// Display no posts found error if function exists
	echo vcex_no_posts_found_message( $atts );

// End post check
endif; ?>