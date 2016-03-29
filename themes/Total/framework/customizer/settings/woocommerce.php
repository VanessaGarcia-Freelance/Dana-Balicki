<?php
/**
 * Customizer => WooCommerce
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_woocommerce_general'] = array(
	'title' => __( 'General', 'wpex' ),
	'panel' => 'wpex_woocommerce',
	'settings' => array(
		array(
			'id' => 'woo_custom_sidebar',
			'default' => true,
			'control' => array (
				'label' => __( 'Custom WooCommerce Sidebar', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'woo_menu_icon',
			'default' => true,
			'control' => array (
				'label' => __( 'Menu Cart', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
			),
		),
		array(
			'id' => 'woo_menu_icon_display',
			'default' => 'icon_count',
			'control' => array (
				'label' => __( 'Menu Cart: Display', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'icon' => __( 'Icon','wpex' ),
					'icon_total' => __( 'Icon And Cart Total','wpex' ),
					'icon_count' => __( 'Icon And Cart Count','wpex' ),
				),
				'desc' => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
			),
		),
		array(
			'id' => 'woo_menu_icon_style',
			'default' => 'drop_down',
			'control' => array (
				'label' => __( 'Menu Cart: Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'drop_down' => __( 'Drop-Down','wpex' ),
					'overlay' => __( 'Open Cart Overlay','wpex' ),
					'store' => __( 'Go To Store','wpex' ),
					'custom-link' => __( 'Custom Link','wpex' ),
				),
				'desc' => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
			),
		),
		array(
			'id' => 'woo_menu_icon_custom_link',
			'control' => array (
				'label' => __( 'Menu Cart: Custom Link', 'wpex' ),
				'type' => 'text',
			),
		),
	)
);

// Archives
$this->sections['wpex_woocommerce_archives'] = array(
	'title' => __( 'Archives', 'wpex' ),
	'panel' => 'wpex_woocommerce',
	'settings' => array(
		array(
			'id' => 'woo_shop_title',
			'default' => 'on',
			'control' => array (
				'label' => __( 'Shop Title', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'woo_shop_slider',
			'control' => array (
				'label' => __( 'Shop Slider', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'woo_shop_posts_per_page',
			'default' => '12',
			'control' => array (
				'label' => __( 'Shop Posts Per Page', 'wpex' ),
				'type' => 'text',
				'desc' => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
			),
		),
		array(
			'id' => 'woo_shop_layout',
			'default' => 'full-width',
			'control' => array (
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'full-width' => __( 'No Sidebar','wpex' ),
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'woocommerce_shop_columns',
			'default' => '4',
			'control' => array (
				'label' => __( 'Shop Columns', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_grid_columns(),

			),
		),
		array(
			'id' => 'woo_category_description_position',
			'default' => 'under_title',
			'control' => array (
				'label' => __( 'Category Description Position', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'under_title' => __( 'Under Title', 'wpex' ),
					'above_loop' => __( 'Above Loop', 'wpex' ),
				),

			),
		),
		array(
			'id' => 'woo_shop_sort',
			'default' => 'on',
			'control' => array (
				'label' => __( 'Shop Sort', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
			),
		),
		array(
			'id' => 'woo_shop_result_count',
			'default' => 'on',
			'control' => array (
				'label' => __( 'Shop Result Count', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
			),
		),
		array(
			'id' => 'woo_product_entry_style',
			'default' => 'image-swap',
			'control' => array (
				'label' => __( 'Product Entry Media', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'featured-image' => __( 'Featured Image','wpex' ),
					'image-swap' => __( 'Image Swap','wpex' ),
					'gallery-slider' => __( 'Gallery Slider','wpex' ),
				),
			),
		),
	)
);

// Single
$this->sections['wpex_woocommerce_single'] = array(
	'title' => __( 'Single', 'wpex' ),
	'panel' => 'wpex_woocommerce',
	'settings' => array(
		array(
			'id' => 'woo_shop_single_title',
			'default' => __( 'Store', 'wpex' ),
			'control' => array (
				'label' => __( 'Page Header Title', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'woo_product_layout',
			'default' => 'full-width',
			'control' => array (
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'full-width' => __( 'No Sidebar','wpex' ),
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'woocommerce_upsells_count',
			'default' => '4',
			'control' => array (
				'label' => __( 'Up-Sells Count', 'wpex' ), 
				'type' => 'text',
			),
		),
		array(
			'id' => 'woocommerce_upsells_columns',
			'default' => '4',
			'control' => array (
				'label' => __( 'Up-Sells Columns', 'wpex' ), 
				'type' => 'select',
				'choices' => wpex_grid_columns(),
			),
		),
		array(
			'id' => 'woocommerce_related_count',
			'default' => '4',
			'control' => array (
				'label' => __( 'Related Items Count', 'wpex' ), 
				'type' => 'text',
			),
		),
		array(
			'id' => 'woocommerce_related_columns',
			'default' => '4',
			'control' => array (
				'label' => __( 'Related Products Columns', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_grid_columns(),
			),
		),
		array(
			'id' => 'woo_product_meta',
			'default' => 'on',
			'control' => array (
				'label' => __( 'Product Meta', 'wpex' ),
				'type' => 'checkbox',
				'desc' => __( 'You must save your options and refresh your live site to preview changes to this setting.', 'wpex' ),
			),
		),
		array(
			'id' => 'woo_next_prev',
			'default' => 'on',
			'control' => array (
				'label' => __( 'Next & Previous Links', 'wpex' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Cart
$this->sections['wpex_woocommerce_cart'] = array(
	'title' => __( 'Cart', 'wpex' ),
	'panel' => 'wpex_woocommerce',
	'settings' => array(
		array(
			'id' => 'woocommerce_cross_sells_count',
			'default' => '2',
			'control' => array (
				'label' => __( 'Cross-Sells Count', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'woocommerce_cross_sells_columns',
			'default' => '2',
			'control' => array (
				'label' => __( 'Cross-Sells Columns', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_grid_columns(),
			),
		),
	),
);


// Styling
$this->sections['wpex_woocommerce_styling'] = array(
	'title' => __( 'Styling', 'wpex' ),
	'panel' => 'wpex_woocommerce',
	'settings' => array(
		array(
			'id' => 'onsale_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'On Sale Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.woocommerce span.onsale',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'onsale_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'On Sale Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => '.woocommerce span.onsale',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'woo_product_title_link_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Product Entry Title Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce ul.products li.product h3',
					'.woocommerce ul.products li.product h3 mark',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'woo_product_title_link_color_hover',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Product Entry Title Color: Hover', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce ul.products li.product h3:hover',
					'.woocommerce ul.products li.product h3:hover mark',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'woo_price_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Global Price Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.price',
					'.amount',
					'.woocommerce ul.products li.product .price .amount',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'woo_product_entry_price_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Product Entry Price Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce ul.products li.product .price',
					'.woocommerce ul.products li.product .price .amount',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'woo_single_price_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Single Product Price Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce .summary .price',
					'.woocommerce .summary .amount',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'woo_stars_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Star Ratings Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce p.stars a',
					'.woocommerce .star-rating',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'woo_single_tabs_active_border_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Product Tabs Active Border Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a',
				),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'woo_button_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Woo Button Background', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce input#submit',
					'.woocommerce .button',
					'a.wc-forward',
				),
				'alter' => 'background',
				'important' => true,
			),
		),
		array(
			'id' => 'woo_button_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Woo Button Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce input#submit',
					'.woocommerce .button',
					'a.wc-forward',
				),
				'alter' => 'color',
				'important' => true,
			),
		),
		array(
			'id' => 'woo_button_border_radius',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Woo Button Border Radius', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce input#submit',
					'.woocommerce .button',
					'a.wc-forward',
				),
				'alter' => 'border-radius',
				'important' => true,
			),
		),
		array(
			'id' => 'woo_button_bg_hover',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Woo Button Hover: Background', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce input#submit:hover',
					'.woocommerce .button:hover',
					'a.wc-forward:hover',
				),
				'alter' => 'background',
				'important' => true,
			),
		),
		array(
			'id' => 'woo_button_color_hover',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Woo Button Hover: Color', 'wpex' )
			),
			'inline_css' => array(
				'target' => array(
					'.woocommerce input#submit:hover',
					'.woocommerce .button:hover',
					'a.wc-forward:hover',
				),
				'alter' => 'color',
				'important' => true,
			),
		),
	),
);