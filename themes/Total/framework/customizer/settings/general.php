<?php
/**
 * Customizer => General Panel
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Accent Colors
$this->sections['wpex_accent_colors'] = array(
	'title' => __( 'Accent Colors', 'wpex' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'accent_color',
			'default' => '#3b86b0',
			'control' => array (
				'label' => __( 'Accent Color', 'wpex' ),
				'type' => 'color',
			),
		),
	)
);

// Background
$patterns_url = get_template_directory_uri() .'/images/patterns/';
$this->sections['wpex_background_background'] = array(
	'title'  => __( 'Site Background', 'wpex' ),
	'panel'  => 'wpex_general',
	'desc' => __( 'Here you can alter the global site background. It is highly recommended that you first set the site layout to "Boxed" under the Layout options.', 'wpex' ),
	'settings' => array(
		array(
			'id' => 'background_color',
			'control' => array (
				'label' => __( 'Background Color', 'wpex' ),
				'type' => 'color',
			),
		),
		array(
			'id' => 'background_image',
			'control' => array (
				'label' => __( 'Custom Background Image', 'wpex' ),
				'type' => 'image',
				'active_callback' => 'wpex_customizer_hasnt_background_pattern',
			),
		),
		array(
			'id' => 'background_style',
			'default' => 'stretched',
			'control' => array (
				'label' => __( 'Background Image Style', 'wpex' ),
				'type'  => 'image',
				'type'  => 'select',
				'active_callback' => 'wpex_customizer_has_background_image',
				'choices' => array(
					'stretched' => _x( 'Stretched', 'Background Style', 'wpex' ),
					'repeat' => _x( 'Repeat', 'Background Style', 'wpex' ),
					'fixed'  => _x( 'Center Fixed', 'Background Style', 'wpex' ),
					'repeat-x' => _x( 'Repeat-x', 'Background Style', 'wpex' ),
					'repeat-y' => _x( 'Repeat-y', 'Background Style', 'wpex' ),
					'repeat-y' => _x( 'Repeat-y', 'Background Style', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'background_pattern',
			'control' => array (
				'label' => __( 'Background Pattern', 'wpex' ),
				'type'  => 'image',
				'type'  => 'select',
				'active_callback' => 'wpex_customizer_hasnt_background_image',
				'choices' => array(
					'' => __( 'None', 'wpex' ),
					$patterns_url .'dark_wood.png'  => __( 'Dark Wood', 'wpex' ),
					$patterns_url .'diagmonds.png'  => __( 'Diamonds', 'wpex' ),
					$patterns_url .'grilled.png' => __( 'Grilled', 'wpex' ),
					$patterns_url .'lined_paper.png' => __( 'Lined Paper', 'wpex' ),
					$patterns_url .'old_wall.png' => __( 'Old Wall', 'wpex' ),
					$patterns_url .'ricepaper2.png' => __( 'Rice Paper', 'wpex' ),
					$patterns_url .'tree_bark.png'  => __( 'Tree Bark', 'wpex' ),
					$patterns_url .'triangular.png' => __( 'Triangular', 'wpex' ),
					$patterns_url .'white_plaster.png' => __( 'White Plaster', 'wpex' ),
					$patterns_url .'wild_flowers.png' => __( 'Wild Flowers', 'wpex' ),
					$patterns_url .'wood_pattern.png' => __( 'Wood Pattern', 'wpex' ),
				),
			),
		),
	),
);

// Social Sharing Section
$this->sections['wpex_social_sharing'] = array(
	'title'  => __( 'Social Sharing', 'wpex' ),
	'panel'  => 'wpex_general',
	'settings' => array(
		array(
			'id'  => 'social_share_sites',
			'default' => array( 'twitter', 'facebook', 'google_plus', 'pinterest' ),
			'control' => array (
				'label'  => __( 'Sites', 'wpex' ),
				'type' => 'multiple-select',
				'object' => 'WPEX_Customize_Multicheck_Control',
				'choices' => array(
					'twitter'  => __( 'Twitter', 'wpex' ),
					'facebook' => __( 'Facebook', 'wpex' ),
					'google_plus' => __( 'Google Plus', 'wpex' ),
					'pinterest' => __( 'Pinterest', 'wpex' ),
					'linkedin' => __( 'LinkedIn', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'social_share_position',
			'default' => '',
			'control' => array (
				'label' => __( 'Position', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'horizontal' => __( 'Horizontal', 'wpex' ),
					'vertical' => __( 'Vertical', 'wpex' ),
				),
				'active_callback' => 'wpex_has_social_share_sites',
			),
		),
		array(
			'id' => 'social_share_heading_enable',
			'default' => true,
			'control' => array (
				'label' => __( 'Enable Heading', 'wpex' ),
				'type'  => 'checkbox',
				'active_callback' => 'wpex_social_sharing_supports_heading',
			),
		),
		array(
			'id' => 'social_share_heading',
			'default' => __( 'Please Share This', 'wpex' ),
			'control' => array (
				'label' => __( 'Heading on Posts', 'wpex' ),
				'type'  => 'text',
				'active_callback' => 'wpex_social_sharing_supports_heading',
			),
		),
		array(
			'id' => 'social_share_style',
			'default' => 'flat',
			'control' => array (
				'label' => __( 'Style', 'wpex' ),
				'type'  => 'select',
				'choices' => array(
					'flat' => _x( 'Flat', 'Social Share Style', 'wpex' ),
					'minimal' => _x( 'Minimal', 'Social Share Style', 'wpex' ),
					'three-d' => _x( '3D', 'Social Share Style', 'wpex' ),
				),
				'active_callback' => 'wpex_has_social_share_sites',
			),
		),
		array(
			'id' => 'social_share_pages',
			'default' => false,
			'control' => array (
				'label' => __( 'Pages', 'wpex' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_has_social_share_sites',
			),
		),
	)
);

// Lightbox
$this->sections['wpex_lightbox'] = array(
	'title'  => __( 'Lightbox', 'wpex' ),
	'panel'  => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'lightbox_skin',
			'control' => array (
				'label' => __( 'Skin', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_ilightbox_skins(),
			),
		),
		array(
			'id' => 'lightbox_thumbnails',
			'default' => true,
			'control' => array (
				'label' => __( 'Gallery Thumbnails', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'lightbox_arrows',
			'default' => true,
			'control' => array (
				'label' => __( 'Gallery Arrows', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'lightbox_mousewheel',
			'default' => false,
			'control' => array (
				'label' => __( 'Gallery Mousewheel Scroll', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'lightbox_titles',
			'default' => true,
			'control' => array (
				'label' => __( 'Titles', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'lightbox_fullscreen',
			'default' => true,
			'control' => array (
				'label' => __( 'Fullscreen Button', 'wpex' ),
				'type' => 'checkbox',
			),
		),
	)
);

// Breadcrumbs
$this->sections['wpex_breadcrumbs'] = array(
	'title' => __( 'Breadcrumbs', 'wpex' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'breadcrumbs',
			'default' => true,
			'control' => array (
				'label' => __( 'Breadcrumbs', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'breadcrumbs_position',
			'control' => array (
				'label' => __( 'Position', 'wpex' ),
				'type'  => 'select',
				'choices' => array(
					''  => __( 'Absolute Right', 'wpex' ),
					'under-title' => __( 'Under Title', 'wpex' ),
				),
				'active_callback' => 'wpex_customizer_has_breadcrumbs',
			),
		),
		array(
			'id' => 'breadcrumbs_home_title',
			'transport' => 'refresh',
			'control' => array (
				'label' => __( 'Custom Home Title', 'wpex' ),
				'type'  => 'text',
				'active_callback' => 'wpex_customizer_enabled_not_yoast',
			),
		),
		array(
			'id' => 'breadcrumbs_title_trim',
			'control' => array (
				'label' => __( 'Title Trim Length', 'wpex' ),
				'type'  => 'text',
				'desc'  => __( 'Enter the max number of words to display for your breadcrumbs post title', 'wpex' ),
				'active_callback' => 'wpex_customizer_enabled_not_yoast',
			),
		),
		array(
			'id' => 'breadcrumbs_text_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Text Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'breadcrumbs_seperator_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Separator Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs .sep',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'breadcrumbs_link_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Link Color', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'breadcrumbs_link_color_hover',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Link Color: Hover', 'wpex' ),
				'active_callback' => 'wpex_customizer_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs a:hover',
				'alter' => 'color',
			),
		),
	),
);

// Page Title
$this->sections['wpex_page_header'] = array(
	'title' => __( 'Page Title', 'wpex' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'page_header_style',
			'default' => '',
			'control' => array (
				'label'  => __( 'Page Header Style', 'wpex' ),
				'type' => 'image',
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default','wpex' ),
					'centered' => __( 'Centered', 'wpex' ),
					'centered-minimal' => __( 'Centered Minimal', 'wpex' ),
					'hidden' => __( 'Hidden', 'wpex' ),
				),
			),
		),
		array(
			'id' => 'page_header_top_padding',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Top Padding', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'padding-top',
			),
		),
		array(
			'id' => 'page_header_bottom_padding',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Bottom Padding', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'padding-bottom',
			),
		),
		array(
			'id' => 'page_header_background',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'page_header_title_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Text Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods .page-header-title',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'page_header_top_border',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Top Border Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'border-top-color',
			),
		),
		array(
			'id' => 'page_header_bottom_border',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Bottom Border Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'border-bottom-color',
			),
		),
	),
);

// Pages
$this->sections['wpex_pages'] = array(
	'title'  => __( 'Pages', 'wpex' ),
	'panel'  => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'page_single_layout',
			'default' => true,
			'default' => '',
			'control' => array (
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
					'full-width' => __( 'No Sidebar','wpex' ),
					'full-screen' => __( 'Full Screen','wpex' ),
				),
			),
		),
		array(
			'id' => 'pages_custom_sidebar',
			'default' => true,
			'control' => array (
				'label' => __( 'Custom Sidebar', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'page_comments',
			'control' => array (
				'label' => __( 'Comments on Pages', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'page_featured_image',
			'control' => array (
				'label' => __( 'Display Featured Images', 'wpex' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Search
$this->sections['wpex_search'] = array(
	'title'  => __( 'Search', 'wpex' ),
	'panel'  => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'search_style',
			'default' => 'default',
			'transport' => 'postMessage',
			'control' => array (
				'label' => __( 'Style', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'default' => __( 'Left Thumbnail', 'wpex' ),
					'blog' => __( 'Inherit From Blog','wpex' ),
				),
			),
		),
		array(
			'id' => 'search_layout',
			'transport' => 'postMessage',
			'control' => array (
				'label' => __( 'Layout', 'wpex' ),
				'type' => 'select',
				'choices' => array(
					'' => __( 'Default', 'wpex' ),
					'right-sidebar' => __( 'Right Sidebar','wpex' ),
					'left-sidebar' => __( 'Left Sidebar','wpex' ),
					'full-width' => __( 'No Sidebar','wpex' ),
				),
			),
		),
		array(
			'id' => 'search_posts_per_page',
			'default' => '10',
			'transport' => 'postMessage',
			'control' => array (
				'label' => __( 'Posts Per Page', 'wpex' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'search_custom_sidebar',
			'default' => true,
			'transport' => 'postMessage',
			'control' => array (
				'label' => __( 'Custom Sidebar', 'wpex' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Scroll to top
$this->sections['wpex_scroll_top'] = array(
	'title' => __( 'Scroll To Top', 'wpex' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'scroll_top',
			'default' => true,
			'active_callback' => 'wpex_has_scroll_top_button',
			'control' => array (
				'label' => __( 'Scroll Up Button', 'wpex' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'scroll_top_arrow',
			'default' => 'chevron-up',
			'active_callback' => 'wpex_has_scroll_top_button',
			'control' => array (
				'label' => __( 'Arrow', 'wpex' ),
				'type' => 'select',
				'choices' => wpex_get_awesome_icons( 'up_arrows' ),
			),
		),
		array(
			'id' => 'scroll_top_size',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Button Size', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'sanitize' => 'px',
				'alter' => array(
					'width',
					'height',
					'line-height',
				),
			),
		),
		array(
			'id' => 'scroll_top_line_height',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Button Line Height', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'sanitize' => 'px',
				'alter' => array(
					'line-height',
				),
			),
		),
		array(
			'id' => 'scroll_top_icon_size',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Icon Size', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'font-size',
			),
		),
		array(
			'id' => 'scroll_top_border_radius',
			'control' => array(
				'type' => 'text',
				'label' => __( 'Border Radius', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'border-radius',
			),
		),
		array(
			'id' => 'scroll_top_color',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'scroll_top_color_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Color: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'scroll_top_bg',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'scroll_top_bg_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Background: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top:hover',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'scroll_top_border',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Border', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'scroll_top_border_hover',
			'control' => array(
				'type' => 'color',
				'label' => __( 'Border: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top:hover',
				'alter' => 'border-color',
			),
		),
	),
);

// Forms
$this->sections['wpex_general_forms'] = array(
	'title' => __( 'Forms', 'wpex' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'input_padding',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Padding', 'wpex' ),
				'description' => __( 'Format: top right bottom left.', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.entry input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea',
				),
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'input_border_radius',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Border Radius', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.entry input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea',
				),
				'alter' => 'border-radius',
			),
		),
		array(
			'id' => 'input_font_size',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Font-Size', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.entry input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea',
				),
				'alter' => 'font-size',
			),
		),
		array(
			'id' => 'input_background',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.entry input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea',
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'input_border',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Border', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.entry input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea',
				),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'input_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.entry input[type="text"],.site-content input[type="password"],.site-content input[type="email"],.site-content input[type="tel"],.site-content input[type="url"],.site-content input[type="search"],.site-content textarea',
				),
				'alter' => 'color',
			),
		),
	),
);


// Links & Buttons
$this->sections['wpex_general_links_buttons'] = array(
	'title' => __( 'Links & Buttons', 'wpex' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'link_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Links Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => 'a, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .entry-title a:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'link_color_hover',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Links Color: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => 'a:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'theme_button_padding',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Theme Button Padding', 'wpex' ),
				'description' => __( 'Format: top right bottom left.', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.theme-button,input[type="submit"],button',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'theme_button_border_radius',
			'control' => array (
				'type' => 'text',
				'label' => __( 'Theme Button Border Radius', 'wpex' ),
			),
			'inline_css' => array(
				'target' => '.theme-button,input[type="submit"],button',
				'alter' => 'border-radius',
			),
		),
		array(
			'id' => 'theme_button_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Theme Button Color', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button,input[type="submit"],button',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'theme_button_hover_color',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Theme Button Color: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button:hover,input[type="submit"]:hover,button:hover',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'theme_button_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Theme Button Background', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button,input[type="submit"],button',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'background',
			),
		),
		array(
			'id' => 'theme_button_hover_bg',
			'control' => array (
				'type' => 'color',
				'label' => __( 'Theme Button Background: Hover', 'wpex' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button:hover,input[type="submit"]:hover,button:hover',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'background',
			),
		),
	),
);