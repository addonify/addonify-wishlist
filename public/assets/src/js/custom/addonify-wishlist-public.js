(function ($) {

    'use strict';

    $(document).ready(function () {

        let $body = $('body');
        let $modal = $('#addonify-wishlist-modal-wrapper');
        let $modal_response = $('#addonify-wishlist-modal-response');
        let $sidebar_ul = $('ul.adfy-wishlist-sidebar-items-entry');
        let plugin_name = 'addonify-wishlist';
        let localDataExpiration = 30;   // local data expiration in days.
        let isLoggedIn = addonifyWishlistJSObject.isLoggedIn;
        $('.addonify-add-to-wishlist-btn button.added-to-wishlist').attr('disabled', true);

        if ( ! isLoggedIn ) {
            guest_init();
        }

        // Display popup modal if login is required.
        $body.on('click', '.addonify-wishlist-login-popup-enabled', function (e) {
            e.preventDefault();
            addonifyShowPopupModal(addonifyWishlistJSObject.loginMessage, '', 'error');
        });

        /**
         * Check if product is already in the cart.
         * If not call ajax function to add the product into the cart.
         */
        $body.on('click', '.addonify-wishlist-ajax-add-to-wishlist', function (e) {
            e.preventDefault();
            let addToWishlistButton = $(this);
            if (addToWishlistButton.hasClass('added-to-wishlist')) {
                addonifyShowPopupModal(
                    addonifyWishlistJSObject.popupAlreadyInWishlistText,
                    addToWishlistButton.data('product_name')
                );
            } else {
                if ( isLoggedIn ) {
                    addonifyAddToWishlist(addToWishlistButton);
                } else {
                    addonifyLocalAddToWishlist(addToWishlistButton);
                }
            }
        })

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

        // Ajax call to add product into cart.
        $body.on('click', '.addonify-wishlist-ajax-add-to-cart', function (event) {

            event.preventDefault();

            let thisButton = $(this);

            let ajaxData = {
                action: 'addonify_add_to_cart_from_wishlist',
                productId: thisButton.val(),
                nonce: addonifyWishlistJSObject.nonce
            }

            let parentProductRow = '';

            if (thisButton.hasClass('addonify-wishlist-sidebar-button')) {
                parentProductRow = $('#addonify-wishlist-sticky-sidebar-container').find('li[data-product_row="addonify-wishlist-sidebar-product-row-' + thisButton.val() + '"]');
            }

            if (thisButton.hasClass('addonify-wishlist-table-button')) {
                parentProductRow = $('#addonify-wishlist-table').find('tr[data-product_row="addonify-wishlist-table-product-row-' + thisButton.val() + '"]');
            }

            if (parentProductRow) {
                parentProductRow.addClass('loading');
            }

            $.post(
                addonifyWishlistJSObject.ajax_url,
                ajaxData,
                function (response) {
                    if (response.success) {
                        
                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_added_to_wishlist', [{ productID: thisButton.data('product_id') }]);

                        if (addonifyWishlistJSObject.removeFromWishlistAfterAddedToCart == '1' && parentProductRow) {

                            parentProductRow.remove();

                            addonifyInitialWishlistButton(thisButton.val());

                            addonifyEmptyWishlistText(response.wishlist_count);

                            addonifyWishlistEmptyWishlist(response.message);
                        }
                    }
                },
                "json"
            );

            if (parentProductRow) {
                parentProductRow.addClass('loading');
            }
        });

        // Ajax call to remove product from wishlist.
        $body.on('click', '.addonify-wishlist-ajax-remove-from-wishlist', function (event) {

            event.preventDefault();

            let thisButton = $(this);

            let ajaxData = {
                action: 'addonify_remove_from_wishlist',
                productId: thisButton.val(),
                nonce: addonifyWishlistJSObject.nonce
            }

            let parentProductRow = '';

            if (thisButton.hasClass('addonify-wishlist-sidebar-button')) {
                parentProductRow = $('#addonify-wishlist-sticky-sidebar-container').find('li[data-product_row="addonify-wishlist-sidebar-product-row-' + thisButton.val() + '"]');
            }

            if (thisButton.hasClass('addonify-wishlist-table-button')) {
                parentProductRow = $('#addonify-wishlist-table').find('tr[data-product_row="addonify-wishlist-table-product-row-' + thisButton.val() + '"]');
            }

            if (parentProductRow) {
                parentProductRow.addClass('loading');
            }

            $.post(
                addonifyWishlistJSObject.ajax_url,
                ajaxData,
                function (response) {

                    if (response.success) {

                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_removed_from_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_removed_from_wishlist', [{ productID: thisButton.val() }]);

                        parentProductRow.remove();

                        if(response.wishlist_count <= 0) {
                            $('#addonify-wishlist-show-sidebar-btn').addClass('hidden');
                        }

                        addonifyInitialWishlistButton(thisButton.val());

                        addonifyEmptyWishlistText(response.wishlist_count);

                        addonifyWishlistEmptyWishlist(response.message);
                    }
                },
                "json"
            );

            if (parentProductRow) {
                parentProductRow.addClass('loading');
            }
        });

        function guest_init() {
            let wishlist_products = getProductids();
            let addedToWishlistButtonLabel = addonifyWishlistJSObject.addedToWishlistButtonLabel;

            wishlist_products.forEach( function (value, index) {
                $('button[data-product_id="' + value + '"]').find('span').html( addedToWishlistButtonLabel );
                $('button[data-product_id="' + value + '"]').find('i').addClass('heart-style-one').removeClass('heart-o-style-one');
            });
        }

        // Ajax call to add product into the wishlist.
        function addonifyAddToWishlist(addToWishlistButton) {

            let data = {
                action: addonifyWishlistJSObject.addToWishlistAction,
                id: addToWishlistButton.data('product_id'),
                nonce: addonifyWishlistJSObject.nonce
            };

            // mark modal as loading
            $modal.addClass('loading');

            $.post(
                addonifyWishlistJSObject.ajax_url,
                data,
                function (response) {

                    $modal.removeClass('loading');

                    if (response.success == true) {

                        // Triggering custom event when product is added to wishlist. 
                        // 'addonify_added_to_wishlist' custom event can be used to perform desired actions.
                        $(document).trigger('addonify_added_to_wishlist', [{ productID: addToWishlistButton.data('product_id') }]);

                        addonifyEmptyWishlistText(response.wishlist_count);

                        // update button 
                        addToWishlistButton.addClass('added-to-wishlist');

                        addonifyShowPopupModal(
                            response.message,
                            addToWishlistButton.data('product_name'),
                            'success'
                        );

                        if(response.wishlist_count > 0) {
                            $('#addonify-wishlist-show-sidebar-btn').removeClass('hidden');
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
            );
        }

        /**
         * Add product to local wishlist.
         *
         * @param {object} addToWishlistButton Button Object.
         */
        function addonifyLocalAddToWishlist(addToWishlistButton) {
            let id = addToWishlistButton.data('product_id');

            let wishlist = getProductids();

            if ( wishlist.indexOf(id) === -1 ) {
                wishlist.push(id);

                setProductids(wishlist);
    
                console.log('Added to wishlist.');

                // update button 
                addToWishlistButton.addClass('added-to-wishlist');

                addonifyShowPopupModal(
                    addonifyWishlistJSObject.popupAddedToWishlistText,
                    addToWishlistButton.data('product_name'),
                    'success'
                );

                // Update button label and icon of custom add to wishlist button.
                if (!addToWishlistButton.hasClass('addonify-custom-wishlist-btn')) {
                    // Update button label.
                    addToWishlistButton.find('span.addonify-wishlist-btn-label').text(addonifyWishlistJSObject.addedToWishlistText);
                    // Update button icon.
                    addToWishlistButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-o-style-one').addClass('heart-style-one');
                }
            } else {
                console.log('Item already in wishlist.');
            }

        }

        // Show popup modal with message.
        function addonifyShowPopupModal(response_text, product_name, icon) {

            // change icon
            $('.adfy-wishlist-icon-entry .adfy-wishlist-icon').hide();
            $('.adfy-wishlist-icon-entry .adfy-wishlist-icon.adfy-status-' + icon).show();
            $modal_response.html("<p class='response-text'>" + response_text.replace('{product_name}', product_name) + "</p>");
            $body.addClass('addonify-wishlist-modal-is-open');
        }


        // Display sidebar notifications.
        function addonifyWishlistEmptyWishlist(message) {

            let notice = $('#addonify-wishlist-sticky-sidebar-container .addonify-wishlist-ssc-footer');

            if (notice) {

                notice.prepend('<div class="notice adfy-wishlist-sidebar-notice"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" /></svg><span>' + message + '</span></div> ');

                // delete notification after 5 seconds
                setTimeout(function () {

                    notice.find('.notice').fadeOut('fast', function () {

                        $(this).remove();
                    })
                }, 5000); // 5000
            }
        }


        // Display empty wishlist text.
        function addonifyEmptyWishlistText(wishlistCount) {

            if (wishlistCount > 0 && $('#addonify-empty-wishlist-para')) {
                $('#addonify-empty-wishlist-para').remove();
            } else {

                if ($sidebar_ul) {
                    $sidebar_ul.html('<p id="addonify-empty-wishlist-para">' + addonifyWishlistJSObject.emptyWishlistText + '</p>');
                }

                if ($('#addonify-wishlist-page-container')) {
                    $('#addonify-wishlist-page-container').html('<p id="addonify-empty-wishlist-para">' + addonifyWishlistJSObject.emptyWishlistText + '</p>');
                }
            }
        }


        // Display intial state wishlist button label and icon.
        function addonifyInitialWishlistButton(productId) {

            let wishlistButton = $('[data-product_id="' + productId + '"].addonify-add-to-wishlist-btn');

            // Update button label and icon of custom add to wishlist button.
            if (wishlistButton && !wishlistButton.hasClass('addonify-custom-wishlist-btn')) {
                wishlistButton.removeClass('added-to-wishlist');
                // Update button label.
                wishlistButton.find('span.addonify-wishlist-btn-label').text(addonifyWishlistJSObject.initialAddToWishlistButtonLabel);
                // Update button icon.
                wishlistButton.find('i.icon.adfy-wishlist-icon').removeClass('heart-style-one').addClass('heart-o-style-one');
            }

            if ( $('.woocommerce-notices-wrapper') ) {
                $('.woocommerce-notices-wrapper').remove();
            }
        }

		/**
		 * Return product ids stored in localstorage.
		 * 
		 * @returns {array|false} product ids.
		 */
		function getProductids() {
			return getLocalItem( 'product_ids' );
		}

		/**
		 * Save product ids in localstorage.
		 *
		 * @param {Object|string} val Value to be inserted.
		 */
		function setProductids( val ) {
			setLocalItem( 'product_ids', val );
		}

        /**
		 * Store item in localstorage.
		 * 
		 * @param {int} productId Product ID.
		 * @param {mixed} val Value to be stored in localstorage.
		 */
		function setLocalItem( name, val ) {
			if ( typeof val === 'object' ) {
				val = JSON.stringify( val )
			}
			const d = new Date();
			d.setTime( d.getTime() + (localDataExpiration * 24 * 60 * 60 * 1000) );
			let expires = d.getTime();
			localStorage.setItem( plugin_name + '_' + name, val )
			localStorage.setItem( plugin_name + '_' + name +  '_deadline', expires )
		}

		/**
		 * Parse string to json.
		 *
		 * @param {string} json_str Json string.
		 * @return {object|false} Json object
		 */
		function parseJson( json_str ) {
			let json_val
			try {
				json_val = JSON.parse(json_str)
			} catch(e) {
				return false;
			}
			return json_val
		}

		/**
		 * Get item from localstorage.
		 *
		 * @param {int} productId Product Id.
		 * @returns {array|false}
		 */
		function getLocalItem( name ) {
			let localDeadline = localStorage.getItem( plugin_name + '_' + name +  '_deadline' )
			if ( null !== localDeadline ) {
				const d = new Date();
				if ( d.getTime() < parseInt( localDeadline ) ) {
					return jsonToArray( parseJson( localStorage.getItem( plugin_name + '_' + name ) ) )
				} else {
					localStorage.removeItem( plugin_name + '_' + name )
					localStorage.removeItem( plugin_name + '_' + name + '_deadline' );
				}
			}
			return [];
		}

		/**
		 * Converts json to Array
		 * 
		 * @param {object} json Json object
		 * @returns {object|false} An array
		 */
		function jsonToArray(json){
			if ( json !== null && typeof json === 'object' ) {
				let result = new Array;
				let keys = Object.keys(json);
				if (keys.length > 0) {
					keys.forEach(function(key){
						result[key]= json[key];
					});
				}
				return result;
			} else {
				return false;
			}
		}


    });

})(jQuery);