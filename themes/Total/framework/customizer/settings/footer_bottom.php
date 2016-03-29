<?php
/**
 * Customizer => Footer Bottom
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_footer_bottom'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
				array(
			'id' => 'footer_bottom',
			'default' => true,
			'control' => array(
				'label' => __( 'Bottom Footer Area', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'If you disable this option we recommend you go to the Customizer Manager and disable the section as well so the next time you work with the Customizer it will load faster.', 'wpex' ),
			),
		),
		array(
			'id' => 'footer_copyright_text',
			'default' => 'Copyright <a href="#">Your Business LLC.</a> - All Rights Reserved',
			'control' => array(
				'label' => __( 'Copyright', 'wpex' ),
				'type' => 'textarea',
				'active_callback' => 'wpex_customizer_has_footer_bottom',
			),
		),
		array(
			'id' => 'bottom_footer_text_align',
			'control' =>  array(
				'type' => 'select',
				'label' => __( 'Text Align', 'wpex' ),
				'choices' => array(
					'default' => __( 'Default','wpex' ),
					'left' => __( 'Left','wpex' ),
					'right' => __( 'Right','wpex' ),
					'center' => __( 'Center','wpex' ),
				),
				'active_callback'=> 'wpex_customizer_has_footer_bottom',
			),
			'inline_css' => array(
				'target' => '#footer-bottom',
				'alter' => 'text-align',
			),
		),
		array(
			'id' => 'bottom_footer_padding',
			'control' =>  array(
				'type' => 'text',
				'label' => __( 'Padding', 'wpex' ),
				'description' => __( 'Format: top right bottom left.', 'wpex' ),
				'active_callback'=> 'wpex_customizer_has_footer_bottom',
			),
			'inline_css' => array(
				'target' => '#footer-bottom',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'bottom_footer_background',
			'control' =>  array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
				'active_callback'=> 'wpex_customizer_has_footer_bottom',
			),
			'inline_css' => array(
				'target' => '#footer-bottom',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'bottom_footer_color',
			'control' =>  array(
				'type' => 'color',
				'label' => __( 'Color', 'wpex' ),
				'active_callback'=> 'wpex_customizer_has_footer_bottom',
			),
			'inline_css' => array(
				'target' => array(
					'#footer-bottom',
					'#footer-bottom p',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'bottom_footer_link_color',
			'control' =>  array(
				'type' => 'color',
				'label' => __( 'Links', 'wpex' ),
				'active_callback'=> 'wpex_customizer_has_footer_bottom',
			),
			'inline_css' => array(
				'target' => '#footer-bottom a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'bottom_footer_link_color_hover',
			'control' =>  array(
				'type' => 'color',
				'label' => __( 'Links: Hover', 'wpex' ),
				'active_callback'=> 'wpex_customizer_has_footer_bottom',
			),
			'inline_css' => array(
				'target' => '#footer-bottom a:hover',
				'alter' => 'color',
			),
		),
	),
);