<?php
/**
 * Customizer => Top Bar
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Social styles
$social_styles = array(
	'' => __( 'Minimal', 'wpex' ),
	'colored-icons' => __( 'Colored Image Icons (Legacy)', 'wpex' ),
);
$social_styles = array_merge( wpex_social_button_styles(), $social_styles );
unset( $social_styles[''] );

// General
$this->sections['wpex_topbar'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'top_bar',
			'default' => true,
			'control' => array(
				'label' => __( 'Enable', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'If you disable this option we recommend you go to the Customizer Manager and disable the section as well so the next time you work with the Customizer it will load faster.', 'wpex' ),
			),
		),
		array(
			'id' => 'top_bar_sticky',
			'default' => false,
			'control' => array(
				'label' => __( 'Sticky', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_topbar',
			),
		),
		array(
			'id' => 'top_bar_style',
			'default' => 'one',
			'control' => array(
				'label' => __( 'Style', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_customizer_has_topbar',
				'choices' => array(
					'one' => __( 'Left Content & Right Social', 'wpex' ),
					'two' => __( 'Left Social & Right Content', 'wpex' ),
					'three' => __( 'Centered Content & Social', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'top_bar_visibility',
			'default' => 'always-visible',
			'control' => array(
				'label' => __( 'Visibility', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_visibility(),
				'active_callback' => 'wpex_customizer_has_topbar',
			),
		),
		array(
			'id' => 'top_bar_content',
			'default' => '[font_awesome icon="phone" margin_right="5px" color="#000"] 1-800-987-654 [font_awesome icon="envelope" margin_right="5px" margin_left="20px" color="#000"] admin@total.com [font_awesome icon="user" margin_right="5px" margin_left="20px" color="#000"] [wp_login_url text="User Login" logout_text="Logout"]',
			'control' => array(
				'label' => __( 'Content', 'wpex' ),
				'type' => 'textarea',
				'active_callback' => 'wpex_customizer_has_topbar',
				'description' => __( 'If you enter the ID number of a page it will automatically display the content of such page.', 'wpex' ),
			),
		),
		// main styling
		array(
			'id' => 'top_bar_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_topbar',
			),
			'inline_css' => array(
				'target' => array(
					'#top-bar-wrap',
					'.wpex-top-bar-sticky',
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'top_bar_border',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Borders', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_topbar',
			),
			'inline_css' => array(
				'target' => '#top-bar-wrap',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'top_bar_text',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_topbar',
			),
			'inline_css' => array(
				'target' => array(
					'#top-bar-wrap',
					'#top-bar-content strong',
				),
				'alter' => 'color',
			),
		),
		// link colors
		array(
			'id' => 'top_bar_link_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_topbar',
			),
			'inline_css' => array(
				'target' => array(
					'#top-bar-content a',
					'#top-bar-social-alt a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'top_bar_link_color_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Link Color: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_topbar',
			),
			'inline_css' => array(
				'target' => array(
					'#top-bar-content a:hover',
					'#top-bar-social-alt a:hover',
				),
				'alter' => 'color',
			),
		),
		/** Social **/
		array(
			'id' => 'topbar_social_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Enable Social Links', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_topbar',
			),
		),
		array(
			'id' => 'top_bar_social',
			'default' => true,
			'control' => array(
				'label' => __( 'Social', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_topbar',
			),
		),
		array(
			'id' => 'top_bar_social_alt',
			'control' => array(
				'label' => __( 'Social Alternative', 'wpex' ),
				'type' => 'textarea',
				'active_callback' => 'wpex_customizer_has_topbar',
				'description' => __( 'If you enter the ID number of a page it will automatically display the content of such page.', 'wpex' ),
			),
		),
		array(
			'id' => 'top_bar_social_target',
			'default' => 'blank',
			'control' => array(
				'label' => __( 'Social Link Target', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'blank' => __( 'New Window', 'wpex' ),
					'self' => __( 'Same Window', 'wpex' ),
				),
				'active_callback' => 'wpex_customizer_has_topbar_social',
			),
		),
		array(
			'id' => 'top_bar_social_style',
			'default' => 'none',
			'control' => array(
				'label' => __( 'Social Style', 'wpex' ),
				'type' => 'select',
				'choices' => $social_styles,
				'active_callback' => 'wpex_customizer_has_topbar_social',
			),
		),
		array(
			'id' => 'top_bar_social_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Social Links Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_topbar_social_style_is_none',
			),
			'inline_css' => array(
				'target' => '#top-bar-social a.wpex-social-btn-no-style',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'top_bar_social_hover_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Social Links Hover Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_topbar_social_style_is_none',
			),
			'inline_css' => array(
				'target' => '#top-bar-social a.wpex-social-btn-no-style:hover',
				'alter' => 'color',
			),
		),
	),
);

// Social settings
$social_options = wpex_topbar_social_options();
foreach ( $social_options as $key => $val ) {
	$this->sections['wpex_topbar']['settings'][] = array(
		'id' => 'top_bar_social_profiles[' . $key .']',
		'control' => array(
			'label' => __( $val['label'], 'wpex' ),
			'type' => 'text',
			'active_callback' => 'wpex_customizer_has_topbar_social',
		),
	);
}