(function($) {
    "use strict";

    function initPs(selector) {
        var el = document.querySelector(selector);
        if (el) {
            new PerfectScrollbar(el, {
                useBothWheelAxes: true,
                suppressScrollX: true,
                suppressScrollY: false,
            });
        }
    }

    initPs('.header-dropdown-list');
    initPs('.notifications-menu');
    initPs('.message-menu-scroll');
 

    //P-scrolling
})(jQuery);