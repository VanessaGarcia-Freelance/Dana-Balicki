<?php
/**
 * Blog Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Entry meta
$entry_meta_defaults = array( 'date', 'author', 'categories', 'comments' );
$entry_meta_choices = array(
	'date' => __( 'Date', 'wpex' ),
	'author' => __( 'Author', 'wpex' ),
	'categories' => __( 'Categories', 'wpex' ),
	'comments' => __( 'Comments', 'wpex' ),
);

// Entry Blocks
$entry_blocks = apply_filters( 'wpex_blog_entry_blocks', array(
	'featured_media' => __( 'Media', 'wpex' ),
	'title' => __( 'Title', 'wpex' ),
	'meta' => __( 'Meta', 'wpex' ),
	'excerpt_content' => __( 'Excerpt', 'wpex' ),
	'readmore' => __( 'Read More', 'wpex' ),
	'social_share' => __( 'Social Share', 'wpex' ),
) );

// Single Blocks
$single_blocks = apply_filters( 'wpex_blog_single_blocks', array(
	'featured_media' => __( 'Featured Media','wpex' ),
	'title' => __( 'Title', 'wpex' ),
	'meta' => __( 'Meta', 'wpex' ),
	'post_series' => __( 'Post Series','wpex' ),
	'the_content' => __( 'Content','wpex' ),
	'post_tags' => __( 'Post Tags','wpex' ),
	'social_share' => __( 'Social Share','wpex' ),
	'author_bio' => __( 'Author Bio','wpex' ),
	'related_posts' => __( 'Related Posts','wpex' ),
	'comments' => __( 'Comments','wpex' ),
) );

// General
$this->sections['wpex_blog_general'] = array(
	'title' => __( 'General', 'wpex' ),
	'panel' => 'wpex_blog',
	'settings' => array(
		array(
			'id' => 'blog_page',
			'control' => array(
				'label' => __( 'Main Page', 'wpex' ),
				'type' => 'wpex-dropdown-pages',
			),
		),
		array(
			'id' => 'blog_cats_exclude',
			'control' => array(
				'label' => __( 'Exclude Categories From Blog', 'wpex' ),
				'type' => 'text',
				'desc' => __( 'Enter the ID\'s of categories to exclude from the blog template or homepage blog seperated by a comma (no spaces).', 'wpex' ),
			),
		),
	),
);

// Archives
$this->sections['wpex_blog_archives'] = array(
	'title' => __( 'Archives & Entries', 'wpex' ),
	'panel' => 'wpex_blog',
	'settings' => array(
		array(
			'id' => 'category_description_position',
			'default' => '',
			'control' => array(
				'label' => __( 'Category Description Position', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					''			 => __( 'Default', 'wpex' ),
					'under_title' => __( 'Under Title', 'wpex' ),
					'above_loop' => __( 'Above Loop', 'wpex' ),
					'hidden' => __( 'Hidden', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'blog_archives_layout',
			'default' => '',
			'control' => array(
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
					'full-width' => __( 'No Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'blog_style',
			'default' => '',
			'control' => array(
				'label' => __( 'Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'large-image-entry-style' => __( 'Large Image','wpex' ),
					'thumbnail-entry-style' => __( 'Left Thumbnail','wpex' ),
					'grid-entry-style' => __( 'Grid','wpex' ),
				),
			),
		),
		array(
			'id' => 'blog_grid_columns',
			'default' => '',
			'control' => array(
				'label' => __( 'Grid Columns', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_customizer_grid_blog_style',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
			),
		),
		array(
			'id' => 'blog_grid_style',
			'default' => '',
			'control' => array(
				'label' => __( 'Grid Style', 'wpex' ),
				'type' => 'select',
				'std' => '',
				'active_callback' => 'wpex_customizer_grid_blog_style',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'fit-rows' => __( 'Fit Rows', 'wpex' ),
					'masonry' => __( 'Masonry', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'blog_archive_grid_equal_heights',
			'control' => array(
				'label' => __( 'Equal Heights', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_blog_supports_equal_heights',
			),
		),
		array(
			'id' => 'blog_pagination_style',
			'default' => '',
			'control' => array(
				'label' => __( 'Pagination Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'standard' => __( 'Standard', 'wpex' ),
					'infinite_scroll' => __( 'Infinite Scroll', 'wpex' ),
					'next_prev' => __( 'Next/Prev', 'wpex' )
				),
			),
		),
		array(
			'id' => 'blog_entry_image_lightbox',
			'control' => array(
				'label' => __( 'Image Lightbox', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_blog_entry_media',
			),
		),
		array(
			'id' => 'blog_entry_overlay',
			'control' => array(
				'label' => __( 'Overlay Style', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_overlay_styles_array(),
				'active_callback' => 'wpex_customizer_has_blog_entry_media',
			),
		),
		array(
			'id' => 'blog_entry_image_hover_animation',
			'control' => array(
				'label' => __( 'Image Hover Animation', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_image_hovers(),
				'active_callback' => 'wpex_customizer_has_blog_entry_media',
			),
		),
		array(
			'id' => 'blog_exceprt',
			'default' => 'on',
			'control' => array(
				'label' => __( 'Auto Excerpts', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_blog_entry_excerpt',
			),
		),
		array(
			'id' => 'blog_excerpt_length',
			'default' => '40',
			'control' => array(
				'label' => __( 'Excerpt length', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_has_blog_entry_excerpt',
			),
		),
		array(
			'id' => 'blog_entry_readmore_text',
			'default' => __( 'Read More', 'wpex' ),
			'control' => array(
				'label' => __( 'Read More Button Text', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_has_blog_entry_readmore',
			),
		),
		array(
			'id' => 'blog_entry_author_avatar',
			'control' => array(
				'label' => __( 'Author Avatar', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'blog_entry_video_output',
			'default' => true,
			'control' => array(
				'label' => __( 'Display Featured Videos?', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'blog_entry_meta_sections',
			'default' => $entry_meta_defaults,
			'control' => array(
				'label' => __( 'Meta', 'wpex' ),
				'type' => 'multiple-select',
				'object' => 'WPEX_Customize_Multicheck_Control',
				'choices' => $entry_meta_choices,
				'active_callback' => 'wpex_customizer_has_blog_entry_meta',
			),
		),
		array(
			'id' => 'blog_entry_composer',
			'default' => 'featured_media,title,meta,excerpt_content,readmore',
			'control' => array(
				'label' => __( 'Entry Layout Elements', 'wpex' ),
				'type' => 'wpex-sortable',
				'object' => 'WPEX_Customize_Control_Sorter',
				'choices' => $entry_blocks,
				'desc' => __( 'Click and drag and drop elements to re-order them. Click the "x" to disable any element. You can not disable all elements, if you do so it will display them all', 'wpex' ),
			),
		),
	),
);

// Single
$this->sections['wpex_blog_single'] = array(
	'title' => __( 'Single', 'wpex' ),
	'panel' => 'wpex_blog',
	'settings' => array(
		array(
			'id' => 'blog_single_layout',
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
			'id' => 'blog_single_header',
			'default' => 'custom_text',
			'control' => array(
				'label' => __( 'Header Displays', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'custom_text' => __( 'Custom Text','wpex' ),
					'post_title' => __( 'Post Title','wpex' ),
				),
			),
		),
		array(
			'id' => 'blog_single_header_custom_text',
			'default' => __( 'Blog', 'wpex' ),
			'control' => array(
				'label' => __( 'Header Custom Text', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_blog_page_header_custom_text',
			),
		),
		array(
			'id' => 'blog_post_image_lightbox',
			'control' => array(
				'label' => __( 'Featured Image Lightbox', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_blog_single_media',
			),
		),
		array(
			'id' => 'blog_thumbnail_caption',
			'control' => array(
				'label' => __( 'Featured Image Caption', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_blog_single_media',
			),
		),
		array(
			'id' => 'blog_next_prev',
			'default' => true,
			'control' => array(
				'label' => __( 'Next & Previous Links', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'blog_post_meta_sections',
			'default' => $entry_meta_defaults,
			'control' => array(
				'label' => __( 'Meta', 'wpex' ),
				'type' => 'multiple-select',
				'object' => 'WPEX_Customize_Multicheck_Control',
				'choices' => $entry_meta_choices,
				'active_callback' => 'wpex_customizer_has_blog_meta',
			),
		),
		array(
			'id' => 'blog_related_title',
			'control' => array(
				'label' => __( 'Related Posts Title', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_count',
			'default' => '3',
			'control' => array(
				'label' => __( 'Related Posts Count', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_columns',
			'default' => '3',
			'control' => array(
				'label' => __( 'Related Posts Columns', 'wpex' ),
				'type' => 'select',
				'active_callback' => 'wpex_customizer_has_blog_related',
				'choices' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
			),
		),
		array(
			'id' => 'blog_related_overlay',
			'control' => array(
				'label' => __( 'Overlay Style', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_overlay_styles_array(),
				'active_callback' => 'wpex_customizer_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_excerpt',
			'default' => 'on',
			'control' => array(
				'label' => __( 'Related Posts Excerpt', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_customizer_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_excerpt_length',
			'default' => '15',
			'control' => array(
				'label' => __( 'Related Posts Excerpt Length', 'wpex' ),
				'type' => 'text',
				'active_callback' => 'wpex_customizer_has_blog_related',
			),
		),
		array(
			'id' => 'blog_single_composer',
			'default' => 'featured_media,title,meta,post_series,the_content,post_tags,social_share,author_bio,related_posts,comments',
			'control' => array(
				'label' => __( 'Blog Entry Element\'s Order', 'wpex' ),
				'type' => 'wpex-sortable',
				'object' => 'WPEX_Customize_Control_Sorter',
				'choices' => $single_blocks,
				'desc' => __( 'Click and drag and drop elements to re-order them. Click the "x" to disable any element. You can not disable all elements, if you do so it will display them all', 'wpex' ),
			),
		),
	),
);