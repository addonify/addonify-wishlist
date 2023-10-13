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
<button
	class="button adfy-wishlist-btn addonify-add-to-wishlist-btn addonify-wishlist-ajax-add-to-wishlist <?php echo esc_attr( implode( ' ', $classes ) ); ?>" 
	data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
	data-product_name="<?php echo esc_attr( $product->get_name() ); ?>"
	<?php
	if ( isset( $data_attrs ) ) {
		foreach ( $data_attrs as $index => $data_attr ) {
			echo 'data-' . esc_attr( $index ) . '="' . esc_attr( $data_attr ) . '"';
		}
	}
	?>
>
	<?php
	if ( $button_label ) {
		?>
		<span class="addonify-wishlist-btn-label"><?php echo esc_html( $button_label ); ?></span>
		<?php
	}

	if ( isset( $button_icon ) ) {
		?>
		<span class="adfy-wishlist-btn-icon">
			<?php echo addonify_wishlist_escape_svg( $button_icon ); // phpcs:ignore ?>
		</span>
		<?php
	}
	?>
</button>
