<?php
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;
?>

<div id="addonify-wishlist-sticky-sidebar-container" class="<?php echo esc_attr( $css_class ); ?>"  >
    
    <div class="addonify-wishlist-ssc-body">

        <h3><?php echo esc_attr( $title );?></h3>
        
        <form action="" method="POST" id="addonify-wishlist-sidebar-form" >
            <input type="hidden" name="nonce" value="<?php echo esc_html( $nonce );?>" >
            <input type="hidden" name="process_addonify_wishlist_form" value="ajax" >

            <ul id="addonify-wishlist-sidebar-items" >
                <?php echo $loop; ?>
            </ul> <!--addonify-wishlist-sidebar-items-->        
        </form>

    </div> <!--addonify-wishlist-ssc-body-->

    <div class="addonify-wishlist-ssc-footer">
        <a href="<?php echo esc_url_raw( $wishlist_url );?>" class="addonify-wishlist-goto-wishlist-btn"><?php _e( 'View all Wishlist', 'addonify-wishlist' );?></a>
    </div>

</div> <!--addonify-wishlist-sticky-sidebar-container-->