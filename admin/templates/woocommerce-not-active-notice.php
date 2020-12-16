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
	<p><?php esc_html_e( 'Addonify Wishlist is enabled but not effective. It requires WooCommerce in order to work.', 'addonify-wishlist' ); ?></p>
</div>
