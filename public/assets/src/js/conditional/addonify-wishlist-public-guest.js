( function ($) {

    'use strict';

    $( document ).ready( function() {

        let $body = $('body');
        let $modal_response = $('#addonify-wishlist-modal-response');
        let plugin_name = 'addonify-wishlist';
        let undoTimeout;
        let loader = '<div id="addonify-wishlist_spinner"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2 11h5v2H2zm15 0h5v2h-5zm-6 6h2v5h-2zm0-15h2v5h-2zM4.222 5.636l1.414-1.414 3.536 3.536-1.414 1.414zm15.556 12.728-1.414 1.414-3.536-3.536 1.414-1.414zm-12.02-3.536 1.414 1.414-3.536 3.536-1.414-1.414zm7.07-7.071 3.536-3.535 1.414 1.415-3.536 3.535z"></path></svg></div>';
        $('.addonify-add-to-wishlist-btn button.added-to-wishlist').attr('disabled', true);
        let default_wishlist = "Default Wishlist";

        let {
            requireLogin,
            addedToWishlistButtonLabel,
            loginMessage,
            loginRequiredMessage,
            ajax_url,
            nonce,
            removeAlreadyAddedProductFromWishlist,
            popupAlreadyInWishlistText,
            emptiedWishlistText,
            removeFromWishlistAfterAddedToCart,
            afterAddToWishlistAction,
            wishlistPageURL,
            addToWishlistActionSideBar,
            popupAddedToWishlistText,
            addedToWishlistText,
            undoActionPrelabelText,
            undoActionLabel,
            undoNoticeTimeout,
            initialAddToWishlistButtonLabel,
            sidebarEmptyWishlistText,
            showPageLinkLabel,
            pageLink,
            pageLinkLabel,
            emptyWishlistText,
            thisSiteUrl,
        } = addonifyWishlistJSObject;

        let AddonifyWishlistPublicGuest = {
            init: function() {
                let wishlist_products = getProductids();

                wishlist_products.forEach(function (value, _) {
                    let product_button = $('.adfy-wishlist-btn[data-product_id="' + value + '"]')
                    product_button.find('span').html(addedToWishlistButtonLabel);
                    product_button.find('i').addClass('heart-style-one').removeClass('heart-o-style-one');
                });
                // actions on wishlist page.
                if ($body.find('div#addonify-wishlist-page-container').length > 0) {
                    if (requireLogin) {
                        $('div#addonify-wishlist-page-container').html('<h3>'+loginRequiredMessage+'</h3>');
                    } else {
                        $('div#addonify-wishlist-page-container').html(loader);
                        //populate table
                        $.post(
                            ajax_url,
                            {
                                action: 'addonify_get_wishlist_table',
                                productIds: JSON.stringify(getProductids()),
                                nonce: nonce
                            },
                            function (result) {
                                $body.find('div#addonify-wishlist-page-container').replaceWith(result);
                            }
                        );
                    }
                }

                if ( $('#addonify-wishlist-table').length === 0 && ! requireLogin ) {
                    // fetch wishlist product data from server
                    $.post(
                        ajax_url,
                        {
                            action: 'addonify_get_wishlist_sidebar',
                            productIds: JSON.stringify(getProductids()),
                            nonce: nonce
                        },
                        function (result) {
                            $body.find('#addonify-wishlist-sticky-sidebar-container').replaceWith(result);
                            if (getProductids().length > 0) {
                                $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
                            }
                        }
                    );
                }

                this.onAddToWishlist();
                this.onRemoveFromWishlist();
                this.onAddToCart();
                this.onSideBarAndPopup();
            },
            onAddToWishlist: function() {
                /**
                 * Check if product is already in the cart.
                 * If not call ajax function to add the product into the cart.
                 */
                $body.on('click', '.addonify-wishlist-ajax-add-to-wishlist', function (e) {
                    e.preventDefault();
                    let addToWishlistButton = $(this);
                    if (addToWishlistButton.hasClass('added-to-wishlist')) {
                        if (removeAlreadyAddedProductFromWishlist) {
                            addonifyLocalRemoveFromWishlist(addToWishlistButton)
                        } else {
                            addonifyShowPopupModal(
                                popupAlreadyInWishlistText,
                                addToWishlistButton.data('product_name')
                            );
                        }
                    } else {
                        addonifyLocalAddToWishlist(addToWishlistButton);
                    }
                })

                $body.on( 'click', '#addonify-wishlist-undo-deleted-product-link', function(event) {
                    event.preventDefault();
                    $('#addonify-wishlist-undo-deleted-product').html('');
                    let product_id = $(this).data('product_id');
                    let wishlist_id = $(this).data('wishlist_id');
                    let addToWishlistButton = $('button.addonify-add-to-wishlist-btn[data-product_id='+product_id+']');
                    let $sidebar_items = $('ul.adfy-wishlist-sidebar-items-entry');
                    let $table = $('#addonify-wishlist-table');
                    $('#addonify-wishlist-sticky-sidebar-container').block({message: null});
                    $('#addonify-wishlist-page-container').append(loader);
                    let wishlist = getProductids();
    
                    if (wishlist.indexOf(product_id) === -1) {
                        wishlist.push(product_id);
                        setProductids(wishlist);
    
                        if (afterAddToWishlistAction === 'redirect_to_wishlist_page') {
                            window.location.href = wishlistPageURL;
                            return;
                        }
                        let sidebar_data = '';
                        $.post(
                            ajax_url,
                            {
                                action: addToWishlistActionSideBar,
                                id: product_id,
                                wishlist_id: wishlist_id,
                                nonce: nonce
                            },
                            function (response) {
                                if (response) {
                                    // update sidebar contents
                                    $sidebar_items.prepend(response.sidebar_data);
                                    sidebar_data = response.sidebar_data
                                    if ( $table.length > 0 && response.table_row_data ) {
                                        $table.find('tbody').prepend(response.table_row_data)
                                    }
                                }
                            }
                        ).always( function() {
                            $('#addonify-wishlist_spinner').remove();$('#addonify-wishlist-sticky-sidebar-container').unblock();
                        } );
    
                        if ( addToWishlistButton.length > 0 ) {
                            // update button 
                            addToWishlistButton.addClass('added-to-wishlist');
        
                            // Update button label and icon of custom add to wishlist button.
                            if (!addToWishlistButton.hasClass('addonify-custom-wishlist-btn')) {
                                // Update button label.
                                addToWishlistButton.find('span.addonify-wishlist-btn-label').text(addedToWishlistText);
                                // Update button icon.
                                addToWishlistButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');
                            }
    
                        }
    
                        addonifyEmptyWishlistText(wishlist.length);
    
                        if (wishlist.length > 0) {
                            $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
                            $('#addonify-wishlist__clear-all').show();
                        }
    
                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_added_to_wishlist', [
                            {
                                productID     : product_id,
                                wishlistCount : wishlist.length,
                                sidebarData   : sidebar_data,
                            }
                        ]);
                    } else {
                        $('#addonify-wishlist_spinner').remove();$('#addonify-wishlist-sticky-sidebar-container').unblock();
                        if (removeAlreadyAddedProductFromWishlist) {
                            addonifyLocalRemoveFromWishlist(addToWishlistButton)
                        }
                    }
                } )
            },
            onRemoveFromWishlist: function() {
                // Ajax call to remove product from wishlist.
                $body.on('click', '.addonify-wishlist-ajax-remove-from-wishlist', function (event) {
                    event.preventDefault();
                    let thisButton = $(this);
                    addonifyLocalRemoveFromWishlist(thisButton)
                });

                // local remove product from wishlist.
                $(document).on('click', '.addonify-wishlist-remove-from-wishlist', function (event) {
                    event.preventDefault();
                    let thisButton = $(this);
                    addonifyLocalRemoveFromWishlist(thisButton)
                })

                // remove all items from wishlist.
                $(document).on( 'click', '#addonify-wishlist__clear-all', function() {
                    setProductids([]);
                    addonifyEmptyWishlistText(getProductids().length);
                    addonifyShowPopupModal(
                        emptiedWishlistText,
                        '',
                        'success',
                        false
                    );
                    $('#addonify-wishlist__clear-all').hide();
                    $(document).trigger('addonify_wishlist_emptied')
                })

                // remove a product from wishlist on add to cart.
                if ( removeFromWishlistAfterAddedToCart === '1' ) {
                    $(document).on('click', '.product_type_simple.add_to_cart_button', function (e) {
                        let $this = $(this);
                        let product_id = $this.data('product_id');
                        let product_ids = getProductids();
                        if ( product_ids.indexOf(parseInt(product_id)) > -1 ) {
                            product_ids.splice(product_ids.indexOf(parseInt(product_id)), 1)
                            setProductids(product_ids)
                        }
                    });
                }

                // remove an item from wishlist table.
                $(document).on('click', '.addonify-wishlist-table-remove-from-wishlist', function (event) {
                    event.preventDefault();
                    let p_tag
                    let product_ids = getProductids();
                    let id_to_remove = parseInt($(this).val());
                    if ($(this).closest('tr.addonify-wishlist-table-product-row').length > 0) {
                        p_tag = $(this).closest('tr.addonify-wishlist-table-product-row');
                    }
                    if (product_ids.indexOf(id_to_remove) > -1) {
                        product_ids.splice(product_ids.indexOf(id_to_remove), 1);
                        setProductids(product_ids);
                    }
                    if (p_tag.length === 1) {
                        p_tag.remove();
                    }

                    addonifyEmptyWishlistText(product_ids.length);
                    addonifyUndoRemoveFromWishlist( $(this).data('product_name'), id_to_remove );
                });

            },
            onAddToCart: function() {

                // Ajax call to add product into cart.
                $body.on('click', '.addonify-wishlist-ajax-add-to-cart', function (event) {
        
                    event.preventDefault();
        
                    let thisButton = $(this);
        
                    let ajaxData = {
                        action: 'addonify_add_to_cart_from_wishlist',
                        productId: thisButton.val(),
                        nonce: nonce
                    }
        
                    let parentProductRow = '';
        
                    if (thisButton.hasClass('addonify-wishlist-sidebar-button')) {
                        parentProductRow = $('div#addonify-wishlist-sticky-sidebar-container').find('li[data-product_row="addonify-wishlist-sidebar-product-row-' + thisButton.val() + '"]');
                    }
        
                    if (thisButton.hasClass('addonify-wishlist-table-button')) {
                        parentProductRow = $('#addonify-wishlist-table').find('tr[data-product_row="addonify-wishlist-table-product-row-' + thisButton.val() + '"]');
                    }
        
                    if (parentProductRow) {
                        parentProductRow.addClass('loading');
                    }
        
                    $.post(
                        ajax_url,
                        ajaxData,
                        function (response) {
                            if (response.success) {
        
                                // Triggering custom event when product is added to cart. 
                                // 'addonify_added_to_cart' custom event can be used to perform desired actions.
                                $(document).trigger('addonify_added_to_cart', [
                                    {
                                        productID      : thisButton.data('product_id'),
                                    }
                                ]);
                                if (thisButton.hasClass('addonify-wishlist-table-button')) {
                                    addonifyShowPopupModal('{product_name} added to cart', thisButton.data('product_name'), 'success')
                                }
        
                                if (removeFromWishlistAfterAddedToCart === '1' && parentProductRow) {
        
                                    parentProductRow.remove();
        
                                    addonifyInitialWishlistButton(thisButton.val());
                                    if ( isLoggedIn ) {
                                        addonifyEmptyWishlistText(response.wishlist_count);
                                    } else {
                                        let product_ids = getProductids();
                                        if ( product_ids.indexOf(parseInt(thisButton.val())) > -1 ) {
                                            product_ids.splice(product_ids.indexOf(parseInt(thisButton.val())), 1)
                                            setProductids(product_ids)
                                        }
                                        addonifyEmptyWishlistText(product_ids.length);
                                    }
                                }
                            }
                        },
                        "json"
                    );
        
                    if (parentProductRow) {
                        parentProductRow.removeClass('loading');
                    }
                });

                // when added_to_cart is triggered
                $(document).on('added_to_cart', function (event, fragments, cart_hash, addToCartButton) {
                    let product_id = (addToCartButton.data('product_id'));
        
                    let parentProductRow = '';
                    let parentProductSiblings = 0;
        
                    if ($('#addonify-wishlist-table').length > 0) {
                        parentProductRow = $('#addonify-wishlist-table').find('tr[data-product_row="addonify-wishlist-table-product-row-' + product_id + '"]');
                    } else {
                        parentProductRow = $('div#addonify-wishlist-sticky-sidebar-container').find('li[data-product_row="addonify-wishlist-sidebar-product-row-' + product_id + '"]');
                    }
                    parentProductSiblings = parentProductRow.siblings().length;
        
                    if (removeFromWishlistAfterAddedToCart === '1' && parentProductRow.length > 0) {
                        if (parentProductRow.length > 0) {
                            parentProductRow.remove();
                        }
        
                        addonifyInitialWishlistButton(product_id);
                        addonifyEmptyWishlistText(parentProductSiblings);
                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_removed_from_wishlist', [{ productID: product_id, wishlist_count : getProductids().length }]);
                    }
                    if (addToCartButton.parent().hasClass('addonify-wishlist-table-button')) {
                        addonifyShowPopupModal('{product_name} added to cart', parentProductRow.data('product_name'), false, false)
                    }
                })
            },
            onSideBarAndPopup: function() {
                // Display popup modal if login is required.
                $body.on('click', '.addonify-wishlist-login-popup-enabled', function (e) {
                    e.preventDefault();
                    addonifyShowPopupModal(loginMessage, '', 'error');
                });

                // Close popup modal.
                $body.on('click', '#addonify-wishlist-close-modal-btn', function () {
                    $body.removeClass('addonify-wishlist-modal-is-open');
                })

                // Close popup modal.
                $body.on('click', '#addonify-wishlist-sticky-sidebar-overlay', function () {
                    $body.removeClass('addonify-wishlist-sticky-sidebar-is-visible');
                })

                // Toggle sidebar wishlist.
                $body.on('click', '#addonify-wishlist-show-sidebar-btn, #close-adfy-wishlist-sidebar-button', function () {
                    $body.toggleClass('addonify-wishlist-sticky-sidebar-is-visible');
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
            let id = addToWishlistButton.data('product_id');

            let wishlist = getProductids();

            if (wishlist.indexOf(id) === -1) {
                wishlist.push(id);
                setProductids(wishlist);

                if (afterAddToWishlistAction === 'redirect_to_wishlist_page') {
                    window.location.href = wishlistPageURL;
                    return;
                }
                let sidebar_data = '';
                $.post(
                    ajax_url,
                    {
                        action: addToWishlistActionSideBar,
                        id: addToWishlistButton.data('product_id'),
                        nonce: nonce
                    },
                    function (response) {
                        if (response) {
                            // update sidebar contents
                            $('ul.adfy-wishlist-sidebar-items-entry').append(response.sidebar_data);
                            sidebar_data = response.sidebar_data
                        }
                    }
                );

                // update button 
                addToWishlistButton.addClass('added-to-wishlist');

                addonifyEmptyWishlistText(wishlist.length);

                addonifyShowPopupModal(
                    popupAddedToWishlistText,
                    addToWishlistButton.data('product_name'),
                    'success'
                );

                if (wishlist.length > 0) {
                    $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
                    $('#addonify-wishlist__clear-all').show();
                }

                // Update button label and icon of custom add to wishlist button.
                if (!addToWishlistButton.hasClass('addonify-custom-wishlist-btn')) {
                    // Update button label.
                    addToWishlistButton.find('span.addonify-wishlist-btn-label').text(addedToWishlistText);
                    // Update button icon.
                    addToWishlistButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');
                }

                // Triggering custom event when product is added to wishlist. 
                // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                $(document).trigger('addonify_added_to_wishlist', [
                    {
                        productID      : addToWishlistButton.data('product_id'),
                        wishlistCount : wishlist.length,
                        sidebarData   : sidebar_data,
                    }
                ]);
            } else {
                if (removeAlreadyAddedProductFromWishlist) {
                    addonifyLocalRemoveFromWishlist(addToWishlistButton)
                }
            }

        }

        /**
         * Function to remove product from wishlist locally.
         * @param {Object} thisButton Jquery object of the button clicked
         */
        function addonifyLocalRemoveFromWishlist(thisButton) {
            let parentProductRow;
            let id_to_remove = parseInt(thisButton.val() ? thisButton.val() : thisButton.data('product_id'));
            if ($('#addonify-wishlist-sticky-sidebar-container').length > 0) {
                parentProductRow = $('#addonify-wishlist-sticky-sidebar-container').find('li[data-product_row="addonify-wishlist-sidebar-product-row-' + id_to_remove + '"]');
                parentProductRow.addClass('loading');
            }

            if ($('#addonify-wishlist-table').length > 0) {
                parentProductRow = $('#addonify-wishlist-table').find('tr[data-product_row="addonify-wishlist-table-product-row-' + id_to_remove + '"]');
                parentProductRow.append(loader)
            }

            let p_tag
            if (thisButton.closest('li.addonify-wishlist-sidebar-item').length > 0) {
                p_tag = thisButton.closest('li.addonify-wishlist-sidebar-item');
                p_tag.addClass('loading')
            }

            let product_ids = getProductids();
            if (product_ids.indexOf(id_to_remove) > -1) {
                product_ids.splice(product_ids.indexOf(id_to_remove), 1);
                setProductids(product_ids);
            }

            // Triggering custom event when product is added to wishlist. 
            // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
            $(document).trigger('addonify_removed_from_wishlist', [{ productID: id_to_remove, wishlistCount : product_ids.length }]);

            if (product_ids.length <= 0) {
                $('#addonify-wishlist-show-sidebar-btn').addClass('hidden');
                $('#addonify-wishlist__clear-all').hide();
            }

            addonifyInitialWishlistButton(id_to_remove);

            addonifyEmptyWishlistText(product_ids.length);

            if (p_tag && p_tag.length === 1) {
                p_tag.remove();
            }

            if (parentProductRow) {
                parentProductRow.remove();
            }
            addonifyUndoRemoveFromWishlist( thisButton.data('product_name'), id_to_remove );
        }

        /**
         * Display undo remove from wishlist message.
         * 
         * @param {string} product_name Name of the product.
         * @param {int} product_id Product ID.
         */
        function addonifyUndoRemoveFromWishlist( product_name, product_id, wishlist_id='' ) {
            clearTimeout(undoTimeout)
            let product_removed_text = undoActionPrelabelText;
            product_removed_text = product_removed_text.replace('{product_name}', product_name);
            let undo_text = undoActionLabel;
            let undo_div = `
                <p id="addonify-wishlist-undo-deleted-product-text">
                    ` + product_removed_text + `
                    <a href="#" id="addonify-wishlist-undo-deleted-product-link" data-product_id="` + product_id + `" data-wishlist_id="` + wishlist_id + `"> ` + undo_text + ` </a>
                </p>`;
            $('#addonify-wishlist-undo-deleted-product').html(undo_div);
            undoTimeout = setTimeout(
                function() {
                    $('#addonify-wishlist-undo-deleted-product').html('');
                },
                parseInt(undoNoticeTimeout) * 1000
            )
        }


        // Display intial state wishlist button label and icon.
        function addonifyInitialWishlistButton(productId) {

            let wishlistButton = $('[data-product_id="' + productId + '"].addonify-add-to-wishlist-btn');

            // Update button label and icon of custom add to wishlist button.
            if (wishlistButton && !wishlistButton.hasClass('addonify-custom-wishlist-btn')) {
                wishlistButton.removeClass('added-to-wishlist');
                // Update button label.
                wishlistButton.find('span.addonify-wishlist-btn-label').text(initialAddToWishlistButtonLabel);
                // Update button icon.
                wishlistButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-style-one').addClass('heart-o-style-one');
            }

            if ($('.woocommerce-notices-wrapper')) {
                $('.woocommerce-notices-wrapper').remove();
            }
        }

        // Show popup modal with message.
        function addonifyShowPopupModal(response_text, product_name, icon, show_view_wishlist_button = true) {
            if ( ! show_view_wishlist_button ) {
                $('.addonify-view-wishlist-btn').css('display','none');
            } else {
                $('.addonify-view-wishlist-btn').css('display','block');
            }
            $('.adfy-wishlist-icon-entry .adfy-wishlist-icon').hide();
            if (icon) {
                // change icon
                $('.adfy-wishlist-icon-entry .adfy-wishlist-icon.adfy-status-' + icon).show();
            }
            $modal_response.html("<p class='response-text'>" + response_text.replace('{product_name}', product_name) + "</p>");
            $body.addClass('addonify-wishlist-modal-is-open');
        }

        // Display empty wishlist text.
        function addonifyEmptyWishlistText(wishlistCount) {
            let addonifyWishlistStickySidebarEle = $("#addonify-wishlist-sticky-sidebar-container");
            let addonifyWishListEmptyTextEle = $("#addonify-wishlist-sticky-sidebar-container #addonify-empty-wishlist-para");
            let table = $('#addonify-wishlist-table')
            let empty_div = $('#addonify-wishlist-empty')
            empty_div.html('');
            if (wishlistCount > 0) {
                if ( table.length > 0 ) {
                    table.show();
                }
                if (addonifyWishListEmptyTextEle.length > 0) {
                    addonifyWishListEmptyTextEle.remove();
                }
            } else {

                if (addonifyWishlistStickySidebarEle.length > 0) {
                    $('#addonify-wishlist-sticky-sidebar-container ul.adfy-wishlist-sidebar-items-entry').html('<p id="addonify-empty-wishlist-para">' + sidebarEmptyWishlistText + '</p>');
                }
                if ($('#addonify-wishlist-page-form')) {
                    table.hide();
                    let link = '';
                    if (showPageLinkLabel) {
                        link = "<a href='" + pageLink + "'>" + pageLinkLabel + "</a>"
                    }   
                    empty_div.html(`
                        <p id="addonify-empty-wishlist-para">` + emptyWishlistText + link + `</p>
                    `);
                }
            }
        }


        /**
         * Return product ids stored in localstorage.
         * 
         * @returns {array|false} product ids.
         */
        function getProductids(wishlist_name = false) {
            if ( ! wishlist_name ) {
                wishlist_name = default_wishlist
            }
            let returnIds = [];
            let items = jsonToArray(parseJson(getLocalItem('product_ids')));
            if ( items ) {
                items.forEach( function( value, index ) {
                    if ( typeof value === "object" ) {
                        if ( value.name === wishlist_name ) {
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
            if ( ! wishlist_name ) {
                wishlist_name = default_wishlist
            }
            let items = jsonToArray(parseJson(getLocalItem('product_ids')));
            if ( items ) {
                items.forEach( function( value, index ) {
                    if ( typeof value === "object" ) {
                        if ( value.name === wishlist_name ) {
                            items[index].product_ids = val
                            return false;
                        }
                    } else {
                        items = val;
                        return false;
                    }
                } )
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
            if ( id ) {
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
            setLocalItem('wishlist_id',id+1)
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

    } )

} )(jQuery)