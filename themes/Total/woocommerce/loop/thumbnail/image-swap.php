<?php
/**
 * Image Swap style thumbnail
 *
 * @package Total Wordpress Theme
 * @subpackage Templates/WooCommerce
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Return dummy image if no featured image is defined
if ( ! has_post_thumbnail() ) {
    wpex_woo_placeholder_img();
    return;
}

//Globals
global $product;

// Get first image
$attachment = get_post_thumbnail_id();
$main_image = wpex_get_post_thumbnail( array(
    'attachment' => $attachment,
    'size'       => 'shop_catalog',
    'alt'        => wpex_get_esc_title(),
    'class'      => 'woo-entry-image-main',
) );

// Get Second Image in Gallery
$attachment_ids           = $product->get_gallery_attachment_ids();
$attachment_ids[]         = $attachment; // Add featured image to the array
$secondary_attachment_url = '';

if ( ! empty( $attachment_ids ) ) {
    $attachment_ids = array_unique( $attachment_ids ); // remove duplicate images
    if ( count( $attachment_ids ) > '1' ) {
        if ( $attachment_ids['0'] !== $attachment ) {
            $secondary_img_id = $attachment_ids['0'];
        } elseif ( $attachment_ids['1'] !== $attachment ) {
            $secondary_img_id = $attachment_ids['1'];
        }
    }
}

// Get secondary image output
if ( ! empty( $secondary_img_id ) ) {
    $secondary_image = wpex_get_post_thumbnail( array(
        'attachment' => $secondary_img_id,
        'size'       => 'shop_catalog',
        'class'      => 'woo-entry-image-secondary',
    ) );
} else {
    $secondary_image = false;
}
            
// Return thumbnail
if ( $main_image && $secondary_image ) : ?>

    <div class="woo-entry-image-swap clr">
        <?php echo $main_image; ?>
        <?php echo $secondary_image; ?>
    </div><!-- .woo-entry-image-swap -->

<?php else : ?>

    <?php echo $main_image; ?>

<?php endif; ?>