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
<div id="addonify-wishlist-page-container">
	<?php do_action( 'addonify_wishlist_before_wishlist_form' ); ?>
	<?php
	if (
		is_array( $wishlist_product_ids ) &&
		count( $wishlist_product_ids ) > 0
	) {
		?>
		<form action="" method="POST" id="addonify-wishlist-page-form">

			<?php do_action( 'addonify_wishlist_before_wishlist_form_table' ); ?>
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
						<tr class="addonify-wishlist-table-product-row" data-product_row="addonify-wishlist-table-product-row-<?php echo esc_attr( $product_id ); ?>" data-product_name="<?php echo esc_attr( $product->get_name() ); ?>">
							<td class="remove">
								<?php
								$remove_class = isset( $guest ) ? ' addonify-wishlist-table-remove-from-wishlist ' : ' addonify-wishlist-ajax-remove-from-wishlist ';
								if ( (int) addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' ) === 1 ) {
									?>
									<button 
										class="adfy-wishlist-btn addonify-wishlist-icon <?php echo esc_html( $remove_class ); ?> addonify-wishlist-table-button" 
										name="addonify_wishlist_remove"
										data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
										value="<?php echo esc_attr( $product_id ); ?>"
									>
										<i class="adfy-wishlist-icon trash-2"></i>
									</button>
									<?php
								} else {
									$remove_class = isset( $guest ) ? ' addonify-wishlist-table-remove-from-wishlist ' : ' adfy-wishlist-remove-btn ';
									?>
									<button 
										type="submit"
										class="adfy-wishlist-btn <?php echo esc_html( $remove_class ); ?> addonify-wishlist-icon"
										name="addonify-remove-from-wishlist"
										data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
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
										<?php echo wp_kses_post( $product->get_image( array( 72, 72 ) ) ); ?>
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
								echo do_shortcode( '[add_to_cart id=' . $product->get_id() . ' show_price=false style="" class="adfy-wishlist-clear-shortcode-button-style adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-table-button"]' );
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php do_action( 'addonify_wishlist_after_wishlist_form_table' ); ?>
			<div id="addonify-wishlist-page-toolbar">
				<?php if ( addonify_wishlist_get_option( 'show_wishlist_emptying_button' ) ) : ?>
					<button type="button" id="addonify-wishlist__clear-all" class="button">Clear Wishlist</button>
				<?php endif ?>
			</div>		
		</form>
		<?php
	} else {
		echo esc_html__( 'Your wishlist is empty.', 'addonify-wishlist' );
	}
	?>
	<?php do_action( 'addonify_wishlist_after_wishlist_form' ); ?>
</div>
