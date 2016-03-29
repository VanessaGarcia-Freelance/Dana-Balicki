<?php
/**
 * Revolution Slider Configurations
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Revslider_Config' ) ) {

	class WPEX_Revslider_Config {

		/**
		 * Start things up
		 *
		 * @since 1.6.0
		 */
		public function __construct() {
			add_action( 'do_meta_boxes', array( $this, 'remove_metabox' ) );
		}

		/**
		 * Remove the Slider revolution metabox where it isn't needed
		 *
		 * @since 1.6.0
		 */
		public function remove_metabox() {
			remove_meta_box( 'mymetabox_revslider_0', 'vc_grid_item', 'normal' );
			remove_meta_box( 'mymetabox_revslider_0', 'templatera', 'normal' );
		}

	}

}
$wpex_revslider_condig = new WPEX_Revslider_Config();