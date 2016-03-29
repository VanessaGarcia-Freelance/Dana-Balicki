<?php
/**
 * Visual Composer Teaser
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
class WPBakeryShortCode_vcex_teaser extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_teaser.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_teaser_shortcode_vc_map() {
	vc_map( array(
		'name' => __( 'Teaser Box', 'wpex' ),
		'description' => __( 'A teaser content box', 'wpex' ),
		'base' => 'vcex_teaser',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-teaser vcex-icon fa fa-file-text-o',
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
				'heading' => __( 'Hover Animation', 'wpex'),
				'param_name' => 'hover_animation',
				'value' => array_flip( wpex_hover_css_animations() ),
				'std' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Align', 'wpex' ),
				'param_name' => 'text_align',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Center', 'wpex' ) => 'center',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Plain', 'wpex' ) => 'one',
					__( 'Boxed 1 - Legacy', 'wpex' ) => 'two',
					__( 'Boxed 2 - Legacy', 'wpex' ) => 'three',
					__( 'Outline - Legacy', 'wpex' ) => 'four',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'dependency' => array( 'element' => 'style', 'value' => 'two' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background Color', 'wpex' ),
				'param_name' => 'background',
				'dependency' => array( 'element' => 'style', 'value' => array( 'two', 'three' ) ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Border Color', 'wpex' ),
				'param_name' => 'border_color',
				'dependency' => array( 'element' => 'style', 'value' => array( 'two', 'three', 'four' ) ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'border_radius',
				'dependency' => array( 'element' => 'style', 'value' => array( 'two', 'three', 'four' ) ),
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
				'type' => 'colorpicker',
				'heading' => __( 'Heading Color', 'wpex' ),
				'param_name' => 'heading_color',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Heading Type', 'wpex' ),
				'param_name' => 'heading_type',
				'group' => __( 'Heading', 'wpex' ),
				'value' => array(
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'div' => 'div',
				),
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
				'type' => 'dropdown',
				'heading' => __( 'Heading Font Weight', 'wpex' ),
				'param_name' => 'heading_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Heading Text Transform', 'wpex' ),
				'param_name' => 'heading_transform',
				'group' => __( 'Heading', 'wpex' ),
				'value' => array_flip( wpex_text_transforms() ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Heading Font Size', 'wpex' ),
				'param_name' => 'heading_size',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Heading Margin', 'wpex' ),
				'param_name' => 'heading_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Heading Letter Spacing', 'wpex' ),
				'param_name' => 'heading_letter_spacing',
				'group' => __( 'Heading', 'wpex' ),
			),
			// Content
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __( 'Content', 'wpex' ),
				'param_name' => 'content',
				'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed faucibus feugiat convallis. Integer nec eros et risus condimentum tristique vel vitae arcu.',
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Margin', 'wpex' ),
				'param_name' => 'content_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Padding', 'wpex' ),
				'param_name' => 'content_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Font Size', 'wpex' ),
				'param_name' => 'content_font_size',
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Content Font Weight', 'wpex' ),
				'param_name' => 'content_font_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Content Font Color', 'wpex' ),
				'param_name' => 'content_color',
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Content Background', 'wpex' ),
				'param_name' => 'content_background',
				'group' => __( 'Content', 'wpex' ),
			),
			// Media
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'wpex' ),
				'param_name' => 'image',
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Video link', 'wpex' ),
				'param_name' => 'video',
				'description' => __( 'Enter in a video URL that is compatible with WordPress\'s built-in oEmbed feature.', 'wpex' ),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Style', 'wpex' ),
				'param_name' => 'img_style',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Stretch', 'wpex' ) => 'stretch',
				),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Filter', 'wpex' ),
				'param_name' => 'img_filter',
				'value' => array_flip( wpex_image_filters() ),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'CSS3 Image Hover', 'wpex' ),
				'param_name' => 'img_hover_style',
				'value' => array_flip( wpex_image_hovers() ),
				'group' => __( 'Media', 'wpex' ),
			),
			// Link
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL', 'wpex' ),
				'param_name' => 'url',
				'group' => __( 'Link', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link: Local Scroll', 'wpex' ),
				'param_name' => 'url_local_scroll',
				'group' => __( 'Link', 'wpex' ),
				'value' => array(
					__( 'False', 'wpex' ) => '',
					__( 'True', 'wpex' ) => 'true',
				),
			),
			// CSS
			array(
				'type' => 'css_editor',
				'heading' => __( 'Design', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'Design', 'wpex' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_teaser_shortcode_vc_map' );