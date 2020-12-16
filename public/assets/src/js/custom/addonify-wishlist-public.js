(function( $ ) {
	'use strict';

	$( document ).ready(function() {

		var $body				= $( 'body' );
		var $modal 				= $( '#addonify-wishlist-modal-wrapper' );
		var $modal_response 	= $( '#addonify-wishlist-modal-response' );
		// var $modal_icon			= $( '.adfy-wishlist-icon-entry .adfy-wishlist-icon' );
		var $sticky_sidebar_btn = $( '#addonify-wishlist-show-sidebar-btn' );
		var $sidebar_ul			= $( 'ul.adfy-wishlist-sidebar-items-entry' );
		var $wishlist_count_sel	= $( '.addonify-wishlist-count' );
		var show_popup			= addonify_wishlist_object.show_popup;


		init();

		// main "add to wishlist" btn.
		$body.on('click', '.addonify-add-to-wishlist-btn button', function( e ) {

			e.preventDefault();

			if ( $( this ).hasClass( 'added-to-wishlist' ) ) {
				// item is already added to wishlist

				if ( show_popup ) {
					show_modal( addonify_wishlist_object.product_already_in_wishlist_text, $(this).data('product_name') );
				}
				
			}
			else {
				add_to_wishlist( this );
			}
		})

		// close viewlist modal
		$body.on('click', '#addonify-wishlist-close-modal-btn', function() {
			hide_modal();
		})


		// click in "view wishlist" button in modal
		$body.on('click', '#addonify-wishlist-view-wishlist-btn', function() {
			window.location.href = addonify_wishlist_object.wishlist_page_url;
		})
		

		// show hide sticky sidebar
		$sticky_sidebar_btn.click( function() {
			$body.toggleClass('addonify-wishlist-sticky-sidebar-is-visible');
		} )


		// wishlist page form elements --------------------------------------

		// select all checkbox
		$body.on('click', 'input.addonify-wishlist-check-all', function() {
			$('input.addonify-wishlist-product-id').prop('checked', $(this).prop( "checked" ) );
		});

		$body.on('click', '.addonify-wishlist-remove-notification', function() {
			var $parent = $(this).parents('.addonify-wishlist-notification');
			$parent.remove();
		});

		// end wishlist page form elements --------------------------------------


		function init() {
			prepare_overlay_buttons();

			$( '.addonify-add-to-wishlist-btn button.added-to-wishlist' ).attr('disabled', true );
		}



		// "add to wish" button in image overlay mode
		function prepare_overlay_buttons() {

			var overlay_btn_wrapper_class = 'addonify-overlay-btn-wrapper';
			var overlay_btn_class = 'addonify-overlay-btn';

			var $overlay_btn_wrapper_sel = $('.' + overlay_btn_wrapper_class);
			var $overlay_parent_container = $('.addonify-overlay-buttons');

			if ( $overlay_btn_wrapper_sel.length ) {

				//  wrapper div already exists
				$overlay_parent_container.each(function() {

					// clone original button
					var btn_clone = $('button.' + overlay_btn_class, this).clone();

					// delete original buttons
					$('button.' + overlay_btn_class, this).remove();
					
					// append to wrapper class
					$('.' + overlay_btn_wrapper_class, this).append( btn_clone );
				})
			}
			else {
				// wrap all buttons into a single div
				$overlay_parent_container.each(function() {
					$('button.' + overlay_btn_class, this).wrapAll('<div class=" '+ overlay_btn_wrapper_class + ' " />');
				});

				var img_height = $('img.attachment-woocommerce_thumbnail').height();

				// set height of the button wrapper div
				$('.' + overlay_btn_wrapper_class).css('height', img_height + 'px');


				$('.' + overlay_btn_wrapper_class).hover(function() {
					$(this).css('opacity', 1);
				}, function() {
					$(this).css('opacity', 0);
				})
			}


		}



		// does exactly what function name says.
		function add_to_wishlist( this_sel ) {

			var data = {
				action	: addonify_wishlist_object.action,
				id		: $(this_sel).data('product_id'),
				nonce	: addonify_wishlist_object.nonce
			};

			// check if login is required
			if ( is_login_required() ) return;

			if ( show_popup ) {
				
				// show product added text in advance
				show_modal( addonify_wishlist_object.product_added_to_wishlist_text, $(this_sel).data('product_name'), 'success' );
			}
			else {

				// update btn label
				$( '.addonify-wishlist-btn-label', this_sel ).text( addonify_wishlist_object.product_adding_to_wishlist_btn_label );

				// disable btn.
				$(this_sel).attr('disabled', true );
				
			}
			
			// mark modal as loading
			$modal.addClass('loading');

			$.post( addonify_wishlist_object.ajax_url, data, function( response ) {
				
				$modal.removeClass('loading');

				if ( response.success == true ) {

					// remove "your wishlist is empty" message
					$('#addonify-wishlist-sidebar-form .empty-wishlist').remove();

					// update button 
					$( this_sel ).addClass('added-to-wishlist');
					
					// update label
					$( '.addonify-wishlist-btn-label', this_sel ).text( addonify_wishlist_object.product_added_to_wishlist_btn_label );

					// update icon
					$( 'i.icon.heart-o-style-one', this_sel ).removeClass('heart-o-style-one').addClass( 'heart-style-one');

					// update sidebar contents
					$sidebar_ul.append( response.data.msg );

					// update wishlist_count button
					$wishlist_count_sel.text( response.data.wishlist_count );

				}
				else{
					show_modal( addonify_wishlist_object.wishlist_not_added_label, $(this_sel).data('product_name'), 'error' );
				}

			}, "json" );
		}


		function show_modal( response_text, product_name, icon ) {
			
			// change icon
			$( '.adfy-wishlist-icon-entry .adfy-wishlist-icon' ).hide();
			$( '.adfy-wishlist-icon-entry .adfy-wishlist-icon.adfy-status-' + icon ).show();

			$modal_response.html( response_text.replace('{product_name}', product_name ) );
			$body.addClass('addonify-wishlist-modal-is-open');
		}


		function hide_modal() {
			$body.removeClass('addonify-wishlist-modal-is-open');
		}


		function is_login_required() {

			// return false if,
			// login is not required or user already loggen in.
			if ( ! addonify_wishlist_object.require_login || addonify_wishlist_object.is_logged_in ) return false;

			// redirect to login, login is required, not logged in
			if ( addonify_wishlist_object.redirect_to_login && ! addonify_wishlist_object.is_logged_in ) {
				window.location.replace( addonify_wishlist_object.login_url );
				return true;
			}

			// show login modal, even if "Show successful popup notice" is disabled by user.
			show_modal( addonify_wishlist_object.login_msg, '', 'error' );

			return true;
		}

		
		// make sidebar form ajaxy
		// also, delete item from wishlist from sidebar

		$body.on( 'click', '#addonify-wishlist-sidebar-form button', function(e) {
			e.preventDefault();

			var $parent = $(this).parents('li');
			var $notice = $('#addonify-wishlist-sticky-sidebar-container .addonify-wishlist-ssc-footer');

			// mark as loading
			$parent.addClass('loading');

			var button = $(this);
			
			// get form item
			var data = $('#addonify-wishlist-sidebar-form').serialize() 
				+ '&' 
				+ encodeURI(button.attr('name'))
				+ '='
				+ encodeURI(button.attr('value'))
				+ '&action=' + encodeURI(addonify_wishlist_object.action_sidebar_form);


			$.post( addonify_wishlist_object.ajax_url, data, function( response ) {

				var msg = '';
				if ( response.success == true ) {

					msg = response.data.msg;

					// update wishlist count.
					$wishlist_count_sel.text( response.data.wishlist_count );

					// remove item from wishlist
					if ( response.data.remove_wishlist == 1 ) {

						// update "add to wishlist" button classes

						var $the_btn = $( 'button.added-to-wishlist[data-product_id="'+ button.attr('value') +'"]' );
						
						$the_btn.find( '.addonify-wishlist-btn-label' ).text( addonify_wishlist_object.add_to_wishlist_btn_text );
						$the_btn.find( 'i.icon.heart-style-one' ).removeClass('heart-style-one').addClass( 'heart-o-style-one');

						$the_btn.removeAttr('disabled').removeClass( 'added-to-wishlist' );
						$parent.remove();
					}

					if ( response.data.wishlist_count < 1 && ! $( '#addonify-wishlist-sidebar-form.empty-wishlist').length ) {
						$('#addonify-wishlist-sidebar-form').append( '<p class="empty-wishlist">' + addonify_wishlist_object.wishlist_empty_label + '</p>');
					}

				}
				else {
					msg = response.data;
				}

				$parent.removeClass('loading');

				// show notification
				$notice.prepend('<div class="notice adfy-wishlist-sidebar-notice"><span>'+ msg +'</span></div>');

				if ( response.data.redirect_url != undefined ) {
					setTimeout( function() {
						window.location.href = response.data.redirect_url;
					}, 2000 );
				}

			}, "json" );


			// delete noticication after 5 seconds
			setTimeout(function() {

				$notice.find('.notice').fadeOut( 'fast', function() {

					$(this).remove();
				})
			}, 5000);
		})

	})

})( jQuery );
