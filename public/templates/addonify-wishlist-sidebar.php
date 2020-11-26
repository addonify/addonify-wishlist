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
                    <li class="addonify-wishlist-sidebar-item">
                        <div class="adfy-wishlist-row">
                            <div class="adfy-wishlist-col image-column">
                                <div class="adfy-wishlist-woo-image">
                                    <a href="#"><img src="https://via.placeholder.com/90" alt="..."></a>
                                </div><!-- // adfy-wishlist-woo-image -->
                            </div><!-- // adfy-wishlist-col -->
                            <div class="adfy-wishlist-col title-price-column">
                                <div class="adfy-wishlist-woo-title">
                                    <a href="http://localhost/addonify/plugin-dev/product/arm-chair-dallas/">Arm Chair Dallas (ACWDW)</a>
                                </div><!-- // adfy-wishlist-woo-title -->
                                <div class="adfy-wishlist-woo-price">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>200.00</bdi></span>
                                </div><!-- // adfy-wishlist-woo-price -->
                            </div><!-- // adfy-wishlist-col -->
                        </div><!-- // adfy-wishlist-row -->
                        <div class="adfy-wishlist-woo-action">
                            <div class="adfy-wishlist-row">
                                <div class="adfy-wishlist-col cart-column">
                                    <button type="submit" class="button adfy-wishlist-btn" name="addonify_wishlist_add_to_cart" value="155">Add to cart</button>
                                </div><!-- // adfy-wishlist-col -->
                                <div class="adfy-wishlist-col remove-item-column">
                                    <button type="submit" class="adfy-wishlist-btn addonify-wishlist-icon" name="addonify_wishlist_remove"><i class="adfy-wishlist-icon trash-2"></i></button>
                                </div><!-- // adfy-wishlist-col -->
                            </div><!-- // adfy-wishlist-row -->
                        </div><!-- // adfy-wishlist-woo-action -->
                    </li>

                    <li class="addonify-wishlist-sidebar-item">
                        <div class="adfy-wishlist-row">
                            <div class="adfy-wishlist-col image-column">
                                <div class="adfy-wishlist-woo-image">
                                    <a href="#"><img src="https://via.placeholder.com/90" alt="..."></a>
                                </div><!-- // adfy-wishlist-woo-image -->
                            </div><!-- // adfy-wishlist-col -->
                            <div class="adfy-wishlist-col title-price-column">
                                <div class="adfy-wishlist-woo-title">
                                    <a href="http://localhost/addonify/plugin-dev/product/arm-chair-dallas/">Hand Induction Control Flying Helicopter Toy with Infrared Sensor, USB Charger and Flashing Light for Kids (Multicolour)</a>
                                </div><!-- // adfy-wishlist-woo-title -->
                                <div class="adfy-wishlist-woo-price">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>400.00</bdi></span>
                                </div><!-- // adfy-wishlist-woo-price -->
                            </div><!-- // adfy-wishlist-col -->
                        </div><!-- // adfy-wishlist-row -->
                        <div class="adfy-wishlist-woo-action">
                            <div class="adfy-wishlist-row">
                                <div class="adfy-wishlist-col cart-column">
                                    <button type="submit" class="button adfy-wishlist-btn" name="addonify_wishlist_add_to_cart" value="155">Add to cart</button>
                                </div><!-- // adfy-wishlist-col -->
                                <div class="adfy-wishlist-col remove-item-column">
                                    <button type="submit" class="adfy-wishlist-btn addonify-wishlist-icon" name="addonify_wishlist_remove" value="155"><i class="adfy-wishlist-icon trash-2"></i></button>
                                </div><!-- // adfy-wishlist-col -->
                            </div><!-- // adfy-wishlist-row -->
                        </div><!-- // adfy-wishlist-woo-action -->
                    </li>

                    <li class="addonify-wishlist-sidebar-item">
                        <div class="adfy-wishlist-row">
                            <div class="adfy-wishlist-col image-column">
                                <div class="adfy-wishlist-woo-image">
                                    <a href="#"><img src="https://via.placeholder.com/90" alt="..."></a>
                                </div><!-- // adfy-wishlist-woo-image -->
                            </div><!-- // adfy-wishlist-col -->
                            <div class="adfy-wishlist-col title-price-column">
                                <div class="adfy-wishlist-woo-title">
                                    <a href="http://localhost/addonify/plugin-dev/product/arm-chair-dallas/">Free Fire 310+310 Diamonds Topup (Bonus)</a>
                                </div><!-- // adfy-wishlist-woo-title -->
                                <div class="adfy-wishlist-woo-price">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>129.00</bdi></span>
                                </div><!-- // adfy-wishlist-woo-price -->
                            </div><!-- // adfy-wishlist-col -->
                        </div><!-- // adfy-wishlist-row -->
                        <div class="adfy-wishlist-woo-action">
                            <div class="adfy-wishlist-row">
                                <div class="adfy-wishlist-col cart-column">
                                    <button type="submit" class="button adfy-wishlist-btn" name="addonify_wishlist_add_to_cart" value="155">Add to cart</button>
                                </div><!-- // adfy-wishlist-col -->
                                <div class="adfy-wishlist-col remove-item-column">
                                    <button type="submit" class="adfy-wishlist-btn addonify-wishlist-icon" name="addonify_wishlist_remove" value="155"><i class="adfy-wishlist-icon trash-2"></i></button>
                                </div><!-- // adfy-wishlist-col -->
                            </div><!-- // adfy-wishlist-row -->
                        </div><!-- // adfy-wishlist-woo-action -->
                    </li>

                    <li class="addonify-wishlist-sidebar-item">
                        <div class="adfy-wishlist-row">
                            <div class="adfy-wishlist-col image-column">
                                <div class="adfy-wishlist-woo-image">
                                    <a href="#"><img src="https://via.placeholder.com/90" alt="..."></a>
                                </div><!-- // adfy-wishlist-woo-image -->
                            </div><!-- // adfy-wishlist-col -->
                            <div class="adfy-wishlist-col title-price-column">
                                <div class="adfy-wishlist-woo-title">
                                    <a href="http://localhost/addonify/plugin-dev/product/arm-chair-dallas/">Black Hooded Streetwear Hip Hop Hoodie For Men By Nepster</a>
                                </div><!-- // adfy-wishlist-woo-title -->
                                <div class="adfy-wishlist-woo-price">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>329.00</bdi></span>
                                </div><!-- // adfy-wishlist-woo-price -->
                            </div><!-- // adfy-wishlist-col -->
                        </div><!-- // adfy-wishlist-row -->
                        <div class="adfy-wishlist-woo-action">
                            <div class="adfy-wishlist-row">
                                <div class="adfy-wishlist-col cart-column">
                                    <button type="submit" class="button adfy-wishlist-btn" name="addonify_wishlist_add_to_cart" value="155">Add to cart</button>
                                </div><!-- // adfy-wishlist-col -->
                                <div class="adfy-wishlist-col remove-item-column">
                                    <button type="submit" class="adfy-wishlist-btn addonify-wishlist-icon" name="addonify_wishlist_remove" value="155"><i class="adfy-wishlist-icon trash-2"></i></button>
                                </div><!-- // adfy-wishlist-col -->
                            </div><!-- // adfy-wishlist-row -->
                        </div><!-- // adfy-wishlist-woo-action -->
                    </li>

                    <li class="addonify-wishlist-sidebar-item">
                        <div class="adfy-wishlist-row">
                            <div class="adfy-wishlist-col image-column">
                                <div class="adfy-wishlist-woo-image">
                                    <a href="#"><img src="https://via.placeholder.com/90" alt="..."></a>
                                </div><!-- // adfy-wishlist-woo-image -->
                            </div><!-- // adfy-wishlist-col -->
                            <div class="adfy-wishlist-col title-price-column">
                                <div class="adfy-wishlist-woo-title">
                                    <a href="http://localhost/addonify/plugin-dev/product/arm-chair-dallas/">Black Hooded Streetwear Hip Hop Hoodie For Men By Nepster</a>
                                </div><!-- // adfy-wishlist-woo-title -->
                                <div class="adfy-wishlist-woo-price">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>569.00</bdi></span>
                                </div><!-- // adfy-wishlist-woo-price -->
                            </div><!-- // adfy-wishlist-col -->
                        </div><!-- // adfy-wishlist-row -->
                        <div class="adfy-wishlist-woo-action">
                            <div class="adfy-wishlist-row">
                                <div class="adfy-wishlist-col cart-column">
                                    <button type="submit" class="button adfy-wishlist-btn" name="addonify_wishlist_add_to_cart" value="155">Add to cart</button>
                                </div><!-- // adfy-wishlist-col -->
                                <div class="adfy-wishlist-col remove-item-column">
                                    <button type="submit" class="adfy-wishlist-btn addonify-wishlist-icon" name="addonify_wishlist_remove" value="155"><i class="adfy-wishlist-icon trash-2"></i></button>
                                </div><!-- // adfy-wishlist-col -->
                            </div><!-- // adfy-wishlist-row -->
                        </div><!-- // adfy-wishlist-woo-action -->
                    </li>
                </ul>
            </div> <!-- addonify-wishlist-sidebar-items-wrapper -->   
        </form>
    </div> <!--addonify-wishlist-ssc-body-->

    <div class="addonify-wishlist-ssc-footer">
        <a href="<?php echo esc_url_raw( $wishlist_url );?>" class="addonify-wishlist-goto-wishlist-btn"><span class="icon"><i class="adfy-wishlist-icon external-link"></i></span>  <?php _e( 'View all Wishlist', 'addonify-wishlist' );?></a>
    </div><!-- // addonify-wishlist-ssc-footer -->
</div> <!--addonify-wishlist-sticky-sidebar-container-->