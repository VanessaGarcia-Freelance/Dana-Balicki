<?php
/**
 * Add more buttons to the MCE editor
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 */

// Only needed in the admin
if( ! is_admin() ) {
    return;
}

// Enable font size buttons in the editor
if ( ! function_exists( 'wpex_mce_buttons' ) ) {
    function wpex_mce_buttons( $buttons ) {
        array_unshift( $buttons, 'fontselect' );
        array_unshift( $buttons, 'fontsizeselect' );
        return $buttons;
    }
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

// Customize mce editor font sizes
if ( ! function_exists( 'wpex_customize_text_sizes' ) ) {
    function wpex_customize_text_sizes( $initArray ){
        $initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
        return $initArray;
    }
}
add_filter( 'tiny_mce_before_init', 'wpex_customize_text_sizes' );

// Add "Styles" / "Formats" (3.9+) drop-down
if ( ! function_exists( 'wpex_style_select' ) ) {
    function wpex_style_select( $buttons ) {
        array_push( $buttons, 'styleselect' );
        return $buttons;
    }
}
add_filter( 'mce_buttons', 'wpex_style_select' );