(function ($) {

    'use strict';

    $(document).ready(function () {

        let body = $('body');

        let pluginName = 'addonify-wishlist';

        let {
            enabledMultiWishlist,
            requireLogin,
            ajax_url,
            nonce,
            removeAlreadyAddedProductFromWishlist,
            removeFromWishlistAfterAddedToCart,
            getSidebarTableProductRowAction,
            getWishlistContent,
            thisSiteUrl,
            isLoginRequired,
            loginRequiredModal,
            ifNotLoginAction,
            loginURL,
        } = addonifyWishlistJSObject;

        let productID, productName, beforeSaving, toBeSaved, currentAddToWishlistButton, currentRemoveFromWishlistButton, currentModalIcon, currentModalMessage;

        let wishlistSidebarEle = $('#addonify-wishlist-sticky-sidebar-container'),
            wishlistTableEle = $('#addonify-wishlist-table');

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


        const localWishlistFuncs = {
            setWishlistData: function(){
                localStorage.setItem(pluginName + '_' + thisSiteUrl + '_product_ids', JSON.stringify(toBeSaved));
            },
            setDefaultWishlist: function(){

                toBeSaved = this.getWishlistData();
                beforeSaving = this.getRawWishlistData();

                if (toBeSaved.length === 0) {

                    let currentDate = new Date();
                    let defaultWishlistData = {
                        'id': 0,
                        'name': 'Default Wishlist',
                        'visibility': 'private',
                        'created_at': currentDate.getTime(),
                        'product_ids': []
                    };

                    toBeSaved.push(defaultWishlistData);

                    this.setWishlistData(toBeSaved);

                    if (this.isWishlistDataSaved()) {
                        return defaultWishlistData;
                    }

                    return false;
                }

                return false;
            },
            getRawWishlistData: function(){
                return localStorage.getItem(pluginName + '_' + thisSiteUrl + '_product_ids');
            },
            getWishlistData: function(){
                let rawWishlistData = this.getRawWishlistData();

                if(rawWishlistData === null) {
                    return [];
                }

                let jsonWishlistData;
                try {
                    jsonWishlistData = JSON.parse(rawWishlistData);
                } catch (error) {
                    console.log(error.message);
                }

                if (Array.isArray(jsonWishlistData)) {
                    return jsonWishlistData;
                }

                return [];
            },
            isWishlistDataSaved: function(){
                return (JSON.stringify(beforeSaving) === toBeSaved) ? false : true;
            },
            addToWishlist: function(productId){

                productId = parseInt(productId);

                toBeSaved = this.getWishlistData();
                beforeSaving = this.getRawWishlistData();

                let products = this.getProducts();
                products.push(productId);
                toBeSaved[0]['product_ids'] = products;

                this.setWishlistData();

                return (this.isWishlistDataSaved()) ? true : false;
            },
            removeFromWishlist: function(productId){

                productId = parseInt(productId);

                toBeSaved = this.getWishlistData();
                beforeSaving = this.getRawWishlistData();
                
                let products = this.getProducts();
                let indexOfProduct = products.indexOf(productId);
                if (indexOfProduct !== -1) {
                    products.splice(indexOfProduct, 1);
                }

                toBeSaved[0]['product_ids'] = products;

                this.setWishlistData();

                return (this.isWishlistDataSaved()) ? true : false;
            },
            emptyWishlist: function(){
                toBeSaved = this.getWishlistData();
                beforeSaving = this.getRawWishlistData();

                toBeSaved[0]['product_ids'] = [];

                this.setWishlistData();

                return (this.isWishlistDataSaved()) ? true : false;
            },
            isProductInWishlist: function(productId){

                productId = parseInt(productId);

                let returnWishlistID = false;
                
                let products = this.getProducts();

                if (products.indexOf(productId) !== -1) {
                    returnWishlistID = products.indexOf(productId);
                }

                return returnWishlistID;
            },
            getProductsCount: function(){
                let products = this.getProducts();
                return products.length;
            },
            getProducts: function(){
                let wishlistData = this.getWishlistData();
                if (wishlistData[0] !== undefined) {
                    let products = wishlistData[0]['product_ids'];
                    products.reverse();
                    return products;
                }

                return [];
            }
        };

        let AddonifyWishlistPublicGuest = {

            init: function () {

                let rawWishlistData = localWishlistFuncs.getRawWishlistData();
                if(rawWishlistData === null){
                    localWishlistFuncs.setDefaultWishlist();
                }

                if (requireLogin !== '1' && enabledMultiWishlist !== '1') {

                    let products = localWishlistFuncs.getProducts();

                    products.forEach(function (value, _) {
                        let product_button = $('.adfy-wishlist-btn[data-product_id="' + value + '"]');
                        addonifyWishlistInit.updateWishlistButtons(product_button,'already-in-wishlist');
                    });

                    if (enabledMultiWishlist !== '1') {
                        addonifyLoadWishlistContent();
                    }
                }

                this.onAddToWishlist();
                this.onRemoveFromWishlist();
                this.addedToCartEventHandler();
                this.undoEventsHandler();
            },

            onAddToWishlist: function () {

                if (enabledMultiWishlist !== '1'){
                
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
                                return;
                            }
                        }

                        if (!addonifyWishlistJSObject.hasOwnProperty('enabledAWP')) {
                            currentAddToWishlistButton = $(this);

                            // Set `loading` CSS class.
                            currentAddToWishlistButton.addClass('loading');

                            addonifyWishlistSetProductIDName(currentAddToWishlistButton);

                            if (currentAddToWishlistButton.hasClass('added-to-wishlist')) {

                                if (removeAlreadyAddedProductFromWishlist === '1') {
                                    currentRemoveFromWishlistButton = currentAddToWishlistButton;
                                    addonifyLocalRemoveFromWishlist();
                                } else {
                                    let alreadyInWishlistModalTemplate = addonifyWishlistJSObject.alreadyInWishlistModal;
                                    alreadyInWishlistModalTemplate = addonifyWishlistUpdateProductNameInModal(alreadyInWishlistModalTemplate);
                                    addonifyWishlistDisplayModal(alreadyInWishlistModalTemplate);
                                }
                            } else {
                                addonifyLocalAddToWishlist();
                            }
                            
                            // Remove `loading` CSS class.
                            currentAddToWishlistButton.removeClass('loading');
                        }
                    });
                }
            },

            onRemoveFromWishlist: function () {
                if (enabledMultiWishlist !== '1') {
                    // local remove product from wishlist.
                    $(document).on('click', '.addonify-wishlist-ajax-remove-from-wishlist, .addonify-wishlist-remove-from-wishlist', function (event) {
                        event.preventDefault();
                        currentRemoveFromWishlistButton = $(this);
                        addonifyWishlistSetProductIDName(currentRemoveFromWishlistButton);
                        addonifyLocalRemoveFromWishlist();
                    });

                    // remove all items from wishlist.
                    $(document).on('click', '#addonify-wishlist__clear-all', function () {
                        addonifyWishlistInit.displayLoader();
                        
                        if( localWishlistFuncs.emptyWishlist() ) {
                            // Triggering custom event when wishlist is emptied. 
                            // 'addonify_wishlist_emptied' custom event can be used to perform desired actions.
                            $(document).trigger('addonify_wishlist_emptied');

                            addonifyWishlistInit.updateWishlistTableElements(localWishlistFuncs.getProductsCount());
                        }
                        addonifyWishlistInit.hideLoader();               
                    });
                }
            },

            undoEventsHandler: function () {

                if (enabledMultiWishlist !== '1') {
                    // Click event handler for undoing the product removal from the wishlist.
                    body.on('click', '#addonify-wishlist-undo-deleted-product-link', function (event) {
                        event.preventDefault();
                        currentAddToWishlistButton = $(this);
                        // Call function to add product into wishlist.
                        addonifyLocalAddToWishlist();
                    });
                }
            },

            addedToCartEventHandler: function () {
                if (enabledMultiWishlist !== '1') {
                    // Updates sidebar and page content, and triggers custom event when product is added into the cart.
                    $(document).on('added_to_cart', function (event, fragments, cart_hash, addToCartButton) {

                        if (removeFromWishlistAfterAddedToCart === '1') {
                            addonifyWishlistSetProductIDName(addToCartButton);
                            addonifyLocalRemoveFromWishlist();                            
                        }
                    });
                }
            },
        }

        AddonifyWishlistPublicGuest.init();

        /**
         * Add product to local wishlist.
         */
        function addonifyLocalAddToWishlist() {

            // Triggering custom event when product is being added into wishlist. 
            // 'addonify_adding_to_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_adding_to_wishlist');

            if (localWishlistFuncs.isProductInWishlist(productID) !== false){

                if (removeAlreadyAddedProductFromWishlist === '1') {
                    currentRemoveFromWishlistButton = currentAddToWishlistButton;
                    addonifyLocalRemoveFromWishlist();
                } else {
                    addonifyWishlistInit.displayModal(
                        addonifyWishlistJSObject.alreadyInWishlistModal,
                        addonifyWishlistPrepareModalContentUpdateData()
                    );
                    addonifyWishlistUpdateButton('already-in-wishlist', currentAddToWishlistButton);
                }
            } else {
    
                localWishlistFuncs.addToWishlist(productID);

                if (localWishlistFuncs.isWishlistDataSaved()){

                    let wishlistProductsCount = localWishlistFuncs.getProductsCount();

                    // Triggering custom event when product is added to wishlist. 
                    // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                    $(document).trigger('addonify_added_to_wishlist', [
                        {
                            productID: productID,
                            itemsCount: wishlistProductsCount,
                            thisButton: currentAddToWishlistButton,
                            modalContentUpdateData: addonifyWishlistPrepareModalContentUpdateData(),
                        }
                    ]);

                    let postRequestData = {
                        action: getSidebarTableProductRowAction,
                        product_id: productID,
                        nonce: nonce
                    };

                    if (wishlistSidebarEle.length > 0){
                        postRequestData.has_wishlist_sidebar = true;
                    }
                    
                    if (wishlistTableEle.length > 0) {
                        postRequestData.has_wishlist_table = true;
                    }

                    $.post(
                        ajax_url,
                        postRequestData,
                    ).done(function(response){
                        if (response.success) {
                            if (response.hasOwnProperty('sidebarProductRowContent')){
                                addonifyWishlistInit.addWishlistSidebarProductRow(response.sidebarProductRowContent);
                            }
                            if (response.hasOwnProperty('tableProductRowContent')) {
                                addonifyWishlistInit.addWishlistTableProductRow(response.tableProductRowContent);
                            }
                            addonifyWishlistInit.updateWishlistSidebarElements(wishlistProductsCount);
                        } else {
                            currentModalMessage = response.message;
                            currentModalIcon = 'flash';
                            addonifyWishlistInit.displayModal(
                                addonifyWishlistJSObject.errorModal,
                                addonifyWishlistPrepareModalContentUpdateData()
                            );
                        }
                    });
                } else {
                    addonifyWishlistInit.displayModal(
                        addonifyWishlistJSObject.errorAddingToWishlistModal,
                        addonifyWishlistPrepareModalContentUpdateData()
                    );
                }
            }

            addonifyWishlistInit.hideLoader();
        }

        /**
         * Function to remove product from wishlist locally.
         * @param {Object} thisButton Jquery object of the button clicked
         */
        function addonifyLocalRemoveFromWishlist() {

            // Triggering custom event when product is being removed from wishlist. 
            // 'addonify_removing_from_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_removing_from_wishlist');

            if (localWishlistFuncs.isProductInWishlist(productID) !== false) {

                localWishlistFuncs.removeFromWishlist(productID);

                if (localWishlistFuncs.isWishlistDataSaved()) {

                    let productsCount = localWishlistFuncs.getProductsCount();

                    // Triggering custom event when product is added to wishlist. 
                    // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                    $(document).trigger('addonify_removed_from_wishlist', [
                        {
                            productID: productID,
                            productName: productName,
                            itemsCount: productsCount,
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
            } else {
                addonifyWishlistInit.displayModal(
                    addonifyWishlistJSObject.alreadyInWishlistModal,
                    addonifyWishlistPrepareModalContentUpdateData()
                );
            }

            addonifyWishlistInit.hideLoader();
        }

        /**
         * Function that makes AJAX request and renders the wishlist content.
         */
        function addonifyLoadWishlistContent() {

            addonifyWishlistInit.displayLoader();

            let productIds = localWishlistFuncs.getProducts();

            let productsCount = localWishlistFuncs.getProductsCount();

            if (wishlistSidebarEle.length > 0 || wishlistTableEle.length > 0) {

                let requestData = {
                    action: getWishlistContent,
                    product_ids: JSON.stringify(productIds),
                    nonce: nonce
                };

                if(wishlistSidebarEle.length > 0){
                    requestData.has_wishlist_sidebar = true;
                }

                if (wishlistTableEle.length > 0) {
                    requestData.has_wishlist_table = true;
                }

                $.post(
                    ajax_url,
                    requestData,
                ).done(function(response){
                    if (response.success) {
                        // Updates the wishlist sidebar content.
                        if (response.hasOwnProperty('sidebarContent') && $('#addonify-wishlist-sidebar-items-wrapper').length > 0) {
                            $('#addonify-wishlist-sidebar-items-wrapper').html(response.sidebarContent);
                        }

                        // Updates the wishlist page table content.
                        if (response.hasOwnProperty('tableContent') && $('#addonify-wishlist-page-items-wrapper').length > 0) {
                            $('#addonify-wishlist-page-items-wrapper').html(response.tableContent);
                        }
                    } else {
                        currentModalMessage = response.message;
                        currentModalIcon = 'flash';
                        addonifyWishlistInit.displayModal(
                            addonifyWishlistJSObject.errorModal,
                            addonifyWishlistPrepareModalContentUpdateData()
                        );
                    }
                });

                addonifyWishlistInit.updateWishlistSidebarElements(productsCount);

                addonifyWishlistInit.updateWishlistTableElements(productsCount);
            }

            addonifyWishlistInit.hideLoader();
        }


        function addonifyWishlistSetProductIDName(buttonEle){
            productID = buttonEle.data('product_id');
            productName = buttonEle.data('product_name');
        }

        function addonifyWishlistPrepareModalContentUpdateData(){
            return {
                product_name: productName,
                modal_icon: currentModalIcon,
                modal_message: currentModalMessage,
            };
        }
    });
})(jQuery)