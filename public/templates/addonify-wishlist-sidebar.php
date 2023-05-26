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
				<?php echo esc_html( $title ); ?>
			</h3>
			<button id="close-adfy-wishlist-sidebar-button" class="button">
				<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
				</svg>
			</button>
		</div>

		<div id="addonify-wishlist-notice" class="addonify-wishlist-notice"></div>

		<form action="" method="POST" id="addonify-wishlist-sidebar-form">
			<?php do_action( 'addonify_wishlist_before_wishlist_form_table' ); ?>
			<div id="addonify-wishlist-sidebar-items-wrapper">
				<ul class="adfy-wishlist-sidebar-items-entry">
					<?php do_action( 'addonify_wishlist_render_sidebar_loop', $product_ids ); ?>
				</ul>
			</div>
			<?php if ( empty( $product_ids ) && $total_items < 1 ) : ?>
			<p id="addonify-empty-wishlist-para" class="empty-wishlist">
				<?php echo esc_html__( 'Your wishlist is empty', 'addonify-wishlist' ); ?>
			</p>
			<?php endif; ?>
			<?php do_action( 'addonify_wishlist_after_wishlist_form_table' ); ?>
		</form>
	</div>
	<?php
	if ( $view_wishlist_page_button_label ) {
		?>
		<div class="addonify-wishlist-ssc-footer">
			<a href="<?php echo esc_url( $wishlist_url ); ?>" class="addonify-wishlist-goto-wishlist-btn">
				<?php echo esc_html( $view_wishlist_page_button_label ); ?>
				<span class="icon">
					<svg viewBox="0 0 64 64" xml:space="preserve">
						<path d="M61.5,28.5l-6.9-8.2c-0.6-0.7-1.7-0.8-2.5-0.2c-0.7,0.6-0.8,1.7-0.2,2.5l6.5,7.7H3c-1,0-1.8,0.8-1.8,1.8c0,1,0.8,1.8,1.8,1.8h55.4l-6.5,7.7c-0.6,0.7-0.5,1.8,0.2,2.5c0.3,0.3,0.7,0.4,1.1,0.4c0.5,0,1-0.2,1.3-0.6l6.9-8.2C63.2,33.5,63.2,30.5,61.5,28.5z"/>
					</svg>
				</span>
			</a>
		</div>
		<?php
	}
	?>
	<?php do_action( 'addonify_wishlist_before_sidebar_closing_tag' ); ?>
</div>
