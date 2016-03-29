<?php
/**
 * Visual Composer Staff Social
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.0.0
 */

function vcex_staff_social_vc_map() {
	vc_map( array(
		'name' => __( 'Staff Social Links', 'wpex' ),
		'description' => __( 'Single staff social links', 'wpex' ),
		'base' => 'staff_social',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-staff-social vcex-icon fa fa-share-alt',
		'params' => array(
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Staff Member ID', 'wpex' ),
				'param_name' => 'post_id',
				'param_holder_class' => 'vc_not-for-custom',
				'description' => __( 'Select a staff member to display their social links. By default it will diplay the current staff member links.', 'wpex'),
				'settings' => array(
					'multiple' => false,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'value' => array_flip( wpex_social_button_styles() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link Target', 'wpex' ),
				'param_name' => 'link_target',
				'value' => array(
					__( 'Blank', 'wpex' ) => 'blank',
					__( 'Self', 'wpex') => 'self',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'font_size',
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'CSS', 'wpex' ),
			),
		)
	) );
}

// Map shortcode
add_action( 'vc_before_init', 'vcex_staff_social_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_staff_social_post_id_callback', 'vcex_suggest_staff_members', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_staff_social_post_id_render', 'vcex_render_staff_members', 10, 1 );