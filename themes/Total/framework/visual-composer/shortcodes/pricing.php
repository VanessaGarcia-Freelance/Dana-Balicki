<?php
/**
 * Visual Composer Pricing
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
class WPBakeryShortCode_vcex_pricing extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_pricing.php' ) );
		return ob_get_clean();
	}
}

/**
 * Parse shortcode attributes and set correct values
 *
 * @since 2.0.0
 */
function parse_vcex_pricing_atts( $atts ) {

	// Convert textfield link to vc_link
	if ( ! empty( $atts['button_url'] ) && false === strpos( $atts['button_url'], 'url:' ) ) {
		$url = 'url:'. $atts['button_url'] .'|';
		$atts['button_url'] = $url;
	}

	// Return $atts
	return $atts;
}
add_filter( 'vc_edit_form_fields_attributes_vcex_pricing', 'parse_vcex_pricing_atts' );

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since Total 1.4.1
 */
function vcex_pricing_shortcode_vc_map() {
	vc_map( array(
		'name' => __( 'Pricing Table', 'wpex' ),
		'description' => __( 'Insert a pricing column', 'wpex' ),
		'base' => 'vcex_pricing',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-pricing vcex-icon fa fa-usd',
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
				'param_name' => 'el_class',
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
			),
			// Plan
			array(
				'type' => 'dropdown',
				'heading' => __( 'Featured', 'wpex' ),
				'param_name' => 'featured',
				'value' => array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex') => 'yes',
				),
				'group' => __( 'Plan', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Plan', 'wpex' ),
				'param_name' => 'plan',
				'group' => __( 'Plan', 'wpex' ),
				'std' => __( 'Basic', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'plan_background',
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'plan_color',
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'plan_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'plan_text_transform',
				'std' => '',
				'value' => array_flip( wpex_text_transforms() ),
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'plan_size',
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Letter Spacing', 'wpex' ),
				'param_name' => 'plan_letter_spacing',
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
				'description' => __( 'Please enter a px value.', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'plan_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'plan_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border', 'wpex' ),
				'param_name' => 'plan_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Plan', 'wpex' ),
				'dependency' => Array( 'element' => 'plan', 'not_empty' => true ),
			),
			// Cost
			array(
				'type' => 'textfield',
				'heading' => __( 'Cost', 'wpex' ),
				'param_name' => 'cost',
				'group' => __( 'Cost', 'wpex' ),
				'std' => '$20',
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'cost_background',
				'group' => __( 'Cost', 'wpex' ),
				'dependency' => Array( 'element' => 'cost', 'not_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'cost_color',
				'group' => __( 'Cost', 'wpex' ),
				'dependency' => Array( 'element' => 'cost', 'not_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'cost_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Cost', 'wpex' ),
				'dependency' => Array( 'element' => 'cost', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'cost_size',
				'group' => __( 'Cost', 'wpex' ),
				'dependency' => Array( 'element' => 'cost', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'cost_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Cost', 'wpex' ),
				'dependency' => Array( 'element' => 'cost', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border', 'wpex' ),
				'param_name' => 'cost_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Cost', 'wpex' ),
				'dependency' => Array( 'element' => 'cost', 'not_empty' => true ),
			),
			// Per
			array(
				'type' => 'textfield',
				'heading' => __( 'Per', 'wpex' ),
				'param_name' => 'per',
				'group' => __( 'Per', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display', 'wpex' ),
				'param_name' => 'per_display',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Inline', 'wpex' ) => 'inline',
					__( 'Block', 'wpex' ) => 'block',
					__( 'Inline-Block', 'wpex' ) => 'inline-block',
				),
				'group' => __( 'Per', 'wpex' ),
				'dependency' => Array(
					'element' => 'per',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'per_color',
				'group' => __( 'Per', 'wpex' ),
				'dependency' => Array(
					'element' => 'per',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'per_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Per', 'wpex' ),
				'dependency' => Array(
					'element' => 'per',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'per_transform',
				'group' => __( 'Per', 'wpex' ),
				'value' => array_flip( wpex_text_transforms() ),
				'dependency' => Array(
					'element' => 'per',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'per_size',
				'group' => __( 'Per', 'wpex' ),
				'dependency' => Array(
					'element' => 'per',
					'not_empty' => true,
				),
			),
			// Features
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Features', 'wpex' ),
				'param_name' => 'content',
				'value' => '<ul>
										<li>30GB Storage</li>
										<li>512MB Ram</li>
										<li>10 databases</li>
										<li>1,000 Emails</li>
										<li>25GB Bandwidth</li>
									</ul>',
				'description' => __('Enter your pricing content. You can use a UL list as shown by default but anything would really work!','wpex'),
				'group' => __( 'Features', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'font_color',
				'group' => __( 'Features', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'features_bg',
				'group' => __( 'Features', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'font_size',
				'group' => __( 'Features', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'features_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Features', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border', 'wpex' ),
				'param_name' => 'features_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Features', 'wpex' ),
			),
			// Button
			array(
				'type' => 'textarea_raw_html',
				'heading' => __( 'Custom Button HTML', 'wpex' ),
				'param_name' => 'custom_button',
				'description' => __( 'Enter your custom button HTML, such as your paypal button code.', 'wpex' ),
				'group' => __( 'Button', 'wpex' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL', 'wpex' ),
				'param_name' => 'button_url',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Local Scroll?', 'wpex' ),
				'param_name' => 'button_local_scroll',
				'group' => __( 'Button', 'wpex' ),
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex') => 'true',
				),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Text', 'wpex' ),
				'param_name' => 'button_text',
				'value' => __( 'Text', 'wpex' ),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => _x( 'Area Background', 'Pricing Button Area Setting', 'wpex' ),
				'param_name' => 'button_wrap_bg',
				'group' => __( 'Button', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => _x( 'Area Padding', 'Pricing Button Area Setting', 'wpex' ),
				'param_name' => 'button_wrap_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Button', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => _x( 'Area Border', 'Pricing Button Area Setting', 'wpex' ),
				'param_name' => 'button_wrap_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Button', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'button_style',
				'value' => array_flip( wpex_button_styles() ),
				'group' => __( 'Button', 'wpex' ),
					'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'button_style_color',
				'value' => array_flip( wpex_button_colors() ),
				'group' => __( 'Button', 'wpex' ),
					'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'button_bg_color',
				'group' => __( 'Button', 'wpex' ),
					'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background: Hover', 'wpex' ),
				'param_name' => 'button_hover_bg_color',
				'group' => __( 'Button', 'wpex' ),
					'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'button_color',
				'group' => __( 'Button', 'wpex' ),
					'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color: Hover', 'wpex' ),
				'param_name' => 'button_hover_color',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'button_size',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'button_border_radius',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Letter Spacing', 'wpex' ),
				'param_name' => 'button_letter_spacing',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'button_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'button_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'button_transform',
				'group' => __( 'Button', 'wpex' ),
				'value' => array_flip( wpex_text_transforms() ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			//Icons
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'wpex' ),
				'param_name' => 'icon_type',
				'description' => __( 'Select icon library.', 'wpex' ),
				'std' => 'fontawesome',
				'value' => array(
					__( 'Font Awesome', 'wpex' ) => 'fontawesome',
					__( 'Open Iconic', 'wpex' ) => 'openiconic',
					__( 'Typicons', 'wpex' ) => 'typicons',
					__( 'Entypo', 'wpex' ) => 'entypo',
					__( 'Linecons', 'wpex' ) => 'linecons',
					__( 'Pixel', 'wpex' ) => 'pixelicons',
				),
				'group' => __( 'Button Icons', 'wpex' ),
				'dependency' => array( 'element' => 'custom_button', 'is_empty' => true ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Left', 'wpex' ),
				'param_name' => 'button_icon_left',
				'admin_label' => true,
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array( 'element' => 'icon_type', 'value' => 'fontawesome' ),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Left', 'wpex' ),
				'param_name' => 'button_icon_left_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array( 'element' => 'icon_type', 'value' => 'openiconic' ),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Left', 'wpex' ),
				'param_name' => 'button_icon_left_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Left', 'wpex' ),
				'param_name' => 'button_icon_left_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Left', 'wpex' ),
				'param_name' => 'button_icon_left_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Left', 'wpex' ),
				'param_name' => 'button_icon_left_pixelicons',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'pixelicons',
					'source' => vcex_pixel_icons(),
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'pixelicons',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Right', 'wpex' ),
				'param_name' => 'button_icon_right',
				'admin_label' => true,
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'fontawesome',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Right', 'wpex' ),
				'param_name' => 'button_icon_right_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Right', 'wpex' ),
				'param_name' => 'button_icon_right_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Right', 'wpex' ),
				'param_name' => 'button_icon_right_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Right', 'wpex' ),
				'param_name' => 'button_icon_right_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon Right', 'wpex' ),
				'param_name' => 'button_icon_right_pixelicons',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'pixelicons',
					'source' => vcex_pixel_icons(),
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'pixelicons',
				),
				'group' => __( 'Button Icons', 'wpex' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_pricing_shortcode_vc_map' );