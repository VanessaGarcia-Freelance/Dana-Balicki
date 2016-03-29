<?php
/**
 * Layout Panel
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_layout_general'] = array(
	'title' => __( 'General', 'wpex' ),
	'panel' => 'wpex_layout',
	'settings' => array(
		array(
			'id' => 'responsive',
			'default' => true,
			'control' => array(
				'label' => __( 'Responsiveness', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'If you are using the Visual Composer plugin, make sure to enable/disable the responsive settings at Settings->Visual composer as well.', 'wpex' ),
			),
		),
		array(
			'id' => 'container_max_width',
			'control' => array(
				'label' => __( 'Max Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 90%',
				'active_callback' => 'wpex_customizer_container_layout_supports_max_width',
			),
		),
		array(
			'id' => 'main_layout_style',
			'default' => 'full-width',
			'control' => array(
				'label' => __( 'Layout Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'full-width' => __( 'Full Width','wpex' ),
					'boxed' => __( 'Boxed','wpex' )
				),
			),
		),
		array(
			'id' => 'boxed_dropdshadow',
			'control' => array(
				'label' => __( 'Boxed Layout Drop-Shadow', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_boxed_layout',
			),
		),
		array(
			'id' => 'boxed_padding',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Outer Margin', 'wpex' ),
				'desc' => __( 'Default:', 'wpex' ) .' 40px 30px',
				'active_callback' => 'wpex_customizer_has_boxed_layout',
			),
			'inline_css' => array(
				'target' => '.boxed-main-layout #outer-wrap',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'boxed_wrap_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Inner Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_boxed_layout',
			),
			'inline_css' => array(
				'target' => '.boxed-main-layout #wrap,.is-sticky #site-header',
				'alter' => 'background-color',
			),
		),
	),
);

// Desktop Widths
$this->sections['wpex_layout_desktop_widths'] = array(
	'title' => __( 'Desktop Widths', 'wpex' ),
	'panel' => 'wpex_layout',
	'desc' => __( 'For screens greater than or equal to 1281px. Accepts both pixels or percentage values.', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'main_container_width',
			'control' => array(
				'label' => __( 'Main Container Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 980px',
			),
		),
		array(
			'id' => 'left_container_width',
			'control' => array(
				'label' => __( 'Content Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 69%',
			),
		),
		array(
			'id' => 'sidebar_width',
			'control' => array(
				'label' => __( 'Sidebar Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', '', 'Customizer' ) .' 26%',
			),
		),
	),
);

// Medium Screen Widths
$this->sections['wpex_layout_medium_widths'] = array(
	'title' => __( 'Medium Screens Widths', 'wpex' ),
	'panel' => 'wpex_layout',
	'desc' => __( 'For screens between 960px - 1280px. Such as landscape tablets and small monitors/laptops. Accepts both pixels or percentage values.', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'tablet_landscape_main_container_width',
			'control' => array(
				'label' => __( 'Main Container Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 90%',
			),
		),
		array(
			'id' => 'tablet_landscape_left_container_width',
			'control' => array(
				'label' => __( 'Content Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Same as desktop by default', 'Customizer Layouts', 'wpex' ),
			),
		),
		array(
			'id' => 'tablet_landscape_sidebar_width',
			'control' => array(
				'label' => __( 'Sidebar Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Same as desktop by default', 'Customizer Layouts', 'wpex' ),
			),
		),
	),
);

// Tablet Portrait Widths
$this->sections['wpex_layout_tablet_widths'] = array(
	'title' => __( 'Tablet Widths', 'wpex' ),
	'panel' => 'wpex_layout',
	'desc' => __( 'For screens between 768px - 959px. Such as portrait tablet. Accepts both pixels or percentage values.', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'tablet_main_container_width',
			'control' => array(
				'label' => __( 'Main Container Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 90%',
			),
		),
		array(
			'id' => 'tablet_left_container_width',
			'control' => array(
				'label' => __( 'Content Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 100%',
			),
		),
		array(
			'id' => 'tablet_sidebar_width',
			'control' => array(
				'label' => __( 'Sidebar Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 100%',
			),
		),
	),
);

// Mobile Phone Widths
$this->sections['wpex_layout_phone_widths'] = array(
	'title' => __( 'Mobile Phone Widths', 'wpex' ),
	'panel' => 'wpex_layout',
	'desc' => __( 'For screens between 0 - 767px. Accepts both pixels or percentage values.', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'mobile_landscape_main_container_width',
			'control' => array(
				'label' => __( 'Landscape: Main Container Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 90%',
			),
		),
		array(
			'id' => 'mobile_portrait_main_container_width',
			'control' => array(
				'label' => __( 'Portrait: Main Container Width', 'wpex' ),
				'type' => 'text',
				'desc' => _x( 'Default:', 'Customizer', 'wpex' ) .' 90%',
			),
		),
	),
);