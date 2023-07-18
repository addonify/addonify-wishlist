<?php
/**
 * Template for displaying wishlist items in wishlist page.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/public/templates
 */

do_action( 'addonify_wishlist_before_wishlist_form' );

if (
	is_array( $products_data ) &&
	count( $products_data ) > 0
) {
	?>
	<form action="#" method="POST" id="addonify-wishlist-page-form">

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
				foreach ( $products_data as $product_id => $product_data ) {
					?>
					<tr
						class="addonify-wishlist-table-product-row"
						data-product_row="addonify-wishlist-table-product-row-<?php echo esc_attr( $product_id ); ?>"
						data-product_name="<?php echo esc_attr( $product_data['name'] ); ?>"
					>
						<td class="remove">
							<?php
							$remove_class = isset( $guest ) ? ' addonify-wishlist-table-remove-from-wishlist ' : ' addonify-wishlist-ajax-remove-from-wishlist ';
							?>
							<button 
								class="adfy-wishlist-btn addonify-wishlist-icon <?php echo esc_attr( $remove_class ); ?> addonify-wishlist-table-button" 
								name="addonify_wishlist_remove"
								<?php
								foreach ( $product_data['data_attrs'] as $data_attr => $data_value ) {
									echo 'data-' . esc_attr( $data_attr ) . '="' . esc_attr( $data_value ) . '" ';
								}
								?>
								data-source="wishlist-table"
							>
								<i class="adfy-wishlist-icon trash-2"></i>
							</button>
						</td>
						<td class="image">
							<a href="<?php echo esc_url( $product_data['permalink'] ); ?>">
								<?php echo wp_kses_post( $product_data['image'] ); ?>
							</a>
						</td>
						<td class="name">
							<a href="<?php echo esc_url( $product_data['permalink'] ); ?>">
								<?php echo wp_kses_post( $product_data['name'] ); ?>
							</a>
						</td>
						<td class="price">
							<?php echo wp_kses_post( $product_data['price'] ); ?>
						</td>
						<td class="stock">
							<span class="stock-label <?php echo esc_attr( $product_data['stock_status']['class'] ); ?>">
								<?php echo esc_html( $product_data['stock_status']['avaibility'] ); ?>
							</span>
						</td>
						<td class="actions">
							<?php
							echo do_shortcode( '[add_to_cart id=' . $product_id . ' show_price=false style="" class="adfy-wishlist-clear-shortcode-button-style adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-table-button"]' );
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
			<?php
			if (
				addonify_wishlist_get_option( 'show_wishlist_emptying_button' ) === '1' &&
				! empty( addonify_wishlist_get_option( 'clear_wishlist_label' ) )
			) {
				?>
				<button type="button" id="addonify-wishlist__clear-all" class="button adfy-wishlist-btn"><?php echo esc_html( addonify_wishlist_get_option( 'clear_wishlist_label' ) ); ?></button>
				<?php
			}
			?>
		</div>		
	</form>
	<?php
} else {
	do_action( 'addonify_wishlist_empty_wishlist_content' );
}

do_action( 'addonify_wishlist_after_wishlist_form' );
