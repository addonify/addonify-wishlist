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

if ( function_exists( 'wc_print_notices' ) ) {
	wc_print_notices();
}
?>

<div id="addonify-wishlist-page-container">
	<?php do_action( 'addonify_wishlist/before_wishlist_form' ); ?>
	<?php
	if ( 
		is_array( $wishlist_product_ids ) && 
		count( $wishlist_product_ids ) > 0 
	) {
		?>
		<form action="" method="POST" id="addonify-wishlist-page-form">

			<?php do_action( 'addonify_wishlist/before_wishlist_form_table' ); ?>

			<table id="addonify-wishlist-table">
				<thead class="addonify-wishlist-items-heading">
					<tr>
						<th class="remove"></th>
						<th class="image"><?php echo esc_html__( 'Product Image', 'addonify-wishlist' ); ?></th>
						<th class="name"><?php echo esc_html__( 'Product Name', 'addonify-wishlist' ); ?></th>
						<th class="price"><?php echo esc_html__( 'Unit Price', 'addonify-wishlist' ); ?></th>
						<th class="stock"><?php echo esc_html__( 'Stock Status', 'addonify-wishlist' ); ?></th>
						<th class="cart"><?php echo esc_html__( 'Actions', 'addonify-wishlist' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $wishlist_product_ids as $product_id ) {

						$product = wc_get_product( $product_id );
						?>
						<tr data-product_row="addonify-wishlist-table-product-row-<?php echo esc_attr( $product_id ); ?>">
							<td class="remove">
								<?php 
								if ( (int) addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' ) == 1 ) {
									?>
									<button 
										class="adfy-wishlist-btn addonify-wishlist-icon addonify-wishlist-ajax-remove-from-wishlist addonify-wishlist-table-button" 
										name="addonify_wishlist_remove" 
										value="<?php echo esc_attr( $product_id ); ?>"
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
										value="<?php echo esc_attr( $product_id ); ?>"
									>
										<i class="adfy-wishlist-icon trash-2"></i>
									</button>
									<?php
								}
								?>
							</td>
							<td class="image">
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
							</td>
							<td class="name">
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo wp_kses_post( $product->get_title() ); ?>
								</a>
							</td>
							<td class="price">
								<?php echo wp_kses_post( $product->get_price_html() ); ?>
							</td>
							<td class="stock">
								<?php 
								if ( $product->get_stock_status() ) {
									switch ( $product->get_stock_status() ) {
										case 'instock':
											echo esc_html__( 'In Stock', 'addonify-wishlist' );
											break;
										case 'outofstock':
											echo esc_html__( 'Out of Stock', 'addonify-wishlist' );
											break;
										default:
											break;
									}
								}
								?>
							</td>
							<td class="actions">
								<?php
								if ( in_array( $product->get_type(), array( 'simple', 'external' ) ) ) {
									if ( $product->is_in_stock() ) {

										if ( (int) addonify_wishlist_get_option( 'ajaxify_add_to_cart' ) == 1 ) {
											?>
											<button 
												class="button adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-ajax-add-to-cart addonify-wishlist-table-button" 
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
												value="<?php echo esc_attr( $product_id ); ?>"
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
										'adfy-wishlist-btn',
										'addonify-wishlist-table-button',
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
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php do_action( 'addonify_wishlist/after_wishlist_form_table' ); ?>		
		</form>
		<?php 
	} else {
		echo esc_html__( 'Your wishlist is empty.', 'addonify-wishlist' );
	}
	?>
	<?php do_action( 'addonify_wishlist/after_wishlist_form' ); ?>
</div>
