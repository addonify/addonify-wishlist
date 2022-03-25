'use strict';

function AddonifyPerfectScrollBar(addonifyScrollbarEle) {

    new PerfectScrollbar(addonifyScrollbarEle, {

        wheelSpeed: 1,
        wheelPropagation: true,
        minScrollbarLength: 20
    });
}

document.addEventListener("DOMContentLoaded", function () {

    var addonifyScrollbarEle = document.getElementById('addonify-wishlist-sidebar-form');

    if ((addonifyScrollbarEle !== null) && (addonifyScrollbarEle !== undefined)) {

        AddonifyPerfectScrollBar(addonifyScrollbarEle);
    }

});
