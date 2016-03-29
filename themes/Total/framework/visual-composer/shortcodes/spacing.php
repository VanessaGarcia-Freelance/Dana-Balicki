<?php
/**
 * Visual Composer Spacing
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
class WPBakeryShortCode_vcex_spacing extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_spacing.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_spacing_vc_map() {
	vc_map( array(
		'name' => __( 'Spacing', 'wpex' ),
		'description' => __( 'Adds spacing anywhere you need it', 'wpex' ),
		'base' => 'vcex_spacing',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-spacing vcex-icon fa fa-sort',
		'params' => array(
			array(
				'type' => 'textfield',
				'admin_label' => true,
				'heading'  => __( 'Spacing', 'wpex' ),
				'param_name'  => 'size',
				'value'  => '30px',
			),
			array(
				'type' => 'textfield',
				'heading'  => __( 'Custom Classes', 'wpex' ),
				'param_name'  => 'class',
			),
			array(
				'type'  => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_spacing_vc_map' );