<?php
/**
 * Visual Composer configuration file
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 */

class WPEX_Visual_Composer {
	private $vc_theme_mode;
	private $remove_vc_design_options;

	/**
	 * Start things up
	 *
	 * @since 1.6.0
	 */
	public function __construct() {

		// Update vars
		$this->vc_theme_mode = wpex_get_mod( 'visual_composer_theme_mode', true );
		$this->remove_vc_design_options = apply_filters( 'wpex_remove_vc_design_options', true );

		// Include helper functions and classes
		require_once( WPEX_FRAMEWORK_DIR .'visual-composer/vc-helpers.php' );

		// Override editor logo
		add_filter( 'vc_nav_front_logo', array( $this, 'nav_logo' ) );

		// Remove design options tab
		if ( $this->remove_vc_design_options ) {
			add_filter( 'vc_settings_page_show_design_tabs', '__return_false' );
			delete_option( 'wpb_js_use_custom' );
		}

		// Add actions
		add_action( 'wp_enqueue_scripts', array( $this, 'load_composer_front_css' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_remove_styles' ) );
		add_action( 'admin_menu', array( __class__, 'remove_welcome' ), 999 );
		add_action( 'wp_footer', array( $this, 'remove_footer_scripts' ) );
		add_action( 'admin_enqueue_scripts',  array( $this, 'admin_scripts' ) );
		add_action( 'admin_init', array( $this, 'disable_updater' ), 99 );
		add_action( 'init', array( $this, 'init' ), 20 );
		add_action( 'wpex_head_css', array( $this,'vc_css_ids' ) );

		// Add filters
		add_filter( 'vc_font_container_get_allowed_tags', array( $this, 'font_container_tags' ) );
		add_filter( 'vc_font_container_get_fonts_filter', array( $this, 'font_container_fonts' ) );

		// Remove actions
		remove_action( 'vc_activation_hook', 'vc_page_welcome_set_redirect' );
		remove_action( 'init', 'vc_page_welcome_redirect' );

		// Register accent colors
		add_filter( 'wpex_accent_texts', array( $this, 'accent_texts' ) );
		add_filter( 'wpex_accent_borders', array( $this, 'accent_borders' ) );
		add_filter( 'wpex_accent_backgrounds', array( $this, 'accent_backgrounds' ) );

		// Add new shortcode param
		add_shortcode_param( 'vcex_textarea_html', array( $this, 'vcex_textarea_html' ) );

		// Extend the Visual Composer (add new modules)
		if ( wpex_get_mod( 'extend_visual_composer', true ) ) {
			add_action( 'after_setup_theme', array( $this, 'map_custom_shortcodes' ) );
		}

	}

	/**
	 * Disables the VC updater function
	 *
	 * @since  3.0.0
	 */
	public function disable_updater() {

		// Make sure theme mode is enabled
		if ( ! $this->vc_theme_mode ) {
			return;
		}

		/**
		 * Remove update pre_download filter
		 *
		 * @see Vc_Updater
		 *
		 */
		if ( empty ( $GLOBALS['wp_filter']['upgrader_pre_download'] ) ) {
			return;
		} else {
			$filters = $GLOBALS['wp_filter']['upgrader_pre_download'];
		}

		// Loop through filter
		foreach ( $filters as $priority => $filter ) {
			foreach ( $filter as $identifier => $function ) {
				if ( is_array( $function )
					and is_a( $function['function'][0], 'Vc_Updater' )
					and 'upgradeFilterFromEnvato' === $function['function'][1]
				) {
					remove_filter( 'upgrader_pre_download', array ( $function['function'][0], 'upgradeFilterFromEnvato' ), $priority );
				}
			}
		}

		/**
		 * Remove Updater message in plugins list
		 *
		 * @see Vc_Updating_Manager
		 *
		 */
		if ( ! function_exists( 'vc_plugin_name' ) ) {
			return;
		}

		$tag = 'in_plugin_update_message-' . vc_plugin_name();

		if ( empty ( $GLOBALS['wp_filter'][$tag] ) ) {
			return;
		} else {
			$filters = $GLOBALS['wp_filter'][$tag];
		}

		// Return if filters are empty
		if ( empty ( $filters ) ) {
			return;
		}

		// Loop through filter
		foreach ( $filters as $priority => $filter ) {
			foreach ( $filter as $identifier => $function ) {
				if ( is_array( $function )
					and is_a( $function['function'][0], 'Vc_Updating_Manager' )
					and 'check_update' === $function['function'][1]
				) {
					remove_filter( $tag, array ( $function['function'][0], 'check_update' ), $priority );
				}
			}
		}

	}

	/**
	 * Override editor logo
	 *
	 * @since  3.0.0
	 */
	public static function nav_logo() {
		return '<div id="vc_logo" class="vc_navbar-brand">'. __( 'Visual Composer', 'wpex' ) .'</div>';
	}

	/**
	 * Removes "About" page in the Visual Composer
	 *
	 * @since  2.1.0
	 */
	public static function remove_welcome() {
		remove_submenu_page( 'vc-general', 'vc-welcome' );
	}

	/**
	 * Load js_composer_front CSS eaerly on for easier modification
	 *
	 * @since  2.1.3
	 */
	public static function load_composer_front_css() {
		wp_enqueue_style( 'js_composer_front' );
	}

	/**
	 * Load and remove stylesheets
	 *
	 * @since 2.0.0
	 */
	public function load_remove_styles() {

		// Add Scripts
		wp_enqueue_style(
			'wpex-visual-composer',
			WPEX_CSS_DIR_URI .'wpex-visual-composer.css',
			array(
				'wpex-style',
				'js_composer_front'
			),
			WPEX_THEME_VERSION
		);

		wp_enqueue_style(
			'wpex-visual-composer-extend',
			WPEX_CSS_DIR_URI .'wpex-visual-composer-extend.css',
			array(
				'wpex-style',
				'js_composer_front'
			),
			WPEX_THEME_VERSION
		);

		// Remove Scripts to fix Customizer issue with jQuery UI
		if ( is_customize_preview() ) {
			wp_deregister_script( 'wpb_composer_front_js' );
			wp_dequeue_script( 'wpb_composer_front_js' );
		}

		// Remove unwanted scripts
		if ( $this->vc_theme_mode ) {
			wp_deregister_style( 'js_composer_custom_css' );
		}
		wp_deregister_style( 'font-awesome' );
		wp_dequeue_style( 'font-awesome' );

	}

	/**
	 * Remove scripts hooked in too late for me to remove on wp_enqueue_scripts
	 *
	 * @since  2.1.0
	 */
	public static function remove_footer_scripts() {

		// JS
		wp_dequeue_script( 'vc_pageable_owl-carousel' );
		wp_dequeue_script( 'vc_grid-js-imagesloaded' );

		// Styles conflict with Total owl carousel styles
		wp_deregister_style( 'vc_pageable_owl-carousel-css-theme' );
		wp_dequeue_style( 'vc_pageable_owl-carousel-css-theme' );
		wp_deregister_style( 'vc_pageable_owl-carousel-css' );
		wp_dequeue_style( 'vc_pageable_owl-carousel-css' );

	}

	/**
	 * Admin Scripts
	 *
	 * @since 1.6.0
	 */
	public static function admin_scripts() {
		wp_enqueue_style( 'vcex-admin-css', WPEX_VCEX_DIR_URI .'assets/wpex-vc-admin.css' );
	}

	/**
	 * Alter default post types
	 *
	 * @since 2.0.0
	 */
	public function init() {

		// Remove templatera notice
		remove_action( 'admin_notices', 'templatera_notice' );

		// Set as theme mode
		if ( function_exists( 'vc_set_as_theme' ) && $this->vc_theme_mode ) {
			vc_set_as_theme( true );
		}

		// Set defaults for admin
		if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
			vc_set_default_editor_post_types( array( 'page', 'portfolio', 'staff' ) );
		}

		// Set defaults for editor
		if ( function_exists( 'vc_editor_set_post_types ') ) {
			$types = vc_settings()->get( 'content_types' );
			if ( empty( $types  ) ) {
				vc_editor_set_post_types( array( 'page', 'portfolio', 'staff' ) );
			}
		}

		// Array of elements to remove
		$elements = array(
			'vc_teaser_grid',
			'vc_posts_grid',
			'vc_posts_slider',
			'vc_carousel',
			'vc_gallery',
			'vc_wp_text',
			'vc_wp_pages',
			'vc_wp_links',
			'vc_wp_categories',
			'vc_wp_meta',
			'vc_images_carousel',
		);

		// Add filter for child theme tweaking
		$elements = apply_filters( 'wpex_vc_remove_elements', $elements );

		// Loop through elements to remove and remove them
		if ( is_array( $elements ) ) {
			foreach ( $elements as $element ) {
				vc_remove_element( $element );
			}
		}
		
		// Add param to tabs
		vc_add_param( 'vc_tabs', array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'wpex' ),
			'param_name' => 'style',
			'value' => array(
				__( 'Default', 'wpex' ) => 'default',
				__( 'Alternative #1', 'wpex' ) => 'alternative-one',
				__( 'Alternative #2', 'wpex' ) => 'alternative-two',
			),  
		) );

