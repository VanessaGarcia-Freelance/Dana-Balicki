<?php
/**
 * Page Animation Functions
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Page_Animations' ) ) {

	class WPEX_Page_Animations {
		private $has_animations;

		/**
		 * Main constructor
		 *
		 * @since 2.1.0
		 */
		public function __construct() {

			// Add customizer settings
			add_filter( 'wpex_customizer_sections', array( $this, 'customizer_settings' ) );

			// Animations disabled by default
			$this->has_animations = false;

			// Get animations
			$this->animate_in  = apply_filters( 'wpex_page_animation_in', wpex_get_mod( 'page_animation_in' ) );
			$this->animate_out = apply_filters( 'wpex_page_animation_out', wpex_get_mod( 'page_animation_out' ) );

			// Set enabled to true
			if ( $this->animate_in || $this->animate_out ) {
				$this->has_animations = true;
			}

			// If page animations is enabled lets do things
			if ( $this->has_animations ) {

				// Load scripts
				add_filter( 'wp_enqueue_scripts', array( $this, 'get_css' ) );

				// Open wrapper
				add_action( 'wpex_outer_wrap_before', array( $this, 'open_wrapper' ) );

				// Close wrapper
				add_action( 'wpex_outer_wrap_after', array( $this, 'close_wrapper' ) );
			   
				// Add to localize array
				add_action( 'wpex_localize_array', array( $this, 'localize' ) );

				// Add custom CSS for text
				add_action( 'wpex_head_css', array( $this, 'loading_text' ) );

				// Add strings to WPML
				add_filter( 'wpex_register_theme_mod_strings', array( $this, 'register_strings' ) );

			}

		}

		/**
		 * Retrieves cached CSS or generates the responsive CSS
		 *
		 * @since 2.1.0
		 */
		public function get_css() {
			wp_enqueue_style( 'animsition', WPEX_CSS_DIR_URI .'animsition.css' );
		}

		/**
		 * Localize script
		 *
		 * @since 2.1.0
		 */
		public function localize( $array ) {

			// Set animation to true
			$array['pageAnimation'] = true;

			// Animate In
			if ( $this->animate_in && array_key_exists( $this->animate_in, $this->in_transitions() ) ) {
				$array['pageAnimationIn'] = $this->animate_in;
			}

			// Animate out
			if ( $this->animate_out && array_key_exists( $this->animate_out, $this->out_transitions() ) ) {
				$array['pageAnimationOut'] = $this->animate_out;
			}

			// Animation Speeds
			$speed = wpex_get_mod( 'page_animation_speed' );
			$speed = $speed ? $speed : 400;
			$array['pageAnimationInDuration']  = $speed;
			$array['pageAnimationOutDuration'] = $speed;

			// Loading text
			$text = wpex_get_mod( 'page_animation_loading' );
			$text = $text ? $text : __( 'Loading...', 'wpex' );
			$array['pageAnimationLoadingText'] = $text;

	
			// Output opening div
			return $array;

		}

		/**
		 * Open wrapper
		 *
		 * @since 2.1.0
		 *
		 */
		public function open_wrapper() {
			echo '<div class="wpex-page-animation-wrap animsition clr">';
		}

		/**
		 * Close Wrapper
		 *
		 * @since 2.1.0
		 *
		 */
		public function close_wrapper() {
			echo '</div><!-- .animsition -->';
		}

		/**
		 * In Transitions
		 *
		 * @return array
		 *
		 * @since 2.1.0
		 *
		 */
		public static function in_transitions() {
			return array(
				''              => __( 'None', 'wpex' ),
				'fade-in'       => __( 'Fade In', 'wpex' ),
				'fade-in-up'    => __( 'Fade In Up', 'wpex' ),
				'fade-in-down'  => __( 'Fade In Down', 'wpex' ),
				'fade-in-left'  => __( 'Fade In Left', 'wpex' ),
				'fade-in-right' => __( 'Fade In Right', 'wpex' ),
				'rotate-in'     => __( 'Rotate In', 'wpex' ),
				'flip-in-x'     => __( 'Flip In X', 'wpex' ),
				'flip-in-y'     => __( 'Flip In Y', 'wpex' ),
				'zoom-in'       => __( 'Zoom In', 'wpex' ),
			);
		}

		/**
		 * Out Transitions
		 *
		 * @return array
		 *
		 * @since 2.1.0
		 */
		public static function out_transitions() {
			return array(
				''               => __( 'None', 'wpex' ),
				'fade-out'       => __( 'Fade Out', 'wpex' ),
				'fade-out-up'    => __( 'Fade Out Up', 'wpex' ),
				'fade-out-down'  => __( 'Fade Out Down', 'wpex' ),
				'fade-out-left'  => __( 'Fade Out Left', 'wpex' ),
				'fade-out-right' => __( 'Fade Out Right', 'wpex' ),
				'rotate-out'     => __( 'Rotate Out', 'wpex' ),
				'flip-out-x'     => __( 'Flip Out X', 'wpex' ),
				'flip-out-y'     => __( 'Flip Out Y', 'wpex' ),
				'zoom-out'       => __( 'Zoom Out', 'wpex' ),
			);
		}

		/**
		 * Add strings for WPML
		 *
		 * @return array
		 *
		 * @since 2.1.0
		 */
		public function register_strings( $strings ) {
			$strings['page_animation_loading'] = __( 'Loading...', 'wpex' );
			return $strings;
		}

		/**
		 * Adds customizer settings for the animations
		 *
		 * @return array
		 *
		 * @since 2.1.0
		 */
		public function customizer_settings( $sections ) {
			$sections['wpex_page_animations'] = array(
				'title' => __( 'Page Animations', 'wpex' ),
				'panel' => 'wpex_general',
				'desc'  => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
				'settings' => array(
					array(
						'id' => 'page_animation_in',
						'transport' => 'postMessage',
						'control' => array (
							'label' => __( 'In Animation', 'wpex' ),
							'type' => 'select',
							'choices' => $this->in_transitions(),
						),
					),
					array(
						'id' => 'page_animation_out',
						'transport' => 'postMessage',
						'control' => array (
							'label' => __( 'Out Animation', 'wpex' ),
							'type' => 'select',
							'choices' => $this->out_transitions(),
						),
					),
					array(
						'id' => 'page_animation_loading',
						'transport' => 'postMessage',
						'control' => array (
							'label' => __( 'Loading Text', 'wpex' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'page_animation_speed',
						'transport' => 'postMessage',
						'default' => 400,
						'control' => array (
							'label' => __( 'Speed', 'wpex' ),
							'type' => 'number',
						),
					),
				)
			);
			return $sections;
		}

		/**
		 * Add loading text
		 *
		 * @since 2.0.0
		 */
		public function loading_text( $css ) {
			$text = wpex_get_mod( 'page_animation_loading' );
			$text = $text ? $text : __( 'Loading...', 'wpex' );
			$css .= '/*PAGE ANIMATIONS*/.animsition-loading{content:"'. $text .'";}';
			return $css;
		}

	}
}
$wpex_page_transitions = new WPEX_Page_Animations();