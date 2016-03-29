<?php
/**
 * Core theme functions - very important!! Do not ever edit this file, if you need to make
 * adjustments, please use a child theme. If you aren't sure how, please ask!
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

/**
 * Returns correct ID for any object
 * Used to fix issues with translation plugins such as WPML
 *
 * @since 3.1.1
 */
function wpex_parse_obj_id( $id, $type = 'page' ) {
	if ( $id && function_exists( 'icl_object_id' ) ) {
		$id = icl_object_id( $id, $type );
	}
	return $id;
}

/**
 * Outputs correct schema HTML for sections of the site
 *
 * @since 3.0.0
 */
function wpex_schema_markup( $location ) {
	echo wpex_get_schema_markup( $location );
}

/**
 * Returns correct schema HTML for sections of the site
 *
 * @since 3.0.0
 */
function wpex_get_schema_markup( $location ) {

	// Return nothing if disabled
	if ( ! wpex_get_mod( 'schema_markup_enable', true ) ) {
		return null;
	}

	// Loop through locations
	if ( 'body' == $location ) {
		$itemscope = 'itemscope';
		$itemtype  = 'http://schema.org/WebPage';
		if ( is_singular( 'post' ) ) {
			$type = "Article";
		} elseif( is_author() ) {
			$type = 'ProfilePage';
		} elseif( is_search() ) {
			$type = 'SearchResultsPage';
		}
		$schema = 'itemscope="'. $itemscope .'" itemtype="'. $itemtype .'"';
	} elseif ( 'header' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPHeader"';
	} elseif( 'site_navigation' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"';
	} elseif( 'main' == $location ) {
		$itemtype = 'http://schema.org/WebPageElement';
		$itemprop = 'mainContentOfPage';
		if ( is_singular( 'post' ) ) {
			$itemprop = '';
			$itemtype = 'http://schema.org/Blog';
		}
		$schema = 'itemprop="'. $itemprop .'" itemscope="itemscope" itemtype="'. $itemtype .'"';
	} elseif( 'sidebar' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPSideBar"';
	} elseif( 'footer' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPFooter"';
	} elseif( 'footer_bottom' == $location ) {
		$schema = '';
	} elseif( 'headline' == $location ) {
		$schema = 'itemprop="headline"';
	} elseif( 'blog_post' == $location ) {
		$schema = 'itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting"';
	} elseif( 'entry_content' == $location ) {
		$schema = 'itemprop="text"';
	} elseif( 'publish_date' == $location ) {
		$schema = 'itemprop="datePublished" pubdate';
	} elseif( 'author_name' == $location ) {
		$schema = 'itemprop="name"';
	} elseif( 'author_link' == $location ) {
		$schema = 'itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"';
	} elseif( 'image' == $location ) {
		$schema = 'itemprop="image"';
	} else {
		$schema = '';
	}

	// Apply filters and return schema
	return ' '. apply_filters( 'wpex_get_schemea', $schema );

}

/**
 * Returns theme custom post types
 *
 * @since  1.3.3
 */
function wpex_theme_post_types() {
	$post_types = array( 'portfolio', 'staff', 'testimonials' );
	$post_types = array_combine( $post_types, $post_types );
	$post_types = apply_filters( 'wpex_theme_post_types', $post_types );
	return $post_types;
}

/**
 * Echo the post URL
 *
 * @since 1.5.4
 */
function wpex_permalink( $post_id = '' ) {
	echo wpex_get_permalink( $post_id );
}

/**
 * Return the post URL
 *
 * @since 2.0.0
 */
function wpex_get_permalink( $post_id = '' ) {

	// If post ID isn't defined lets get it
	$post_id = $post_id ? $post_id : get_the_ID();

	// Check wpex_post_link custom field for custom link
	$meta = get_post_meta( $post_id, 'wpex_post_link', true );

	// If wpex_post_link custom field is defined return that otherwise return the permalink
	$permalink  = $meta ? $meta : get_permalink( $post_id );

	// Apply filters
	$permalink = apply_filters( 'wpex_permalink', $permalink );

	// Sanitize
	$permalink = esc_url( $permalink );

	// Return permalink
	return $permalink;

}

/**
 * Return custom permalink
 *
 * @since 2.0.0
 */
function wpex_get_custom_permalink() {
	return esc_url( get_post_meta( get_the_ID(), 'wpex_post_link', true ) );
}

