<?php
/**
 * Portfolio Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Single Blocks
$blocks = apply_filters( 'wpex_portfolio_single_blocks', array(
    'title' => __( 'Post Title', 'wpex' ),
    'meta' => __( 'Post Meta', 'wpex' ),
    'media' => __( 'Media', 'wpex' ),
    'content' => __( 'Content', 'wpex' ),
    'share' => __( 'Social Share', 'wpex' ),
    'comments' => __( 'Comments', 'wpex' ),
    'related' => __( 'Related Posts', 'wpex' ),
) );

// General
$this->sections['wpex_portfolio_general'] = array(
	'title' => __( 'General', 'wpex' ),
	'panel' => 'wpex_portfolio',
	'settings' => array(
		array(
			'id' => 'portfolio_page',
			'default' => '',
			'control' => array(
				'label' => __( 'Main Page', 'wpex' ),
				'type' => 'wpex-dropdown-pages',
				'description' => __( 'Used for breadcrumbs.', 'wpex' ),
			),
		),
		array(
			'id' => 'portfolio_custom_sidebar',
			'default' => true,
			'control' => array(
				'label' => __( 'Custom Post Type Sidebar', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'portfolio_search',
			'default' => true,
			'control' => array(
				'label' => __( 'Include In Search', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'portfolio_entry_excerpt_length',
			'default' => '20',
			'control' => array(
				'label' => __( 'Archives Entry: Excerpt Length', 'wpex' ),
				'type' => 'text',
			),
		),
	),
);

// Archives
$this->sections['wpex_portfolio_archives'] = array(
	'title' => __( 'Archives & Entries', 'wpex' ),
	'panel' => 'wpex_portfolio',
	'desc' => __( 'The following options are for the post type category and tag archives.', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'portfolio_archive_layout',
			'default' => 'full-width',
			'control' => array(
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices'   => array(
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
					'full-width' => __( 'No Sidebar','wpex' ),
					'full-screen' => __( 'Full-Screen','wpex' ),
				),
			),
		),
		array(
			'id' => 'portfolio_archive_grid_style',
			'default' => 'fit-rows',
			'control' => array(
				'label' => __( 'Grid Style', 'wpex' ),
				'type' => 'select',
				'choices'   => array(
					'fit-rows' => __( 'Fit Rows','wpex' ),
					'masonry' => __( 'Masonry','wpex' ),
					'no-margins' => __( 'No Margins','wpex' ),
				),
			),
		),
		array(
			'id' => 'portfolio_entry_columns',
			'default' => '4',
			'control' => array(
				'label' => __( 'Columns', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_grid_columns(),
			),
		),
		array(
			'id' => 'portfolio_archive_grid_equal_heights',
			'default' => '',
			'control' => array(
				'label' => __( 'Equal Heights', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_portfolio_style_supports_equal_heights',
			),
		),
		array(
			'id' => 'portfolio_archive_posts_per_page',
			'default' => '12',
			'control' => array(
				'label' => __( 'Posts Per Page', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'portfolio_entry_overlay_style',
			'default' => 'none',
			'control' => array(
				'label' => __( 'Archives Entry: Overlay Style', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_overlay_styles_array(),
			),
		),
		array(
			'id' => 'portfolio_entry_details',
			'default' => true,
			'control' => array(
				'label' => __( 'Archives Entry: Details', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'portfolio_entry_excerpt_length',
			'default' => '20',
			'control' => array(
				'label' => __( 'Archives Entry: Excerpt Length', 'wpex' ),
				'type' => 'text',
			),
		),
	),
);


// Single
$this->sections['wpex_portfolio_single'] = array(
	'title' => __( 'Single', 'wpex' ),
	'panel' => 'wpex_portfolio',
	'settings' => array(
		array(
			'id' => 'portfolio_single_layout',
			'default' => 'full-width',
			'control' => array(
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices'   => array(
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
					'full-width' => __( 'No Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'portfolio_next_prev',
			'default' => true,
			'control' => array(
				'label' => __( 'Next & Previous Links', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'portfolio_related_title',
			'default' => __( 'Related Projects', 'wpex' ),
			'control' => array(
				'label' => __( 'Related Posts Title', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_has_portfolio_related',
			),
		),
		array(
			'id' => 'portfolio_related_count',
			'default' => 4,
			'control' => array(
				'label' => __( 'Related Posts Count', 'wpex' ),
				'type' => 'number',
				'active_callback' => 'wpex_customizer_has_portfolio_related',
			),
		),
		array(
			'id' => 'portfolio_related_columns',
			'default' => '4',
			'control' => array(
				'label' => __( 'Related Posts Columns', 'wpex' ),
				'type' => 'select',
				'choices'   => wpex_grid_columns(),
				'active_callback' => 'wpex_customizer_has_portfolio_related',
			),
		),
		array(
			'id' => 'portfolio_related_excerpts',
			'default' => true,
			'control' => array(
				'label' => __( 'Related Posts Content', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_portfolio_related',
			),
		),
		array(
			'id' => 'portfolio_post_composer',
			'default' => 'content,share,related',
			'control' => array(
				'label' => __( 'Post Layout Elements', 'wpex' ),
				'type' => 'wpex-sortable',
				'choices' => $blocks,
				'desc' => __( 'Click and drag and drop elements to re-order them. Click the "x" to disable any element. You can not disable all elements, if you do so it will display them all', 'wpex' ),
			),
		),
	),
);