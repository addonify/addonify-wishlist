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
<div id="addonify-wishlist-page-container">

	<div id="addonify-wishlist-notice" class="addonify-wishlist-notice"></div>

	<div id="addonify-wishlist-page-items-wrapper">
		<?php
		if ( is_user_logged_in() ) {
			do_action( 'addonify_wishlist_render_wishlist_page_loop', $wishlist_product_ids );
		} else {
			if ( addonify_wishlist_get_option( 'require_login' ) === '1' ) {
				?>
				<div id="addonify-wishlist-login-required-message">
					<p class="response-text"><?php echo esc_html( addonify_wishlist_get_option( 'login_required_message' ) ); ?></p>
				</div>
				<div class="addonify-wishlist-login-link">
					<?php do_action( 'addonify_wishlist_modal_login_link' ); ?>
				</div>
				<?php
			} else {
				do_action( 'addonify_wishlist_render_wishlist_page_loop', $wishlist_product_ids );
			}
		}
		?>
	</div>
</div>
