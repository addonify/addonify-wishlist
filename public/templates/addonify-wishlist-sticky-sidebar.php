<?php
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;
?>

<button type="button" id="addonify-wishlist-show-sidebar-btn" class="<?php echo sanitize_html_class( $data['alignment'] );  if( addonify_wishlist_get_total_items() < 1 ) echo ' hidden '; ?>" ><?php _e( 'Wishlist', 'addonify-wishlist' ); ?></button>

<div id="addonify-wishlist-sticky-sidebar-container" class="<?php echo sanitize_html_class( $data['alignment'] ); ?>"  >
    
    <div class="addonify-wishlist-ssc-body">

        <h3><?php echo $data['wishlist_name'];?></h3>
        
        <form action="" method="POST" >
            <input type="hidden" name="nonce" value="<?php echo esc_html( $data['nonce'] );?>" >
            <input type="hidden" name="process_addonify_wishlist_form" value="1" >

            <ul id="addonify-wishlist-sidebar-items" >
                <?php echo $data['loop']; ?>
            </ul> <!--addonify-wishlist-sidebar-items-->        
        </form>

    </div> <!--addonify-wishlist-ssc-body-->

    <div class="addonify-wishlist-ssc-footer">
        <a href="<?php echo esc_url_raw( $data['wishlist_url'] );?>" class="addonify-wishlist-goto-wishlist-btn"><?php _e( 'View all Wishlist', 'ddonify-wishlist' );?></a>
    </div>

</div> <!--addonify-wishlist-sticky-sidebar-container-->

