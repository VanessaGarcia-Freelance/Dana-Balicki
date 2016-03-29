<?php
/**
 * Visual Composer Row Configuration
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'VCEX_VC_Row_Config' ) ) {
	
	class VCEX_VC_Row_Config {

		/**
		 * Main constructor
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			add_action( 'vc_after_init', array( $this, 'update_params' ) );
			add_action( 'init', array( $this, 'add_params' ) );
			add_filter( 'vc_edit_form_fields_attributes_vc_row', array( $this, 'edit_form_fields') );
		}

		/**
		 * Used to update default parms
		 *
		 * @since 3.0.0
		 */
		public function update_params() {

			// Only needed on front-end
			if ( ! is_admin() ) return;

			// Set ID weight
			$param = WPBMap::getParam( 'vc_row', 'el_id' );
			if ( $param ) {
				$param['weight'] = 99;
				vc_update_shortcode_param( 'vc_row', $param );
			}

			// Set class weight
			$param = WPBMap::getParam( 'vc_row', 'el_class' );
			if ( $param ) {
				$param['weight'] = 98;
				$time_start = microtime( true );
				vc_update_shortcode_param( 'vc_row', $param );
			}

			// Move video parallax setting
			$param = WPBMap::getParam( 'vc_row', 'video_bg_parallax' );
			if ( $param ) {
				$param['group'] = __( 'Video', 'wpex' );
				$param['dependency'] = array(
					'element' => 'video_bg',
					'value' => 'youtube',
				);
				vc_update_shortcode_param( 'vc_row', $param );
			}

			// Move youtube url
			$param = WPBMap::getParam( 'vc_row', 'video_bg_url' );
			if ( $param ) {
				$param['group'] = __( 'Video', 'wpex' );
				$param['dependency'] = array(
					'element' => 'video_bg',
					'value' => 'youtube',
				);
				vc_update_shortcode_param( 'vc_row', $param );
			}

			// Alter Parallax dropdown
			$param = WPBMap::getParam( 'vc_row', 'parallax' );
			if ( $param ) {
				$param['group'] = __( 'Parallax', 'wpex' );
				$param['value'][ __( 'Advanced Parallax', 'wpex' ) ] = 'vcex_parallax';
				vc_update_shortcode_param( 'vc_row', $param );
			}

			// Alter Parallax image location
			$param = WPBMap::getParam( 'vc_row', 'parallax_image' );
			if ( $param ) {
				$param['group'] = __( 'Parallax', 'wpex' );
				vc_update_shortcode_param( 'vc_row', $param );
			}

			// Move design options
			$param = WPBMap::getParam( 'vc_row', 'css' );
			if ( $param ) {
				$param['weight'] = -1;
				vc_update_shortcode_param( 'vc_row', $param );
			}

		}

		/**
		 * Adds new params for the VC Rows
		 *
		 * @since 2.0.0
		 */
		public function add_params() {

			// Array of params to add
			$add_params = array();

			$add_params['local_scroll_id'] = array(
				'type' => 'textfield',
				'heading' => __( 'Local Scroll ID', 'wpex' ),
				'param_name' => 'local_scroll_id',
				'description' => __( 'Unique identifier for local scrolling links.', 'wpex' ),
				'weight' => 99,
			);

			$add_params['min_height'] = array(
				'type' => 'textfield',
				'heading' => __( 'Minimum Height', 'wpex' ),
				'description' => __( 'Adds a minimum height to the row so you can have a row without any content but still display it at a certain height. Such as a background with a video or image background but without any content.', 'wpex' ),
				'param_name' => 'min_height',
			);

			$add_params['visibility'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
			);

			$add_params['center_row'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Center Row Content', 'wpex' ),
				'param_name' => 'center_row',
				'value' => array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'yes',
				),
				'dependency' => array( 'element' => 'full_width', 'is_empty' => true ),
				'description' => __( 'Use this option to center the inner content (Horizontally). Only used for "Full Screen" layouts.', 'wpex' ),
			);

			$add_params['match_column_height'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Equal Column Heights', 'wpex' ),
				'param_name' => 'match_column_height',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'yes',
				),
			);

			$add_params['css_animation'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Animation', 'wpex' ),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			);

			$add_params['typography_style'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Typography Style', 'wpex' ),
				'param_name' => 'typography_style',
				'value' => array_flip( wpex_typography_styles() ),
			);

			$add_params['max_width'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Max Width', 'wpex' ),
				'param_name' => 'max_width',
				'value' => array(
					__( 'None', 'wpex' ) => '',
					'50%' => '50',
					'60%' => '60',
					'70%' => '70',
					'80%' => '80',
				),
			);

			$add_params['column_spacing'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Spacing Between Columns', 'wpex' ),
				'param_name' => 'column_spacing',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					'0px' => '0px',
					'20px' => '20',
					'30px' => '30',
					'40px' => '40',
					'50px' => '50',
					'60px' => '60',
				),
			);
			$add_params['tablet_fullwidth_cols'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Full-Width Columns On Tablets', 'wpex' ),
				'param_name' => 'tablet_fullwidth_cols',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'yes',
				),
				'description' => __( 'Check this box to make all columns inside this row full-width for tablets.', 'wpex' ),
			);

			// Parallax
			$add_params['parallax_mobile'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Enable parallax for mobile devices', 'wpex' ),
				'param_name' => 'parallax_mobile',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'on',
				),
				'description' => __( 'Parallax effects would most probably cause slowdowns when your site is viewed in mobile devices. By default it is disabled.', 'wpex' ),
				'group' => __( 'Parallax', 'wpex' ),
				'dependency' => array(
					'element' => 'parallax',
					'value' => 'vcex_parallax',
				),
			);
			$add_params['parallax_style'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Parallax Style', 'wpex' ),
				'param_name' => 'parallax_style',
				'group' => __( 'Parallax', 'wpex' ),
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Fixed & Repeat', 'wpex' ) => 'fixed-repeat',
					__( 'Fixed & No-Repeat', 'wpex' ) => 'fixed-no-repeat',
				),
				'dependency' => array(
					'element' => 'parallax',
					'value' => 'vcex_parallax',
				),
			);
			$add_params['parallax_direction'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Parallax Direction', 'wpex' ),
				'param_name' => 'parallax_direction',
				'value' => array(
					__( 'Up', 'wpex' ) => '',
					__( 'Down', 'wpex' ) => 'down',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
				),
				'group' => __( 'Parallax', 'wpex' ),
				'dependency' => array(
					'element' => 'parallax',
					'value' => 'vcex_parallax',
				),
			);
			$add_params['parallax_speed'] = array(
				'type' => 'textfield',
				'heading' => __( 'Parallax Speed', 'wpex' ),
				'param_name' => 'parallax_speed',
				'description' => __( 'The movement speed, value should be between 0.1 and 1.0. A lower number means slower scrolling speed. Be mindful of the background size and the dimensions of your background image when setting this value. Faster scrolling means that the image will move faster, make sure that your background image has enough width or height for the offset.', 'wpex' ),
				'group' => __( 'Parallax', 'wpex' ),
				'dependency' => array(
					'element' => 'parallax',
					'value' => 'vcex_parallax',
				),
			);

			// Video
			$add_params['video_bg'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Video Background?', 'wpex' ),
				'param_name' => 'video_bg',
				'description' => __( 'Check this box to enable the options for a self hosted video background.', 'wpex' ),
				'value' => array(
					__( 'None', 'wpex' ) => '',
					__( 'Youtube', 'wpex' ) => 'youtube',
					__( 'Self Hosted', 'wpex' ) => 'self_hosted',
				),
				'group' => __( 'Video', 'wpex' ),
			);
			$add_params['video_bg_mp4'] = array(
				'type' => 'textfield',
				'heading' => __( 'Video URL: MP4 URL', 'wpex' ),
				'param_name' => 'video_bg_mp4',
				'dependency' => array(
					'element' => 'video_bg',
					'value' => 'self_hosted',
				),
				'group' => __( 'Video', 'wpex' ),
			);
			$add_params['video_bg_webm'] = array(
				'type' => 'textfield',
				'heading' => __( 'Video URL: WEBM URL', 'wpex' ),
				'param_name' => 'video_bg_webm',
				'dependency' => array(
					'element' => 'video_bg',
					'value' => 'self_hosted',
				),
				'group' => __( 'Video', 'wpex' ),
			);
			$add_params['video_bg_ogv'] = array(
				'type' => 'textfield',
				'heading' => __( 'Video URL: OGV URL', 'wpex' ),
				'param_name' => 'video_bg_ogv',
				'dependency' => array(
					'element' => 'video_bg',
					'value' => 'self_hosted',
				),
				'group' => __( 'Video', 'wpex' ),
			);
			$add_params['video_bg_overlay'] = array(
				'type' => 'dropdown',
				'heading' => __( 'Video Background Overlay', 'wpex' ),
				'param_name' => 'video_bg_overlay',
				'group' => __( 'Video', 'wpex' ),
				'value' => array(
					__( 'None', 'wpex' ) => 'none',
					__( 'Dark', 'wpex' ) => 'dark',
					__( 'Dotted', 'wpex' ) => 'dotted',
					__( 'Diagonal Lines', 'wpex' ) => 'dashed',
				),
				'dependency' => array(
					'element' => 'video_bg',
					'value' => 'self_hosted',
				),
			);

			// Apply filters for child theming
			$add_params = apply_filters( 'wpex_vc_row_custom_params', $add_params );

			// Loop through array and add new params
			foreach( $add_params as $key => $val ) {
				vc_add_param( 'vc_row', $val );
			}

			// Hidden fields = Deprecated params, these should be removed on save
			$deprecated = array(
				'id',
				'style',
				'bg_color',
				'bg_image',
				'bg_style',
				'border_style',
				'border_color',
				'border_width',
				'margin_top',
				'margin_bottom',
				'margin_left',
				'padding_top',
				'padding_bottom',
				'padding_left',
				'padding_right',
				'no_margins',
			);
			foreach ( $deprecated as $key => $val ) {
				vc_add_param( 'vc_row', array(
					'type' => 'hidden',
					'param_name' => $val,
				) );
			}

		}

		/**
		 * Tweaks row attributes on edit
		 *
		 * @since 2.0.2
		 */
		public function edit_form_fields( $atts ) {

			// Parse ID
			if ( empty( $atts['el_id'] ) && ! empty( $atts['id'] ) ) {
				$atts['el_id'] = $atts['id'];
				unset( $atts['id'] );
			}

			// Parse $style into $typography_style
			if ( empty( $atts['typography_style'] ) && ! empty( $atts['style'] ) ) {
				if ( in_array( $atts['style'], array_flip( wpex_typography_styles() ) ) ) {
					$atts['typography_style'] = $atts['style'];
					unset( $atts['style'] );
				}
			}

			// Parse parallax
			if ( ! empty( $atts['parallax'] ) ) {
				if ( in_array( $atts['parallax'], array( 'simple', 'advanced', 'true' ) ) ) {
					$atts['parallax'] = 'vcex_parallax';
				}
			} elseif ( empty( $atts['parallax'] ) && ! empty( $atts['bg_style'] ) ) {
				if ( 'parallax' == $atts['bg_style'] || 'parallax-advanced' == $atts['bg_style'] ) {
					$atts['parallax'] = 'vcex_parallax';
					unset( $atts['bg_style'] );
				}
			}

			// Parse video background
			if ( ! empty( $atts['video_bg'] ) && 'yes' == $atts['video_bg'] ) {
				$atts['video_bg'] = 'self_hosted';
			}

			// Convert 'no-margins' to '0px' column_spacing
			if ( empty( $this->atts['column_spacing'] ) && ! empty( $atts['no_margins'] ) && 'true' == $atts['no_margins'] ) {
				$atts['column_spacing'] = '0px';
				unset( $atts['no_margins'] );
			}

			// Parse css
			if ( empty( $atts['css'] ) ) {

				// Convert deprecated fields to css field
				$atts['css'] = vcex_parse_deprecated_row_css( $atts );

				// Unset deprecated vars
				unset( $atts['bg_image'] );
				unset( $atts['bg_color'] );

				unset( $atts['margin_top'] );
				unset( $atts['margin_bottom'] );
				unset( $atts['margin_right'] );
				unset( $atts['margin_left'] );

				unset( $atts['padding_top'] );
				unset( $atts['padding_bottom'] );
				unset( $atts['padding_right'] );
				unset( $atts['padding_left'] );

				unset( $atts['border_width'] );
				unset( $atts['border_style'] );
				unset( $atts['border_color'] );

			}

			// Return $atts
			return $atts;

		}

	}

}
$vcex_vc_row_config = new VCEX_VC_Row_Config();