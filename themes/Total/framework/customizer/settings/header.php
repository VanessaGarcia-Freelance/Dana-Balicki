<?php
/**
 * Header Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Header styles
$header_styles = apply_filters( 'wpex_header_styles', array(
	'one'   => __( 'One - Left Logo & Right Navbar','wpex' ),
	'two'   => __( 'Two - Bottom Navbar','wpex' ),
	'three' => __( 'Three - Bottom Navbar Centered','wpex' ),
	'four'  => __( 'Four - Top Navbar Centered','wpex' ),
	'five'  => __( 'Five - Centered Inline Logo','wpex' ),
	'six'   => __( 'Six - Vertical','wpex' ),
) );

/*-----------------------------------------------------------------------------------*/
/* - Header => General
/*-----------------------------------------------------------------------------------*/
$this->sections['wpex_header_general'] = array(
	'title' => __( 'General', 'wpex' ),
	'panel' => 'wpex_header',
	'settings' => array(
		array(
			'id' => 'header_style',
			'default' => 'one',
			'control' => array(
				'label' => __( 'Style', 'wpex' ),
				'type' => 'select',
				'choices' => $header_styles,
			),
		),
		array(
			'id' => 'vertical_header_style',
			'default' => 'one',
			'control' => array(
				'label' => __( 'Vertical Header Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'fixed' => __( 'Fixed', 'wpex' ),
				),
				'active_callback' => 'wpex_customizer_has_vertical_header',
			),
		),
		array(
			'id' => 'full_width_header',
			'default' => false,
			'control' => array(
				'label' => __( 'Full-Width', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_header_supports_full_width',
			),
		),
		array(
			'id' => 'header_background',
			'control' => array(
				'label' => __( 'Background', 'wpex' ),
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => array(
					'#site-header',
					'.wpex-sticky-header-holder',
					'.wpex-sticky-header-holder.is-sticky #site-header',
					'.wpex-sticky-header-holder',
					'#site-header.wpex-shrink-sticky-header',
					'.footer-has-reveal #site-header',
					'#searchform-header-replace',
					'body.wpex-has-vertical-header #site-header',
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'header_top_padding',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Top Padding', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'#site-header-inner',
					'#site-header.overlay-header #site-header-inner',
				),
				'alter' => 'padding-top',
				'sanitize' => 'px',
			),
		),
		array(
			'id' => 'header_bottom_padding',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Bottom Padding', 'wpex' ), 
			),
			'inline_css' => array(
				'target' => array(
					'#site-header-inner',
					'#site-header.overlay-header #site-header-inner',
				),
				'alter' => 'padding-bottom',
				'sanitize' => 'px',
			),
		),
		/*** Aside ***/
		array(
			'id' => 'header_aside_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Aside', 'wpex' ),
				'active_callback' => 'wpex_customizer_header_has_aside',
			),
		),
		array(
			'id' => 'header_aside_visibility',
			'default' => 'visible-desktop',
			'control' => array(
				'label' => __( 'Visibility', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_visibility(),
				'active_callback' => 'wpex_customizer_header_has_aside',
			),
		),
		array(
			'id' => 'header_aside_search',
			'default' => true,
			'control' => array(
				'label' => __( 'Header Aside Search', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_header_has_aside_search',
			),
		),
		array(
			'id' => 'header_aside',
			'control' => array(
				'label' => __( 'Header Aside Content', 'wpex' ),
				'type' => 'textarea',
				'active_callback' => 'wpex_customizer_header_has_aside',
				'description' => __( 'If you enter the ID number of a page it will automatically display the content of such page.', 'wpex' ),
			),
		),
	)
);

