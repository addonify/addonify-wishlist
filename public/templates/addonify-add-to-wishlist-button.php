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

$label = ( $button_label ) ? '<span class="addonify-wishlist-btn-label">' . esc_html( $button_label ) . ' </span>' : '';

// If icon is enabled, icon is displayed before the button lable.
if ( $display_icon ) {
	$label = '<i class="icon adfy-wishlist-icon ' . esc_attr( $icon ) . '"></i> ' . $label;
}

if ( $require_login == true ) {
	if ( $login_url ) {
		?>
		<a 
			href="<?php echo esc_url( $login_url ); ?>" 
			class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>"
			data-product_id="<?php echo esc_attr( $product_id ); ?>" 
			data-product_name="<?php echo esc_attr( $product_name ); ?>"
		>
			<?php echo wp_kses_post( $label ); ?>
		</a>
		<?php
	} else {
		?>
		<button
			class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>" 
			data-product_id="<?php echo esc_attr( $product_id ); ?>" 
			data-product_name="<?php echo esc_attr( $product_name ); ?>"
		>
			<?php echo wp_kses_post( $label ); ?>
		</button>
		<?php
	}
} else {

	if ( $display_popup_notice ) {
		?>
		<button 
			class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>" 
			data-product_id="<?php echo esc_attr( $product_id ); ?>" 
			data-product_name="<?php echo esc_attr( $product_name ); ?>"
		>
			<?php echo wp_kses_post( $label ); ?>
		</button>
		<?php
	} else {
		?>
		<a 
			href="?addonify-add-to-wishlist=<?php echo esc_attr( $product_id ); ?>"
			class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>" 
			data-product_id="<?php echo esc_attr( $product_id ); ?>" 
			data-product_name="<?php echo esc_attr( $product_name ); ?>"
		>
			<?php echo wp_kses_post( $label ); ?>
		</a>
		<?php
	}
}