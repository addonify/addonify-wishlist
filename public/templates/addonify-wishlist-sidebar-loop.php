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
	is_array( $wishlist_product_ids ) &&
	count( $wishlist_product_ids ) > 0
) {
	foreach ( $wishlist_product_ids as $product_id ) {
		$wishlist_attr = '';
		if ( is_user_logged_in() ) {
			$wishlist = new Addonify\Wishlist();

			$parent_wishlist_id = $wishlist->get_wishlist_id_from_product_id( $product_id );
			if ( $parent_wishlist_id ) {
				$wishlist_attr = 'data-wishlist_id=' . $parent_wishlist_id;
			}
		}

		$product      = wc_get_product( $product_id );
		$in_stock     = '<div style="font-weight:bold;">In stock</div>';
		$out_of_stock = '<div style="font-weight:bold;color:#CD5C5C">Out of stock</div>';
		?>
		<li class="addonify-wishlist-sidebar-item" data-product_row="addonify-wishlist-sidebar-product-row-<?php echo esc_attr( $product_id ); ?>" data-product_name="<?php echo esc_attr( $product->get_name() ); ?>">
			<div class="adfy-wishlist-row">
				<div class="adfy-wishlist-col image-column">
					<div class="adfy-wishlist-woo-image">
						<?php
						$product_post_thumbnail_id = $product->get_image_id();
						if ( $product->get_image() ) {
							?>
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo wp_kses_post( $product->get_image( array( 72, 72 ) ) ); ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="adfy-wishlist-col title-price-column">
					<div class="adfy-wishlist-woo-title">
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php echo wp_kses_post( $product->get_title() ); ?>
						</a>
					</div>
					<div class="adfy-wishlist-woo-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
					<div class="adfy-wishlist-woo-stock"><?php echo wp_kses_post( $product->is_in_stock() ? $in_stock : $out_of_stock ); ?></div>
				</div>
			</div>

			<div class="adfy-wishlist-woo-action">
				<div class="adfy-wishlist-row">
					<div class="adfy-wishlist-col cart-column">
						<?php
						echo do_shortcode( '[add_to_cart id=' . $product->get_id() . ' show_price=false style="" class="adfy-wishlist-clear-shortcode-button-style adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-sidebar-button"]' );
						?>
					</div>
					<div class="adfy-wishlist-col remove-item-column">
						<?php
						if ( (int) addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' ) === 1 ) {
							$remove_from_wishlist_class = $guest ? ' addonify-wishlist-remove-from-wishlist ' : ' adfy-wishlist-remove-btn addonify-wishlist-ajax-remove-from-wishlist ';
							?>
							<button
								class="adfy-wishlist-btn addonify-wishlist-icon <?php echo esc_attr( $remove_from_wishlist_class ); ?> addonify-wishlist-sidebar-button"
								name="addonify_wishlist_remove" 
								data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
								value="<?php echo esc_attr( $product->get_id() ); ?>"
								<?php echo esc_attr( $wishlist_attr ); ?>
							>
								<i class="adfy-wishlist-icon trash-2"></i>
							</button>
							<?php
						} else {
							$remove_from_wishlist_class = $guest ? ' addonify-wishlist-remove-from-wishlist ' : ' adfy-wishlist-remove-btn ';
							?>
							<button 
								type="submit"
								class="adfy-wishlist-btn <?php echo esc_attr( $remove_from_wishlist_class ); ?> addonify-wishlist-icon"
								name="addonify-remove-from-wishlist"
								data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
								value="<?php echo esc_attr( $product->get_id() ); ?>"
								<?php echo esc_attr( $wishlist_attr ); ?>
							>
								<i class="adfy-wishlist-icon trash-2"></i>
							</button>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</li>
		<?php
	}
}
