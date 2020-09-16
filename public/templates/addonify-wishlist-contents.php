<h2>My Wishlist</h2>

<div id="addonify-wishlist-container">

    <form action="">
        
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
            if( isset( $data ) ):
                foreach( $data as $value ):
        ?>

            <div class="addonify-wishlist-items-package">
                <ul>
                    <li class="checkbox" ><input type="checkbox" name="addonify-wishlist_product_ids[]" value="<?php echo $value['id'];?>" class="wishlist-product-id" ></li>
                    <li class="remove"><button type="submit" name="remove-wishlist" value="<?php echo $value['id'];?>">x</button></li>
                    <li class="image"><?php echo $value['image'];?></li>
                    <li class="name"><?php echo $value['title'];?></li>
                    <li class="price"><?php echo $value['price'];?></li>
                    <li class="date"><?php echo $value['date_added'];?></li>
                    <li class="stock"><?php echo $value['stock'];?></li>
                    <li class="cart"><?php echo $value['add_to_cart'];?></li>
                </ul>
            </div> <!--wishlist-container-heading-->

        <?php endforeach; endif; ?>

        <div class="addonify-wishlist-footer-actions">
            <div class="addonify-wfa-packets">
                <select name="actions" >
                    <option value="" >Actions</option>
                    <option value="add_to_cart" >Add to cart</option>
                    <option value="remove" >Remove</option>
                </select>
                <button type="submit" name="apply_action" >Apply Action</button>
            </div> <!--addonify-wfa-packets-->
            
            <div class="addonify-wfa-packets go-right">
                <button type="submit" class="addonify_add_to_cart" name="add_selected_to_cart" value="selected_product" >Add Selected to Cart</button>
                <button type="submit" class="addonify_add_to_cart" name="add_all_to_cart" value="all" >Add All to Cart</button>
            </div> <!--addonify-wfa-packets-->
            
        <div>

    </form>

</div><!--wishlist-contaienr-->
