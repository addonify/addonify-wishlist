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

$empty_notice_css_class        = '';
$wishlist_table_form_css_class = '';

if (
	is_array( $wishlist_product_ids ) &&
	count( $wishlist_product_ids ) > 0
) {
	$empty_notice_css_class        = 'adfy-wishlist-hide';
	$wishlist_table_form_css_class = 'adfy-wishlist-show';
} else {
	$empty_notice_css_class        = 'adfy-wishlist-show';
	$wishlist_table_form_css_class = 'adfy-wishlist-hide';
}
?>
<form
	action="#"
	method="POST"
	id="addonify-wishlist-page-form"
	class="adfy-wishlist-table-from <?php echo esc_attr( $wishlist_table_form_css_class ); ?>"
>
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
		<tbody id="adfy-wishlist-table-body">
			<?php
			foreach ( $wishlist_product_ids as $product_id ) {

				$product = wc_get_product( (int) $product_id );

				do_action( 'addonify_wishlist_render_table_product_row', $product );
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

<p
	id="addonify-empty-wishlist-para"
	class="adfy-wishlist-empty-table <?php echo esc_attr( $empty_notice_css_class ); ?>"
>
	<?php echo esc_html( addonify_wishlist_get_option( 'empty_wishlist_label' ) ); ?>
	<?php
	if (
		addonify_wishlist_get_option( 'show_empty_wishlist_navigation_link' ) === '1' &&
		! empty( addonify_wishlist_get_option( 'empty_wishlist_navigation_link' ) )
	) {
		$page_link = get_permalink( addonify_wishlist_get_option( 'empty_wishlist_navigation_link' ) );
		?>
		<a href="<?php echo esc_url( get_permalink( addonify_wishlist_get_option( 'empty_wishlist_navigation_link' ) ) ); ?>"><?php echo esc_html( addonify_wishlist_get_option( 'empty_wishlist_navigation_link_label' ) ); ?></a>
		<?php
	}
	?>
</p>
<?php
do_action( 'addonify_wishlist_after_wishlist_form' );
