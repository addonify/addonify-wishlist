(function ($) {
    $.fn.addonifyWishlistInit = function(settings) {

        const body = $('body');
        let undoTimeout;

        const initializeAddonifyWishlist = {
            init: function(){
                initializeAddonifyWishlist.toggleModalBackgrounds();
                initializeAddonifyWishlist.wishlistEvents();
                initializeAddonifyWishlist.undoEvent();
            },
            displayModal: function (modalTemplate, elesToUpdate) {
                for (const key in elesToUpdate) {

                    if (elesToUpdate.hasOwnProperty(key)){
                        let value = elesToUpdate[key];
                        
                        if (value !== '' && value !== undefined){
                            switch (key) {
                                case 'product_name':
                                    if (modalTemplate.includes('{product_name}')) {
                                        modalTemplate = modalTemplate.replace('{product_name}', value);
                                    }
                                    break;
                                case 'modal_message':
                                    if (modalTemplate.includes('{modal_message}')) {
                                        modalTemplate = modalTemplate.replace('{modal_message}', value);
                                    }
                                    break;
                                case 'modal_icon':
                                    if (modalTemplate.includes('{modal_icon}')) {
                                        modalTemplate = modalTemplate.replace('{modal_icon}', value);
                                    }
                                    break;
                                case 'wishlist_name':
                                    if (modalTemplate.includes('{wishlist_name}')) {
                                        modalTemplate = modalTemplate.replace('{wishlist_name}', value);
                                    }
                                    break;
                                default:
                            }
                        }
                    }
                };

                $('#addonify-wishlist-modal-wrapper').replaceWith(modalTemplate);
                if (!body.hasClass('addonify-wishlist-modal-is-open')){
                    body.toggleClass('addonify-wishlist-modal-is-open');
                }
            },
            toggleModalBackgrounds: function(){
                // Toggle modal background overlay.
                body.on('click', '#addonify-wishlist-close-modal-btn, #addonify-wishlist-modal-overlay', function () {
                    body.toggleClass('addonify-wishlist-modal-is-open');
                    initializeAddonifyWishlist.hideLoader();
                });

                // Toggle sidebar background overlay.
                body.on('click', '#addonify-wishlist-show-sidebar-btn, #close-adfy-wishlist-sidebar-button, #addonify-wishlist-sticky-sidebar-overlay', function () {
                    body.toggleClass('addonify-wishlist-sticky-sidebar-is-visible');
                });
            },
            wishlistEvents: function(){

                // Displays loader when product is being added into the wishlist.
                $(document).on('addonify_adding_to_wishlist', function () {
                    initializeAddonifyWishlist.displayLoader();
                });

                // Displays loader when product is being removed from the wishlist.
                $(document).on('addonify_removing_from_wishlist', function () {
                    initializeAddonifyWishlist.displayLoader();
                });

                // Sets button label and icon for add to wishlist buttons on product added into the cart.
                $(document).on('addonify_added_to_wishlist', function (event, data) {

                    initializeAddonifyWishlist.renderUndoNotice(false);

                    if( data.hasOwnProperty('thisButton') ) {
                        if (settings.afterAddToWishlistAction === 'redirect_to_wishlist_page' && data.thisButton.hasClass('addonify-add-to-wishlist-btn')) {
                            window.location.href = settings.wishlistPageURL;
                            return;
                        }
                    }

                    if (data.hasOwnProperty('thisButton') && data.hasOwnProperty('modalContentUpdateData')) {
                        // Display added to wishlist modal.
                        if (settings.afterAddToWishlistAction === 'show_popup_notice' && data.thisButton.hasClass('addonify-add-to-wishlist-btn')) {
                            initializeAddonifyWishlist.displayModal(
                                settings.addedToWishlistModal,
                                data.modalContentUpdateData
                            );
                        }
                    }

                    if (data.hasOwnProperty('productID')) {
                        let wishlistButtons = $('button[data-product_id=' + data.productID + ']');
                        if (wishlistButtons.length > 0) {
                            wishlistButtons.each(function () {
                                let currentButton = $(this);
                                let wishlistId = data.hasOwnProperty('wishlistID') ? data.wishlistID : '';
                                let wishlistName = data.hasOwnProperty('wishlistName') ? data.wishlistName : '';
                                initializeAddonifyWishlist.updateWishlistButtons(currentButton, 'added-to-wishlist', wishlistId, wishlistName );
                            });
                        }
                    }

                    if (data.hasOwnProperty('itemsCount')) {
                        initializeAddonifyWishlist.updateWishlistSidebarElements(data.itemsCount);
                        initializeAddonifyWishlist.updateWishlistTableElements(data.itemsCount);
                    }
                });

                // Sets button label and icon for add to wishlist buttons on product removed from the cart.
                $(document).on('addonify_removed_from_wishlist', function (event, data) {
                    
                    if (data.hasOwnProperty('thisButton') && data.hasOwnProperty('modalContentUpdateData')) {
                        if (data.thisButton !== undefined && data.thisButton.hasClass('addonify-add-to-wishlist-btn')) {
                            initializeAddonifyWishlist.displayModal(
                                settings.removedFromWishlistModal,
                                data.modalContentUpdateData
                            );

                        }
                    }

                    if (data.hasOwnProperty('productID')) {

                        let wishlistButtons = $('[data-product_id=' + data.productID + ']');
                        if (wishlistButtons.length > 0) {
                            wishlistButtons.each(function () {
                                let currentButton = $(this);
                                let wishlistId = data.hasOwnProperty('wishlistID') ? data.wishlistID : '';
                                let wishlistName = data.hasOwnProperty('wishlistName') ? data.wishlistName : '';
                                initializeAddonifyWishlist.updateWishlistButtons(currentButton, 'removed-from-wishlist', wishlistId, wishlistName );
                            });
                        }

                        initializeAddonifyWishlist.removeWishlistSidebarTableProductRow(data.productID);
                    }

                    if (data.hasOwnProperty('itemsCount')){
                        initializeAddonifyWishlist.updateWishlistSidebarElements(data.itemsCount);
                        initializeAddonifyWishlist.updateWishlistTableElements(data.itemsCount);
                    }

                    if(data.hasOwnProperty('productName')){
                        initializeAddonifyWishlist.renderUndoNotice(true, data.productName);
                    }
                });
            },
            updateWishlistButtons: function(buttonElement, buttonStatus, wishlistId = '', wishlistName = ''){

                if (buttonStatus === 'added-to-wishlist' || buttonStatus === 'already-in-wishlist'){
                    if (!buttonElement.hasClass('added-to-wishlist')) {
                        buttonElement.addClass('added-to-wishlist');
                    }
                    // Update button label and icon of custom add to wishlist button.
                    if (!buttonElement.hasClass('addonify-custom-wishlist-btn') && buttonElement.hasClass('addonify-add-to-wishlist-btn')) {
                        // Update button icon.
                        buttonElement.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');

                        // Update button label.
                        if (buttonElement.hasClass('addonify-wishlist-save-for-later')) {
                            // If button is save for later button.
                            buttonElement.find('span.addonify-wishlist-btn-label').text(settings.savedForLaterButtonLabel);
                        } else {
                            if (buttonStatus === 'added-to-wishlist') {
                                let addedToWishlistButtonLabel = settings.addedToWishlistButtonLabel;
                                if (addedToWishlistButtonLabel.includes('{wishlist_name}')) {
                                    addedToWishlistButtonLabel = addedToWishlistButtonLabel.replace('{wishlist_name}', wishlistName);
                                }
                                buttonElement.find('span.addonify-wishlist-btn-label').text(addedToWishlistButtonLabel);
                            } else {
                                let alreadyInWishlistButtonLabel = settings.alreadyInWishlistButtonLabel;
                                if (alreadyInWishlistButtonLabel.includes('{wishlist_name}')) {
                                    alreadyInWishlistButtonLabel = alreadyInWishlistButtonLabel.replace('{wishlist_name}', wishlistName);
                                }
                                buttonElement.find('span.addonify-wishlist-btn-label').text(alreadyInWishlistButtonLabel);
                            }
                        }
                    }

                    if (wishlistId !== ''){
                        buttonElement.attr('data-wishlist_id', wishlistId);
                    }

                    if (wishlistName !== '') {
                        buttonElement.attr('data-wishlist_name', wishlistName);
                    }
                }

                if(buttonStatus === 'removed-from-wishlist'){
                    if (buttonElement.hasClass('added-to-wishlist')) {
                        buttonElement.removeClass('added-to-wishlist');
                    }
                    // Update button label and icon of custom add to wishlist button.
                    if (!buttonElement.hasClass('addonify-custom-wishlist-btn') && buttonElement.hasClass('addonify-add-to-wishlist-btn')) {
                        // Update button icon.
                        buttonElement.find('i.icon.adfy-wishlist-icon').addClass('heart-o-style-one').removeClass('heart-style-one');

                        // Update button label.
                        if (buttonElement.hasClass('addonify-wishlist-save-for-later')) {
                            // If button is save for later button.
                            buttonElement.find('span.addonify-wishlist-btn-label').text(settings.saveForLaterButtonLabel);
                        } else {
                            // If button is not save for later button.
                            buttonElement.find('span.addonify-wishlist-btn-label').text(settings.initialAddToWishlistButtonLabel);
                        }
                    }

                    let buttonWishlistIdAttr = buttonElement.attr('data-wishlist_id');

                    if (typeof buttonWishlistIdAttr !== 'undefined' && buttonWishlistIdAttr !== false) {
                        buttonElement.removeAttr('data-wishlist_id');
                    }

                    let buttonWishlistNameAttr = buttonElement.attr('data-wishlist_name');

                    if (typeof buttonWishlistNameAttr !== 'undefined' && buttonWishlistNameAttr !== false) {
                        buttonElement.removeAttr('data-wishlist_name');
                    }
                }
            },
            addWishlistSidebarProductRow: function(newSidebarProductRow){
                let wishlistSidebarListEle = $('#addonify-wishlist-sidebar-ul');
                if (wishlistSidebarListEle.length > 0) {
                    wishlistSidebarListEle.prepend(newSidebarProductRow);
                }
            },
            addWishlistTableProductRow: function(newTableProductRow){
                let wishlistTableBodyEle = $('#adfy-wishlist-table-body');
                if (wishlistTableBodyEle.length > 0) {
                    wishlistTableBodyEle.prepend(newTableProductRow);
                }
            },
            removeWishlistSidebarTableProductRow: function(productId){
                
                let removedProductRow = '';
                if ($('#addonify-wishlist-sticky-sidebar-container').length > 0) {
                    removedProductRow = $('#adfy-wishlist-sidebar-product-row-' + productId);
                }

                if ($('#addonify-wishlist-table').length > 0) {
                    removedProductRow = $('#adfy-wishlist-table-product-row-' + productId);
                }

                if (removedProductRow.length > 0) {
                    removedProductRow.remove();
                }
            },
            updateWishlistSidebarElements: function(itemsCount){

                if ($('#addonify-wishlist-sticky-sidebar-container').length > 0) {

                    let sidebarToggleButton = $('#addonify-wishlist-show-sidebar-btn');
                    if (sidebarToggleButton.length > 0) {
                        // Toggles the wishlist sidebar toggle button.
                        if (itemsCount > 0) {
                            sidebarToggleButton.removeClass('hidden');
                        } else {
                            sidebarToggleButton.addClass('hidden');
                        }
                    }

                    let sidebarEmptyWishlistParagraphEle = $('#adfy-wishlist-empty-sidebar-para');
                    if (sidebarEmptyWishlistParagraphEle.length > 0) {
                        if (itemsCount > 0) {
                            sidebarEmptyWishlistParagraphEle.removeClass('adfy-wishlist-show').addClass('adfy-wishlist-hide');
                        } else {
                            sidebarEmptyWishlistParagraphEle.removeClass('adfy-wishlist-hide').addClass('adfy-wishlist-show');
                        }
                    }
                }
            },
            updateWishlistTableElements: function(itemsCount){

                if ($('#addonify-wishlist-page-container').length > 0) {
                    let wishlistTableFormEle = $('#addonify-wishlist-page-form');
                    let wishlistEmptyParaEle = $('#addonify-empty-wishlist-para');

                    if (itemsCount > 0) {
                        wishlistTableFormEle.addClass('adfy-wishlist-show').removeClass('adfy-wishlist-hide');
                        wishlistEmptyParaEle.addClass('adfy-wishlist-hide').removeClass('adfy-wishlist-show');
                    } else {
                        wishlistTableFormEle.addClass('adfy-wishlist-hide').removeClass('adfy-wishlist-show');
                        wishlistEmptyParaEle.addClass('adfy-wishlist-show').removeClass('adfy-wishlist-hide');
                    }
                }
            },
            undoEvent: function(){
                // Event handler for setting timeout for undo notice.
                $(document).on('addonify_wishlist_undo_notice_set', function (data) {
                    clearTimeout(undoTimeout);
                    if (parseInt(settings.undoNoticeTimeout) > 0) {
                        undoTimeout = setTimeout(
                            function () {
                                $('#addonify-wishlist-notice').html('');
                            },
                            parseInt(settings.undoNoticeTimeout) * 1000
                        );
                    }
                });
            },
            displayLoader: function(){
                if ($('#addonify-wishlist-sticky-sidebar-container').length > 0) {
                    $('#addonify-wishlist-sticky-sidebar-container').append(settings.loader);
                }

                if ($('#addonify-wishlist-page-container').length > 0) {
                    $('#addonify-wishlist-page-container').append(settings.loader);
                }
            },
            hideLoader: function(){
                if ($('#addonify-wishlist_spinner')) {
                    $('#addonify-wishlist_spinner').remove();
                }
            },
            displayModalLoader: function(){
                if ($('.addonify-wishlist-modal-btns').length > 0) {
                    $('.addonify-wishlist-modal-btns').append(settings.loader);
                }
            },
            renderUndoNotice: function(setNotice = false, productName = ""){
                let undoNoticeContainerEle = $('#addonify-wishlist-notice');
                if (undoNoticeContainerEle.length > 0) {
                    if (setNotice) {
                        let undoNoticeTemplate = settings.productRemovalUndoNotice;
                        if (undoNoticeTemplate.includes('{product_name}') && productName !== '' && productName !== undefined) {
                            undoNoticeTemplate = undoNoticeTemplate.replace('{product_name}', productName);
                        }
                        undoNoticeContainerEle.html(undoNoticeTemplate);
                        $(document).trigger('addonify_wishlist_undo_notice_set');
                    } else {
                        undoNoticeContainerEle.html('');
                    }
                }
            }
        }

        return initializeAddonifyWishlist;
    };
}(jQuery));