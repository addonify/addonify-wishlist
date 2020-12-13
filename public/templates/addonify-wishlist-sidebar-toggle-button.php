<?php
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

?>

<a id="addonify-wishlist-show-sidebar-btn" class="<?php echo $css_classes; ?>">
    <?php if( $show_icon ) :?>
        <span class="button-icon"><i class="adfy-wishlist-icon <?php echo esc_attr( $icon );?>"></i> </span>
    <?php endif;?>

    <span class="button-label"><?php echo $label; ?></span>
</a>