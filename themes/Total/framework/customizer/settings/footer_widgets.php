<?php
/**
 * Customizer => Footer Widgets
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_footer_widgets'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'footer_widgets',
			'default' => true,
			'control' => array(
				'label' => __( 'Footer Widgets', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'If you disable this option we recommend you go to the Customizer Manager and disable the section as well so the next time you work with the Customizer it will load faster.', 'wpex' ),
			),
		),
		array(
			'id' => 'fixed_footer',
			'default' => false,
			'control' => array(
				'label' => __( 'Fixed Footer', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'This setting will not "fix" your footer per-se but will add a min-height to your #main container to keep your footer always at the bottom of the page.', 'wpex' ),
			),
		),
		array(
			'id' => 'footer_reveal',
			'control' => array(
				'label' => __( 'Footer Reveal', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'Enable the footer reveal style. The footer will be placed in a fixed postion and display on scroll. This setting is for the "Full-Width" layout only and desktops only.', 'wpex' ),
				'active_callback' => 'wpex_customizer_supports_reveal',
			),
		),
		array(
			'id' => 'footer_headings',
			'default' => 'div',
			'control' => array(
				'label' => __( 'Footer Widget Title Headings', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'span' => 'span',
					'div' => 'div',
				),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
		),
		array(
			'id' => 'footer_widgets_columns',
			'default' => '4',
			'control' => array(
				'label' => __( 'Columns', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
		),
		array(
			'id' => 'footer_widgets_gap',
			'control' => array(
				'label' => __( 'Footer Widgets Gap', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_column_gaps(),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
		),
		array(
			'id' => 'footer_padding',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Padding', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
				'description' => __( 'Format: top right bottom left.', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#footer-inner',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'footer_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
			'inline_css' => array(
				'target' => '#footer',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'footer_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
			'inline_css' => array(
				'target' => array(
					'#footer',
					'#footer p',
					'#footer li a:before',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'footer_borders',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Borders', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
			'inline_css' => array(
				'target' => array(
					'#footer li',
					'#footer #wp-calendar thead th',
					'#footer #wp-calendar tbody td',
				),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'footer_link_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Links', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
			'inline_css' => array(
				'target' => '#footer a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'footer_link_color_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Links: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_footer_widgets',
			),
			'inline_css' => array(
				'target' => '#footer a:hover',
				'alter' => 'color',
			),
		),
	),
);