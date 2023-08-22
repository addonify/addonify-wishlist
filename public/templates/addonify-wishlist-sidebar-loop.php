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

$empty_notice_css_class     = '';
$wishlist_sidebar_css_class = '';

if (
	is_array( $products_data ) &&
	count( $products_data ) > 0
) {
	$empty_notice_css_class     = 'adfy-wishlist-hide';
	$wishlist_sidebar_css_class = 'adfy-wishlist-show';
} else {
	$empty_notice_css_class     = 'adfy-wishlist-show';
	$wishlist_sidebar_css_class = 'adfy-wishlist-hide';
}
?>
<ul
	id="addonify-wishlist-sidebar-ul"
	class="adfy-wishlist-sidebar-items-entry <?php echo esc_attr( $wishlist_sidebar_css_class ); ?>"
>
	<?php
	foreach ( $products_data as $product_id => $product_data ) {

		$product = wc_get_product( (int) $product_id );

		do_action( 'addonify_wishlist_render_sidebar_product_row', $product );
	}
	?>
</ul>

<p
	id="adfy-wishlist-empty-sidebar-para"
	class="adfy-wishlist-empty-sidebar <?php echo esc_attr( $empty_notice_css_class ); ?>"
>
	<?php echo esc_html( addonify_wishlist_get_option( 'sidebar_empty_wishlist_label' ) ); ?>
</p>
