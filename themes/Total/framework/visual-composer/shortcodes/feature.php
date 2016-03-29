<?php
/**
 * Visual Composer Feature Box
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
class WPBakeryShortCode_vcex_feature_box extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_feature_box.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_feature_box_vc_map() {
	vc_map( array(
		'name' => __( 'Feature Box', 'wpex' ),
		'description' => __( 'A feature content box', 'wpex' ),
		'base' => 'vcex_feature_box',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-feature-box vcex-icon fa fa-trophy',
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
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Left Content - Right Image', 'wpex' ) => 'left-content-right-image',
					__( 'Left Image - Right Content', 'wpex' ) => 'left-image-right-content',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Alignment', 'wpex' ),
				'param_name' => 'text_align',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Center', 'wpex' ) => 'center',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border', 'wpex' ),
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'param_name' => 'border',
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'background',
			),
			// Heading
			array(
				'type' => 'textfield',
				'heading' => __( 'Heading', 'wpex' ),
				'param_name' => 'heading',
				'value' => 'Sample Heading',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'HTML Tag', 'wpex' ),
				'param_name' => 'heading_type',
				'group' => __( 'Heading', 'wpex' ),
				'value' => array(
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					__( 'h5', 'wpex' ) => 'h5',
					'div' => 'div',
				),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Link', 'wpex' ),
				'param_name' => 'heading_url',
				'group' => __( 'Heading', 'wpex' ),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			array(
				'type'  => 'dropdown',
				'heading' => __( 'Font Family', 'wpex' ),
				'param_name' => 'heading_font_family',
				'std' => '',
				'value' => vcex_fonts_array(),
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Heading Color', 'wpex' ),
				'param_name' => 'heading_color',
				'group' => __( 'Heading', 'wpex' ),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'heading_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Heading', 'wpex' ),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Heading Text Transform', 'wpex' ),
				'param_name' => 'heading_transform',
				'group' => __( 'Heading', 'wpex' ),
				'value' => array_flip( wpex_text_transforms() ),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'heading_size',
				'group' => __( 'Heading', 'wpex' ),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Letter Spacing', 'wpex' ),
				'param_name' => 'heading_letter_spacing',
				'group' => __( 'Heading', 'wpex' ),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'heading_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Heading', 'wpex' ),
				'dependency' => array( 'element' => 'heading', 'not_empty' => true ),
			),
			// Content
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __( 'Content', 'wpex' ),
				'param_name' => 'content',
				'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'content_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Content', 'wpex' ),
				'dependency' => array( 'element' => 'content', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_font_size',
				'group' => __( 'Content', 'wpex' ),
				'dependency' => array( 'element' => 'content', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'content_font_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Content', 'wpex' ),
				'dependency' => array( 'element' => 'content', 'not_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'content_background',
				'group' => __( 'Content', 'wpex' ),
				'dependency' => array( 'element' => 'content', 'not_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_color',
				'group' => __( 'Content', 'wpex' ),
				'dependency' => array( 'element' => 'content', 'not_empty' => true ),
			),
			// Image
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'wpex' ),
				'param_name' => 'image',
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Equal Heights?', 'wpex' ),
				'param_name' => 'equal_heights',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'description' => __( 'Keeps the image column the same height as your content.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Image URL', 'wpex' ),
				'param_name' => 'image_url',
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Type', 'wpex' ),
				'param_name' => 'image_lightbox',
				'group' => __( 'Image', 'wpex' ),
				'value' => array(
					__( 'None', 'wpex' ) => '',
					__( 'Self', 'wpex' ) => 'image',
					__( 'URL', 'wpex' ) => 'url',
					__( 'Auto Detect - slow', 'wpex' ) => 'auto-detect',
					__( 'Video', 'wpex' ) => 'video_embed',
					__( 'HTML5', 'wpex' ) => 'html5',
					__( 'Quicktime', 'wpex' ) => 'quicktime',
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
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Width', 'wpex' ),
				'param_name' => 'img_width',
				'description' => __( 'Enter a width in pixels.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'img_border_radius',
				'description' => __( 'Please enter a px value.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'image', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'CSS3 Image Hover', 'wpex' ),
				'param_name' => 'img_hover_style',
				'value' => array_flip( wpex_image_hovers() ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'image', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Filter', 'wpex' ),
				'param_name' => 'img_filter',
				'value' => array_flip( wpex_image_filters() ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'image', 'not_empty' => true ),
			),
			// Video
			array(
				'type' => 'textfield',
				'heading' => __( 'Video link', 'wpex' ),
				'param_name' => 'video',
				'description' => __('Enter a URL that is compatible with WP\'s built-in oEmbed feature. ', 'wpex' ),
				'group' => __( 'Video', 'wpex' ),
			),
			// Widths
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Width', 'wpex' ),
				'param_name' => 'content_width',
				'value' => '50%',
				'group' => __( 'Widths', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Width', 'wpex' ),
				'param_name' => 'media_width',
				'value' => '50%',
				'group' => __( 'Widths', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Tablet Widths', 'wpex' ),
				'param_name' => 'tablet_widths',
				'group' => __( 'Widths', 'wpex' ),
				'value' => array(
					__( 'Inherit', 'wpex' ) => '',
					__( 'Full-Width', 'wpex' ) => 'fullwidth',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Phone Widths', 'wpex' ),
				'param_name' => 'phone_widths',
				'group' => __( 'Widths', 'wpex' ),
				'value' => array(
					__( 'Inherit', 'wpex' ) => '',
					__( 'Full-Width', 'wpex' ) => 'fullwidth',
				),
			),

		)
	) );
}
add_action( 'vc_before_init', 'vcex_feature_box_vc_map' );