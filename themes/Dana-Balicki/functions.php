<?php // Opening PHP tag - nothing should be before this, not even whitespace


//adding styles from parent the
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


//using SVGs inside the media library
// function svg_mime_types( $mimes ){
//   $mimes['svg'] = 'image/svg+xml';
//   return $mimes;}
// add_filter( 'upload_mimes', 'svg_mime_types' );


// Add custom font to font settings
// function wpex_add_custom_fonts() {
//     return array( 'DINPro-Black', 'DINPro-Bold', 'DINPro-Medium', 'DINPro-Light', 'emporium' );
// }


// add_action( 'wp_enqueue_scripts', 'child_functions_enqueue_scripts' );
// function child_functions_enqueue_scripts() {
//     wp_enqueue_script( 'child_functions', get_stylesheet_directory_uri() . '/js/child-functions.js', '', '', true );
// }