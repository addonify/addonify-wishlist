(function ($) {

    'use strict';

    $(document).ready(function () {

        let body = $('body'),
            wishlistSidebarEle = $('#addonify-wishlist-sticky-sidebar-container'),
            wishlistTableEle = $('#addonify-wishlist-table');

        let {
            enabledMultiWishlist,
            ajax_url,
            nonce,
            addToWishlistAction,
            removeFromWishlistAction,
            emptyWishlistAction,
            removeFromWishlistAfterAddedToCart,
            removeAlreadyAddedProductFromWishlist,
        } = addonifyWishlistJSObject;

        let productID, productName, currentAddToWishlistButton, currentRemoveFromWishlistButton, currentModalIcon, currentModalMessage;

        let addonifyWishlistInitArgs = {
            loader: addonifyWishlistJSObject.loader,
            wishlistPageURL: addonifyWishlistJSObject.wishlistPageURL,
            saveForLaterButtonLabel: addonifyWishlistJSObject.saveForLaterButtonLabel,
            savedForLaterButtonLabel: addonifyWishlistJSObject.savedForLaterButtonLabel,
            initialAddToWishlistButtonLabel: addonifyWishlistJSObject.initialAddToWishlistButtonLabel,
            addedToWishlistButtonLabel: addonifyWishlistJSObject.addedToWishlistButtonLabel,
            alreadyInWishlistButtonLabel: addonifyWishlistJSObject.alreadyInWishlistButtonLabel,
            undoNoticeTimeout: addonifyWishlistJSObject.undoNoticeTimeout,
            addedToWishlistModal: addonifyWishlistJSObject.addedToWishlistModal,
            removedFromWishlistModal: addonifyWishlistJSObject.removedFromWishlistModal,
            afterAddToWishlistAction: addonifyWishlistJSObject.afterAddToWishlistAction,
            productRemovalUndoNotice: addonifyWishlistJSObject.productRemovalUndoNotice,
        };

        let addonifyWishlistInit = body.addonifyWishlistInit(addonifyWishlistInitArgs);

        addonifyWishlistInit.init();

        let addonifyWishlist = {
            init: function() {
                this.wishlistButtonEventHandler();
                this.undoEventsHandler();
                this.addedToCartEventHandler();
            },
            wishlistButtonEventHandler: function() {
                if (enabledMultiWishlist !== '1') {

                    /**
                     * Check if product is already in the cart.
                     * If not call AJAX function to add the product into the cart.
                     */
                    body.on('click', '.addonify-wishlist-ajax-add-to-wishlist', function (e) {
                        e.preventDefault();

                        currentAddToWishlistButton = jQuery(this);
                        
                        // Set `loading` CSS class.
                        currentAddToWishlistButton.addClass('loading');

                        addonifyWishlistSetProductIDName(currentAddToWishlistButton);

                        if (currentAddToWishlistButton.hasClass("added-to-wishlist")) {

                            // Remove product from wishlist when clicked on the added to wishlist button.
                            if (removeAlreadyAddedProductFromWishlist === '1') {
                                currentRemoveFromWishlistButton = currentAddToWishlistButton;
                                addonifyRemoveFromWishlist();
                            } else {
                                addonifyWishlistInit.displayModal(
                                    addonifyWishlistJSObject.alreadyInWishlistModal,
                                    addonifyWishlistPrepareModalContentUpdateData()
                                );
                            }
                        } else {
                            // Call function to add product into wishlist.
                            addonifyAddToWishlist();
                        }
                        // Remove `loading` CSS class.
                        currentAddToWishlistButton.removeClass('loading');
                    });

                    // Click event handler for removing product from wishlist.
                    body.on('click', '.addonify-wishlist-ajax-remove-from-wishlist', function (event) {
                        event.preventDefault();

                        currentRemoveFromWishlistButton = $(this);

                        addonifyWishlistSetProductIDName(currentRemoveFromWishlistButton);

                        // Call function to remove product from the wishlist.
                        addonifyRemoveFromWishlist();
                    });

                    // Click event handler for emptying wishlist.
                    $(document).on('click', '#addonify-wishlist__clear-all', function (event) {
                        event.preventDefault();

                        // Display loader.
                        addonifyWishlistInit.displayLoader();

                        // Initiate AJAX request for emptying the wishlist.
                        $.post(
                            ajax_url,
                            {
                                action: emptyWishlistAction,
                                nonce: nonce
                            },
                        ).done(function(response){
                            if (response.success) {

                                // Triggering custom event when wishlist is emptied. 
                                // 'addonify_wishlist_emptied' custom event can be used to perform desired actions.
                                $(document).trigger('addonify_wishlist_emptied');

                                addonifyWishlistInit.updateWishlistTableElements(0);
                            } else {
                                currentModalMessage = response.message;
                                currentModalIcon = 'flash';
                                addonifyWishlistInit.displayModal(
                                    addonifyWishlistJSObject.errorModal,
                                    addonifyWishlistPrepareModalContentUpdateData()
                                );
                            }
                        }).always(function () {
                            addonifyWishlistInit.hideLoader();
                        });
                    });
                }
            },
            undoEventsHandler: function() {
                if (enabledMultiWishlist !== '1') {
                    // Click event handler for undoing the product removal from the wishlist.
                    body.on('click', '#addonify-wishlist-undo-deleted-product-link', function (event) {
                        event.preventDefault();
                        currentAddToWishlistButton = $(this);
                        // Call function to add product into wishlist.
                        addonifyAddToWishlist();
                    });
                }
            },
            addedToCartEventHandler: function() {

                if (enabledMultiWishlist !== '1') {
                    // Updates sidebar and page content, and triggers custom event when product is added into the cart.
                    $(document).on('added_to_cart', function (event, fragments, cart_hash, addToCartButton) {
                        // Updates wishlist sidebar and page content.

                        if (removeFromWishlistAfterAddedToCart === '1') {

                            addonifyWishlistSetProductIDName(addToCartButton);
                            
                            // Triggering custom event when product is added to wishlist. 
                            // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                            $(document).trigger('addonify_removed_from_wishlist', [
                                {
                                    productID: addToCartButton.data('product_id'),
                                    productName: addToCartButton.data('product_name'),
                                    itemsCount: fragments.itemsCount,
                                    thisButton: addToCartButton,
                                    modalContentUpdateData: addonifyWishlistPrepareModalContentUpdateData(),
                                }
                            ]);
                        }
                    });
                }
            }
        }    

        /**
         * Function to add product into wishlist.
         */
        function addonifyAddToWishlist() {

            // Triggering custom event when product is being added into wishlist. 
            // 'addonify_adding_to_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_adding_to_wishlist');

            let postRequestData = {
                action: addToWishlistAction,
                product_id: productID,
                nonce: nonce
            };

            if (wishlistSidebarEle.length > 0) {
                postRequestData.has_wishlist_sidebar = true;
            }

            if (wishlistTableEle.length > 0) {
                postRequestData.has_wishlist_table = true;
            }

            $.post(
                ajax_url,
                postRequestData,
            ).done(function(response){
                if (response.success == true) {

                    // Triggering custom event when product is added to wishlist. 
                    // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                    $(document).trigger('addonify_added_to_wishlist', [
                        {
                            productID: productID,
                            itemsCount: response.itemsCount,
                            thisButton: currentAddToWishlistButton,
                            modalContentUpdateData: addonifyWishlistPrepareModalContentUpdateData(),
                        }
                    ]);

                    if (response.hasOwnProperty('sidebarProductRowContent')) {
                        addonifyWishlistInit.addWishlistSidebarProductRow(response.sidebarProductRowContent);
                    }

                    if (response.hasOwnProperty('tableProductRowContent')) {
                        addonifyWishlistInit.addWishlistTableProductRow(response.tableProductRowContent);
                    }
                } else {
                    currentModalMessage = response.message;
                    currentModalIcon = 'flash';
                    addonifyWishlistInit.displayModal(
                        addonifyWishlistJSObject.errorModal,
                        addonifyWishlistPrepareModalContentUpdateData()
                    );
                }
            }).always(function () {
                addonifyWishlistInit.hideLoader();
            });
        }

        /**
         * Function to remove product from wishlist.
         *
         * @param {Object} data Request data.
         */
        function addonifyRemoveFromWishlist() {

            // Triggering custom event when product is being removed from wishlist. 
            // 'addonify_removing_from_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_removing_from_wishlist');

            $.post(
                ajax_url,
                {
                    action: removeFromWishlistAction,
                    product_id: productID,
                    nonce: nonce
                },
            ).done(function(response){
                if (response.success) {

                    // Triggering custom event when product is added to wishlist. 
                    // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                    $(document).trigger('addonify_removed_from_wishlist', [
                        {
                            productID: productID,
                            productName: productName,
                            itemsCount: response.itemsCount,
                            thisButton: currentRemoveFromWishlistButton,
                            modalContentUpdateData: addonifyWishlistPrepareModalContentUpdateData(),
                        }
                    ]);
                } else {
                    currentModalMessage = response.message;
                    currentModalIcon = 'flash';
                    addonifyWishlistInit.displayModal(
                        addonifyWishlistJSObject.errorRemovingFromWishlistModal,
                        addonifyWishlistPrepareModalContentUpdateData()
                    );
                }
            }).always(function () {
                addonifyWishlistInit.hideLoader();
            });
        }


        function addonifyWishlistSetProductIDName(buttonEle) {
            productID = buttonEle.data('product_id');
            productName = buttonEle.data('product_name');
        }

        function addonifyWishlistPrepareModalContentUpdateData() {
            return {
                product_name: productName,
                modal_icon: currentModalIcon,
                modal_message: currentModalMessage,
            };
        }

        addonifyWishlist.init();
    });

})(jQuery);