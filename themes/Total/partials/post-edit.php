<?php
/**
 * Edit post link
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Return if disabled
if ( ! wpex_get_mod( 'edit_post_link_enable', true ) ) {
	return;
}

// Edit text
if ( is_page() ) {
    $edit_text = __( 'Edit This Page', 'wpex' );
} else {
    $edit_text = __( 'Edit This Post', 'wpex' );
}

// Display edit post link
edit_post_link(
    $edit_text,
    '<div class="post-edit clr">', ' <a href="#" class="hide-post-edit" title="'. __( 'Hide Post Edit Links', 'wpex' ) .'"><span class="fa fa-times"></span></a></div>'
); ?>