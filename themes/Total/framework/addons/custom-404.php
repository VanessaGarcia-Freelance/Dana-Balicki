<?php
/**
 * Custom 404 Page Design
 *
 * @package Total WordPress theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Custom_Error_page' ) ) {

	class WPEX_Custom_Error_page {

		/**
		 * Start things up
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_page' ) );
			add_action( 'admin_init', array( $this,'register_page_options' ) );
			add_filter( 'template_redirect', array( $this, 'redirect' ) );
		}

		/**
		 * Add sub menu page for the custom CSS input
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_page
		 */
		public function add_page() {
			add_submenu_page(
				WPEX_THEME_PANEL_SLUG,
				__( '404 Page', 'wpex' ),
				__( '404 Page', 'wpex' ),
				'administrator',
				WPEX_THEME_PANEL_SLUG .'-404',
				array( $this, 'create_admin_page' )
			);
		}

		/**
		 * Function that will register admin page options.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_setting
		 * @link http://codex.wordpress.org/Function_Reference/add_settings_section
		 * @link http://codex.wordpress.org/Function_Reference/add_settings_field
		 */
		public function register_page_options() {

			// Register settings
			register_setting( 'wpex_error_page', 'error_page', array( $this, 'sanitize' ) );

			// Add main section to our options page
			add_settings_section( 'wpex_error_page_main', false, array( $this, 'section_main_callback' ), 'wpex-custom-error-page-admin' );

			// Redirect field
			add_settings_field(
				'redirect',
				__( 'Redirect 404\'s', 'wpex' ),
				array( $this, 'redirect_field_callback' ),
				'wpex-custom-error-page-admin',
				'wpex_error_page_main'
			);

			// Custom Page ID
			add_settings_field(
				'error_page_id',
				__( 'Custom 404 Redirect', 'wpex' ),
				array( $this, 'content_id_field_callback' ),
				'wpex-custom-error-page-admin',
				'wpex_error_page_main'
			);

			// Title field
			add_settings_field(
				'error_page_title',
				__( '404 Page Title', 'wpex' ),
				array( $this, 'title_field_callback' ),
				'wpex-custom-error-page-admin',
				'wpex_error_page_main'
			);

			// Content field
			add_settings_field(
				'error_page_text',
				__( '404 Page Content', 'wpex' ),
				array( $this, 'content_field_callback' ),
				'wpex-custom-error-page-admin',
				'wpex_error_page_main'
			);

		}

		/**
		 * Sanitization callback
		 */
		public function sanitize( $options ) {

			// Set theme mods
			if ( isset ( $options['redirect'] ) ) {
				set_theme_mod( 'error_page_redirect', 1 );
			} else {
				set_theme_mod( 'error_page_redirect', 0 );
			}

			if ( isset( $options['title'] ) ) {
				set_theme_mod( 'error_page_title', $options['title'] );
			}

			if ( isset( $options['text'] ) ) {
				set_theme_mod( 'error_page_text', $options['text'] );
			}

			if ( isset( $options['content_id'] ) ) {
				set_theme_mod( 'error_page_content_id', $options['content_id'] );
			}

			// Set options to nothing since we are storing in the theme mods
			$options = '';
			return $options;
		}

		/**
		 * Main Settings section callback
		 */
		public function section_main_callback( $options ) {
			// Leave blank
		}

		/**
		 * Fields callback functions
		 */

		// Redirect field
		public function redirect_field_callback() {
			$val    = wpex_get_mod( 'error_page_redirect' );
			$output = '<input type="checkbox" name="error_page[redirect]" id="error-page-redirect" value="'. $val .'" '. checked( $val, true, false ) .'> ';
			$output .= '<span class="description">'. __( 'Automatically 301 redirect all 404 errors to your homepage.', 'wpex' ) .'</span>';
			echo $output;
		}

		// Custom Error Page ID
		public function content_id_field_callback() {
			wp_dropdown_pages( array(
				'echo'             => true,
				'selected'         => wpex_get_mod( 'error_page_content_id' ),
				'name'             => 'error_page[content_id]',
				'id'               => 'error-page-content-id',
				'show_option_none' => __( 'None', 'wpex' ),
			) ); ?>
			<br />
			<p class="description"><?php _e( 'Select a custom page if you want to use the Visual Composer to create your custom 404 page.', 'wpex' ) ?></p>
		<?php }

		// Title field
		public function title_field_callback() { ?>
			<input type="text" name="error_page[title]" id="error-page-title" value="<?php echo wpex_get_mod( 'error_page_title' ); ?>">
			<p class="description"><?php _e( 'Enter a custom title for your 404 page.', 'wpex' ) ?></p>
		<?php }

		// Content field
		public function content_field_callback() {
			wp_editor( wpex_get_mod( 'error_page_text' ), 'error_page_text', array(
				'textarea_name' => 'error_page[text]'
			) );
		}

		/**
		 * Settings page output
		 */
		public function create_admin_page() { ?>
			<div class="wrap">
				<h2 style="padding-right:0;">
					<?php _e( '404 Error Page', 'wpex' ); ?>
				</h2>
				<form method="post" action="options.php">
					<?php settings_fields( 'wpex_error_page' ); ?>
					<?php do_settings_sections( 'wpex-custom-error-page-admin' ); ?>
					<?php submit_button(); ?>
				</form>
			</div><!-- .wrap -->
			<script>
				( function( $ ) {
					"use strict";

					// Hide/Show fields if page Id is defined
					var $pageIdSelect   = $( '#error-page-content-id' ),
						$pageIdVal      = $pageIdSelect.val(),
						$fieldsTohide   = $( '#error-page-title, #wp-error_page_text-wrap' );

					// Get tr of field to hide
					var $elementsTohide = $fieldsTohide.closest( 'tr' );

					// Check initial val    
					if ( $pageIdVal ) {
						$elementsTohide.hide();
					}

					// Check on change
					$( $pageIdSelect ).change(function () {
						var $selected = $( this ).val();
						if ( $selected !== '' ) {
							$elementsTohide.hide();
						} else {
							$elementsTohide.show();
						}
					});

				} ) ( jQuery );

			</script>
		<?php }

		/**
		 * Redirect all pages to the under cronstruction page if user is not logged in
		 *
		 * @link    http://codex.wordpress.org/Plugin_API/Action_Reference/template_redirect
		 * @since   1.6.0
		 */
		public function redirect() {

			if ( is_404() ) :

				// Redirect home
				if ( wpex_get_mod( 'error_page_redirect' ) ) {
					wp_redirect( home_url(), 301 );
					exit();
				}

				// Custom redirect
				if ( $error_page_id = wpex_get_mod( 'error_page_content_id' ) ) {
					if ( function_exists( 'icl_object_id' ) ) {
						$error_page_id = icl_object_id( $error_page_id, 'page' );
					}
					$permalink = get_permalink( $error_page_id );
					if ( $permalink ) {
						wp_redirect( $permalink, 301 );
						exit();
					}
				}

			endif;

		}
	}

}
new WPEX_Custom_Error_page();