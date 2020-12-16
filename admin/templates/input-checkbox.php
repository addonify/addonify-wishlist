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
	'<input type="checkbox"  name="%1$s" id="%1$s" value="1" %2$s %3$s /><span class="label-after-input">%4$s</span>',
	esc_attr( $args['name'] ),
	wp_kses_post( $is_checked ),
	wp_kses_post( $attr ),
	wp_kses_post( $end_label )
);
