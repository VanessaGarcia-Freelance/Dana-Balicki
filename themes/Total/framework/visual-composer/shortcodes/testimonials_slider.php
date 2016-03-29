<?php
/**
 * Registers the testimonials slider shortcode and adds it to the Visual Composer
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.0.0
 */
class WPBakeryShortCode_vcex_testimonials_slider extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_testimonials_slider.php' ) );
		return ob_get_clean();
	}
}

/**
 * Parse old shortcode attributes
 *
 * @since 2.0.0
 */
function parse_vcex_testimonials_slider_atts( $atts ) {
	if ( ! empty( $atts['animation'] ) && 'fade' == $atts['animation'] ) {
		$atts['animation'] = 'fade_slides';
	}
	return $atts;
}
add_filter( 'vc_edit_form_fields_attributes_vcex_testimonials_slider', 'parse_vcex_testimonials_slider_atts' );

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_testimonials_slider_vc_map() {
	vc_map( array(
		'name' => __( 'Testimonials Slider', 'wpex' ),
		'description' => __( 'Recent testimonials slider', 'wpex' ),
		'base' => 'vcex_testimonials_slider',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-testimonials-slider vcex-icon fa fa-comments-o',
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
			array(
				'type' => 'dropdown',
				'heading' => __( 'Appear Animation', 'wpex'),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Author Name?', 'wpex' ),
				'param_name' => 'display_author_name',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'yes',
					__( 'No', 'wpex' ) => 'no',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Author Company?', 'wpex' ),
				'param_name' => 'display_author_company',
				'value' => array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			// Slider Settings
			array(
				'type' => 'dropdown',
				'heading' => __( 'Animation', 'wpex' ),
				'param_name' => 'animation',
				'std' => 'fade_slides',
				'value' => array(
					__( 'Fade', 'wpex' ) => 'fade_slides',
					__( 'Slide', 'wpex' ) => 'slide',
				),
				'group' => __( 'Slider Settings', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Loop', 'wpex' ),
				'param_name' => 'loop',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Slider Settings', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Auto Height Animation', 'wpex' ),
				'std' => 400,
				'param_name' => 'height_animation',
				'group' => __( 'Slider Settings', 'wpex' ),
				'description' => __( 'You can enter "0.0" to disable the animation completely.', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Animation Speed', 'wpex' ),
				'param_name' => 'animation_speed',
				'std' => 600,
				'description' => __( 'Enter a value in milliseconds.', 'wpex' ),
				'group' => __( 'Slider Settings', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Auto Play', 'wpex' ),
				'param_name' => 'slideshow',
				'description' => __( 'Enable automatic slideshow? Disabled in front-end composer to prevent page "jumping".', 'wpex' ),
				'group' => __( 'Slider Settings', 'wpex' ),
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Auto Play Delay', 'wpex' ),
				'param_name' => 'slideshow_speed',
				'std' => 5000,
				'description' => __( 'Enter a value in milliseconds.', 'wpex' ),
				'group' => __( 'Slider Settings', 'wpex' ),
				'dependency' => Array( 'element' => 'slideshow', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Dot Navigation', 'wpex' ),
				'param_name' => 'control_nav',
				'group' => __( 'Slider Settings', 'wpex' ),
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Arrows', 'wpex' ),
				'param_name' => 'direction_nav',
				'group' => __( 'Slider Settings', 'wpex' ),
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Posts Count', 'wpex' ),
				'param_name' => 'count',
				'value' => 3,
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Include Categories', 'wpex' ),
				'param_name' => 'include_categories',
				'param_holder_class' => 'vc_not-for-custom',
				'admin_label' => true,
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Exclude Categories', 'wpex' ),
				'param_name' => 'exclude_categories',
				'param_holder_class' => 'vc_not-for-custom',
				'admin_label' => true,
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => false,
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
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'display_author_avatar',
				'group' => __( 'Image', 'wpex' ),
				'value' => array(
					__( 'Yes', 'wpex' ) => 'yes',
					__( 'No', 'wpex' ) => 'no',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'img_border_radius',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => Array( 'element' => 'display_author_avatar', 'value' => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'wpex_custom',
				'value' => vcex_image_sizes(),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => Array( 'element' => 'display_author_avatar', 'value' => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Crop Location', 'wpex' ),
				'param_name' => 'img_crop',
				'std' => 'center-center',
				'value' => array_flip( wpex_image_crop_locations() ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => Array( 'element' => 'display_author_avatar', 'value' => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'description' => __( 'Enter a width in pixels.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			// Thumbnails
			array(
				'type' => 'dropdown',
				'heading' => __( 'Thumbnails', 'wpex' ),
				'param_name' => 'control_thumbs',
				'group' => __( 'Thumbnails', 'wpex' ),
				'value' => array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'true'
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Navigation Thumbnails Height', 'wpex' ),
				'param_name' => 'control_thumbs_height',
				'std' => 50,
				'group' => __( 'Thumbnails', 'wpex' ),
				'dependency' => Array( 'element' => 'control_thumbs', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Navigation Thumbnails Width', 'wpex' ),
				'param_name' => 'control_thumbs_width',
				'std' => 50,
				'group' => __( 'Thumbnails', 'wpex' ),
				'dependency' => Array( 'element' => 'control_thumbs', 'value' => 'true' ),
			),
			// Excerpts
			array(
				'type' => 'dropdown',
				'heading' => __( 'Excerpt', 'wpex' ),
				'param_name' => 'excerpt',
				'group' => __( 'Excerpt', 'wpex' ),
				'value' => array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Excerpt Length', 'wpex' ),
				'param_name' => 'excerpt_length',
				'value' => 20,
				'description' => __( 'Enter a custom excerpt length. Will trim the excerpt by this number of words. Enter "-1" to display the_content instead of the auto excerpt.', 'wpex' ),
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => Array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Read More', 'wpex' ),
				'param_name' => 'read_more',
				'group' => __( 'Excerpt', 'wpex' ),
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'dependency' => Array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Read More Text', 'wpex' ),
				'param_name' => 'read_more_text',
				'group' => __( 'Excerpt', 'wpex' ),
				'value' => __( 'read more', 'wpex' ),
				'dependency' => Array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			// CSS
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Skin', 'wpex' ),
				'param_name' => 'skin',
				'group' => __( 'Design', 'wpex' ),
				'value' => array(
					__( 'Dark Text', 'wpex' ) => 'dark',
					__( 'Light Text', 'wpex' ) => 'light',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'font_size',
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'font_weight',
				'group' => __( 'Design', 'wpex' ),
				'description' => __( 'Note: Not all font families support every font weight.', 'wpex' ),
				'value' => array_flip( wpex_font_weights() ),
				'std' => '',
			),

		),
	) );
}
// Map shortcode
add_action( 'vc_before_init', 'vcex_testimonials_slider_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_testimonials_slider_include_categories_callback', 'vcex_suggest_testimonials_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_testimonials_slider_exclude_categories_callback', 'vcex_suggest_testimonials_categories', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_testimonials_slider_include_categories_render', 'vcex_render_testimonials_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_testimonials_slider_exclude_categories_render', 'vcex_render_testimonials_categories', 10, 1 );