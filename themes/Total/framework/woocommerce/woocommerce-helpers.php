<?php
/**
 * WooCommerce helper functions
 * This functions only load if WooCommerce is enabled because
 * they should be used within Woo loops only.
 *
 * @package Total WordPress Theme
 * @subpackage WooCommerce
 */

/**
 * Creates the WooCommerce link for the navbar
 *
 * @since Total 1.0
 */
if ( ! function_exists( 'wpex_wcmenucart_menu_item' ) ) {
	function wpex_wcmenucart_menu_item() {
		
		// Vars
		global $woocommerce;
		$icon_style   = wpex_get_mod( 'woo_menu_icon_style', 'drop-down' );
		$custom_link  = wpex_get_mod( 'woo_menu_icon_custom_link' );
		$header_style = wpex_global_obj( 'header_style' );

		// URL
		if ( 'custom-link' == $icon_style && $custom_link ) {
			$url = esc_url( $custom_link );
		} else {
			$cart_id = woocommerce_get_page_id( 'cart' );
			if ( function_exists( 'icl_object_id' ) ) {
				$cart_id = icl_object_id( $cart_id, 'page' );
			}
			$url = get_permalink( $cart_id );
		}
		
		// Cart total
		$display = wpex_get_mod( 'woo_menu_icon_display', 'icon_count' );
		if ( 'icon_total' == $display ) {
			$cart_extra = WC()->cart->get_cart_total();
			$cart_extra = str_replace( 'amount', 'wcmenucart-details', $cart_extra );
		} elseif ( 'icon_count' == $display ) {
			$cart_extra = '<span class="wcmenucart-details count">'. WC()->cart->cart_contents_count .'</span>';
		} else {
			$cart_extra = '';
		}

		// Cart Icon
		$cart_icon = '<span class="fa fa-shopping-cart"></span><span class="wcmenucart-text">'. _x( 'Shop', 'Navbar Cart Text For Vertical Nav', 'wpex' ) .'</span>';
		$cart_icon = apply_filters( 'wpex_menu_cart_icon_html', $cart_icon );

		ob_start(); ?>

			<a href="<?php echo $url; ?>" class="wcmenucart" title="<?php _e('Your Cart','wpex'); ?>">
				<span class="link-inner">
					<span class="wcmenucart-count"><?php echo $cart_icon; ?><?php echo $cart_extra; ?></span>
				</span>
			</a>
			
		<?php
		return ob_get_clean();
	}
}

/**
 * Outputs placeholder image
 *
 * @since 1.0.0
 */
function wpex_woo_placeholder_img() {
	if ( function_exists( 'wc_placeholder_img_src' ) && wc_placeholder_img_src() ) {
		$placeholder = '<img src="'. wc_placeholder_img_src() .'" alt="'. __( 'Placeholder Image', 'wpex' ) .'" class="woo-entry-image-main" />';
		$placeholder = apply_filters( 'wpex_woo_placeholder_img_html', $placeholder );
		if ( $placeholder ) {
			echo $placeholder;
		}
	}
}

/**
 * Check if product is in stock
 *
 * @since 1.0.0
 */
function wpex_woo_product_instock( $post_id = '' ) {
	global $post;
	$post_id      = $post_id ? $post_id : $post->ID;
	$stock_status = get_post_meta( $post_id, '_stock_status', true );
	if ( 'instock' == $stock_status ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Outputs product price
 *
 * @since 1.0.0
 */
function wpex_woo_product_price( $post_id = '' ) {
	echo wpex_get_woo_product_price( $post_id );
}

/**
 * Returns product price
 *
 * @since 1.0.0
 */
function wpex_get_woo_product_price( $post_id = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$product = get_product( $post_id );
	$price   = $product->get_price_html();
	if ( $price ) {
		return $price;
	}
}