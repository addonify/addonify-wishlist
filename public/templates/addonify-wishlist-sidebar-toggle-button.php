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

<button id="addonify-wishlist-show-sidebar-btn" class="adfy-wishlist-clear-button-style <?php echo esc_attr( $css_classes ); ?>">
	<?php
	if ( $show_icon ) {
		?>
		<span class="button-icon">
			<i class="adfy-wishlist-icon <?php echo esc_attr( $icon ); ?>"></i>
		</span>
		<?php
	}
	?>
	<span class="button-label"><?php echo esc_html( $label ); ?></span>
</button>

