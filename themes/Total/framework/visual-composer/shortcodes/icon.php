<?php
/**
 * Visual Composer Icon
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
class WPBakeryShortCode_vcex_icon extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_icon.php' ) );
		return ob_get_clean();
	}
}

/**
 * Parse shortcode attributes and set correct values
 *
 * @since 2.0.0
 */
function parse_vcex_icon_atts( $atts ) {

	// Convert textfield link to vc_link
	if ( ! empty( $atts['link_url'] ) && false === strpos( $atts['link_url'], 'url:' ) ) {
		$url = 'url:'. $atts['link_url'] .'|';
		$link_title = isset( $atts['link_title'] ) ? 'title:' . $atts['link_title'] .'|' : '|';
		$link_target = ( isset( $atts['link_target'] ) && 'blank' == $atts['link_target'] ) ? 'target:_blank' : '';
		$atts['link_url'] = $url . $link_title . $link_target;
	}

	// Update link target
	if ( isset( $atts['link_target'] ) && 'local' == $atts['link_target'] ) {
		$atts['link_local_scroll'] = 'true';
	}

	// Return $atts
	return $atts;
}
add_filter( 'vc_edit_form_fields_attributes_vcex_icon', 'parse_vcex_icon_atts' );

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since Total 1.4.1
 */
if ( ! function_exists( 'vcex_icon_shortcode_vc_map' ) ) {
	function vcex_icon_shortcode_vc_map() {
		vc_map( array(
			'name' => __( 'Font Icon', 'wpex' ),
			'description' => __( 'Font Icon from various libraries', 'wpex' ),
			'base' => 'vcex_icon',
			'icon' => 'vcex-font-icon vcex-icon fa fa-bolt',
			'category' => WPEX_THEME_BRANDING,
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
				),
				array(
					'type' => 'iconpicker',
					'heading' => __( 'Icon', 'wpex' ),
					'param_name' => 'icon',
					'admin_label' => true,
					'value' => 'fa fa-info-circle',
					'settings' => array(
						'emptyIcon' => true,
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'fontawesome',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => __( 'Icon', 'wpex' ),
					'param_name' => 'icon_openiconic',
					'std' => '',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'openiconic',
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'openiconic',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => __( 'Icon', 'wpex' ),
					'param_name' => 'icon_typicons',
					'std' => '',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'typicons',
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'typicons',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => __( 'Icon', 'wpex' ),
					'param_name' => 'icon_entypo',
					'std' => '',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'entypo',
						'iconsPerPage' => 300,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'entypo',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => __( 'Icon', 'wpex' ),
					'param_name' => 'icon_linecons',
					'std' => '',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'linecons',
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'linecons',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => __( 'Icon', 'wpex' ),
					'param_name' => 'icon_pixelicons',
					'std' => '',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'pixelicons',
						'source' => vcex_pixel_icons(),
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'pixelicons',
					),
				),
				// Design
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Color', 'wpex' ),
					'param_name' => 'color',
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Color: Hover', 'wpex' ),
					'param_name' => 'color_hover',
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Background', 'wpex' ),
					'param_name' => 'background',
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Background: Hover', 'wpex' ),
					'param_name' => 'background_hover',
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Size', 'wpex' ),
					'param_name' => 'size',
					'std' => 'normal',
					'value' => array(
						__( 'Inherit', 'wpex' ) => 'inherit',
						__( 'Extra Large', 'wpex' ) => 'xlarge',
						__( 'Large', 'wpex' ) => 'large',
						__( 'Normal', 'wpex' ) => 'normal',
						__( 'Small', 'wpex') => 'small',
						__( 'Tiny', 'wpex' ) => 'tiny',
					),
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Position', 'wpex' ),
					'param_name' => 'float',
					'value' => array_flip( wpex_alignments() ),
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Custom Size', 'wpex' ),
					'param_name' => 'custom_size',
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Border Radius', 'wpex' ),
					'param_name' => 'border_radius',
					'description' => __( 'Enter a pixel value for the border radius or enter 50% for a circle', 'wpex' ),
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Border', 'wpex' ),
					'param_name' => 'border',
					'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Width', 'wpex' ),
					'param_name' => 'width',
					'group' => __( 'Design', 'wpex' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Height', 'wpex' ),
					'param_name' => 'height',
					'group' => __( 'Design', 'wpex' ),
				),
				// Link
				array(
					'type' => 'vc_link',
					'heading' => __( 'Link', 'wpex' ),
					'param_name' => 'link_url',
					'group' => __( 'Link', 'wpex' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Link: Local Scroll', 'wpex' ),
					'param_name' => 'link_local_scroll',
					'value' => array(
						__( 'False', 'wpex' ) => 'false',
						__( 'True', 'wpex' ) => 'true',
					),
					'group' => __( 'Link', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'vc_before_init', 'vcex_icon_shortcode_vc_map' );