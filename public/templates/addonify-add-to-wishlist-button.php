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

$wishlist               = '';
$button_label_preserved = '';
if ( isset( $parent_wishlist_id ) ) {
	$wishlist = 'data-wishlist_id="' . $parent_wishlist_id . '"';
} else {
	$parent_wishlist_id = '';
}
if ( $preserve_button_label ) {
	$button_label_preserved = 'data-wishlist_label="' . esc_html( $preserve_button_label ) . '"';
}

if ( true === $require_login ) {
	if ( $login_url ) {
		?>
		<a
			href="<?php echo esc_url( $login_url ); ?>" 
			class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>"
			data-product_id="<?php echo esc_attr( $product_id ); ?>" 
			data-product_name="<?php echo esc_attr( $product_name ); ?>"
			<?php echo $button_label_preserved; //phpcs:ignore ?>
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
			<?php echo $button_label_preserved; //phpcs:ignore ?>
		>
			<?php echo wp_kses_post( $label ); ?>
		</button>
		<?php
	}
} else {

	if (
		( addonify_wishlist_get_option( 'after_add_to_wishlist_action' ) === 'redirect_to_wishlist_page' ) &&
		is_user_logged_in()
	) {
		if ( ! $in_wishlist ) {
			?>
			<a
				href="?addonify-add-to-wishlist=<?php echo esc_attr( $product_id ); ?>"
				class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>" 
				data-product_id="<?php echo esc_attr( $product_id ); ?>" 
				data-product_name="<?php echo esc_attr( $product_name ); ?>"
				<?php echo esc_attr( $wishlist ); ?>
				<?php echo $button_label_preserved; //phpcs:ignore ?>
			>
				<?php echo wp_kses_post( $label ); ?>
			</a>
			<?php
		} else {
			?>
			<a
				href="?addonify-remove-from-wishlist=<?php echo esc_attr( $product_id ); ?>&wishlist=<?php echo esc_attr( $parent_wishlist_id ); ?>"
				class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>" 
				data-product_id="<?php echo esc_attr( $product_id ); ?>" 
				data-product_name="<?php echo esc_attr( $product_name ); ?>"
				<?php echo esc_attr( $wishlist ); ?>
				<?php echo $button_label_preserved; //phpcs:ignore ?>
			>
				<?php echo wp_kses_post( $label ); ?>
			</a>
			<?php
		}
	} else {
		?>
		<button
			class="<?php echo esc_attr( implode( ' ', $button_classes ) ); ?>" 
			data-product_id="<?php echo esc_attr( $product_id ); ?>" 
			data-product_name="<?php echo esc_attr( $product_name ); ?>"
			<?php echo $button_label_preserved; //phpcs:ignore ?>
		>
			<?php echo wp_kses_post( $label ); ?>
		</button>
		<?php
	}
}
