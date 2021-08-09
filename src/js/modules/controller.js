import $fn from "../utilities/$fn";

const $ = jQuery;

export default function() {
    $.fn.controller = new $fn('controller', {

        init() {
            const $this = $(this);

            $this.controller('loadScripts');
        },

        /**
         * Pass script name to load a particular script
         * @param name
         */
        loadScripts(name = '') {
            const $this = name ? $(this).find(`[data-script="${name}"`) : $(this).find('[data-src]');

            /**
             * Load the scripts
             */
            $this.each(function(){
                const $script = $(this);

                $script
                    .attr('src', $script.attr('data-src'))
                    .removeAttr('data-src');
            });
        }

    });
};

