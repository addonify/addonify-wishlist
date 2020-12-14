<div id="addonify-wishlist-modal-wrapper" class="<?php echo esc_html( $css_classes );?>">
    <div class="addonify-wishlist-modal-body">
    	<div class="adfy-wishlist-icon-entry">
            <i class="adfy-wishlist-icon adfy-status-success heart-o-style-three" stye="display: none; " ></i>
            <i class="adfy-wishlist-icon adfy-status-error flash" stye="display: none; " ></i>
    	</div><!-- // adfy-wishlist-icon-entry -->
        <div id="addonify-wishlist-modal-response"></div><!--addonify-wishlist-modal-response-->
        <div class="addonify-wishlist-modal-btns">
            <?php do_action( 'addonify_wishlist_modal_btns' ); ?>
        </div> <!--addonify-wishlist-modal-btns-->
    </div><!--addonify-wishlist-modal-body-->
</div><!--addonify-wishlist-modal-wrapper-->