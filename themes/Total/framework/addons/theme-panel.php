<?php
/**
 * Main Theme Panel
 *
 * @package Total WordPress theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Theme_Panel' ) ) {
	class WPEX_Theme_Panel {
		private $user_key;

		/**
		 * Start things up
		 *
		 * @since 1.6.0
		 */
		public function __construct() {

			// Get $ validate user license
			$this->user_key         = get_option( 'wpex_product_license' );
			$this->license_is_valid = $this->validate_code();

			// Array of theme "parts/addons" that can be enabled/disabled
			$this->theme_addons = apply_filters( 'wpex_theme_addons', array(
				'under_construction' => array(
					'label' => __( 'Under Construction', 'wpex' ),
					'icon' => 'dashicons dashicons-hammer',
					'desc' => __( 'Redirect all non-logged in traffic to a single page while you work on your site.', 'wpex' ),
				),
				'recommend_plugins' => array(
					'label' => __( 'Recommend Plugins', 'wpex' ),
					'desc' => __( 'Displays a notice to enable theme recommended plugins. Can also be used for updating your Visual Composer and Slider Revolution.', 'wpex' ),
					'icon' => 'dashicons dashicons-admin-plugins'
				),
				'changelog' => array(
					'label' => __( 'Changelog', 'wpex' ),
					'desc' => __( 'Creates a new admin page that displays the changelog for the last five theme updates.', 'wpex' ),
					'icon' => 'dashicons dashicons-update',
				),
				'schema_markup' => array(
					'label' => __( 'Schema Markup', 'wpex' ),
					'desc' => __( 'Schema markup is code (semantic vocabulary) that you put on your website to help the search engines return more informative results for users.', 'wpex' ),
					'icon' => 'dashicons dashicons-feedback'
				),
				'minify_js' => array(
					'label' => __( 'Minify Javascript', 'wpex' ),
					'desc' => __( 'Instead of loading all the theme js files it will load a single minified javascript file to speed things up. Disable for troubleshooting console errors.', 'wpex' ),
					'icon' => 'dashicons dashicons-performance'
				),
				'custom_css' => array(
					'label' => __( 'Custom CSS', 'wpex' ),
					'icon' => 'dashicons dashicons-admin-appearance',
					'desc' => __( 'Add custom CSS to your site for your modifications without using a child theme. All custom CSS is minified on the front-end to keep things fast.', 'wpex' ),
				),
				'custom_js' => array(
					'label' => __( 'Custom JS', 'wpex' ),
					'icon' => 'dashicons dashicons-media-code',
					'desc' => __( 'Add custom JS to your site for your modifications without using a child theme. All custom JS will be added before the closing body tag.', 'wpex' ),
				),
				'custom_actions' => array(
					'label' => __( 'Custom Actions', 'wpex' ),
					'icon' => 'dashicons dashicons-editor-code',
					'desc' => __( 'Easily add custom HTML to the built-in theme action hooks and the wp_head and wp_footer core action hooks.', 'wpex' ),
				),
				'favicons' => array(
					'label' => __( 'Favicons', 'wpex' ),
					'icon' => 'dashicons dashicons-nametag',
					'desc' => __( 'Define your website icon that displays in the browser for desktops, mobile devices and retina devices.', 'wpex' ),
				),
				'visual_composer_theme_mode' => array(
					'label' =>  __( 'Visual Composer Theme Mode', 'wpex' ),
					'icon' => 'dashicons dashicons-align-left',
					'custom_id' => true,
					'desc' => __( 'Please keep this option enabled unless you have purchased a full copy of the Visual Composer plugin directly from the author.', 'wpex' ),
					'condition' => WPEX_VC_ACTIVE,
				),
				'extend_visual_composer' => array(
					'label' => WPEX_THEME_BRANDING .' '. __( 'Visual Composer Modules', 'wpex' ),
					'icon' => 'dashicons dashicons-align-left',
					'custom_id' => true,
					'desc' => __( 'This theme includes many extensions (more modules) for the Visual Composer plugin. If you do not wish to use them uncheck this box.', 'wpex' ),
					'condition' => WPEX_VC_ACTIVE,
				),
				/* Coming soon
				'hide_vc_deprecated_modules' => array(
					'enabled'   => false,
					'label'     => __( 'Hide Deprecated Visual Composer Modules', 'wpex' ),
					'icon'      => 'dashicons dashicons-align-left',
					'custom_id' => true,
					'desc'      => __( 'From time to time Visual Composer modules may become deprecated you can use this setting to completely hide them.', 'wpex' ),
					'condition' => WPEX_VC_ACTIVE,
				),*/
				'portfolio' => array(
					'label' => __( 'Portfolio', 'wpex' ),
					'icon' => 'dashicons dashicons-portfolio',
					'desc' => __( 'Display your work so your visitors and potential customers can see what you are all about via the built-in portfolio post type.', 'wpex' ),
				),
				'staff' => array(
					'label' => __( 'Staff', 'wpex' ),
					'icon' => 'dashicons dashicons-groups',
					'desc' => __( 'Easily add all your staff members to your site and showcase them on the front-end with the built-in staff post type.', 'wpex' ),
				),
				'testimonials' => array(
					'label' => __( 'Testimonials', 'wpex' ),
					'icon' => 'dashicons dashicons-format-status',
					'desc' => __( 'Show the world how much your customers love you and your products and or services with the testimonials post type.', 'wpex' ),
				),
				'post_series' => array(
					'label' => __( 'Post Series', 'wpex' ),
					'icon' => 'dashicons dashicons-edit',
					'desc' => __( 'Adds a new taxonomy to your standard posts so you can organize blog posts into series. Can be extended for use on custom types.', 'wpex' ),
				),
				'footer_builder' => array(
					'label' => __( 'Footer Builder', 'wpex' ),
					'icon' => 'dashicons dashicons-editor-insertmore',
					'desc' => __( 'Build a custom footer layout using the Visual Composer instead of being restricted by the native theme footer and widgets.', 'wpex' ),
				),
				'custom_admin_login'  => array(
					'label' => __( 'Login Page', 'wpex' ),
					'desc' => __( 'Completely redesign the default WordPress login page to include your own logo, background and custom form colors.', 'wpex' ),
					'icon' => 'dashicons dashicons-lock',
				),
				'custom_404' => array(
					'label' => __( '404 Page', 'wpex' ),
					'desc' => __( 'Redirect your 404 error page to the homepage or a custom page. Or add your own title and content for the default error page.', 'wpex' ),
					'icon' => 'dashicons dashicons-no-alt',
				),
				'customizer_panel' => array(
					'label' => __( 'Customizer Manager', 'wpex' ),
					'desc' => __( 'Enable or disable any Customizer panel to speed up development as you tweak your theme to fit your needs.', 'wpex' ),
					'icon' => 'dashicons dashicons-admin-settings',
				),
				'custom_wp_gallery' => array(
					'label' => __( 'Custom WordPress Gallery', 'wpex' ),
					'desc' => __( 'Display a nice grid with custom image cropping and lightbox for your WordPress galleries.', 'wpex' ),
					'icon' => 'dashicons dashicons-images-alt2',
				),
				'widget_areas' => array(
					'label' => __( 'Widget Areas', 'wpex' ),
					'desc' => __( 'Create custom widget areas under Appearance > Widgets that you can use to display widgets conditionally on your site.', 'wpex' ),
					'icon' => 'dashicons dashicons-archive',
				),
				'term_thumbnails' => array(
					'label' => __( 'Category Thumbnails', 'wpex' ),
					'desc' => __( 'Add custom thumbnails to your standard categories and built-in post type taxonomies that can be displayed in the archives.', 'wpex' ),
					'icon' => 'dashicons dashicons-format-image',
				),
				'editor_formats' => array(
					'label' => __( 'Editor Formats', 'wpex' ),
					'desc' => __( 'Adds custom styles to the post editor Formats dropdown so you can easily insert buttons, notices, dropcaps..etc.', 'wpex' ),
					'icon' => 'dashicons dashicons-editor-paste-word',
				),
				'editor_shortcodes' => array(
					'label' => __( 'Editor Shortcodes', 'wpex' ),
					'desc' => __( 'This theme includes a few basic shortcodes for use with the WP editor. You can easily disable them here.', 'wpex' ),
					'icon' => 'dashicons dashicons-editor-paste-word',
				),
				'remove_emoji_scripts' => array(
					'label' => __( 'Remove Emoji Scripts', 'wpex' ),
					'desc' => __( 'Remove the core WordPress Emoji scripts from your source code to slim down and speed up the site if you do not wish to use them.', 'wpex' ),
					'icon' => 'dashicons dashicons-smiley',
				),
				'image_sizes' => array(
					'label' => __( 'Image Sizes', 'wpex' ),
					'desc' => __( 'Define custom image cropping values for all features images used in the theme. Disable to display featured images at full size.', 'wpex' ),
					'icon' => 'dashicons dashicons-image-crop',
				),
				'page_animations' => array(
					'label' => __( 'Page Animations', 'wpex' ),
					'desc' => __( 'Adds a new section to the customizer under the General panel where you can enable a page load and exit animation.', 'wpex' ),
					'icon' => 'dashicons dashicons-welcome-view-site',
				),
				'edit_post_link' => array(
					'label' => __( 'Post Edit Links', 'wpex' ),
					'desc' => __( 'Enable to display edit page/post links below your posts and pages for quick access to the editor.', 'wpex' ),
					'icon' => 'dashicons dashicons-admin-tools',
				),
				'header_image' => array(
					'label' => __( 'Header Image', 'wpex' ),
					'disabled' => true,
					'desc' => __( 'Enable the core WordPress header image function in the Customizer which is disabled by default in this theme.', 'wpex' ),
					'icon' => 'dashicons dashicons-format-image',
				),
				'import_export' => array(
					'label' => __( 'Import/Export Panel', 'wpex' ),
					'desc' => __( 'Enables an admin panel you can use to import, export and reset all of your your theme_mods.', 'wpex' ),
					'icon' => 'dashicons dashicons-admin-settings',
				),
				'remove_posttype_slugs' => array(
					'disabled' => true,
					'label' => __( 'Remove Post Type Slugs', 'wpex' ),
					'desc' => __( 'Removes the slug from built-in custom post types. Slugs are important to prevent conflicts so use with caution (not recommented in most cases).', 'wpex' ),
					'custom_id' => true,
					'icon' => 'dashicons dashicons-art',
				),
			) );

			// Actions
			add_action( 'admin_menu', array( $this, 'add_menu_page' ), 0 );
			add_action( 'admin_enqueue_scripts',array( $this,'scripts' ) );
			add_action( 'admin_print_styles-toplevel_page_wpex-panel', array( $this,'css' ) );
			add_action( 'admin_menu', array( $this, 'add_menu_subpage' ) );
			add_action( 'admin_init', array( $this,'register_settings' ) );

			// Include subpanels
			$this->include_panels();

		}

		/**
		 * Registers a new menu page
		 *
		 * @since 1.6.0
		 */
		public function add_menu_page() {

		   $my_admin_page = add_menu_page(
				__( 'Theme Panel', 'wpex' ),
				'Theme Panel', // menu title - can't be translated because it' used for the $hook prefix
				'manage_options',
				WPEX_THEME_PANEL_SLUG,
				'',
				'dashicons-admin-generic',
				null
			);

			// Adds my_help_tab when my_admin_page loads
		   	global $wpex_admin_help_tabs;
			if ( $wpex_admin_help_tabs ) {
				add_action( 'load-'. $my_admin_page, array( $this, 'help_tab' ) );
			}

		}

		/**
		 * Load scripts
		 *
		 * @since 1.6.0
		 */
		public function scripts( $hook ) {
			if ( 'toplevel_page_wpex-panel' == $hook ) {
				wp_enqueue_script(
					'wpex-match-height', WPEX_JS_DIR_URI .'lib/jquery.matchHeight.js',
					array( 'jquery' ),
					false,
					true
				);
			}
		}

		/**
		 * Adds help tab to this admin page
		 *
		 * @since 1.6.0
		 */
		public function help_tab() {

			// Get current screen
			$screen = get_current_screen();

			// Define content
			$content  = '<p><h3>'. __( 'Useful Links', 'wpex' ) .'</h3><ul>';
				$content .= '<li><a href="http://wpexplorer-themes.com/total/changelog/" target="_blank">'. __( 'Changelog', 'wpex' ) .'</a></li>';
				$content .= '<li><a href="http://wpexplorer-themes.com/total/docs/" target="_blank">'. __( 'Documentation', 'wpex' ) .'</a></li>';
				$content .= '<li><a href="http://wpexplorer-themes.com/total/docs-category/sample-data/" target="_blank">'. __( 'Sample Data', 'wpex' ) .'</a></li>';
				$content .= '<li><a href="http://wpexplorer-themes.com/total/snippets/" target="_blank">'. __( 'Snippets', 'wpex' ) .'</a></li>';
				$content .= '<li><a href="http://themeforest.net/item/total-responsive-multipurpose-wordpress-theme/6339019/comments?ref=WPExplorer" target="_blank">'. __( 'Support', 'wpex' ) .'</a></li>';
			$content  .= '</ul></p>';

			// Add wpex_footer_builder help tab if current screen is My Admin Page
			$screen->add_help_tab( array(
				'id'      => 'wpex_theme_panel',
				'title'   => __( 'Useful Links', 'wpex' ),
				'content' => $content,
			) );

		}

		/**
		 * Registers a new submenu page
		 *
		 * @since 1.6.0
		 */
		public function add_menu_subpage(){
			add_submenu_page(
				'wpex-general',
				__( 'General', 'wpex' ),
				__( 'General', 'wpex' ),
				'manage_options',
				WPEX_THEME_PANEL_SLUG,
				array( $this, 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * @since 1.6.0
		 */
		public function register_settings() {
			register_setting( 'wpex_tweaks', 'wpex_tweaks', array( $this, 'admin_sanitize' ) ); 
		}

		/**
		 * Main Sanitization callback
		 *
		 * @since 1.6.0
		 */
		public function admin_sanitize( $options ) {

			// Check options first
			if ( ! is_array( $options ) || empty( $options ) || ( false === $options ) ) {
				return array();
			}

			// Save checkboxes
			$checkboxes = array();

			// Add theme parts to checkboxes
			foreach ( $this->theme_addons as $key => $val ) {

				// Get correct ID
				$id = isset( $val['custom_id'] ) ? $key : $key .'_enable';

				// No need to save items that are enabled by default unless they have been disabled
				$default = isset ( $val['disabled'] ) ? false : true;

				// If default is true
				if ( $default ) {
					if ( ! isset( $options[$id] ) ) {
						set_theme_mod( $id, 0 ); // Disable option that is enabled by default
					} else {
						remove_theme_mod( $id ); // Make sure its not in the theme_mods since it's already enabled
					}
				}

				// If default is false
				elseif ( ! $default ) {
					if ( isset( $options[$id] ) ) {
						set_theme_mod( $id, 1 ); // Enable option that is disabled by default
					} else {
						remove_theme_mod( $id ); // Remove theme mod because it's disabled by default
					}
				}


			}

			// Remove thememods for checkboxes not in array
			foreach ( $checkboxes as $checkbox ) {
				if ( isset( $options[$checkbox] ) ) {
					set_theme_mod( $checkbox, 1 );
				} else {
					set_theme_mod( $checkbox, 0 );
				}
			}

			// Save Branding
			$value = $options['theme_branding'];
			if ( empty( $value ) ) {
				remove_theme_mod( 'theme_branding' );
			} else {
				set_theme_mod( 'theme_branding', $value );
			}

			// Save Purchase code
			$value = $options['wpex_product_license'];
			if ( isset( $value ) ) {
				update_option( 'wpex_product_license', $value );
			}

			// No need to save in options table
			$options = '';
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.6.0
		 */
		public function create_admin_page() { ?>

			<div class="wpex-theme-panel wrap clr">

				<form method="post" action="options.php">

					<?php settings_fields( 'wpex_tweaks' ); ?>

					<h2 class="wpex-features-heading">
						<?php _e( 'Branding & Purchase Code', 'wpex' ); ?>
					</h2>

					<div class="wpex-theme-panel-top clr">

						<div>
							<h4><?php _e( 'Theme Branding', 'wpex' ); ?></h4>
							<input type="text" name="wpex_tweaks[theme_branding]" value="<?php echo wpex_get_mod( 'theme_branding' ); ?>" style="width:25em;" placeholder="<?php _e( 'Used in widgets and builder blocks...', 'wpex' ); ?>">
						</div>

						<?php
						// Validate purchase code
						if ( $this->user_key ) {
							$valid = $this->license_is_valid ? 'wpex-valid' : 'wpex-invalid';
						} else {
							$valid = '';
						} ?>

						<div>
							<h4 class="wpex-purchase-code-heading">
								<?php _e( 'Purchase Code', 'wpex' ); ?>
								<?php if ( 'wpex-valid' == $valid ) { ?>
									<span class="dashicons dashicons-yes"></span>
								<?php } elseif ( 'wpex-invalid' == $valid ) { ?>
									<span class="dashicons dashicons-no"></span>
								<?php } ?>

							</h4>
							<input type="text" name="wpex_tweaks[wpex_product_license]" value="<?php echo $this->user_key; ?>" style="width:25em;" placeholder="<?php _e( 'Get auto updates and sample data...', 'wpex' ); ?>" class="<?php echo $valid; ?>"><p class="description"></p>
						</div>

					</div>


					<h2 class="wpex-features-heading">
						<?php _e( 'Theme Features', 'wpex' ); ?>
						<?php submit_button(); ?>
					</h2>

					<div class="wpex-features clr">

						<div class="wpex-row clr">

							<?php
							// Loop through theme pars and add checkboxes
							$wpex_count=0;
							foreach ( $this->theme_addons as $key => $val ) :
								$wpex_count++;

								// Display setting?
								$display = true;
								if ( isset( $val['condition'] ) ) {
									$display = $val['condition'];
								}

								// Fix counter for hidden item
								if ( ! $display ) {
									$wpex_count = $wpex_count - 1;
								}

								// Sanitize vars
								$default = isset ( $val['disabled'] ) ? false : true;
								$label   = isset ( $val['label'] ) ? $val['label'] : '';
								$icon    = isset ( $val['icon'] ) ? $val['icon'] : '';

								// Label
								if ( $icon ) {
									$label = '<i class="'. $icon .'"></i>'. $label;
								}

								// Set id
								if ( isset( $val['custom_id'] ) ) {
									$key = $key;
								} else {
									$key = $key .'_enable';
								}

								// Get theme option
								$theme_mod = wpex_get_mod( $key, $default ); ?>

								<div class="wpex-col-3 clr wpex-count-<?php echo $wpex_count; ?><?php if ( ! $display ) echo ' wpex-hidden'; ?>">

									<div class="wpex-feature clr <?php if ( ! $theme_mod ) echo 'wpex-disabled'; ?>">

										<h3><?php echo $label; ?></h3>

										<?php if ( isset( $val['desc'] ) ) { ?>
											<p class="wpex-feature-description"><?php echo $val['desc']; ?></p>
										<?php } ?>

										<input type="checkbox" name="wpex_tweaks[<?php echo $key; ?>]" value="<?php echo $theme_mod; ?>" <?php checked( $theme_mod, true ); ?> class="wpex-checkbox">

										<a href="#" title="<?php _e( 'On', 'wpex' ); ?>" class="button wpex-toggle-on <?php if ( $theme_mod ) echo 'button-primary'; ?>">
											<?php _e( 'On', 'wpex' ); ?>
										</a>

										<a href="#" title="<?php _e( 'Off', 'wpex' ); ?>" class="button wpex-toggle-off <?php if ( ! $theme_mod ) echo 'button-primary'; ?>">
											<?php _e( 'Off', 'wpex' ); ?>
										</a>

									</div>

								</div>

								<?php if ( 3 == $wpex_count ) $wpex_count = 0; ?>

							<?php endforeach; ?>

						</div>

					</div>

				</form>

			</div>

			<script>
				( function( $ ) {
					"use strict";
					$( document ).ready( function() {
						$( '.wpex-toggle-on' ).click( function( e ) {
							e.preventDefault();
							$( this ).addClass( 'button-primary' );
							$( this ).parent().find( '.wpex-checkbox' ).attr( 'checked', true );
							$( this ).next().removeClass( 'button-primary' );
						} );
						$( '.wpex-toggle-off' ).click( function( e ) {
							e.preventDefault();
							$( this ).addClass( 'button-primary' );
							$( this ).parent().find( '.wpex-checkbox' ).attr( 'checked', false );
							$( this ).prev().removeClass( 'button-primary' );
						} );
						$( window ).load(function() {
							if ( $.fn.matchHeight ) {
								$( '.wpex-feature p.wpex-feature-description' ).matchHeight();
							}
           				} );
           			} );
				} ) ( jQuery );
			</script>

		<?php
		}

		/**
		 * Validate purchase code
		 *
		 * @since 3.0.0
		 * @link  https://build.envato.com/api#market_0_Buyer_Purchases
		 */
		private function validate_code() {

			// Check if key is already valid
			if ( $this->user_key && get_option( 'wpex-verify-purchase-'. $this->user_key ) ) {
				return true;
			}

			// Validate Key
			if ( $this->user_key ) {

				// Get data
				$response = wp_remote_get( 'https://api.envato.com/v1/market/private/user/verify-purchase:'. $this->user_key .'.json', array(
					'headers' => array(
						'Authorization' => 'Bearer GJk2ohI6oyTfZwkwH2vbAwdLm5gvovr8'
					),
				) );

				// Check for errors
				if ( is_wp_error( $response ) or ( wp_remote_retrieve_response_code( $response ) != 200 ) ) {
					return false;
				}
 	
				// Get and decode data
				$data = json_decode( wp_remote_retrieve_body( $response ), true );

				// Validate data
				if ( ! empty( $data['verify-purchase'] ) ) {
					update_option( 'wpex-verify-purchase-'. $this->user_key, 1 );
					return true;
				} else {
					return false;
				}

			} else {
				return false;
				
			}
			
		}

		/**
		 * Include addons
		 *
		 * @since 1.6.0
		 */
		private function include_panels() {
			$dir = WPEX_FRAMEWORK_DIR .'addons/';

			// Under Construction
			if ( wpex_get_mod( 'under_construction_enable', true ) ) {
				require_once( $dir .'under-construction.php' );
			}

			// Custom Favicons
			if ( wpex_get_mod( 'favicons_enable', true ) ) {
				require_once( $dir .'favicons.php' );
			}

			// Custom 404
			if ( wpex_get_mod( 'custom_404_enable', true ) ) {
				require_once( $dir .'custom-404.php' );
			}

			// Custom widget areas
			if ( wpex_get_mod( 'widget_areas_enable', true ) ) {
				require_once( $dir .'widget-areas.php' );
			}

			// Custom Login
			if ( wpex_get_mod( 'custom_admin_login_enable', true ) ) {
				require_once( $dir .'custom-login.php' );
			}

			// Footer builder
			if ( wpex_get_mod( 'footer_builder_enable', true ) ) {
				require_once( $dir .'footer-builder.php' );
			}

			// Custom WordPress gallery output
			if ( wpex_get_mod( 'custom_wp_gallery_enable', true ) ) {
				require_once( $dir .'custom-wp-gallery.php' );
			}

			// Custom CSS
			if ( wpex_get_mod( 'custom_css_enable', true ) ) {
				require_once( $dir .'custom-css.php' );
			}

			// Custom JS
			if ( wpex_get_mod( 'custom_js_enable', true ) ) {
				require_once( $dir .'custom-js.php' );
			}

			// User Actions
			if ( wpex_get_mod( 'custom_actions_enable', true ) ) {
				require_once( $dir .'custom-actions.php' );
			}

			// Page animations
			if ( wpex_get_mod( 'page_animations_enable', true ) ) {
				require_once( $dir .'page-animations.php' );
			}

			// Skins (deprecated since 3.0.0)
			require_once( get_template_directory() . '/skins/skins.php' );

			// Import Export Functions
			if ( is_admin() && wpex_get_mod( 'import_export_enable', true ) ) {
				require_once( $dir .'import-export.php' );
			}

			/*** ADMIN ONLY ADDONS ***/
			if ( is_admin() ) {

				// Changelog
				if ( wpex_get_mod( 'changelog_enable', true ) ) {
					require_once( $dir .'changelog.php' );
				}

				// Editor formats
				if ( wpex_get_mod( 'editor_formats_enable', true ) ) {
					require_once( $dir .'editor-formats.php' );
				}

			} // End is_admin()

		}

		/**
		 * Theme panel CSS
		 *
		 * @since 3.0.0
		 */
		public static function css() { ?>
		
			<style type="text/css">

				.clr:after { content: ""; display: block; height: 0; clear: both; visibility: hidden; zoom: 1; }
				.wpex-theme-panel { padding: 0 40px 0 20px }

				.wpex-theme-panel-top input { font-size: 14px; padding: 10px; }
				.wpex-theme-panel-top h4 { margin: 0 0 10px }
				.wpex-theme-panel-top > div { float: left; margin-right: 40px; margin-bottom: 20px; }

				.wrap h2.wpex-features-heading { position: relative; margin-bottom: 20px; color: #000; }
				.wpex-features-heading p.submit { position: absolute; right: 0; top: 0; margin: 0 !important; }

				.wpex-row { margin: 0 -10px }
				.wpex-count-1 { clear: both }
				.wpex-col-3 { display: block; float: left; width: 33.33%; padding: 0 10px; margin-bottom: 20px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
				.wpex-feature { padding: 15px; text-align: left; border: 1px solid #dae0e2; background: #fff; box-shadow: 0 0 0 rgba(0,0,0,0.03); transition: all 0.15s ease-in; font-weight: 300; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
				.wpex-col-3.wpex-hidden { display: none }

				.wpex-feature h3 { margin: 0 0 15px; font-size: 1.14286em; line-height: 1.4em; font-weight: 600; }
				.wpex-feature h3 i { margin-right: 7px }
				.wpex-feature.wpex-disabled { opacity: 0.75 }
				.wpex-feature:hover,
				.wpex-feature:focus { border-color: #8ac9e8; background: #f8fcfe; opacity: 1 !important; }
				.wpex-feature p { color: #686f72; margin: 0 0 13px; min-height: 60px; }
				.wpex-feature .wpex-checkbox { display: none !important }

				.admin-color-fresh .wpex-feature h3 { color: #1a8dba; }
				.admin-color-midnight .wpex-feature h3 { color: #dd382d; }
				.admin-color-light .wpex-feature h3 { color: #777; }
				.admin-color-blue .wpex-feature h3 { color: #096484; }
				.admin-color-coffee .wpex-feature h3 { color: #59524c; }
				.admin-color-ectoplasm .wpex-feature h3 { color: #a3b745; }
				.admin-color-ocean .wpex-feature h3 { color: #9ebaa0; }
				.admin-color-sunrise .wpex-feature h3 { color: #dd823b; }

				.admin-color-fresh .wpex-feature:hover,
				.admin-color-fresh .wpex-feature:focus { border-color: #8ac9e8; background: #f8fcfe; }

				.admin-color-coffee .wpex-feature:hover,
				.admin-color-coffee .wpex-feature:focus { border-color: #d8dac9; background: #fcfcfb; }

				.admin-color-ectoplasm .wpex-feature:hover,
				.admin-color-ectoplasm .wpex-feature:focus { border-color: #a695c0; background: #fff; }

				.admin-color-ocean .wpex-feature:hover,
				.admin-color-ocean .wpex-feature:focus { border-color: #cbd4d7; background: #fbfcfc; }

				.admin-color-sunrise .wpex-feature:hover,
				.admin-color-sunrise .wpex-feature:focus { border-color: #f4d7c3; background: #fefdfc; }

				.wpex-purchase-code-heading > span { float: right }
				.wpex-purchase-code-heading .dashicons-no { color: red }
				input.wpex-invalid { border-color: red !important }
				.wpex-purchase-code-heading .dashicons-yes { color: #8BC53F }
				input.wpex-valid { border-color: #8BC53F !important }

				@media only screen and (max-width: 800px) { 
					.wpex-theme-panel { padding-left: 10px; padding-right: 20px; }
					.wpex-col-3 { width: 100% }
				}

			</style>


		<?php }

	}
}
$wpex_theme_panel = new WPEX_Theme_Panel();