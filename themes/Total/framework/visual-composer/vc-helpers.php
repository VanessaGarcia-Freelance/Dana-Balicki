<?php
/**
 * Visual Composer Helper Functions
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 */

/**
 * Config files tweak VC modules (add params, remove params, filter fields)
 *
 * Must load on the front-end and backend to ensure items are mapped correctly for
 * vc_map_get_attributes()
 *
 * @since 3.0.0
 */
require_once( WPEX_FRAMEWORK_DIR .'visual-composer/parse/parse-row-atts.php' );
require_once( WPEX_FRAMEWORK_DIR .'visual-composer/config/row.php' );
require_once( WPEX_FRAMEWORK_DIR .'visual-composer/config/column.php' );
require_once( WPEX_FRAMEWORK_DIR .'visual-composer/config/single-image.php' );

/**
 * Declare functions for use with the Visual Composer autocomplete
 *
 * @since 3.0.0
 */
if ( is_admin() ) {
	require_once( WPEX_FRAMEWORK_DIR .'visual-composer/helpers/autocomplete.php' );
}

/**
 * Helper classes for VC module output
 *
 * @since 3.0.0
 */
require_once( WPEX_FRAMEWORK_DIR .'visual-composer/helpers/build-query.php' );
require_once( WPEX_FRAMEWORK_DIR .'visual-composer/helpers/inline-js.php' );
require_once( WPEX_FRAMEWORK_DIR .'visual-composer/helpers/inline-style.php' );

/**
 * Returns list of post types
 *
 * @since 2.1.0
 */
function vcex_get_post_types() {
	$post_types_list = array();
	$post_types = get_post_types( array(
		'public' => true
	) );
	if ( $post_types ) {
		foreach ( $post_types as $post_type ) {
			if ( 'revision' != $post_type && 'nav_menu_item' != $post_type && 'attachment' != $post_type ) {
				$post_types_list[$post_type] = $post_type;
			}
		}
	}
	return $post_types_list;
}

/**
 * Array of Google Font options
 *
 * @since 2.1.0
 */
function vcex_fonts_array() {
	$array = array(
		__( 'Default', 'wpex' ) => '',
	);
	$std_fonts    = wpex_standard_fonts();
	$array        = array_merge( $array, $std_fonts );
	$google_fonts = wpex_google_fonts_array();
	$array        = array_merge( $array, $google_fonts );
	$array        = apply_filters( 'vcex_google_fonts_array', $array );
	return $array;
}

/**
 * Parses lightbox dimensions
 *
 * @since 2.1.2
 */
function vcex_parse_lightbox_dims( $dims ) {

	// Return default if undefined
	if ( ! $dims ) {
		return 'width:1920,height:1080';
	}

	// Parse data
	$dims = explode( 'x', $dims );
    $w    = isset( $dims[0] ) ? $dims[0] : '1920';
    $h    = isset( $dims[1] ) ? $dims[1] : '1080';

    // Return dimensions
    return 'width:'. $w .',height:'. $h .'';
	
}

/**
 * Parses lightbox dimensions
 *
 * @since 2.1.2
 */
function vcex_parse_textarea_html( $data = '' ) {
	if ( $data && base64_decode( $data, true ) ) {
		return rawurldecode( base64_decode( strip_tags( $data ) ) );
	}
	return $data;
}

/**
 * Parses the font_control / typography param
 *
 * @since 2.0.0
 */
function vcex_parse_typography_param( $value ) {

	// Conter value to array
	$value = vc_parse_multi_attribute( $value );
	
	// Define defaults
	$defaults = array(
		'tag'               => '',
		'text_align'        => '',
		'font_size'         => '',
		'line_height'       => '',
		'color'             => '',
		'font_style_italic' => '',
		'font_style_bold'   => '',
		'font_family'       => '',
		'letter_spacing'    => '',
		'font_family'       => '',
	);

	// Parse values so keys exist
	$values = wp_parse_args( $value, $defaults );

	// Return values
	return $values;

}

/**
 * Return grid filter arguments
 *
 * @since 2.0.0
 */
