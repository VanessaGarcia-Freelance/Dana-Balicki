<?php
/**
 * Visual Composer Navbar
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
class WPBakeryShortCode_vcex_navbar extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_navbar.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_navbar_vc_map() {
	// Create an array of menu items
	$menus_array = array( __( 'None', 'wpex' ) => '' );
	if ( is_admin() ) {
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		foreach ( $menus as $menu) {
			$menus_array[$menu->name] = $menu->term_id;
		}
	}
	// Map the shortcode
	vc_map( array(
		'name' => __( 'Navigation Bar', 'wpex' ),
		'description' => __( 'Custom menu navigation bar', 'wpex' ),
		'base' => 'vcex_navbar',
		'icon' => 'vcex-navbar vcex-icon fa fa-navicon',
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
				'admin_label' => true,
				'heading' => __( 'Menu', 'wpex' ),
				'param_name' => 'menu',
				'std' => '',
				'value' => $menus_array,
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Alignment', 'wpex' ),
				'param_name' => 'align',
				'value' => array_flip( wpex_alignments() ),
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
				'heading' => __( 'Local Scroll menu', 'wpex'),
				'param_name' => 'local_scroll',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			// Design
			array(
				'type' => 'dropdown',
				'admin_label' => true,
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'std' => 'buttons',
				'group' => __( 'Design', 'wpex' ),
				'value' => array(
					__( 'Buttons', 'wpex' ) => 'buttons',
					__( 'Simple', 'wpex' ) => 'simple',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Button Style', 'wpex' ),
				'param_name' => 'button_style',
				'value' => array_flip( wpex_button_styles() ),
				'group' => __( 'Design', 'wpex' ),
				'std' => 'minimal-border',
				'dependency' => Array( 'element' => 'style', 'value' => 'buttons' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Button Color', 'wpex' ),
				'param_name' => 'button_color',
				'std' => '',
				'value' => array_flip( wpex_button_colors() ),
				'group' => __( 'Design', 'wpex' ),
				'dependency' => Array( 'element' => 'style', 'value' => 'buttons' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Layout', 'wpex' ),
				'param_name' => 'button_layout',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Expanded', 'wpex' ) => 'expanded',
				),
				'group' => __( 'Design', 'wpex' ),
				'dependency' => Array( 'element' => 'style', 'value' => 'buttons' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'font_size',
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'wpex' ) .' ('. _x( 'Legacy', 'Old VC Module Setting', 'wpex' ) .')',
				'param_name' => 'link_color',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Black', 'wpex' ) => 'black',
					__( 'White', 'wpex' ) => 'white',
				),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Hover: Background', 'wpex' ),
				'param_name' => 'hover_bg',
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Hover: Color', 'wpex' ),
				'param_name' => 'hover_color',
				'group' => __( 'Design', 'wpex' ),
			),
			// Advanced Styling
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'CSS', 'wpex' ),
			),
			// Deprecated params
			array(
				'type' => 'hidden',
				'param_name' => 'border_radius',
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_navbar_vc_map' );