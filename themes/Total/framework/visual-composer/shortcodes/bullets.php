<?php
/**
 * Visual Composer Bullets
 *
 * @package    Total WordPress Theme
 * @subpackage VC Functions
 * @version    3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.0.0
 */
class WPBakeryShortCode_vcex_bullets extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_bullets.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since Total 1.4.1
 */
if ( ! function_exists( 'vcex_bullets_shortcode_vc_map' ) ) {
	function vcex_bullets_shortcode_vc_map() {
		vc_map( array(
			'name'        => __( 'Bullets', 'wpex' ),
			'description' => __( 'Styled bulleted lists', 'wpex' ),
			'base'        => 'vcex_bullets',
			'category'    => WPEX_THEME_BRANDING,
			'icon'        => 'vcex-bullets vcex-icon fa fa-dot-circle-o',
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => __( 'Style', 'wpex' ),
					'param_name'  => 'style',
					'admin_label' => true,
					'value'       => array(
						__( 'Check', 'wpex')        => 'check',
						__( 'Blue', 'wpex' )        => 'blue',
						__( 'Gray', 'wpex' )        => 'gray',
						__( 'Purple', 'wpex' )      => 'purple',
						__( 'Red', 'wpex' )         => 'red',
					),
				),
				array(
					'type'       => 'textarea_html',
					'heading'    => __( 'Insert Unordered List', 'wpex' ),
					'param_name' => 'content',
					'value'      => '<ul><li>List 1</li><li>List 2</li><li>List 3</li><li>List 4</li></ul>',
				),
			)
		) );
	}
}
add_action( 'vc_before_init', 'vcex_bullets_shortcode_vc_map' );