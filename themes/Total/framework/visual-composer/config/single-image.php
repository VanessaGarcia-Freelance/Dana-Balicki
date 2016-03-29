<?php
/**
 * Visual Composer Single Image Configuration
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'VCEX_Single_Image_Config' ) ) {
	
	class VCEX_Single_Image_Config {

		/**
		 * Main constructor
		 *
		 * @since 2.0.0
		 */
		function __construct() {
			add_filter( 'init', array( $this, 'add_params') );
			add_action( 'vc_after_init', array( $this, 'update_params' ) );
			add_filter( 'vc_edit_form_fields_attributes_vc_single_image', array( $this, 'edit_form_fields') );
		}

		/**
		 * Used to update default parms
		 *
		 * @since 3.0.0
		 * @access public
		 */
		public function update_params() {

			$param = WPBMap::getParam( 'vc_single_image', 'img_size' );
			if ( $param ) {
				$param['value'] = 'full';
				vc_update_shortcode_param( 'vc_single_image', $param );
			}

		}

		/**
		 * Adds new params for the VC Single_Images
		 *
		 * @since 2.0.0
		 */
		public static function add_params() {

			vc_add_param( 'vc_single_image', array(
				'type' => 'dropdown',
				'heading' => __( 'Image alignment', 'wpex' ),
				'param_name' => 'alignment',
				'value' => array(
					__( 'Default', 'wpex' ) => '',
					__( 'Left', 'wpex' ) => 'left',
					__( 'Right', 'wpex' ) => 'right',
					__( 'Center', 'wpex' ) => 'center',
				),
				'description' => __( 'Select image alignment.', 'wpex' )
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'dropdown',
				'heading' => __( 'Image Filter', 'wpex' ),
				'param_name' => 'img_filter',
				'value' => array_flip( wpex_image_filters() ),
				'description' => __( 'Select an image filter style.', 'wpex' ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'textfield',
				'heading' => __( 'Over Image Caption', 'wpex' ),
				'param_name' => 'img_caption',
				'description' => __( 'Use this field to add a caption to any single image with a link.', 'wpex' ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'dropdown',
				'heading' => __( 'CSS3 Image Link Hover', 'wpex' ),
				'param_name' => 'img_hover',
				'std' => '',
				'value' => array_flip( wpex_image_hovers() ),
				'description' => __( 'Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.', 'wpex' ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'textfield',
				'heading' => __( 'Video, SWF, Flash, URL Lightbox', 'wpex' ),
				'param_name' => 'lightbox_video',
				'description' => __( 'Enter the URL to a video, SWF file, flash file or a website URL to open in lightbox.', 'wpex' ),
				'group' => __( 'Custom Lightbox', 'wpex' ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'dropdown',
				'heading' => __( 'Lightbox Type', 'wpex' ),
				'param_name' => 'lightbox_iframe_type',
				'value' => array(
					__( 'Auto Detect', 'wpex' ) => '',
					__( 'URL', 'wpex' ) => 'url',
					__( 'Youtube, Vimeo, Embed or Iframe', 'wpex' ) => 'video_embed',
					__( 'HTML5', 'wpex' ) => 'html5',
					__( 'Quicktime', 'wpex' ) => 'quicktime',
				),
				'description' => __( 'Auto detect depends on the iLightbox API, so by choosing your type it speeds things up and you also allows for HTTPS support.', 'wpex' ),
				'group' => __( 'Custom Lightbox', 'wpex' ),
				'dependency' => Array( 'element' => 'lightbox_video', 'not_empty' => true ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'textfield',
				'heading' => __( 'HTML5 Webm URL', 'wpex' ),
				'param_name' => 'lightbox_video_html5_webm',
				'description' => __( 'Enter the URL to a video, SWF file, flash file or a website URL to open in lightbox.', 'wpex' ),
				'group' => __( 'Custom Lightbox', 'wpex' ),
				'dependency' => Array( 'element' => 'lightbox_iframe_type', 'value' => 'html5' ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'textfield',
				'heading' => __( 'Lightbox Dimensions', 'wpex' ),
				'param_name' => 'lightbox_dimensions',
				'description' => __( 'Enter a custom width and height for your lightbox pop-up window. Use format widthxheight. Example: 900x600.', 'wpex' ),
				'group' => __( 'Custom Lightbox', 'wpex' ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'attach_image',
				'admin_label' => false,
				'heading' => __( 'Custom Image Lightbox', 'wpex' ),
				'param_name' => 'lightbox_custom_img',
				'description' => __( 'Select a custom image to open in lightbox format', 'wpex' ),
				'group' => __( 'Custom Lightbox', 'wpex' ),
			) );

			vc_add_param( 'vc_single_image', array(
				'type' => 'attach_images',
				'admin_label' => false,
				'heading' => __( 'Gallery Lightbox', 'wpex' ),
				'param_name' => 'lightbox_gallery',
				'description' => __( 'Select images to create a lightbox Gallery.', 'wpex' ),
				'group' => __( 'Custom Lightbox', 'wpex' ),
			) );

			// Hidden fields for parsing
			vc_add_param( 'vc_single_image', array(
				'type' => 'hidden',
				'param_name' => 'rounded_image',
			) );

		}

		/**
		 * Alter fields on edit
		 *
		 * @since 2.0.0
		 */
		public static function edit_form_fields( $atts ) {
			if ( ! empty( $atts['rounded_image'] )
				&& 'yes' == $atts['rounded_image']
				&& empty( $atts['style'] )
			) {
				$atts['style'] = 'vc_box_circle';
				unset( $atts['rounded_image'] );
			}
			if ( ! empty( $atts['link'] ) && empty( $atts['onclick'] ) ) {
				$atts['onclick'] = 'custom_link';
			}
			return $atts;
		}

	}

}
$vcex_single_image_config = new VCEX_Single_Image_Config();