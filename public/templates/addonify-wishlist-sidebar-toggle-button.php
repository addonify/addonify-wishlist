<?php
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

?>

<button type="button" id="addonify-wishlist-show-sidebar-btn" class="<?php echo esc_attr( $css_class );  if( addonify_wishlist_get_total_items() < 1 ) echo ' hidden '; ?>" ><?php echo esc_attr( $label ); ?></button>