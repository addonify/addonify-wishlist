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
	'<textarea name="%1$s" id="%1$s" %2$s >%3$s</textarea>',
	esc_attr( $args['name'] ),
	wp_kses_post( $attr ),
	esc_textarea( $db_value )
);
