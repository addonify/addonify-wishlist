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
?>
<div class="notice notice-error is-dismissible">
	<p><?php echo wp_kses_post( __( '<b>Addonify WooCommerce Wishlist</b>  plugin is enabled but not functional. <b>WooCommerce</b> is required for it to work properly.', 'addonify-wishlist' ) ); ?></p>
</div>
