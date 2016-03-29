<?php
/**
 * Active callback functions for the customizer
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 */

/*-------------------------------------------------------------------------------*/
/* [ Core ]
/*-------------------------------------------------------------------------------*/

function wpex_customizer_container_layout_supports_max_width() {
	if ( 'full-width' == get_theme_mod( 'main_layout_style', 'full-width' ) &&
		get_theme_mod( 'responsive', true ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_boxed_layout() {
	if ( 'boxed' == get_theme_mod( 'main_layout_style', 'full-width' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_hasnt_boxed_layout() {
	if ( 'boxed' == get_theme_mod( 'main_layout_style', 'full-width' ) ) {
		return false;
	} else {
		return true;
	}
}

function wpex_customizer_has_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		return true;
	} else {
		return get_theme_mod( 'breadcrumbs', true );
	}
}


function wpex_customizer_enabled_not_yoast() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		return false;
	} else {
		return wpex_customizer_has_breadcrumbs();
	}
}

function wpex_customizer_has_page_header() {
	if ( 'hidden' != get_theme_mod( 'page_header_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_callout() {
	return get_theme_mod( 'callout', true );
}

function wpex_customizer_callout_has_button() {
	if ( wpex_customizer_has_callout() && get_theme_mod( 'callout_link', true ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_has_scroll_top_button() {
	return get_theme_mod( 'scroll_top', true );
}

function wpex_customizer_has_topbar_social() {
	if ( wpex_customizer_has_topbar()
		&& get_theme_mod( 'top_bar_social' )
		&& ! get_theme_mod( 'top_bar_social_alt' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_topbar_social_style_is_none() {
	if ( wpex_customizer_has_topbar_social() && 'none' == get_theme_mod( 'top_bar_social_style' ) ) {
		return true;
	} else {
		return false;
	}
}


function wpex_customizer_has_footer_widgets() {
	return get_theme_mod( 'footer_widgets', true );
}

function wpex_customizer_supports_reveal() {
	if ( wpex_customizer_has_footer_widgets() && ! wpex_customizer_has_vertical_header() ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_footer_bottom() {
	return get_theme_mod( 'footer_bottom', true );
}

/*-------------------------------------------------------------------------------*/
/* [ Background ]
/*-------------------------------------------------------------------------------*/

function wpex_customizer_has_background_image() {
	return get_theme_mod( 'background_image' );
}

function wpex_customizer_hasnt_background_image() {
	if ( get_theme_mod( 'background_image' ) ) {
		return false;
	} else {
		return true;
	}
}

function wpex_customizer_hasnt_background_pattern() {
	if ( get_theme_mod( 'background_pattern' ) ) {
		return false;
	} else {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Togglebar / Topbar ]
/*-------------------------------------------------------------------------------*/

function wpex_customizer_has_togglebar() {
	return get_theme_mod( 'toggle_bar', true ) ;
}

function wpex_customizer_has_topbar() {
	return get_theme_mod( 'top_bar', true );
}

/*-------------------------------------------------------------------------------*/
/* [ Header ]
/*-------------------------------------------------------------------------------*/

function wpex_customizer_header_supports_sticky() {
	if ( wpex_customizer_has_vertical_header() ) {
		return false;
	} else {
		return true;
	}
}

function wpex_customizer_header_supports_full_width() {
	if ( wpex_customizer_hasnt_boxed_layout() && 'six' != get_theme_mod( 'header_style', 'one' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_fixed_header() {
	if ( wpex_customizer_header_supports_sticky() && get_theme_mod( 'fixed_header', true ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_supports_fixed_header_mobile() {
	if ( wpex_customizer_has_fixed_header() && 'toggle' != get_theme_mod( 'mobile_menu_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_hasnt_sticky_header() {
	if ( get_theme_mod( 'fixed_header', true ) ) {
		return false;
	} else {
		return true;
	}
}

function wpex_customizer_has_shrink_sticky_header() {
	if ( wpex_customizer_has_fixed_header() && get_theme_mod( 'shink_fixed_header', true ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_is_header_one() {
	if ( 'one' == get_theme_mod( 'header_style', 'one' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_is_header_two() {
	if ( 'two' == get_theme_mod( 'header_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_vertical_header() {
	if ( 'six' == get_theme_mod( 'header_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_hasnt_vertical_header() {
	if ( 'six' == get_theme_mod( 'header_style' ) ) {
		return false;
	} else {
		return true;
	}
}

function wpex_customizer_fixed_header_supports_opacity() {
	if ( wpex_customizer_has_fixed_header() && (
		'one' == get_theme_mod( 'header_style' )
		|| 'five' == get_theme_mod( 'header_style' )
	) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_header_has_aside() {
	$style = get_theme_mod( 'header_style', 'one' );
	if ( 'two' == $style || 'three' == $style || 'four' == $style ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_header_has_aside_search() {
	if ( 'two' == get_theme_mod( 'header_style', 'one'  ) ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Logo ]
/*-------------------------------------------------------------------------------*/

function wpex_customizer_has_image_logo() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_supports_fixed_header_logo() {
	if ( wpex_customizer_has_fixed_header() && wpex_customizer_has_image_logo() ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_hasnt_custom_logo() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		return false;
	} else {
		return true;
	}
}

function wpex_customizer_has_retina_logo() {
	if ( get_theme_mod( 'custom_logo' ) && get_theme_mod( 'retina_logo' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_text_logo_icon() {
	$mod = get_theme_mod( 'logo_icon' );
	if ( wpex_customizer_hasnt_custom_logo() && $mod && 'none' != $mod ) {
		return true;
	} else {
		return false;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Menu ]
/*-------------------------------------------------------------------------------*/

function wpex_has_mobile_menu() {
	if ( 'disabled' != get_theme_mod( 'mobile_menu_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_is_mobile_toggle_fixed_top() {
	if ( 'fixed_top' == get_theme_mod( 'mobile_menu_toggle_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_mobile_menu_is_sidr() {
	if ( 'sidr' == get_theme_mod( 'mobile_menu_style', 'sidr' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_mobile_menu_is_full_screen() {
	if ( 'full_screen' == get_theme_mod( 'mobile_menu_style', 'sidr' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_mobile_menu_is_toggle() {
	if ( 'toggle' == get_theme_mod( 'mobile_menu_style', 'sidr' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_mobile_menu_icons() {
	if ( 'disabled' == get_theme_mod( 'mobile_menu_style' )
		|| wpex_customizer_is_mobile_toggle_fixed_top()
	) {
		return false;
	} else {
		return true;
	}
}

function wpex_customizer_navbar_supports_flush_dropdowns() {
	if ( wpex_customizer_has_vertical_header() ) {
		return false;
	} else {
		return true;
	}
}

function wpex_has_menu_search_icon() {
	if ( wpex_has_menu_search() && 'two' != get_theme_mod( 'header_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_has_menu_search_dropdown() {
	if ( 'six' == get_theme_mod( 'header_style' )
		|| 'drop_down' != get_theme_mod( 'menu_search_style' )
	) {
		return false;
	} else {
		return true;
	}
}

function wpex_has_menu_search_overlay() {
	if ( 'six' == get_theme_mod( 'header_style' ) ) {
		return true;
	}
	if ( wpex_has_menu_search_icon() && 'overlay' == get_theme_mod( 'menu_search_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_has_menu_dropdown_top_border() {
	return get_theme_mod( 'menu_dropdown_top_border', false );
}

function wpex_has_menu_pointer() {
	if ( get_theme_mod( 'menu_dropdown_style' ) ) {
		return false;
	} elseif ( 'one' != get_theme_mod( 'header_style' ) ) {
		return false;
	} elseif ( get_theme_mod( 'menu_flush_dropdowns' ) ) {
		return false;
	} else {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ Blog ]
/*-------------------------------------------------------------------------------*/

function wpex_customizer_blog_page_header_custom_text() {
	if ( 'custom_text' == wpex_get_mod( 'blog_single_header', 'custom_text' ) ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_grid_blog_style() {
	$style = get_theme_mod( 'blog_style' );
	if ( 'grid-entry-style' == $style || 'grid' == $style ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_blog_supports_equal_heights() {
	if ( wpex_customizer_grid_blog_style() && 'masonry' != get_theme_mod( 'blog_grid_style' ) ) {
		return true;
	} else {
		return false;
	}
}


function wpex_customizer_has_blog_related() {
	$pos = strpos( wpex_get_mod( 'blog_single_composer', 'related_posts' ), 'related_posts' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_blog_meta() {
	$pos = strpos( wpex_get_mod( 'blog_single_composer', 'meta' ), 'meta' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_blog_entry_meta() {
	$pos = strpos( wpex_get_mod( 'blog_entry_composer', 'meta' ), 'meta' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_blog_single_media() {
	$pos = strpos( wpex_get_mod( 'blog_single_composer', 'featured_media' ), 'featured_media' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_blog_entry_media() {
	$pos = strpos( wpex_get_mod( 'blog_entry_composer', 'featured_media' ), 'featured_media' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_blog_entry_excerpt() {
	$pos = strpos( wpex_get_mod( 'blog_entry_composer', 'excerpt_content' ), 'excerpt_content' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}

function wpex_customizer_has_blog_entry_readmore() {
	$pos = strpos( wpex_get_mod( 'blog_entry_composer', 'readmore' ), 'readmore' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}


/*-------------------------------------------------------------------------------*/
/* [ Portfolio ]
/*-------------------------------------------------------------------------------*/

function wpex_customizer_has_portfolio_related() {
	$pos = strpos( wpex_get_mod( 'portfolio_post_composer', 'related' ), 'related' );
	if ( $pos !== false ) {
		return true;
	} else {
		return false;
	}
}