function vcex_grid_filter_args( $atts = '', $query = '' ) {

	// Return if no attributes found
	if ( ! $atts ) {
		return;
	}

	// Define args
	$args = $include = array();

	// Don't get empty
	$args['hide_empty'] = true;

	// Taxonomy
	$taxonomy = isset( $atts['taxonomy'] ) ? $atts['taxonomy'] : '';

	// Define post type and taxonomy
	$post_type = ! empty( $atts['post_type'] ) ? $atts['post_type'] : '';

	// Define include/exclude category vars
	$include_cats = ! empty( $atts['include_categories'] ) ? vcex_string_to_array( $atts['include_categories'] ) : '';

	// Check if only 1 category is included
	// If so check if it's a parent item so we can display children as the filter links
	if ( $include_cats && '1' == count( $include_cats ) && $children = get_term_children( $include_cats[0], $taxonomy ) ) {
		$include = $children;
	}

	// Include only terms from current query
	if ( empty( $include ) && $query ) {
		$post_ids = wp_list_pluck( $query->posts, 'ID' );
		foreach ( $post_ids as $post_id ) {
			$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );
			if ( ! empty( $terms ) && is_array( $terms ) ) {
				foreach( $terms as $term ) {
					if ( ! $include_cats ) {
						$include[$term] = $term;
					} elseif ( $include_cats && in_array( $term, $include_cats ) ) {
						$include[$term] = $term;
					}
				}
			}
		}
		$args['include'] = $include;
	}

	// Add to args
	if ( ! empty( $include ) ) {
		$args['include'] = $include;
	}
	if ( ! empty( $exclude ) ) {
		$args['exclude'] = $exclude;
	}

	// Apply filters
	if ( $post_type ) {
		$args = apply_filters( 'vcex_'. $post_type .'_grid_filter_args', $args );
	}

	// Return args
	return $args;

}

/**
 * Convert to array
 *
 * @since 2.0.0
 */
