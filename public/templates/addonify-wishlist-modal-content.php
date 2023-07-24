<?php
/**
 * Modal template for displaying wishlist message.
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
				<?php echo $icon; // phpcs:ignore ?>
			</div>
			<div id="addonify-wishlist-modal-response">
				<p class="response-text"><?php echo wp_kses_post( $message ); // phpcs:ignore ?></p>
			</div>
			<?php
			if ( $button_content ) {
				echo wp_kses_post( $button_content ); // phpcs:ignore
			}
			?>
		</div>
	</div>

	<?php do_action( 'addonify_wishlist_before_popup_closing_tag' ); ?>

</div>
