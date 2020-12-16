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

<div id="addonify-wishlist-sticky-sidebar-container" class="<?php echo esc_attr( $css_class ); ?>" >

	<?php do_action( 'addonify_wishlist_after_sidebar_opening_tag' ); ?>

	<div class="addonify-wishlist-ssc-body">

		<h3><?php echo esc_attr( $title ); ?></h3>

		<form action="" method="POST" id="addonify-wishlist-sidebar-form" >
			<input type="hidden" name="nonce" value="<?php echo esc_attr( $nonce ); ?>" >
			<input type="hidden" name="process_addonify_wishlist_form" value="ajax" >

			<div id="addonify-wishlist-sidebar-items-wrapper" >
				<ul class="adfy-wishlist-sidebar-items-entry">
					<?php echo wp_kses_post( $loop ); ?>
				</ul>
			</div>

			<?php if ( $total_items < 1 ) : ?>
				<p class="empty-wishlist"><?php echo esc_html_e( 'Your wishlist is empty', 'addonify-wishlist' ); ?></p> 
			<?php endif; ?>

		</form>
	</div>

	<div class="addonify-wishlist-ssc-footer">
		<a href="<?php echo esc_url( $wishlist_url ); ?>" class="addonify-wishlist-goto-wishlist-btn">
			<span class="icon"><i class="adfy-wishlist-icon external-link"></i></span>
			<?php esc_html_e( 'View all Wishlist', 'addonify-wishlist' ); ?>
		</a>
	</div>
	
	<?php do_action( 'addonify_wishlist_before_sidebar_closing_tag' ); ?>

</div>
