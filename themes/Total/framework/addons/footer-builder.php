<?php
/**
 * Footer Builder Addon
 *
 * @package Total WordPress theme
 * @subpackage Framework
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
class WPEX_Footer_Builder {

	/**
	 * Start things up
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// Define footer ID
		$this->footer_builder_id = wpex_get_mod( 'footer_builder_page_id' );

		// Add admin page
		add_action( 'admin_menu', array( $this, 'add_page' ), 20 );

		// Register admin options
		add_action( 'admin_init', array( $this, 'register_page_options' ) );

		// Run actions and filters if footer_builder ID is defined
		if ( $this->footer_builder_id ) {

			// Alter the footer on init
			add_action( 'init', array( $this, 'alter_footer' ) );

			// Remove all actions from wp_head on footer builder page
			add_action( 'wp_head', array( $this, 'remove_actions' ) );

			// Make sure custom VC CSS for this page is added on all pages
			add_action( 'wpex_head_css', array( $this, 'vc_css' ) );

			// Remove sidebar on footer builder page
			add_filter( 'wpex_post_layout_class', array( $this, 'remove_sidebar_on_footer_builder' ) );

			// Remove footer customizer settings
			add_filter( 'wpex_customizer_panels', array( $this, 'remove_customizer_footer_panel' ) );

		}

	}

	/**
	 * Add sub menu page
	 *
	 * @since 2.0.0
	 */
	public function add_page() {

		$admin_page = add_submenu_page(
			WPEX_THEME_PANEL_SLUG,
			__( 'Footer Builder', 'wpex' ),
			__( 'Footer Builder', 'wpex' ),
			'administrator',
			WPEX_THEME_PANEL_SLUG .'-footer-builder',
			array( $this, 'create_admin_page' )
		);

		// Adds my_help_tab when admin_page loads
		global $wpex_admin_help_tabs;
		if ( $wpex_admin_help_tabs ) {
			add_action( 'load-'. $admin_page, array( $this, 'help_tab' ) );
		}

	}

	/**
	 * Adds help tab to this admin page
	 *
	 * @since 2.0.0
	 */
	public static function help_tab() {

		// Get current screen
		$screen = get_current_screen();

		// Define content
		$content  = '<p><h3>'. __( 'Documentation', 'wpex' ) .'</h3><ul>';
			$content .= '<li><a href="http://wpexplorer-themes.com/total/docs/footer-builder/" target="_blank">http://wpexplorer-themes.com/total/docs/footer-builder/</a></li>';
		$content  .= '</ul></p>';

		// Add wpex_footer_builder help tab if current screen is My Admin Page
		$screen->add_help_tab( array(
			'id'      => 'wpex_footer_builder',
			'title'   => __( 'Documentation', 'wpex' ),
			'content' => $content,
		) );

	}

	/**
	 * Function that will register admin page options
	 *
	 * @since 2.0.0
	 */
	public function register_page_options() {

		// Register settings
		register_setting( 'wpex_footer_builder', 'footer_builder', array( $this, 'sanitize' ) );

		// Add main section to our options page
		add_settings_section( 'wpex_footer_builder_main', false, array( $this, 'section_main_callback' ), 'wpex-footer-builder-admin' );

		// Custom Page ID
		add_settings_field(
			'footer_builder_page_id',
			__( 'Footer Builder page', 'wpex' ),
			array( $this, 'content_id_field_callback' ),
			'wpex-footer-builder-admin',
			'wpex_footer_builder_main'
		);

		// Fixed Footer
		add_settings_field(
			'fixed_footer',
			__( 'Fixed Footer', 'wpex' ),
			array( $this, 'fixed_footer_field_callback' ),
			'wpex-footer-builder-admin',
			'wpex_footer_builder_main'
		);

		// Footer Reveal
		add_settings_field(
			'footer_reveal',
			__( 'Footer Reveal', 'wpex' ),
			array( $this, 'footer_reveal_field_callback' ),
			'wpex-footer-builder-admin',
			'wpex_footer_builder_main'
		);

	}

	/**
	 * Sanitization callback
	 *
	 * @since 2.0.0
	 */
	public static function sanitize( $options ) {

		// Update footer builder page ID
		if ( ! empty( $options['content_id'] ) ) {
			set_theme_mod( 'footer_builder_page_id', $options['content_id'] );
		} else {
			remove_theme_mod( 'footer_builder_page_id' );
		}

		// Update fixed footer - Enabled by default
		if ( empty( $options['fixed_footer'] ) ) {
			set_theme_mod( 'fixed_footer', false );
		} else {
			remove_theme_mod( 'fixed_footer' );
		}

		// Update footer Reveal - Disabled by default
		if ( empty( $options['footer_reveal'] ) ) {
			remove_theme_mod( 'footer_reveal' );
		} else {
			set_theme_mod( 'footer_reveal', true );
		}

		// Set options to nothing since we are storing in the theme mods
		$options = '';
		return $options;
	}

	/**
	 * Main Settings section callback
	 *
	 * @since 2.0.0
	 */
	public static function section_main_callback( $options ) {
		// Leave blank
	}

	/**
	 * Fields callback functions
	 *
	 * @since 2.0.0
	 */

	// Footer Builder Page ID
	public static function content_id_field_callback() { ?>

		<?php
		// Get footer builder page ID
		$page_id = wpex_get_mod( 'footer_builder_page_id' ); ?>

		<?php
		// Display dropdown of pages
		wp_dropdown_pages( array(
			'echo'             => true,
			'selected'         => $page_id,
			'name'             => 'footer_builder[content_id]',
			'show_option_none' => __( 'None - Display Widgetized Footer', 'wpex' ),
		) ); ?>
		<br />

		<p class="description"><?php _e( 'Select your custom page for your footer layout.', 'wpex' ) ?></p>

		<?php
		// If page_id is defined display edit and preview links
		if ( $page_id ) { ?>

			<br />

			<a href="<?php echo admin_url( 'post.php?post='. $page_id .'&action=edit' ); ?>" class="button" target="_blank">
				<?php _e( 'Backend Edit', 'wpex' ); ?>
			</a>

			<?php if ( WPEX_VC_ACTIVE ) { ?>

				<a href="<?php echo admin_url( 'post.php?vc_action=vc_inline&post_id='. $page_id .'&post_type=page' ); ?>" class="button" target="_blank">
					<?php _e( 'Frontend Edit', 'wpex' ); ?>
				</a>

			<?php } ?>

			<a href="<?php echo get_permalink( $page_id ); ?>" class="button" target="_blank">
				<?php _e( 'Preview', 'wpex' ); ?>
			</a>

		<?php } ?>
		
	<?php }

	/**
	 * Fixed Footer Callback
	 *
	 * @since 2.0.0
	 */

	// Footer Builder Page ID
	public static function fixed_footer_field_callback() {

		// Get theme mod val
		$val = get_theme_mod( 'fixed_footer', true );
		$val = $val ? 'on' : false; ?>

			<input type="checkbox" name="footer_builder[fixed_footer]" <?php checked( $val, 'on' ); ?>>

		<?php
	}

	/**
	 * Footer Reveal Callback
	 *
	 * @since 2.0.0
	 */

	// Footer Builder Page ID
	public static function footer_reveal_field_callback() {

		// Get theme mod val
		$val = get_theme_mod( 'footer_reveal' );
		$val = $val ? 'on' : false; ?>

			<input type="checkbox" name="footer_builder[footer_reveal]" <?php checked( $val, 'on' ); ?>>

		<?php
	}


	/**
	 * Settings page output
	 *
	 * @since 2.0.0
	 */
	public static function create_admin_page() { ?>
		<div class="wrap">
			<h2><?php _e( 'Footer Builder', 'wpex' ); ?></h2>
			<p>
				<?php echo _x( 'By default the footer consists of a simple widgetized area. For more complex layouts you can use the option below to select a page which will hold the content and layout for your site footer. Selecting a custom footer will remove all footer functions (footer widgets and footer customizer options) so you can create an entire footer using the Visual Composer and not load that extra functions.', 'Footer Builder Description', 'wpex' ); ?>
			</p>
			<form method="post" action="options.php">
				<?php settings_fields( 'wpex_footer_builder' ); ?>
				<?php do_settings_sections( 'wpex-footer-builder-admin' ); ?>
				<?php submit_button(); ?>
			</form>
		</div><!-- .wrap -->
	<?php }

	/**
	 * Remove the footer and add custom footer if enabled
	 *
	 * @since 2.0.0
	 */
	public function alter_footer() {

		// Remove theme footer
		remove_action( 'wpex_hook_wrap_bottom', 'wpex_footer', 10 );

		// Remove all actions in footer hooks
		$hooks = wpex_theme_hooks();
		if ( isset( $hooks['footer']['hooks'] ) ) {
			foreach( $hooks['footer']['hooks'] as $hook ) {
				remove_all_actions( $hook, false );
			}
		}

		// Re add callout
		add_action( 'wpex_hook_footer_before', 'wpex_footer_callout' );

		// Re add reveal if enabled
		if ( get_theme_mod( 'footer_reveal' ) ) {
			add_action( 'wpex_hook_footer_before', 'wpex_footer_reveal_open', 0 );
			add_action( 'wpex_hook_footer_after', 'wpex_footer_reveal_close', 99 );
		}

		// Add builder footer
		add_action( 'wpex_hook_wrap_bottom', array( $this, 'get_part' ), 10 );

		// Remove widgets
		unregister_sidebar( 'footer_one' );
		unregister_sidebar( 'footer_two' );
		unregister_sidebar( 'footer_three' );
		unregister_sidebar( 'footer_four' );

	}

	/**
	 * Load VC CSS
	 *
	 * @since 2.0.0
	 */
	public function vc_css( $css ) {
		if ( $vc_css = get_post_meta( $this->footer_builder_id, '_wpb_shortcodes_custom_css', true ) ) {
			$css .='/*FOOTER BUILDER CSS*/'. $vc_css;
		}
		return $css;
	}

	/**
	 * Remove all theme actions
	 *
	 * @since 2.0.0
	 */
	public function remove_actions() {
		if ( is_page( $this->footer_builder_id ) ) {
			wpex_remove_actions();
		}
	}

	/**
	 * Remove the footer and add custom footer if enabled
	 *
	 * @since 2.0.0
	 */
	public static function remove_customizer_footer_panel( $panels ) {
		unset( $panels['footer_widgets'] );
		unset( $panels['footer_bottom'] );
		return $panels;
	}

	/**
	 * Make Footer builder page full-width (no sidebar)
	 *
	 * @since 2.0.0
	 */
	public function remove_sidebar_on_footer_builder( $class ) {

		// Set the footer builder to "full-width" by default
		if ( is_page( $this->footer_builder_id ) ) {
			$class = 'full-width';
		}

		// Return correct class
		return $class;

	}

	/**
	 * Gets the footer builder template part if the footer is enabled
	 *
	 * @since 2.0.0
	 */
	public static function get_part() {
		if ( wpex_global_obj( 'has_footer' ) ) {
			get_template_part( 'partials/footer/footer-builder' );
		}
	}

}
$wpex_footer_builder = new WPEX_Footer_Builder();