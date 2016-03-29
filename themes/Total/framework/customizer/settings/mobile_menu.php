<?php
/**
 * Footer Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_mobile_menu'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(

		/*** Toggle Style ***/
		array(
			'id' => 'mobile_menu_toggle_style',
			'default' => 'icon_buttons',
			'control' => array (
				'label' => __( 'Toggle Button Style', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_has_mobile_menu',
				'choices' => array(
					'icon_buttons' => __( 'Right Aligned Icon Button(s)', 'wpex' ),
					'icon_buttons_under_logo' => __( 'Under The Logo Icon Button(s)', 'wpex' ),
					'fixed_top'  => __( 'Fixed Site Top', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'mobile_menu_toggle_fixed_top_bg',
			'control' => array (
				'label' => __( 'Fixed Toggle Background', 'wpex' ),
				'type' => 'color',
				'active_callback' => 'wpex_customizer_is_mobile_toggle_fixed_top',
			),
			'inline_css' => array(
				'target' => '#wpex-mobile-menu-fixed-top',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'mobile_menu_toggle_text',
			'default' => _x( 'Menu', 'Mobile Menu Toggle Button Text', 'wpex' ),
			'control' => array (
				'label' => __( 'Text', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_is_mobile_toggle_fixed_top',
			),
		),

		/*** General */
		array(
			'id' => 'mobile_menu_style',
			'default' => 'sidr',
			'control' => array (
				'label' => __( 'Mobile Menu Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'sidr' => __( 'Sidebar', 'wpex' ),
					'toggle' => __( 'Toggle', 'wpex' ),
					'full_screen' => __( 'Full Screen Overlay', 'wpex' ),
					'disabled' => __( 'Disabled', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'full_screen_mobile_menu_style',
			'default' => 'white',
			'control' => array (
				'label' => __( 'Style', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_customizer_mobile_menu_is_full_screen',
				'choices' => array(
					'white'	=> __( 'White', 'wpex' ),
					'black'	=> __( 'Black', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'mobile_menu_sidr_direction',
			'default' => 'left',
			'control' => array (
				'label' => __( 'Direction', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
				'choices' => array(
					'left'	=> __( 'Left', 'wpex' ),
					'right'	=> __( 'Right', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'mobile_menu_sidr_displace',
			'default' => true,
			'control' => array (
				'label' => __( 'Displace', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
		),

		/*** Mobile Icons Styling ***/
		array(
			'id' => 'mobile_menu_sidr_styling_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Styling: Mobile Icons Menu', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
		),
		array(
			'id' => 'mobile_menu_icon_size',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Font Size', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
			'inline_css' => array(
				'target' => '#mobile-menu a',
				'alter' => 'font-size',
				'sanitize' => 'px',
			),
		),
		array(
			'id' => 'mobile_menu_icon_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
			'inline_css' => array(
				'target' => '#mobile-menu a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'mobile_menu_icon_color_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Color: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
			'inline_css' => array(
				'target' => '#mobile-menu a:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'mobile_menu_icon_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
			'inline_css' => array(
				'target' => '#mobile-menu a',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'mobile_menu_icon_background_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
			'inline_css' => array(
				'target' => '#mobile-menu a:hover',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'mobile_menu_icon_border',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Border', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
			'inline_css' => array(
				'target' => '#mobile-menu a',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'mobile_menu_icon_border_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Border: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
			'inline_css' => array(
				'target' => '#mobile-menu a:hover',
				'alter' => 'border-color',
			),
		),

		/*** Sidr Styling ***/
		array(
			'id' => 'mobile_menu_icons_styling_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Styling: Mobile Sidebar Menu', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
		),
		array(
			'id' => 'mobile_menu_sidr_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
			'inline_css' => array(
				'target' => '#sidr-main',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'mobile_menu_sidr_borders',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Borders', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
			'inline_css' => array(
				'target' => '#sidr-main li, #sidr-main ul',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'mobile_menu_links',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Links', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
			'inline_css' => array(
				'target' => '.sidr a, .sidr-class-dropdown-toggle',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'mobile_menu_links_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Links: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
			'inline_css' => array(
				'target' => '.sidr a:hover, .sidr-class-dropdown-toggle:hover, .sidr-class-dropdown-toggle .fa, .sidr-class-menu-item-has-children.active > a, .sidr-class-menu-item-has-children.active > a > .sidr-class-dropdown-toggle',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'mobile_menu_sidr_search_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Searchbar Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
			'inline_css' => array(
				'target' => array(
					'.sidr-class-mobile-menu-searchform input',
					'.sidr-class-mobile-menu-searchform input:focus',
					'.sidr-class-mobile-menu-searchform button',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'mobile_menu_sidr_search_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Searchbar Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_sidr',
			),
			'inline_css' => array(
				'target' => '.sidr-class-mobile-menu-searchform input',
				'alter' => 'background',
			),
		),

		/*** Toggle Menu ***/
		array(
			'id' => 'mobile_menu_toggle_menu_styling_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Styling: Mobile Toggle Menu', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_toggle',
			),
		),
		array(
			'id' => 'toggle_mobile_menu_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_toggle',
			),
			'inline_css' => array(
				'target' => array(
					'.mobile-toggle-nav',
					'.wpex-mobile-toggle-menu-fixed_top .mobile-toggle-nav',
				),
				'alter' => 'background',
			),
		),
		array(
			'id' => 'toggle_mobile_menu_borders',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Borders', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_toggle',
			),
			'inline_css' => array(
				'target' => array(
					'.mobile-toggle-nav a',
					'.wpex-mobile-toggle-menu-fixed_top .mobile-toggle-nav a',
				),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'toggle_mobile_menu_links',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Links', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_toggle',
			),
			'inline_css' => array(
				'target' => array(
					'.mobile-toggle-nav a',
					'.wpex-mobile-toggle-menu-fixed_top .mobile-toggle-nav a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'toggle_mobile_menu_links_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Links: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_mobile_menu_is_toggle',
			),
			'inline_css' => array(
				'target' => array(
					'.mobile-toggle-nav a:hover',
					'.wpex-mobile-toggle-menu-fixed_top .mobile-toggle-nav a:hover',
				),
				'alter' => 'color',
			),
		),

		/*** Full Site Overlay */

	),
);