		// Add param Tours
		vc_add_param( 'vc_tour', array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'wpex' ),
			'param_name' => 'style',
			'value' => array(
				__( 'Default', 'wpex' ) => 'default',
				__( 'Alternative #1', 'wpex' ) => 'alternative-one',
				__( 'Alternative #2', 'wpex' ) => 'alternative-two',
			),
			
		) );

		// Add param Custom Heading
		vc_add_param( 'vc_custom_heading', array(
			'type' => 'dropdown',
			'heading' => __( 'Enqueue Font Style', 'wpex' ),
			'param_name' => 'enqueue_font_style',
			'value' => array(
				__( 'Yes', 'wpex' ) => 'true',
				__( 'No', 'wpex' ) => 'false',
			),
			'descriptipn' => __( 'If the Google Font you are using is already in use by the theme select No to prevent this font from loading again on the site.', 'wpex' ),
		) );

	}

	/**
	 * Adds fonts to the font_container param
	 *
	 * @since 2.1.0
	 */
	public static function font_container_tags( $tags ) {
		$tags['span'] = 'span';
		return $tags;
	}

	/**
	 * Adds fonts to the font_container param
	 *
	 * @since  2.1.0
	 */
	public static function font_container_fonts( $fonts ) {

		// Add blank option
		$new_fonts[''] = __( 'Default', 'wpex' );

		// Merge arrays
		$fonts = array_merge( $new_fonts, $fonts );

		// Return fonts
		return $fonts;

	}

	/**
	 * Adds border accents for WooCommerce styles
	 *
	 * @since  2.1.0
	 */
	public static function accent_texts( $texts ) {
		return array_merge( array(
			'.wpex-carousel-woocommerce .wpex-carousel-entry-details',
		), $texts );
	}

	/**
	 * Adds border accents for WooCommerce styles
	 *
	 * @since  2.1.0
	 */
	public static function accent_borders( $borders ) {
		return array_merge( array(
			'.vcex-heading-bottom-border-w-color' => array( 'bottom' ),
			'.wpb_tabs.tab-style-alternative-two .wpb_tabs_nav li.ui-tabs-active a' => array( 'bottom' ),
		), $borders );
	}

	/**
	 * Adds border accents for WooCommerce styles
	 *
	 * @since  2.1.0
	 */
	public static function accent_backgrounds( $backgrounds ) {
		return array_merge( array(
			'.vcex-skillbar-bar',
			'.vcex-icon-box.style-five.link-wrap:hover',
			'.vcex-icon-box.style-four.link-wrap:hover',
			'.vcex-recent-news-date span.month',
			'.vcex-pricing.featured .vcex-pricing-header',
			'.vcex-testimonials-fullslider .sp-button:hover',
			'.vcex-testimonials-fullslider .sp-selected-button',
			'.vcex-social-links a:hover',
			'.vcex-testimonials-fullslider.light-skin .sp-button:hover',
			'.vcex-testimonials-fullslider.light-skin .sp-selected-button',
		), $backgrounds );
	}

	/**
	 * Maps custom shortcodes for the VC
	 *
	 * @since  2.1.0
	 */
	public static function map_custom_shortcodes() {

		// Define dir
		$dir = WPEX_VCEX_DIR;

		// Array of new modules to add to the VC
		$vcex_modules = array(
			'spacing' => $dir .'shortcodes/spacing.php',
			'divider' => $dir .'shortcodes/divider.php',
			'heading' => $dir .'shortcodes/heading.php',
			'button' => $dir .'shortcodes/button.php',
			'icon_box' => $dir .'shortcodes/icon_box.php',
			'teaser' => $dir .'shortcodes/teaser.php',
			'feature' => $dir .'shortcodes/feature.php',
			'callout' => $dir .'shortcodes/callout.php',
			'list_item' => $dir .'shortcodes/list_item.php',
			'bullets' => $dir .'shortcodes/bullets.php',
			'pricing' => $dir .'shortcodes/pricing.php',
			'skillbar' => $dir .'shortcodes/skillbar.php',
			'icon' => $dir .'shortcodes/icon.php',
			'milestone' => $dir .'shortcodes/milestone.php',
			'social_links' => $dir .'shortcodes/social_links.php',
			'navbar' => $dir .'shortcodes/navbar.php',
			'searchbar' => $dir .'shortcodes/searchbar.php',
			'login_form' => $dir .'shortcodes/login_form.php',
			'newsletter_form' => $dir .'shortcodes/newsletter_form.php',
			'image_swap' => $dir .'shortcodes/image_swap.php',
			'image_galleryslider'  => $dir .'shortcodes/image_galleryslider.php',
			'image_flexslider' => $dir .'shortcodes/image_flexslider.php',
			'image_carousel' => $dir .'shortcodes/image_carousel.php',
			'image_grid' => $dir .'shortcodes/image_grid.php',
			'recent_news' => $dir .'shortcodes/recent_news.php',
			'blog_grid' => $dir .'shortcodes/blog_grid.php',
			'blog_carousel' => $dir .'shortcodes/blog_carousel.php',
			'post_type_grid' => $dir .'shortcodes/post_type_grid.php',
			'post_type_archive' => $dir .'shortcodes/post_type_archive.php',
			'post_type_slider' => $dir .'shortcodes/post_type_slider.php',
			'testimonials_grid' => array(
				'file' => $dir .'shortcodes/testimonials_grid.php',
				'condition' => WPEX_TESTIMONIALS_IS_ACTIVE,
			),
			'testimonials_slider' => array(
				'file' => $dir .'shortcodes/testimonials_slider.php',
				'condition' => WPEX_TESTIMONIALS_IS_ACTIVE,
			),
			'portfolio_grid' => array(
				'file' => $dir .'shortcodes/portfolio_grid.php',
				'condition' => WPEX_PORTFOLIO_IS_ACTIVE,
			),
			'portfolio_carousel' => array(
				'file' => $dir .'shortcodes/portfolio_carousel.php',
				'condition' => WPEX_PORTFOLIO_IS_ACTIVE,
			),
			'staff_grid' => array( 
				'file' => $dir .'shortcodes/staff_grid.php',
				'condition' => WPEX_STAFF_IS_ACTIVE,
			),
			'staff_carousel' => array(
				'file' => $dir .'shortcodes/staff_carousel.php',
				'condition' => WPEX_STAFF_IS_ACTIVE,
			),
			'staff_social' => array(
				'file' => $dir .'shortcodes/staff_social.php',
				'condition' => WPEX_STAFF_IS_ACTIVE,
			),
			'woocommerce_carousel' => array(
				'file' => $dir .'shortcodes/woocommerce_carousel.php',
				'condition' => WPEX_WOOCOMMERCE_ACTIVE,
			),
			'terms_grid' => $dir .'shortcodes/terms_grid.php',
		);

		// Apply filters so you can easily modify the modules 100%
		$vcex_modules = apply_filters( 'vcex_builder_modules', $vcex_modules );

		// Load mapping files
		if ( ! empty( $vcex_modules ) ) {
			foreach ( $vcex_modules as $key => $val ) {
				if ( is_array( $val ) ) {
					$condition = isset( $val['condition'] ) ? $val['condition'] : true;
					if ( $condition ) {
						require_once( $val['file'] );
					}
				} else {
					require_once( $val );
				}
			}
		}

	}

	/**
	 * Load VC CSS
	 *
	 * @since 2.0.0
	 */
	public static function vc_css_ids( $css ) {
		$ids = wpex_global_obj( 'vc_css_ids' );
		if ( ! $ids ) {
			return $css;
		}
		foreach ( $ids as $id ) {
			if ( $id != wpex_global_obj( 'post_id' ) && $vc_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true ) ) {
				$css .='/*VC META CSS*/'. $vc_css;
			}
		}
		return $css;
	}

	/**
	 * Add textarea param that accepts html
	 *
	 * @since 2.0.0
	 */
	public static function vcex_textarea_html( $settings, $value ) {
		$rows = isset( $settings['vcex_rows'] ) ? $settings['vcex_rows'] : 5;
		return '<textarea name="'
			. $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea_raw_html '
			. $settings['param_name'] . ' textarea_safe" rows="'. $rows .'">'
			. vc_value_from_safe( $value ) . '</textarea>';
	}
	
}
$wpex_visual_composer_config = new WPEX_Visual_Composer();