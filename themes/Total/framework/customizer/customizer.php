<?php
/**
 * Main Customizer functions
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define class global var
global $wpex_customizer;

/**
 * Total Customizer class
 *
 * @since 3.0.0
 */
if ( ! class_exists( 'WPEX_Customizer' ) ) {
	class WPEX_Customizer {
		private $customizer_dir_uri;
		private $customizer_dir;
		private $admin_enabled = true;
		private $inline_css_cache;
		private $panels = array();
		private $enabled_panels = array();
		private $sections = array();
		private $settings = array();

		/**
		 * Start things up
		 *
		 * @since 3.0.0
		 */
		public function __construct() {

			// Give values to vars
			$this->customizer_dir_uri = WPEX_FRAMEWORK_DIR_URI .'customizer/';
			$this->customizer_dir     = WPEX_FRAMEWORK_DIR .'customizer/';

			// Check if the customizer admin panel is enabled
			$this->admin_enabled = wpex_get_mod( 'customizer_panel_enable', true );

			// Add admin panel if enabled
			if ( is_admin() && $this->admin_enabled ) {
				add_action( 'admin_menu', array( $this, 'add_admin_page' ), 40 );
				add_action( 'admin_init', array( $this,'admin_options' ) );
				add_action( 'admin_print_styles-'. WPEX_ADMIN_PANEL_HOOK_PREFIX . '-customizer', array( $this,'admin_styles' ), 40 );
			}

			// Create an array of registered theme customizer panels
			$this->panels = apply_filters( 'wpex_customizer_panels', array(
				'general' => array(
					'title' => __( 'General Theme Options', 'wpex' ),
				),
				'layout' => array(
					'title' => __( 'Layout', 'wpex' ),
				),
				'typography' => array(
					'title' => __( 'Typography', 'wpex' ),
				),
				'togglebar' => array(
					'title' => __( 'Toggle Bar', 'wpex' ),
					'is_section' => true,
				),
				'topbar' => array(
					'title' => __( 'Top Bar', 'wpex' ),
					'is_section' => true,
				),
				'header' => array(
					'title' => __( 'Header', 'wpex' ),
				),
				'navbar' => array(
					'title' => __( 'Navbar', 'wpex' ),
					'is_section' => true,
				),
				'mobile_menu' => array(
					'title' => __( 'Mobile Menu', 'wpex' ),
					'is_section' => true,
				),
				'sidebar' => array(
					'title' => __( 'Sidebar', 'wpex' ),
					'is_section' => true,
				),
				'blog' => array(
					'title' => __( 'Blog', 'wpex' ),
				),
				'portfolio' => array(
					'title' => __( 'Portfolio', 'wpex' ),
					'condition' => WPEX_PORTFOLIO_IS_ACTIVE,
				),
				'staff' => array(
					'title' => __( 'Staff', 'wpex' ),
					'condition' => WPEX_STAFF_IS_ACTIVE,
				),
				'testimonials' => array(
					'title' => __( 'Testimonials', 'wpex' ),
					'condition' => WPEX_TESTIMONIALS_IS_ACTIVE,
					'is_section' => true,
				),
				'woocommerce' => array(
					'title' => __( 'WooCommerce', 'wpex' ),
					'condition' => WPEX_WOOCOMMERCE_ACTIVE,
				),
				'callout' => array(
					'title' => __( 'Callout', 'wpex' ),
					'is_section' => true,
				),
				'footer_widgets' => array(
					'title' => __( 'Footer Widgets', 'wpex' ),
					'is_section' => true,
				),
				'footer_bottom' => array(
					'title' => __( 'Footer Bottom', 'wpex' ),
					'is_section' => true,
				),
				'visual_composer' => array(
					'title' => __( 'Visual Composer', 'wpex' ),
					'is_section' => true,
					'condition' => WPEX_VC_ACTIVE,
				),
			) );

			// Get enabled panels
			$this->enabled_panels = get_option( 'wpex_customizer_panels', $this->panels );

			// Add sections (stores all sections in array if not already saved in DB)
			if ( ! $this->sections ) {
				$this->add_sections();
			}

			// Add custom controls and callbacks
			add_action( 'customize_register', array( $this, 'controls_callbacks' ) );

			// Remove core panels and sections
			add_action( 'customize_register', array( $this, 'remove_core_sections' ), 11 );

			// Add theme customizer sections and panels
			add_action( 'customize_register', array( $this, 'add_customizer_panels_sections' ), 40 );

			// Adds CSS for customizer custom controls
			add_action( 'customize_controls_print_styles', array( $this, 'customize_controls_print_styles' ) );

			// Include Typography & Styling Classes
			require_once( WPEX_FRAMEWORK_DIR .'customizer/settings/typography.php' );

			// Get inline CSS cache - humm, not sure if I really want to add this
			// Could cause issues for people and they don't know what's up
			//$this->inline_css_cache = get_option( 'wpex_customizer_inline_css_cache' );
			
			// Add inline CSS to header = Run Last to make sure it overrides custom CSS
			add_action( 'wpex_head_css' , array( $this, 'add_inline_css' ), 999 );

			// Reset CSS cache
			add_action( 'customize_save_after', array( $this, 'reset_inline_css_cache' ) );
			add_action( 'switch_theme', array( $this, 'reset_inline_css_cache' ) );
			if ( ! empty( $_GET['wpex_clear_customizer_cache'] ) ) {
				$this->reset_inline_css_cache();
			}

		}

		/**
		 * Add sub menu page for the custom CSS input
		 *
		 * @since 3.0.0
		 */
		public function add_admin_page() {
			add_submenu_page(
				WPEX_THEME_PANEL_SLUG,
				__( 'Customizer Manager', 'wpex' ),
				__( 'Customizer Manager', 'wpex' ),
				'administrator',
				WPEX_THEME_PANEL_SLUG .'-customizer',
				array( $this, 'create_admin_page' )
			);
		}

		/**
		 * Prints styles for the admin page
		 *
		 * @since 3.0.0
		 */
		public function admin_styles() { ?>

			<style type="text/css">
				.wpex-customizer-editor-table th,
				.wpex-customizer-editor-table td { padding: 7px 0 !important; }
			</style>

		<?php }

		/**
		 * Function that will register admin page options.
		 *
		 * @since 3.0.0
		 */
		public function admin_options() {
			register_setting( 'wpex_customizer_editor', 'wpex_customizer_panels' );
		}

		/**
		 * Settings page output
		 *
		 * @since 3.0.0
		 *
		 */
		public function create_admin_page() { ?>

			<div class="wrap">

				<h2><?php _e( 'Customizer Manager', 'wpex' ); ?></h2>

				<?php
				// Customizer url
				$customize_url = add_query_arg(
					array(
						'return'                => urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
						'wpex_theme_customizer' => 'true',
					),
					'customize.php'
				); ?>

				<h2 class="nav-tab-wrapper">
					<a href="#" class="nav-tab nav-tab-active"><?php _e( 'Enable Panels', 'wpex' ); ?></a>
					<a href="<?php echo esc_url( $customize_url ); ?>?return=1"  class="nav-tab"><?php _e( 'Customize', 'wpex' ); ?><span class="dashicons dashicons-external" style="padding-left:7px;"></span></a>
				</h2>

				<div style="margin-top:20px;">
					<a href="#" class="wpex-customizer-check-all"><?php _e( 'Check all', 'wpex' ); ?></a> | <a href="#" class="wpex-customizer-uncheck-all"><?php _e( 'Uncheck all', 'wpex' ); ?></a>
				</div>

				<form method="post" action="options.php">

					<?php settings_fields( 'wpex_customizer_editor' ); ?>

					<table class="form-table wpex-customizer-editor-table">
						<?php
						// Get panels
						$panels = $this->panels;

						// Check if post types are enabled
						$post_types = wpex_theme_post_types();

						// Get options and set defaults
						$options = get_option( 'wpex_customizer_panels', $this->panels );

						// Loop through panels and add checkbox
						foreach ( $panels as $id => $val ) {

							// Parse panel data
							$title     = isset( $val['title'] ) ? $val['title'] : $val;
							$condition = isset( $val['condition'] ) ? $val['condition'] : true;

							// Get option
							$option = isset( $options[$id] ) ? 'on' : false;

							// Display option if condition is met
							if ( $condition ) { ?>

								<tr valign="top">
									<th scope="row"><?php echo $title; ?></th>
									<td>
										<fieldset>
											<input class="wpex-customizer-editor-checkbox" type="checkbox" name="wpex_customizer_panels[<?php echo $id; ?>]"<?php checked( $option, 'on' ); ?>>
										</fieldset>
									</td>
								</tr>

							<?php }

							// Condition isn't met so add it as a hidden item
							else { ?>

								<input type="hidden" name="wpex_customizer_panels[<?php echo $id; ?>]"<?php checked( $option, 'on' ); ?>>	

							<?php } ?>

						<?php } ?>

					</table>

					<?php submit_button(); ?>

				</form>

			</div><!-- .wrap -->

			<script>
				(function($) {
					"use strict";
						$( '.wpex-customizer-check-all' ).click( function() {
							$('.wpex-customizer-editor-checkbox').each( function() {
								this.checked = true;
							} );
							return false;
						} );
						$( '.wpex-customizer-uncheck-all' ).click( function() {
							$('.wpex-customizer-editor-checkbox').each( function() {
								this.checked = false;
							} );
							return false;
						} );
				} ) ( jQuery );
			</script>

		<?php } // END create_admin_page()

		/**
		 * Adds custom controls
		 *
		 * @since 3.0.0
		 */
		public function controls_callbacks() {
			require_once( $this->customizer_dir . 'customizer-controls.php' );
			require_once( $this->customizer_dir . 'customizer-helpers.php' );
		}

		/**
		 * Adds CSS for customizer custom controls
		 *
		 * @since 3.0.0
		 */
		public static function customize_controls_print_styles() { ?>
			
			 <style type="text/css" id="wpex-customizer-controls-css">

				/* General Tweaks */
				.customize-control-select select { min-width: 100% }

				/* Slider UI */
				li.customize-control.customize-control-wpex_slider_ui input[type=text] { width: 20%; float: left; text-align: center; }
				li.customize-control.customize-control-wpex_slider_ui .ui-slider-horizontal.wpex-slider-ui { float: right; width: 75%; height: 5px; margin-top: 10px; color: #333; position: relative; border-radius: 5px; border: 1px solid #747474; border-bottom-color: #aeaeae; background-color: #cdcdcd; background: -webkit-linear-gradient(#aaaaaa, #cdcdcd); background: -o-linear-gradient(#aaaaaa, #cdcdcd); background: -moz-linear-gradient(#aaaaaa, #cdcdcd); background: linear-gradient(#aaaaaa, #cdcdcd); }
				li.customize-control.customize-control-wpex_slider_ui .ui-slider-horizontal .ui-slider-handle { position: absolute; z-index: 2; width: 17px; height: 17px; cursor: default; top: -7px; margin-left: -10px; border-radius: 50%; border: 1px solid #9e9e9e; -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.07); box-shadow: inset 0 1px 2px rgba(0,0,0,.07); cursor: pointer; background-color: #f5f5f5; background: -webkit-linear-gradient(#f8f8f8, #ededed); background: -o-linear-gradient(#f8f8f8, #ededed); background: -moz-linear-gradient(#f8f8f8, #ededed); background: linear-gradient(#f8f8f8, #ededed); box-shadow: 0 2px 2px rgba(0,0,0,0.24); }

				/* Sortable */
				.wpex-sortable ul { margin-top: 10px }
				.wpex-sortable li.wpex-sortable-li { cursor: move; background: #fff; padding: 0; padding-left: 15px; height: 40px; line-height: 40px; white-space: nowrap; border: 1px solid #dfdfdf; text-overflow: ellipsis; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; color: #222; margin-bottom: 5px; margin-top: 0; overflow: hidden; position: relative; }
				.wpex-sortable li.wpex-sortable-li:hover { border-color: #999; z-index: 10; }
				.wpex-sortable li.wpex-sortable-li .dashicons { display: block; position: absolute; top: 0; right: 0; width: 42px; height: 40px; line-height: 40px; margin: 0; color: #a0a5aa; }
				.wpex-sortable li.wpex-sortable-li .wpex-hide-sortee { cursor: pointer }
				.wpex-sortable li.wpex-sortable-li .wpex-hide-sortee:hover { color: #F64744; }
				.wpex-sortable ul li:last-child { margin-bottom: 0 }
				.wpex-sortable li.wpex-hide { opacity: 0.6; }
				.wpex-sortable li.wpex-hide .wpex-hide-sortee:hover { color: #23CF5F; }

				/* Custom Heading */
				.wpex-customizer-heading { display: block; padding-top: 30px; padding-bottom: 5px; border-bottom: 1px solid #ddd; font-size: 16px; font-weight: bold; }

			 </style>

		<?php }

		/**
		 * Removes core modules
		 *
		 * @since 3.0.0
		 */
		public static function remove_core_sections( $wp_customize ) {

			// Remove core sections
			$wp_customize->remove_section( 'colors' );
			$wp_customize->remove_section( 'nav' );
			$wp_customize->remove_section( 'themes' );
			$wp_customize->remove_section( 'title_tagline' );
			$wp_customize->remove_section( 'background_image' );
			$wp_customize->remove_section( 'static_front_page' );

			// Remove core controls
			$wp_customize->remove_control( 'blogname' );
			$wp_customize->remove_control( 'blogdescription' );
			$wp_customize->remove_control( 'header_textcolor' );
			$wp_customize->remove_control( 'background_color' );
			$wp_customize->remove_control( 'background_image' );

			// Remove default settings
			$wp_customize->remove_setting( 'background_color' );
			$wp_customize->remove_setting( 'background_image' );

			// Remove widgets
			$wp_customize->remove_panel( 'widgets' );

			// Remove menus - slows things down
			$wp_customize->remove_panel( 'nav_menus' );
			remove_action( 'customize_controls_enqueue_scripts', array( $wp_customize->nav_menus, 'enqueue_scripts' ) );
			remove_action( 'customize_register', array( $wp_customize->nav_menus, 'customize_register' ), 11 );
			remove_filter( 'customize_dynamic_setting_args', array( $wp_customize->nav_menus, 'filter_dynamic_setting_args' ) );
			remove_filter( 'customize_dynamic_setting_class', array( $wp_customize->nav_menus, 'filter_dynamic_setting_class' ) );
			remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'print_templates' ) );
			remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'available_items_template' ) );
			remove_action( 'customize_preview_init', array( $wp_customize->nav_menus, 'customize_preview_init' ) );

		}

		/**
		 * Get all sections
		 *
		 * @since 3.0.0
		 */
		public function add_sections() {

			// Get panels
			$panels = $this->panels;

			// Return if there aren't any panels
			if ( ! $panels ) {
				return;
			}

			// Loop through panels
			foreach( $panels as $id => $val ) {

				// These have their own sections outside the main class scope
				if ( 'typography' == $id ) {
					continue;
				}

				// Continue if condition isn't met
				if ( isset( $val['condition'] ) && ! $val['condition'] ) {
					continue;
				}

				// Section file location
				$file = $this->customizer_dir . 'settings/'. $id .'.php';

				// Include file and update sections var
				if ( file_exists( $file ) ) {
					require_once( $file );
				}

			}

			// Apply filters
			$this->sections = apply_filters( 'wpex_customizer_sections', $this->sections );

		}
 
		/**
		 * Registers new controls
		 * Removes default customizer sections and settings
		 * Adds new customizer sections, settings & controls
		 *
		 * @since 3.0.0
		 */
		public function add_customizer_panels_sections( $wp_customize ) {

			// Get panels
			$all_panels = $this->panels;

			// Get enabled panels
			$enabled_panels = $this->enabled_panels;

			// If there are panels enabled let's add them and get their controls
			if ( $enabled_panels ) {

				// Add Panels
				$priority = 140;
				foreach( $all_panels as $id => $val ) {
					$priority++;

					// Disabled so do nothing
					if ( ! isset( $enabled_panels[$id] ) ) {
						continue;
					}

					// No panel needed for these
					if ( 'styling' == $id || 'typography' == $id ) {
						continue;
					}

					// Continue if condition isn't met
					if ( isset( $val['condition'] ) && ! $val['condition'] ) {
						continue;
					}

					// Get title and check if panel or section
					$title      = isset( $val['title'] ) ? $val['title'] : $val;
					$is_section = isset( $val['is_section'] ) ? true : false;

					// Add section
					if ( $is_section ) {

						$wp_customize->add_section( 'wpex_'. $id, array(
							'priority' => $priority,
							'title'    => $title,
						) );

					}

					// Add Panel
					else {

						$wp_customize->add_panel( 'wpex_'. $id, array(
							'priority' => $priority,
							'title'    => $title,
						) );

					}

				}

				// Create the new customizer sections
				if ( $this->sections ) {
					$this->create_sections( $wp_customize, $this->sections );
				}

				//print_r( $wp_customize ); // For testing

			} // $enabled_panels check

		} // END customize_register()

		/**
		 * Creates the Sections and controls for the customizer
		 *
		 * @since 3.0.0
		 */
		public function create_sections( $wp_customize ) {

			// Loop through sections and add create the customizer sections, settings & controls
			foreach ( $this->sections as $section_id => $section ) {

				// Get section settings
				$settings = ! empty( $section['settings'] ) ? $section['settings'] : null;

				// Return if no settings are found
				if ( ! $settings ) {
					return;
				}

				// Get section description
				$description = isset( $section['desc'] ) ? $section['desc'] : '';

				// Add customizer section
				if ( isset( $section['panel'] ) ) {
					$wp_customize->add_section( $section_id, array(
						'title'       => $section['title'],
						'panel'       => $section['panel'],
						'description' => $description,
					) );
				}

				// Add settings+controls
				foreach ( $settings as $setting ) {

					// Get vals
					$id              = $setting['id']; // Required no need to check
					$transport       = isset( $setting['transport'] ) ? $setting['transport'] : 'refresh';
					$default         = isset( $setting['default'] ) ? $setting['default'] : '';
					$control_type    = isset( $setting['control']['type'] ) ? $setting['control']['type'] : 'text';

					// Add values to control
					$setting['control']['settings'] = $setting['id'];
					$setting['control']['section'] = $section_id;

					// Add description
					if ( isset( $setting['control']['desc'] ) ) {
						$setting['control']['description'] = $setting['control']['desc'];
					}

					// Control object
					if ( isset( $setting['control']['object'] ) ) {
						$control_object = $setting['control']['object'];
					} elseif ( 'image' == $control_type ) {
						$control_object = 'WP_Customize_Image_Control';
					} elseif ( 'color' == $control_type ) {
						$control_object = 'WP_Customize_Color_Control';
					} elseif ( 'wpex-heading' == $control_type ) {
						$control_object = 'WPEX_Customizer_Heading_Control';
					} elseif ( 'wpex-sortable' == $control_type ) {
						$control_object = 'WPEX_Customize_Control_Sorter';
					} elseif ( 'wpex-dropdown-pages' == $control_type ) {
						$control_object = 'WPEX_Customizer_Dropdown_Pages';
					} else {
						$control_object = 'WP_Customize_Control';
					}

					// If $id defined add setting and control
					if ( $id ) {

						// Add setting
						$wp_customize->add_setting( $id, array(
							'type'              => 'theme_mod',
							'transport'         => $transport,
							'default'           => $default,
							'sanitize_callback' => false,
						) );

						// Add control
						$wp_customize->add_control( new $control_object (
							$wp_customize,
							$id, $setting['control'] )
						);

					}
				}
			}

		} // END create_sections()


		/**
		 * Generates inline CSS for styling options
		 *
		 * @since 1.0.0
		 */
		public function loop_through_inline_css( $return = 'css' ) {

			// Define vars
			$add_css = '';
			$elements_to_alter = '';

			// Get customizer settings
			$settings = wp_list_pluck( $this->sections, 'settings' );

			// Return if there aren't any settings
			if ( empty( $settings ) ) {
				return;
			}

			// Loop through settings and find inline_css
			foreach ( $settings as $settings_array ) {

				foreach ( $settings_array as $setting ) {

					// If setting shouldn't output css continue on to the next
					if ( ! isset( $setting['inline_css'] ) ) {
						continue;
					}

					// Get setting ID and if empty continue onto the next setting
					$id = isset( $setting['id'] ) ? $setting['id'] : '';

					if ( ! $id ) {
						continue;
					}

					// Check if there is a default value
					$default = isset ( $setting['default'] ) ? $setting['default'] : false;

					// Get theme mod value and if empty continue onto the next setting
					$theme_mod = get_theme_mod( $id, $default );

					// Return if theme mod is empty
					if ( ! $theme_mod ) {
						continue;
					}

					// Extract vars
					$inline_css = $setting['inline_css'];

					// Make sure vars are defined
					$sanitize    = isset( $inline_css['sanitize'] ) ? $inline_css['sanitize'] : '';
					$target      = isset( $inline_css['target'] ) ? $inline_css['target'] : '';
					$alter       = isset( $inline_css['alter'] ) ? $inline_css['alter'] : '';
					$important   = isset( $inline_css['important'] ) ? '!important' : false;

					// Target and alter vars are required, if they are empty continue onto the next setting
					if ( ! $target && ! $alter ) {
						continue;
					}

					// Sanitize data
					if ( $sanitize ) {
						$theme_mod = wpex_sanitize_data( $theme_mod, $sanitize );
					} else {
						$theme_mod = $theme_mod;
					}

					// Save inline_css
					if ( $theme_mod ) {

						// Set to array if not
						$target = is_array( $target ) ? $target : array( $target );

						// Loop through items
						foreach( $target as $element ) {

							// Add to elements list if not already
							if ( ! isset( $elements_to_alter[$element] ) ) {
								$elements_to_alter[$element] = array( 'css' => '' );
							}

							// Add css to element
							if ( is_array( $alter ) ) {
								foreach( $alter as $alter_val ) {
									$elements_to_alter[$element]['css'] .= $alter_val .':'. $theme_mod . $important .';';
								}
							} else {
								$elements_to_alter[$element]['css'] .= $alter .':'. $theme_mod . $important .';';
							}

						}

					} // End theme_mod check

				} // End settings_array

			} // End settings loop

			// No elements to alter so return null
			if ( ! $elements_to_alter ) {
				return null;
			}

			// Loop through elements
			foreach( $elements_to_alter as $element => $array ) {
				if ( isset( $array['css'] ) ) {
					$add_css .= $element.'{'.$array['css'].'}';
				}
			}

			// Return custom CSS
			if ( $add_css ) {
				return $add_css;
			}

		}

		/**
		 * Returns correct CSS to output to wp_head
		 *
		 * Inline CSS is cached to GREALY speed things up!
		 * Cached option is cleared on theme switch, on customizer save,
		 * and on theme options reset.
		 *
		 * @since 1.0.0
		 */
		public function add_inline_css( $output ) {

			// Generate for customizer always
			if ( is_customize_preview() ) {
				$inline_css = $this->loop_through_inline_css();
			}

			// Check cache or regenerate for front-end
			else {

				// Check cache
				$inline_css = $this->inline_css_cache;

				// Generate CSS
				if ( ! $inline_css ) {

					// Generate CSS
					$inline_css = $this->loop_through_inline_css();

					// Make sure cache isn't empty so we don't keep looping through settings
					if ( ! $inline_css ) {
						$inline_css = 'empty';
					}

					// Cache CSS
					add_option( 'wpex_customizer_inline_css_cache', $inline_css );

				}

			}

			// Return CSS
			if ( $inline_css ) {
				$output .= '/*CUSTOMIZER STYLING*/'. $inline_css;
			}

			// Return css output
			return $output;

		}

		/**
		 * Resets the inline CSS cache
		 *
		 * @since 1.0.0
		 */
		public static function reset_inline_css_cache() {
			delete_option( 'wpex_customizer_inline_css_cache' );
		}

	}
}

// Start up class and set to global var
$wpex_customizer = new WPEX_Customizer();