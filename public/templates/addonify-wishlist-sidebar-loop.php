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

if ( isset( $wishlist_data ) && count( $wishlist_data ) > 0 ) :
	$i = 1;
	$sidebar_max_item = apply_filters( 'addonify_wishlist_sidebar_max_item', 10 );
	foreach ( $wishlist_data as $value ) :
		if ( $i >= $sidebar_max_item ) {
			break;
		}
		?>
<li class="addonify-wishlist-sidebar-item">

	<div class="adfy-wishlist-row">

		<div class="adfy-wishlist-col image-column">
			<div class="adfy-wishlist-woo-image"><?php echo wp_kses_post( $value['image'] ); ?></div>
		</div>

		<div class="adfy-wishlist-col title-price-column">
			<div class="adfy-wishlist-woo-title"><?php echo wp_kses_post( $value['title'] ); ?></div>
			<div class="adfy-wishlist-woo-price"><?php echo wp_kses_post( $value['price'] ); ?></div>
		</div>

	</div>

	<div class="adfy-wishlist-woo-action">
		<div class="adfy-wishlist-row">
			<div class="adfy-wishlist-col cart-column"><?php echo wp_kses_post( $value['add_to_cart'] ); ?></div>
			<div class="adfy-wishlist-col remove-item-column">
				<?php echo wp_kses_post( $value['remove_btn'] ); ?>
			</div>
		</div>
	</div>

</li>
		<?php
		$i++;
	endforeach;
endif;
?>
