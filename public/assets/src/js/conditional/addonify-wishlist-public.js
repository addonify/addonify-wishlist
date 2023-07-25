(function ($) {

    'use strict';

    $(document).ready(function () {

        let body = $('body'),
            undoTimeout;

        let {
            ajax_url,
            nonce,
            addedToWishlistText,
            initialAddToWishlistButtonLabel,
            addToWishlistAction,
            removeFromWishlistAction,
            emptyWishlistAction,
            removeFromWishlistAfterAddedToCart,
            removeAlreadyAddedProductFromWishlist,
            afterAddToWishlistAction,
            wishlistPageURL,
            undoNoticeTimeout,
            loader,
            alreadyInWishlistModal,
            saveForLaterButtonLabel,
            savedForLaterButtonLabel,
        } = addonifyWishlistJSObject;

        console.log(saveForLaterButtonLabel);

        let addonifyWishlist = {
            init: function() {
                this.wishlistButtonEventHandler();
                this.undoEventsHandler();
                this.wishlistEventHandler();
                this.toggleBackgroundOverlays();
                this.addedToCartEventHandler();
            },

            wishlistButtonEventHandler: function() {

                if (!addonifyWishlistJSObject.hasOwnProperty('enabledAWP')) {

                    /**
                     * Check if product is already in the cart.
                     * If not call AJAX function to add the product into the cart.
                     */
                    body.on('click', '.addonify-wishlist-ajax-add-to-wishlist', function (e) {
                        e.preventDefault();
                        let addToWishlistButton = jQuery(this);
                        // Set `loading` CSS class.
                        addToWishlistButton.addClass('loading');
                        if (addToWishlistButton.hasClass("added-to-wishlist")) {
                            // Remove product from wishlist when clicked on the added to wishlist button.
                            if (removeAlreadyAddedProductFromWishlist === '1') {
                                addonifyRemoveFromWishlist({
                                    action: removeFromWishlistAction,
                                    product_id: addToWishlistButton.data('product_id'),
                                    nonce: nonce,
                                    source: 'add-to-wishlist',
                                });
                            } else {
                                // Display already in wishlist modal.
                                addonifyWishlistDisplayModal(alreadyInWishlistModal, addToWishlistButton.data('product_name'));
                            }
                        } else {
                            // Call function to add product into wishlist.
                            addonifyAddToWishlist({
                                action: addToWishlistAction,
                                product_id: addToWishlistButton.data('product_id'),
                                nonce: nonce
                            }, addToWishlistButton);
                        }
                        // Remove `loading` CSS class.
                        addToWishlistButton.removeClass('loading');
                    });

                    // Click event handler for removing product from wishlist.
                    body.on('click', '.addonify-wishlist-ajax-remove-from-wishlist', function (event) {
                        event.preventDefault();
                        let thisButton = $(this);
                        // Call function to remove product from the wishlist.
                        addonifyRemoveFromWishlist({
                            action: removeFromWishlistAction,
                            product_id: thisButton.data('product_id'),
                            nonce: nonce
                        });
                    });

                    // Click event handler for emptying wishlist.
                    $(document).on('click', '#addonify-wishlist__clear-all', function () {
                        // Display loader.
                        addonifyWishlistDisplayLoader();
                        // Initiate AJAX request for emptying the wishlist.
                        $.post(
                            ajax_url,
                            {
                                action: emptyWishlistAction,
                                nonce: nonce
                            },
                            function (response) {
                                if (response.success) {
                                    // Update wishlist page table content.
                                    if (response.hasOwnProperty('tableContent') && $('#addonify-wishlist-page-items-wrapper')) {
                                        $('#addonify-wishlist-page-items-wrapper').html(response.tableContent);
                                    }

                                    if (response.hasOwnProperty('modalContent')) {
                                        addonifyWishlistDisplayModal(response.modalContent);
                                    }

                                    // Triggering custom event when wishlist is emptied. 
                                    // 'addonify_wishlist_emptied' custom event can be used to perform desired actions.
                                    $(document).trigger('addonify_wishlist_emptied');

                                    $('#addonify-wishlist-notice').html('');
                                } else {
                                    if (response.hasOwnProperty('modalContent')) {
                                        addonifyWishlistDisplayModal(response.modalContent);
                                    } else {
                                        if (response.hasOwnProperty('message')) {
                                            console.log(response.message);
                                        }
                                    }
                                }
                            }
                        ).always(function () {
                            addonifyWishlistHideLoader();
                        });
                    });
                }

                
            },

            undoEventsHandler: function() {
                
                if (!addonifyWishlistJSObject.hasOwnProperty('enabledAWP')) {
                    // Click event handler for undoing the product removal from the wishlist.
                    body.on('click', '#addonify-wishlist-undo-deleted-product-link', function (event) {
                        event.preventDefault();
                        let thisButton = $(this);
                        // Call function to add product into wishlist.
                        addonifyAddToWishlist({
                            action: addToWishlistAction,
                            product_id: thisButton.data('product_id'),
                            nonce: nonce,
                            source: thisButton.data('source'),
                        }, thisButton);
                    });
                }

                // Event handler for setting timeout for undo notice.
                $(document).on('addonify_wishlist_undo_notice_set', function(event) {
                    clearTimeout(undoTimeout);
                    if (parseInt(undoNoticeTimeout) > 0) {
                        undoTimeout = setTimeout(
                            function () {
                                $('#addonify-wishlist-notice').html('');
                            },
                            parseInt(undoNoticeTimeout) * 1000
                        )
                    }
                });
            },

            wishlistEventHandler: function() {

                // Displays loader when product is being added into and removed from the wishlist.
                $(document).on('addonify_adding_to_wishlist, addonify_removing_from_wishlist', function(event){
                    addonifyWishlistDisplayLoader();
                });

                // Sets button label and icon for add to wishlist buttons on product added into the cart.
                $(document).on('addonify_added_to_wishlist', function(event, data){

                    if (!addonifyWishlistJSObject.hasOwnProperty('enabledAWP')) {

                        if(data.hasOwnProperty('productID')) {
                            let wishlistButtons = $('button[data-product_id=' + data.productID + ']');
                            if(wishlistButtons.length > 0) {
                                wishlistButtons.each(function(){
                                    let currentButton = $(this);
                                    if(!currentButton.hasClass('added-to-wishlist')) {
                                        currentButton.addClass('added-to-wishlist');
                                    }
                                    // Update button label and icon of custom add to wishlist button.
                                    if (!currentButton.hasClass('addonify-custom-wishlist-btn') && currentButton.hasClass('addonify-add-to-wishlist-btn')) {
                                        
                                        // Update button icon.
                                        currentButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');

                                        // Update button label.
                                        if (currentButton.hasClass('addonify-wishlist-save-for-later')){
                                            console.log(savedForLaterButtonLabel);
                                            // If button is save for later button.
                                            currentButton.find('span.addonify-wishlist-btn-label').text(savedForLaterButtonLabel);
                                        } else {
                                            // If button is not save for later button.
                                            currentButton.find('span.addonify-wishlist-btn-label').text(addedToWishlistText);
                                        }
                                    }
                                });
                            }
                        }
                    }

                    addonifyWishlistHideLoader();
                });

                // Sets button label and icon for add to wishlist buttons on product removed from the cart.
                $(document).on('addonify_removed_from_wishlist', function (event, data) {
                    
                    if (data.hasOwnProperty('productID')) {

                        let wishlistButtons = $('[data-product_id=' + data.productID + ']');
                        if (wishlistButtons.length > 0) {
                            wishlistButtons.each(function () {
                                let currentButton = $(this);
                                if(currentButton.hasClass('added-to-wishlist')){
                                    currentButton.removeClass('added-to-wishlist');
                                }
                                // Update button label and icon of custom add to wishlist button.
                                if (!currentButton.hasClass('addonify-custom-wishlist-btn') && currentButton.hasClass('addonify-add-to-wishlist-btn')) {
                                    // Update button icon.
                                    currentButton.find('i.icon.adfy-wishlist-icon').addClass('heart-o-style-one').removeClass('heart-style-one');

                                    // Update button label.
                                    if (currentButton.hasClass('addonify-wishlist-save-for-later')) {
                                        console.log(currentButton);
                                        // If button is save for later button.
                                        currentButton.find('span.addonify-wishlist-btn-label').text(saveForLaterButtonLabel);
                                    } else {
                                        // If button is not save for later button.
                                        currentButton.find('span.addonify-wishlist-btn-label').text(initialAddToWishlistButtonLabel);
                                    }
                                }
                            });
                        }
                    }

                    addonifyWishlistHideLoader();
                });
            },

            toggleBackgroundOverlays: function() {

                // Toggle modal background overlay.
                body.on('click', '#addonify-wishlist-close-modal-btn, #addonify-wishlist-modal-overlay', function () {
                    body.toggleClass('addonify-wishlist-modal-is-open');
                });

                // Toggle sidebar background overlay.
                body.on('click', '#addonify-wishlist-show-sidebar-btn, #close-adfy-wishlist-sidebar-button, #addonify-wishlist-sticky-sidebar-overlay', function () {
                    body.toggleClass('addonify-wishlist-sticky-sidebar-is-visible');
                });
            },

            addedToCartEventHandler: function() {

                // Updates sidebar and page content, and triggers custom event when product is added into the cart.
                $(document).on('added_to_cart', function (event, fragments, cart_hash, addToCartButton) {
                    // Updates wishlist sidebar and page content.
                    addonifyWishlistUpdateWishlistSidebarPageContent(fragments);

                    if (removeFromWishlistAfterAddedToCart === '1') {
                        let addToWishlistButtonSibling = addToCartButton.parent().find('.addonify-wishlist-ajax-add-to-wishlist');
                        if (addToWishlistButtonSibling.hasClass('added-to-wishlist')) {
                            // Triggering custom event when product is added to wishlist. 
                            // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                            $(document).trigger('addonify_removed_from_wishlist', [
                                {
                                    productID: addToCartButton.data('product_id'),
                                    itemsCount: fragments.itemsCount,
                                }
                            ]);
                        }
                        
                    }
                });
            }
        }    

        /**
         * Function to add product into wishlist.
         *
         * @param {Object} data Request data.
         * @param {Object} thisButton Button.
         */
        function addonifyAddToWishlist(data,thisButton) {

            // Triggering custom event when product is being added into wishlist. 
            // 'addonify_adding_to_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_adding_to_wishlist');

            $.post(
                ajax_url,
                data,
                function (response) {

                    if (response.success == true) {

                        // Redirect to wishlist page once product is added into the wishlist.
                        if (afterAddToWishlistAction === 'redirect_to_wishlist_page' && thisButton.hasClass('addonify-add-to-wishlist-btn')) {
                            window.location.href = wishlistPageURL;
                        }

                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_added_to_wishlist', [
                            {
                                productID: data.product_id,
                                itemsCount: response.itemsCount
                            }
                        ]);

                        // Display added to wishlist modal.
                        if (afterAddToWishlistAction === 'show_popup_notice' && thisButton.hasClass('addonify-add-to-wishlist-btn') && response.hasOwnProperty('modalContent')) {
                            addonifyWishlistDisplayModal(response.modalContent, response.productName);
                        }

                        // Updates wishlist sidebar and page content.
                        addonifyWishlistUpdateWishlistSidebarPageContent(response,'added_to_wishlist');
                    } else {
                        if (response.hasOwnProperty('modalContent')) {
                            addonifyWishlistDisplayModal(response.modalContent);
                        } else {
                            if(response.hasOwnProperty('message')){
                                console.log(response.message);
                            }
                        }
                    }
                },
                "json"
            ).always(function () {
                addonifyWishlistHideLoader();
            });
        }

        /**
         * Function to remove product from wishlist.
         *
         * @param {Object} data Request data.
         */
        function addonifyRemoveFromWishlist(data) {

            // Triggering custom event when product is being removed from wishlist. 
            // 'addonify_removing_from_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_removing_from_wishlist');

            $.post(
                ajax_url,
                data,
                function (response) {
                    if (response.success) {

                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_removed_from_wishlist', [
                            {
                                productID: data.product_id,
                                itemsCount: response.itemsCount,
                            }
                        ]);

                        if (response.hasOwnProperty('modalContent')) {
                            addonifyWishlistDisplayModal(response.modalContent);
                        }

                        // Updates wishlist sidebar and page content.
                        addonifyWishlistUpdateWishlistSidebarPageContent(response,'removed_from_wishlist');
                    } else {
                        if (response.hasOwnProperty('modalContent')) {
                            addonifyWishlistDisplayModal(response.modalContent);
                        } else {
                            if (response.hasOwnProperty('message')) {
                                console.log(response.message);
                            }
                        }
                    }
                },
                "json"
            ).always(function () {
                addonifyWishlistHideLoader();
            });
        }

        
        /**
         * Function to update sidebar and wishlist page content.
         *
         * @param {Object} data Response data.
         * @param {string} action Action causing the update.
         */
        function addonifyWishlistUpdateWishlistSidebarPageContent(data,action) {

            // Toggles the wishlist sidebar toggle button.
            if (data.itemsCount > 0) {
                $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
            }  

            // Updates the wishlist sidebar content.
            if (data.hasOwnProperty('sidebarContent') && $('#addonify-wishlist-sidebar-items-wrapper')) {
                $('#addonify-wishlist-sidebar-items-wrapper').html(data.sidebarContent);
            }

            // Updates the wishlist page table content.
            if (data.hasOwnProperty('tableContent') && $('#addonify-wishlist-page-items-wrapper')) {
                $('#addonify-wishlist-page-items-wrapper').html(data.tableContent);
            }

            // Sets product removal undo notice.
            if (action === 'removed_from_wishlist') {
                if (data.hasOwnProperty('undoContent') && $('#addonify-wishlist-notice') ) {
                    $('#addonify-wishlist-notice').html(data.undoContent);
                    $(document).trigger('addonify_wishlist_undo_notice_set');
                }
            }

            // Removes product removal undo notice when product is added to wishlist.
            if (action === 'added_to_wishlist') {
                $('#addonify-wishlist-notice').html('');
            }
        }


        /**
         * Function to display modals.
         *
         * @param {Object} template Modal template.
         * @param {productName} productName Product's name.
         */
        function addonifyWishlistDisplayModal(template,productName) {

            if (productName !== '' ) {
                if(template.includes('{product_name}')) {
                    template = template.replace('{product_name}', productName);
                }
            }

            $('#addonify-wishlist-modal-wrapper').replaceWith(template);
            body.toggleClass('addonify-wishlist-modal-is-open');
        }


        /**
         * Function to display loader in wishlist sidebar and page.
         */
        function addonifyWishlistDisplayLoader() {
            if ($('#addonify-wishlist-sticky-sidebar-container').length > 0) {
                $('#addonify-wishlist-sticky-sidebar-container').append(loader);
            }

            if ($('#addonify-wishlist-page-container').length > 0) {
                $('#addonify-wishlist-page-container').append(loader);
            }
        }

        /**
         * Function to hide loader in wishlist sidebar and page.
         */
        function addonifyWishlistHideLoader() {
            if ($('#addonify-wishlist_spinner')) {
                $('#addonify-wishlist_spinner').remove();
            }
        }

        addonifyWishlist.init();
    });

})(jQuery);