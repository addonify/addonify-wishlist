(function( $ ) {
	'use strict';

	$( document ).ready(function(){

		var $body				= $( 'body' );
		var $modal 				= $( '#addonify-wishlist-modal-wrapper' );
		var $modal_response 	= $( '#addonify-wishlist-modal-response' );
		var $sticky_sidebar_btn = $( '#addonify-wishlist-show-sidebar-btn' );

		init();

		$body.on('click', '.addonify-add-to-wishlist-btn button', function(){

			if( $( this ).hasClass( 'added-to-wishlist' ) ){
				// item is already added to wishlist
				show_modal( addonify_wishlist_object.product_already_in_wishlist_text, $(this).data('product_name') );
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

			// mark modal as loading
			$modal.addClass('loading');
			show_modal( addonify_wishlist_object.product_added_to_wishlist_text, $(this_sel).data('product_name') );

			$.post( addonify_wishlist_object.ajax_url, data, function( response ) {
				$modal.removeClass('loading');

				if( response.success == true ){
					$(this_sel).addClass('added-to-wishlist');
				}

				$sticky_sidebar_btn.show();

				// update sidebar contents
				$('#addonify-wishlist-sidebar-items').append( response.data );
				

			}, "json" );
		}


		function show_modal( response_text, product_name ){
			$modal_response.html( response_text.replace('{product_name}', product_name ) );
			$body.addClass('addonify-wishlist-modal-is-open');
		}


		function hide_modal(){
			$body.removeClass('addonify-wishlist-modal-is-open');
		}


	})

})( jQuery );
