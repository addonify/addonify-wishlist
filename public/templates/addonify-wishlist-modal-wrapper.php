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

<div id="addonify-wishlist-modal-wrapper" class="<?php echo esc_attr( $css_classes ); ?>">

	<?php do_action( 'addonify_wishlist_after_popup_opening_tag' ); ?>

	<div class="addonify-wishlist-modal-body">
		<div class="adfy-wishlist-icon-entry">
			<i class="adfy-wishlist-icon adfy-status-success heart-o-style-three"></i>
			<i class="adfy-wishlist-icon adfy-status-error flash"></i>
		</div>
		<div id="addonify-wishlist-modal-response"></div>
		<div class="addonify-wishlist-modal-btns">
			<?php do_action( 'addonify_wishlist/popup_action_btns' ); ?>
		</div>
	</div>

	<?php do_action( 'addonify_wishlist_before_popup_closing_tag' ); ?>

</div>
