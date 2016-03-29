<?php
/**
 * Adds custom styles to the tinymce editor "Formats" dropdown
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Editor_Formats' ) ) {
	class WPEX_Editor_Formats {

		/**
		 * Main constructor
		 *
		 * @since 2.1.0
		 */
		public function __construct() {
			add_filter( 'tiny_mce_before_init', array( $this, 'settings' ) );
		}

		/**
		 * Adds custom styles to the formats dropdown by altering the $settings
		 *
		 * @since 2.1.0
		 */
		public function settings( $settings ) {

			// General
			$items = apply_filters( 'wpex_tiny_mce_formats_items', array(
				array(
					'title'    => __( 'Theme Button', 'wpex' ),
					'selector' => 'a',
					'classes'  => 'theme-button',
				),
				array(
					'title'   => __( 'Highlight', 'wpex' ),
					'inline'  => 'span',
					'classes' => 'text-highlight',
				),
				array(
					'title'   => __( 'Thin Font', 'wpex' ),
					'inline'  => 'span',
					'classes' => 'thin-font'
				),
				array(
					'title'   => __( 'White Text', 'wpex' ),
					'inline'  => 'span',
					'classes' => 'white-text'
				),
				array(
					'title'    => __( 'Check List', 'wpex' ),
					'selector' => 'ul',
					'classes'  => 'check-list'
				),
			) );

			// Dropcaps
			$dropcaps = apply_filters( 'wpex_tiny_mce_formats_dropcaps', array(
				array(
					'title'   => __( 'Dropcap', 'wpex' ),
					'inline'  => 'span',
					'classes' => 'dropcap',
				),
				array(
					'title'   => __( 'Boxed Dropcap', 'wpex' ),
					'inline'  => 'span',
					'classes' => 'dropcap boxed',
				),
			) );

			// Color buttons
			$color_buttons = apply_filters( 'wpex_tiny_mce_formats_color_buttons', array(
				array(
					'title'     => __( 'Blue', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button blue',
				),
				array(
					'title'     => __( 'Black', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button black',
				),
				array(
					'title'     => __( 'Red', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button red',
				),
				array(
					'title'     => __( 'Orange', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button orange',
				),
				array(
					'title'     => __( 'Green', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button green',
				),
				array(
					'title'     => __( 'Gold', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button gold',
				),
				array(
					'title'     => __( 'Teal', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button teal',
				),
				array(
					'title'     => __( 'Purple', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button purple',
				),
				array(
					'title'     => __( 'Pink', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button pink',
				),
				array(
					'title'     => __( 'Brown', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button brown',
				),
				array(
					'title'     => __( 'Rosy', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button rosy',
				),
				array(
					'title'     => __( 'White', 'wpex' ),
					'selector'  => 'a',
					'classes'   => 'color-button white',
				),
			) );

			// Create array of formats
			$new_formats = array(
				// Total Buttons
				array(
					'title' => WPEX_THEME_BRANDING .' '. __( 'Styles', 'wpex' ),
					'items' => $items,
				),
				array(
					'title' => __( 'Dropcaps', 'wpex' ),
					'items' => $dropcaps,
				),
				array(
					'title' =>  __( 'Color Buttons', 'wpex' ),
					'items' => $color_buttons,
				),
			);

			// Merge Formats
			$settings['style_formats_merge'] = true;

			// Add new formats
			$settings['style_formats'] = json_encode( $new_formats );

			// Return New Settings
			return $settings;

		}

	}
}
$wpex_editor_formats = new WPEX_Editor_Formats();