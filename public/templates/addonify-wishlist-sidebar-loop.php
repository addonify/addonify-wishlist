<?php 
    if( isset( $wishlist_data ) && count( $wishlist_data ) > 0 ):
        $i = 1;
        foreach( $wishlist_data as $value ):
            if( $i >= 10 ) break;
?>
    <li class="addonify-wishlist-sidebar-item">

        <div class="adfy-wishlist-row">
            
            <div class="adfy-wishlist-col image-column">
                <div class="adfy-wishlist-woo-image"><?php echo $value['image'];?></div>
            </div>

            <div class="adfy-wishlist-col title-price-column">
                <div class="adfy-wishlist-woo-title"><?php echo $value['title'];?></div>
                <div class="adfy-wishlist-woo-price"><?php echo $value['price'];?></div>
            </div>

        </div>

        <div class="adfy-wishlist-woo-action">
            <div class="adfy-wishlist-row">
                <div class="adfy-wishlist-col cart-column"><?php echo $value['add_to_cart'];?></div><!-- // adfy-wishlist-col -->
                <div class="adfy-wishlist-col remove-item-column">
                    <button type="submit" class="adfy-wishlist-btn addonify-wishlist-icon" name="addonify_wishlist_remove" value="<?php echo $value['id'];?>"><i class="adfy-wishlist-icon trash-2"></i></button>
                </div>
            </div>
        </div>

    </li>
<?php 
            $i++;
        endforeach;
    endif;
?>