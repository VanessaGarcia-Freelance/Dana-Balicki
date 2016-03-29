<?php
/**
 * Search entry thumbnail
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Return if there isn't any thumbnail defined
if ( ! has_post_thumbnail() ) {
    return;
}

// Thumbnail arguments
$args = array(
    'size'   => 'thumbnail',
    'width'  => '',
    'height' => '',
    'alt'    => wpex_get_esc_title(),
);

// Apply filters
$args = apply_filters( 'wpex_search_thumbnail_args', $args ); ?>

<div class="search-entry-thumb">
    <a href="<?php wpex_permalink(); ?>" title="<?php wpex_esc_title(); ?>" class="search-entry-img-link"><?php wpex_post_thumbnail( $args ); ?></a>
</div><!-- .search-entry-thumb -->