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

$label = '<span class="addonify-wishlist-btn-label">' . ( ( $button_label ) ? esc_html( $button_label ) : '' ) . ' </span>';

// If icon is enabled, icon is displayed before the button lable.
if ( $display_icon ) {
	if ( esc_html( addonify_wishlist_get_option( 'icon_position' ) ) === 'right' ) {
		$label = $label . '<i class="icon adfy-wishlist-icon ' . esc_attr( $icon ) . '"></i> ';
	} else {
		$label = '<i class="icon adfy-wishlist-icon ' . esc_attr( $icon ) . '"></i> ' . $label;
	}
}

$button_label_preserved = '';
if ( $preserve_button_label ) {
	$button_label_preserved = 'data-wishlist_label="' . esc_html( $preserve_button_label ) . '"';
}

$data_attributes = '';

if ( $data_attrs ) {
	foreach ( $data_attrs as $data_attrs_id => $data_attrs_value ) {
		$data_attributes .= 'data-' . $data_attrs_id . '="' . $data_attrs_value . '" ';
	}
}
?>
<button
	class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>" 
	<?php echo $data_attributes; // phpcs:ignore ?>
	<?php echo $button_label_preserved; //phpcs:ignore ?>
>
	<?php echo wp_kses_post( $label ); ?>
</button>
