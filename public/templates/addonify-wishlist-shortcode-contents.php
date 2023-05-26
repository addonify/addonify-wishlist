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

	<div id="addonify-wishlist-notice" class="addonify-wishlist-notice"></div>

	<div id="addonify-wishlist-empty">
		<?php
		if (
			is_array( $wishlist_product_ids ) &&
			count( $wishlist_product_ids ) <= 0
		) {
			if ( addonify_wishlist_get_option( 'show_empty_wishlist_navigation_link' ) ) {
				$page_link = get_permalink( addonify_wishlist_get_option( 'empty_wishlist_navigation_link' ) );
				echo '<p id="addonify-empty-wishlist-para">';
				echo esc_html( addonify_wishlist_get_option( 'empty_wishlist_label' ) );
				echo "<a href='" . esc_url( $page_link ) . "'>" . esc_html( addonify_wishlist_get_option( 'empty_wishlist_navigation_link_label' ) ) . '</a>';
				echo '</p>';
			}
		}
		?>
	</div>
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
						$wishlist_attr = '';
						if ( is_user_logged_in() ) {
							global $addonify_wishlist;

							$parent_wishlist_id = $addonify_wishlist->get_wishlist_id_from_product_id( $product_id );
							if ( $parent_wishlist_id ) {
								$wishlist_attr = 'data-wishlist_id=' . $parent_wishlist_id;
							}
						}

						$product = wc_get_product( $product_id );
						?>
						<tr
							class="addonify-wishlist-table-product-row"
							data-product_row="addonify-wishlist-table-product-row-<?php echo esc_attr( $product_id ); ?>"
							data-product_name="<?php echo esc_attr( $product->get_name() ); ?>"
						>
							<td class="remove">
								<?php
								$remove_class = isset( $guest ) ? ' addonify-wishlist-table-remove-from-wishlist ' : ' addonify-wishlist-ajax-remove-from-wishlist ';
								?>
								<button 
									class="adfy-wishlist-btn addonify-wishlist-icon <?php echo esc_html( $remove_class ); ?> addonify-wishlist-table-button" 
									name="addonify_wishlist_remove"
									data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
									value="<?php echo esc_attr( $product_id ); ?>"
									<?php echo esc_attr( $wishlist_attr ); ?>
								>
									<i class="adfy-wishlist-icon trash-2"></i>
								</button>
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
								$product_avaibility = addonify_wishlist_get_product_avaibility( $product );
								if ( $product_avaibility ) {
									echo esc_html( $product_avaibility['avaibility'] );
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
				<?php
				if ( addonify_wishlist_get_option( 'show_wishlist_emptying_button' ) ) {
					?>
					<button type="button" id="addonify-wishlist__clear-all" class="button adfy-wishlist-btn"><?php echo esc_html( addonify_wishlist_get_option( 'clear_wishlist_label' ) ); ?></button>
					<?php
				}
				?>
			</div>		
		</form>
		<?php
	}
	?>
	<?php do_action( 'addonify_wishlist_after_wishlist_form' ); ?>
</div>
