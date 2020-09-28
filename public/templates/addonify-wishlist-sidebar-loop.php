<?php 
    if( isset( $data['wishlist_data'] ) && count( $data['wishlist_data'] ) > 0 ):
        $i = 1;
        foreach( $data['wishlist_data'] as $value ):
            if( $i >= 5 ) break;
?>

    <li>
        <?php echo $value['image'];?>
        <?php echo $value['title'];?><br>
        <?php echo $value['price'];?> <br>
        <?php echo $value['add_to_cart'];?><br>
        <?php echo $value['remove_btn'];?>
    </li>

<?php endforeach; $i++; else: ?>
    <li>Your wishlist is empty</li>
<?php endif;?>