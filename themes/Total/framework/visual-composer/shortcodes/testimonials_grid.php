<?php
/**
 * Visual Composer Testimonials Grid
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
class WPBakeryShortCode_vcex_testimonials_grid extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_testimonials_grid.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the testimonials grid shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_testimonials_grid_vc_map() {
	vc_map( array(
		'name' => __( 'Testimonials Grid', 'wpex' ),
		'description' => __( 'Recent testimonials post grid', 'wpex' ),
		'base' => 'vcex_testimonials_grid',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-testimonials-grid vcex-icon fa fa-comments-o',
		'params' => array(
			// General
			array(
				'type' => 'textfield',
				'heading' => __( 'Unique Id', 'wpex' ),
				'param_name' => 'unique_id',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Classes', 'wpex' ),
				'param_name' => 'classes',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Appear Animation', 'wpex'),
				'param_name' => 'css_animation',
				'value' => array_flip( wpex_css_animations() ),
				'dependency' => array( 'element' => 'filter', 'value' => 'false' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Grid Style', 'wpex' ),
				'param_name' => 'grid_style',
				'value' => array(
					__( 'Fit Columns', 'wpex' ) => 'fit_columns',
					__( 'Masonry', 'wpex' ) => 'masonry',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column clear',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Columns', 'wpex' ),
				'param_name' => 'columns',
				'value' => array_flip( wpex_grid_columns() ),
				'std' => '3',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gap', 'wpex' ),
				'param_name' => 'columns_gap',
				'value' => array_flip( wpex_column_gaps() ),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Responsive', 'wpex' ),
				'param_name' => 'columns_responsive',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'yes',
					__( 'No', 'wpex' ) => 'false',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Posts Per Page', 'wpex' ),
				'param_name' => 'posts_per_page',
				'value' => '-1',
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Pagination', 'wpex' ),
				'param_name' => 'pagination',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'description' => __( 'Important: Pagination will not work on your homepage due to how WordPress Queries function.', 'wpex' ),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Include Categories', 'wpex' ),
				'param_name' => 'include_categories',
				'param_holder_class' => 'vc_not-for-custom',
				'admin_label' => true,
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
				'type' => 'autocomplete',
				'heading' => __( 'Exclude Categories', 'wpex' ),
				'param_name' => 'exclude_categories',
				'param_holder_class' => 'vc_not-for-custom',
				'admin_label' => true,
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
				'heading' => __( 'Order', 'wpex' ),
				'param_name' => 'order',
				'group' => __( 'Query', 'wpex' ),
				'value' => array(
					__( 'Default', 'wpex' ) => '',
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
				'dependency' => array(
					'element' => 'orderby',
					'value' => array( 'meta_value_num', 'meta_value' ),
				),
			),
			// Filter
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'filter',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Filter', 'wpex' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Default Active Category', 'wpex' ),
				'param_name' => 'filter_active_category',
				'param_holder_class' => 'vc_not-for-custom',
				'admin_label' => true,
				'settings' => array(
					'multiple' => false,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
				),
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display All Link?', 'wpex' ),
				'param_name' => 'filter_all_link',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Filter "All" Text', 'wpex' ),
				'param_name' => 'all_text',
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter_all_link', 'value' => 'true' ),
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
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'filter_font_size',
				'group' => __( 'Filter', 'wpex' ),
				'dependency' => array( 'element' => 'filter', 'value' => 'true' ),
			),
			// Image
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'entry_media',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Radius', 'wpex' ),
				'param_name' => 'img_border_radius',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'wpex_custom',
				'value' => vcex_image_sizes(),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Crop Location', 'wpex' ),
				'param_name' => 'img_crop',
				'std' => 'center-center',
				'value' => array_flip( wpex_image_crop_locations() ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
			),
			// Title
			array(
				'type' => 'dropdown',
				'heading' => __( 'Details', 'wpex' ),
				'param_name' => 'title',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Title', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'title_font_size',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'HTML Tag', 'wpex' ),
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
			// Author
			array(
				'type' => 'dropdown',
				'heading' => __( 'Author', 'wpex' ),
				'param_name' => 'author',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Details', 'wpex' ),
			),
			// Author
			array(
				'type' => 'dropdown',
				'heading' => __( 'Company', 'wpex' ),
				'param_name' => 'company',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Details', 'wpex' ),
			),
			// Excerpt
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_font_size',
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Excerpt', 'wpex' ),
				'param_name' => 'excerpt',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				 'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Excerpt Length', 'wpex' ),
				'param_name' => 'excerpt_length',
				'value' => '20',
				'dependency' => Array( 'element' => 'excerpt', 'value' => 'true' ),
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Read More', 'wpex' ),
				'param_name' => 'read_more',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'dependency' => Array( 'element' => 'excerpt', 'value' => 'true' ),
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Read More Text', 'wpex' ),
				'param_name' => 'read_more_text',
				'value' => __( 'read more', 'wpex' ),
				'dependency' => Array( 'element' => 'read_more', 'value' => 'true' ),
				'group' => __( 'Content', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Read More Arrow', 'wpex' ),
				'param_name' => 'read_more_rarr',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex') => 'false',
				),
				'dependency' => Array( 'element' => 'read_more', 'value' => 'true' ),
				'group' => __( 'Content', 'wpex' ),
			),
		),
	) );
}

// Map shortcode
add_action( 'vc_before_init', 'vcex_testimonials_grid_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_testimonials_grid_include_categories_callback', 'vcex_suggest_testimonials_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_testimonials_grid_exclude_categories_callback', 'vcex_suggest_testimonials_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_testimonials_grid_filter_active_category_callback', 'vcex_suggest_testimonials_categories', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_testimonials_grid_include_categories_render', 'vcex_render_testimonials_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_testimonials_grid_exclude_categories_render', 'vcex_render_testimonials_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_testimonials_grid_filter_active_category_render', 'vcex_render_testimonials_categories', 10, 1 );