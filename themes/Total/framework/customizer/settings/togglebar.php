<?php
/**
 * Toggle Bar Panel
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_togglebar'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'toggle_bar',
			'default' => true,
			'control' => array(
				'label' => __( 'Enable', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'If you disable this option we recommend you go to the Customizer Manager and disable the section as well so the next time you work with the Customizer it will load faster.', 'wpex' ),
			),
		),
		array(
			'id' => 'toggle_bar_page',
			'default' => '',
			'control' => array(
				'label' => __( 'Content', 'wpex' ),
				'type' => 'dropdown-pages',
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
		),
		array(
			'id' => 'toggle_bar_visibility',
			'default' => 'hidden-phone',
			'control' => array(
				'label' => __( 'Visibility', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_visibility(),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
		),
		array(
			'id' => 'toggle_bar_animation',
			'default' => 'fade',
			'control' => array(
				'label' => __( 'Animation', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'fade' => __( 'Fade', 'wpex' ),
					'fade-slide' => __( 'Fade & Slide Down', 'wpex' ),
				),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
		),
		array(
			'id' => 'toggle_bar_button_icon',
			'default' => 'plus',
			'control' => array(
				'label' => __( 'Button Icon', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_get_awesome_icons(),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
		),
		array(
			'id' => 'toggle_bar_button_icon_active',
			'default' => 'minus',
			'control' => array(
				'label' => __( 'Button Icon: Active', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_get_awesome_icons(),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
		),
		array(
			'id' => 'toggle_bar_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Content Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
			'inline_css' => array(
				'target' => '#toggle-bar-wrap',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'toggle_bar_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Content Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
			'inline_css' => array(
				'target' => array(
					'#toggle-bar-wrap',
					'#toggle-bar-wrap strong',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'toggle_bar_btn_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Button Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
			'inline_css' => array(
				'target' => '.toggle-bar-btn',
				'alter' => array( 'border-top-color', 'border-right-color' ),
			),
		),
		array(
			'id' => 'toggle_bar_btn_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Button Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
			'inline_css' => array(
				'target' => '.toggle-bar-btn span.fa',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'toggle_bar_btn_hover_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Button Hover Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
			'inline_css' => array(
				'target' => '.toggle-bar-btn:hover',
				'alter' => array( 'border-top-color', 'border-right-color' ),
			),
		),
		array(
			'id' => 'toggle_bar_btn_hover_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Button Hover Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_togglebar',
			),
			'inline_css' => array(
				'target' => '.toggle-bar-btn:hover span.fa',
				'alter' => 'color',
			),
		),
	)
);