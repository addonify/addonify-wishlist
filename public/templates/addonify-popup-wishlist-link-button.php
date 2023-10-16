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

?>
<div class="addonify-wishlist-modal-btns">
	<a
		class="adfy-wishlist-btn-link addonify-view-wishlist-btn"
		href="<?php echo esc_url( $wishlist_page_url ); ?>"
	>
		<?php echo esc_html( $view_wishlist_button_label ); ?>
	</a>
</div>
