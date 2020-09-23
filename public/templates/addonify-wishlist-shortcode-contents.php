<?php
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;
?>
<h2><?php echo esc_html( $data['wishlist_name'] );?></h2>

<div id="addonify-wishlist-container">

    <form action="" method="POST" >

        <input type="hidden" name="nonce" value="<?php echo esc_html( $data['nonce'] );?>" >
        <input type="hidden" name="process_addonify_wishlist_form" value="1" >
        
        <div class="addonify-wishlist-items-heading">
            <ul>
                <li class="checkbox" ><input type="checkbox" class="addonify-wishlist-check-all" ></li>
                <li class="remove"></li>
                <li class="image"></li>
                <li class="name"><?php _e( 'Product Name', 'addonify-wishlist' );?></li>
                <li class="price"><?php _e( 'Unit Price', 'addonify-wishlist' );?></li>
                <li class="date"><?php _e( 'Added Date', 'addonify-wishlist' );?></li>
                <li class="stock"><?php _e( 'Stock', 'addonify-wishlist' );?></li>
                <li class="cart"></li>
            </ul>
        </div> <!--addonify-wishlist-items-heading-->

        <?php 
            if( isset( $data['wishlist_data'] ) && count( $data['wishlist_data'] ) > 0 ):
                foreach( $data['wishlist_data'] as $value ):
        ?>

            <div class="addonify-wishlist-items-package">
                <ul>
                    <li class="checkbox" ><input type="checkbox" name="product_ids[]" value="<?php echo $value['id'];?>" class="addonify-wishlist-product-id" ></li>
                    <li class="remove"><?php echo $value['remove_btn'];?></li>
                    <li class="image"><?php echo $value['image'];?></li>
                    <li class="name"><?php echo $value['title'];?></li>
                    <li class="price"><?php echo $value['price'];?></li>
                    <li class="date"><?php echo date( 'F d, Y', $value['date_added'] );?></li>
                    <li class="stock"><?php echo $value['stock'];?></li>
                    <li class="cart"><?php echo $value['add_to_cart'];?></li>
                </ul>
            </div> <!--addonify-wishlist-items-package-->

        <?php endforeach; else: ?>
            <div class="addonify-wishlist-items-package addonify-wishlist-is-empty">
                <?php _e( 'Your wishlist is empty', 'addonify-wishlist' );?>
            </div> <!--addonify-wishlist-items-package-->
        <?php endif;?>

        <div class="addonify-wishlist-footer-actions">
            <div class="addonify-wfa-packets">
                <select name="addonify_wishlist_action" >
                    <option value="" ><?php _e( 'Actions', 'addonify-wishlist' );?></option>
                    <option value="add_selected_to_cart" ><?php _e( 'Add to cart', 'addonify-wishlist' );?></option>
                    <option value="remove" ><?php _e( 'Remove', 'addonify-wishlist' );?></option>
                </select>
                <button type="submit" ><?php _e( 'Apply Action', 'addonify-wishlist' );?></button>
            </div> <!--addonify-wfa-packets-->
            
            <div class="addonify-wfa-packets go-right">
                <button type="submit" class="addonify_add_to_cart" name="addonify_wishlist_action" value="add_selected_to_cart" ><?php _e( 'Add Selected to Cart', 'addonify-wishlist' );?></button>
                <button type="submit" class="addonify_add_to_cart" name="addonify_wishlist_action" value="add_all_to_cart" ><?php _e( 'Add All to Cart', 'addonify-wishlist' );?></button>
            </div> <!--addonify-wfa-packets-->
            
        <div> <!--addonify-wishlist-footer-actions-->
        
    </form>

</div><!--addonify-wishlist-container-->
