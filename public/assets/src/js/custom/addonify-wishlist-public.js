(function( $ ) {
	'use strict';

	$( document ).ready(function(){

		var $body				= $( 'body' );
		var $modal 				= $( '#addonify-wishlist-modal-wrapper' );
		var $modal_response 	= $( '#addonify-wishlist-modal-response' );
		var $sticky_sidebar_btn = $( '#addonify-wishlist-show-sidebar-btn' );
		var $sidebar_ul			= $( '#addonify-wishlist-sidebar-items' );
		var show_popup			= addonify_wishlist_object.show_popup;

		init();

		$body.on('click', '.addonify-add-to-wishlist-btn button', function( e ){

			e.preventDefault();

			if( $( this ).hasClass( 'added-to-wishlist' ) ){
				// item is already added to wishlist

				if( show_popup ){
					show_modal( addonify_wishlist_object.product_already_in_wishlist_text, $(this).data('product_name') );
				}
				
			}
			else{
				add_to_wishlist( this );
			}
		})

		// close viewlist modal
		$body.on('click', '#addonify-wishlist-close-modal-btn', function(){
			hide_modal();
		})


		// click in "view wishlist" button in modal
		$body.on('click', '#addonify-wishlist-view-wishlist-btn', function(){
			window.location.href = addonify_wishlist_object.wishlist_page_url;
		})
		

		// show hide sticky sidebar
		$sticky_sidebar_btn.click( function(){
			$body.toggleClass('addonify-wishlist-sticky-sidebar-is-visible');
		} )


		// wishlist page form elements --------------------------------------

		// select all checkbox
		$body.on('click', 'input.addonify-wishlist-check-all', function(){
			$('input.addonify-wishlist-product-id').prop('checked', $(this).prop( "checked" ) );
		});

		$body.on('click', '.addonify-wishlist-remove-notification', function(){
			var $parent = $(this).parents('.addonify-wishlist-notification');
			$parent.remove();
		});

		// end wishlist page form elements --------------------------------------


		function init(){
			prepare_overlay_buttons();

			$( '.addonify-add-to-wishlist-btn button.added-to-wishlist' ).attr('disabled', true );
		}



		// "add to wish" button in image overlay mode
		function prepare_overlay_buttons(){

			var overlay_btn_wrapper_class = 'addonify-overlay-btn-wrapper';
			var overlay_btn_class = 'addonify-overlay-btn';

			var $overlay_btn_wrapper_sel = $('.' + overlay_btn_wrapper_class);
			var $overlay_parent_container = $('.addonify-overlay-buttons');

			if( $overlay_btn_wrapper_sel.length ){

				//  wrapper div already exists
				$overlay_parent_container.each(function(){

					// clone original button
					var btn_clone = $('button.' + overlay_btn_class, this).clone();

					// delete original buttons
					$('button.' + overlay_btn_class, this).remove();
					
					// append to wrapper class
					$('.' + overlay_btn_wrapper_class, this).append( btn_clone );
				})
			}
			else{
				// wrap all buttons into a single div
				$overlay_parent_container.each(function(){
					$('button.' + overlay_btn_class, this).wrapAll('<div class=" '+ overlay_btn_wrapper_class + ' " />');
				});

				var img_height = $('img.attachment-woocommerce_thumbnail').height();

				// set height of the button wrapper div
				$('.' + overlay_btn_wrapper_class).css('height', img_height + 'px');


				$('.' + overlay_btn_wrapper_class).hover(function(){
					$(this).css('opacity', 1);
				}, function(){
					$(this).css('opacity', 0);
				})
			}


		}


		function add_to_wishlist( this_sel ){

			var data = {
				action	: addonify_wishlist_object.action,
				id		: $(this_sel).data('product_id'),
				nonce	: addonify_wishlist_object.nonce
			};

			// check if login is required
			if( is_login_required() ) return;


			// mark modal as loading
			$modal.addClass('loading');


			if( show_popup ){
				show_modal( addonify_wishlist_object.product_added_to_wishlist_text, $(this_sel).data('product_name') );
			}
			else{
				$(this_sel).text( addonify_wishlist_object.product_adding_to_wishlist_btn_label ).attr('disabled', true );
			}


			$.post( addonify_wishlist_object.ajax_url, data, function( response ) {
				$modal.removeClass('loading');

				if( response.success == true ){
					// remove "your wishlist is empty" message
					$('#addonify-wishlist-sidebar-form .empty-wishlist').remove();
					
					// update button 
					$(this_sel).addClass('added-to-wishlist addonify_icon-heart').text( addonify_wishlist_object.product_added_to_wishlist_btn_label );
					
					// update sidebar contents
					$sidebar_ul.append( response.data.msg );
					
					// update sidebar toggle button
					$sticky_sidebar_btn.removeClass('hidden').find('.addonify-wishlist-count').text( response.data.wishlist_count );

				}

			}, "json" );
		}


		function show_modal( response_text, product_name ){
			$modal_response.html( response_text.replace('{product_name}', product_name ) );
			$body.addClass('addonify-wishlist-modal-is-open');
		}


		function hide_modal(){
			$body.removeClass('addonify-wishlist-modal-is-open');
		}


		function is_login_required(){
			if( ! addonify_wishlist_object.require_login || addonify_wishlist_object.is_logged_in ) return false;

			if( addonify_wishlist_object.redirect_to_login && ! addonify_wishlist_object.is_logged_in ) {
				window.location.replace( addonify_wishlist_object.login_url );
				return true;
			}

			show_modal( addonify_wishlist_object.login_msg, '' );

			return true;
		}

		
		// make sidebar form ajaxy
		$body.on( 'click', '#addonify-wishlist-sidebar-form button', function(e){
			e.preventDefault();

			var $parent = $(this).parents('li');
			var $notice = $('#addonify-wishlist-sticky-sidebar-container .addonify-wishlist-ssc-footer');

			// mark as loading
			$parent.addClass('loading');

			var button = $(this);
			var data = $('#addonify-wishlist-sidebar-form').serialize() 
				+ '&' 
				+ encodeURI(button.attr('name'))
				+ '='
				+ encodeURI(button.attr('value'))
				+'&action=' + encodeURI(addonify_wishlist_object.action_sidebar_form);
			;

			$.post( addonify_wishlist_object.ajax_url, data, function( response ) {
				
				$parent.removeClass('loading');

				var msg = '';
				if( response.success == true ){

					msg = response.data.msg;

					// remove 'li'
					$parent.remove();

					// remove item from wishlist
					if( response.data.remove_wishlist ){
						
						// update "add to wishlist" button classes
						$( 'button.added-to-wishlist[data-product_id="'+ button.attr('value') +'"]' ).removeClass( 'added-to-wishlist addonify_icon-heart' );
						$sticky_sidebar_btn.find('.addonify-wishlist-count').text( response.data.wishlist_count );
					}

					if( response.data.wishlist_count < 1 ){
						$('#addonify-wishlist-sidebar-form').append( '<p class="empty-wishlist">' + addonify_wishlist_object.wishlist_empty_label + '</p>');
					}

				}
				else{
					msg = response.data;
				}

				// show notification
				$notice.prepend('<div class="notice">'+ msg +'</div>');

			}, "json" );


			// delete noticication after 5 seconds
			setTimeout(function(){
				$notice.find('.notice').fadeOut( 'fast', function(){
					$(this).remove();
				})
			}, 5000);
		})


	})

})( jQuery );
