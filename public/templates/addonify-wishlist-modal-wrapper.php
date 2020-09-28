<div id="addonify-wishlist-modal-wrapper" class="<?php echo sanitize_html_class( $css_class );?>">
    <div class="addonify-wishlist-modal-body">
        <div id="addonify-wishlist-modal-response"></div><!--addonify-wishlist-modal-response-->
        <div class="addonify-wishlist-modal-btns">

            <?php do_action( 'addonify_wishlist_view_wishlist_btn', $btn_label ); ?>
            <?php do_action( 'addonify_wishlist_login_from_modal_btn', __( 'Login', 'addonify-wishlist' ), $redirect_url ); ?>
            <?php do_action( 'addonify_wishlist_close_modal_btn', __( 'Close', 'addonify-wishlist' ) ); ?>

        </div> <!--addonify-wishlist-modal-btns-->
    </div><!--addonify-wishlist-modal-body-->
</div><!--addonify-wishlist-modal-wrapper-->