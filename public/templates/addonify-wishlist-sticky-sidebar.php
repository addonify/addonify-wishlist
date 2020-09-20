<?php
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;
?>

<button type="button" id="addonify-wishlist-show-sidebar-btn" class="<?php if( addonify_wishlist_get_total_items() < 1 ) echo 'hidden';?>" ><?php _e( 'Wishlist', 'addonify-wishlist' );?></button>

<div id="addonify-wishlist-sticky-sidebar-container" >
    
    <div class="addonify-wishlist-ssc-body">

        <h3><?php echo $data['wishlist_name'];?></h3>
        
        <ul id="addonify-wishlist-sidebar-items" >
            <?php echo $data['loop']; ?>
        </ul> <!--addonify-wishlist-sidebar-items-->        

    </div> <!--addonify-wishlist-ssc-body-->

    <div class="addonify-wishlist-ssc-footer">
        <a href="<?php echo esc_html( $data['wishlist_url'] );?>" class="addonify-wishlist-goto-wishlist-btn"><?php _e( 'View all Wishlist', 'ddonify-wishlist' );?></a>
    </div>

</div> <!--addonify-wishlist-sticky-sidebar-container-->

