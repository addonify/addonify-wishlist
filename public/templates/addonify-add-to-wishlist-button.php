<?php
/**
 * Public template.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/public/templates
 */

// direct access is disabled.
defined( 'ABSPATH' ) || exit;

$label = '<span class="addonify-wishlist-btn-label">' . $label . ' </span>';

if ( $show_icon ) {
	$label = '<i class="icon adfy-wishlist-icon ' . $icon . '"></i> ' . $label;
}

printf(
	'<div class="addonify-add-to-wishlist-btn-wrapper"><button type="button" class="button adfy-wishlist-btn addonify-add-to-wishlist-btn %2$s" data-product_id="%3$s" data-product_name="%4$s"> %1$s</button></div>',
	wp_kses_post( $label ),
	esc_attr( $css_class ),
	esc_attr( $product_id ),
	esc_attr( $name )
);
