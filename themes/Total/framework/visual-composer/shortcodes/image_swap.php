<?php
/**
 * Registers the image swap shortcode and adds it to the Visual Composer
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
class WPBakeryShortCode_vcex_image_swap extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_image_swap.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_image_swap_vc_map() {
	vc_map( array(
		'name' => __( 'Image Swap', 'wpex' ),
		'description' => __( 'Double Image Hover Effect', 'wpex' ),
		'base' => 'vcex_image_swap',
		'icon' => 'vcex-image-swap vcex-icon fa fa-picture-o',
		'category' => WPEX_THEME_BRANDING,
		'params' => array(
			// General
			array(
				'type' => 'attach_image',
				'heading' => __( 'Primary Image', 'wpex' ),
				'param_name' => 'primary_image',
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Secondary Image', 'wpex' ),
				'param_name' => 'secondary_image',
			),
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
				'heading' => __( 'Appear Animation', 'wpex'),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
			),
			// Image
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'wpex_custom',
				'value' => vcex_image_sizes(),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Crop Location', 'wpex' ),
				'param_name' => 'img_crop',
				'std' => 'center-center',
				'value' => array_flip( wpex_image_crop_locations() ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			// Link
			array(
				'type' => 'vc_link',
				'heading' => __( 'Link', 'wpex' ),
				'param_name' => 'link',
				'group' => __( 'Link', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable Tooltip?', 'wpex' ),
				'param_name' => 'link_tooltip',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'true'
				),
				'group' => __( 'Link', 'wpex' ),
			),
			// Design Options
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'description' => __( 'These settings are applied to the main wrapper and they will override any other styling options.', 'wpex' ),
				'group' => __( 'Design options', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Container Width', 'wpex' ),
				'param_name' => 'container_width',
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'border_radius',
				'group' => __( 'Image', 'wpex' ),
			),
			// Hidden
			array(
				'type' => 'hidden',
				'param_name' => 'link_title',
			),
			array(
				'type' => 'hidden',
				'param_name' => 'link_target',
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_image_swap_vc_map' );