/*-----------------------------------------------------------------------------------*/
/* - Header => Logo
/*-----------------------------------------------------------------------------------*/
$this->sections['wpex_header_logo'] = array(
	'title' => __( 'Logo', 'wpex' ),
	'panel' => 'wpex_header',
	'settings' => array(
		array(
			'id' => 'logo_icon',
			'default' => '',
			'control' => array(
				'label' => __( 'Text Logo Icon', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_get_awesome_icons(),
				'active_callback' => 'wpex_customizer_hasnt_custom_logo',
			),
		),
		array(
			'id' => 'logo_icon_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Logo Icon Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_text_logo_icon',
			),
			'inline_css' => array(
				'target' => '#site-logo-fa-icon',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'logo_icon_right_margin',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Logo Icon Right Margin', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_text_logo_icon',
			),
			'inline_css' => array(
				'target' => '#site-logo-fa-icon',
				'alter' => 'margin-right',
			),
		),
		array(
			'id' => 'logo_top_margin',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Top Margin', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-logo',
				'alter' => 'padding-top',
				'sanitize' => 'px',
			),
		),
		array(
			'id' => 'logo_bottom_margin',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Bottom Margin', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-logo',
				'alter' => 'padding-bottom',
				'sanitize' => 'px',
			),
		),
		array(
			'id' => 'logo_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_hasnt_custom_logo',
			),
			'inline_css' => array(
				'target' => '#site-logo a.site-logo-text',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'logo_hover_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Hover Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_hasnt_custom_logo',
			),
			'inline_css' => array(
				'target' => '#site-logo a.site-logo-text:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'custom_logo',
			'default' => '',
			'control' => array(
				'label' => __( 'Image Logo', 'wpex' ),
				'type' => 'image',
			),
		),
		array(
			'id' => 'retina_logo',
			'default' => '',
			'control' => array(
				'label' => __( 'Retina Image Logo', 'wpex' ),
				'type' => 'image',
				'active_callback' => 'wpex_customizer_has_image_logo',
			),
		),
		array(
			'id' => 'retina_logo_height',
			'control' => array(
				'label' => __( 'Standard Retina Logo Height', 'wpex' ),
				'type' => 'text',
				'description' => __( 'Enter the height in pixels of your standard logo size in order to mantain proportions for your retina logo.', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_retina_logo',
			),
		),
		array(
			'id' => 'logo_max_width',
			'control' => array(
				'label' => __( 'Logo Max Width: Desktop', 'wpex' ),
				'type' => 'text',
				'description' => __( 'Screens 960px wide and greater.', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_image_logo',
			),
		),
		array(
			'id' => 'logo_max_width_tablet_portrait',
			'control' => array(
				'label' => __( 'Logo Max Width: Tablet Portrait', 'wpex' ),
				'type' => 'text',
				'description' => __( 'Screens 768px-959px wide.', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_image_logo',
			),
		),
		array(
			'id' => 'logo_max_width_phone',
			'control' => array(
				'label' => __( 'Logo Max Width: Phone', 'wpex' ),
				'type' => 'text',
				'description' => __( 'Screens smaller than 767px wide.', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_image_logo',
			),
		),
	)
);

/*-----------------------------------------------------------------------------------*/
/* - Header => Fixed On Scroll
/*-----------------------------------------------------------------------------------*/
$this->sections['wpex_header_fixed'] = array(
	'title' => __( 'Sticky Header', 'wpex' ),
	'panel' => 'wpex_header',
	'settings' => array(
		array(
			'id' => 'fixed_header',
			'default' => true,
			'control' => array(
				'label' => __( 'Sticky Header on Scroll', 'wpex' ),
				'type' => 'checkbox',
				'description' => __( 'For some header styles the entire header will be fixed for others only the menu.', 'wpex' ),
				'active_callback' => 'wpex_customizer_header_supports_sticky'
			),
		),
		array(
			'id' => 'shink_fixed_header',
			'default' => true,
			'control' => array(
				'label' => __( 'Shrink Sticky Header', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_fixed_header',
			),
		),
		array(
			'id' => 'fixed_header_shrink_logo_height',
			'default' => 50,
			'control' => array(
				'label' => __( 'Shrink Sticky Header Logo Height', 'wpex' ),
				'type' => 'number',
				'active_callback' => 'wpex_customizer_has_shrink_sticky_header',
			),
		),
		array(
			'id' => 'fixed_header_mobile',
			'control' => array(
				'label' => __( 'Sticky Header On Mobile', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_supports_fixed_header_mobile',
			),
		),
		array(
			'id' => 'fixed_header_logo',
			'control' => array(
				'label' => __( 'Sticky Header Custom Logo', 'wpex' ),
				'type' => 'image',
				'active_callback' => 'wpex_customizer_supports_fixed_header_logo',
			),
		),
		array(
			'id' => 'fixed_header_opacity',
			'control' => array(
				'type' => 'number',
				'label' => __( 'Sticky header Opacity', 'wpex' ),
				'active_callback' => 'wpex_customizer_fixed_header_supports_opacity',
				'input_attrs' => array(
					'min' => 0,
        			'max' => 1,
        			'step' => 0.1,
        		),
			),
			'inline_css' => array(
				'target' => '.wpex-sticky-header-holder.is-sticky #site-header',
				'alter' => 'opacity',
			),
		),
	)
);