function vcex_string_to_array( $value = array() ) {
	
	// Return wpex function if it exists  
	if ( function_exists( 'wpex_string_to_array' ) ) {
		return wpex_string_to_array( $value );
	}

	// Create our own return
	else {

		// Return null for empty array
		if ( empty( $value ) && is_array( $value ) ) {
			return null;
		}

		// Return if already array
		if ( ! empty( $value ) && is_array( $value ) ) {
			return $value;
		}

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
 * Generates various types of HTML based on a value
 *
 * @since 2.0.0
 */
function vcex_parse_old_design_js() {
	return WPEX_VCEX_DIR_URI . 'assets/parse-old-design.js';
}

/**
 * Generates various types of HTML based on a value
 *
 * @since 2.0.0
 */
function vcex_html( $type, $value, $trim = false ) {

	// Return nothing by default
	$return = '';

	// Return if value is empty
	if ( ! $value ) {
		return;
	}

	// Title attribute
	if ( 'id_attr' == $type ) {
		$value  = trim ( str_replace( '#', '', $value ) );
		$value  = str_replace( ' ', '', $value );
		if ( $value ) {
			$return = ' id="'. esc_attr( $value ) .'"';
		}
	}

	// Title attribute
	if ( 'title_attr' == $type ) {
		$return = ' title="'. esc_attr( $value ) .'"';
	}

	// Link Target
	elseif ( 'target_attr' == $type ) {
		if ( 'blank' == $value
			|| '_blank' == $value
			|| strpos( $value, 'blank' ) ) {
			$return = ' target="_blank"';
		}
	}

	// Link rel
	elseif ( 'rel_attr' == $type ) {
		if ( 'nofollow' == $value ) {
			$return = ' rel="nofollow"';
		}
	}

	// Return HTMl
	if ( $trim ) {
		return trim( $return );
	} else {
		return $return;
	}

}

/**
 * Returns array of image sizes for use in the Customizer
 *
 * @since 2.0.0
 */
function vcex_image_sizes() {
	$sizes = array(
		__( 'Custom Size', 'wpex' ) => 'wpex_custom',
	);
	$get_sizes = get_intermediate_image_sizes();
	array_unshift( $get_sizes, 'full' );
	$get_sizes = array_combine( $get_sizes, $get_sizes );
	$sizes     = array_merge( $sizes, $get_sizes );
	return $sizes;
}

/**
 * Notice when no posts are found
 *
 * @since 2.0.0
 */
function vcex_no_posts_found_message( $atts ) {
	if ( wpex_is_front_end_composer() ) {
		return '<div class="vcex-no-posts-found">'. apply_filters( 'vcex_no_posts_found_message', __( 'No posts found for your query.', 'wpex' ) ) .'</div>';
	}
}

/**
 * Get Extra class
 *
 * @since 2.0.0
 */
function vcex_get_extra_class( $classes ) {
	if ( $classes ) {
		return str_replace( '.', '', $classes );
	}
}

/**
 * Echos unique ID html for VC modules
 *
 * @since 2.0.0
 */
function vcex_unique_id( $id ) {
	if ( ! $id ) {
		return;
	}
	echo vcex_html( 'id_attr', $id );
}

/**
 * Returns dummy image
 *
 * @since 2.0.0
 */
function vcex_dummy_image_url() {
	return get_template_directory_uri() .'/images/dummy-image.jpg';
}

/**
 * Outputs dummy image
 *
 * @since 2.0.0
 */
function vcex_dummy_image() {
	echo '<img src="'. get_template_directory_uri() .'/images/dummy-image.jpg" />';
}

/**
 * Used to enqueue styles for Visual Composer modules
 *
 * @since 2.0.0
 */
function vcex_enque_style( $type, $value = '' ) {

	// iLightbox
	if ( 'ilightbox' == $type ) {
		wpex_enqueue_ilightbox_skin( $value );
	}

	// Hover animation
	elseif ( 'hover-animations' == $type ) {
		wp_enqueue_style( 'wpex-hover-animations' );
	}

}

/**
 * Array of Icon box styles
 *
 * @since 2.0.0
 */
function vcex_icon_box_styles() {

	// Define array
	$array  = array(
		'one'   => __( 'Left Icon', 'wpex' ),
		'seven' => __( 'Right Icon', 'wpex' ),
		'two'   => __( 'Top Icon', 'wpex' ),
		'three' => __( 'Top Icon Style 2 - legacy', 'wpex' ),
		'four'  => __( 'Outlined & Top Icon - legacy', 'wpex' ),
		'five'  => __( 'Boxed & Top Icon - legacy', 'wpex' ),
		'six'   => __( 'Boxed & Top Icon Style 2 - legacy', 'wpex' ),
	);

	// Apply filters
	$array = apply_filters( 'vcex_icon_box_styles', $array );

	// Flip array around for use with VC
	$array = array_flip( $array ); 

	// Return array
	return $array;

}

/**
 * Array of orderby options
 *
 * @since 2.0.0
 */
function vcex_orderby_array() {
	return apply_filters( 'vcex_orderby', array(
		__( 'Default', 'wpex')             => '',
		__( 'Date', 'wpex')                => 'date',
		__( 'Title', 'wpex' )              => 'title',
		__( 'Name', 'wpex' )               => 'name',
		__( 'Modified', 'wpex')            => 'modified',
		__( 'Author', 'wpex' )             => 'author',
		__( 'Random', 'wpex')              => 'rand',
		__( 'Parent', 'wpex')              => 'parent',
		__( 'Type', 'wpex')                => 'type',
		__( 'ID', 'wpex' )                 => 'ID',
		__( 'Comment Count', 'wpex' )      => 'comment_count',
		__( 'Menu Order', 'wpex' )         => 'menu_order',
		__( 'Meta Key Value', 'wpex' )     => 'meta_value',
		__( 'Meta Key Value Num', 'wpex' ) => 'meta_value_num',
	) );
}

/**
 * Array of ilightbox skins
 *
 * @since 2.0.0
 */
function vcex_ilightbox_skins() {
	$skins = array(
		''  => __( 'Default', 'wpex' ),
	);
	$skins = array_merge( $skins, wpex_ilightbox_skins() );
	$skins = array_flip( $skins );
	return $skins;
}

/**
 * Border Radius Classname
 *
 * @since 1.4.0
 */
function vcex_get_border_radius_class( $val ) {
	if ( 'none' == $val || '' == $val ) {
		return;
	}
	return 'wpex-'. $val;
}

/**
 * Overlay options for the VC
 *
 * @since   1.4.0
 */
function vcex_overlays_array( $group = '', $style = 'default' ) {
	if ( ! function_exists( 'wpex_overlay_styles_array' ) ) {
		return;
	}
	$overlays = wpex_overlay_styles_array( $style );
	if ( ! is_array( $overlays ) ) {
		return;
	}
	$overlays   = array_flip( $overlays );
	$group      = ! empty( $group ) ? $group : __( 'Image', 'wpex' ); 
	return array(
		'type'          => 'dropdown',
		'heading'       => __( 'Image Overlay Style', 'wpex' ),
		'param_name'    => 'overlay_style',
		'value'         => $overlays,
		'group'         => $group,
	);
}

/**
 * Helper function for building links using link param
 *
 * @since 2.0.0
 */
function vcex_build_link( $link, $fallback = '' ) {

	// If empty return fallback
	if ( empty( $link ) ) {
		return $fallback;
	}

	// Return if there isn't any link
	if ( '||' == $link ) {
		return;
	}

	// Return simple link escaped (fallback for old textfield input)
	if ( false === strpos( $link, 'url:' ) ) {
		return esc_url( $link );
	}

	// Build link
	$link = vc_build_link( $link );

	// Return array of link data
	return $link;

}

/**
 * Returns link data
 *
 * @since 2.0.0
 */
function vcex_get_link_data( $return, $link, $fallback = '' ) {

	// Get data
	$link = vcex_build_link( $link, $fallback );

	if ( 'url' == $return ) {
		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			return $link['url'];
		} else {
			return $link;
		}
	}

	if ( 'title' == $return ) {
		if ( is_array( $link ) && ! empty( $link['title'] ) ) {
			return $link['title'];
		} else {
			return $fallback;
		}
	}

	if ( 'target' == $return ) {
		if ( is_array( $link ) && ! empty( $link['target'] ) ) {
			return $link['target'];
		} else {
			return $fallback;
		}
	}

}

/**
 * Helper function enqueues icon fonts from Visual Composer
 *
 * @since 2.0.0
 */
function vcex_enqueue_icon_font( $family = '' ) {

	// Return if VC function doesn't exist
	if ( ! function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
		return;
	}

	// Return if icon type is empty or it's fontawesome
	if ( empty( $family ) || 'fontawesome' == $family ) {
		return;
	}

	// Enqueue script
	vc_icon_element_fonts_enqueue( $family );

}

/**
 * Returns correct icon class based on icon type
 *
 * @since 2.0.0
 */
function vcex_get_icon_class( $atts, $icon_location ) {

	// Define vars
	$icon = '';
	$icon_type = ! empty( $atts['icon_type'] ) ? $atts['icon_type'] : 'fontawesome';

	// Generate fontawesome icon class
	if ( 'fontawesome' == $icon_type && ! empty( $atts[$icon_location] ) ) {
		$icon = $atts[$icon_location];
		$icon = str_replace( 'fa-', '', $icon );
		$icon = str_replace( 'fa ', '', $icon );
		$icon = 'fa fa-'. $icon;
	} elseif ( ! empty( $atts[ $icon_location .'_'. $icon_type ] ) ) {
		$icon = $atts[ $icon_location .'_'. $icon_type ];
	}

	// Sanitize
	$icon = in_array( $icon, array( 'icon', 'none' ) ) ? '' : $icon;

	// Return icon class
	return $icon;

}

/**
 * Adds inner row margin to compensate for the VC negative margins
 *
 * @since 2.0.0
 */
function vcex_offset_vc( $atts ) {

	// No offset added here
	if ( ! empty( $atts['full_width'] ) || ! empty( $atts['max_width'] ) ) {
		return;
	}

	// Get column spacing
	$spacing = ! empty( $atts['column_spacing'] ) ? $atts['column_spacing'] : '30';

	// Return if spacing set to 0px
	if ( '0px' == $spacing ) {
		return;
	}

	// Define offset class
	$classes = 'wpex-offset-vc-'. $spacing/2;

	// Check new CSS module
	if ( ! empty( $atts['css'] ) ) {
		if ( strpos( $atts['css'], 'background' )
			|| strpos( $atts['css'], 'border' )
		) {
			return $classes;
		}
	}

	// Check old modules for background or border
	elseif ( ! empty( $atts['center_row'] )
		|| ! empty( $atts['bg_image'] )
		|| ! empty( $atts['bg_color'] )
		|| ! empty( $atts['border_width'] )
	) {
		return $classes;
	}

}

/**
 * Outputs video row background
 *
 * @since 2.0.0
 */
if ( ! function_exists( 'vcex_row_video' ) ) {
	function vcex_row_video( $atts ) {

		// Extract attributes
		extract( $atts );

		// Return if video_bg is empty
		if ( empty( $video_bg ) && 'self_hosted' != $video_bg ) {
			return;
		}

		// Make sure videos are defined
		if ( ! $video_bg_webm && ! $video_bg_ogv && ! $video_bg_mp4 ) {
			return;
		}

		// Get background image
		$bg_image = ! empty( $bg_image ) ? $bg_image : '';

		// Check sound
		$sound = apply_filters( 'vcex_self_hosted_row_video_sound', false );
		$sound = $sound ? '' : 'muted volume="0"'; ?>

		<div class="wpex-video-bg-wrap">
			<video class="wpex-video-bg" poster="<?php echo $bg_image; ?>" preload="auto" autoplay="true" loop="loop" <?php echo $sound; ?>>
				<?php if ( $video_bg_webm ) { ?>
					<source src="<?php echo $video_bg_webm; ?>" type="video/webm" />
				<?php } ?>
				<?php if ( $video_bg_ogv ) { ?>
					<source src="<?php echo $video_bg_ogv; ?>" type="video/ogg ogv" />
				<?php } ?>
				<?php if ( $video_bg_mp4 ) { ?>
					<source src="<?php echo $video_bg_mp4; ?>" type="video/mp4" />
				<?php } ?>
			</video><!-- .wpex-video-bg -->
		</div><!-- .wpex-video-bg-wrap -->

		<?php
		// Video overlay
		if ( ! empty( $video_bg_overlay ) && 'none' != $video_bg_overlay ) { ?>

			<span class="wpex-video-bg-overlay <?php echo $video_bg_overlay; ?>"></span>

		<?php } ?>

	<?php
	}
}

/**
 * Outputs row parallax background
 *
 * @since 2.0.0
 */
if ( ! function_exists( 'vcex_parallax_bg' ) ) {

	function vcex_parallax_bg( $atts ) {

		// Extract attributes
		extract( $atts );

		// Make sure parallax is enabled
		if ( empty( $vcex_parallax ) ) {
			return;
		}

		// Return if a video is defined
		if ( ! empty( $video_bg ) && 'none' != $video_bg ) {
			return;
		}

		// Sanitize $bg_image
		$bg_image = ! empty( $atts['parallax_image'] ) ? wp_get_attachment_url( $atts['parallax_image'] ) : $bg_image;

		// Background image is obviously required
		if ( empty( $bg_image ) ) {
			return;
		}

		// Load inline js
		vcex_inline_js( array( 'parallax' ) );

		// Sanitize data
		$parallax_style     = ! empty( $parallax_style ) ? $parallax_style : 'fixed-no-repeat';
		$parallax_speed     = ! empty( $parallax_speed ) ? abs( $parallax_speed ) : '0.2';
		$parallax_direction = ! empty( $parallax_direction ) ? $parallax_direction : 'top';

		// Classes
		$classes = array( 'wpex-parallax-bg' );
		$classes[] = $parallax_style;
		if ( ! $parallax_mobile ) {
			 $classes[] = 'not-mobile';
		}
		$classes = apply_filters( 'wpex_parallax_classes', $classes );
		$classes = implode( ' ', $classes );

		// Add style
		$style = 'style="background-image: url('. $bg_image .');"';

		// Attributes
		$attributes = 'data-direction="'. $parallax_direction .'" data-velocity="-'. $parallax_speed .'"'; ?>

		<div class="<?php echo $classes; ?>" <?php echo $style; ?> <?php echo $attributes; ?>></div>

	<?php
	}

}

/**
 * Array of social links profiles to loop through
 *
 * @since 2.0.0
 */
function vcex_social_links_profiles() {

	// Create array of social profiles
	$profiles = array(
		'twitter'       => array(
			'label'         => 'Twitter',
			'icon_class'    => 'fa fa-twitter',
		),
		'facebook'      => array(
			'label'         => 'Facebook',
			'icon_class'    => 'fa fa-facebook',
		),
		'googleplus'    => array(
			'label'         => 'Google Plus',
			'icon_class'    => 'fa fa-google-plus',
		),
		'pinterest'     => array(
			'label'         => 'Pinterest',
			'icon_class'    => 'fa fa-pinterest',
		),
		'dribbble'      => array(
			'label'         => 'Dribbble',
			'icon_class'    => 'fa fa-dribbble',
		),
		'vk'            => array(
			'label'         => 'Vk',
			'icon_class'    => 'fa fa-vk',
		),
		'instagram'     => array(
			'label'         => 'Instragram',
			'icon_class'    => 'fa fa-instagram',
		),
		'linkedin'      => array(
			'label'         => 'LinkedIn',
			'icon_class'    => 'fa fa-linkedin',
		),
		'tumblr'        => array(
			'label'         => 'Tumblr',
			'icon_class'    => 'fa fa-tumblr',
		),
		'github'        => array(
			'label'         => 'Github',
			'icon_class'    => 'fa fa-github-alt',
		),
		'flickr'        => array(
			'label'         => 'Flickr',
			'icon_class'    => 'fa fa-flickr',
		),
		'skype'         => array(
			'label'         => 'Skype',
			'icon_class'    => 'fa fa-skype',
		),
		'youtube'       => array(
			'label'         => 'Youtube',
			'icon_class'    => 'fa fa-youtube',
		),
		'vimeo'         => array(
			'label'         => 'Vimeo',
			'icon_class'    => 'fa fa-vimeo-square',
		),
		'vine'          => array(
			'label'         => 'Vine',
			'icon_class'    => 'fa fa-vine',
		),
		'xing'          => array(
			'label'         => 'Xing',
			'icon_class'    => 'fa fa-xing',
		),
		'yelp'          => array(
			'label'         => 'Yelp',
			'icon_class'    => 'fa fa-yelp',
		),
		'email'         => array(
			'label'         => __( 'Email', 'wpex' ),
			'icon_class'    => 'fa fa-envelope',
		),
		'rss'           => array(
			'label'         => __( 'RSS', 'wpex' ),
			'icon_class'    => 'fa fa-rss',
		),
	);

	// Apply filters
	$profiles = apply_filters( 'vcex_social_links_profiles', $profiles );

	// Return profiles array
	return $profiles;

}

/**
 * Array of pixel icons
 *
 * @since 1.4.0
 */
if ( ! function_exists( 'vcex_pixel_icons' ) ) {
	function vcex_pixel_icons() {
		return array(
			array( 'vc_pixel_icon vc_pixel_icon-alert' => __( 'Alert', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-info' => __( 'Info', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-tick' => __( 'Tick', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-explanation' => __( 'Explanation', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-address_book' => __( 'Address book', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-alarm_clock' => __( 'Alarm clock', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-anchor' => __( 'Anchor', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-application_image' => __( 'Application Image', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-arrow' => __( 'Arrow', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-asterisk' => __( 'Asterisk', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-hammer' => __( 'Hammer', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-balloon' => __( 'Balloon', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-balloon_buzz' => __( 'Balloon Buzz', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-balloon_facebook' => __( 'Balloon Facebook', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-balloon_twitter' => __( 'Balloon Twitter', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-battery' => __( 'Battery', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-binocular' => __( 'Binocular', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-document_excel' => __( 'Document Excel', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-document_image' => __( 'Document Image', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-document_music' => __( 'Document Music', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-document_office' => __( 'Document Office', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-document_pdf' => __( 'Document PDF', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-document_powerpoint' => __( 'Document Powerpoint', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-document_word' => __( 'Document Word', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-bookmark' => __( 'Bookmark', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-camcorder' => __( 'Camcorder', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-camera' => __( 'Camera', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-chart' => __( 'Chart', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-chart_pie' => __( 'Chart pie', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-clock' => __( 'Clock', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-fire' => __( 'Fire', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-heart' => __( 'Heart', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-mail' => __( 'Mail', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-play' => __( 'Play', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-shield' => __( 'Shield', 'wpex' ) ),
			array( 'vc_pixel_icon vc_pixel_icon-video' => __( 'Video', 'wpex' ) ),
		);
	}
}

/**
 * Parses deprecated css fields into new css_editor field
 *
 * @since 3.0.0
 */
function vcex_parse_deprecated_row_css( $atts, $return = 'temp_class' ) {

	// Parse CSS if empty and enabled
	$parse_css = apply_filters( 'vcex_parse_deprecated_row_css', true );

	// Return if disabled
	if ( ! $parse_css ) {
		return;
	}

	$new_css = '';

	// Margin top
	if ( ! empty( $atts['margin_top'] ) ) {
		$new_css .= 'margin-top: '. wpex_sanitize_data( $atts['margin_top'], 'px-pct' ) .';';
	}

	// Margin bottom
	if ( ! empty( $atts['margin_bottom'] ) ) {
		$new_css .= 'margin-bottom: '. wpex_sanitize_data( $atts['margin_bottom'], 'px-pct' ) .';';
	}

	// Margin right
	if ( ! empty( $atts['margin_right'] ) ) {
		$new_css .= 'margin-right: '. wpex_sanitize_data( $atts['margin_right'], 'px-pct' ) .';';
	}

	// Margin left
	if ( ! empty( $atts['margin_left'] ) ) {
		$new_css .= 'margin-left: '. wpex_sanitize_data( $atts['margin_left'], 'px-pct' ) .';';
	}

	// Padding top
	if ( ! empty( $atts['padding_top'] ) ) {
		$new_css .= 'padding-top: '. wpex_sanitize_data( $atts['padding_top'], 'px-pct' ) .';';
	}

	// Padding bottom
	if ( ! empty( $atts['padding_bottom'] ) ) {
		$new_css .= 'padding-bottom: '. wpex_sanitize_data( $atts['padding_bottom'], 'px-pct' ) .';';
	}

	// Padding right
	if ( ! empty( $atts['padding_right'] ) ) {
		$new_css .= 'padding-right: '. wpex_sanitize_data( $atts['padding_right'], 'px-pct' ) .';';
	}

	// Padding left
	if ( ! empty( $atts['padding_left'] ) ) {
		$new_css .= 'padding-left: '. wpex_sanitize_data( $atts['padding_left'], 'px-pct' ) .';';
	}

	// Border
	if ( ! empty( $atts['border_width'] ) && ! empty( $atts['border_color'] ) ) {
		$border_width = explode( ' ', $atts['border_width'] );
		$border_style = isset( $atts['border_style'] ) ? $atts['border_style'] : 'solid';
		$bcount = count( $border_width );
		if ( '1' == $bcount ) {
			$new_css .= 'border: '. $border_width[0] . ' '. $border_style .' '. $atts['border_color'] .';';
		} else {
			$new_css .= 'border-color: '. $atts['border_color'] .';';
			$new_css .= 'border-style: '. $border_style .';';
			if ( '2' == $bcount ) {
				$new_css .= 'border-top-width: '. $border_width[0] .';';
				$new_css .= 'border-bottom-width: '. $border_width[0] .';';
				$bw = isset( $border_width[1] ) ? $border_width[1] : '0px';
				$new_css .= 'border-left-width: '. $bw .';';
				$new_css .= 'border-right-width: '. $bw .';';
			} else {
				$new_css .= 'border-top-width: '. $border_width[0] .';';
				$bw = isset( $border_width[1] ) ? $border_width[1] : '0px';
				$new_css .= 'border-right-width: '. $bw .';';
				$bw = isset( $border_width[2] ) ? $border_width[2] : '0px';
				$new_css .= 'border-bottom-width: '. $bw .';';
				$bw = isset( $border_width[3] ) ? $border_width[3] : '0px';
				$new_css .= 'border-left-width: '. $bw .';';
			}
		}
	}

	// Background image
	if ( ! empty( $atts['bg_image'] ) ) {
		if ( 'temp_class' == $return ) {
			$bg_image = wp_get_attachment_url( $atts['bg_image'] ) .'?id='. $atts['bg_image'];
		} elseif ( 'inline_css' == $return ) {
			if ( is_numeric( $atts['bg_image'] ) ) {
				$bg_image = wp_get_attachment_url( $atts['bg_image'] );
			} else {
				$bg_image = $atts['bg_image'];
			}
		}
	}

	// Background Image & Color
	if ( ! empty( $bg_image ) && ! empty( $atts['bg_color'] ) ) {
		$style = ! empty( $atts['bg_style'] ) ? $atts['bg_style'] : 'stretch';
		$position = '';
		$repeat   = '';
		$size     = '';
		if ( 'stretch' == $style ) {
			$position = 'center';
			$repeat   = 'no-repeat';
			$size     = 'cover';
		}
		if ( 'fixed' == $style ) {
			$position = '0 0';
			$repeat   = 'no-repeat';
		}
		if ( 'repeat' == $style ) {
			$position = '0 0';
			$repeat   = 'repeat';
		}
		$new_css .= 'background: '. $atts['bg_color'] .' url('. $bg_image .');';
		if ( $position ) {
			$new_css .= 'background-position: '. $position .';';
		}
		if ( $repeat ) {
			$new_css .= 'background-repeat: '. $repeat .';';
		}
		if ( $size ) {
			$new_css .= 'background-size: '. $size .';';
		}
	}

	// Background Image - No Color
	if ( ! empty( $bg_image ) && empty( $atts['bg_color'] ) ) {
		$new_css .= 'background-image: url('. $bg_image .');'; // Add image
		$style = ! empty( $atts['bg_style'] ) ? $atts['bg_style'] : 'stretch'; // Generate style
		$position = '';
		$repeat   = '';
		$size     = '';
		if ( 'stretch' == $style ) {
			$position = 'center';
			$repeat   = 'no-repeat';
			$size     = 'cover';
		}
		if ( 'fixed' == $style ) {
			$position = '0 0';
			$repeat   = 'no-repeat';
		}
		if ( 'repeat' == $style ) {
			$position = '0 0';
			$repeat   = 'repeat';
		}
		if ( $position ) {
			$new_css .= 'background-position: '. $position .';';
		}
		if ( $repeat ) {
			$new_css .= 'background-repeat: '. $repeat .';';
		}
		if ( $size ) {
			$new_css .= 'background-size: '. $size .';';
		}
	}

	// Background Color - No Image
	if ( ! empty( $atts['bg_color'] ) && empty( $bg_image ) ) {
		$new_css .= 'background-color: '. $atts['bg_color'] .';';
	}

	// Return new css
	if ( $new_css ) {
		if ( 'temp_class' == $return ) {
			return '.temp{'. $new_css .'}';
		} elseif ( 'inline_css' == $return ) {
			return $new_css;
		}
	}

}

/**
 * Fallback to prevent JS error - DO NOT REMOVE!!!!!!
 *
 * @since 2.0.0
 */
if ( ! function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
	function vc_icon_element_fonts_enqueue() {
	   return;
	}
}

/*-----------------------------------------------------------------------------------*/
/* - Deprecated Functions
/*-----------------------------------------------------------------------------------*/
function vcex_sanitize_data() {
	_deprecated_function( 'vcex_sanitize_data', '3.0.0', 'wpex_sanitize_data' );
}
function vcex_image_rendering() {
	return;
}