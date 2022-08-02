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

		$product = wc_get_product( $product_id );
		?>
		<li class="addonify-wishlist-sidebar-item" data-product_row="addonify-wishlist-sidebar-product-row-<?php echo esc_attr( $product_id ); ?>">
			<div class="adfy-wishlist-row">
				<div class="adfy-wishlist-col image-column">
					<div class="adfy-wishlist-woo-image">
						<?php
						$product_post_thumbnail_id = $product->get_image_id();
						if ( $product->get_image() ) {
							?>
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo wp_kses_post( $product->get_image( array(72, 72) ) ); ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="adfy-wishlist-col title-price-column">
					<div class="adfy-wishlist-woo-title">
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php echo $product->get_title(); ?>
						</a>
					</div>
					<div class="adfy-wishlist-woo-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				</div>
			</div>

			<div class="adfy-wishlist-woo-action">
				<div class="adfy-wishlist-row">
					<div class="adfy-wishlist-col cart-column">
						<?php
						if ( in_array( $product->get_type(), array( 'simple', 'external' ) ) ) {

							if ( $product->is_in_stock() ) {

								if ( (int) addonify_wishlist_get_option( 'ajaxify_add_to_cart' ) == 1 ) {
									?>
									<button 
										class="button adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-ajax-add-to-cart addonify-wishlist-sidebar-button" 
										name="addonify_wishlist_add_to_cart" 
										value="<?php echo esc_attr( $product_id ); ?>">
											<?php echo esc_html( $product->add_to_cart_text() ); ?>
									</button>
									<?php
								} else {
									?>
									<button 
										type="submit" 
										class="button adfy-wishlist-btn addonify-wishlist-add-to-cart"
										name="addonify-add-to-cart-from-wishlist"
										value="<?php echo esc_attr( $product->get_id() ); ?>"
									>
										<?php echo esc_html( $product->add_to_cart_text() ); ?>
									</button>
									<?php
								}
							} else {
								$add_to_cart_button_classes = array(
									'button',
									'adfy-wishlist-btn addonify-wishlist-add-to-cart',
									'product_type_' . $product->get_type(),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : ''
									
								);

								$add_to_cart_button_attributes = array(
									'data-product_id'  => $product->get_id(),
									'data-product_sku' => $product->get_sku(),
									'aria-label'       => $product->add_to_cart_description(),
									'rel'              => 'nofollow',
								);
								?>
								<a 
									href="<?php echo esc_url( $product->get_permalink() ) ?>" 
									class="<?php echo esc_attr( implode( ' ', $add_to_cart_button_classes ) ); ?>" 
									<?php echo wc_implode_html_attributes( $add_to_cart_button_attributes ); ?>
								>
									<?php echo esc_html( $product->add_to_cart_text() ); ?>
								</a>
								<?php
							}
						} else {
							$add_to_cart_button_classes = array(
								'button',
								'adfy-wishlist-btn addonify-wishlist-add-to-cart',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : ''
								
							);

							$add_to_cart_button_attributes = array(
								'data-product_id'  => $product->get_id(),
								'data-product_sku' => $product->get_sku(),
								'aria-label'       => $product->add_to_cart_description(),
								'rel'              => 'nofollow',
							);
							?>
							<a 
								href="<?php echo esc_url( $product->add_to_cart_url() ) ?>" 
								class="<?php echo esc_attr( implode( ' ', $add_to_cart_button_classes ) ); ?>" 
								<?php echo wc_implode_html_attributes( $add_to_cart_button_attributes ); ?>
							>
								<?php echo esc_html( $product->add_to_cart_text() ); ?>
							</a>
							<?php
						}	
						?>
					</div>
					<div class="adfy-wishlist-col remove-item-column">
						<?php 
						if ( (int) addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' ) == 1 ) {
							?>
							<button
								class="adfy-wishlist-btn adfy-wishlist-remove-btn addonify-wishlist-icon addonify-wishlist-ajax-remove-from-wishlist addonify-wishlist-sidebar-button"
								name="addonify_wishlist_remove" 
								value="<?php echo esc_attr( $product->get_id() ); ?>"
							>
								<i class="adfy-wishlist-icon trash-2"></i>
							</button>
							<?php
						} else {
							?>
							<button 
								type="submit"
								class="adfy-wishlist-btn adfy-wishlist-remove-btn addonify-wishlist-icon"
								name="addonify-remove-from-wishlist"
								value="<?php echo esc_attr( $product->get_id() ); ?>"
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