/**
 * Echo escaped post title
 *
 * @since 2.0.0
 */
function wpex_esc_title() {
	echo wpex_get_esc_title();
}

/**
 * Return escaped post title
 *
 * @since 1.5.4
 */
function wpex_get_esc_title() {
	return esc_attr( the_title_attribute( 'echo=0' ) );
}

/**
 * Returns the correct sidebar ID
 *
 * @since  1.0.0
 */
function wpex_get_sidebar( $sidebar = 'sidebar' ) {

	// Get global object
	$wpex_theme = wpex_global_obj();

	// Pages
	if ( is_page() && wpex_get_mod( 'pages_custom_sidebar', true ) ) {
		if ( ! is_page_template( 'templates/blog.php' ) ) {
			$sidebar = 'pages_sidebar';
		}
	}

	// Search
	elseif ( is_search() && wpex_get_mod( 'search_custom_sidebar', true ) ) {
		$sidebar = 'search_sidebar';
	}
	
	// Add filter for tweaking the sidebar display via child theme's
	$sidebar = apply_filters( 'wpex_get_sidebar', $sidebar );

	// Check meta option after filter so it always overrides
	if ( $meta = get_post_meta( $wpex_theme->post_id, 'sidebar', true ) ) {
		$sidebar = $meta;
	}

	// Never show empty sidebar
	if ( ! is_active_sidebar( $sidebar ) ) {
		$sidebar = 'sidebar';
	} 

	// Return the correct sidebar
	return $sidebar;
	
}

/**
 * Returns the correct classname for any specific column grid
 *
 * @since 1.0.0
 */
function wpex_grid_class( $col = '4' ) {
	$class = 'span_1_of_'. $col;
	$class = apply_filters( 'wpex_grid_class', $class );
	return $class;
}

/**
 * Echos 1st taxonomy of any taxonomy with a link
 *
 * @since 2.0.0
 */
function wpex_first_term_link( $post_id, $taxonomy = 'category' ) {
	if ( ! $post_id ) {
		return;
	}
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return;
	}
	$terms = wp_get_post_terms( $post_id, $taxonomy );
	if ( ! empty( $terms ) ) {
		$term_link = get_term_link( $terms[0], $taxonomy ); ?>
		<a href="<?php echo esc_url( $term_link ); ?>" title="<?php esc_attr( $terms[0]->name ); ?>"><?php echo $terms[0]->name; ?></a>
	<?php
	}
}

/**
 * Returns a list of terms for specific taxonomy
 * 
 * @since 2.1.3
 */
function wpex_get_list_post_terms( $taxonomy = 'category', $show_links = true ) {
	return wpex_list_post_terms( $taxonomy, $show_links, false );
}

/**
 * List terms for specific taxonomy
 * 
 * @since 1.6.3
 */
function wpex_list_post_terms( $taxonomy = 'category', $show_links = true, $echo = true ) {

	// Make sure taxonomy exists
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return;
	}

	// Get terms
	$list_terms = array();
	$terms      = wp_get_post_terms( get_the_ID(), $taxonomy );

	// Return if no terms are found
	if ( ! $terms ) {
		return;
	}

	// Loop through terms
	foreach ( $terms as $term ) {
		$permalink = get_term_link( $term->term_id, $taxonomy );
		if ( $show_links ) {
			$list_terms[] = '<a href="'. $permalink .'" title="'. $term->name .'" class="term-'. $term->term_id .'">'. $term->name .'</a>';
		} else {
			$list_terms[] = '<span class="term-'. $term->term_id .'">'. $term->name .'</span>';
		}
	}

	// Turn into comma seperated string
	if ( $list_terms && is_array( $list_terms ) ) {
		$list_terms = implode( ', ', $list_terms );
	} else {
		return;
	}

	// Echo terms
	if ( $echo ) {
		echo $list_terms;
	} else {
		return $list_terms;
	}

}

/**
 * Minify CSS
 *
 * @since 1.6.3
 */
function wpex_minify_css( $css ) {

	if ( $css ) {

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Trim
		$css = trim( $css );

		// Return minified CSS
		return $css;

	}
	
}

/**
 * Provides translation support for plugins such as WPML
 *
 * @since 1.6.3
 */
