<?php
/**
 * Menu Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_navbar'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'menu_arrow_down',
			'default' => false,
			'control' => array (
				'label' => __( 'Top Level Dropdown Icon', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'menu_arrow_side',
			'default' => true,
			'control' => array (
				'label' => __( 'Second+ Level Dropdown Icon', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'menu_dropdown_top_border',
			'default' => false,
			'control' => array (
				'label' => __( 'Dropdown Top Border', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'menu_flush_dropdowns',
			'default' => false,
			'control' => array (
				'label' => __( 'Flush Dropdowns', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_navbar_supports_flush_dropdowns'
			),
		),
		array(
			'id' => 'menu_dropdown_style',
			'default' => '',
			'control' => array (
				'label' => __( 'Dropdown Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Skin Default', 'wpex' ),
					'minimal' => __( 'Minimal', 'wpex' ),
					'black' => __( 'Black', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'menu_dropdown_dropshadow',
			'default' => '',
			'control' => array (
				'label' => __( 'Dropdown Dropshadow Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'None', 'wpex' ),
					'one' => __( 'One', 'wpex' ),
					'two' => __( 'Two', 'wpex' ),
					'three' => __( 'Three', 'wpex' ),
					'four' => __( 'Four', 'wpex' ),
				),
			),
		),

		/*** Search Icon ***/
		array(
			'id' => 'navbar_search_icon_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Search Icon', 'wpex' ),
			),
		),
		array(
			'id' => 'menu_search_style',
			'default' => 'drop_down',
			'control' => array (
				'label' => __( 'Search Icon Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'disabled' => __( 'Disabled','wpex' ),
					'drop_down' => __( 'Drop Down','wpex' ),
					'overlay' => __( 'Site Overlay','wpex' ),
					'header_replace' => __( 'Header Replace','wpex' )
				),
				'description' => __( 'Vertical header styles only support the disabled and overlay styles.', 'wpex' ),
			),
		),
		array(
			'id' => 'search_dropdown_top_border',
			'control' => array (
				'label' => __( 'Search Dropdown Top Border', 'wpex' ),
				'type' => 'color',
				'active_callback' => 'wpex_has_menu_search_dropdown',
			),
			'inline_css' => array(
				'target' => '#searchform-dropdown',
				'alter'  => 'border-top-color',
			),
		),

		/*** Main Styling ***/
		array(
			'id' => 'menu_main_styling_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Styling: Main', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_mobile_menu_icons',
			),
		),
		array(
			'id' => 'menu_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation-wrap, .is-sticky .fixed-nav',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'menu_borders',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Borders', 'wpex' ),
				'description' => __( 'Not all menus have borders, but this setting is for those that do', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'#site-navigation li',
					'#site-navigation a',
					'#site-navigation ul',
					'#site-navigation-wrap',
					'#site-navigation',
					'.navbar-style-six #site-navigation',
				),
				'alter' => 'border-color',
			),
		),
		// Menu Link Colors
		array(
			'id' => 'menu_link_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > li > a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'menu_link_color_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > li > a:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'menu_link_color_active',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color: Current Menu Item', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > .current-menu-item > a,
							#site-navigation .dropdown-menu > .current-menu-parent > a,
							#site-navigation .dropdown-menu > .current-menu-item > a:hover,
							#site-navigation .dropdown-menu > .current-menu-parent > a:hover',
				'alter' => 'color',
			),
		),
		// Link Background
		array(
			'id' => 'menu_link_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > li > a',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'menu_link_hover_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Background: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > li > a:hover',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'menu_link_active_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Background: Current Menu Item', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > .current-menu-item > a,
							#site-navigation .dropdown-menu > .current-menu-parent > a,
							#site-navigation .dropdown-menu > .current-menu-item > a:hover,
							#site-navigation .dropdown-menu > .current-menu-parent > a:hover',
				'alter' => 'background-color',
			),
		),
		// Link Inner
		array(
			'id' => 'menu_link_span_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Inner Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > li > a > span.link-inner',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'menu_link_span_hover_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Inner Background: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > li > a:hover > span.link-inner',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'menu_link_span_active_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Inner Background: Current Menu Item', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-navigation .dropdown-menu > .current-menu-item > a > span.link-inner,
							#site-navigation .dropdown-menu > .current-menu-parent > a > span.link-inner,
							#site-navigation .dropdown-menu > .current-menu-item > a:hover > span.link-inner,
							#site-navigation .dropdown-menu > .current-menu-parent > a:hover > span.link-inner',
				'alter' => 'background-color',
			),
		),

		/**** Dropdown Styling ****/
		array(
			'id' => 'menu_dropdowns_styling_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Styling: Dropdowns', 'wpex' ),
			),
		),

		// Menu Dropdowns
		array(
			'id' => 'dropdown_menu_background',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-header #site-navigation .dropdown-menu ul',
				'alter' => 'background-color',
			),
		),
		// Pointer
		array(
			'id' => 'dropdown_menu_pointer_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Pointer Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.wpex-dropdowns-caret .dropdown-menu ul:after',
				'alter' => 'border-bottom-color',
			),
		),
		array(
			'id' => 'dropdown_menu_pointer_border',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Pointer Border', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.wpex-dropdowns-caret .dropdown-menu ul:before',
				'alter' => 'border-bottom-color',
			),
		),
		// Borders
		array(
			'id' => 'dropdown_menu_borders',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Dropdown Borders', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
						'#site-header #site-navigation .dropdown-menu ul',
						'#site-header #site-navigation .dropdown-menu ul li',
						'#site-header #site-navigation .dropdown-menu ul li a',
				),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'menu_dropdown_top_border_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Top Border', 'wpex' ),
				'active_callback' => 'wpex_has_menu_dropdown_top_border',
			),
			'inline_css' => array(
				'target' => array(
						'.wpex-dropdown-top-border #site-navigation .dropdown-menu li ul',
						'#searchform-dropdown',
						'#current-shop-items-dropdown',
				),
				'alter' => 'border-top-color',
			),
		),
		// Link color
		array(
			'id' => 'dropdown_menu_link_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-header #site-navigation .dropdown-menu ul > li > a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'dropdown_menu_link_color_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-header #site-navigation .dropdown-menu ul > li > a:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'dropdown_menu_link_hover_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Background: Hover', 'wpex' ),
			),
			'subtitle' => __( 'Select your custom hex color.', 'wpex' ),
			'inline_css' => array(
				'target' => '#site-header #site-navigation .dropdown-menu ul > li > a:hover',
				'alter' => 'background-color',
			),
		),
		// Current item
		array(
			'id' => 'dropdown_menu_link_color_active',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color: Current Menu Item', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-header #site-navigation .dropdown-menu ul > .current-menu-item > a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'dropdown_menu_link_bg_active',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Background: Current Menu Item', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-header #site-navigation .dropdown-menu ul > .current-menu-item > a',
				'alter' => 'background-color',
			),
		),
		// Mega menu
		array(
			'id' => 'mega_menu_title',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Megamenu Subtitle Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-header #site-navigation .sf-menu > li.megamenu > ul.sub-menu > .menu-item-has-children > a',
				'alter' => 'color',
			),
		),

	),
);