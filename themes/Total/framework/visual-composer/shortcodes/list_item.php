<?php
/**
 * Visual Composer List Item
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
class WPBakeryShortCode_vcex_list_item extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_list_item.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_list_item_vc_map() {
	vc_map( array(
		'name' => __( 'List Item', 'wpex' ),
		'description' => __( 'Font Icon list item', 'wpex' ),
		'base' => 'vcex_list_item',
		'icon' => 'vcex-list-item vcex-icon fa fa-list',
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
				'heading' => __( 'Appear Animation', 'wpex' ),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content', 'wpex' ),
				'param_name' => 'content',
				'admin_label' => true,
				'value' => __( 'This is a pretty list item', 'wpex' ),
			),
			array(
				'type'  => 'dropdown',
				'heading'  => __( 'Font Family', 'wpex' ),
				'param_name'  => 'font_family',
				'std' => '',
				'value' => vcex_fonts_array(),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'font_size',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Align', 'wpex' ),
				'param_name' => 'text_align',
				'value' => array_flip( wpex_alignments() ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'font_color',
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
				'heading' => __( 'Right Margin', 'wpex' ),
				'param_name' => 'margin_right',
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'color',
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
				'heading' => __( 'Size', 'wpex' ),
				'param_name' => 'icon_size',
				'group' => __( 'Icon', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'icon_border_radius',
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
			// Link
			array(
				'type' => 'vc_link',
				'heading' => __( 'Link', 'wpex' ),
				'param_name' => 'link',
				'group' => __( 'Link', 'wpex' ),
			),
			// CSS
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'description' => __( 'If any of these are defined it will add a new wrapper around your icon box with the custom CSS applied to it.', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),

		)
	) );
}
add_action( 'vc_before_init', 'vcex_list_item_vc_map' );