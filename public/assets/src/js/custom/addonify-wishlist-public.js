(function( $ ) {
	'use strict';

	$( document ).ready(function(){

		var $body	= $( 'body' );

		var $product_added_to_wishlist_reponse;

		init();
		
		$body.on('click', '.addonify-add-to-wishlist-btn a', function(){

		})


		function init(){
			// create markups for "after add to wishlist" modal
			var template = '<div id="addonify-wishlist-modal-wrapper"><div class="addonify-wishlist-modal-body" >';
				template += '<div class="wishlist-response">{Item}'+ product_added_to_wishlist_reponse +'</div>';
				template += '<button type="button" class="addonify-wishlist-modal-btn addonify-view-wishlist-btn" >'+ addonify_wishlist_object.view_wishlist_btn_text +'</button>';
				template += '<button type="button" class="addonify-wishlist-modal-btn addonify-close-btn" >Close</button>';
				template += '</div></div>';
			$body.append( template );
		}

	})

})( jQuery );
