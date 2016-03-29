<?php
/**
 * Sidebar Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$this->sections['wpex_sidebar'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'sidebar_headings',
			'default' => 'div',
			'control' => array (
				'label' => __( 'Sidebar Widget Title Headings', 'wpex' ),
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
			),
		),
		array(
			'id' => 'has_widget_icons',
			'default' => '1',
			'control' => array (
				'label' => __( 'Widget Icons', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'Certain widgets include little icons such as the recent posts widget. Here you can toggle the icons on or off.', 'wpex' ),
			),
		),
		array(
			'id' => 'sidebar_background',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#sidebar',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'sidebar_padding',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Padding', 'wpex' ),
				'description' => __( 'Format: top right bottom left.', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#sidebar',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'sidebar_headings_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Headings Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'#sidebar .widget-title',
					'#sidebar .widget-title a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'sidebar_text_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Text Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'#sidebar',
					'#sidebar p',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'sidebar_borders_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Li & Calendar Borders', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'#sidebar li',
					'#sidebar #wp-calendar thead th',
					'#sidebar #wp-calendar tbody td',
				),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'sidebar_link_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Link Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#sidebar a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'sidebar_link_color_hover',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Link Color: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#sidebar a:hover',
				'alter' => 'color',
			),
		),
	),
);