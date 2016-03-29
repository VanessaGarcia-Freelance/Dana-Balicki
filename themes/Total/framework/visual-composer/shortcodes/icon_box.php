<?php
/**
 * Visual Composer Icon Box
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
class WPBakeryShortCode_vcex_icon_box extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_icon_box.php' ) );
		return ob_get_clean();
	}
}

/**
 * Parse shortcode attributes and set correct values
 *
 * @since 2.0.0
 */
function parse_vcex_icon_box_atts( $atts ) {

	// Set font family if icon is defined
	if ( isset( $atts['icon'] ) && empty( $atts['icon_type'] ) ) {
		$atts['icon_type'] = 'fontawesome';
		$atts['icon'] = 'fa fa-'. $atts['icon'];
	}

	// Return $atts
	return $atts;
}
add_filter( 'vc_edit_form_fields_attributes_vcex_icon_box', 'parse_vcex_icon_box_atts' );

/**
 * Register the shortcode for use with the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_icon_box_vc_map() {
	vc_map( array(
		'name' => __( 'Icon Box', 'wpex' ),
		'base' => 'vcex_icon_box',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-icon-box vcex-icon fa fa-star',
		'description' => __( 'Content box with icon', 'wpex' ),
		'params' => array(
			// General
			array(
				'type' => 'textfield',
				'heading' => __( 'Unique Id', 'wpex' ),
				'param_name' => 'unique_id',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Classes', 'wpex' ),
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
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'value' => vcex_icon_box_styles(),
				'description' => __( 'For greater control select left, right or top icon styles then go to the "Design" tab to modify the icon box design.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Alignment', 'wpex' ),
				'param_name' => 'alignment',
				'dependency' => Array(
					'element' => 'style',
					'value' => array( 'two' ),
				),
				'value' => array(
					__( 'Default', 'wpex') => '',
					__( 'Center', 'wpex') => 'center',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Icon Bottom Margin', 'wpex' ),
				'param_name' => 'icon_bottom_margin',
				'dependency' => Array(
					'element' => 'style',
					'value' => array( 'two', 'three', 'four', 'five', 'six' ),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Container Left Padding', 'wpex' ),
				'param_name' => 'container_left_padding',
				'dependency' => Array( 'element' => 'style', 'value' => array( 'one' ) ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Container Right Padding', 'wpex' ),
				'param_name' => 'container_right_padding',
				'description' => __( 'Please enter a px value.', 'wpex' ),
				'dependency' => Array(
					'element' => 'style',
					'value' => array( 'seven' )
				),
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
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'font_size',
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'font_color',
				'group' => __( 'Content', 'wpex' ),
			),
			// Heading
			array(
				'type' => 'textfield',
				'heading' => __( 'Heading', 'wpex' ),
				'param_name' => 'heading',
				'std' => 'Sample Heading',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'heading_color',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Type', 'wpex' ),
				'param_name' => 'heading_type',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'div' => 'div',
					'span' => 'span',
				),
				'group' => __( 'Heading', 'wpex' ),
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
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'heading_weight',
				'value' => array_flip( wpex_font_weights() ),
				'std' => '',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'heading_transform',
				'std' => '',
				'group' => __( 'Heading', 'wpex' ),
				'value' => array_flip( wpex_text_transforms() ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'heading_size',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Letter Spacing', 'wpex' ),
				'param_name' => 'heading_letter_spacing',
				'group' => __( 'Heading', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Bottom Margin', 'wpex' ),
				'param_name' => 'heading_bottom_margin',
				'group' => __( 'Heading', 'wpex' ),
			),
			// Icon
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'wpex' ),
				'param_name' => 'icon_type',
				'description' => __( 'Select icon library.', 'wpex' ),
				'value' => array(
					__( 'Font Awesome', 'wpex' ) => 'fontawesome',
					__( 'Open Iconic', 'wpex' ) => 'openiconic',
					__( 'Typicons', 'wpex' ) => 'typicons',
					__( 'Entypo', 'wpex' ) => 'entypo',
					__( 'Linecons', 'wpex' ) => 'linecons',
					__( 'Pixel', 'wpex' ) => 'pixelicons',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'wpex' ),
				'param_name' => 'icon',
				'value' => 'fa fa-info-circle',
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'fontawesome',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'wpex' ),
				'param_name' => 'icon_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'wpex' ),
				'param_name' => 'icon_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'wpex' ),
				'param_name' => 'icon_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'wpex' ),
				'param_name' => 'icon_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'wpex' ),
				'param_name' => 'icon_pixelicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'pixelicons',
					'source' => vcex_pixel_icons(),
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'pixelicons',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Icon Font Alternative Classes', 'wpex' ),
				'param_name' => 'icon_alternative_classes',
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'icon_color',
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'icon_background',
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'icon_size',
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'icon_border_radius',
				'description' => __( 'For a circle enter 50%.', 'wpex' ),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Width', 'wpex' ),
				'param_name' => 'icon_width',
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'wpex' ),
				'param_name' => 'icon_height',
				'group' => __( 'Icon', 'wpex' ),
			),
			// Icon
			array(
				'type' => 'attach_image',
				'heading' => __( 'Icon Image Alternative', 'wpex' ),
				'param_name' => 'image',
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Icon Image Alternative Width', 'wpex' ),
				'param_name' => 'image_width',
				'group' => __( 'Image', 'wpex' ),
			),
			// URL
			array(
				'type' => 'textfield',
				'heading' => __( 'URL', 'wpex' ),
				'param_name' => 'url',
				'group' => __( 'URL', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'URL Target', 'wpex' ),
				'param_name' => 'url_target',
				 'value' => array(
					__( 'Self', 'wpex' ) => 'self',
					__( 'Blank', 'wpex' ) => '_blank',
					__( 'Local', 'wpex' ) => 'local',
				),
				'group' => __( 'URL', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'URL Rel', 'wpex' ),
				'param_name' => 'url_rel',
				'value' => array(
					__( 'None', 'wpex' ) => '',
					__( 'Nofollow', 'wpex' ) => 'nofollow',
				),
				'group' => __( 'URL', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link Container Wrap', 'wpex' ),
				'param_name' => 'url_wrap',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'URL', 'wpex' ),
				'description' => __( 'Apply the link to the entire wrapper?', 'wpex' ),
			),
			// Design
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'description' => __( 'If any of these are defined it will add a new wrapper around your icon box with the custom CSS applied to it.', 'wpex' ),
				'group' => __( 'CSS', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'border_radius',
				'group' => __( 'CSS', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background: Hover', 'wpex' ),
				'param_name' => 'hover_background',
				'description' => __( 'Will add a hover background color to your entire icon box or replace the current hover color for specific icon box styles.', 'wpex' ),
				'group' => __( 'CSS', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'White Text On Hover', 'wpex' ),
				'param_name' => 'hover_white_text',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'CSS', 'wpex' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_icon_box_vc_map' );