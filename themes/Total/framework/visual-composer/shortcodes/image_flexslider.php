<?php
/**
 * Visual Composer Image Slider
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
class WPBakeryShortCode_vcex_image_flexslider extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		ob_start();
		include( locate_template( 'vcex_templates/vcex_image_flexslider.php' ) );
		return ob_get_clean();
	}
}

/**
 * Adds the shortcode to the Visual Composer
 *
 * @since 1.4.1
 */
function vcex_image_flexslider_shortcode_vc_map() {
	vc_map( array(
		'name' => __( 'Image Slider', 'wpex' ),
		'description' => __( 'Custom image slider', 'wpex' ),
		'base' => 'vcex_image_flexslider',
		'category' => WPEX_THEME_BRANDING,
		'icon' => 'vcex-image-flexslider vcex-icon fa fa-picture-o',
		'params' => array(
			// Images
			array(
				'type' => 'attach_images',
				'admin_label' => true,
				'heading' => __( 'Attach Images', 'wpex' ),
				'param_name' => 'image_ids',
				'description' => __( 'You can display captions by giving your images a caption and you can also display videos by adding an image that has a Video URL defined for it.', 'wpex' ),
				'group' => __( 'Images', 'wpex' ),
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
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Custom Classes', 'wpex' ),
				'param_name' => 'classes',
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'visibility',
				'value' => array_flip( wpex_visibility() ),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Randomize', 'wpex' ),
				'param_name' => 'randomize',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Animation', 'wpex' ),
				'param_name' => 'animation',
				'value' => array(
					__( 'Slide', 'wpex' ) => 'slide',
					__( 'Fade', 'wpex' ) => 'fade_slides',
				),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Loop', 'wpex' ),
				'param_name' => 'loop',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Auto Height Animation', 'wpex' ),
				'std' => '500',
				'param_name' => 'height_animation',
				'group' => __( 'General', 'wpex' ),
				'description' => __( 'You can enter "0.0" to disable the animation completely.', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Animation Speed', 'wpex' ),
				'param_name' => 'animation_speed',
				'std' => '600',
				'description' => __( 'Enter a value in milliseconds.', 'wpex' ),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Auto Play', 'wpex' ),
				'param_name' => 'slideshow',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'description' => __( 'Enable automatic slideshow? Disabled in front-end composer to prevent page "jumping".', 'wpex' ),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Auto Play Delay', 'wpex' ),
				'param_name' => 'slideshow_speed',
				'std' => '5000',
				'description' => __( 'Enter a value in milliseconds.', 'wpex' ),
				'group' => __( 'General', 'wpex' ),
				'dependency' => Array( 'element' => 'slideshow', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Arrows', 'wpex' ),
				'param_name' => 'direction_nav',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Arrows on Hover', 'wpex' ),
				'param_name' => 'direction_nav_hover',
				'value' => array(
					__( 'Yes', 'wpex' ) => '',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'General', 'wpex' ),
				'dependency' => array( 'element' => 'direction_nav', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Dot Navigation', 'wpex' ),
				'param_name' => 'control_nav',
				'value' => array(
					__( 'Yes', 'wpex' ) => '',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Thumbnails', 'wpex' ),
				'param_name' => 'control_thumbs',
				'value' => array(
					__( 'Yes', 'wpex' ) => 'true',
					__( 'No', 'wpex' ) => 'false',
				),
				'group' => __( 'General', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Thumbnails Pointer', 'wpex' ),
				'param_name' => 'control_thumbs_pointer',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'General', 'wpex' ),
				'dependency' => array( 'element' => 'control_thumbs', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Navigation Thumbnails Height', 'wpex' ),
				'param_name' => 'control_thumbs_height',
				'std' => '70',
				'group' => __( 'General', 'wpex' ),
				'dependency' => array( 'element' => 'control_thumbs', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Navigation Thumbnails Width', 'wpex' ),
				'param_name' => 'control_thumbs_width',
				'std' => '70',
				'group' => __( 'General', 'wpex' ),
				'dependency' => array( 'element' => 'control_thumbs', 'value' => 'true' ),
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
				'description' => __( 'Enter a height in pixels. Leave empty to disable vertical cropping and keep image proportions.', 'wpex' ),
				'dependency' => array( 'element' => 'img_size', 'value' => 'wpex_custom' ),
				'group' => __( 'Image', 'wpex' )
			),
			// Caption
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable', 'wpex' ),
				'param_name' => 'caption',
				'std' => 'false',
				'value' => array(
					__( 'No', 'wpex' ) => 'false',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Caption', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Based On', 'wpex' ),
				'param_name' => 'caption_type',
				'std' => 'caption',
				'value' => array(
					__( 'Title', 'wpex' ) => 'title',
					__( 'Caption', 'wpex' ) => 'caption',
					__( 'Description', 'wpex' ) => 'description',
					__( 'Alt', 'wpex' ) => 'alt',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Visibility', 'wpex' ),
				'param_name' => 'caption_visibility',
				'value' => array_flip( wpex_visibility() ),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'wpex' ),
				'param_name' => 'caption_style',
				'value' => array(
					__( 'Black', 'wpex' ) => 'black',
					__( 'White', 'wpex' ) => 'white',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Rounded', 'wpex' ),
				'param_name' => 'caption_rounded',
				'value' => array(
					__( 'No', 'wpex' ) => '',
					__( 'Yes', 'wpex' ) => 'true',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Position', 'wpex' ),
				'param_name' => 'caption_position',
				'std' => 'bottomCenter',
				'value' => array(
					__( 'Bottom Center', 'wpex' ) => 'bottomCenter',
					__( 'Bottom Left', 'wpex' ) => 'bottomLeft',
					__( 'Bottom Right', 'wpex' ) => 'bottomRight',
					__( 'Top Center', 'wpex' ) => 'topCenter',
					__( 'Top Left', 'wpex' ) => 'topLeft',
					__( 'Top Right', 'wpex' ) => 'topRight',
					__( 'Center Center', 'wpex' ) => 'centerCenter',
					__( 'Center Left', 'wpex' ) => 'centerLeft',
					__( 'Center Right', 'wpex' ) => 'centerRight',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Show Transition', 'wpex' ),
				'param_name' => 'caption_show_transition',
				'std' => 'up',
				'value' => array(
					__( 'None', 'wpex' ) => 'false',
					__( 'Up', 'wpex' ) => 'up',
					__( 'Down', 'wpex' ) => 'down',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Hide Transition', 'wpex' ),
				'param_name' => 'caption_hide_transition',
				'std' => 'down',
				'value' => array(
					__( 'None', 'wpex' ) => 'false',
					__( 'Up', 'wpex' ) => 'up',
					__( 'Down', 'wpex' ) => 'down',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
				),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Width', 'wpex' ),
				'param_name' => 'caption_width',
				'value' => '100%',
				'description' => __( 'Enter a pixel or percentage value. You can also enter "auto" for content dependent width.', 'wpex' ),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Font-Size', 'wpex' ),
				'param_name' => 'caption_font_size',
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Padding', 'wpex' ),
				'param_name' => 'caption_padding',
				'description' => __( 'Please use the following format: top right bottom left.', 'wpex' ),
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Horizontal Offset', 'wpex' ),
				'param_name' => 'caption_horizontal',
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Vertical Offset', 'wpex' ),
				'param_name' => 'caption_vertical',
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Delay', 'wpex' ),
				'param_name' => 'caption_delay',
				'std' => '500',
				'group' => __( 'Caption', 'wpex' ),
				'dependency' => array( 'element' => 'caption', 'value' => 'true' ),
			),
			// Links
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image Link', 'wpex' ),
				'param_name' => 'thumbnail_link',
				'value' => array(
					__( 'None', 'wpex' ) => 'none',
					__( 'Lightbox', 'wpex' ) => 'lightbox',
					__( 'Custom Links', 'wpex' ) => 'custom_link',
				),
				'group' => __( 'Links', 'wpex' ),
			),
			array(
				'type' => 'exploded_textarea',
				'heading' => __('Custom links', 'wpex' ),
				'param_name' => 'custom_links',
				'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter). For images without a link enter a # symbol.', 'wpex' ),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'custom_link' ),
				'group' => __( 'Links', 'wpex' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Custom link target', 'wpex' ),
				'param_name' => 'custom_links_target',
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'custom_link' ),
				'value' => array(
					__( 'Same window', 'wpex' ) => 'self',
					__( 'New window', 'wpex' ) => '_blank'
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
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Thumbnails Placement', 'wpex' ),
				'param_name' => 'lightbox_path',
				'value' => array(
					__( 'Horizontal', 'wpex' ) => 'horizontal',
					__( 'Vertical', 'wpex' ) => 'vertical',
				),
				'group' => __( 'Links', 'wpex' ),
				'dependency' => Array( 'element' => 'thumbnail_link', 'value' => 'lightbox' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Title', 'wpex' ),
				'param_name' => 'lightbox_title',
				'value' => array(
					__( 'None', 'wpex' ) => 'none',
					__( 'Alt', 'wpex' ) => 'alt',
					__( 'Title', 'wpex' ) => 'title',
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
			// Design options
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS', 'wpex' ),
				'param_name' => 'css',
				'group' => __( 'CSS', 'wpex' ),
			),
		)
	) );
}
add_action( 'vc_before_init', 'vcex_image_flexslider_shortcode_vc_map' );