function wpex_translate_theme_mod( $id, $content ) {

	// Return false if no content is found
	if ( ! $content ) {
		return false;
	}

	// WPML translation
	if ( function_exists( 'icl_t' ) && $id ) {
		$content = icl_t( 'Theme Mod', $id, $content );
	}

	// Polylang Translation
	if ( function_exists( 'pll__' ) && $id ) {
		$content = pll__( $content );
	}

	// Return the content
	return $content;

}

/**
 * Outputs a theme heading
 * 
 * @since 1.3.3
 */
function wpex_heading( $args = array() ) {

	// Defaults
	$defaults = array(
		'apply_filters' => '',
		'content'       => '',
		'tag'           => 'h2',
		'classes'       => array(),
	);

	// Add filters if defined
	if ( ! empty( $args['apply_filters'] ) ) {
		$args = apply_filters( 'wpex_heading_'. $args['apply_filters'], $args );
	}

	// Parse args
	wp_parse_args( $args, $defaults );

	// Extract args
	extract( $args );

	// Return if text is empty
	if ( ! $content ) {
		return;
	}

	// Get classes
	$add_classes = $classes;
	$classes     = array( 'theme-heading' );
	if ( $add_classes && is_array( $add_classes ) ) {
		$classes = array_merge( $classes, $add_classes );
	}

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes ); ?>

	<<?php echo $tag; ?> class="<?php echo $classes; ?>">
		<span class="text"><?php echo $content; ?></span>
	</<?php echo $tag; ?>><!-- <?php echo $classes; ?> -->

<?php
}

/**
 * Provides translation support for plugins such as WPML
 * 
 * @since 1.3.3
 */
if ( ! function_exists( 'wpex_element' ) ) {
	function wpex_element( $element ) {

		// Rarr
		if ( 'rarr' == $element ) {
			if ( is_rtl() ) {
				return '&larr;';
			} else {
				return '&rarr;';
			}
		}

		// Angle Right
		elseif ( 'angle_right' == $element ) {

			if ( is_rtl() ) {
				return '<span class="fa fa-angle-left"></span>';
			} else {
				return '<span class="fa fa-angle-right"></span>';
			}

		}

	}
}

/**
 * Checks if a featured image has a caption
 *
 * @since 2.0.0
 */
function wpex_featured_image_caption( $post_id = '' ) {
	$post_id      = $post_id ? $post_id : get_the_ID();
	$thumbnail_id = get_post_thumbnail_id( $post_id );
	$caption      = get_post_field( 'post_excerpt', $thumbnail_id );
	return $caption;
}

/**
 * Adds the sp-video class to an iframe
 *
 * @since 1.0.0
 */
function wpex_add_sp_video_to_oembed( $oembed ) {
	$oembed = str_replace( 'iframe', 'iframe class="sp-video"', $oembed );
	return $oembed;
}

/**
 * Returns attachment data
 *
 * @since 2.0.0
 */
function wpex_get_attachment_data( $attachment = '', $return = '' ) {

	// Return if no attachment
	if ( ! $attachment ) {
		return;
	}

	// Return if return equals none
	if ( 'none' == $return ) {
		return;
	}

	// Create array of attachment data
	$array = array(
		'url'         => get_post_meta( $attachment, '_wp_attachment_url', true ),
		'src'         => wp_get_attachment_url( $attachment ),
		'alt'         => get_post_meta( $attachment, '_wp_attachment_image_alt', true ),
		'title'       => get_the_title( $attachment),
		'caption'     => get_post_field( 'post_excerpt', $attachment ),
		'description' => get_post_field( 'post_content', $attachment ),
		'video'       => esc_url( get_post_meta( $attachment, '_video_url', true ) ),
	);

	// Set alt to title if alt not defined
	$array['alt'] = $array['alt'] ? $array['alt'] : $array['title'];

	// Return data
	if ( $return ) {
		return $array[$return];
	} else {
		return $array;
	}

}

/**
 * Returns correct hover animation class
 *
 * @since 2.0.0
 */
function wpex_hover_animation_class( $animation ) {
	$animation = 'hvr-'. $animation;
	return $animation;
}

/**
 * Echo animation classes for entries
 *
 * @since 1.1.6
 */
function wpex_entry_image_animation_classes() {
	echo wpex_get_entry_image_animation_classes();
}

/**
 * Returns animation classes for entries
 *
 * @since 1.1.6
 */
