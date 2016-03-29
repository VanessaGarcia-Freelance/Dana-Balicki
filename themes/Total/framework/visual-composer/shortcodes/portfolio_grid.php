<?php
/**
 * Visual Composer Portfolio Grid
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 3.0.0
 */

/**
 * Register shortcode with VC Composer
 *
 * @since 2.0.0
 */
class WPBakeryShortCode_vcex_portfolio_grid extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_portfolio_grid.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the portfolio grid shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_portfolio_grid_vc_map() {
	vc_map( array(
		'name' => __( 'Portfolio Grid', 'wpex' ),
		'description' => __( 'Recent portfolio posts grid', 'wpex' ),
		'base' => 'vcex_portfolio_grid',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-portfolio-grid vcex-icon fa fa-folder-open',
		'params' => array(
			// Main
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
				'heading' => __( 'Appear Animation', 'wpex' ),
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
					__( 'No Margins', 'wpex' ) => 'no_margins',
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
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( '1 Column Style', 'wpex' ),
				'param_name' => 'single_column_style',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
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
					__( 'Yes', 'wpex' ) => 'true',
				),
				'dependency' => array( 'element' => 'grid_style', 'value' => 'fit_columns' ),
				'description' => __( 'Adds equal heights for the entry content so "boxes" on the same row are the same height. You must have equal sized images for this to work efficiently.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link Target', 'wpex' ),
				'param_name' => 'link_target',
				'value' => array(
					__( 'Default', 'wpex' ) => 'self',
					__( 'Blank', 'wpex' ) => 'blank',
				),
				'description' => __( 'This will apply to the image, title and readmore button', 'wpex' ),
			),
			// Query
			array(
				'type' => 'textfield',
				'heading' => __( 'Posts Per Page', 'wpex' ),
				'param_name' => 'posts_per_page',
				'value' => '8',
				'description' => __( 'When pagination is disabled this is also used for the post count.', 'wpex' ),
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
				'dependency' => array( 'element' => 'orderby', 'value' => array( 'meta_value_num', 'meta_value' ) ),
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
				'description' => __( 'Enables a category filter to show and hide posts based on their categories. This does not load posts via AJAX, but rather filters items currently on the page.', 'wpex' ),
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
				'description' => __( 'Default is "0.4" seconds. Enter "0.0" to disable.', 'wpex' ),
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
			// Images
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'entry_media',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Media', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Featured Videos', 'wpex' ),
				'param_name' => 'featured_video',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'entry_media', 'value' => 'true' ),
			),
			/*
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gallery Slider', 'wpex' ),
				'param_name' => 'gallery_slider',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Media', 'wpex' ),
				'description' => __( 'Displays a slider of the latest photos added to the post Image Gallery metabox.', 'wpex' ),
			),
			*/
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
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Skin', 'wpex' ),
				'param_name' => 'lightbox_skin',
				'value' => vcex_ilightbox_skins(),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'thumb_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Gallery', 'wpex' ),
				'param_name' => 'thumb_lightbox_gallery',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'thumb_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Title', 'wpex' ),
				'param_name' => 'thumb_lightbox_title',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'thumb_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Excerpt', 'wpex' ),
				'param_name' => 'thumb_lightbox_caption',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Media', 'wpex' ),
				'dependency' => array( 'element' => 'thumb_link', 'value' => 'lightbox' ),
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
				'type' => 'dropdown',
				'heading' => __( 'Title Links To', 'wpex' ),
				'param_name' => 'title_link',
				'value' => array(
					__( 'Post', 'wpex' ) => 'post',
					__( 'Lightbox', 'wpex' ) => 'lightbox',
					__( 'Nowhere', 'wpex' ) => 'nowhere',
				),
				'group' => __( 'Title', 'wpex' ),
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
				'heading' => __( 'Font Size', 'wpex' ),
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
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Title', 'wpex' ),
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
			// Meta
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'show_categories',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Categories', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Show Only The First Category', 'wpex' ),
				'param_name' => 'show_first_category_only',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Categories', 'wpex' ),
				'dependency' => array( 'element' => 'show_categories', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'categories_font_size',
				'group' => __( 'Categories', 'wpex' ),
				'dependency' => array( 'element' => 'show_categories', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'categories_margin',
				'group' => __( 'Categories', 'wpex' ),
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'dependency' => array( 'element' => 'show_categories', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'categories_color',
				'group' => __( 'Categories', 'wpex' ),
				'dependency' => array( 'element' => 'show_categories', 'value' => 'true' ),
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
				'heading' => __( 'Custom Excerpt Length', 'wpex' ),
				'param_name' => 'excerpt_length',
				'group' => __( 'Excerpt', 'wpex' ),
				'description' => __( 'Enter how many words to display for the excerpt. To display the full post content enter "-1". To display the full post content up to the "more" tag enter "9999".', 'wpex' ),
				'std' => '15',
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_color',
				'group' => __( 'Excerpt', 'wpex' ),
				'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_font_size',
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
				'group' => __( 'Content Design', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Content Alignment', 'wpex' ),
				'param_name' => 'content_alignment',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
					__( 'Center', 'wpex' ) => 'center',
				),
				'group' => __( 'Content Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Margin', 'wpex' ),
				'param_name' => 'content_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Content Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Padding', 'wpex' ),
				'param_name' => 'content_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Content Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Border', 'wpex' ),
				'param_name' => 'content_border',
				'description' => __( 'Please use the shorthand format: width style color. Enter 0px or "none" to disable border.', 'wpex' ),
				'group' => __( 'Content Design', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Content Opacity', 'wpex' ),
				'param_name' => 'content_opacity',
				'description' => __( 'Enter a value between "0" and "1".', 'wpex' ),
				'group' => __( 'Content Design', 'wpex' ),
			),
		),
	) );
}

// Map shortcode
add_action( 'vc_before_init', 'vcex_portfolio_grid_vc_map' );

// Get autocomplete suggestion
add_filter( 'vc_autocomplete_vcex_portfolio_grid_include_categories_callback', 'vcex_suggest_portfolio_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_portfolio_grid_exclude_categories_callback', 'vcex_suggest_portfolio_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_portfolio_grid_filter_active_category_callback', 'vcex_suggest_portfolio_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_portfolio_grid_author_in_callback', 'vcex_suggest_users', 10, 1 );

// Render autocomplete suggestions
add_filter( 'vc_autocomplete_vcex_portfolio_grid_include_categories_render', 'vcex_render_portfolio_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_portfolio_grid_exclude_categories_render', 'vcex_render_portfolio_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_portfolio_grid_filter_active_category_render', 'vcex_render_portfolio_categories', 10, 1 );
add_filter( 'vc_autocomplete_vcex_portfolio_grid_author_in_render', 'vcex_render_users', 10, 1 );