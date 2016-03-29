<?php
/**
 * Visual Composer Social Links
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.0.0
 */
class WPBakeryShortCode_vcex_social_links extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_social_links.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 2.0.0
 */
function vcex_social_links_vc_map() {
	// Define params var
	$params = array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Unique Id', 'wpex' ),
			'param_name' => 'unique_id',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Classes', 'wpex' ),
			'param_name' => 'classes',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'wpex'),
			'param_name' => 'style',
			'value' => array_flip( wpex_social_button_styles() ),
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
		array(
			'type' => 'dropdown',
			'heading' => __( 'Link Target', 'wpex'),
			'param_name' => 'link_target',
			'value' => array(
				__( 'Self', 'wpex' ) => '',
				__( 'Blank', 'wpex' ) => 'blank',
			),
		),
	);
	// Get array of social links to loop through
	$social_links = vcex_social_links_profiles();
	// Loop through social links and add to params
	foreach ( $social_links as $key => $val ) {

		$desc = ( 'email' == $key ) ? __( 'Format: mailto:email@site.com', 'wpex' ) : '';

		$params[] = array(
			'type' => 'textfield',
			'heading' => $val['label'],
			'param_name' => $key,
			'group' => __( 'Profiles', 'wpex' ),
			'description' => $desc,
		);

	}
	// Add CSS option
	$params[] = array(
		'type' => 'css_editor',
		'heading' => __( 'CSS', 'wpex' ),
		'param_name' => 'css',
		'group' => __( 'Design', 'wpex' ),
	);
	$params[] = array(
		'type' => 'dropdown',
		'heading' => __( 'Align', 'wpex' ),
		'param_name' => 'align',
		'value' => array_flip( wpex_alignments() ),
		'group' => __( 'Design', 'wpex' ),
	);
	$params[] = array(
		'type' => 'textfield',
		'heading' => __( 'Font Size', 'wpex' ),
		'param_name' => 'size',
		'group' => __( 'Design', 'wpex' ),
	);
	$params[] = array(
		'type' => 'textfield',
		'heading' => __( 'Width', 'wpex' ),
		'param_name' => 'width',
		'group' => __( 'Design', 'wpex' ),
	);
	$params[] = array(
		'type' => 'textfield',
		'heading' => __( 'Height', 'wpex' ),
		'param_name' => 'height',
		'group' => __( 'Design', 'wpex' ),
	);
	$params[] = array(
		'type' => 'textfield',
		'heading' => __( 'Border Radius', 'wpex' ),
		'param_name' => 'border_radius',
		'group' => __( 'Design', 'wpex' ),
	);
	$params[] = array(
		'type' => 'colorpicker',
		'heading' => __( 'Color', 'wpex' ),
		'param_name' => 'color',
		'group' => __( 'Design', 'wpex' ),
	);
	$params[] = array(
		'type' => 'colorpicker',
		'heading' => __( 'Hover Background', 'wpex' ),
		'param_name' => 'hover_bg',
		'group' => __( 'Design', 'wpex' ),
	);

	$params[] = array(
		'type' => 'colorpicker',
		'heading' => __( 'Hover Color', 'wpex' ),
		'param_name' => 'hover_color',
		'group' => __( 'Design', 'wpex' ),
	);
	// Add to VC
	vc_map( array(
		'name' => __( 'Social Links', 'wpex' ),
		'description' => __( 'Display social links using icon fonts', 'wpex' ),
		'base' => 'vcex_social_links',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-social-links vcex-icon fa fa-user-plus',
		'params' => $params,
	) );
}
add_action( 'vc_before_init', 'vcex_social_links_vc_map' );