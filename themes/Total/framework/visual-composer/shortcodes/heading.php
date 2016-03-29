<?php
/**
 * Visual Composer Heading
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
class WPBakeryShortCode_vcex_heading extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_heading.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_heading_vc_map() {
	vc_map( array(
		'name'  => __( 'Heading', 'wpex' ),
		'description' => __( 'A better heading module', 'wpex' ),
		'base'  => 'vcex_heading',
		'category' => WPEX_THEME_BRANDING,
		'icon'  => 'vcex-heading vcex-icon fa fa-font',
		'params' => array(
			// General
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Classes', 'wpex' ),
				'param_name' => 'el_class',
			),
			array(
				'type'  => 'dropdown',
				'heading'  => __( 'Visibility', 'wpex' ),
				'param_name'  => 'visibility',
				'value' => array_flip( wpex_visibility() ),
			),
			array(
				'type'  => 'dropdown',
				'heading'  => __( 'Style', 'wpex' ),
				'param_name'  => 'style',
				'value' => array(
					__( 'Plain', 'wpex' ) => 'plain',
					__( 'Bottom Border With Color', 'wpex' ) => 'bottom-border-w-color',
					__( 'Graphical', 'wpex' ) => 'graphical',
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Accent Border Color', 'wpex' ),
				'param_name' => 'inner_bottom_border_color',
				'dependency' => array( 'element' => 'style', 'value' => 'bottom-border-w-color' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Border Color', 'wpex' ),
				'param_name' => 'inner_bottom_border_color_main',
				'dependency' => array( 'element' => 'style', 'value' => 'bottom-border-w-color' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Source', 'wpex' ),
				'param_name' => 'source',
				'value' => array(
					__( 'Custom Text', 'wpex' ) => '',
					__( 'Post or Page Title', 'wpex' ) => 'post_title',
					__( 'Custom Field', 'wpex' ) => 'custom_field',
				),
			),
			array(
				'type'  => 'vcex_textarea_html',
				'heading'  => __( 'Text', 'wpex' ),
				'param_name'  => 'text',
				'value' => __( 'Heading', 'wpex' ),
				'admin_label' => true,
				'vcex_rows' => 2,
				'description' => __( 'HTML Supported', 'wpex' ),
				'dependency' => array( 'element' => 'source', 'is_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Field', 'wpex' ),
				'param_name' => 'custom_field',
				'dependency' => array( 'element' => 'source', 'value' => 'custom_field' ),
			),
			array(
				'type'  => 'dropdown',
				'heading'  => __( 'Font Family', 'wpex' ),
				'param_name'  => 'font_family',
				'std' => '',
				'value' => vcex_fonts_array(),
			),
			array(
				'type' => 'dropdown',
				'heading'  => __( 'Tag', 'wpex' ),
				'param_name'  => 'tag',
				'value'  => array(
					__( 'Default', 'wpex' ) => '',
					'h1'  => 'h1',
					'h2'  => 'h2',
					'h3'  => 'h3',
					'h4'  => 'h4',
					'h5'  => 'h5',
					'div' => 'div',
					'span'  => 'span',
				),
			),
			array(
				'type'  => 'textfield',
				'heading'  => __( 'Font Size', 'wpex' ),
				'param_name'  => 'font_size',
			),
			array(
				'type'  => 'textfield',
				'heading'  => __( 'Line Height', 'wpex' ),
				'param_name'  => 'line_height',
			),
			array(
				'type'  => 'textfield',
				'heading'  => __( 'Letter Spacing', 'wpex' ),
				'param_name'  => 'letter_spacing',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Italic', 'wpex' ),
				'param_name' => 'italic',
				'value' => array(
					__( 'False', 'wpex' ) => 'false',
					__( 'True', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'font_weight',
				'value' => array_flip( wpex_font_weights() ),
				'std'  => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Align', 'wpex' ),
				'param_name' => 'text_align',
				'value' => array_flip( wpex_alignments() ),
				'std'  => '',
			),
			array(
				'type'  => 'colorpicker',
				'heading'  => __( 'Color', 'wpex' ),
				'param_name'  => 'color',
			),
			// Link
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL', 'wpex' ),
				'param_name' => 'link',
				'group' => __( 'Link', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link: Local Scroll', 'wpex' ),
				'param_name' => 'link_local_scroll',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' )  => 'true',
				),
				'group' => __( 'Link', 'wpex' ),
			),
			array(
				'type'  => 'colorpicker',
				'heading'  => __( 'Color: Hover', 'wpex' ),
				'param_name'  => 'color_hover',
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
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'wpex' ),
				'param_name' => 'icon',
				'value' => '',
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array( 'element' => 'icon_type', 'value' => 'fontawesome' ),
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
				'dependency' => array( 'element' => 'icon_type', 'value' => 'openiconic' ),
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
				'dependency' => array( 'element' => 'icon_type', 'value' => 'typicons' ),
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
				'dependency' => array( 'element' => 'icon_type', 'value' => 'entypo' ),
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
				'dependency' => array( 'element' => 'icon_type', 'value' => 'linecons' ),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Position', 'wpex' ),
				'param_name' => 'icon_position',
				'value' => array(
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' )  => 'right',
				),
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'icon_color',
				'group' => __( 'Icon', 'wpex' ),
			),
			// CSS
			array(
				'type' => 'css_editor',
				'heading' => __( 'Design', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'CSS', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background: Hover', 'wpex' ),
				'param_name' => 'background_hover',
				'group' => __( 'CSS', 'wpex' ),
				'dependency' => array( 'element' => 'style', 'value' => 'plain' ),
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
				'dependency' => array( 'element' => 'style', 'value' => 'plain' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_heading_vc_map' );