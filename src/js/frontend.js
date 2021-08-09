'use strict';

import onReady from "./hooks/onReady";

import controller from "./modules/controller";

!(function ($) {

    controller();

    $(document)
        .on('ready', onReady.bind(this));

})(jQuery);
