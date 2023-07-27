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

if (
	is_array( $products_data ) &&
	count( $products_data ) > 0
) {
	?>
	<ul class="adfy-wishlist-sidebar-items-entry">
		<?php
		foreach ( $products_data as $product_id => $product_data ) {
			?>
			<li
				class="addonify-wishlist-sidebar-item"
				data-product_row="addonify-wishlist-sidebar-product-row-<?php echo esc_attr( $product_id ); ?>"
				data-product_name="<?php echo esc_attr( $product_data['name'] ); ?>"
			>
				<div class="adfy-wishlist-row">
					<div class="adfy-wishlist-col image-column">
						<div class="adfy-wishlist-woo-image">
							<a href="<?php echo esc_url( $product_data['permalink'] ); ?>">
								<?php echo wp_kses_post( $product_data['image'] ); ?>
							</a>
						</div>
					</div>
					<div class="adfy-wishlist-col title-price-column">
						<div class="adfy-wishlist-woo-title">
							<a href="<?php echo esc_url( $product_data['permalink'] ); ?>">
								<?php echo wp_kses_post( $product_data['name'] ); ?>
							</a>
						</div>
						<div class="adfy-wishlist-woo-price"><?php echo wp_kses_post( $product_data['price'] ); ?></div>
						<?php
						if ( isset( $product_data['stock_status'] ) ) {
							?>
							<div class="adfy-wishlist-woo-stock">
								<span class="stock-label <?php echo esc_attr( $product_data['stock_status']['class'] ); ?>">
									<?php echo esc_html( $product_data['stock_status']['avaibility'] ); ?>
								</span>
							</div>
							<?php
						}
						?>
					</div>
				</div>

				<div class="adfy-wishlist-woo-action">
					<div class="adfy-wishlist-row">
						<div class="adfy-wishlist-col cart-column">
							<?php
							echo do_shortcode( '[add_to_cart id=' . $product_id . ' show_price=false style="" class="adfy-wishlist-clear-shortcode-button-style adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-sidebar-button"]' );
							?>
						</div>
						<div class="adfy-wishlist-col remove-item-column">
							<?php
							$remove_from_wishlist_class = $guest ? ' addonify-wishlist-remove-from-wishlist addonify-wishlist-ajax-remove-from-wishlist' : ' adfy-wishlist-remove-btn addonify-wishlist-ajax-remove-from-wishlist ';
							?>
							<button
								class="adfy-wishlist-btn addonify-wishlist-icon <?php echo esc_attr( $remove_from_wishlist_class ); ?> addonify-wishlist-sidebar-button"
								name="addonify_wishlist_remove"
								<?php
								foreach ( $product_data['data_attrs'] as $data_attr => $data_value ) {
									echo 'data-' . esc_attr( $data_attr ) . '="' . esc_attr( $data_value ) . '" ';
								}
								?>
								data-source="wishlist-sidebar"
							>
								<i class="adfy-wishlist-icon trash-2"></i>
							</button>
						</div>
					</div>
				</div>
			</li>
			<?php
		}
		?>
	</ul>
	<?php
} else {
	?>
	<p><?php echo esc_html( addonify_wishlist_get_option( 'sidebar_empty_wishlist_label' ) ); ?></p>
	<?php
}
