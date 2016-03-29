<?php
/**
 * Used for generating custom layouts CSS
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Advanced_Styling' ) ) {
	
	class WPEX_Advanced_Styling {

		/**
		 * Main constructor
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			add_filter( 'wpex_head_css', array( $this, 'generate' ), 999 );
		}

		/**
		 * Generates the CSS output
		 *
		 * @since 2.0.0
		 */
		public static function generate( $output ) {

			// Define main variables
			$css = '';
			
			/*-----------------------------------------------------------------------------------*/
			/*  - Logo Max Widths
			/*-----------------------------------------------------------------------------------*/

			// Desktop
			if ( $width = wpex_get_mod( 'logo_max_width' ) ) {
				$css .= '@media only screen and (min-width: 960px) {
							#site-logo img {
								max-width: '. wpex_sanitize_data( $width, 'px_pct' ) .';
							}
						}';
			}

			// Tablet Portrait
			if ( $width = wpex_get_mod( 'logo_max_width_tablet_portrait' ) ) {
				$css .= '@media only screen and (min-width: 768px) and (max-width: 959px) {
							#site-logo img {
								max-width: '. wpex_sanitize_data( $width, 'px_pct' ) .';
							}
						}';
			}

			// Phone
			if ( $width = wpex_get_mod( 'logo_max_width_phone' ) ) {
				$css .= '@media only screen and (max-width: 767px) {
							#site-logo img {
								max-width: '. wpex_sanitize_data( $width, 'px_pct' ) .';
							}
						}';
			}

			/*-----------------------------------------------------------------------------------*/
			/*  - Other
			/*-----------------------------------------------------------------------------------*/

			// Fixes for full-width layout when custom background is added
			if ( 'full-width' == wpex_global_obj( 'main_layout' )
				&& ( wpex_get_mod( 'background_color' ) || wpex_get_mod( 'background_image' ) )
			) {
				$css .= '.wpex-sticky-header-holder{background:none;}';
			}

			// Fix for Fonts In the Visual Composer
			if ( wpex_global_obj( 'vc_is_inline' ) ) {
				$css .='.wpb_row .fa:before { box-sizing:content-box!important; -moz-box-sizing:content-box!important; -webkit-box-sizing:content-box!important; }';
			}

			// Remove header border if custom color is set
			if ( wpex_get_mod( 'header_background' ) ) {
				$css .='.is-sticky #site-header{border-color:transparent;}';
			}

			// Overlay Header font size
			if ( wpex_global_obj( 'has_overlay_header' )
				&& $font_size = get_post_meta( wpex_global_obj( 'post_id' ), 'wpex_overlay_header_font_size', true ) 
			) {
				$css .='#site-navigation, #site-navigation .dropdown-menu a{font-size:'. intval( $font_size ) .'px;}';
			}
			
			/*-----------------------------------------------------------------------------------*/
			/*  - Return CSS
			/*-----------------------------------------------------------------------------------*/
			if ( ! empty( $css ) ) {
				$output .= '/*ADVANCED STYLING CSS*/'. $css;
			}

			// Return output css
			return $output;

		}

	}

}
new WPEX_Advanced_Styling();