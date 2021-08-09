class $fn {
    constructor(name, methods = {}) {
        const $ = jQuery;

        if ($.fn[name]) {

            try {
                return $(this)
            } catch (e) {
                return () => false;
            }
        } else {
            return function (method) {

                try {
                    if (methods[method]) {
                        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));

                    } else if (typeof method === 'object' || !method) {
                        return methods.init.apply(this, arguments);

                    } else if (method === 'debug') {
                        return $fn.debug.apply(this, arguments);
                    } else {
                        console.warn('Method named ' + method + ` isn't exist within jQuery.${name}`);

                        return $(this);
                    }
                } catch (e) {
                    const location = method ? `jQuery.fn.${name}('${method}')` : `jQuery.fn.${name}()`;

                    console.warn('An error caused at', location, e);

                    return $(this);
                }
            };
        }
    }

    static debug(param = '') {
        return param;
    }
}

window.$fn = $fn;

export default $fn;
