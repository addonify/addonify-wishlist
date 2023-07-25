(function ($) {

    'use strict';

    $(document).ready(function () {

        let body = $('body'),
            undoNoticeEle = $('#addonify-wishlist-notice'),
            undoTimeout;

        let plugin_name = 'addonify-wishlist';
        let default_wishlist = "Default Wishlist";

        let {
            requireLogin,
            addedToWishlistButtonLabel,

            ajax_url,
            nonce,
            removeAlreadyAddedProductFromWishlist,

            removeFromWishlistAfterAddedToCart,
            afterAddToWishlistAction,
            wishlistPageURL,
            initialWishlistContentGetAction,
            guestAddToWishlistAction,
            guestRemoveFromWishlistAction,
            addedToWishlistText,

            undoNoticeTimeout,
            initialAddToWishlistButtonLabel,
            
            thisSiteUrl,
            loader,
            addedToWishlistModal,
            alreadyInWishlistModal,
            errorAddingToWishlistModal,
            errorRemovingFromWishlistModal,
            removedFromWishlistModal,

            isLoginRequired,
            loginRequiredModal,
            ifNotLoginAction,
            loginURL,
            saveForLaterButtonLabel,
            savedForLaterButtonLabel,
        } = addonifyWishlistJSObject;

        let AddonifyWishlistPublicGuest = {

            init: function () {

                if (requireLogin !== '1') {

                    let wishlist_products = getProductids();

                    wishlist_products.forEach(function (value, _) {
                        let product_button = $('.adfy-wishlist-btn[data-product_id="' + value + '"]');
                        if (!product_button.hasClass('addonify-custom-wishlist-btn')) {
                            
                            product_button.find('i').addClass('heart-style-one').removeClass('heart-o-style-one');

                            // Update button label.
                            if (product_button.hasClass('addonify-wishlist-save-for-later')) {
                                // If button is save for later button.
                                product_button.find('span.addonify-wishlist-btn-label').text(savedForLaterButtonLabel);
                            } else {
                                // If button is not save for later button.
                                product_button.find('span.addonify-wishlist-btn-label').text(addedToWishlistText);
                            }
                        }
                        product_button.addClass('added-to-wishlist');
                    });

                    addonifyLoadWishlistContent();
                }

                this.onAddToWishlist();
                this.onRemoveFromWishlist();
                this.addedToCartEventHandler();
                this.toggleBackgroundOverlays();
                this.wishlistEventHandler();
                this.undoEventsHandler();
            },

            onAddToWishlist: function () {
                /**
                 * Check if product is already in the cart.
                 * If not call ajax function to add the product into the cart.
                 */
                body.on('click', '.addonify-wishlist-ajax-add-to-wishlist', function (e) {
                    e.preventDefault();
                    if(isLoginRequired === '1') {
                        if( ifNotLoginAction === 'show_popup' ){
                            addonifyWishlistDisplayModal(loginRequiredModal);
                            return;
                        } else {
                            window.location.href = loginURL;
                        }
                    }
                    let addToWishlistButton = $(this);
                    if (addToWishlistButton.hasClass('added-to-wishlist')) {
                        if (removeAlreadyAddedProductFromWishlist === '1') {
                            addonifyLocalRemoveFromWishlist(addToWishlistButton)
                        } else {
                            addonifyWishlistDisplayModal(alreadyInWishlistModal,addToWishlistButton.data('product_name'));
                        }
                    } else {
                        addonifyLocalAddToWishlist(addToWishlistButton);
                    }
                    $('#addonify-wishlist-notice').html('');
                });
            },

            onRemoveFromWishlist: function () {

                // local remove product from wishlist.
                $(document).on('click', '.addonify-wishlist-ajax-remove-from-wishlist, .addonify-wishlist-remove-from-wishlist', function (event) {
                    event.preventDefault();
                    let thisButton = $(this);
                    addonifyLocalRemoveFromWishlist(thisButton)
                });

                // remove all items from wishlist.
                $(document).on('click', '#addonify-wishlist__clear-all', function () {
                    addonifyWishlistDisplayLoader();
                    if( setProductids([]) !== false ) {
                        addonifyLoadWishlistContent();

                        // Triggering custom event when wishlist is emptied. 
                        // 'addonify_wishlist_emptied' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_wishlist_emptied');
                    }
                    addonifyWishlistHideLoader();                
                });

            },

            wishlistEventHandler: function () {

                // Displays loader when product is being added into and removed from the wishlist.
                $(document).on('addonify_adding_to_wishlist, addonify_removing_from_wishlist', function (event) {
                    addonifyWishlistDisplayLoader();
                });

                // Sets button label and icon for add to wishlist buttons on product added into the cart.
                $(document).on('addonify_added_to_wishlist', function (event, data) {

                    if (data.hasOwnProperty('productID')) {
                        let wishlistButtons = $('button[data-product_id=' + data.productID + ']');
                        if (wishlistButtons.length > 0) {
                            wishlistButtons.each(function () {
                                let currentButton = $(this);
                                if (!currentButton.hasClass('added-to-wishlist')) {
                                    currentButton.addClass('added-to-wishlist');
                                }
                                // Update button label and icon of custom add to wishlist button.
                                if (!currentButton.hasClass('addonify-custom-wishlist-btn') && currentButton.hasClass('addonify-add-to-wishlist-btn')) {
                                    // Update button icon.
                                    currentButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');

                                    // Update button label.
                                    if (currentButton.hasClass('addonify-wishlist-save-for-later')) {
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

                    addonifyWishlistHideLoader();
                });

                // Sets button label and icon for add to wishlist buttons on product removed from the cart.
                $(document).on('addonify_removed_from_wishlist', function (event, data) {

                    if (data.hasOwnProperty('productID')) {

                        let wishlistButtons = $('[data-product_id=' + data.productID + ']');
                        if (wishlistButtons.length > 0) {
                            wishlistButtons.each(function () {
                                let currentButton = $(this);
                                if (currentButton.hasClass('added-to-wishlist')) {
                                    currentButton.removeClass('added-to-wishlist');
                                }
                                // Update button label and icon of custom add to wishlist button.
                                if (!currentButton.hasClass('addonify-custom-wishlist-btn') && currentButton.hasClass('addonify-add-to-wishlist-btn')) {
                                    // Update button icon.
                                    currentButton.find('i.icon.adfy-wishlist-icon').addClass('heart-o-style-one').removeClass('heart-style-one');

                                    // Update button label.
                                    if (currentButton.hasClass('addonify-wishlist-save-for-later')) {
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

            undoEventsHandler: function () {

                // Click event handler for undoing the product removal from the wishlist.
                body.on('click', '#addonify-wishlist-undo-deleted-product-link', function (event) {
                    event.preventDefault();
                    let thisButton = $(this);
                    // Call function to add product into wishlist.
                    addonifyLocalAddToWishlist(thisButton);
                });

                // Event handler for setting timeout for undo notice.
                $(document).on('addonify_wishlist_undo_notice_set', function (event) {
                    clearTimeout(undoTimeout);
                    if (parseInt(undoNoticeTimeout) > 0) {
                        undoTimeout = setTimeout(
                            function () {
                                undoNoticeEle.html('');
                            },
                            parseInt(undoNoticeTimeout) * 1000
                        )
                    }
                });
            },

            addedToCartEventHandler: function () {

                // Updates sidebar and page content, and triggers custom event when product is added into the cart.
                $(document).on('added_to_cart', function (event, fragments, cart_hash, addToCartButton) {

                    if (removeFromWishlistAfterAddedToCart === '1') {
                        let addToWishlistButtonSibling = addToCartButton.parent().find('.addonify-wishlist-ajax-add-to-wishlist');
                        console.log(addToWishlistButtonSibling);
                        if(addToWishlistButtonSibling.hasClass('added-to-wishlist')){
                            addonifyLocalRemoveFromWishlist( addToWishlistButtonSibling, 'added-to-cart' );
                        }
                        
                    }
                });
            },

            toggleBackgroundOverlays: function () {

                // Toggle modal background overlay.
                body.on('click', '#addonify-wishlist-close-modal-btn, #addonify-wishlist-modal-overlay', function () {
                    body.toggleClass('addonify-wishlist-modal-is-open');
                });

                // Toggle sidebar background overlay.
                body.on('click', '#addonify-wishlist-show-sidebar-btn, #close-adfy-wishlist-sidebar-button, #addonify-wishlist-sticky-sidebar-overlay', function () {
                    body.toggleClass('addonify-wishlist-sticky-sidebar-is-visible');
                });
            }
        }

        AddonifyWishlistPublicGuest.init();

        /**
         * Add product to local wishlist.
         *
         * @param {object} addToWishlistButton Button Object.
         */
        function addonifyLocalAddToWishlist(addToWishlistButton) {
            

            // Triggering custom event when product is being added into wishlist. 
            // 'addonify_adding_to_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_adding_to_wishlist');

            let productId = parseInt(addToWishlistButton.data('product_id'));

            let wishlist = getProductids();

            if (wishlist.indexOf(productId) === -1) {

                wishlist.push(productId);
                if ( setProductids(wishlist) !== false ) {
                    let productIds = getProductids();

                    if (afterAddToWishlistAction === 'redirect_to_wishlist_page' && addToWishlistButton.hasClass('addonify-add-to-wishlist-btn')) {
                        window.location.href = wishlistPageURL;
                    }

                    // Triggering custom event when product is added to wishlist. 
                    // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                    $(document).trigger('addonify_added_to_wishlist', [
                        {
                            productID: productId,
                            itemsCount: productIds.length,
                        }
                    ]);

                    // Display added to wishlist modal.
                    if (afterAddToWishlistAction === 'show_popup_notice' && addToWishlistButton.hasClass('addonify-add-to-wishlist-btn')) {
                        addonifyWishlistDisplayModal(addedToWishlistModal, addToWishlistButton.data('product_name'));
                    }

                    $.post(
                        ajax_url,
                        {
                            action: guestAddToWishlistAction,
                            product_ids: JSON.stringify(productIds),
                            nonce: nonce
                        },
                        function (response) {
                            if (response.success) {
                                response.itemsCount = productIds.length;
                                // Updates wishlist sidebar and page content.
                                addonifyWishlistUpdateWishlistSidebarPageContent(response, 'added_to_wishlist');
                            } else {
                                if (response.hasOwnProperty('error')) {
                                    if (response.error === 'e1') {
                                        console.log(response.message);
                                    }
                                }
                            }
                        }
                    );
                } else {
                    // Displays error adding to wishlist modal.
                    addonifyWishlistDisplayModal(errorAddingToWishlistModal, addToWishlistButton.data('product_name'));
                };
            } else {
                if (removeAlreadyAddedProductFromWishlist) {
                    addonifyLocalRemoveFromWishlist(addToWishlistButton)
                }
            }
        }

        /**
         * Function that makes AJAX request and renders the wishlist content.
         */
        function addonifyLoadWishlistContent() {

            addonifyWishlistDisplayLoader();

            let productIds = getProductids();

            $.post(
                ajax_url,
                {
                    action: initialWishlistContentGetAction,
                    product_ids: JSON.stringify(productIds),
                    nonce: nonce
                },
                function (response) {
                    if (response.success) {
                        if (response.hasOwnProperty('tableContent')) {
                            $('#addonify-wishlist-page-items-wrapper').html(response.tableContent);
                        }
                        if (response.hasOwnProperty('sidebarContent')) {
                            $('#addonify-wishlist-sidebar-items-wrapper').html(response.sidebarContent);

                            if (productIds.length > 0) {
                                $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
                            }
                        }
                    } else {
                        if (response.hasOwnProperty('error')) {
                            if (response.error === 'e1') {
                                console.log(response.message);
                            }
                        }
                    }
                }
            ).always(function () {
                addonifyWishlistHideLoader();
            });
        }

        /**
         * Function to remove product from wishlist locally.
         * @param {Object} thisButton Jquery object of the button clicked
         */
        function addonifyLocalRemoveFromWishlist(thisButton, added_to_cart = '') {

            // Triggering custom event when product is being removed from wishlist. 
            // 'addonify_removing_from_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_removing_from_wishlist');

            let productToRemove = parseInt(thisButton.val() ? thisButton.val() : thisButton.data('product_id'));

            let productIds = getProductids();

            if (productIds.indexOf(productToRemove) !== -1) {
                productIds.splice(productIds.indexOf(productToRemove), 1);
                if ( setProductids(productIds) !== false ) {
                    productIds = getProductids();

                    $.post(
                        ajax_url,
                        {
                            action: guestRemoveFromWishlistAction,
                            product_ids: JSON.stringify(productIds),
                            product_id: productToRemove,
                            nonce: nonce
                        },
                        function (response) {
                            if (response.success) {
                                response.itemsCount = productIds.length;
                                // Updates wishlist sidebar and page content.
                                addonifyWishlistUpdateWishlistSidebarPageContent(response, 'removed_from_wishlist', added_to_cart);
                            } else {
                                if (response.hasOwnProperty('error')) {
                                    if (response.error === 'e1') {
                                        console.log(response.message);
                                    }
                                }
                            }
                        }
                    );

                    if (thisButton.hasClass('addonify-wishlist-ajax-add-to-wishlist')) {
                        addonifyWishlistDisplayModal(removedFromWishlistModal, thisButton.data('product_name'));
                    }

                    // Triggering custom event when product is added to wishlist. 
                    // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                    $(document).trigger('addonify_removed_from_wishlist', [
                        {
                            productID: productToRemove,
                            itemsCount: productIds.length,
                        }
                    ]);

                    
                } else {
                    // Displays error removing from wishlist modal.
                    addonifyWishlistDisplayModal(errorRemovingFromWishlistModal, thisButton.data('product_name'));
                }
            } else {
                // Displays error removing from wishlist modal.
                addonifyWishlistDisplayModal(errorRemovingFromWishlistModal, thisButton.data('product_name'));
            }
        }


        /**
         * Return product ids stored in localstorage.
         * 
         * @returns {array|false} product ids.
         */
        function getProductids(wishlist_name = false) {
            if (!wishlist_name) {
                wishlist_name = default_wishlist
            }
            let returnIds = [];
            let items = jsonToArray(parseJson(getLocalItem('product_ids')));
            if (items) {
                items.forEach(function (value, index) {
                    if (typeof value === "object") {
                        if (value.name === wishlist_name) {
                            returnIds = items[index].product_ids;
                            return false;
                        }
                    } else {
                        returnIds = items;
                        return false;
                    }
                })
            }
            return returnIds;
        }

        /**
         * Save product ids in localstorage.
         *
         * @param {Object|string} val Value to be inserted.
         */
        function setProductids(val, wishlist_name = false) {

            if (!wishlist_name) {
                wishlist_name = default_wishlist
            }
            let items = jsonToArray(parseJson(getLocalItem('product_ids')));
            if (items) {
                items.forEach(function (value, index) {
                    if (typeof value === "object") {
                        if (value.name === wishlist_name) {
                            items[index].product_ids = val
                            return false;
                        }
                    } else {
                        items = val;
                        return false;
                    }
                })
                setLocalItem('product_ids', items);
            } else {
                items = [];
                let id = getCurrentWishlistId()
                let d = new Date();
                let created_at = d.getTime();
                let visibility = 'private';
                let wishlist_data = {
                    'id': id,
                    'name': wishlist_name,
                    'visibility': visibility,
                    'created_at': created_at,
                    'product_ids': val
                }
                items.push(wishlist_data);
                setLocalItem('product_ids', items);
                incrementCurrentWishlistId();
            }
        }

        /**
         * Get current wishlist id number.
         *
         * @return int Wishlist Id.
         */
        function getCurrentWishlistId() {
            let id = getLocalItem('wishlist_id');
            if (id) {
                return parseInt(id)
            } else {
                return 0;
            }
        }

        /**
         * Increment wishlist id number.
         */
        function incrementCurrentWishlistId() {
            let id = getCurrentWishlistId()
            setLocalItem('wishlist_id', id + 1)
        }

        /**
         * Store item in localstorage.
         * 
         * @param {string} name Item Name.
         * @param {mixed} val Value to be stored in localstorage.
         */
        function setLocalItem(name, val) {
            if (typeof val === 'object') {
                val = JSON.stringify(val)
            }
            let hostname = thisSiteUrl;
            localStorage.setItem(plugin_name + '_' + hostname + '_' + name, val)
        }

        /**
         * Parse string to json.
         *
         * @param {string} json_str Json string.
         * @return {object|false} Json object
         */
        function parseJson(json_str) {
            let json_val
            try {
                json_val = JSON.parse(json_str)
            } catch (e) {
                return false;
            }
            return json_val
        }

        /**
         * Get item from localstorage.
         *
         * @param {string} name Item name.
         * @return {any}
         */
        function getLocalItem(name) {
            let hostname = thisSiteUrl;
            return localStorage.getItem(plugin_name + '_' + hostname + '_' + name)
        }

        /**
         * Converts json to Array
         * 
         * @param {object} json Json object
         * @returns {object|false} An array
         */
        function jsonToArray(json) {
            if (json !== null && typeof json === 'object') {
                let result = new Array;
                let keys = Object.keys(json);
                if (keys.length > 0) {
                    keys.forEach(function (key) {
                        result[key] = json[key];
                    });
                }
                return result;
            } else {
                return false;
            }
        }


        /**
         * Function to update sidebar and wishlist page content.
         *
         * @param {Object} data Response data.
         * @param {string} action Action causing the update.
         */
        function addonifyWishlistUpdateWishlistSidebarPageContent(data, action, added_to_cart = '') {

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
            if (action === 'removed_from_wishlist' && added_to_cart === '') {
                if (data.hasOwnProperty('undoContent') && $('#addonify-wishlist-notice')) {
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
        function addonifyWishlistDisplayModal(template, productName) {

            if (productName !== '') {
                if (template.includes('{product_name}')) {
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
    });
})(jQuery)