function wpex_get_entry_image_animation_classes() {

	// Empty by default
	$classes = '';

	// Only used for standard posts now
	if ( 'post' != get_post_type( get_the_ID() ) ) {
		return;
	}

	// Get blog classes
	if ( wpex_get_mod( 'blog_entry_image_hover_animation' ) ) {
		$classes = ' wpex-image-hover '. wpex_get_mod( 'blog_entry_image_hover_animation' );
	}

	// Apply filters
	return apply_filters( 'wpex_entry_image_animation_classes', $classes );

}

/**
 * Returns thumbnail sizes
 *
 * @since 2.0.0
 */
function wpex_get_thumbnail_sizes( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array(
		'full'  => array(
			'width'  => '9999',
			'height' => '9999',
			'crop'   => 0,
		),
	);
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width']   = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height']  = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop']    = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array( 
				'width'     => $_wp_additional_image_sizes[ $_size ]['width'],
				'height'    => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'      => $_wp_additional_image_sizes[ $_size ]['crop']
			);

		}

	}

	// Get only 1 size if found
	if ( $size ) {
		if ( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		} else {
			return false;
		}
	}

	// Return sizes
	return $sizes;
}

/**
 * Generates a retina image
 *
 * @since 2.0.0
 */
function wpex_generate_retina_image( $image, $width, $height, $crop ) {

	// Define cropping args
	$args = array(
		'image'  => $image,
		'width'  => $width,
		'height' => $height,
		'crop'   => $crop,
		'return' => 'url',
		'retina' => true,
	);

	// Resize image and create retina version
	$image = wpex_image_resize( $args );

	// Return image
	return $image;

}

/**
 * Echo post thumbnail url
 *
 * @since 2.0.0
 */
function wpex_post_thumbnail_url( $args = array() ) {
	echo wpex_get_post_thumbnail_url( $args );
}

/**
 * Return post thumbnail url
 *
 * @since 2.0.0
 */
function wpex_get_post_thumbnail_url( $args = array() ) {
	$args['return'] = 'url';
	return wpex_get_post_thumbnail( $args );
}

/**
 * Outputs the img HTMl thubmails used in the Total VC modules
 *
 * @since 2.0.0
 */
function wpex_post_thumbnail( $args = array() ) {
	echo wpex_get_post_thumbnail( $args );
}

/**
 * Returns correct HTMl for post thumbnails
 *
 * @since 2.0.0
 */
