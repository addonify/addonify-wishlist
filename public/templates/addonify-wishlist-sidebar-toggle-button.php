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

<a id="addonify-wishlist-show-sidebar-btn" class="<?php echo esc_attr( $css_classes ); ?>">
	<?php if ( $show_icon ) : ?>
		<span class="button-icon"><i class="adfy-wishlist-icon <?php echo esc_attr( $icon ); ?>"></i> </span>
	<?php endif; ?>

	<span class="button-label"><?php echo wp_kses_post( $label ); ?></span>
</a>
