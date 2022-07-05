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
<div id="addonify-wishlist-sticky-sidebar-overlay"></div>
<div id="addonify-wishlist-sticky-sidebar-container" class="<?php echo esc_attr( $css_class ); ?>">
	<?php do_action( 'addonify_wishlist_after_sidebar_opening_tag' ); ?>
	<div class="addonify-wishlist-ssc-body">
		<div class="addonify-wishlist-scs-header">
			<h3 class="adfy-wishlist-sidebar-title">
				<?php echo esc_attr( $title ); ?>
			</h3>
			<button id="close-adfy-wishlist-sidebar-button" class="button">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
					<g>
						<path d="M30.2,57.2c-0.7,0-1.4-0.2-2-0.7L3.5,36.7c-1.4-1.1-2.2-2.8-2.2-4.7s0.8-3.5,2.2-4.7L28.2,7.5c1-0.8,2.2-0.9,3.3-0.4
                        c1.1,0.5,1.8,1.6,1.8,2.8v11.1c8.5,1.2,16.2,5,22,10.7c3.9,4,5.9,7.8,7,13.4c0.2,1.3,0.4,3.4,0.4,6.4c0,1.2-0.6,2.3-1.6,2.8
                        c-1,0.6-2.3,0.5-3.2-0.1c-9-5.8-17.4-9.3-24.5-10.2V54c0,1.2-0.7,2.3-1.8,2.8C31.1,57.1,30.7,57.2,30.2,57.2z M29.9,10.7L5.7,30.1
                        c-0.6,0.5-0.9,1.2-0.9,1.9c0,0.8,0.3,1.5,0.9,1.9l24.2,19.4V42.2c0-0.5,0.2-0.9,0.6-1.3c0.4-0.3,0.8-0.5,1.3-0.5
                        c9.9,0.6,20.3,6,27.5,10.6c-0.1-2.4-0.2-4.2-0.4-5.1c-1-5-2.6-8.1-6-11.7c-5.5-5.5-13.2-9-21.4-9.9c-0.9-0.1-1.6-0.8-1.6-1.7V10.7z
                        "></path>
					</g>
				</svg>
			</button>
		</div>

		<form action="" method="POST" id="addonify-wishlist-sidebar-form">
			<?php do_action( 'addonify_wishlist/before_wishlist_form' ); ?>
			<div id="addonify-wishlist-sidebar-items-wrapper">
				<ul class="adfy-wishlist-sidebar-items-entry">
					<?php echo wp_kses_post( $loop ); ?>
				</ul>
			</div>
			<?php if ( $total_items < 1 ) : ?>
			<p id="addonify-empty-wishlist-para" class="empty-wishlist">
				<?php echo esc_html_e( 'Your wishlist is empty', 'addonify-wishlist' ); ?>
			</p>
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