function wpex_get_post_thumbnail( $args = array() ) {

	// Check if retina is enabled
	$retina_img = '';
	$attr       = array();

	// Default args
	$defaults = array(
		'attachment'    => get_post_thumbnail_id(),
		'size'          => 'full',
		'width'         => '',
		'height'        => '',
		'crop'          => 'center-center',
		'alt'           => '',
		'class'         => '',
		'return'        => 'html',
		'style'         => '',
		'retina'        => wpex_global_obj( 'retina' ),
		'schema_markup' => false,
	);

	// Parse args
	$args = wp_parse_args( $args, $defaults );

	// Extract args
	extract( $args );

	// Return dummy image
	if ( 'dummy' == $attachment ) {
		return '<img src="'. wpex_placeholder_img_src() .'" />';
	}

	// Return if there isn't any attachment
	if ( ! $attachment ) {
		return;
	}

	// Sanitize variables
	$size = ( 'wpex-custom' == $size ) ? 'wpex_custom' : $size;
	$size = ( 'wpex_custom' == $size ) ? false : $size;
	$crop = ( ! $crop ) ? 'center-center' : $crop;
	$crop = ( 'true' == $crop ) ? 'center-center' : $crop;

	// Image must have an alt
	if ( empty( $alt ) ) {
		$alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );
	}
	if ( empty( $alt ) ) {
		$alt = trim( strip_tags( get_post_field( 'post_excerpt', $attachment ) ) );
	}
	if ( empty( $alt ) ) {
		$alt = trim( strip_tags( get_the_title( $attachment ) ) );
		$alt = str_replace( '_', ' ', $alt );
		$alt = str_replace( '-', ' ', $alt );
	}

	// Prettify alt attribute
	if ( $alt ) {
		$alt = ucwords( $alt );
	}

	// If image width and height equal '9999' return full image
	if ( '9999' == $width && '9999' == $height ) {
		$size  = $size ? $size : 'full';
		$width = $height = '';
	}

	// Define crop locations
	$crop_locations = array_flip( wpex_image_crop_locations() );

	// Set crop location if defined in format 'left-top' and turn into array
	if ( $crop && in_array( $crop, $crop_locations ) ) {
		$crop = ( 'center-center' == $crop ) ? true : explode( '-', $crop );
	}

	// Get attachment URl
	$attachment_url = wp_get_attachment_url( $attachment );

	// Return if there isn't any attachment URL
	if ( ! $attachment_url ) {
		return;
	}

	// Add classes
	if ( $class ) {
		$attr['class'] = $class;
	}

	// Add alt
	if ( $alt ) {
		$attr['alt'] = esc_attr( $alt );
	}

	// Add style
	if ( $style ) {
		$attr['style'] = $style;
	}

	// Add schema markup
	if ( $schema_markup ) {
		$attr['itemprop'] = 'image';
	}

	// If on the fly image resizing is enabled or a custom width/height is defined
	if ( wpex_get_mod( 'image_resizing', true ) || ( $width || $height ) ) {

		// Add Classes
		if ( $class ) {
			$class = ' class="'. $class .'"';
		}

		// If size is defined and not equal to wpex_custom
		if ( $size && 'wpex_custom' != $size ) {
			$dims   = wpex_get_thumbnail_sizes( $size );
			$width  = $dims['width'];
			$height = $dims['height'];
			$crop   = ! empty( $dims['crop'] ) ? $dims['crop'] : $crop;
		}


		// Crop standard image
		$image = wpex_image_resize( array(
			'image'  => $attachment_url,
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		) );

		// Generate retina version
		if ( $retina ) {
			$retina_img = wpex_generate_retina_image( $attachment_url, $width, $height, $crop );
			if ( $retina_img ) {
				$attr['data-at2x'] = $retina_img;
			} else {
				$attr['data-no-retina'] = '';
			}
		}

		// Return HTMl
		if ( $image ) {

			// Return image URL
			if ( 'url' == $return ) {
				return $image['url'];
			}

			// Return image HTMl
			else {

				// Add attributes
				$attr = array_map( 'esc_attr', $attr );
				$html = '';
				foreach ( $attr as $name => $value ) {
					$html .= ' '. $name .'="'. $value .'"';
				}

				// Return img
				return '<img src="'. $image['url'] .'" width="'. $image['width'] .'" height="'. $image['height'] .'"'. $html .' />';

			}

		}

	}

	// Return image from add_image_size
	else {

		// Sanitize size
		$size = $size ? $size : 'full';

		// Create retina version if retina is enabled (not needed for full images)
		if ( $retina ) {

			// Retina not needed for full images
			if ( 'full' != $size ) {
				$dims       = wpex_get_thumbnail_sizes( $size );
				$retina_img = wpex_generate_retina_image( $attachment_url, $dims['width'], $dims['height'], $dims['crop'] );
			}

			// Add retina tag
			if ( $retina_img ) {
				$attr['data-at2x'] = $retina_img;
			} else {
				$attr['data-no-retina'] = '';
			}

		}

		// Return image URL
		if ( 'url' == $return ) {
			$src = wp_get_attachment_image_src( $attachment, $size, false );
			return $src[0];
		}

		// Return image HTMl
		else {
			return wp_get_attachment_image( $attachment, $size, false, $attr );
		}

	}

}

/**
 * Echo lightbox image URL
 *
 * @since 2.0.0
 */
function wpex_lightbox_image( $attachment = '' ) {
	echo wpex_get_lightbox_image( $attachment );
}

/**
 * Returns lightbox image URL.
 *
 *  @since 2.0.0
 */
function wpex_get_lightbox_image( $attachment = '' ) {

	// If attachment is empty lets set it to the post thumbnail id
	if ( ! $attachment ) {
		$attachment = get_post_thumbnail_id();
	}

	// If the attachment is an ID lets get the URL
	if ( is_numeric( $attachment ) ) {
		$image = $attachment;
	} elseif ( is_array( $attachment ) ) {
		return $attachment[0];
	} else {
		return $attachment;
	}

	// Set default size
	$size = apply_filters( 'wpex_get_lightbox_image_size', 'lightbox' );

	// Sanitize data
	$image = wpex_get_post_thumbnail_url( array(
		'attachment' => $image,
		'size'       => $size,
		'retina'     => false,
	) );

	// Return escaped image
	return esc_url( $image );
}

/**
 * Echo post video
 *
 * @since 2.0.0
 */
function wpex_post_video( $post_id ) {
	echo wpex_get_post_video( $post_id );
}

