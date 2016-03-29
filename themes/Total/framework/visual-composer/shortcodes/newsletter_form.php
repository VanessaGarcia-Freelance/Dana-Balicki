<?php
/**
 * Visual Composer Newsletter Form
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
class WPBakeryShortCode_vcex_newsletter_form extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_newsletter_form.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since Total 1.4.1
 */
function vcex_newsletter_form_vc_map() {

	// VC Map
	vc_map( array(
		'name' => __( 'Mailchimp Form', 'wpex' ),
		'description' => __( 'Newsletter subscription form', 'wpex' ),
		'base' => 'vcex_newsletter_form',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-newsletter vcex-icon fa fa-envelope',
		'params' => array(
			// General
			array(
				'type' => 'textfield',
				'admin_label' => true,
				'heading' => __( 'Unique Id', 'wpex' ),
				'param_name' => 'unique_id',
			),
			array(
				'type' => 'textfield',
				'admin_label' => true,
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
				'heading' => __( 'CSS Animation', 'wpex' ),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Mailchimp Form Action', 'wpex' ),
				'param_name' => 'mailchimp_form_action',
				'value' => 'http://domain.us1.list-manage.com/subscribe/post?u=numbers_go_here',
				'description' => __( 'Enter the MailChimp form action URL.', 'wpex' ) .' <a href="http://docs.shopify.com/support/configuration/store-customization/where-do-i-get-my-mailchimp-form-action?ref=wpexplorer" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Placeholder Text', 'wpex' ),
				'param_name' => 'placeholder_text',
				'std' => _x( 'Enter your email address', 'Newsletter VC module placeholder text', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Submit Button Text', 'wpex' ),
				'param_name' => 'submit_text',
				'std' => _x( 'Go', 'Newsletter VC module submit button text', 'wpex' ),
			),
			// Input
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'input_bg',
				'dependency' => Array(
					'element' => 'mailchimp_form_action',
					'not_empty' => true
				),
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'input_color',
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Width', 'wpex' ),
				'param_name' => 'input_width',
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'wpex' ),
				'param_name' => 'input_height',
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'input_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border', 'wpex' ),
				'param_name' => 'input_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'input_border_radius',
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'input_font_size',
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Letter Spacing', 'wpex' ),
				'param_name' => 'input_letter_spacing',
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'input_weight',
				'group' => __( 'Input', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
			),
			// Submit
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'submit_bg',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background: Hover', 'wpex' ),
				'param_name' => 'submit_hover_bg',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'submit_color',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color: Hover', 'wpex' ),
				'param_name' => 'submit_hover_color',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin Right', 'wpex' ),
				'param_name' => 'submit_position_right',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'wpex' ),
				'param_name' => 'submit_height',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'submit_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border', 'wpex' ),
				'param_name' => 'submit_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'submit_border_radius',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'submit_font_size',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Letter Spacing', 'wpex' ),
				'param_name' => 'submit_letter_spacing',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'submit_weight',
				'group' => __( 'Submit', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_newsletter_form_vc_map' );