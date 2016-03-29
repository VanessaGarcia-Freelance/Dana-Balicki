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
$this->sections['wpex_callout'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'callout',
			'default' => '1',
			'control' => array (
				'label' => __( 'Enable', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'If you disable this option we recommend you go to the Customizer Manager and disable the section as well so the next time you work with the Customizer it will load faster.', 'wpex' ),
			),
		),
		array(
			'id' => 'callout_visibility',
			'control' => array (
				'label' => __( 'Visibility', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_visibility(),
				'active_callback' => 'wpex_customizer_has_callout',
			),
		),
		array(
			'id' => 'callout_text',
			'default' => 'I am the footer call-to-action block, here you can add some relevant/important information about your company or product. I can be disabled in the theme options.',
			'control' => array (
				'label' => __( 'Content', 'wpex' ),
				'type' => 'textarea',
				'active_callback' => 'wpex_customizer_has_callout',
				'description' => __( 'If you enter the ID number of a page it will automatically display the content of such page.', 'wpex' ),
			),
		),
		/** Button **/
		array(
			'id' => 'callout_button_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Button', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_callout',
			),
		),
		array(
			'id' => 'callout_link',
			'default' => 'http://www.wpexplorer.com',
			'control' => array (
				'label' => __( 'Link URL', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_has_callout',
			),
		),
		array(
			'id' => 'callout_link_txt',
			'default' => 'Get In Touch',
			'control' => array (
				'label' => __( 'Link Text', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_callout_has_button',
			),
		),
		array(
			'id' => 'callout_button_target',
			'default' => 'blank',
			'control' => array (
				'label' => __( 'Link Target', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_customizer_callout_has_button',
				'choices' => array(
					'blank' => __( 'Blank', 'wpex' ),
					'self' => __( 'Self', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'callout_button_rel',
			'control' => array (
				'label' => __( 'Link Rel', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_customizer_callout_has_button',
				'choices' => array(
					'' => __( 'None', 'wpex' ),
					'nofollow' => __( 'Nofollow', 'wpex' ),
				),
			),
		),
		/** Styling **/
		array(
			'id' => 'callout_styling_heading',
			'control' => array(
				'type' => 'wpex-heading',
				'label' => __( 'Styling', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_callout',
			),
		),
		array(
			'id' => 'footer_callout_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_callout',
			),
			'inline_css' => array(
				'target' => '#footer-callout-wrap',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'footer_callout_border',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Border Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_callout',
			),
			'inline_css' => array(
				'target' => '#footer-callout-wrap',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'footer_callout_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Text Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_callout',
			),
			'inline_css' => array(
				'target' => '#footer-callout-wrap',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'footer_callout_link_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Links', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_callout',
			),
			'inline_css' => array(
				'target' => '.footer-callout-content a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'footer_callout_link_color_hover',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Links: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_callout',
			),
			'inline_css' => array(
			'target' => '.footer-callout-content a:hover',
			'alter' => 'color',
			),
		),
		array(
			'id' => 'callout_button_border_radius',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Button Border Radius', 'wpex' ),
				'active_callback' => 'wpex_customizer_callout_has_button',
			),
			'inline_css' => array(
				'target' => '#footer-callout .theme-button',
				'alter' => 'border-radius',
			),
		),
		array(
			'id' => 'footer_callout_button_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Button Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_callout_has_button',
			),
			'inline_css' => array(
				'target' => '#footer-callout .theme-button',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'footer_callout_button_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Button Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_callout_has_button',
			),
			'inline_css' => array(
				'target' => '#footer-callout .theme-button',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'footer_callout_button_hover_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Button: Hover Background', 'wpex' ),
				'active_callback' => 'wpex_customizer_callout_has_button',
			),
			'inline_css' => array(
				'target' => '#footer-callout .theme-button:hover',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'footer_callout_button_hover_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Button: Hover Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_callout_has_button',
			),
			'inline_css' => array(
				'target' => '#footer-callout .theme-button:hover',
				'alter' => 'color',
			),
		),
	),
);