/**
 * Returns post video
 *
 * @since 2.0.0
 */
function wpex_get_post_video( $post_id = '' ) {

	// Define video variable
	$video = '';

	// Get correct ID
	$post_id = $post_id ? $post_id : get_the_ID();

	// Embed
	if ( $meta = get_post_meta( $post_id, 'wpex_post_video_embed', true ) ) {
		$video = $meta;
	}

	// Check for self-hosted first
	elseif ( $meta = get_post_meta( $post_id, 'wpex_post_self_hosted_media', true ) ) {
		$video = $meta;
	}

	// Check for wpex_post_video custom field
	elseif ( $meta = get_post_meta( $post_id, 'wpex_post_video', true ) ) {
		$video = $meta;
	}

	// Check for post oembed
	elseif ( $meta = get_post_meta( $post_id, 'wpex_post_oembed', true ) ) {
		$video = $meta;
	}

	// Check old redux custom field last
	elseif ( $meta = get_post_meta( $post_id, 'wpex_post_self_hosted_shortcode_redux', true ) ) {
		$video = $meta;
	}

	// Apply filters for child theming
	$video = apply_filters( 'wpex_get_post_video', $video );

	// Return data
	return $video;

}

/**
 * Echo post video HTML
 *
 * @since 2.0.0
 */
function wpex_post_video_html( $video = '' ) {
	echo wpex_get_post_video_html( $video );
}

/**
 * Returns post video HTML
 *
 * @since 2.0.0
 */
function wpex_get_post_video_html( $video = '' ) {

	// Get video
	$video = $video ? $video : wpex_get_post_video();

	// Return if video is empty
	if ( empty( $video ) ) {
		return;
	}

	// Check post format for standard post type
	if ( 'post' == get_post_type() && 'video' != get_post_format() ) {
		return;
	}

	// Check if it's an embed or iframe

	// Get oembed code and return
	if ( ! is_wp_error( $oembed = wp_oembed_get( $video ) ) && $oembed ) {
		return '<div class="responsive-video-wrap">'. $oembed .'</div>';
	}

	// Display using apply_filters if it's self-hosted
	else {

		$video = apply_filters( 'the_content', $video );

		// Add responsive video wrap for youtube/vimeo embeds
		if ( strpos( $video, 'youtube' ) || strpos( $video, 'vimeo' ) ) {
			return '<div class="responsive-video-wrap">'. $video .'</div>';
		}
		
		// Else return without responsive wrap
		else {
			return $video;
		}

	}

}


/**
 * Returns post audio
 *
 * @since 2.0.0
 */
function wpex_get_post_audio( $id = '' ) {

	// Define video variable
	$audio = '';

	// Get correct ID
	$id = $id ? $id : get_the_ID();

	// Check for self-hosted first
	if ( $self_hosted = get_post_meta( $id, 'wpex_post_self_hosted_media', true ) ) {
		$audio = $self_hosted;
	}

	// Check for wpex_post_audio custom field
	elseif ( $post_video = get_post_meta( $id, 'wpex_post_audio', true ) ) {
		$audio = $post_video;
	}

	// Check for post oembed
	elseif ( $post_oembed = get_post_meta( $id, 'wpex_post_oembed', true ) ) {
		$audio = $post_oembed;
	}

	// Check old redux custom field last
	elseif ( $self_hosted = get_post_meta( $id, 'wpex_post_self_hosted_shortcode_redux', true ) ) {
		$audio = $self_hosted;
	}

	// Apply filters for child theming
	$audio = apply_filters( 'wpex_get_post_audio', $audio );

	// Return data
	return $audio;

}

/**
 * Returns post audio
 *
 * @since 2.0.0
 */
function wpex_get_post_audio_html( $audio = '' ) {

	// Get video
	$audio = $audio ? $audio : wpex_get_post_audio();

	// Return if video is empty
	if ( empty( $audio ) ) {
		return;
	}

	// Get oembed code and return
	if ( ! is_wp_error( $oembed = wp_oembed_get( $audio ) ) && $oembed ) {
		return '<div class="responsive-audio-wrap">'. $oembed .'</div>';
	}

	// Display using apply_filters if it's self-hosted
	else {
		return apply_filters( 'the_content', $audio );
	}

}

/**
 * Returns the "category" taxonomy for a given post type
 *
 * @since 2.0.0
 */
