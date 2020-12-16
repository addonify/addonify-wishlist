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
	'<div class="addonify-input-radio-group" ><label><input type="radio" name="%1$s" value="%2$s" %3$s ><span class="label-after-input">%4$s</span></label></div>',
	esc_attr( $args['name'] ),
	esc_attr( $args['value'] ),
	wp_kses_post( $attr ),
	wp_kses_post( $label )
);
