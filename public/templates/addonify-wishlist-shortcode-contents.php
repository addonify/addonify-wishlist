<?php
/**
 * Public template.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/public/templates
 */

// direct access is disabled.
defined( 'ABSPATH' ) || exit;
?>

<h2><?php echo esc_html( $data['wishlist_name'] ); ?></h2>

<div id="addonify-wishlist-page-container">

	<form action="" method="POST" >

		<input type="hidden" name="nonce" value="<?php echo esc_html( $data['nonce'] ); ?>" >
		<input type="hidden" name="process_addonify_wishlist_form" value="1" >
		
		<div class="addonify-wishlist-items-heading">
			<ul>
				<li class="checkbox" ><input type="checkbox" class="addonify-wishlist-check-all" ></li>
				<li class="remove"></li>
				<li class="image"></li>
				<li class="name"><?php _e( 'Product Name', 'addonify-wishlist' ); ?></li>
				<li class="price"><?php _e( 'Unit Price', 'addonify-wishlist' ); ?></li>
				<li class="date"><?php _e( 'Added Date', 'addonify-wishlist' ); ?></li>
				<li class="stock"><?php _e( 'Stock', 'addonify-wishlist' ); ?></li>
				<li class="cart"></li>
			</ul>
		</div> <!--addonify-wishlist-items-heading-->

		<?php
			if( isset( $data['wishlist_data'] ) && count( $data['wishlist_data'] ) > 0 ):
				foreach( $data['wishlist_data'] as $value ): 
		?>

			<div class="addonify-wishlist-items-package">
				<ul>
					<li class="checkbox" ><input type="checkbox" name="product_ids[]" value="<?php echo esc_attr( $value['id'] ); ?>" class="addonify-wishlist-product-id" ></li>
					<li class="remove"><?php echo wp_kses_post( $value['remove_btn'] ); ?></li>
					<li class="image"><?php echo wp_kses_post( $value['image'] ); ?></li>
					<li class="name"><?php echo wp_kses_post( $value['title'] ); ?></li>
					<li class="price"><?php echo wp_kses_post( $value['price'] ); ?></li>
					<li class="date"><?php echo wp_kses_post( $value['date_added'] ); ?></li>
					<li class="stock"><?php echo wp_kses_post( $value['stock'] ); ?></li>
					<li class="cart"><?php echo wp_kses_post( $value['add_to_cart'] ); ?></li>
				</ul>
			</div> <!--addonify-wishlist-items-package-->

		<?php
				endforeach;
			else: 
		?>
			<div class="addonify-wishlist-items-package addonify-wishlist-is-empty">
				<?php _e( 'Your wishlist is empty', 'addonify-wishlist' ); ?>
			</div> <!--addonify-wishlist-items-package-->
		<?php endif;?>

		<div class="addonify-wishlist-footer-actions">
			<div class="addonify-wfa-packets">
				<select name="addonify_wishlist_action" >
					<option value="" ><?php _e( 'Actions', 'addonify-wishlist' ); ?></option>
					<option value="add_selected_to_cart" ><?php _e( 'Add to cart', 'addonify-wishlist' ); ?></option>
					<option value="remove" ><?php _e( 'Remove', 'addonify-wishlist' ); ?></option>
				</select>
				<button class="adfy-wishlist-btn" type="submit" ><?php _e( 'Apply Action', 'addonify-wishlist' ); ?></button>
			</div>

			<div class="addonify-wfa-packets go-right">
				<button class="adfy-wishlist-btn" type="submit" class="addonify_add_to_cart" name="addonify_wishlist_action" value="add_selected_to_cart" ><?php _e( 'Add Selected to Cart', 'addonify-wishlist' ); ?></button>
				<button class="adfy-wishlist-btn" type="submit" class="addonify_add_to_cart" name="addonify_wishlist_action" value="add_all_to_cart" ><?php _e( 'Add All to Cart', 'addonify-wishlist' ); ?></button>
			</div>
			
		<div>
		
	</form>

</div>
