<?php
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;
?>

<div id="addonify-wishlist-sticky-sidebar-container" class="<?php echo $css_class; ?>"  >
    
    <div class="addonify-wishlist-ssc-body">

        <h3><?php echo esc_attr( $title );?></h3>
        
        <form action="" method="POST" id="addonify-wishlist-sidebar-form" >
            <input type="hidden" name="nonce" value="<?php echo esc_html( $nonce );?>" >
            <input type="hidden" name="process_addonify_wishlist_form" value="ajax" >

            <div id="addonify-wishlist-sidebar-items-wrapper" >
                <ul class="adfy-wishlist-sidebar-items-entry">
                    <?php echo $loop;?>
                </ul>
            </div> <!-- addonify-wishlist-sidebar-items-wrapper -->   
        </form>
    </div> <!--addonify-wishlist-ssc-body-->

    <div class="addonify-wishlist-ssc-footer">
        <a href="<?php echo esc_url_raw( $wishlist_url );?>" class="addonify-wishlist-goto-wishlist-btn"><span class="icon"><i class="adfy-wishlist-icon external-link"></i></span>  <?php _e( 'View all Wishlist', 'addonify-wishlist' );?></a>
    </div><!-- // addonify-wishlist-ssc-footer -->

</div> <!--addonify-wishlist-sticky-sidebar-container-->