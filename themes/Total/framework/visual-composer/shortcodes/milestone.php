<?php
/**
 * Visual Composer Milestone
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
class WPBakeryShortCode_vcex_milestone extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_milestone.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since Total 1.4.1
 */
function vcex_milestone_vc_map() {
	vc_map( array(
		'name' => __( 'Milestone', 'wpex' ),
		'description' => __( 'Animated counter', 'wpex' ),
		'base' => 'vcex_milestone',
		'icon' => 'vcex-milestone vcex-icon fa fa-medium',
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
				'heading' => __( 'Appear Animation', 'wpex' ),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Hover Animation', 'wpex'),
				'param_name' => 'hover_animation',
				'value' => array_flip( wpex_hover_css_animations() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Animated', 'wpex' ),
				'param_name' => 'animated',
				'std' => 'true',
				'value' => array(
					__( 'Yes', 'wpex') => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Speed', 'wpex' ),
				'param_name' => 'speed',
				'value' => '2500',
				'description' => __('The number of milliseconds it should take to finish counting.','wpex'),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Refresh Interval', 'wpex' ),
				'param_name' => 'interval',
				'value' => '50',
				'description' => __('The number of milliseconds to wait between refreshing the counter.','wpex'),
			),
			// Number
			array(
				'type' => 'textfield',
				'admin_label' => true,
				'heading' => __( 'Number', 'wpex' ),
				'param_name' => 'number',
				'std' => '45',
				'group' => __( 'Number', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Before', 'wpex' ),
				'param_name' => 'before',
				'group' => __( 'Number', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'After', 'wpex' ),
				'param_name' => 'after',
				'default' => '%',
				'group' => __( 'Number', 'wpex' ),
			),
			array(
				'type'  => 'dropdown',
				'heading' => __( 'Font Family', 'wpex' ),
				'param_name' => 'number_font_family',
				'std' => '',
				'value' => vcex_fonts_array(),
				'group' => __( 'Number', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'number_color',
				'group' => __( 'Number', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'number_size',
				'group' => __( 'Number', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'number_weight',
				'value' => array_flip( wpex_font_weights() ),
				'std' => '',
				'group' => __( 'Number', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Bottom Margin', 'wpex' ),
				'param_name' => 'number_bottom_margin',
				'group' => __( 'Number', 'wpex' ),
			),
			// caption
			array(
				'type' => 'textfield',
				'class' => 'vcex-animated-counter-caption',
				'heading' => __( 'Caption', 'wpex' ),
				'param_name' => 'caption',
				'value' => 'Awards Won',
				'admin_label' => true,
				'group' => __( 'Caption', 'wpex' ),
			),
			array(
				'type'  => 'dropdown',
				'heading' => __( 'Font Family', 'wpex' ),
				'param_name' => 'caption_font_family',
				'std' => '',
				'value' => vcex_fonts_array(),
				'group' => __( 'Caption', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __(  'Color', 'wpex' ),
				'param_name' => 'caption_color',
				'group' => __( 'Caption', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'caption_size',
				'group' => __( 'Caption', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'caption_font',
				'value' => array_flip( wpex_font_weights() ),
				'std' => '',
				'group' => __( 'Caption', 'wpex' ),
			),
			// Link
			array(
				'type' => 'textfield',
				'heading' => __( 'URL', 'wpex' ),
				'param_name' => 'url',
				'group' => __( 'Link', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'URL Target', 'wpex' ),
				'param_name' => 'url_target',
				'value' => array(
					__( 'Self', 'wpex') => 'self',
					__( 'Blank', 'wpex' ) => 'blank',
				),
				'group' => __( 'Link', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'URl Rel', 'wpex' ),
				'param_name' => 'url_rel',
				'value' => array(
					__( 'None', 'wpex') => '',
					__( 'Nofollow', 'wpex' ) => 'nofollow',
				),

				'group' => __( 'Link', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link Container Wrap', 'wpex' ),
				'param_name' => 'url_wrap',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Link', 'wpex' ),
				'description' => __( 'Apply the link to the entire wrapper?', 'wpex' ),
			),
			
			// CSS
			array(
				'type' => 'css_editor',
				'heading' => __( 'Design', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'Design options', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Width', 'wpex' ),
				'param_name' => 'width',
				'group' => __( 'Design options', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'border_radius',
				'group' => __( 'Design options', 'wpex' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_milestone_vc_map' );