<?php
/**
 * Staff Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Single blocks
$blocks = apply_filters( 'wpex_staff_single_blocks', array(
	'title' => __( 'Post Title', 'wpex' ),
	'media' => __( 'Media', 'wpex' ),
	'content' => __( 'Content', 'wpex' ),
	'share' => __( 'Social Share', 'wpex' ),
	'comments' => __( 'Comments', 'wpex' ),
	'related' => __( 'Related Posts', 'wpex' ),
) );

// General
$this->sections['wpex_staff_general'] = array(
	'title' => __( 'General', 'wpex' ),
	'panel' => 'wpex_staff',
	'settings' => array(
		array(
			'id' => 'staff_page',
			'default' => '',
			'control' => array(
				'label' => __( 'Main Page', 'wpex' ),
				'type' => 'wpex-dropdown-pages',
				'desc' => __( 'Used for breadcrumbs.', 'wpex' ),
			),
		),
		array(
			'id' => 'staff_custom_sidebar',
			'default' => true,
			'control' => array(
				'label' => __( 'Custom Post Type Sidebar', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'staff_search',
			'default' => true,
			'control' => array(
				'label' => __( 'Include In Search', 'wpex' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Archives
$this->sections['wpex_staff_archives'] = array(
	'title' => __( 'Archives', 'wpex' ),
	'panel' => 'wpex_staff',
	'desc' => __( 'The following options are for the post type category and tag archives.', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'staff_archive_layout',
			'default' => 'full-width',
			'control' => array(
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
					'full-width' => __( 'No Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'staff_archive_grid_style',
			'default' => 'fit-rows',
			'control' => array(
				'label' => __( 'Grid Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'fit-rows' => __( 'Fit Rows','wpex' ),
					'masonry' => __( 'Masonry','wpex' ),
					'no-margins' => __( 'No Margins','wpex' ),
				),
			),
		),
		array(
			'id' => 'staff_archive_grid_equal_heights',
			'default' => '',
			'control' => array(
				'label' => __( 'Equal Heights', 'wpex' ),
				'type' => 'checkbox',
				'desc'   => __( 'Displays the content containers (with the title and excerpt) in equal heights. Will NOT work with the "Masonry" layouts.', 'wpex' ),
			),
		),
		array(
			'id' => 'staff_entry_columns',
			'default' => '3',
			'control' => array(
				'label' => __( 'Columns', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_grid_columns(),
			),
		),
		array(
			'id' => 'staff_archive_posts_per_page',
			'default' => '12',
			'control' => array(
				'label' => __( 'Posts Per Page', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'staff_entry_overlay_style',
			'default' => 'none',
			'control' => array(
				'label' => __( 'Archives Entry: Overlay Style', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_overlay_styles_array()
			),
		),
		array(
			'id' => 'staff_entry_details',
			'default' => true,
			'control' => array(
				'label' => __( 'Archives Entry: Details', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'staff_entry_position',
			'default' => true,
			'control' => array(
				'label' => __( 'Archives Entry: Position', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'staff_entry_excerpt_length',
			'default' => '20',
			'control' => array(
				'label' => __( 'Archives Entry: Excerpt Length', 'wpex' ),
				'type' => 'text',
				'desc' => __( 'Enter 0 or leave blank to disable', 'wpex' ),
			),
		),
		array(
			'id' => 'staff_entry_social',
			'default' => true,
			'control' => array(
				'label' => __( 'Archives Entry: Social Links', 'wpex' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Single
$this->sections['wpex_staff_single'] = array(
	'title' => __( 'Single', 'wpex' ),
	'panel' => 'wpex_staff',
	'settings' => array(
		array(
			'id' => 'staff_single_layout',
			'default' => 'right-sidebar',
			'control' => array(
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
					'full-width' => __( 'No Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'staff_next_prev',
			'default' => true,
			'control' => array(
				'label' => __( 'Next & Previous Links', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'staff_related_title',
			'default' => '',
			'control' => array(
				'label' => __( 'Related Posts Title', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'staff_related_count',
			'default' => '3',
			'control' => array(
				'label' => __( 'Related Posts Count', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'staff_related_columns',
			'default' => '3',
			'control' => array(
				'label' => __( 'Related Posts Columns', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_grid_columns(),
			),
		),
		array(
			'id' => 'staff_related_excerpts',
			'default' => true,
			'control' => array(
				'label' => __( 'Related Posts Content', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'staff_post_composer',
			'default' => 'content,related',
			'control' => array(
				'label' => __( 'Post Layout Elements', 'wpex' ),
				'type' => 'wpex-sortable',
				'choices' => $blocks,
				'desc' => __( 'Click and drag and drop elements to re-order them. Click the "x" to disable any element. You can not disable all elements, if you do so it will display them all', 'wpex' ),
			),
		),
	),
);