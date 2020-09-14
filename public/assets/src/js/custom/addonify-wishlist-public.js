(function( $ ) {
	'use strict';

	$( document ).ready(function(){

		var $body	= $( 'body' );
		var $modal, $modal_response;

		init();
		
		$body.on('click', '.addonify-add-to-wishlist-btn a', function(){
			if( $( this ).hasClass( 'added-to-wishlist' ) ){
				// item is already added to wishlist
				show_modal( addonify_wishlist_object.product_already_in_wishlist_text );
			}
			else{
				add_to_wishlist( this );
			}
		})


		function init(){
			// create markups for "after add to wishlist" modal
			var template = '<div id="addonify-wishlist-modal-wrapper"><div class="addonify-wishlist-modal-body" >';
				template += '<div id="addonify-wishlist-modal-response"></div><div class="addonify-wishlist-modal-btns">';
				template += '<button type="button" class="addonify-view-wishlist-btn" >'+ addonify_wishlist_object.view_wishlist_btn_text +'</button>';
				template += '<button type="button" class="addonify-close-btn" >Close</button>';
				template += '</div></div></div>';
			$body.append( template );

			$modal = $( '#addonify-wishlist-modal-wrapper' );
			$modal_response = $( '#addonify-wishlist-modal-response' );
		}

		function add_to_wishlist( this_sel ){

			var data = {
				action	: addonify_wishlist_object.action,
				id		: $(this_sel).data('product_id')
			};

			// mark modal as loading
			$modal.addClass('loading');
			show_modal( addonify_wishlist_object.product_added_to_wishlist_text );

			$.post( addonify_wishlist_object.ajax_url, data, function( reponse ) {
				$modal.removeClass('loading');
			}, "json" );
		}

		function show_modal( reponse ){
			$modal_response.html( reponse );
			$body.addClass('addonify-wishlist-modal-is-open');
		}


	})

})( jQuery );
