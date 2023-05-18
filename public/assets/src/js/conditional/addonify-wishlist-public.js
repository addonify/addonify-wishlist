(function ($) {

    'use strict';

    $(document).ready(function () {

        let $body = $('body');
        let $modal_response = $('#addonify-wishlist-modal-response');
        let $sidebar_ul = $('ul.adfy-wishlist-sidebar-items-entry');
        let isLoggedIn = addonifyWishlistJSObject.isLoggedIn;
        let undoTimeout;
        let loader = '<div id="addonify-wishlist_spinner"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2 11h5v2H2zm15 0h5v2h-5zm-6 6h2v5h-2zm0-15h2v5h-2zM4.222 5.636l1.414-1.414 3.536 3.536-1.414 1.414zm15.556 12.728-1.414 1.414-3.536-3.536 1.414-1.414zm-12.02-3.536 1.414 1.414-3.536 3.536-1.414-1.414zm7.07-7.071 3.536-3.535 1.414 1.415-3.536 3.535z"></path></svg></div>';
        $('.addonify-add-to-wishlist-btn button.added-to-wishlist').attr('disabled', true);

        // Display popup modal if login is required.
        $body.on('click', '.addonify-wishlist-login-popup-enabled', function (e) {
            e.preventDefault();
            addonifyShowPopupModal(addonifyWishlistJSObject.loginMessage, '', 'error');
        });

        if ( ! addonifyWishlistJSObject.proExists ) {
            /**
             * Check if product is already in the cart.
             * If not call ajax function to add the product into the cart.
             */
            $body.on('click', '.addonify-wishlist-ajax-add-to-wishlist', function (e) {
                e.preventDefault();
                let addToWishlistButton = $(this);
                if (addToWishlistButton.hasClass('added-to-wishlist')) {
                    if (addonifyWishlistJSObject.removeAlreadyAddedProductFromWishlist) {
                        addonifyRemoveFromWishlist(addToWishlistButton)
                    } else {
                        addonifyShowPopupModal(
                            addonifyWishlistJSObject.popupAlreadyInWishlistText,
                            addToWishlistButton.data('product_name'),
                            'success'
                        );
                    }
                } else {
                    addonifyAddToWishlist(addToWishlistButton);
                }
            })
        }

        // Close popup modal.
        $body.on('click', '#addonify-wishlist-close-modal-btn, #addonify-wishlist-modal-wrapper', function () {
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

        $body.on('click', '#addonify-wishlist-undo-deleted-product-link', function (event) {
            event.preventDefault();
            $('#addonify-wishlist-undo-deleted-product').html('');
            let product_id = $(this).data('product_id');
            let wishlist_id = $(this).data('wishlist_id');
            let addToWishlistButton = $('button.addonify-add-to-wishlist-btn[data-product_id=' + product_id + ']');
            let $sidebar_items = $('ul.adfy-wishlist-sidebar-items-entry');
            let $table = $('#addonify-wishlist-table');
            $('#addonify-wishlist-sticky-sidebar-container').block({ message: null });
            $('#addonify-wishlist-page-container').append(loader);
            let data = {
                action: addonifyWishlistJSObject.addToWishlistAction,
                id: product_id,
                wishlist_id: wishlist_id,
                nonce: addonifyWishlistJSObject.nonce
            };
            $.post(
                addonifyWishlistJSObject.ajax_url,
                data,
                function (response) {
                    if (response.success == true) {

                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_added_to_wishlist', [
                            {
                                productID: product_id,
                                wishlistCount: response.wishlist_count,
                                sidebarData: response.sidebar_data,
                            }
                        ]);

                        addonifyEmptyWishlistText(response.wishlist_count);

                        if (addToWishlistButton.length > 0) {
                            // update button 
                            addToWishlistButton.addClass('added-to-wishlist');

                            // Update button label and icon of custom add to wishlist button.
                            if (!addToWishlistButton.hasClass('addonify-custom-wishlist-btn')) {
                                // Update button label.
                                addToWishlistButton.find('span.addonify-wishlist-btn-label').text(addonifyWishlistJSObject.addedToWishlistText);
                                // Update button icon.
                                addToWishlistButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');
                            }
                        }

                        if (response.wishlist_count > 0) {
                            $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
                            $('#addonify-wishlist__clear-all').show();
                        }

                        if (response.sidebar_data) {
                            // update sidebar contents
                            $sidebar_ul.prepend(response.sidebar_data);
                        }
                        if ($table.length > 0 && response.table_row_data) {
                            $table.find('tbody').prepend(response.table_row_data)
                        }
                    } else {
                        addonifyShowPopupModal(
                            response.message,
                            addToWishlistButton.data('product_name'),
                            'error'
                        );
                    }
                },
                "json"
            ).always(function () {
                $('#addonify-wishlist_spinner').remove();
                $('#addonify-wishlist-sticky-sidebar-container').unblock();
            });
        })

        // Ajax call to remove product from wishlist.
        $body.on('click', '.addonify-wishlist-ajax-remove-from-wishlist', function (event) {

            event.preventDefault();

            let thisButton = $(this);

            addonifyRemoveFromWishlist(thisButton)
        });

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

            if (addonifyWishlistJSObject.removeFromWishlistAfterAddedToCart === '1' && parentProductRow.length > 0) {
                if (parentProductRow.length > 0) {
                    parentProductRow.remove();
                }

                addonifyInitialWishlistButton(product_id);
                addonifyEmptyWishlistText(parentProductSiblings);
                // Triggering custom event when product is added to wishlist. 
                // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                $(document).trigger('addonify_removed_from_wishlist', [{ productID: product_id, wishlist_count: fragments.addonify_wishlist_count }]);
            }

            if ( fragments.addonify_wishlist_count <= 0 ) {
                $('#addonify-wishlist-show-sidebar-btn').addClass('hidden');
                $('#addonify-wishlist__clear-all').hide();
            }
            $('#addonify-wishlist-undo-deleted-product').html('');
        })

        $(document).on('click', '#addonify-wishlist__clear-all', function () {
            let ajaxData = {
                action: addonifyWishlistJSObject.emptyWishlistAction,
                nonce: addonifyWishlistJSObject.nonce
            }
            $('#addonify-wishlist-table').append(loader)
            $.post(
                addonifyWishlistJSObject.ajax_url,
                ajaxData,
                function (response) {
                    if (response.success) {
                        addonifyEmptyWishlistText(0);
                        $('#addonify-wishlist__clear-all').hide();
                        $(document).trigger('addonify_wishlist_emptied')
                    } else {
                        addonifyShowPopupModal(
                            response.message,
                            '',
                            'failure',
                            false
                        );
                    }
                }
            ).always(function () {
                $('#addonify-wishlist-table #addonify-wishlist_spinner').remove();
            })
        })

        // Ajax call to add product into the wishlist.
        function addonifyAddToWishlist(addToWishlistButton) {

            let data = {
                action: addonifyWishlistJSObject.addToWishlistAction,
                id: addToWishlistButton.data('product_id'),
                wishlist_id: addToWishlistButton.data('wishlist_id'),
                nonce: addonifyWishlistJSObject.nonce
            };

            addToWishlistButton.addClass('loading');

            $.post(
                addonifyWishlistJSObject.ajax_url,
                data,
                function (response) {

                    if (response.success == true) {

                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_added_to_wishlist', [
                            {
                                productID: addToWishlistButton.data('product_id'),
                                wishlistCount: response.wishlist_count,
                                sidebarData: response.sidebar_data,
                            }
                        ]);

                        addonifyEmptyWishlistText(response.wishlist_count);

                        // update button 
                        addToWishlistButton.addClass('added-to-wishlist');

                        if (addonifyWishlistJSObject.afterAddToWishlistAction !== 'none') {
                            addonifyShowPopupModal(
                                response.message,
                                addToWishlistButton.data('product_name'),
                                'success'
                            );
                        }

                        // if undo message exists for given product, remove message
                        let undo_message = $('#addonify-wishlist-undo-deleted-product-link')
                        if ( undo_message ) {
                            undo_message.parent('#addonify-wishlist-undo-deleted-product-text').remove();
                        }

                        if (response.wishlist_count > 0) {
                            $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
                            $('#addonify-wishlist__clear-all').show();
                        }

                        if (response.sidebar_data) {
                            // update sidebar contents
                            $sidebar_ul.append(response.sidebar_data);
                        }

                        // Update button label and icon of custom add to wishlist button.
                        if (!addToWishlistButton.hasClass('addonify-custom-wishlist-btn')) {
                            // Update button label.
                            addToWishlistButton.find('span.addonify-wishlist-btn-label').text(addonifyWishlistJSObject.addedToWishlistText);
                            // Update button icon.
                            addToWishlistButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');
                        }
                    } else {
                        addonifyShowPopupModal(
                            response.message,
                            addToWishlistButton.data('product_name'),
                            'error'
                        );
                    }

                },
                "json"
            ).always(function () {
                addToWishlistButton.removeClass('loading');
                if (addToWishlistButton.hasClass('addonify_wishlist-cart-item-add-to-wishlist')) {
                    addToWishlistButton.hide();
                }
            });
        }

        /**
         * Function to remove product from wishlist.
         * @param {Object} thisButton Jquery object of the button clicked
         */
        function addonifyRemoveFromWishlist(thisButton) {

            thisButton.addClass('loading');

            let product_id = parseInt(thisButton.val() ? thisButton.val() : thisButton.data('product_id'))
            let wishlist_id = parseInt(thisButton.data('wishlist_id'))

            let ajaxData = {
                action: 'addonify_remove_from_wishlist',
                productId: product_id,
                wishlistId: wishlist_id,
                nonce: addonifyWishlistJSObject.nonce
            }

            let parentProductRow = '';

            if ($('#addonify-wishlist-sticky-sidebar-container').length > 0) {
                parentProductRow = $('#addonify-wishlist-sticky-sidebar-container').find('li[data-product_row="addonify-wishlist-sidebar-product-row-' + product_id + '"]');
                parentProductRow.addClass('loading');
            }

            if ($('#addonify-wishlist-table').length > 0) {
                parentProductRow = $('#addonify-wishlist-table').find('tr[data-product_row="addonify-wishlist-table-product-row-' + product_id + '"]');
                parentProductRow.append(loader)
            }

            $.post(
                addonifyWishlistJSObject.ajax_url,
                ajaxData,
                function (response) {

                    if (response.success) {

                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_removed_from_wishlist', [{ productID: product_id, wishlistCount: response.wishlist_count }]);

                        if (response.wishlist_count <= 0) {
                            $('#addonify-wishlist-show-sidebar-btn').addClass('hidden');
                            $('#addonify-wishlist__clear-all').hide();
                        }

                        addonifyInitialWishlistButton(product_id);

                        addonifyEmptyWishlistText(response.wishlist_count);

                        addonifyUndoRemoveFromWishlist(thisButton.data('product_name'), product_id, wishlist_id);
                    } else {
                        addonifyShowPopupModal(
                            response.message,
                            addToWishlistButton.data('product_name'),
                            'error'
                        );
                    }
                },
                "json"
            ).always(function () {
                thisButton.removeClass('loading');
                if (parentProductRow) {
                    parentProductRow.remove();
                }
            });
        }

        // Show popup modal with message.
        function addonifyShowPopupModal(response_text, product_name, icon, show_view_wishlist_button = true) {
            if (!show_view_wishlist_button) {
                $('.addonify-view-wishlist-btn').css('display', 'none');
            } else {
                $('.addonify-view-wishlist-btn').css('display', 'block');
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
                if (table.length > 0) {
                    table.show();
                }
                if (addonifyWishListEmptyTextEle.length > 0) {
                    addonifyWishListEmptyTextEle.remove();
                }
            } else {

                if (addonifyWishlistStickySidebarEle.length > 0) {
                    $('#addonify-wishlist-sticky-sidebar-container ul.adfy-wishlist-sidebar-items-entry').html('<p id="addonify-empty-wishlist-para">' + addonifyWishlistJSObject.sidebarEmptyWishlistText + '</p>');
                }
                if ($('#addonify-wishlist-page-form')) {
                    table.hide();
                    let link = '';
                    if (addonifyWishlistJSObject.showPageLinkLabel) {
                        link = "<a href='" + addonifyWishlistJSObject.pageLink + "'>" + addonifyWishlistJSObject.pageLinkLabel + "</a>"
                    }
                    empty_div.html(`
                        <p id="addonify-empty-wishlist-para">` + addonifyWishlistJSObject.emptyWishlistText + link + `</p>
                    `);
                }
            }
        }

        /**
         * Display undo remove from wishlist message.
         * 
         * @param {string} product_name Name of the product.
         * @param {int} product_id Product ID.
         */
        function addonifyUndoRemoveFromWishlist(product_name, product_id, wishlist_id = '') {
            clearTimeout(undoTimeout)
            let product_removed_text = addonifyWishlistJSObject.undoActionPrelabelText;
            product_removed_text = product_removed_text.replace('{product_name}', product_name);
            let undo_text = addonifyWishlistJSObject.undoActionLabel;
            let undo_div = `
                <p id="addonify-wishlist-undo-deleted-product-text">
                    ` + product_removed_text + `
                    <a href="#" id="addonify-wishlist-undo-deleted-product-link" data-product_id="` + product_id + `" data-wishlist_id="` + wishlist_id + `"> ` + undo_text + ` </a>
                </p>`;
            $('#addonify-wishlist-undo-deleted-product').html(undo_div);
            if ( parseInt(addonifyWishlistJSObject.undoNoticeTimeout) > 0 ) {
                undoTimeout = setTimeout(
                    function () {
                        $('#addonify-wishlist-undo-deleted-product').html('');
                    },
                    parseInt(addonifyWishlistJSObject.undoNoticeTimeout) * 1000
                )
            }
        }

        // Display intial state wishlist button label and icon.
        function addonifyInitialWishlistButton(product_id) {
            let productBtns = $('[data-product_id="' + product_id + '"].addonify-add-to-wishlist-btn')
            let label = addonifyWishlistJSObject.initialAddToWishlistButtonLabel
            productBtns.each(function(_, val) {
                if ( $(val).attr('data-wishlist_label') ) {
                    label = $(val).attr('data-wishlist_label')
                }

                // Update button label and icon of custom add to wishlist button.
                if ($(val) && !$(val).hasClass('addonify-custom-wishlist-btn')) {
                    $(val).removeClass('added-to-wishlist');
                    // Update button label.
                    $(val).find('span.addonify-wishlist-btn-label').text(label);
                    // Update button icon.
                    $(val).find('i.icon.adfy-wishlist-icon').removeClass('heart-style-one').addClass('heart-o-style-one');
                }
            })

            if ($('.woocommerce-notices-wrapper')) {
                $('.woocommerce-notices-wrapper').remove();
            }
        }
    });

})(jQuery);