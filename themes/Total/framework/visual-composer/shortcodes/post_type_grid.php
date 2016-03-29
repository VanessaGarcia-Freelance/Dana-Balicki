<?php
/**
 * Post Type Grid
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.0.0
 */
class WPBakeryShortCode_vcex_post_type_grid extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_post_type_grid.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_post_type_grid_vc_map() {
	vc_map( array(
		'name' => __( 'Post Types Grid', 'wpex' ),
		'description' => __( 'Multiple post types posts grid', 'wpex' ),
		'base' => 'vcex_post_type_grid',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-post-type-grid vcex-icon fa fa-files-o',
		'params' => array(
			// General
			array(
				'type' => 'textfield',
				'heading' => __( 'Unique Id', 'wpex' ),
				'description' => __( 'Give your main element a unique ID.', 'wpex' ),
				'param_name' => 'unique_id',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Classes', 'wpex' ),
				'description' => __( 'Add additonal classes to the main element.', 'wpex' ),
				'param_name' => 'classes',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
				'description' => __( 'Choose when this module should display.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Appear Animation', 'wpex'),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
				'description' => __( 'If the "filter" is enabled animations will be disabled to prevent bugs.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Grid Style', 'wpex' ),
				'param_name' => 'grid_style',
				'value' => array(
					__( 'Fit Columns', 'wpex' ) => 'fit_columns',
					__( 'Masonry', 'wpex' ) => 'masonry',
					__( 'No Margins', 'wpex' ) => 'no_margins',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column clear',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Columns', 'wpex' ),
				'param_name' => 'columns',
				'value' => wpex_grid_columns(),
				'std' => '3',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gap', 'wpex' ),
				'param_name' => 'columns_gap',
				'value' => array_flip( wpex_column_gaps() ),
				'std' => '20',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Responsive', 'wpex' ),
				'param_name' => 'columns_responsive',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'std' => '',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( '1 Column Style', 'wpex' ),
				'param_name' => 'single_column_style',
				'value' => array(
					__( 'Default', 'wpex') => '',
					__( 'Left Image & Right Content', 'wpex' ) => 'left_thumbs',
				),
				'dependency' => array( 'element' => 'columns', 'value' => '1' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Equal Heights?', 'wpex' ),
				'param_name' => 'equal_heights_grid',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex') => 'true',
				),
				'dependency' => array(
					'element' => 'grid_style',
					'value' => 'fit_columns',
				),
				'description' => __( 'Adds equal heights for the entry content so entries on the same row are the same height. You must have equal sized images for this to work efficiently. Disabled for masonry style layouts and filterable layouts.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Post Link Target', 'wpex' ),
				'param_name' => 'url_target',
				 'value' => array(
					__( 'Self', 'wpex') => 'self',
					__( 'Blank', 'wpex') => '_blank',
				),
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Posts Per Page', 'wpex' ),
				'param_name' => 'posts_per_page',
				'value' => '12',
				'description' => __( 'You can enter "-1" to display all posts.', 'wpex' ),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Pagination', 'wpex' ),
				'param_name' => 'pagination',
				'value' => array(
					__( 'False', 'wpex') => 'false',
					__( 'True', 'wpex' ) => 'true',
				),
				'description' => __( 'Important: Pagination will not work on your homepage due to how WordPress Queries function.', 'wpex' ),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Offset', 'wpex' ),
				'param_name' => 'offset',
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'Number of post to displace or pass over. Warning: Setting the offset parameter overrides/ignores the paged parameter and breaks pagination. The offset parameter is ignored when posts per page is set to -1.', 'wpex' ),
			),
			array(
				'type' => 'posttypes',
				'heading' => __( 'Post types', 'wpex' ),
				'param_name' => 'post_types',
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Limit By Post ID\'s', 'wpex' ),
				'param_name' => 'posts_in',
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'Seperate by a comma.', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Limit By Author', 'wpex' ),
				'param_name' => 'author_in',
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Query by Taxonomy', 'wpex' ),
				'param_name' => 'tax_query',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex') => 'true',
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Taxonomy Name', 'wpex' ),
				'param_name' => 'tax_query_taxonomy',
				'dependency' => array(
					'element' => 'tax_query',
					'value' => 'true',
				),
				'settings' => array(
					'multiple' => false,
					'min_length' => 1,
					'groups' => false,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'If you do not see your taxonomy in the dropdown you can still enter the taxonomy name manually.', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Terms', 'wpex' ),
				'param_name' => 'tax_query_terms',
				'dependency' => array( 'element' => 'tax_query', 'value' => 'true' ),
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'If you do not see your terms in the dropdown you can still enter the term slugs manually seperated by a space.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order', 'wpex' ),
				'param_name' => 'order',
				'group' => __( 'Query', 'wpex' ),
				'value' => array(
					__( 'Default', 'wpex' ) => 'default',
					__( 'DESC', 'wpex' ) => 'DESC',
					__( 'ASC', 'wpex' ) => 'ASC',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Order By', 'wpex' ),
				'param_name' => 'orderby',
				'value' => vcex_orderby_array(),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Orderby: Meta Key', 'wpex' ),
				'param_name' => 'orderby_meta_key',
				'group' => __( 'Query', 'wpex' ),
				'dependency' => array( 'element' => 'orderby', 'value' => array( 'meta_value_num', 'meta_value' ) ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Post With Thumbnails Only', 'wpex' ),
				'param_name' => 'thumbnail_query',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex') => 'true',
				),
				'group' => __( 'Query', 'wpex' ),
			),
			// Filter
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'filter',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex') => 'true',
				),
				'description' => __( 'If more then one post type is selected it will display a post type filter, otherwise it will display the categories for the current post type.', 'wpex' ),
				'group' => __( 'Filter', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Button Style', 'wpex' ),
				'param_name' => 'filter_button_style',
				'value' => array_flip( wpex_button_styles() ),
				'group' => __( 'Filter', 'wpex' ),
				'std' => 'minimal-border',
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Button Color', 'wpex' ),
				'param_name' => 'filter_button_color',
				'std' => '',
				'value' => array_flip( wpex_button_colors() ),
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Filter What?', 'wpex' ),
				'param_name' => 'filter_type',
				'value' => array(
					__( 'Post Types', 'wpex' ) => 'post_types',
					__( 'Custom Taxonomy', 'wpex') => 'taxonomy',
				),
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Layout Mode', 'wpex' ),
				'param_name' => 'masonry_layout_mode',
				'value' => array(
					__( 'Masonry', 'wpex' ) => 'masonry',
					__( 'Fit Rows', 'wpex' ) => 'fitRows',
				),
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Filter Taxonomy Name', 'wpex' ),
				'param_name' => 'filter_taxonomy',
				'dependency' => array( 'element' => 'filter_type', 'value' => array( 'taxonomy' ) ),
				'settings' => array(
					'multiple' => false,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'description' => __( 'Enter the taxonomy name for the filter links.', 'wpex' ),
				'group' => __( 'Filter', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Filter Speed', 'wpex' ),
				'param_name' => 'filter_speed',
				'description' => __( 'Default is 0.4 seconds. Enter 0.0 to disable.', 'wpex' ),
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Center Filter Links', 'wpex' ),
				'param_name' => 'center_filter',
				'value' => array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'yes',
				),
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Filter "All" Text', 'wpex' ),
				'param_name' => 'all_text',
				'group' => __( 'Filter', 'wpex' ),
				'value' => _x( 'All', 'Grid Filter All Button', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			// Media
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'entry_media',
				'value' => array(
					__( 'Yes', 'wpex') => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Featured Videos?', 'wpex' ),
				'param_name' => 'featured_video',
				'value' => array(
					__( 'True', 'wpex') => 'true',
					__( 'False', 'wpex' ) => 'false',
				),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Links To', 'wpex' ),
				'param_name' => 'thumb_link',
				'value' => array(
					__( 'Post', 'wpex' ) => 'post',
					__( 'Lightbox', 'wpex' ) => 'lightbox',
					__( 'Nowhere', 'wpex' ) => 'nowhere',
				),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'wpex_custom',
				'value' => vcex_image_sizes(),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Crop Location', 'wpex' ),
				'param_name' => 'img_crop',
				'std' => 'center-center',
				'value' => array_flip( wpex_image_crop_locations() ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'description' => __( 'Enter a width in pixels.', 'wpex' ),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Overlay Style', 'wpex' ),
				'param_name' => 'overlay_style',
				'value' => array_flip( wpex_overlay_styles_array() ),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Button Text', 'wpex' ),
				'param_name' => 'overlay_button_text',
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'overlay_style', 'value' => 'hover-button' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Excerpt Length', 'wpex' ),
				'param_name' => 'overlay_excerpt_length',
				'value' => '15',
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'overlay_style', 'value' => 'title-excerpt-hover' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'CSS3 Image Link Hover', 'wpex' ),
				'param_name' => 'img_hover_style',
				'value' => array_flip( wpex_image_hovers() ),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Filter', 'wpex' ),
				'param_name' => 'img_filter',
				'value' => array_flip( wpex_image_filters() ),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			// Title
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'title',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Title', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Tag', 'wpex' ),
				'param_name' => 'title_tag',
				'group' => __( 'Title', 'wpex' ),
				'std' => 'h2',
				'value' => array(
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'div' => 'div',
				),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_heading_color',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __(  'Font Size', 'wpex' ),
				'param_name' => 'content_heading_size',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Line Height', 'wpex' ),
				'param_name' => 'content_heading_line_height',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'content_heading_margin',
				'group' => __( 'Title', 'wpex' ),
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'content_heading_weight',
				'group' => __( 'Title', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'content_heading_transform',
				'group' => __( 'Title', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_text_transforms() ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			// Date
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'date',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Date', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'date_color',
				'group' => __( 'Date', 'wpex' ),
				'dependency' => array( 'element' => 'date', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'date_font_size',
				'group' => __( 'Date', 'wpex' ),
				'dependency' => array( 'element' => 'date', 'value' => 'true' ),
			),
			// Excerpt
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'excerpt',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Excerpt', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Length', 'wpex' ),
				'param_name' => 'excerpt_length',
				'group' => __( 'Excerpt', 'wpex' ),
				'value' => '20',
				'description' => __( 'Enter how many words to display for the excerpt. To display the full post content enter "-1". To display the full post content up to the "more" tag enter "9999".', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_font_size',
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_color',
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			// Readmore
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'read_more',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Button', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Text', 'wpex' ),
				'param_name' => 'read_more_text',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'readmore_style',
				'std' => '',
				'value' => array_flip( wpex_button_styles() ),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'readmore_style_color',
				'std' => '',
				'value' => array_flip( wpex_button_colors() ),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Arrow', 'wpex' ),
				'param_name' => 'readmore_rarr',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'readmore_size',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'readmore_border_radius',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'readmore_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'readmore_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background', 'wpex' ),
				'param_name' => 'readmore_background',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'readmore_color',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background: Hover', 'wpex' ),
				'param_name' => 'readmore_hover_background',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color: Hover', 'wpex' ),
				'param_name' => 'readmore_hover_color',
				'group' => __( 'Button', 'wpex' ),
				'dependency' => array( 'element' => 'read_more', 'value' => 'true' ),
			),
			// Design
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Content Background', 'wpex' ),
				'param_name' => 'content_background',
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Content Alignment', 'wpex' ),
				'param_name' => 'content_alignment',
				'value' => array_flip( wpex_alignments() ),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Margin', 'wpex' ),
				'param_name' => 'content_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Padding', 'wpex' ),
				'param_name' => 'content_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Border', 'wpex' ),
				'param_name' => 'content_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Opacity', 'wpex' ),
				'param_name' => 'content_opacity',
				'description' => __( 'Enter a value between "0" and "1".', 'wpex' ),
				'group' => __( 'Design', 'wpex' ),
			),
		)
	) );
}

// IMPORTANT: Needs to run on init to get post types and taxonomies
add_action( 'init', 'vcex_post_type_grid_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_post_type_grid_tax_query_taxonomy_callback', 'vcex_suggest_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_grid_filter_taxonomy_callback', 'vcex_suggest_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_grid_tax_query_terms_callback', 'vcex_suggest_terms', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_grid_author_in_callback', 'vcex_suggest_users', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_post_type_grid_filter_taxonomy_render', 'vcex_render_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_grid_tax_query_taxonomy_render', 'vcex_render_taxonomies', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_grid_tax_query_terms_render', 'vcex_render_terms', 10, 1 );
add_filter( 'vc_autocomplete_vcex_post_type_grid_author_in_render', 'vcex_render_users', 10, 1 );