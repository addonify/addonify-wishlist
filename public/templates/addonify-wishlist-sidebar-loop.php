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
	isset( $data['wishlist_product_ids'] ) &&
	is_array( $data['wishlist_product_ids'] ) && 
	count( $data['wishlist_product_ids'] ) > 0 
) {
	foreach ( $data['wishlist_product_ids'] as $product_id ) {

		$product = wc_get_product( $product_id );
		?>
		<li class="addonify-wishlist-sidebar-item">
			<div class="adfy-wishlist-row">
				<div class="adfy-wishlist-col image-column">
					<div class="adfy-wishlist-woo-image">
						<?php
						$product_post_thumbnail_id = $product->get_image_id();
						if ( $product->get_image() ) {
							?>
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo $product->get_image(array(72, 72)); ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="adfy-wishlist-col title-price-column">
					<div class="adfy-wishlist-woo-title"><?php echo $product->get_title(); ?></div>
					<div class="adfy-wishlist-woo-price"><?php echo $product->get_price_html(); ?></div>
				</div>
			</div>

			<div class="adfy-wishlist-woo-action">
				<div class="adfy-wishlist-row">
					<div class="adfy-wishlist-col cart-column">
						<?php
						if ( in_array( $product->get_type(), array( 'simple', 'external' ) ) ) {
							if ( $product->is_in_stock() ) {
								?>
								<button type="submit" class="button adfy-wishlist-btn" name="addonify_wishlist_add_to_cart" value="<?php echo esc_attr( $product_id ); ?>"><?php echo esc_html( $product->add_to_cart_text() ); ?></button>
								<?php
							}
						} else {
							$add_to_cart_button_classes = array(
								'button',
								'adfy-wishlist-btn',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
								$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
							);

							$add_to_cart_button_attributes = array(
								'data-product_id'  => $product->get_id(),
								'data-product_sku' => $product->get_sku(),
								'aria-label'       => $product->add_to_cart_description(),
								'rel'              => 'nofollow',
							);
							?>
							<a href="<?php echo esc_url( $product->add_to_cart_url() ) ?>" class="<?php echo esc_attr( implode( ' ', $add_to_cart_button_classes ) ); ?>" <?php echo wc_implode_html_attributes( $add_to_cart_button_attributes ); ?>>
								<?php echo esc_html( $product->add_to_cart_text() ); ?>
							</a>
							<?php
						}	
						?>
					</div>
					<div class="adfy-wishlist-col remove-item-column">
						<button type="submit" class="adfy-wishlist-btn adfy-wishlist-remove-btn addonify-wishlist-icon" name="addonify_wishlist_remove" value="<?php echo esc_attr( $product->get_id() ); ?>"><i class="adfy-wishlist-icon trash-2"></i></button>
					</div>
				</div>
			</div>
		</li>
		<?php
	}
}
