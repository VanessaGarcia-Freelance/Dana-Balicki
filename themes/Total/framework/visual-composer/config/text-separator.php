<?php
/**
 * Visual Composer Text Separator Configuration
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 */

return; // DEPRECATED

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'VCEX_Separator_Config' ) ) {
	
	class VCEX_Separator_Config {

		/**
		 * Main constructor
		 *
		 * @since 3.0.0
		 * @access public
		 */
		public function __construct() {
			add_filter( 'admin_init', array( $this, 'add_params' ) );
		}

		/**
		 * Adds new params for the VC Rows
		 *
		 * @since 3.0.0
		 * @access public
		 */
		public function add_params() {

			// Get global object
			global $vcex_global;

			vc_add_param( 'vc_text_separator', array(
				'type' => 'dropdown',
				'heading' => __( 'Element Type', 'wpex' ),
				'param_name' => 'element_type',
				'value' => array(
					'div' => 'div',
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
				),
			) );

			vc_add_param( 'vc_text_separator', array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Bottom Border', 'wpex' ) => 'one',
					__( 'Bottom Border With Color', 'wpex' ) => 'two',
					__( 'Line Through', 'wpex' ) => 'three',
					__( 'Double Line Through', 'wpex' ) => 'four',
					__( 'Dotted', 'wpex' ) => 'five',
					__( 'Dashed', 'wpex' ) => 'six',
					__( 'Top & Bottom Borders', 'wpex' ) => 'seven',
					__( 'Graphical', 'wpex' ) => 'eight',
					__( 'Outlined', 'wpex' ) => 'nine',
				),
			) );

			vc_add_param( 'vc_text_separator', array(
				'type' => 'colorpicker',
				'heading' => __( 'Border Color', 'wpex' ),
				'param_name' => 'border_color',
				'description' => __( 'Select a custom color for your colored border under the title.', 'wpex' ),
				'dependency' => Array(
					'element' => 'style',
					'value' => array( 'two' ),
				),
			) );

			vc_add_param( 'vc_text_separator', array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'font_size',
				'description' => __( 'You can use "em" or "px" values, but you must define them.', 'wpex' ),
			) );

			vc_add_param( 'vc_text_separator', array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'std' => '',
				'param_name' => 'font_weight',
				'description' => __( 'Note: Not all font families support every font weight.', 'wpex' ),
				'value' => array_flip( wpex_font_weights() ),
			) );

			vc_add_param( 'vc_text_separator', array(
				'type' => 'textfield',
				'heading' => __( 'Bottom Margin', 'wpex' ),
				'param_name' => 'margin_bottom',
				'description' => __( 'Please enter a px value.', 'wpex' ),
			) );

			vc_add_param( 'vc_text_separator', array(
				'type' => 'colorpicker',
				'heading' => __( 'Background Color', 'wpex' ),
				'param_name' => 'span_background',
				'dependency' => Array(
					'element' => 'style',
					'value' => array( 'three', 'four', 'five', 'six' ),
				)
			) );

			vc_add_param( 'vc_text_separator', array(
				'type' => 'colorpicker',
				'heading' => __( 'Font Color', 'wpex' ),
				'param_name' => 'span_color',
			) );

		}

		/**
		 * Tweaks attributes on edit
		 *
		 * @since 3.0.0
		 * @access public
		 */
		public function edit_form_fields( $atts ) {

		}

	}

}
$vcex_separator_config = new VCEX_Separator_Config();