function wpex_get_post_type_cat_tax( $post_type = '' ) {

	// Get the post type
	$post_type = $post_type ? $post_type : get_post_type();

	// Return taxonomy
	if ( 'post' == $post_type ) {
		$tax = 'category';
	} elseif ( 'portfolio' == $post_type ) {
		$tax = 'portfolio_category';
	} elseif( 'staff' == $post_type ) {
		$tax = 'staff_category';
	} elseif( 'testimonials' == $post_type ) {
		$tax = 'testimonials_category';
	} elseif ( 'product' == $post_type ) {
		$tax = 'product_cat';
	} elseif ( 'tribe_events' == $post_type ) {
		$tax = 'tribe_events_cat';
	} else {
		$tax = false;
	}

	// Apply filters
	$tax = apply_filters( 'wpex_get_post_type_cat_tax', $tax );

	// Return
	return $tax;

}

/**
 * Returns correct typography style class
 *
 * @since  2.0.2
 * @return string
 */
function wpex_typography_style_class( $style ) {
	$class = '';
	if ( $style
		&& 'none' != $style
		&& array_key_exists( $style, wpex_typography_styles() ) ) {
		$class = 'typography-'. $style;
	}
	return $class;
}

/**
 * Convert to array
 *
 * @since 2.0.0
 */
function wpex_string_to_array( $value = array() ) {

	// Return empty array if value is empty
	if ( empty( $value ) ) {
		return array();
	}

	// Check if array and not empty
	elseif ( ! empty( $value ) && is_array( $value ) ) {
		return $array;
	}

	// Create our own return
	else {

		// Define array
		$array = array();

		// Clean up value
		$items  = preg_split( '/\,[\s]*/', $value );

		// Create array
		foreach ( $items as $item ) {
			if ( strlen( $item ) > 0 ) {
				$array[] = $item;
			}
		}

		// Return array
		return $array;

	}

}

/**
 * Retrieve all term data
 *
 * @since 2.1.0
 */
function wpex_get_term_data() {
	return get_option( 'wpex_term_data' );
}

/**
 * Placeholder Image
 *
 * @since 2.1.0
 */
function wpex_placeholder_img_src() {
	$img = apply_filters( 'wpex_placeholder_img_src', get_template_directory_uri() .'/images/placeholder.png' );
	return $img;
}

/**
 * Returns data attributes for post sliders
 *
 * @since 2.0.0
 */
function wpex_slider_data( $args = '' ) {

	// Define main vars
	$defaults = array(
		'filter_tag'        => 'wpex_slider_data',
		'auto-play'         => 'false',
		'buttons'           => 'false',
		'fade'              => 'true',
		'loop'              => 'true',
		'thumbnails-height' => '60',
		'thumbnails-width'  => '60',
	);

	// Parse arguments
	$args = wp_parse_args( $args, $defaults );

	// Extract args
	extract( $args );

	// Apply filters for child theming
	$args = apply_filters( $filter_tag, $args );

	// Turn array into HTML
	$return = '';
	foreach ( $args as $key => $val ) {
		$return .= ' data-'. $key .'="'. $val .'"';
	}

	// Return
	echo $return;

}

/**
 * Blank Image
 *
 * @since 2.1.0
 */
function wpex_blank_img_src() {
	return get_template_directory_uri() .'/images/slider-pro/blank.png';
}

/**
 * Register theme mods for translations
 *
 * @since 2.1.0
 */
function wpex_register_theme_mod_strings() {
	return apply_filters( 'wpex_register_theme_mod_strings', array(
		'custom_logo'                    => false,
		'retina_logo'                    => false,
		'retina_logo_height'             => false,
		'error_page_title'               => '404: Page Not Found',
		'error_page_text'                => false,
		'top_bar_content'                => '[font_awesome icon="phone" margin_right="5px" color="#000"] 1-800-987-654 [font_awesome icon="envelope" margin_right="5px" margin_left="20px" color="#000"] admin@total.com [font_awesome icon="user" margin_right="5px" margin_left="20px" color="#000"] [wp_login_url text="User Login" logout_text="Logout"]',
		'top_bar_social_alt'             => false,
		'header_aside'                   => false,
		'breadcrumbs_home_title'         => false,
		'blog_entry_readmore_text'       => 'Read More',
		'social_share_heading'           => 'Please Share This',
		'portfolio_related_title'        => 'Related Projects',
		'staff_related_title'            => 'Related Staff',
		'blog_related_title'             => 'Related Posts',
		'callout_text'                   => 'I am the footer call-to-action block, here you can add some relevant/important information about your company or product. I can be disabled in the theme options.',
		'callout_link'                   => 'http://www.wpexplorer.com',
		'callout_link_txt'               => 'Get In Touch',
		'footer_copyright_text'          => 'Copyright <a href="#">Your Business LLC.</a> - All Rights Reserved',
		'woo_shop_single_title'          => __( 'Store', 'wpex' ),
		'woo_menu_icon_custom_link'      => '',
		'blog_single_header_custom_text' => 'Blog',
	) );
}

