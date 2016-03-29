<?php
/**
 * Main Loop
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_template_part( 'partials/post-type/post-type-entry', get_post_type() );