<?php
/**
 * Visual Composer Searchbar
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.1.0
 */
class WPBakeryShortCode_vcex_searchbar extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_searchbar.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 2.1.0
 */
function vcex_searchbar_vc_map() {
	vc_map( array(
		'name' => __( 'Search Bar', 'wpex' ),
		'description' => __( 'Custom search form', 'wpex' ),
		'base' => 'vcex_searchbar',
		'icon' => 'vcex-searchbar vcex-icon fa fa-search',
		'category' => WPEX_THEME_BRANDING,
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
				'heading' => __( 'Appear Animation', 'wpex'),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Placeholder', 'wpex' ),
				'param_name' => 'placeholder',
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Advanced Search', 'wpex' ),
				'param_name' => 'advanced_query',
				'group' => __( 'Query', 'wpex' ),
				'description'	=> __( 'Example: ', 'wpex' ) . 'post_type=portfolio&taxonomy=portfolio_category&term=advertising',
			),
			// Widths
			array(
				'type' => 'textfield',
				'heading' => __( 'Input Width', 'wpex' ),
				'param_name' => 'input_width',
				'group' => __( 'Widths', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Button Width', 'wpex' ),
				'param_name' => 'button_width',
				'group' => __( 'Widths', 'wpex' ),
			),

			// Input
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'input_color',
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
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'input_text_transform',
				'group' => __( 'Input', 'wpex' ),
				'value' => array_flip( wpex_text_transforms() ),
				'std' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'input_font_weight',
				'value' => array_flip( wpex_font_weights() ),
				'std'  => '',
				'group' => __( 'Input', 'wpex' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'Design', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'Input', 'wpex' ),
			),
			// Submit
			array(
				'type' => 'textfield',
				'heading' => __( 'Button Text', 'wpex' ),
				'param_name' => 'button_text',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'button_bg',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background: Hover', 'wpex' ),
				'param_name' => 'button_bg_hover',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'button_color',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color: Hover', 'wpex' ),
				'param_name' => 'button_color_hover',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'button_font_size',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Letter Spacing', 'wpex' ),
				'param_name' => 'button_letter_spacing',
				'group' => __( 'Submit', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'button_text_transform',
				'group' => __( 'Submit', 'wpex' ),
				'value' => array_flip( wpex_text_transforms() ),
				'std'  => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'button_font_weight',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Submit', 'wpex' ),
				'std'  => '',
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_searchbar_vc_map' );