/**
 * Returns correct image hover classnames
 *
 * @since 2.0.0
 */
function wpex_image_hover_classes( $style ) {
	$classes    = array( 'wpex-image-hover' );
	$classes[]  = $style;
	return implode( ' ', $classes );
}

/**
 * Returns correct image rendering class
 *
 * @since 2.0.0
 */
function wpex_image_rendering_class( $rendering ) {
	return 'image-rendering-'. $rendering;
}

/**
 * Returns correct image filter class
 *
 * @since 2.0.0
 */
function wpex_image_filter_class( $filter ) {
	if ( ! $filter || 'none' == $filter ) {
		return;
	}
	return 'image-filter-'. $filter;
}

/**
 * Returns correct social button class
 *
 * @since 3.0.0
 */
function wpex_get_social_button_class( $style ) {

	// Set theme default style
	$style = $style ? $style : 'flat-rounded';
	$style = apply_filters( 'wpex_default_social_button_style', $style );

	// None
	if ( 'none' == $style ) {
		$style = 'wpex-social-btn-no-style';
	}

	// Minimal
	elseif ( 'minimal' == $style ) {
		$style = 'wpex-social-btn-minimal';
	} elseif ( 'minimal-rounded' == $style ) {
		$style = 'wpex-social-btn-minimal wpex-semi-rounded';
	} elseif ( 'minimal-round' == $style ) {
		$style = 'wpex-social-btn-minimal wpex-round';
	}

	// Flat
	elseif ( 'flat' == $style ) {
		$style = 'wpex-social-btn-flat wpex-bg-gray';
	} elseif ( 'flat-rounded' == $style ) {
		$style = 'wpex-social-btn-flat wpex-semi-rounded';
	} elseif ( 'flat-round' == $style ) {
		$style = 'wpex-social-btn-flat wpex-round';
	}

	// Flat Color
	elseif ( 'flat-color' == $style ) {
		$style = 'wpex-social-btn-flat wpex-social-bg';
	} elseif ( 'flat-color-rounded' == $style ) {
		$style = 'wpex-social-btn-flat wpex-social-bg wpex-semi-rounded';
	} elseif ( 'flat-color-round' == $style ) {
		$style = 'wpex-social-btn-flat wpex-social-bg wpex-round';
	}

	// 3D
	elseif ( '3d' == $style ) {
		$style = 'wpex-social-btn-3d';
	} elseif ( '3d-color' == $style ) {
		$style = 'wpex-social-btn-3d wpex-social-bg';
	}

	// Black
	elseif ( 'black' == $style ) {
		$style = 'wpex-social-btn-black';
	} elseif ( 'black-rounded' == $style ) {
		$style = 'wpex-social-btn-black wpex-semi-rounded';
	} elseif ( 'black-round' == $style ) {
		$style = 'wpex-social-btn-black wpex-round';
	}

	// Black + Color Hover
	elseif ( 'black-ch' == $style ) {
		$style = 'wpex-social-btn-black-ch';
	} elseif ( 'black-ch-rounded' == $style ) {
		$style = 'wpex-social-btn-black-ch wpex-semi-rounded';
	} elseif ( 'black-ch-round' == $style ) {
		$style = 'wpex-social-btn-black-ch wpex-round';
	}

	// Graphical
	elseif ( 'graphical' == $style ) {
		$style = 'wpex-social-bg wpex-social-btn-graphical';
	} elseif ( 'graphical-rounded' == $style ) {
		$style = 'wpex-social-bg wpex-social-btn-graphical wpex-semi-rounded';
	} elseif ( 'graphical-round' == $style ) {
		$style = 'wpex-social-bg wpex-social-btn-graphical wpex-round';
	}

	// Return style
	return apply_filters( 'wpex_get_social_button_class', 'wpex-social-btn '. $style );
}