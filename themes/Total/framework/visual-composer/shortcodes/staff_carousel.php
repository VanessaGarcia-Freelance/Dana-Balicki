<?php
/**
 * Visual Composer Staff Carousel
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
class WPBakeryShortCode_vcex_staff_carousel extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_staff_carousel.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_staff_carousel_vc_map() {
	vc_map( array(
		'name' => __( 'Staff Carousel', 'wpex' ),
		'description' => __( 'Recent staff posts carousel', 'wpex' ),
		'base' => 'vcex_staff_carousel',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-staff-carousel vcex-icon fa fa-users',
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
				'heading' => __( 'Arrows?', 'wpex' ),
				'param_name' => 'arrows',
				'value' => array(
					__( 'True', 'wpex' ) => 'true',
					__( 'False', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Dots?', 'wpex' ),
				'param_name' => 'dots',
				'value' => array(
					__( 'False', 'wpex' ) => 'false',
					__( 'True', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Items To Display', 'wpex' ),
				'param_name' => 'items',
				'value' => '4',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Items To Scrollby', 'wpex' ),
				'param_name' => 'items_scroll',
				'value' => '1',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin Between Items', 'wpex' ),
				'param_name' => 'items_margin',
				'value' => '15',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Auto Play', 'wpex' ),
				'param_name' => 'auto_play',
				'value' => array(
					__( 'True', 'wpex' ) => 'true',
					__( 'False', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Infinite Loop', 'wpex' ),
				'param_name' => 'infinite_loop',
				'value' => array(
					__( 'True', 'wpex' )  => 'true',
					__( 'False', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Center Item', 'wpex' ),
				'param_name' => 'center',
				'value' => array(
					__( 'False', 'wpex' ) => 'false',
					__( 'True', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Animation Speed', 'wpex' ),
				'param_name' => 'animation_speed',
				'value' => 150,
				'description' => __( 'Default is 150 milliseconds. Enter 0.0 to disable.', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Timeout Duration in milliseconds', 'wpex' ),
				'param_name' => 'timeout_duration',
				'value' => 5000,
				'dependency' => array( 'element' => 'auto_play', 'value' => 'true' ),
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Post Count', 'wpex' ),
				'param_name' => 'count',
				'value' => '8',
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Offset', 'wpex' ),
				'param_name' => 'offset',
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'Number of post to displace or pass over. Warning: Setting the offset parameter overrides/ignores the paged parameter and breaks pagination. The offset parameter is ignored when posts per page is set to -1.', 'wpex' ),
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
					'groups' => true,
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
				'type'       => 'dropdown',
				'heading'    => __( 'Image Links To', 'wpex' ),
				'param_name' => 'thumbnail_link',
				'group'      => __( 'Image', 'wpex' ),
				'value'      => array(
					__( 'Default', 'wpex')      => '',
					__( 'Post', 'wpex')         => 'post',
					__( 'Lightbox', 'wpex' )    => 'lightbox',
					__( 'None', 'wpex' )        => 'none',
				),
			),
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
				'dependency' => array(
					'element' => 'img_size',
					'value' => 'wpex_custom',
				),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'dependency' => array(
					'element' => 'img_size',
					'value' => 'wpex_custom',
				),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'dependency' => array(
					'element' => 'img_size',
					'value' => 'wpex_custom',
				),
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Overlay Style', 'wpex' ),
				'param_name' => 'overlay_style',
				'value' => array_flip( wpex_overlay_styles_array() ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Button Text', 'wpex' ),
				'param_name' => 'overlay_button_text',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'overlay_style', 'value' => 'hover-button' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Excerpt Length', 'wpex' ),
				'param_name' => 'overlay_excerpt_length',
				'value' => '15',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'overlay_style', 'value' => 'title-excerpt-hover' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'CSS3 Image Link Hover', 'wpex' ),
				'param_name' => 'img_hover_style',
				'value' => array_flip( wpex_image_hovers() ),
				'group'            => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Filter', 'wpex' ),
				'param_name' => 'img_filter',
				'value' => array_flip( wpex_image_filters() ),
				'group' => __( 'Image', 'wpex' ),
			),
			// Title
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'title',
				'value' => array(
					__( 'Yes', 'wpex') => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Title', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_heading_color',
				'group' => __( 'Title', 'wpex' ),
				'description' => __( 'Select a custom color to override the default.', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_heading_size',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'content_heading_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Line Height', 'wpex' ),
				'param_name' => 'content_heading_line_height',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __(  'Font Weight', 'wpex' ),
				'param_name' => 'content_heading_weight',
				'group' => __( 'Title', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'content_heading_transform',
				'value' => array_flip( wpex_text_transforms() ),
				'group' => __( 'Title', 'wpex' ),
			),
			// Social
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'social_links',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Social', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'social_links_style',
				'std' => 'flat-color-round',
				'value' => array_flip( wpex_social_button_styles() ),
				'group' => __( 'Social', 'wpex' ),
				'dependency' => array( 'element' => 'social_links', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'social_links_size',
				'group' => __( 'Social', 'wpex' ),
				'dependency' => array( 'element' => 'social_links', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'social_links_margin',
				'group' => __( 'Social', 'wpex' ),
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'dependency' => array( 'element' => 'social_links', 'value' => 'true' ),
			),
			// Excerpt
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'excerpt',
				'value' => array(
					__( 'Yes', 'wpex') => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Excerpt', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Length', 'wpex' ),
				'param_name' => 'excerpt_length',
				'value' => '30',
				'description' => __( 'Enter how many words to display for the excerpt. To display the full post content enter "-1". To display the full post content up to the "more" tag enter "9999".', 'wpex' ),
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_font_size',
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_color',
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			// Design
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Default', 'wpex') => '',
					__( 'No Margins', 'wpex' ) => 'no-margins',
				),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Arrows?', 'wpex' ),
				'param_name' => 'arrows',
				'value' => array(
					__( 'True', 'wpex' ) => 'true',
					__( 'False', 'wpex' ) => 'false',
				),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Content Background', 'wpex' ),
				'param_name' => 'content_background',
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Content Alignment', 'wpex' ),
				'param_name' => 'content_alignment',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Left', 'wpex' )    => 'left',
					__( 'Right', 'wpex' )   => 'right',
					__( 'Center', 'wpex')   => 'center',
				),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Margin', 'wpex' ),
				'param_name' => 'content_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Padding', 'wpex' ),
				'param_name' => 'content_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Border', 'wpex' ),
				'param_name' => 'content_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Opacity', 'wpex' ),
				'param_name' => 'content_opacity',
				'description' => __( 'Enter a value between "0" and "1".', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
			// Mobile
			array(
				'type' => 'textfield',
				'heading' => __( 'Tablet: Items To Display', 'wpex' ),
				'param_name' => 'tablet_items',
				'value' => '3',
				'group' => __( 'Mobile', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Mobile Landscape: Items To Display', 'wpex' ),
				'param_name' => 'mobile_landscape_items',
				'value' => '2',
				'group' => __( 'Mobile', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Mobile Portrait: Items To Display', 'wpex' ),
				'param_name' => 'mobile_portrait_items',
				'value' => '1',
				'group' => __( 'Mobile', 'wpex' ),
			),

		),

	) );
}

// Map Shortcode
add_action( 'vc_before_init', 'vcex_staff_carousel_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_staff_carousel_include_categories_callback', 'vcex_suggest_staff_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_staff_carousel_exclude_categories_callback', 'vcex_suggest_staff_categories', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_staff_carousel_include_categories_render', 'vcex_render_staff_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_staff_carousel_exclude_categories_render', 'vcex_render_staff_categories', 10, 1 );