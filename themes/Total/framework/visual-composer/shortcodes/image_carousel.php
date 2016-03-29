<?php
/**
 * Visual Composer Image Carousel
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
class WPBakeryShortCode_vcex_image_carousel extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_image_carousel.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_image_carousel_vc_map() {
	vc_map( array(
		'name' => __( 'Image Carousel', 'wpex' ),
		'description' => __( 'Image based jQuery carousel', 'wpex' ),
		'base' => 'vcex_image_carousel',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-image-carousel vcex-icon fa fa-picture-o',
		'params' => array(
			// Gallery
			array(
				'type' => 'attach_images',
				'admin_label' => true,
				'heading'  => __( 'Attach Images', 'wpex' ),
				'param_name' => 'image_ids',
				'group' => __( 'Gallery', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading'  => __( 'Post Gallery', 'wpex' ),
				'param_name' => 'post_gallery',
				'group' => __( 'Gallery', 'wpex' ),
				'description' => __( 'Enable to display images from the current post "Image Gallery".', 'wpex' ),
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'dropdown',
				'admin_label' => true,
				'heading'  => __( 'Randomize Images', 'wpex' ),
				'param_name' => 'randomize_images',
				'group' => __( 'Gallery', 'wpex' ),
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			// General
			array(
				'type' => 'textfield',
				'heading'  => __( 'Unique Id', 'wpex' ),
				'param_name' => 'unique_id',
			),
			array(
				'type' => 'textfield',
				'heading'  => __( 'Custom Classes', 'wpex' ),
				'param_name' => 'classes',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Default', 'wpex' ) => 'default',
					__( 'No Margins', 'wpex' ) => 'no-margins',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Arrows?', 'wpex' ),
				'param_name' => 'arrows',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Dots?', 'wpex' ),
				'param_name' => 'dots',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Items To Display', 'wpex' ),
				'param_name' => 'items',
				'value' => '4',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Items To Scrollby', 'wpex' ),
				'param_name' => 'items_scroll',
				'value' => '1',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin Between Items', 'wpex' ),
				'param_name' => 'items_margin',
				'value' => '15',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Auto Play', 'wpex' ),
				'param_name' => 'auto_play',
				'std' => 'true',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Infinite Loop', 'wpex' ),
				'param_name' => 'infinite_loop',
				'std' => 'true',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Center Item', 'wpex' ),
				'param_name' => 'center',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Timeout Duration in milliseconds', 'wpex' ),
				'param_name' => 'timeout_duration',
				'value' => '5000',
				'dependency' => Array(
					'element' => 'auto_play',
					'value' => 'true'
				),
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
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Width', 'wpex' ),
				'param_name' => 'img_width',
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Crop Height', 'wpex' ),
				'param_name' => 'img_height',
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'group' => __( 'Image', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Rounded Image?', 'wpex' ),
				'param_name' => 'rounded_image',
				'group' => __( 'Image', 'wpex' ),
				'value' => Array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'yes'
				),
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
			// Links
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Link', 'wpex' ),
				'param_name' => 'thumbnail_link',
				'std' => 'none',
				'value' => array(
					__( 'None', 'wpex' ) => 'none',
					__( 'Lightbox', 'wpex' )  => 'lightbox',
					__( 'Custom Links', 'wpex' ) => 'custom_link',
				),
				'group' => __( 'Links', 'wpex' ),
			),
			array(
				'type' => 'exploded_textarea',
				'heading'  => __( 'Custom links', 'wpex' ),
				'param_name' => 'custom_links',
				'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter). For images without a link enter a # symbol. And don\'t forget to include the http:// at the front.', 'wpex'),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'custom_link' ),
			),
			array(
				'type' => 'dropdown',
				'heading'  => __( 'Custom link target', 'wpex' ),
				'param_name' => 'custom_links_target',
				'description' => __( 'Select where to open custom links.', 'wpex'),
				'group' => __( 'Links', 'wpex' ),
				'value' => array(
					__( 'Same window', 'wpex' ) => 'self',
					__( 'New window', 'wpex' ) => '_blank'
				),
				'dependency' => Array(
					'element' => 'thumbnail_link',
					'value' => 'custom_link',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Skin', 'wpex' ),
				'param_name' => 'lightbox_skin',
				'std' => '',
				'value' => vcex_ilightbox_skins(),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => Array(
					'element' => 'thumbnail_link',
					'value' => 'lightbox',
				),
			),
			// Title
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title', 'wpex' ),
				'param_name' => 'title',
				'std' => 'no',
				'group' => __( 'Title', 'wpex' ),
				'value' => Array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'yes',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title Based On Image', 'wpex' ),
				'param_name' => 'title_type',
				'value' => array(
					__( 'Default', 'wpex' ) => 'default',
					__( 'Title', 'wpex' ) => 'title',
					__( 'Alt', 'wpex' )  => 'alt',
				),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_heading_color',
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Font Weight', 'wpex' ),
				'param_name' => 'content_heading_weight',
				'std' => '',
				'value' => array_flip( wpex_font_weights() ),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Transform', 'wpex' ),
				'param_name' => 'content_heading_transform',
				'value' => array_flip( wpex_text_transforms() ),
				'group' => __( 'Title', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_heading_size',
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
				'group' => __( 'Title', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Margin', 'wpex' ),
				'param_name' => 'content_heading_margin',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'dependency' => array( 'element' => 'title', 'value' => 'yes' ),
			),
			// Caption
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Caption', 'wpex' ),
				'param_name' => 'caption',
				'group' => __( 'Caption', 'wpex' ),
				'value' => Array(
					__( 'No', 'wpex' ) => 'no',
					__( 'Yes', 'wpex' ) => 'yes',
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Color', 'wpex' ),
				'param_name' => 'content_color',
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading'  => __( 'Font Size', 'wpex' ),
				'param_name' => 'content_font_size',
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'yes' ),
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
				'group' => __( 'Design', 'wpex' ),
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
					__( 'Center', 'wpex') => 'center',
				),
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
			// Mobile
			array(
				'type' => 'textfield',
				'heading' => __( 'Tablet: Items To Display', 'wpex' ),
				'param_name' => 'tablet_items',
				'value' => '3',
				'group' => __( 'Mobile', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Mobile Landscape: Items To Display', 'wpex' ),
				'param_name' => 'mobile_landscape_items',
				'value' => '2',
				'group' => __( 'Mobile', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Mobile Portrait: Items To Display', 'wpex' ),
				'param_name' => 'mobile_portrait_items',
				'value' => '1',
				'group' => __( 'Mobile', 'wpex' ),
			),
		),
	) );
}
add_action( 'vc_before_init', 'vcex_image_carousel_vc_map' );