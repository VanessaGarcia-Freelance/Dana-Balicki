<?php
/**
 * Custom Login Page Design
 *
 * @package Total WordPress theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Custom_Login' ) ) {
	class WPEX_Custom_Login {
		private $options = array();

		/**
		 * Start things up
		 *
		 * @since 1.6.0
		 */
		public function __construct() {

			// Get options
			$this->options = wpex_get_mod( 'login_page_design', array(
				'enabled'                 => true,
				'logo'                    => '',
				'logo_height'             => '',
				'background_color'        => '',
				'background_img'          => '',
				'background_style'        => '',
				'form_background_color'   => '',
				'form_background_opacity' => '',
				'form_text_color'         => '',
				'form_top'                => '',
				'form_border_radius'      => '',
			) );

			// Add actions
			add_action( 'admin_menu', array( $this, 'add_page' ) );
			add_action( 'admin_init', array( $this,'register_settings' ) );
			add_action( 'admin_enqueue_scripts',array( $this,'scripts' ) );
			add_action( 'admin_print_styles-'. WPEX_ADMIN_PANEL_HOOK_PREFIX . '-admin-login', array( $this,'admin_styles' ), 40 );
			add_action( 'login_head', array( $this, 'output_css' ) );
			add_action( 'login_headerurl', array( $this, 'logo_link' ) );

		}

		/**
		 * Add sub menu page for the custom CSS input
		 *
		 * @since 1.6.0
		 */
		public function add_page() {
			add_submenu_page(
				WPEX_THEME_PANEL_SLUG,
				__( 'Login Page', 'wpex' ),
				__( 'Login Page', 'wpex' ),
				'administrator',
				WPEX_THEME_PANEL_SLUG .'-admin-login',
				array( $this, 'create_admin_page' )
			);
		}

		/**
		 * Load scripts
		 *
		 * @since 1.6.0
		 */
		public function scripts( $hook ) {

			if ( WPEX_ADMIN_PANEL_HOOK_PREFIX . '-admin-login' != $hook ) {
				return;
			}

			// Media Uploader
			wp_enqueue_media();

			wp_enqueue_script(
				'wpex-media-uploader-field',
				WPEX_FRAMEWORK_DIR_URI .'addons/assets/admin-fields/media-uploader.js',
				array( 'media-upload' ),
				false,
				true
			);

			// Color Picker
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'wpex-color-picker-field', WPEX_FRAMEWORK_DIR_URI .'addons/assets/admin-fields/color-picker.js', false, false, true );

			// CSS
			wp_enqueue_style( 'wpex-admin', WPEX_FRAMEWORK_DIR_URI .'addons/assets/admin-fields/admin.css' );

		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * @since 1.6.0
		 */
		public function register_settings() {
			register_setting( 'wpex_custom_login', 'login_page_design', array( $this, 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.6.0
		 */
		public static function sanitize( $options ) {

			// Set theme mod
			if ( $options ) {
				set_theme_mod( 'login_page_design', $options );
			}

			// Clear options and return
			$options = '';
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.6.0
		 */
		public function create_admin_page() { ?>

			<div class="wrap">

				<h1><?php _e( 'Custom Login Page Design', 'wpex' ); ?></h1>

				<h2 class="nav-tab-wrapper wpex-custom-login-admin-tabs" style="margin-top:20px;">
					<a href="#main" class="nav-tab nav-tab-active"><?php _e( 'Main', 'wpex' ); ?></a>
					<a href="#background" class="nav-tab"><?php _e( 'Background', 'wpex' ); ?></a>
					<a href="#form" class="nav-tab"><?php _e( 'Form', 'wpex' ); ?></a>
					<a href="#button" class="nav-tab"><?php _e( 'Button', 'wpex' ); ?></a>
				</h2>

				<?php $theme_mod = $this->options; ?>

				<form method="post" action="options.php">

					<?php settings_fields( 'wpex_custom_login' ); ?>

					<table class="form-table wpex-custom-admin-login-table">

						<tr valign="top" class="wpex-custom-admin-screen-main-section">
							<th scope="row"><?php _e( 'Enable', 'wpex' ); ?></th>
							<td>
								<?php $enabled = isset ( $theme_mod['enabled'] ) ? $theme_mod['enabled'] : ''; ?>
								<input type="checkbox" name="login_page_design[enabled]" <?php checked( $enabled, 'on' ); ?>> <?php _e( 'Enable the custom Login Screen.', 'wpex' ); ?>
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-main-section">
							<th scope="row"><?php _e( 'Logo', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['logo'] ) ? $theme_mod['logo'] : ''; ?>
								<input type="text" name="login_page_design[logo]" value="<?php echo $option; ?>">
								<input class="wpex-media-upload-button button-secondary" type="button" value="<?php _e( 'Upload', 'wpex' ); ?>" />
								<?php $preview = $this->return_image ( $option ); ?>
								<div class="wpex-media-live-preview">
									<?php if ( $preview ) { ?>
										<img src="<?php echo $preview; ?>" alt="<?php _e( 'Preview Image', 'wpex' ); ?>" />
									<?php } ?>
								</div>
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-main-section">
							<th scope="row"><?php _e( 'Logo Height', 'wpex' ); ?></th>
							<td>
								<?php $option = ! empty( $theme_mod['logo_height'] ) ? intval( $theme_mod['logo_height'] ) : ''; ?>
								<input type="number" name="login_page_design[logo_height]" value="<?php echo $option; ?>">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-main-section">
							<th scope="row"><?php _e( 'Logo URL', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['logo_url'] ) ? $theme_mod['logo_url'] : ''; ?>
								<input type="text" name="login_page_design[logo_url]" value="<?php echo $option; ?>">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-background-section">
							<th scope="row"><?php _e( 'Background Color', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['background_color'] ) ? $theme_mod['background_color'] : ''; ?>
								<input id="background_color" type="text" name="login_page_design[background_color]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-background-section">
							<th scope="row"><?php _e( 'Background Image', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['background_img'] ) ? $theme_mod['background_img'] : ''; ?>
								<div class="uploader">
									<input type="text" name="login_page_design[background_img]" value="<?php echo $option; ?>">
									<input class="wpex-media-upload-button button-secondary" type="button" value="<?php _e( 'Upload', 'wpex' ); ?>" />
									<?php $preview = $this->return_image ( $option ); ?>
									<div class="wpex-media-live-preview">
										<?php if ( $preview ) { ?>
											<img src="<?php echo $preview; ?>" alt="<?php _e( 'Preview Image', 'wpex' ); ?>" />
										<?php } ?>
									</div>
								</div>
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-background-section">
							<th scope="row"><?php _e( 'Background Image Style', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['background_style'] ) ? $theme_mod['background_style'] : ''; ?>
								<select name="login_page_design[background_style]">
									<?php
									$bg_styles = array(
										'stretched' => __( 'Stretched','wpex' ),
										'repeat'    => __( 'Repeat','wpex' ),
										'fixed'     => __( 'Center Fixed','wpex' )
									);
									foreach ( $bg_styles as $key => $val ) { ?>
										<option value="<?php echo $key; ?>" <?php selected( $option, $key, true ); ?>><?php echo $val; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-form-section">
							<th scope="row"><?php _e( 'Form Background Color', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['form_background_color'] ) ? $theme_mod['form_background_color'] : ''; ?>
								<input id="form_background_color" type="text" name="login_page_design[form_background_color]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-form-section">
							<th scope="row"><?php _e( 'Form Background Opacity', 'wpex' ); ?></th>
							<td>
								<?php $option = ! empty( $theme_mod['form_background_opacity'] ) ? floatval( $theme_mod['form_background_opacity'] ) : ''; ?>
								<input type="number" name="login_page_design[form_background_opacity]" value="<?php echo $option; ?>" min="0" max="1" step="0.1">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-form-section">
							<th scope="row"><?php _e( 'Form Text Color', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['form_text_color'] ) ? $theme_mod['form_text_color'] : ''; ?>
								<input id="form_text_color" type="text" name="login_page_design[form_text_color]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-form-section">
							<th scope="row"><?php _e( 'Form Input Background', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['form_input_bg'] ) ? $theme_mod['form_input_bg'] : ''; ?>
								<input id="form_input_bg" type="text" name="login_page_design[form_input_bg]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-form-section">
							<th scope="row"><?php _e( 'Form Input Color', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['form_input_color'] ) ? $theme_mod['form_input_color'] : ''; ?>
								<input id="form_input_color" type="text" name="login_page_design[form_input_color]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-form-section">
							<th scope="row"><?php _e( 'Form Top Margin', 'wpex' ); ?></th>
							<td>
								<?php $option = ! empty( $theme_mod['form_top'] ) ? intval( $theme_mod['form_top'] ) : '150'; ?>
								<input type="number" name="login_page_design[form_top]" value="<?php echo $option; ?>">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-form-section">
							<th scope="row"><?php _e( 'Form Border Radius', 'wpex' ); ?></th>
							<td>
								<?php $option = ! empty( $theme_mod['form_border_radius'] ) ? intval( $theme_mod['form_border_radius'] ) : ''; ?>
								<input type="text" name="login_page_design[form_border_radius]" value="<?php echo $option; ?>">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-button-section">
							<th scope="row"><?php _e( 'Form Button Background', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['form_button_bg'] ) ? $theme_mod['form_button_bg'] : ''; ?>
								<input id="form_button_bg" type="text" name="login_page_design[form_button_bg]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-button-section">
							<th scope="row"><?php _e( 'Form Button Color', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['form_button_color'] ) ? $theme_mod['form_button_color'] : ''; ?>
								<input id="form_button_color" type="text" name="login_page_design[form_button_color]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

						<tr valign="top" class="wpex-custom-admin-screen-button-section">
							<th scope="row"><?php _e( 'Form Button Background: Hover', 'wpex' ); ?></th>
							<td>
								<?php $option = isset( $theme_mod['form_button_bg_hover'] ) ? $theme_mod['form_button_bg_hover'] : ''; ?>
								<input id="form_button_bg_hover" type="text" name="login_page_design[form_button_bg_hover]" value="<?php echo $option; ?>" class="wpex-color-field">
							</td>
						</tr>

					</table>

					<?php submit_button(); ?>

				</form>

				<script>
					( function( $ ) {
						"use strict";
						$( document ).ready( function() {
							$( '.wpex-custom-login-admin-tabs a' ).click( function() {
								$( '.wpex-custom-login-admin-tabs a' ).removeClass( 'nav-tab-active' );
								$(this).addClass( 'nav-tab-active' );
								var $hash = $( this ).attr( 'href' ).substring(1);
								$( '.wpex-custom-admin-login-table tr' ).hide();
								$( 'tr.wpex-custom-admin-screen-'+ $hash +'-section' ).show();
								return false;
							} );
						} );
					} ) ( jQuery );
				</script>

			</div><!-- .wrap -->
		<?php }

		/**
		 * RGBA to HEX conversions
		 *
		 * @since 1.6.0
		 */
		private static function hex2rgba( $color, $opacity = false ) {

			// Define default rgba
			$default = 'rgb(0,0,0)';

			//Return default if no color provided
			if( empty( $color ) ) {
				return $default;
			}

			//Sanitize $color if "#" is provided 
			if ( $color[0] == '#' ) {
				$color = substr( $color, 1 );
			}

			//Check if color has 6 or 3 characters and get values
			if ( strlen( $color ) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
				return $default;
			}

			//Convert hexadec to rgb
			$rgb =  array_map( 'hexdec', $hex );

			//Check if opacity is set(rgba or rgb)
			if( $opacity ) {
				if( abs ( $opacity ) > 1 )
					$opacity = 1.0;
				$output = 'rgba('.implode( ",", $rgb ).','.$opacity.')';
			} else {
				$output = 'rgb('.implode( ",", $rgb ).')';
			}

			//Return rgb(a) color string
			return $output;
		}

		/**
		 * Returns correct image value
		 *
		 * @since 1.6.0
		 */
		private static function return_image( $val ) {
			if ( is_numeric( $val ) ) {
				$val = wp_get_attachment_image_src( $val, 'full' );
				$val = $val[0];
			} elseif( is_numeric( $val ) ) {
				$val = absint( $val );
			} else {
				$val = esc_url( $val );
			}
			return $val;
		}

		/**
		 * Prints styles for the admin page
		 *
		 * @since 3.0.0
		 */
		public function admin_styles() { ?>

			<style type="text/css">
				.wpex-custom-login-admin-tabs { min-height: 35px; }
				.wpex-custom-login-admin-tabs a.nav-tab { outline: 0; box-shadow: none; -moz-box-shadow: none; -webkit-box-shadow: none; }
				.wpex-custom-admin-login-table tr { display: none; }
				.wpex-custom-admin-login-table tr.wpex-custom-admin-screen-main-section { display: block; }
			</style>

		<?php }

		/**
		 * Outputs the CSS for the custom login page
		 *
		 * @since 1.6.0
		 */
		public function output_css() {

			// Get options
			$options = $this->options;

			// Do nothing if disabled
			if ( empty( $options['enabled'] ) ) {
				return;
			}

			// Sanitize data
			$logo                    = $this->parseOption( 'logo' );
			$logo_height             = $this->parseOption( 'logo_height', '84px' );
			$logo_height             = intval( $logo_height ) .'px';
			$background_img          = $this->parseOption( 'background_img' );
			$background_style        = $this->parseOption( 'background_style' );
			$background_color        = $this->parseOption( 'background_color' );
			$form_background_color   = $this->parseOption( 'form_background_color' );
			$form_background_opacity = $this->parseOption( 'form_background_opacity' );
			$form_text_color         = $this->parseOption( 'form_text_color' );
			$form_top                = $this->parseOption( 'form_top', '150px' );
			$form_input_bg           = $this->parseOption( 'form_input_bg' );
			$form_input_color        = $this->parseOption( 'form_input_color' );
			$form_border_radius      = $this->parseOption( 'form_border_radius' );
			$form_button_bg          = $this->parseOption( 'form_button_bg' );
			$form_button_bg_hover    = $this->parseOption( 'form_button_bg_hover' );
			$form_button_color       = $this->parseOption( 'form_button_color' );

			// Convert image ID's to urls
			if ( is_numeric( $logo ) ) {
				$logo = wp_get_attachment_image_src( $logo, 'full' );
				$logo = $logo[0];
			}
			if ( is_numeric( $background_img ) ) {
				$background_img = wp_get_attachment_image_src( $background_img, 'full' );
				$background_img = $background_img[0];
			}

			// Output Styles
			$output = '<style type="text/css">';

				// Logo
				if ( $logo ) {
					$output .='body.login div#login h1 a {';
						$output .='background: url("'. $logo .'") center center no-repeat;';
						$output .='height: '. intval( $logo_height ) .'px;';
						$output .='width: 100%;';
						$output .='display: block;';
						$output .='margin: 0 auto 30px;';
					$output .='}';
				}

				// Background image
				if ( $background_img ) {
					if ( 'stretched' == $background_style ) {
						$output .= 'body.login { background: url('. $background_img .') no-repeat center center fixed; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; }';
					} elseif ( 'repeat' == $background_style ) {
						$output .= 'body.login { background: url('. $background_img .') repeat; }';
					} elseif ( 'fixed' == $background_style ) {
						$output .= 'body.login { background: url('. $background_img .') center top fixed no-repeat; }';
					}
				}

				// Background color
				if ( $background_color ) {
					$output .='body.login { background-color: '. $background_color .'; }';
				}

				// Form Background Color
				if ( $form_background_color ) {
					$form_bg_color_rgba = self::hex2rgba( $form_background_color, $form_background_opacity );
					$output .='.login form { background: none; -webkit-box-shadow: none; box-shadow: none; padding: 0 0 20px; } #backtoblog { display: none; } .login #nav { text-align: center; }';
					$output .='body.login div#login { background: '. $form_background_color .'; background: '. $form_bg_color_rgba .';height:auto;left:50%;margin: 0 0 0 -200px;padding:40px;position:absolute;width:320px; max-width:90%; border-radius: 5px; }';
				} else {
					$output .= 'body.login div#login { opacity:'. $form_background_opacity .'; }';
				}

				// Form top
				if ( $form_top ) {
					$output .= 'body.login div#login {top:'. intval( $form_top ) .'px;}';
				}

				// Form top
				if ( $form_border_radius ) {
					if ( $form_background_color ) {
						$output .= 'body.login div#login { border-radius:'. intval( $form_border_radius ) .'px; }';
					} else {
						$output .= 'body.login div#login #loginform { border-radius:'. intval( $form_border_radius ) .'px; }';
					}
				}

				// Form input
				if ( $form_input_bg ) {
					$output .='body.login div#login input.input { background: '. $form_input_bg .'; border: 0; box-shadow: none; }';
				}
				if ( $form_input_color ) {
					$output .='body.login form .input { color: '. $form_input_color .'; }';
				}

				// Text Color
				if ( $form_text_color ) {
					$output .='.login label, .login #nav a, .login #backtoblog a, .login #nav { color: '. $form_text_color .'; }';
				}

				// Button background
				if ( $form_button_bg ) {
					$output .='body.login div#login .button { background: '. $form_button_bg .'; border:0; outline: 0; box-shadow: none !important; }';
				}

				// Button background
				if ( $form_button_color ) {
					$output .='body.login div#login .button { color: '. $form_button_color .'; }';
				}

				// Button background Hover
				if ( $form_button_bg_hover ) {
					$output .='body.login div#login .button:hover { background: '. $form_button_bg_hover .'; border:0; outline: 0; box-shadow: none !important; }';
				}

			$output .='</style>';

			echo $output;

		}

		/**
		 * Parses data
		 *
		 * @since 1.6.0
		 */
		private function parseOption( $option_id, $default = '' ) {
			$options = $this->options;
			return ! empty( $options[$option_id] ) ? $options[$option_id] : $default;
		}

		/**
		 * Custom login page logo URL
		 *
		 * @since 1.6.0
		 */
		public function logo_link( $url ) {
			$options  = $this->options;
			$logo_url = isset( $options['logo_url']) ? $options['logo_url'] : '';
			if ( $logo_url ) {
				$url = esc_url( $logo_url );
			}
			$url = apply_filters( 'wpex_login_logo_link', $url );
			return $url;
		}

	}
}
new WPEX_Custom_Login();