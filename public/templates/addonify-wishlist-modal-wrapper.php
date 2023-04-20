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

<div id="addonify-wishlist-modal-wrapper" class="<?php echo esc_attr( $css_classes ); ?>" data_model-width="default">

	<?php do_action( 'addonify_wishlist_after_popup_opening_tag' ); ?>

	<div class="addonify-wishlist-modal">
		<div class="adfy-model-close">
			<button type="button" id="addonify-wishlist-close-modal-btn" class="adfy-wishlist-btn adfy-wishlist-clear-button-style">
				<svg x="0px" y="0px" viewBox="0 0 511.991 511.991">
				<g><path d="M286.161,255.867L505.745,36.283c8.185-8.474,7.951-21.98-0.523-30.165c-8.267-7.985-21.375-7.985-29.642,0   L255.995,225.702L36.411,6.118c-8.475-8.185-21.98-7.95-30.165,0.524c-7.985,8.267-7.985,21.374,0,29.641L225.83,255.867   L6.246,475.451c-8.328,8.331-8.328,21.835,0,30.165l0,0c8.331,8.328,21.835,8.328,30.165,0l219.584-219.584l219.584,219.584   c8.331,8.328,21.835,8.328,30.165,0l0,0c8.328-8.331,8.328-21.835,0-30.165L286.161,255.867z"/>
				</g></svg>
			</button>
		</div>
		<div class="addonify-wishlist-modal-body">
			<div class="adfy-wishlist-icon-entry">
				<i class="adfy-wishlist-icon adfy-status-success heart-o-style-three"></i>
				<i class="adfy-wishlist-icon adfy-status-error flash"></i>
			</div>
			<div id="addonify-wishlist-modal-response"></div>
			<div class="addonify-wishlist-modal-btns">
				<?php do_action( 'addonify_wishlist_popup_action_btns' ); ?>
			</div>
		</div>
	</div>

	<?php do_action( 'addonify_wishlist_before_popup_closing_tag' ); ?>

</div>
