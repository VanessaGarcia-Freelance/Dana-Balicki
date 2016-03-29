<?php
/**
 * Adds custom metaboxes to the WordPress categories
 * Developed & Designed exclusively for the Total WordPress theme
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The Metabox class
class WPEX_Post_Metaboxes {
	private $post_types;

	/**
	 * Register this class with the WordPress API
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Post types to add the metabox to
		$this->post_types = apply_filters( 'wpex_main_metaboxes_post_types', array(
			'post' => 'post',
			'page' => 'page',
			'portfolio' => 'portfolio',
			'staff' => 'staff',
			'testimonials' => 'testimonials',
			'page' => 'page',
			'product' => 'product',
		) );

		// Add metabox to corresponding post types
		foreach( $this->post_types as $key => $val ) {
			add_action( 'add_meta_boxes_'. $val, array( $this, 'post_meta' ), 11 );
		}

		// Save meta
		add_action( 'save_post', array( $this, 'save_meta_data' ) );

		// Load scripts for the metabox
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Load custom css for metabox
		add_action( 'admin_print_styles-post.php', array( $this, 'metaboxes_css' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'metaboxes_css' ) );

		// Load custom js for metabox
		add_action( 'admin_footer-post.php', array( $this, 'metaboxes_js' ) );
		add_action( 'admin_footer-post-new.php', array( $this, 'metaboxes_js' ) );

	}

	/**
	 * The function responsible for creating the actual meta box.
	 *
	 * @since 1.0.0
	 */
	public function post_meta( $post ) {
		$obj = get_post_type_object( $post->post_type );
		add_meta_box(
			'wpex-metabox',
			$obj->labels->singular_name . ' '. __( 'Settings', 'wpex' ),
			array( $this, 'display_meta_box' ),
			$post->post_type,
			'normal',
			'high'
		);
	}

	/**
	 * Enqueue scripts and styles needed for the metaboxes
	 *
	 * @since 1.0.0
	 */
	public static function admin_enqueue_scripts() {
		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	/**
	 * Renders the content of the meta box.
	 *
	 * @since 1.0.0
	 */
	public function display_meta_box( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wpex_metabox', 'wpex_metabox_nonce' );

		// Get current post data
		$post_id   = $post->ID;
		$post_type = get_post_type();

		// Get tabs
		$tabs = $this->tabs_array();

		// Make sure tabs aren't empty
		if ( empty( $tabs ) ) {
			echo '<p>Hey your settings are empty, something is going on please contact your webmaster</p>';
			return;
		}

		// Store tabs that should display on this specific page in an array for use later
		$active_tabs = array();
		foreach ( $tabs as $tab ) {
			$tab_post_type = isset( $tab['post_type'] ) ? $tab['post_type'] : '';
			if ( ! $tab_post_type ) {
				$display_tab = true;
			} elseif ( in_array( $post_type, $tab_post_type ) ) {
				$display_tab = true;
			} else {
				$display_tab = false;
			}
			if ( $display_tab ) {
				$active_tabs[] = $tab;
			}
		} ?>

		<ul class="wp-tab-bar">
			<?php
			// Output tab links
			$wpex_count = '';
			foreach ( $active_tabs as $tab ) {
				$wpex_count++;
				$li_class = ( '1' == $wpex_count ) ? ' class="wp-tab-active"' : '';
				// Define tab title
				$tab_title = $tab['title'] ? $tab['title'] : __( 'Other', 'wpex' ); ?>
				<li<?php echo $li_class; ?>>
					<a href="javascript:;" data-tab="#wpex-mb-tab-<?php echo $wpex_count; ?>"><?php echo $tab_title; ?></a>
				</li>
			<?php } ?>
		</ul><!-- .wpex-mb-tabnav -->

		<?php
		// Output tab sections
		$wpex_count = '';
		foreach ( $active_tabs as $tab ) {
			$wpex_count++; ?>
			<div id="wpex-mb-tab-<?php echo $wpex_count; ?>" class="wp-tab-panel clr">
				<table class="form-table">
					<?php
					// Loop through sections and store meta output
					foreach ( $tab['settings'] as $setting ) {

						// Vars
						$meta_id     = $setting['id'];
						$title       = $setting['title'];
						$hidden      = isset ( $setting['hidden'] ) ? $setting['hidden'] : false;
						$type        = isset ( $setting['type'] ) ? $setting['type'] : 'text';
						$default     = isset ( $setting['default'] ) ? $setting['default'] : '';
						$description = isset ( $setting['description'] ) ? $setting['description'] : '';
						$meta_value  = get_post_meta( $post_id, $meta_id, true );
						$meta_value  = $meta_value ? $meta_value : $default; ?>

						<tr<?php if ( $hidden ) echo ' style="display:none;"'; ?> id="<?php echo $meta_id; ?>_tr">
							<th>
								<label for="wpex_main_layout"><strong><?php echo $title; ?></strong></label>
								<?php
								// Display field description
								if ( $description ) { ?>
									<p class="wpex-mb-description"><?php echo $description; ?></p>
								<?php } ?>
							</th>

							<?php
							// Text Field
							if ( 'text' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo $meta_value; ?>"></td>

							<?php }

							// Number Field
							if ( 'number' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="number" value="<?php echo $meta_value; ?>"></td>

							<?php }

							// HTML Text
							if ( 'text_html' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo esc_html( $meta_value ); ?>"></td>

							<?php }

							// Link field
							elseif ( 'link' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo esc_url( $meta_value ); ?>"></td>

							<?php }

							// Textarea Field
							elseif ( 'textarea' == $type ) {
								$rows = isset ( $setting['rows'] ) ? $setting['rows'] : '4';?>

								<td>
									<textarea rows="<?php echo $rows; ?>" cols="1" name="<?php echo $meta_id; ?>" type="text" class="wpex-mb-textarea"><?php echo $meta_value; ?></textarea>
								</td>

							<?php }

							// Code Field
							elseif ( 'code' == $type ) { ?>

								<td>
									<textarea rows="1" cols="1" name="<?php echo $meta_id; ?>" type="text" class="wpex-mb-textarea-code"><?php echo $meta_value; ?></textarea>
								</td>

							<?php }

							// Checkbox
							elseif ( 'checkbox' == $type ) {

								$meta_value = ( 'on' == $meta_value ) ? false : true; ?>
								<td><input name="<?php echo $meta_id; ?>" type="checkbox" <?php checked( $meta_value, true, true ); ?>></td>

							<?php }

							// Select
							elseif ( 'select' == $type ) {

								$options = isset ( $setting['options'] ) ? $setting['options'] : '';
								if ( ! empty( $options ) ) { ?>
									<td><select id="<?php echo $meta_id; ?>" name="<?php echo $meta_id; ?>">
									<?php foreach ( $options as $option_value => $option_name ) { ?>
										<option value="<?php echo $option_value; ?>" <?php selected( $meta_value, $option_value, true ); ?>><?php echo $option_name; ?></option>
									<?php } ?>
									</select></td>
								<?php }

							}

							// Select
							elseif ( 'color' == $type ) { ?>

								<td><input name="<?php echo $meta_id; ?>" type="text" value="<?php echo $meta_value; ?>" class="wpex-mb-color-field"></td>

							<?php }

							// Media
							elseif ( 'media' == $type ) {

								// Validate data if array - old Redux cleanup
								if ( is_array( $meta_value ) ) {
									if ( ! empty( $meta_value['url'] ) ) {
										$meta_value = $meta_value['url'];
									} else {
										$meta_value = '';
									}
								} ?>
								<td>
									<div class="uploader">
									<input type="text" name="<?php echo $meta_id; ?>" value="<?php echo $meta_value; ?>">
									<input class="wpex-mb-uploader button-secondary" name="<?php echo $meta_id; ?>" type="button" value="<?php _e( 'Upload', 'wpex' ); ?>" />
									<?php /* if ( $meta_value ) {
											if ( is_numeric( $meta_value ) ) {
												$meta_value = wp_get_attachment_image_src( $meta_value, 'full' );
												$meta_value = $meta_value[0];
											} ?>
										<div class="wpex-mb-thumb" style="padding-top:10px;"><img src="<?php echo $meta_value; ?>" height="40" width="" style="height:40px;width:auto;max-width:100%;" /></div>
									<?php } */ ?>
									</div>
								</td>

							<?php }

							// Editor
							elseif ( 'editor' == $type ) {
								$teeny= isset( $setting['teeny'] ) ? $setting['teeny'] : false;
								$rows = isset( $setting['rows'] ) ? $setting['rows'] : '10';
								$media_buttons= isset( $setting['media_buttons'] ) ? $setting['media_buttons'] : true; ?>
								<td><?php wp_editor( $meta_value, $meta_id, array(
									'textarea_name' => $meta_id,
									'teeny' => $teeny,
									'textarea_rows' => $rows,
									'media_buttons' => $media_buttons,
								) ); ?></td>
							<?php } ?>
						</tr>

					<?php } ?>
				</table>
			</div>
		<?php } ?>

		<div class="wpex-mb-reset">
			<a class="button button-secondary wpex-reset-btn"><?php _e( 'Reset Settings', 'wpex' ); ?></a>
			<div class="wpex-reset-checkbox"><input type="checkbox" name="wpex_metabox_reset"> <?php _e( 'Are you sure? Check this box, then update your post to reset all settings.', 'wpex' ); ?></div>
		</div>

		<div class="clear"></div>

	<?php }

	/**
	 * Save metabox data
	 *
	 * @since 1.0.0
	 */
	public function save_meta_data( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpex_metabox_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['wpex_metabox_nonce'], 'wpex_metabox' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. Now we can loop through fields */

		// Check reset field
		$reset = isset( $_POST['wpex_metabox_reset'] ) ? $_POST['wpex_metabox_reset'] : '';

		// Set settings array
		$tabs = $this->tabs_array();
		$settings = array();
		foreach( $tabs as $tab ) {
			foreach ( $tab['settings'] as $setting ) {
				$settings[] = $setting;
			}
		}

		// Loop through settings and validate
		foreach ( $settings as $setting ) {

			// Vars
			$value = '';
			$id    = $setting['id'];
			$type  = isset ( $setting['type'] ) ? $setting['type'] : 'text';

			// Make sure field exists and if so validate the data
			if ( isset( $_POST[$id] ) ) {

				// Validate text
				if ( 'text' == $type ) {
					$value = sanitize_text_field( $_POST[$id] );
				}

				// Validate textarea
				if ( 'textarea' == $type ) {
					$value = esc_html( $_POST[$id] );
				}

				// Links
				elseif ( 'link' == $type ) {
					$value = esc_url( $_POST[$id] );
				}

				// Validate select
				elseif ( 'select' == $type ) {
					if ( 'default' == $_POST[$id] ) {
						$value = '';
					} else {
						$value = $_POST[$id];
					}
				}

				// Validate media
				if ( 'media' == $type ) {

					// Sanitize
					$value = $_POST[$id];

					// Move old wpex_post_self_hosted_shortcode_redux to wpex_post_self_hosted_media
					if ( 'wpex_post_self_hosted_media' == $id && empty( $_POST[$id] ) && $old = get_post_meta( $post_id, 'wpex_post_self_hosted_shortcode_redux', true ) ) {
						$value = $old;
						delete_post_meta( $post_id, 'wpex_post_self_hosted_shortcode_redux' );
					}

				}

				// All else
				else {
					$value = $_POST[$id];
				}

				// Update meta if value exists
				if ( $value && 'on' != $reset ) {
					update_post_meta( $post_id, $id, $value );
				}

				// Otherwise cleanup stuff
				else {
					delete_post_meta( $post_id, $id );
				}
			}

		}

	}

	/**
	 * Helpers
	 *
	 * @since 1.0.0
	 */
	public static function helpers( $return = NULl ) {


		// Return array of WP menus
		if ( 'menus' == $return ) {
			$menus = array( __( 'Default', 'wpex' ) );
			$get_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
			foreach ( $get_menus as $menu) {
				$menus[$menu->term_id] = $menu->name;
			}
			return $menus;
		}

		// Title styles
		elseif ( 'title_styles' == $return ) {
			$styles = array(
				'' => __( 'Default', 'wpex' ),
				'centered' => __( 'Centered', 'wpex' ),
				'centered-minimal' => __( 'Centered Minimal', 'wpex' ),
				'background-image' => __( 'Background Image', 'wpex' ),
				'solid-color' => __( 'Solid Color & White Text', 'wpex' ),
			);
			$styles = apply_filters( 'wpex_title_styles', $styles );
			return $styles;
		}

		// Widgets
		elseif ( 'widget_areas' == $return ) {
			global $wp_registered_sidebars;
			$widgets_areas = array( __( 'Default', 'wpex' ) );
			$get_widget_areas = $wp_registered_sidebars;
			if ( ! empty( $get_widget_areas ) ) {
				foreach ( $get_widget_areas as $widget_area ) {
					$name = isset ( $widget_area['name'] ) ? $widget_area['name'] : '';
					$id = isset ( $widget_area['id'] ) ? $widget_area['id'] : '';
					if ( $name && $id ) {
						$widgets_areas[$id] = $name;
					}
				}
			}
			return $widgets_areas;
		}

	}

	/**
	 * Settings Array
	 *
	 * @since 1.0.0
	 */
	public function tabs_array() {

		// Prefix
		$prefix = 'wpex_';

		// Define variable
		$array = array();

		// Main Tab
		$array['main'] = array(
			'title' => __( 'Main', 'wpex' ),
			'settings' => array(
				'post_link' => array(
					'title' => __( 'Redirect', 'wpex' ),
					'id' => $prefix . 'post_link',
					'type' => 'link',
					'description' => __( 'Enter a url to redirect this post or page.', 'wpex' ),
				),
				'main_layout' =>array(
					'title' => __( 'Site Layout', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'main_layout',
					'description' => __( 'Select the layout for your site. This option should only be used in very specific cases such as landing.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'full-width' => __( 'Full-Width', 'wpex' ),
						'boxed' => __( 'Boxed', 'wpex' ),
					),
				),
				'post_layout' => array(
					'title' => __( 'Content Layout', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'post_layout',
					'description' => __( 'Select your custom layout for this page or post content.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'right-sidebar' => __( 'Right Sidebar', 'wpex' ),
						'left-sidebar' => __( 'Left Sidebar', 'wpex' ),
						'full-width' => __( 'No Sidebar', 'wpex' ),
						'full-screen' => __( 'Full Screen', 'wpex' ),
					),
				),
				'sidebar' => array(
					'title' => __( 'Sidebar', 'wpex' ),
					'type' => 'select',
					'id' => 'sidebar',
					'description' => __( 'Select your a custom sidebar for this page or post.', 'wpex' ),
					'options' => $this->helpers( 'widget_areas' ),
				),
				'disable_toggle_bar' => array(
					'title' => __( 'Toggle Bar', 'wpex' ),
					'id' => $prefix . 'disable_toggle_bar',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'enable' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'disable_top_bar' => array(
					'title' => __( 'Top Bar', 'wpex' ),
					'id' => $prefix . 'disable_top_bar',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'enable' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'disable_breadcrumbs' => array(
					'title' => __( 'Breadcrumbs', 'wpex' ),
					'id' => $prefix . 'disable_breadcrumbs',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'enable' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'disable_social' => array(
					'title' => __( 'Social Share', 'wpex' ),
					'id' => $prefix . 'disable_social',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'enable' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
			),
		);

		// Header Tab
		$array['header'] = array(
			'title' => __( 'Header', 'wpex' ),
			'settings' => array(
				'disable_header' => array(
					'title' => __( 'Header', 'wpex' ),
					'id' => $prefix . 'disable_header',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'custom_menu' => array(
					'title' => __( 'Custom Menu', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'custom_menu',
					'description' => __( 'Select a custom menu for this page or post.', 'wpex' ),
					'options' => $this->helpers( 'menus' ),
				),
				'overlay_header' => array(
					'title' => __( 'Overlay Header', 'wpex' ),
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id' => $prefix . 'overlay_header',
					'type' => 'select',
					'options' => array(
						'' => __( 'Disable', 'wpex' ),
						'on' => __( 'Enable', 'wpex' ),
					),
				),
				'overlay_header_style' => array(
					'title' => __( 'Overlay Header Style', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'overlay_header_style',
					'description' => __( 'Select your overlay header style', 'wpex' ),
					'options' => array(
						'' => __( 'White Text', 'wpex' ),
						'dark' => __( 'Black Text', 'wpex' ),
					),
					'default' => 'light',
				),
				'overlay_header_font_size' => array(
					'title' => __( 'Overlay Header Menu Font Size', 'wpex'),
					'id' => $prefix . 'overlay_header_font_size',
					'description' => __( 'Enter a size in px.', 'wpex' ),
					'type' => 'number',
				),
				'overlay_header_logo' => array(
					'title' => __( 'Overlay Header Logo', 'wpex'),
					'id' => $prefix . 'overlay_header_logo',
					'type' => 'media',
					'description' => __( 'Select a custom logo (optional) for the overlay header.', 'wpex' ),
				),
				'overlay_header_logo_retina' => array(
					'title' => __( 'Overlay Header Logo: Retina', 'wpex'),
					'id' => $prefix . 'overlay_header_logo_retina',
					'type' => 'media',
					'description' => __( 'Retina version for the overlay header custom logo.', 'wpex' ),
				),
				'overlay_header_retina_logo_height' => array(
					'title' => __( 'Overlay Header Retina Logo Height', 'wpex'),
					'id' => $prefix . 'overlay_header_logo_retina_height',
					'description' => __( 'Enter a size in px.', 'wpex' ),
					'type' => 'number',
				),
			),
		);

		// Title Tab
		$array['title'] = array(
			'title' => __( 'Title', 'wpex' ),
			'settings' => array(
				'disable_title' => array(
					'title' => __( 'Title', 'wpex' ),
					'id' => $prefix . 'disable_title',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'disable_header_margin' => array(
					'title' => __( 'Title Margin', 'wpex' ),
					'id' => $prefix . 'disable_header_margin',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'post_subheading' => array(
					'title' => __( 'Subheading', 'wpex' ),
					'type' => 'text_html',
					'id' => $prefix . 'post_subheading',
					'description' => __( 'Enter your page subheading. Shortcodes & HTML is allowed.', 'wpex' ),
				),
				'post_title_style' => array(
					'title' => __( 'Title Style', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'post_title_style',
					'description' => __( 'Select a custom title style for this page or post.', 'wpex' ),
					'options' => $this->helpers( 'title_styles' ),
				),
				'post_title_background_color' => array(
					'title' => __( 'Title: Background Color', 'wpex' ),
					'description' => __( 'Select a color.', 'wpex' ),
					'id' => $prefix .'post_title_background_color',
					'type' => 'color',
					'hidden' => true,
				),
				'post_title_background_redux' => array(
					'title' => __( 'Title: Background Image', 'wpex'),
					'id' => $prefix . 'post_title_background_redux',
					'type' => 'media',
					'description' => __( 'Select a custom header image for your main title.', 'wpex' ),
					'hidden' => true,
				),
				'post_title_height' => array(
					'title' => __( 'Title: Background Height', 'wpex' ),
					'type' => 'text',
					'id' => $prefix . 'post_title_height',
					'description' => __( 'Select your custom height for your title background. Default is 400px.', 'wpex' ),
					'hidden' => true,
				),
				'post_title_background_overlay' => array(
					'title' => __( 'Title: Background Overlay', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'post_title_background_overlay',
					'description' => __( 'Select an overlay for the title background.', 'wpex' ),
					'options' => array(
						'' => __( 'None', 'wpex' ),
						'dark' => __( 'Dark', 'wpex' ),
						'dotted' => __( 'Dotted', 'wpex' ),
						'dashed' => __( 'Diagonal Lines', 'wpex' ),
						'bg_color' => __( 'Background Color', 'wpex' ),
					),
					'hidden' => true,
				),
				'post_title_background_overlay_opacity' => array(
					'id' => $prefix . 'post_title_background_overlay_opacity',
					'type' => 'text',
					'title' => __( 'Title: Background Overlay Opacity', 'wpex' ),
					'description' => __( 'Enter a custom opacity for your title background overlay.', 'wpex' ),
					'default' => '',
					'hidden' => true,
				),
			),
		);

		// Slider tab
		$array['slider'] = array(
			'title' => __( 'Slider', 'wpex' ),
			'settings' => array(
				'post_slider_shortcode' => array(
					'title' => __( 'Slider Shortcode', 'wpex' ),
					'type' => 'code',
					'id' => $prefix . 'post_slider_shortcode',
					'description' => __( 'Enter a slider shortcode here to display a slider at the top of the page.', 'wpex' ),
				),
				'post_slider_shortcode_position' => array(
					'title' => __( 'Slider Position', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'post_slider_shortcode_position',
					'description' => __( 'Select the position for the slider shortcode.', 'wpex' ),
					'options' => array(
						'' => __( 'Skin Default', 'wpex' ),
						'below_title' => __( 'Below Title', 'wpex' ),
						'above_title' => __( 'Above Title', 'wpex' ),
						'above_menu' => __( 'Above Menu (Header 2 or 3)', 'wpex' ),
						'above_header' => __( 'Above Header', 'wpex' ),
						'above_topbar' => __( 'Above Top Bar', 'wpex' ),
					),
				),
				'post_slider_bottom_margin' => array(
					'title' => __( 'Slider Bottom Margin', 'wpex' ),
					'description' => __( 'Enter a bottom margin for your slider in pixels', 'wpex' ),
					'id' => $prefix . 'post_slider_bottom_margin',
					'type' => 'text',
				),
				'disable_post_slider_mobile' => array(
					'title' => __( 'Slider On Mobile', 'wpex' ),
					'id' => $prefix . 'disable_post_slider_mobile',
					'type' => 'select',
					'description' => __( 'Enable or disable slider display for mobile devices.', 'wpex' ),
					'options' => array(
						'' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'post_slider_mobile_alt' => array(
					'title' => __( 'Slider Mobile Alternative', 'wpex' ),
					'type' => 'media',
					'id' => $prefix . 'post_slider_mobile_alt',
					'description' => __( 'Select an image.', 'wpex' ),
					'type' => 'media',
				),
				'post_slider_mobile_alt_url' => array(
					'title' => __( 'Slider Mobile Alternative URL', 'wpex' ),
					'id' => $prefix . 'post_slider_mobile_alt_url',
					'description' => __( 'URL for the mobile slider alternative.', 'wpex' ),
					'type' => 'text',
				),
				'post_slider_mobile_alt_url_target' => array(
					'title' => __( 'Slider Mobile Alternative URL Target', 'wpex' ),
					'id' => $prefix . 'post_slider_mobile_alt_url_target',
					'description' => __( 'Select your link target window.', 'wpex' ),
					'type' => 'select',
					'options' => array(
						'' => __( 'Same Window', 'wpex' ),
						'blank' => __( 'New Window', 'wpex' ),
					),
				),
			),
		);

		// Background tab
		$array['background'] = array(
			'title' => __( 'Background', 'wpex' ),
			'settings' => array(
				'page_background_color' => array(
					'title' => __( 'Background Color', 'wpex' ),
					'description' => __( 'Select a color.', 'wpex' ),
					'id' => $prefix . 'page_background_color',
					'type' => 'color',
				),
				'page_background_image_redux' => array(
					'title' => __( 'Background Image', 'wpex' ),
					'id' => $prefix . 'page_background_image_redux',
					'description' => __( 'Select an image.', 'wpex' ),
					'type' => 'media',
				),
				'page_background_image_style' => array(
					'title' => __( 'Background Style', 'wpex' ),
					'type' => 'select',
					'id' => $prefix . 'page_background_image_style',
					'description' => __( 'Select the style.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'repeat' => __( 'Repeat', 'wpex' ),
						'fixed' => __( 'Fixed', 'wpex' ),
						'stretched' => __( 'Streched', 'wpex' ),
					),
				),
			),
		);

		// Footer tab
		$array['footer'] = array(
			'title' => __( 'Footer', 'wpex' ),
			'settings' => array(
				'disable_footer' => array(
					'title' => __( 'Footer', 'wpex' ),
					'id' => $prefix . 'disable_footer',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'enable' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'disable_footer_widgets' => array(
					'title' => __( 'Footer Widgets', 'wpex' ),
					'id' => $prefix . 'disable_footer_widgets',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'footer_reveal' => array(
					'title' => __( 'Footer Reveal', 'wpex' ),
					'description' => __( 'Enable the footer reveal style. The footer will be placed in a fixed postion and display on scroll. This setting is for the "Full-Width" layout only and desktops only.', 'wpex' ),
					'id' => $prefix . 'footer_reveal',
					'type' => 'select',
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'on' => __( 'Enable', 'wpex' ),
						'off' => __( 'Disable', 'wpex' ),
					),
				),
			),
		);

		// Callout Tab
		$array['callout'] = array(
			'title' => __( 'Callout', 'wpex' ),
			'settings' => array(
				'disable_footer_callout' => array(
					'title' => __( 'Callout', 'wpex' ),
					'id' => $prefix . 'disable_footer_callout',
					'type' => 'select',
					'description' => __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'enable' => __( 'Enable', 'wpex' ),
						'on' => __( 'Disable', 'wpex' ),
					),
				),
				'callout_link' => array(
					'title' => __( 'Callout Link', 'wpex' ),
					'id' => $prefix . 'callout_link',
					'type' => 'link',
					'description' => __( 'Enter a valid link.', 'wpex' ),
				),
				'callout_link_txt' => array(
					'title' => __( 'Callout Link Text', 'wpex' ),
					'id' => $prefix . 'callout_link_txt',
					'type' => 'text',
					'description' => __( 'Enter your text.', 'wpex' ),
				),
				'callout_text' => array(
					'title' => __( 'Callout Text', 'wpex' ),
					'id' => $prefix . 'callout_text',
					'type' => 'editor',
					'rows' => '5',
					'teeny' => true,
					'media_buttons' => false,
					'description' => __( 'Override the default callout text and if your callout box is disabled globally but you have content here it will still display for this page or post.', 'wpex' ),
				),
			),
		);
		// Media tab
		$array['media'] = array(
			'title' => __( 'Media', 'wpex' ),
			'post_type' => array( 'post' ),
			'settings' => array(
				'post_media_position' => array(
					'title' => __( 'Media Display/Position', 'wpex' ),
					'id' => $prefix . 'post_media_position',
					'type' => 'select',
					'description' => __( 'Select your preferred position for your post\'s media (featured image or video).', 'wpex' ),
					'options' => array(
						'' => __( 'Default', 'wpex' ),
						'above' => __( 'Full-Width Above Content', 'wpex' ),
						'hidden' => __( 'None (Do Not Display Featured Image/Video)', 'wpex' ),
					),
				),
				'post_oembed' => array(
					'title' => __( 'oEmbed URL', 'wpex' ),
					'description' =>__( 'Enter a URL that is compatible with WP\'s built-in oEmbed feature. This setting is used for your video and audio post formats.', 'wpex' ) .'<br /><a href="http://codex.wordpress.org/Embeds" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
					'id' => $prefix . 'post_oembed',
					'type' => 'text',
				),
				'post_self_hosted_shortcode_redux' => array(
					'title' => __( 'Self Hosted', 'wpex' ),
					'description' => __( 'Insert your self hosted video or audio url here.', 'wpex' ) .'<br /><a href="http://make.wordpress.org/core/2013/04/08/audio-video-support-in-core/" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
					'id' => $prefix . 'post_self_hosted_media',
					'type' => 'media',
				),
				'post_video_embed' => array(
					'title' => __( 'Embed Code', 'wpex' ),
					'description' => __( 'Insert your embed/iframe code.', 'wpex' ),
					'id' => $prefix . 'post_video_embed',
					'type' => 'textarea',
					'rows' => '2',
				),
			),
		);

		// Staff Tab
		if ( WPEX_STAFF_IS_ACTIVE ) {
			$staff_meta_array = wpex_staff_social_meta_array();
			$staff_meta_array['position'] = array(
				'title' => __( 'Position', 'wpex' ),
				'id' => $prefix .'staff_position',
				'type' => 'text',
			);
			$obj = get_post_type_object( 'staff' );
			$tab_title= $obj->labels->singular_name;
			$array['staff'] = array(
				'title' => $tab_title,
				'post_type' => array( 'staff' ),
				'settings' => $staff_meta_array,
			);
		}

		// Portfolio Tab
		if ( WPEX_PORTFOLIO_IS_ACTIVE ) {
			$obj= get_post_type_object( 'portfolio' );
			$tab_title = $obj->labels->singular_name;
			$array['portfolio'] = array(
				'title' => $tab_title,
				'post_type' => array( 'portfolio' ),
				'settings' => array(
					'featured_video' => array(
						'title' => __( 'oEmbed URL', 'wpex' ),
						'description' =>__( 'Enter a URL that is compatible with WP\'s built-in oEmbed feature. This setting is used for your video and audio post formats.', 'wpex' ) .'<br /><a href="http://codex.wordpress.org/Embeds" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
						'id' => $prefix .'post_video',
						'type' => 'text',
					),
					'post_video_embed' => array(
						'title' => __( 'Embed Code', 'wpex' ),
						'description' => __( 'Insert your embed/iframe code.', 'wpex' ),
						'id' => $prefix . 'post_video_embed',
						'type' => 'textarea',
						'rows' => '2',
					),
				),
			);
		}

		// Testimonials Tab
		if ( WPEX_TESTIMONIALS_IS_ACTIVE ) {
			$obj= get_post_type_object( 'testimonials' );
			$tab_title = $obj->labels->singular_name;
			$array['testimonials'] = array(
				'title' => $tab_title,
				'post_type' => array( 'testimonials' ),
				'settings' => array(
					'testimonial_author' => array(
						'title' => __( 'Author', 'wpex' ),
						'description' => __( 'Enter the name of the author for this testimonial.', 'wpex' ),
						'id' => $prefix .'testimonial_author',
						'type' => 'text',
					),
					'testimonial_company' => array(
						'title' => __( 'Company', 'wpex' ),
						'description' => __( 'Enter the name of the company for this testimonial.', 'wpex' ),
						'id' => $prefix .'testimonial_company',
						'type' => 'text',
					),
					'testimonial_url' => array(
						'title' => __( 'Company URL', 'wpex' ),
						'description' => __( 'Enter the url for the company for this testimonial.', 'wpex' ),
						'id' => $prefix .'testimonial_url',
						'type' => 'text',
					),
				),
			);
		}

		// Apply filter & return settings array
		return apply_filters( 'wpex_metabox_array', $array );
	}

	/**
	 * Adds custom CSS for the metaboxes inline instead of loading another stylesheet
	 *
	 * @see assets/metabox.css
	 * @since 1.0.0
	 */
	public static function metaboxes_css() { ?>

		<style type="text/css">
			#wpex-metabox .wp-tab-panel{display:none;}#wpex-metabox .wp-tab-panel#wpex-mb-tab-1{display:block;}#wpex-metabox .wp-tab-panel{max-height:none !important;}#wpex-metabox ul.wp-tab-bar{-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}#wpex-metabox ul.wp-tab-bar{padding-top:5px;}#wpex-metabox ul.wp-tab-bar:after{content:"";display:block;height:0;clear:both;visibility:hidden;zoom:1;}#wpex-metabox ul.wp-tab-bar li{padding:5px 12px;font-size:14px;}#wpex-metabox ul.wp-tab-bar li a:focus{box-shadow:none;}#wpex-metabox .inside .form-table tr{border-top:1px solid #dfdfdf;}#wpex-metabox .inside .form-table tr:first-child{border:none;}#wpex-metabox .inside .form-table th{width:240px;padding:10px 30px 10px 0;}#wpex-metabox .inside .form-table td{padding:10px 0;}#wpex-metabox .inside .form-table label{display:block;}#wpex-metabox .inside .form-table th label span{margin-right:7px;}#wpex-metabox .wpex-mb-uploader{margin-left:5px;}#wpex-metabox .inside .form-table th p.wpex-mb-description{font-size:12px;font-weight:normal;margin:0;padding:0;padding-top:4px;}#wpex-metabox .inside .form-table input[type="text"],#wpex-metabox .inside .form-table input[type="number"],#wpex-metabox .inside .form-table .wpex-mb-textarea-code{width:40%;}#wpex-metabox .inside .form-table textarea{width:100%}#wpex-metabox .inside .form-table select{min-width:40%;}#wpex-metabox .wpex-mb-reset{margin-top:7px;}#wpex-metabox .wpex-mb-reset .wpex-reset-btn{display:block;float:left;}#wpex-metabox .wpex-mb-reset .wpex-reset-checkbox{float:left;display:none;margin-left:10px;padding-top:5px;}
		</style>

	<?php

	}

	/**
	 * Adds custom js for the metaboxes inline instead of loading another js file
	 *
	 * @see assets/metabox.js
	 * @since 1.0.0
	 */
	public static function metaboxes_js() { ?>

		<script type="text/javascript">
			!function(e){"use strict";e(document).on("ready",function(){e("div#wpex-metabox ul.wp-tab-bar a").click(function(){var t=e("#wpex-metabox ul.wp-tab-bar li"),a=e(this).data("tab"),o=e("#wpex-metabox div.wp-tab-panel");return e(t).removeClass("wp-tab-active"),e(o).hide(),e(a).show(),e(this).parent("li").addClass("wp-tab-active"),!1}),e("div#wpex-metabox .wpex-mb-color-field").wpColorPicker();var t=!0,a=wp.media.editor.send.attachment;e("div#wpex-metabox .wpex-mb-uploader").click(function(){var o=(wp.media.editor.send.attachment,e(this)),i=o.prev();return wp.media.editor.send.attachment=function(o,r){return t?void e(i).val(r.id):a.apply(this,[o,r])},wp.media.editor.open(o),!1}),e("div#wpex-metabox .add_media").on("click",function(){t=!1}),e("div#wpex-metabox div.wpex-mb-reset a.wpex-reset-btn").click(function(){var t=e("div.wpex-mb-reset div.wpex-reset-checkbox"),a=t.is(":visible")?"<?php echo __(  'Reset Settings', 'wpex' ); ?>":"<?php echo __(  'Cancel Reset', 'wpex' ); ?>";e(this).text(a),e("div.wpex-mb-reset div.wpex-reset-checkbox input").attr("checked",!1),t.toggle()});var o=(e("#wpex_disable_header_margin_tr, #wpex_post_subheading_tr,#wpex_post_title_style_tr"),e("div#wpex-metabox select#wpex_post_title_style")),i=(o.val(),e("#wpex_post_title_background_color_tr, #wpex_post_title_background_redux_tr,#wpex_post_title_height_tr,#wpex_post_title_background_overlay_tr,#wpex_post_title_background_overlay_opacity_tr")),r=e("#wpex_post_title_background_color_tr");"background-image"==o.val()&&i.show(),"solid-color"==o.val()&&r.show(),"background-image"==o&&i.show(),o.change(function(){i.hide(),"background-image"==e(this).val()?i.show():"solid-color"===e(this).val()&&r.show()});var _=e("div#wpex-metabox select#wpex_overlay_header"),p=e("#wpex_overlay_header_style_tr, #wpex_overlay_header_font_size_tr,#wpex_overlay_header_logo_tr,#wpex_overlay_header_logo_retina_tr,#wpex_overlay_header_logo_retina_height_tr");"on"===_.val()?p.show():p.hide(),_.change(function(){"on"===e(this).val()?p.show():p.hide()})})}(jQuery);
		</script>

	<?php }

}
$wpex_post_metaboxes = new WPEX_Post_Metaboxes();