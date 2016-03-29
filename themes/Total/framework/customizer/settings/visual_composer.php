<?php
/**
 * Customizer => Visual Composer
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// General
$this->sections['wpex_visual_composer'] = array(
	'title' => __( 'General', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'vc_row_bottom_margin',
			'default' => '40px',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Column Bottom Margin', 'wpex' ),
				'description' => __( 'Enter a default bottom margin for all Visual Composer columns to help speed up development.', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.wpex-vc-column-wrapper',
				'alter' => 'margin-bottom',
			),
		),
		array(
			'id' => 'vcex_text_separator_two_border_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Separator With Text Border Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => 'body .vc_text_separator_two span',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'vcex_text_tab_two_bottom_border',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Tabs Alternative 2 Border Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => 'body .wpb_tabs.tab-style-alternative-two .wpb_tabs_nav li.ui-tabs-active a',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'vcex_carousel_arrows',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Carousel Arrows Highlight Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.wpex-carousel .owl-prev',
					'.wpex-carousel .owl-next',
					'.wpex-carousel .owl-prev:hover',
					'.wpex-carousel .owl-next:hover',
				),
				'alter' => 'background-color',
			),
		),
		// Grid filter
		array(
			'id' => 'vcex_grid_filter_active_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Grid Filter: Active Link Color', 'wpex' ),
				'description' => __( 'Legacy Option', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.vcex-filter-links a.theme-button.minimal-border:hover',
					'.vcex-filter-links li.active a.theme-button.minimal-border',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'vcex_grid_filter_active_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Grid Filter: Active Link Background', 'wpex' ),
				'description' => __( 'Legacy Option', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.vcex-filter-links a.theme-button.minimal-border:hover',
					'.vcex-filter-links li.active a.theme-button.minimal-border',
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'vcex_grid_filter_active_border',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Grid Filter: Active Link Border', 'wpex' ),
				'description' => __( 'Legacy Option', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.vcex-filter-links a.theme-button.minimal-border:hover',
					'.vcex-filter-links li.active a.theme-button.minimal-border',
				),
				'alter' => 'border-color',
			),
		),
		// Recent news
		array(
			'id' => 'vcex_recent_news_date_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Recent News Date: Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.vcex-recent-news-date span.month',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'vcex_recent_news_date_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Recent News Date: Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.vcex-recent-news-date span.month',
				'alter' => 'color',
			),
		),
	),
);