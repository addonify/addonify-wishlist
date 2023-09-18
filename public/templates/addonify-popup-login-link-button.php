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
		class="adfy-wishlist-btn-link addonify-goto-login-btn"
		href="<?php echo esc_url( $redirect_url ); ?>"
	>
		<?php echo esc_html( $login_button_label ); ?>
	</a>
</div>
