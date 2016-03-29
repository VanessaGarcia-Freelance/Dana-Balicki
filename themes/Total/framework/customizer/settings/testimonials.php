<?php
/**
 * Testimonials Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_testimonials'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'testimonials_page',
			'control' => array (
				'label' => __( 'Main Page', 'wpex' ),
				'type' => 'dropdown-pages',
				'desc' => __( 'Used for breadcrumbs.', 'wpex' ),
			),
		),
		array(
			'id' => 'testimonials_custom_sidebar',
			'default' => 1,
			'control' => array (
				'label' => __( 'Custom Post Type Sidebar', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'testimonials_search',
			'default' => 1,
			'control' => array (
				'label' => __( 'Include In Search', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'testimonials_archive_layout',
			'default' => 'full-width',
			'control' => array (
				'label' => __( 'Archive Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
					'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
					'full-width'	=> __( 'No Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'testimonials_entry_columns',
			'default' => '4',
			'control' => array (
				'label' => __( 'Archive Columns', 'wpex' ), 
				'type' => 'select',
				'choices' => wpex_grid_columns(),
			),
		),
		array(
			'id' => 'testimonials_archive_posts_per_page',
			'default' => '12',
			'control' => array (
				'label' => __( 'Archive Posts Per Page', 'wpex' ),
				'type' => 'number',
			),
		),
		array(
			'id' => 'testimonial_entry_title',
			'control' => array (
				'label' => __( 'Archive Entry Title', 'wpex' ), 
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'testimonial_post_style',
			'default' => 'blockquote',
			'control' => array (
				'label' => __( 'Single Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'blockquote' => __( 'Blockquote', 'wpex' ),
					'standard' => __( 'Standard', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'testimonials_single_layout',
			'default' => 'right-sidebar',
			'control' => array (
				'label' => __( 'Single Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
					'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
					'full-width'	=> __( 'No Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'testimonials_comments',
			'control' => array (
				'label' => __( 'Comments', 'wpex' ), 
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'testimonials_next_prev',
			'default' => 1,
			'control' => array (
				'label' => __( 'Next & Previous Links', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'testimonial_entry_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Entry Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.testimonial-entry-content',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'testimonial_entry_pointer_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Entry Pointer Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.testimonial-caret',
				'alter' => 'border-top-color',
			),
		),
		array(
			'id' => 'testimonial_entry_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Entry Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.testimonial-entry-content',
					'.testimonial-entry-content a',
				),
				'alter' => 'color',
			),
		),
	),
);