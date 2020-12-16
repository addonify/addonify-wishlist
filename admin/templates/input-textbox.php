<?php
/**
 * Admin template.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/admin/templates
 */

// direct access is disabled.
defined( 'ABSPATH' ) || exit;

printf(
	'<input type="%4$s" class="regular-text %3$s" name="%1$s" id="%1$s" value="%2$s" %6$s /><span class="label-after-input">%5$s</span>',
	esc_attr( $args['name'] ),
	esc_attr( $db_value ),
	esc_attr( $args['css_class'] ),
	esc_attr( $args['type'] ),
	esc_html( $args['end_label'] ),
	wp_kses_post( $args['other_attr'] )
);
