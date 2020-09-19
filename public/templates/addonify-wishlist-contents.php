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
                <li class="name">Product Name</li>
                <li class="price">Unit Price</li>
                <li class="date">Added Date</li>
                <li class="stock">Stock</li>
                <li class="cart"></li>
            </ul>
        </div> <!--wishlist-container-heading-->

        <?php 
            if( isset( $data['wishlist_data'] ) && count( $data['wishlist_data'] ) > 0 ):
                foreach( $data['wishlist_data'] as $value ):
        ?>

            <div class="addonify-wishlist-items-package">
                <ul>
                    <li class="checkbox" ><input type="checkbox" name="product_ids[]" value="<?php echo $value['id'];?>" class="addonify-wishlist-product-id" ></li>
                    <li class="remove"><button type="submit" name="addonify_wishlist_remove" value="<?php echo $value['id'];?>">x</button></li>
                    <li class="image"><?php echo $value['image'];?></li>
                    <li class="name"><?php echo $value['title'];?></li>
                    <li class="price"><?php echo $value['price'];?></li>
                    <li class="date"><?php echo date( 'F d, Y', $value['date_added'] );?></li>
                    <li class="stock"><?php echo $value['stock'];?></li>
                    <li class="cart"><?php echo $value['add_to_cart'];?></li>
                </ul>
            </div> <!--wishlist-container-heading-->

        <?php endforeach; else: ?>
            <div class="addonify-wishlist-items-package addonify-wishlist-is-empty">
                    Your wishlist is empty
            </div> <!--wishlist-container-heading-->
        <?php endif;?>

        <div class="addonify-wishlist-footer-actions">
            <div class="addonify-wfa-packets">
                <select name="addonify_wishlist_action" >
                    <option value="" >Actions</option>
                    <option value="add_selected_to_cart" >Add to cart</option>
                    <option value="remove" >Remove</option>
                </select>
                <button type="submit" >Apply Action</button>
            </div> <!--addonify-wfa-packets-->
            
            <div class="addonify-wfa-packets go-right">
                <button type="submit" class="addonify_add_to_cart" name="addonify_wishlist_action" value="add_selected_to_cart" >Add Selected to Cart</button>
                <button type="submit" class="addonify_add_to_cart" name="addonify_wishlist_action" value="add_all_to_cart" >Add All to Cart</button>
            </div> <!--addonify-wfa-packets-->
            
        <div>

    </form>

</div><!--wishlist-contaienr-->
