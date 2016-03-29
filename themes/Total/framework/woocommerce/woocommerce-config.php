<?php
/**
 * Perform all main WooCommerce configurations for this theme
 *
 * @package Total WordPress Theme
 * @subpackage WooCommerce
 */

if ( ! class_exists( 'WPEX_WooCommerce_Config' ) ) {
	class WPEX_WooCommerce_Config {

		/**
		 * Main Class Constructor
		 *
		 * @since 2.0.0
		 */
		public function __construct() {

			// Include helper functions
			require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woocommerce-helpers.php' );

			// ACTIONS
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'woocommerce_enqueue_styles', array( $this, 'remove_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'remove_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_css' ) );
			add_action( 'woocommerce_after_single_product_summary', 'wpex_social_share', 11 );
			add_action( 'wpex_hook_header_inner', array( $this, 'cart_dropdown' ), 40 );
			add_action( 'wpex_hook_main_menu_bottom', array( $this, 'cart_dropdown' ) );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_out_of_stock_badge' ) );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'clear_summary_floats' ), 1 );
			add_action( 'wp_footer', array( $this, 'cart_overlay' ) );

			// FILTERS
			add_filter( 'wp_nav_menu_items', array( $this, 'menu_cart_icon' ) , 10, 2 );
			add_filter( 'add_to_cart_fragments', array( $this, 'menu_cart_icon_fragments' ) );
			add_filter( 'wpex_image_sizes', array( $this, 'add_image_sizes' ), 99 );
			add_filter( 'woocommerce_general_settings', array( $this, 'remove_general_settings' ) );
			add_filter( 'woocommerce_product_settings', array( $this, 'remove_product_settings' ) );
			add_filter( 'widgets_init', array( $this, 'register_woo_sidebar' ) );
			add_filter( 'wpex_get_sidebar', array( $this, 'display_woo_sidebar' ) );
			add_filter( 'wpex_title', array( $this, 'title_config' ) );
			add_filter( 'wpex_display_page_header', array( $this, 'display_page_header' ) );
			add_filter( 'wpex_post_layout_class', array( $this, 'layouts' ) );
			add_filter( 'woocommerce_show_page_title', '__return_false' );
			add_filter( 'woocommerce_sale_flash', array( $this, 'woocommerce_sale_flash' ), 10, 3 );
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_product_args' ) );
			add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );
			add_filter( 'woocommerce_continue_shopping_redirect', array( $this, 'continue_shopping_redirect' ) );
			add_filter( 'wpex_has_post_slider', array( $this, 'display_shop_slider' ) );
			add_filter( 'wpex_post_slider_shortcode', array( $this, 'shop_slider_shortcode' ) );
			add_filter( 'wpex_post_subheading', array( $this, 'alter_subheadings' ) );
			add_filter( 'wpex_has_term_description_above_loop', array( $this, 'term_description_above_loop' ) );
			add_filter( 'wpex_has_social_share', array( $this, 'post_social_share' ) );
			add_filter( 'post_class', array( $this, 'add_product_entry_classes' ) );
			add_filter( 'wpex_has_next_prev', array( $this, 'next_prev' ) );
			add_filter( 'wpex_accent_texts', array( $this, 'accent_texts' ) );
			add_filter( 'wpex_accent_borders', array( $this, 'accent_borders' ) );
			add_filter( 'wpex_accent_backgrounds', array( $this, 'accent_backgrounds' ) );
			add_filter( 'product_cat_class', array( $this, 'product_cat_class' ) );
			add_filter( 'woocommerce_cart_item_thumbnail', array( $this, 'cart_item_thumbnail' ), 10, 3 );
			add_filter( 'wpex_typography_settings', array( $this, 'typography_settings' ) );
			add_filter( 'wpex_customizer_sections', array( $this, 'customizer_settings' ) );
			
		}

		/**
		 * Runs on Init.
		 * You can't remove certain actions in the constructor because it's too early.
		 *
		 * @since 2.0.0
		 */
		public function init() {

			// Remove category descriptions, these are added already by the theme
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			
			// Alter cross-sells display
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			add_action( 'woocommerce_cart_collaterals', array( $this, 'cross_sell_display' ) );

			// Alter upsells display
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'upsell_display' ), 15 );

			// Alter WooCommerce category thumbnail
			remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
			add_action( 'woocommerce_before_subcategory_title', array( $this, 'subcategory_thumbnail' ), 10 );

			// Remove loop product thumbnail function and add our own that pulls from template parts
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_thumbnail' ), 10 );

			// Remove coupon from checkout
			//remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

			// Remove single meta
			if ( ! wpex_get_mod( 'woo_product_meta', true ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}

			// Remove upsells if set to 0
			if ( '0' == wpex_get_mod( 'woocommerce_upsells_count', '4' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'wpex_woocommerce_output_upsells', 15 );
			}

			// Remove related products if count is set to 0
			if ( '0' == wpex_get_mod( 'woocommerce_related_count', '4' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}

			// Remove crossells if set to 0
			if ( '0' == wpex_get_mod( 'woocommerce_cross_sells_count', '4' ) ) {
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			}

			// Remove result count if disabled
			if ( ! wpex_get_mod( 'woo_shop_result_count', true ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			// Remove orderby if disabled
			if ( ! wpex_get_mod( 'woo_shop_sort', true ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}

		}

		/**
		 * Adds image sizes for WooCommerce to the image sizes panel.
		 *
		 * @since 2.0.0
		 */
		public static function add_image_sizes( $sizes ) {
			$new_sizes  = array(
				'shop_catalog' => array(
					'label'    => __( 'Product Entry', 'wpex' ),
					'width'    => 'woo_entry_width',
					'height'   => 'woo_entry_height',
					'crop'     => 'woo_entry_image_crop',
				),
				'shop_single' => array(
					'label'   => __( 'Product Post', 'wpex' ),
					'width'   => 'woo_post_width',
					'height'  => 'woo_post_height',
					'crop'    => 'woo_post_image_crop',
				),
				'shop_thumbnail' => array(
					'label'     => __( 'Shop & Cart Thumbnail', 'wpex' ),
					'width'     => 'woo_shop_thumbnail_width',
					'height'    => 'woo_shop_thumbnail_height',
					'crop'      => 'woo_shop_thumbnail_crop',
				),
				'shop_category' => array(
					'label'     => __( 'Product Category Entry', 'wpex' ),
					'width'     => 'woo_cat_entry_width',
					'height'    => 'woo_cat_entry_height',
					'crop'      => 'woo_cat_entry_image_crop',
				),
			);
			$sizes = array_merge( $sizes, $new_sizes );
			return $sizes;
		}

		/**
		 * Remove general settings from Woo Admin panel.
		 *
		 * @since 2.0.0
		 */
		public static function remove_general_settings( $settings ) {
			$remove = array( 'woocommerce_enable_lightbox' );
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Remove product settings from Woo Admin panel.
		 *
		 * @since 2.0.0
		 */
		public static function remove_product_settings( $settings ) {
			$remove = array(
				'image_options',
				'shop_catalog_image_size',
				'shop_single_image_size',
				'shop_thumbnail_image_size',
				'woocommerce_enable_lightbox'
			);
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Register new WooCommerce sidebar.
		 *
		 * @since 2.0.0
		 */
		public static function register_woo_sidebar() {

			// Return if custom sidebar disabled
			if ( ! wpex_get_mod( 'woo_custom_sidebar', true ) ) {
				return;
			}

			// Get correct sidebar heading tag
			$heading_tag = wpex_get_mod( 'sidebar_headings', 'div' );
			$heading_tag = $heading_tag ? $heading_tag : 'div';

			// Register new woo_sidebar widget area
			register_sidebar( array (
				'name'          => __( 'WooCommerce Sidebar', 'wpex' ),
				'id'            => 'woo_sidebar',
				'before_widget' => '<div class="sidebar-box %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $heading_tag .' class="widget-title">',
				'after_title'   => '</'. $heading_tag .'>',
			) );

		}

		/**
		 * Display WooCommerce sidebar.
		 *
		 * @since 2.0.0
		 */
		public static function display_woo_sidebar( $sidebar ) {

			// Alter sidebar display to show woo_sidebar where needed
			if ( wpex_get_mod( 'woo_custom_sidebar', true ) && is_woocommerce() && is_active_sidebar( 'woo_sidebar' ) ) {
				$sidebar = 'woo_sidebar';
			}

			// Return correct sidebar
			return $sidebar;

		}

		/**
		 * Returns correct title for WooCommerce pages.
		 *
		 * @since 2.0.0
		 */
		public static function title_config( $title ) {

			// Shop title
			if ( is_shop() ) {
				$title = get_the_title( wc_get_page_id( 'shop' ) );
				$title = $title ? $title : $title = __( 'Shop', 'wpex' );
			}

			// Product title
			elseif ( is_product() ) {
				$title = wpex_get_mod( 'woo_shop_single_title', __( 'Shop', 'wpex' ) );
				$title = $title ? $title : __( 'Shop', 'wpex' );
			}

			// Return title
			return $title;

		}

		/**
		 * Hooks into the wpex_display_page_header and returns false if page header is disabled via the customizer.
		 *
		 * @since 2.0.0
		 */
		public static function display_page_header( $return ) {
			if ( is_shop() && ! wpex_get_mod( 'woo_shop_title', true ) ) {
				$return = false;
			}
			return $return;
		}

		/**
		 * Tweaks the post layouts for WooCommerce archives and single product posts.
		 *
		 * @since 2.0.0
		 */
		public static function layouts( $class ) {
			if ( wpex_is_woo_shop() ) {
				$class = wpex_get_mod( 'woo_shop_layout', 'full-width' );
			} elseif ( wpex_is_woo_tax() ) {
				$class = wpex_get_mod( 'woo_shop_layout', 'full-width' );
			} elseif ( wpex_is_woo_single() ) {
				$class = wpex_get_mod( 'woo_product_layout', 'full-width' );
			}
			return $class;
		}

		/**
		 * Remove WooCommerce styles not needed for this theme.
		 *
		 * @since 2.0.0
		 * @link  http://docs.woothemes.com/document/disable-the-default-stylesheet/
		 */
		public static function remove_styles( $enqueue_styles ) {
			unset( $enqueue_styles['woocommerce-layout'] );
			unset( $enqueue_styles['woocommerce_prettyPhoto_css'] );
			return $enqueue_styles;
		}

		/**
		 * Remove WooCommerce scripts.
		 *
		 *
		 * @since 2.0.0
		 */
		public static function remove_scripts() {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
		}

		/**
		 * Add Custom WooCommerce CSS.
		 *
		 * @since 2.0.0
		 */
		public static function add_custom_css() {

			// General WooCommerce Custom CSS
			wp_enqueue_style( 'wpex-woocommerce', WPEX_CSS_DIR_URI .'wpex-woocommerce.css' );

			// WooCommerce Responsiveness
			if ( wpex_global_obj( 'responsive' ) ) {
				wp_enqueue_style( 'wpex-woocommerce-responsive', WPEX_CSS_DIR_URI .'wpex-woocommerce-responsive.css', array( 'wpex-woocommerce' ) );
			}

		}

		/**
		 * Change onsale text.
		 *
		 * @since 2.0.0
		 */
		public static function woocommerce_sale_flash( $text, $post, $_product ) {
			return '<span class="onsale">'. __( 'Sale', 'wpex' ) .'</span>';
		}

		/**
		 * Returns correct posts per page for the shop
		 *
		 * @since 3.0.0
		 */
		public static function loop_shop_per_page() {
			return wpex_get_mod( 'woo_shop_posts_per_page', '12' );
		}

		/**
		 * Change products per row for the main shop.
		 *
		 * @since 2.0.0
		 */
		public static function loop_shop_columns() {
			return wpex_get_mod( 'woocommerce_shop_columns', '4' );
		}

		/**
		 * Change products per row for upsells.
		 *
		 * @since 2.0.0
		 */
		public static function upsell_display() {
			woocommerce_upsell_display(
				wpex_get_mod( 'woocommerce_upsells_count', '4' ),
				wpex_get_mod( 'woocommerce_upsells_columns', '4' )
			);
		}

		/**
		 * Change products per row for crossells.
		 *
		 * @since 2.0.0
		 */
		public static function cross_sell_display() {
			woocommerce_cross_sell_display(
				wpex_get_mod( 'woocommerce_cross_sells_count', '2' ),
				wpex_get_mod( 'woocommerce_cross_sells_columns', '2' )
			);
		}

		/**
		 * Change category thumbnail.
		 *
		 * @since 2.0.0
		 */
		public static function subcategory_thumbnail( $category ) {

			// Get attachment id
			$attachment = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

			// Return thumbnail if attachment is defined
			if ( $attachment ) {

				wpex_post_thumbnail( array(
					'attachment' => $attachment,
					'size'       => 'shop_category',
					'alt'        => wpex_get_esc_title(),
				) );

			}

			// Display placeholder
			else {

				echo '<img src="'. wc_placeholder_img_src() .'" alt="'. __( 'Placeholder Image', 'wpex' ) .'" />';

			}

		}

		/**
		 * Alter the related product arguments.
		 *
		 * @since 2.0.0
		 */
		public static function related_product_args() {
			global $product, $orderby, $related;
			return array(
				'posts_per_page' => wpex_get_mod( 'woocommerce_related_count', '4' ),
				'columns'        => wpex_get_mod( 'woocommerce_related_columns', '4' ),
			);
		}

		/**
		 * Adds an opening div "product-inner" around product entries.
		 *
		 * @since 2.0.0
		 */
		public static function add_shop_loop_item_inner_div() {
			echo '<div class="product-inner clr">';
		}

		/**
		 * Closes the "product-inner" div around product entries.
		 *
		 * @since 2.0.0
		 */
		public static function close_shop_loop_item_inner_div() {
			echo '</div><!-- .product-inner .clr -->';
		}

		/**
		 * Clear floats after single product summary.
		 *
		 * @since 2.0.0
		 */
		public static function clear_summary_floats() {
			echo '<div class="wpex-clear-after-summary wpex-clear"></div>';
		}

		/**
		 * Adds an out of stock tag to the products.
		 *
		 * @since 2.0.0
		 */
		public static function add_shop_loop_item_out_of_stock_badge() {
			if ( function_exists( 'wpex_woo_product_instock' ) && ! wpex_woo_product_instock() ) { ?>
				<div class="outofstock-badge">
					<?php echo apply_filters( 'wpex_woo_outofstock_text', __( 'Out of Stock', 'wpex' ) ); ?>
				</div><!-- .product-entry-out-of-stock-badge -->
			<?php }
		}

		/**
		 * Returns our product thumbnail from our template parts based on selected style in theme mods.
		 *
		 * @since 2.0.0
		 */
		public static function loop_product_thumbnail() {
			if ( function_exists( 'wc_get_template' ) ) {
				$style = wpex_get_mod( 'woo_product_entry_style', 'image-swap' );
				wc_get_template(  'loop/thumbnail/'. $style .'.php' );
			}
		}

		/**
		 * Tweaks pagination arguments.
		 *
		 * @since 2.0.0
		 */
		public static function pagination_args( $args ) {
			$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
			$args['next_text'] = '<i class="fa fa-angle-right"></i>';
			return $args;
		}

		/**
		 * Alter continue shoping URL.
		 *
		 * @since 2.0.0
		 */
		public static function continue_shopping_redirect( $return_to ) {
			$shop_id = woocommerce_get_page_id( 'shop' );
			if ( function_exists( 'icl_object_id' ) ) {
				$shop_id = icl_object_id( $shop_id, 'page' );
			}
			if ( $shop_id ) {
				$return_to = get_permalink( $shop_id );
			}
			return $return_to;
		}

		/**
		 * Hooks into the wpex_has_post_slider function and returns true for the shop if
		 * a slider is defined via the customizer.
		 *
		 * @since 2.0.0
		 */
		public static function display_shop_slider( $return ) {
			if ( is_shop() && wpex_get_mod( 'woo_shop_slider' ) ) {
				$return = true;
			}
			return $return;
		}

		/**
		 * The shop post slider
		 *
		 * @since 2.0.0
		 */
		public static function shop_slider_shortcode( $slider ) {
			if ( is_shop() && ! $slider ) {
				$slider = wpex_get_mod( 'woo_shop_slider' );
			}
			return $slider;
		}

		/**
		 * Alters subheading for the shop.
		 *
		 * @since 2.0.0
		 */
		public static function alter_subheadings( $subheading ) {

			// Woo Taxonomies
			if ( wpex_is_woo_tax() ) {
				if ( 'under_title' == wpex_get_mod( 'woo_category_description_position', 'under_title' ) ) {
					$subheading = term_description();
				} else {
					$subheading = NULL;
				}
			}

			// Orderby, search...etc
			if ( is_shop() ) {
				if ( ! empty( $_GET['s'] ) ) {
					$subheading = __( 'Search results for:', 'wpex' ) .' <span>&quot;'. $_GET['s'] .'&quot;</span>';
				}
			}

			// Return subheading
			return $subheading;

		}

		/**
		 * Alters subheading for the shop.
		 *
		 * @since 2.0.0
		 */
		public static function term_description_above_loop( $return ) {

			// Check if enabled
			if ( wpex_is_woo_tax() && 'above_loop' == wpex_get_mod( 'woo_category_description_position' ) ) {
				$return = true;
			}

			// Return bool
			return $return;

		}

		/**
		 * Enable post social share if enabled.
		 *
		 * @since 2.0.0
		 */
		public static function post_social_share( $return ) {
			if ( is_singular( 'product' ) && wpex_get_mod( 'social_share_woo', false ) ) {
				$return = true;
			}
			return $return;
		}

		/**
		 * Add classes to WooCommerce product entries.
		 *
		 * @since 2.0.0
		 */
		public static function add_product_entry_classes( $classes ) {
			global $product, $woocommerce_loop;
			if ( $product && $woocommerce_loop ) {
				$classes[] = 'col';
				$classes[] = wpex_grid_class( $woocommerce_loop['columns'] );
			}
			return $classes;
		}

		/**
		 * Disables the next/previous links if disabled via the customizer.
		 *
		 * @since 2.0.0
		 */
		public static function next_prev( $return ) {
			if ( is_woocommerce() && is_singular( 'product' ) && ! wpex_get_mod( 'woo_next_prev', true ) ) {
				$return = false;
			}
			return $return;
		}

		/**
		 * Adds border accents for WooCommerce styles.
		 *
		 * @since 2.1.0
		 */
		public static function accent_texts( $texts ) {
			return array_merge( array(
				'.woocommerce ul.products li.product h3',
				'.woocommerce ul.products li.product h3 mark',
			), $texts );
		}

		/**
		 * Adds border accents for WooCommerce styles.
		 *
		 * @since 2.1.0
		 */
		public static function accent_borders( $borders ) {
			return array_merge( array(
				'#current-shop-items-dropdown' => array( 'top' ),
				'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a' => array( 'bottom' ),
			), $borders );
		}

		/**
		 * Adds border accents for WooCommerce styles.
		 *
		 * @since 2.1.0
		 */
		public static function accent_backgrounds( $backgrounds ) {
			return array_merge( array(
				'.woocommerce #respond input#submit',
				'.woocommerce a.button',
				'.woocommerce button.button',
				'.woocommerce input.button',
				'.woocommerce ul.products li.product .added_to_cart',
				'.woocommerce #respond input#submit.alt',
				'.woocommerce a.button.alt',
				'.woocommerce button.button.alt',
				'.woocommerce input.button.alt',
				'.woocommerce #respond input#submit:hover',
				'.woocommerce a.button:hover',
				'.woocommerce button.button:hover',
				'.woocommerce input.button:hover',
				'.woocommerce ul.products li.product .added_to_cart:hover',
				'.woocommerce #respond input#submit.alt:hover',
				'.woocommerce a.button.alt:hover',
				'.woocommerce button.button.alt:hover',
				'.woocommerce input.button.alt:hover',
			), $backgrounds );
		}

		/**
		 * Alter WooCommerce category classes
		 *
		 * @since 3.0.0
		 */
		public static function product_cat_class( $classes ) {
			global $woocommerce_loop;
			$classes[] = 'col';
			$classes[] = wpex_grid_class( $woocommerce_loop['columns'] );
			return $classes;
		}

		/**
		 * Alter the cart item thumbnail size
		 *
		 * @since 3.0.0
		 */
		public static function cart_item_thumbnail( $thumb, $cart_item, $cart_item_key ) {
			if ( ! empty( $cart_item['variation_id'] ) ) {
				$post_id = $cart_item['variation_id'];
			} elseif ( isset( $cart_item['product_id'] ) ) {
				$post_id = $cart_item['product_id'];
			} else {
				$post_id = '';
			}
			if ( has_post_thumbnail( $post_id ) ) {
				return wpex_get_post_thumbnail( array(
					'size'       => 'shop_thumbnail',
					'attachment' => get_post_thumbnail_id( $post_id ),
				));
			} else {
				return wc_placeholder_img();
			}
		}

		/**
		 * Add WooCommerce cart dropdown to the header
		 *
		 * @since 3.0.0
		 */
		public static function cart_dropdown() {

			// Return if style not set to dropdown
			if ( 'drop_down' != wpex_global_obj( 'menu_cart_style' ) ) {
				return;
			}

			// Should we get the template part?
			$get = false;

			// Get current header style
			$header_style = wpex_global_obj( 'header_style' );

			// Header Inner Hook
			if ( 'wpex_hook_header_inner' == current_filter() ) {
				if ( 'one' == $header_style ) {
					$get = true;
				}
			}
			
			// Menu bottom hook
			elseif ( 'wpex_hook_main_menu_bottom' == current_filter() ) {
				if ( 'two' == $header_style
					|| 'three' == $header_style
					|| 'four' == $header_style
					|| 'five' == $header_style ) {
					$get = true;
				}
			}

			// Get template file
			if ( $get ) {
				get_template_part( 'partials/cart/cart-dropdown' );
			}

		}

		/**
		 * Adds Cart overlay code to footer
		 *
		 * @since 3.0.0
		 */
		public static function cart_overlay() {
			if ( 'overlay' == wpex_global_obj( 'menu_cart_style' ) ) {
				get_template_part( 'partials/cart/cart-overlay' );
			}
		}

		/**
		 * Adds cart icon to menu
		 *
		 * @since 3.0.0
		 */
		public static function menu_cart_icon( $items, $args ) {

			// Only used for the main menu
			if ( 'main_menu' != $args->theme_location ) {
				return $items;
			}

			// Get style
			$style = wpex_global_obj( 'menu_cart_style' );

			// Return items if no style
			if ( ! $style ) {
				return $items;
			}

			// Toggle class
			$toggle_class = 'toggle-cart-widget';

			// Define classes to add to li element
			$classes = array( 'woo-menu-icon', 'wpex-menu-extra' );
			
			// Add style class
			$classes[] = 'wcmenucart-toggle-'. $style;

			// Prevent clicking on cart and checkout
			if ( 'custom-link' != $style && ( is_cart() || is_checkout() ) ) {
				$classes[] = 'nav-no-click';
			}

			// Add toggle class
			else {
				$classes[] = $toggle_class;
			}

			// Turn classes into string
			$classes = implode( ' ', $classes );
			
			// Add cart link to menu items
			$items .= '<li class="'. $classes .'">' . wpex_wcmenucart_menu_item() .'</li>';
			
			// Return menu items
			return $items;
		}

		/**
		 * Add menu cart item to the Woo fragments so it updates with AJAX
		 *
		 * @since 3.0.0
		 */
		public static function menu_cart_icon_fragments( $fragments ) {
			$fragments['.wcmenucart'] = wpex_wcmenucart_menu_item();
			return $fragments;
		}

		/**
		 * Add typography options for the WooCommerce product title
		 *
		 * @since 3.0.0
		 */
		public static function typography_settings( $settings ) {
			$settings['woo_product_title'] = array(
				'label' => __( 'WooCommerce Product Title', 'wpex' ),
				'target' => '.woocommerce div.product .product_title',
			);
			return $settings;
		}

		/**
		 * Adds customizer settings
		 *
		 * @since 3.0.8
		 */
		public function customizer_settings( $sections ) {

			// Social share
			if ( isset( $sections['wpex_social_sharing']['settings'] ) ) {
				$sections['wpex_social_sharing']['settings'][] = array(
					'id' => 'social_share_woo',
					'default' => false,
					'control' => array (
						'label' => 'WooCommerce',
						'type' => 'checkbox',
						'active_callback' => 'wpex_has_social_share_sites',
					),
				);
			}
				
			// Return sections
			return $sections;

		}
		

	}
}
$wpex_woocommerce_config = new WPEX_WooCommerce_Config();