<?php
/**
 * Visual Composer Post Type Slider
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.0.0
 */
class WPBakeryShortCode_vcex_post_type_flexslider extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_post_type_flexslider.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_post_type_flexslider_vc_map() {
	vc_map( array(
		'name' => __( 'Post Types Slider', 'wpex' ),
		'description' => __( 'Recent posts slider', 'wpex' ),
		'base' => 'vcex_post_type_flexslider',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-post-type-slider vcex-icon fa fa-files-o',
		'params' => array(
			// General
			array(
				'type' => 'textfield',
				'heading' => __( 'Unique Id', 'wpex' ),
				'param_name' => 'unique_id',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Classes', 'wpex' ),
				'param_name' => 'classes',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
			),
			// Slider Settings
			array(
				'type' => 'dropdown',
				'heading' => __( 'Randomize', 'wpex' ),
				'param_name' => 'randomize',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Animation', 'wpex' ),
				'param_name' => 'animation',
				'value' => array(
					__( 'Fade', 'wpex' ) => 'fade_slides',
					__( 'Slide', 'wpex' ) => 'slide',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Loop', 'wpex' ),
				'param_name' => 'loop',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Auto Height Animation', 'wpex' ),
				'std' => '500',
				'param_name' => 'height_animation',
				'description' => __( 'You can enter "0.0" to disable the animation completely.', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Animation Speed', 'wpex' ),
				'param_name' => 'animation_speed',
				'std' => '600',
				'description' => __( 'Enter a value in milliseconds.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Auto Play', 'wpex' ),
				'param_name' => 'slideshow',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'description' => __( 'Enable automatic slideshow? Disabled in front-end composer to prevent page "jumping".', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Auto Play Delay', 'wpex' ),
				'param_name' => 'slideshow_speed',
				'std' => '5000',
				'description' => __( 'Enter a value in milliseconds.', 'wpex' ),
				'dependency' => Array( 'element' => 'slideshow', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Arrows', 'wpex' ),
				'param_name' => 'direction_nav',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Arrows on Hover', 'wpex' ),
				'param_name' => 'direction_nav_hover',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'dependency' => Array( 'element' => 'arrows', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Dot Navigation', 'wpex' ),
				'param_name' => 'control_nav',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Thumbnails', 'wpex' ),
				'param_name' => 'control_thumbs',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Thumbnails Pointer', 'wpex' ),
				'param_name' => 'control_thumbs_pointer',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'dependency' => Array( 'element' => 'control_thumbs', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Navigation Thumbnails Height', 'wpex' ),
				'param_name' => 'control_thumbs_height',
				'std' => '70',
				'dependency' => Array( 'element' => 'control_thumbs', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Navigation Thumbnails Width', 'wpex' ),
				'param_name' => 'control_thumbs_width',
				'std' => '70',
				'dependency' => Array( 'element' => 'control_thumbs', 'value' => 'true' ),
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Count', 'wpex' ),
				'param_name' => 'posts_per_page',
				'value' => '4',
				'description' => __( 'You can enter "-1" to display all posts.', 'wpex' ),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'posttypes',
				'heading' => __( 'Post types', 'wpex' ),
				'param_name' => 'post_types',
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Limit By Post ID\'s', 'wpex' ),
				'param_name' => 'posts_in',
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'Seperate by a comma.', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Limit By Author', 'wpex' ),
				'param_name' => 'author_in',
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
					//'values' => vcex_get_users(),
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Query by Taxonomy', 'wpex' ),
				'param_name' => 'tax_query',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex') => 'true',
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Taxonomy Name', 'wpex' ),
				'param_name' => 'tax_query_taxonomy',
				'dependency' => array( 'element' => 'tax_query', 'value' => 'true' ),
				'settings' => array(
					'multiple' => false,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 500,
					'auto_focus' => true,
					//'values' => vcex_get_taxonomies(),
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Terms', 'wpex' ),
				'param_name' => 'tax_query_terms',
				'dependency' => array( 'element' => 'tax_query', 'value' => 'true' ),
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => true,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order', 'wpex' ),
				'param_name' => 'order',
				'group' => __( 'Query', 'wpex' ),
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'DESC', 'wpex' ) => 'DESC',
					__( 'ASC', 'wpex' ) => 'ASC',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order By', 'wpex' ),
				'param_name' => 'orderby',
				'value' => vcex_orderby_array(),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Orderby: Meta Key', 'wpex' ),
				'param_name' => 'orderby_meta_key',
				'group' => __( 'Query', 'wpex' ),
				'dependency' => array(
					'element' => 'orderby',
					'value' => array( 'meta_value_num', 'meta_value' ),
				),
			),
			// Image
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'wpex_custom',
				'value' => vcex_image_sizes(),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Crop Location', 'wpex' ),
				'param_name' => 'img_crop',
				'std' => 'center-center',
				'value' => array_flip( wpex_image_crop_locations() ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' )
			),
			// Caption
			array(
				'type' => 'dropdown',
				'heading' => __( 'Caption', 'wpex' ),
				'param_name' => 'caption',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Caption', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Caption Visibility', 'wpex' ),
				'param_name' => 'caption_visibility',
				'value' => array_flip( wpex_visibility() ),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Caption Location', 'wpex' ),
				'param_name' => 'caption_location',
				'value' => array(
					__( 'Over Image', 'wpex' ) => 'over-image',
					__( 'Under Image', 'wpex' ) => 'under-image',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title', 'wpex' ),
				'param_name' => 'title',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Meta', 'wpex' ),
				'param_name' => 'meta',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Excerpt', 'wpex' ),
				'param_name' => 'excerpt',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Excerpt Length', 'wpex' ),
				'param_name' => 'excerpt_length',
				'value' => '40',
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			// Design
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'Design', 'wpex' ),
			),

		),
		
	) );
}
// IMPORTANT: Needs to run on init to get post types and taxonomies
add_action( 'init', 'vcex_post_type_flexslider_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_post_type_flexslider_tax_query_taxonomy_callback', 'vcex_suggest_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_flexslider_tax_query_terms_callback', 'vcex_suggest_terms', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_flexslider_author_in_callback', 'vcex_suggest_users', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_post_type_flexslider_tax_query_taxonomy_render', 'vcex_render_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_flexslider_tax_query_terms_render', 'vcex_render_terms', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_flexslider_author_in_render', 'vcex_render_users', 10, 1 );