<?php
/**
 * iLightbox class
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_iLightbox' ) ) {
	
	class WPEX_iLightbox {

		/**
		 * Main constructor
		 *
		 * @since 2.1.0
		 */
		public function __construct() {

			// Add actions
			add_action( 'wp_enqueue_scripts', array( $this, 'register_style_sheets' ), 20 );

			// Add filters
			add_filter( 'wpex_localize_array', array( $this, 'localize' ) );

		}

		/**
		 * Localize scripts
		 *
		 * @since 2.1.0
		 */
		public function localize( $array ) {
			
			// Add lightbox settings to array
			$array['iLightbox'] = array(
				'skin' => wpex_global_obj( 'lightbox_skin' ),
				'path' => 'horizontal',
				'controls' => array(
					'arrows' => wpex_get_mod( 'lightbox_arrows', true ),
					'thumbnail' => wpex_get_mod( 'lightbox_thumbnails', true ),
					'fullscreen' => wpex_get_mod( 'lightbox_fullscreen', true ),
					'mousewheel' => wpex_get_mod( 'lightbox_mousewheel', false ),
				),
				'effects' => array(
					'loadedFadeSpeed' => 50,
					'fadeSpeed' => 500,
				),
				'show' => array(
					'title' => wpex_get_mod( 'lightbox_titles', true ),
					'speed' => 200,
				),
				'hide' => array(
					'speed' => 200,
				),
				'overlay' => array(
					'blur' => true,
					'opacity' => 0.9,
				),
				'social' => array(
					'start' => true,
					'show' => 'mouseenter',
					'hide' => 'mouseleave',
					'buttons' => false,
				),
				/*'social' => array(
					'buttons' => array(
						'facebook' => array(
							'text' => 'Facebook'
						),
						'twitter' => array(
							'text' => 'Twitter'
						),
						'googleplus' => array(
							'text' => 'Google Plus'
						),
						'pinterest' => array(
							'text'   => 'Pinterest',
							'source' => 'https://www.pinterest.com/pin/create/button/?url={URL}',
						),
					),
				),*/
			);
	
			// Return array
			return $array;

		}

		/**
		 * Holds an array of lightbox skins
		 *
		 * @since 2.1.0
		 */
		public static function skins() {
			return apply_filters( 'wpex_ilightbox_skins', array(
				'minimal'     => __( 'Minimal', 'wpex' ),
				//'modern'      => __( 'Modern', 'wpex' ), // COMING SOON
				'white'       => __( 'White', 'wpex' ),
				'dark'        => __( 'Dark', 'wpex' ),
				'light'       => __( 'Light', 'wpex' ),
				'mac'         => __( 'Mac', 'wpex' ),
				'metro-black' => __( 'Metro Black', 'wpex' ),
				'metro-white' => __( 'Metro White', 'wpex' ),
				'parade'      => __( 'Parade', 'wpex' ),
				'smooth'      => __( 'Smooth', 'wpex' ),
			) );
		}

		/**
		 * Returns active lightbox skin
		 *
		 * @since 2.1.0
		 */
		public static function active_skin() {

			// Get skin from Customizer setting
			$skin = wpex_get_mod( 'lightbox_skin', 'minimal' );

			// Sanitize
			$skin = $skin ? $skin : 'minimal';
				
			// Apply filters
			$skin = apply_filters( 'wpex_lightbox_skin', $skin );

			// Return
			return $skin;

		}

		/**
		 * Returns correct skin stylesheet
		 *
		 * @since 2.1.0
		 */
		public static function skin_style( $skin = null ) {

			// Sanitize skin
			if ( ! $skin ) {
				$skin = self::active_skin();
			}

			// Loop through skins
			$stylesheet = WPEX_CSS_DIR_URI .'ilightbox/'. $skin .'/ilightbox-'. $skin .'-skin.css';

			// Apply filters
			$stylesheet = apply_filters( 'wpex_ilightbox_stylesheet', $stylesheet );

			// Return directory uri
			return $stylesheet;

		}

		/**
		 * Enqueues iLightbox skin stylesheet
		 *
		 * @since 2.1.0
		 */
		public static function enqueue_style( $skin = null ) {

			// Get default skin if custom skin not defined
			$skin = ( $skin && 'default' != $skin ) ? $skin : self::active_skin();

			// Enqueue stylesheet
			wp_enqueue_style( 'wpex-ilightbox-'. $skin );

		}

		/**
		 * Registers all stylesheets for quick usage and enqueues default skin for the whole site
		 *
		 * @since 2.1.0
		 */
		public function register_style_sheets() {

			// Register skins
			foreach( self::skins() as $key => $val ) {
				wp_register_style( 'wpex-ilightbox-'. $key, $this->skin_style( $key ), false, WPEX_THEME_VERSION );
			}

		}

		/**
		 * Loads the stylesheet
		 *
		 * @since 2.1.0
		 */
		public function load_css() {
			self::enqueue_style();
		}

	}

}
new WPEX_iLightbox();


/* Helper functions
-------------------------------------------------------------------------------*/

/**
 * Returns array of ilightbox Skins
 *
 * @since 2.0.0
 */
function wpex_ilightbox_skins() {
	return WPEX_iLightbox::skins();
}

/**
 * Returns lightbox skin
 *
 * @since 1.3.3
 */
function wpex_ilightbox_skin() {
	return WPEX_iLightbox::active_skin();
}

/**
 * Returns lightbox skin stylesheet
 *
 * @since 1.3.3
 */
function wpex_ilightbox_stylesheet( $skin = null ) {
	return WPEX_iLightbox::skin_style( $skin );
}

/**
 * Enqueues lightbox stylesheet
 *
 * @since 1.3.3
 */
function wpex_enqueue_ilightbox_skin( $skin = null ) {
	return WPEX_iLightbox::enqueue_style( $skin );
}