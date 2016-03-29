<?php
/**
 * Visual Composer Recent News
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
class WPBakeryShortCode_vcex_recent_news extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_recent_news.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_recent_news_vc_map() {
	vc_map( array(
		'name' => __( 'Recent News', 'wpex' ),
		'description' => __( 'Recent blog posts', 'wpex' ),
		'base' => 'vcex_recent_news',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-recent-news vcex-icon fa fa-newspaper-o',
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
				'type' => 'textfield',
				'heading' => __( 'Heading', 'wpex' ),
				'param_name' => 'header',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Columns', 'wpex' ),
				'param_name' => 'grid_columns',
				'std' => '1',
				'value' => array_flip( wpex_grid_columns() ),
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
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Post Count', 'wpex' ),
				'param_name' => 'count',
				'value' => '3',
				'description' => __( 'How many posts do you wish to show.', 'wpex' ),
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
				'type' => 'textfield',
				'heading' => __( 'Offset', 'wpex' ),
				'param_name' => 'offset',
				'group' => __( 'Query', 'wpex' ),
				'description' => __( 'Number of post to displace or pass over. Warning: Setting the offset parameter overrides/ignores the paged parameter and breaks pagination. The offset parameter is ignored when posts per page is set to -1.', 'wpex' ),
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
				'heading' => __( 'Get Posts From', 'wpex' ),
				'param_name' => 'get_posts',
				'group' => __( 'Query', 'wpex' ),
				'std' => 'standard_post_types',
				'value' => array(
					__( 'Standard Posts','wpex' ) => 'standard_post_types',
					__( 'Custom Post types','wpex' ) => 'custom_post_types',
				),
			),
			array(
				'type' => 'posttypes',
				'heading' => __( 'Post types', 'wpex' ),
				'param_name' => 'post_types',
				'std' => 'post',
				'group' => __( 'Query', 'wpex' ),
				'dependency' => Array(
					'element' => 'get_posts',
					'value' => 'custom_post_types'
				),
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
				'dependency' => Array(
					'element' => 'get_posts',
					'value' => 'standard_post_types'
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
				'dependency' => Array(
					'element' => 'get_posts',
					'value' => 'standard_post_types'
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
				'type' => 'dropdown',
				'heading' => __( 'Ignore Sticky Posts', 'wpex' ),
				'param_name' => 'ignore_sticky_posts',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Query', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Orderby: Meta Key', 'wpex' ),
				'param_name' => 'orderby_meta_key',
				'group' => __( 'Query', 'wpex' ),
				'dependency' => array( 'element' => 'orderby', 'value' => array( 'meta_value_num', 'meta_value' ) ),
			),
			// Media
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Featured Media?', 'wpex' ),
				'param_name' => 'featured_image',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Featured Videos?', 'wpex' ),
				'param_name' => 'featured_video',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'featured_image', 'value' => array( 'true' ) ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'wpex_custom',
				'value' => vcex_image_sizes(),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'featured_image', 'value' => array( 'true' ) ),
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
				'heading' => __( 'HTML Tag', 'wpex' ),
				'param_name' => 'title_tag',
				'value' => array(
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'div' => 'div',
				),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'title_weight',
				'group' => __( 'Title', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'title_transform',
				'group' => __( 'Title', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_text_transforms() ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'title_size',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Line Height', 'wpex' ),
				'param_name' => 'title_line_height',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'title_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'true' ),
			),
			// Date
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'date',
				'value' => array(
					__( 'True','wpex' ) => 'true',
					__( 'False','wpex' ) => 'false',
				),
				'group' => __( 'Date', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Month Background', 'wpex' ),
				'param_name' => 'month_background',
				'group' => __( 'Date', 'wpex' ),
				'dependency' => array( 'element' => 'date', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Month Color', 'wpex' ),
				'param_name' => 'month_color',
				'group' => __( 'Date', 'wpex' ),
				'dependency' => array( 'element' => 'date', 'value' => 'true' ),
			),
			// Excerpt
			array(
				'type' => 'dropdown',
				'heading' => __( 'Excerpt', 'wpex' ),
				'param_name' => 'excerpt',
				'value' => array(
					__( 'Yes', 'wpex') => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Excerpt', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Length', 'wpex' ),
				'param_name' => 'excerpt_length',
				'value' => '30',
				'description' => __( 'Enter how many words to display for the excerpt. To display the full post content enter "-1". To display the full post content up to the "more" tag enter "9999".', 'wpex' ),
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'excerpt_font_size',
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'excerpt_color',
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'read_more',
				'value' => array(
					__( 'Yes', 'wpex') => 'true',
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
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex') => 'true',
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
			// Design options
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'CSS', 'wpex' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Article Bottom Border Color', 'wpex' ),
				'param_name' => 'entry_bottom_border_color',
				'group' => __( 'CSS', 'wpex' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_recent_news_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_recent_news_include_categories_callback', 'vcex_suggest_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_recent_news_exclude_categories_callback', 'vcex_suggest_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_recent_news_author_in_callback', 'vcex_suggest_users', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_recent_news_include_categories_render', 'vcex_render_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_recent_news_exclude_categories_render', 'vcex_render_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_recent_news_author_in_render', 'vcex_render_users', 10, 1 );