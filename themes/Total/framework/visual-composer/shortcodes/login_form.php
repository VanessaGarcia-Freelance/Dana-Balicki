<?php
/**
 * Visual Composer Login Form
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
class WPBakeryShortCode_vcex_login_form extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_login_form.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_login_form_vc_map() {
	vc_map( array(
		'name' => __( 'Login Form', 'wpex' ),
		'description' => __( 'Adds a WordPress login form', 'wpex' ),
		'base' => 'vcex_login_form',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-login-form vcex-icon fa fa-unlock-alt',
		'params' => array(
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
				'heading' => __( 'CSS Animation', 'wpex' ),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Redirect', 'wpex' ),
				'param_name' => 'redirect',
				'description' => __( 'Enter a URL to redirect the user after they successfully log in. Leave blank to redirect to the current page.','wpex'),
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Logged in Content', 'wpex' ),
				'param_name' => 'content',
				'value' => __('You are currently logged in','wpex'),
				'description' => __( 'The content to displayed for logged in users.','wpex'),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_login_form_vc_map' );