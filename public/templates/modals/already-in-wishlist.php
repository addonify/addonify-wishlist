<?php
/**
 * Modal template for displaying already in wishlist message.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/public/templates
 */

?>
<div id="addonify-wishlist-modal-wrapper" class="" data_model-width="default">

	<?php do_action( 'addonify_wishlist_after_popup_opening_tag' ); ?>

	<div class="addonify-wishlist-modal">
		<div class="adfy-model-close">
			<?php do_action( 'addonify_wishlist_render_modal_close_button' ); ?>
		</div>
		<div class="addonify-wishlist-modal-body">
			<div class="adfy-wishlist-icon-entry">
				<?php echo apply_filters( 'addonify_wishlist_already_in_wishlist_modal_icon', '<i class="adfy-wishlist-icon adfy-status-success heart-o-style-three"></i>' ); // phpcs:ignore ?>
			</div>
			<div id="addonify-wishlist-modal-response">
				<p class="response-text"><?php echo esc_html( addonify_wishlist_get_option( 'product_already_in_wishlist_text' ) ); ?></p>
			</div>
			<div class="addonify-wishlist-modal-btns">
				<?php do_action( 'addonify_wishlist_modal_wishlist_link' ); ?>
			</div>
		</div>
	</div>

	<?php do_action( 'addonify_wishlist_before_popup_closing_tag' ); ?>

</div>
