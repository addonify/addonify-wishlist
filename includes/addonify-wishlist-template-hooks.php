<?php
/**
 * The file that adds the template actions.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

add_action( 'addonify_wishlist_render_wishlist_button', 'addonify_wishlist_render_add_to_wishlist_button' );

add_action( 'addonify_wishlist_render_modal_wrapper', 'addonify_wishlist_render_modal_wrapper' );
add_action( 'addonify_wishlist_render_sidebar_toggle_button', 'addonify_wishlist_render_sidebar_toggle_button' );
add_action( 'addonify_wishlist_render_sidebar', 'addonify_wishlist_render_sidebar' );
add_action( 'addonify_wishlist_render_sidebar_loop', 'addonify_wishlist_render_sidebar_loop' );
add_action( 'addonify_wishlist_render_shortcode_content', 'addonify_wishlist_render_wishlist_content' );


add_action( 'addonify_wishlist_popup_action_btns', 'addonify_wishlist_render_popup_wishlist_link_button' );
add_action( 'addonify_wishlist_popup_action_btns', 'addonify_wishlist_render_popup_login_link_button' );
