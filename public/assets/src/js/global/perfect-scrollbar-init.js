'use strict';

const helpers = {

    /**
    *
    * Init perfect scrollbar.
    * 
    * @since 2.0.0
    */

    addonifyPerfectScrollBar: () => {

        const wishlistSidebarScrollableEle = document.getElementById('addonify-wishlist-sidebar-form');

        if (wishlistSidebarScrollableEle) {

            new PerfectScrollbar(wishlistSidebarScrollableEle, {

                wheelSpeed: 1,
                wheelPropagation: true,
                minScrollbarLength: 20
            });
        }
    }
}

/**
*
* DOMContentLoaded event.
* 
* @since 2.0.0
*/

document.addEventListener("DOMContentLoaded", helpers.addonifyPerfectScrollBar());
