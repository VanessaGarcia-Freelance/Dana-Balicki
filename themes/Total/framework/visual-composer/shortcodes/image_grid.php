<?php
/**
 * Visual Composer Image Grid
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
class WPBakeryShortCode_vcex_image_grid extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_image_grid.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_image_grid_vc_map() {
	vc_map( array(
		'name' => __( 'Image Grid', 'wpex' ),
		'description' => __( 'Responsive image gallery', 'wpex' ),
		'base' => 'vcex_image_grid',
		'icon' => 'vcex-image-grid vcex-icon fa fa-picture-o',
		'category' => WPEX_THEME_BRANDING,
		'params' => array(
			// General
			array(
				'type' => 'attach_images',
				'admin_label' => true,
				'heading' => __( 'Attach Images', 'wpex' ),
				'param_name' => 'image_ids',
				'group' => __( 'Images', 'wpex' ),
				'description' => __( 'Click the plus icon to add images to your gallery. Once images are added they can be drag and dropped for sorting.', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Post Gallery', 'wpex' ),
				'param_name' => 'post_gallery',
				'group' => __( 'Images', 'wpex' ),
				'description' => __( 'Enable to display images from the current post "Image Gallery".', 'wpex' ),
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
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
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Hover Animation', 'wpex'),
				'param_name' => 'hover_animation',
				'value' => array_flip( wpex_hover_css_animations() ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Grid Style', 'wpex' ),
				'param_name' => 'grid_style',
				'value' => array(
					__( 'Fit Rows', 'wpex' ) => 'default',
					__( 'Masonry', 'wpex' ) => 'masonry',
					__( 'No Margins', 'wpex' ) => 'no-margins',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column clear',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Columns', 'wpex' ),
				'param_name' => 'columns',
				'std' => '4',
				'value' => array_flip( wpex_grid_columns() ),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gap', 'wpex' ),
				'param_name' => 'columns_gap',
				'value' => array_flip( wpex_column_gaps() ),
				'std' => '',
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Responsive', 'wpex' ),
				'param_name' => 'responsive_columns',
				'std' => '',
				'value' => array(
					__( 'True', 'wpex' ) => '',
					__( 'False', 'wpex' ) => 'false',
				),
				'edit_field_class' => 'vc_col-sm-3 vc_column',
			),
			array(
				'type' => 'dropdown',
				'admin_label' => true,
				'heading' => __( 'Randomize Images', 'wpex' ),
				'param_name' => 'randomize_images',
				'value' => array(
					__( 'False', 'wpex' ) => '',
					__( 'True', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'textfield',
				'admin_label' => true,
				'heading' => __( 'Images Per Page', 'wpex' ),
				'param_name' => 'posts_per_page',
				'value' => '-1',
				'description' => __( 'This will enable pagination for your gallery. Enter -1 or leave blank to display all images without pagination.', 'wpex' ),
			),
			// Links
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Link', 'wpex' ),
				'param_name' => 'thumbnail_link',
				'std' => 'lightbox',
				'value' => array(
					__( 'None', 'wpex' ) => 'none',
					__( 'Lightbox', 'wpex' ) => 'lightbox',
					__( 'Attachment Page', 'wpex' ) => 'attachment_page',
					__( 'Custom Links', 'wpex' ) => 'custom_link',
				),
				'group' => __( 'Links', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Skin', 'wpex' ),
				'param_name' => 'lightbox_skin',
				'std' => '',
				'value' => vcex_ilightbox_skins(),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'lightbox', ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Gallery', 'wpex' ),
				'param_name' => 'lightbox_gallery',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => array( 'element' => 'thumbnail_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Thumbnails Placement', 'wpex' ),
				'param_name' => 'lightbox_path',
				'value' => array(
					__( 'Horizontal', 'wpex' ) => '',
					__( 'Vertical', 'wpex' ) => 'vertical',
				),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => Array( 'element' => 'lightbox_gallery', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Title', 'wpex' ),
				'param_name' => 'lightbox_title',
				'value' => array(
					__( 'Alt', 'wpex' ) => '',
					__( 'Title', 'wpex' ) => 'title',
					__( 'None', 'wpex' ) => 'false',
				),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Caption', 'wpex' ),
				'param_name' => 'lightbox_caption',
				'value' => array(
					__( 'Enable', 'wpex' ) => 'true',
					__( 'Disable', 'wpex' ) => 'false',
				),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'exploded_textarea',
				'heading' => __( 'Custom links', 'wpex' ),
				'param_name' => 'custom_links',
				'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter). For images without a link enter a # symbol. And don\'t forget to include the http:// at the front.', 'wpex' ),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => array( 'custom_link' ) ),
				'group' => __( 'Links', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link Target', 'wpex' ),
				'param_name' => 'custom_links_target',
				'group' => __( 'Links', 'wpex' ),
				'value' => array(
					__( 'Same window', 'wpex' ) => '_self',
					__( 'New window', 'wpex' ) => '_blank'
				),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => array( 'custom_link' ) ),
			),
			// Image
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Size', 'wpex' ),
				'param_name' => 'img_size',
				'std' => 'wpex_custom',
				'value' => vcex_image_sizes(),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Crop Location', 'wpex' ),
				'param_name' => 'img_crop',
				'std' => 'center-center',
				'value' => array_flip( wpex_image_crop_locations() ),
				'dependency' => array(
					'element' => 'img_size',
					'value' => 'wpex_custom',
				),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => Array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => Array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Rounded Image?', 'wpex' ),
				'param_name' => 'rounded_image',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'yes'
				),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Overlay Style', 'wpex' ),
				'param_name' => 'overlay_style',
				'value' => array_flip( wpex_overlay_styles_array() ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Button Text', 'wpex' ),
				'param_name' => 'overlay_button_text',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'overlay_style', 'value' => 'hover-button' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'CSS3 Image Hover', 'wpex' ),
				'param_name' => 'img_hover_style',
				'value' => array_flip( wpex_image_hovers() ),
				'group' => __( 'Image', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Filter', 'wpex' ),
				'param_name' => 'img_filter',
				'value' => array_flip( wpex_image_filters() ),
				'group' => __( 'Image', 'wpex' ),
			),
			// Title
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'title',
				'std' => '',
				'value' => array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'yes'
				),
				'group' => __( 'Title', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Tag', 'wpex' ),
				'param_name' => 'title_tag',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'div' => 'div',
				),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Based On', 'wpex' ),
				'param_name' => 'title_type',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Title', 'wpex' ) => 'title',
					__( 'Alt', 'wpex' ) => 'alt',
					__( 'Caption', 'wpex' ) => 'caption',
					__( 'Description', 'wpex' ) => 'description',
				),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'title_color',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'title_size',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Line Height', 'wpex' ),
				'param_name' => 'title_line_height',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'title_margin',
				'group' => __( 'Title', 'wpex' ),
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'title_weight',
				'group' => __( 'Title', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'title_transform',
				'group' => __( 'Title', 'wpex' ),
				'std' => '',
				'value' => array_flip( wpex_text_transforms() ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			// Entry CSS
			array(
				'type' => 'css_editor',
				'heading' => __( 'Entry CSS', 'wpex' ),
				'param_name' => 'entry_css',
				'group' => __( 'Entry CSS', 'wpex' ),
			),
			// CSS
			array(
				'type' => 'css_editor',
				'heading' => __( 'Wrap CSS', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'Container CSS', 'wpex' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_image_grid_vc_map' );