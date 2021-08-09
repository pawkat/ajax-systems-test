const $ = jQuery;

export function getScrolledBottomCorner() {
    return getScrollTop() + window.innerHeight;
    // return (window.pageYOffset || document.documentElement.scrollTop) + window.innerHeight;
}

export function getScrollTop() {
    return $(window).scrollTop();
}

export function getElScrollTop(el) {
    return el.getBoundingClientRect().y + document.querySelector('html').scrollTop;
}

export function getOffset(element) {
    if (element) {
        const box = element.getBoundingClientRect();
        return box.top + getScrollTop();
    } else {
        const nodeRect = this.getBoundingClientRect();
        const bodyRect = document.body.getBoundingClientRect();

        return nodeRect.top - bodyRect.top;
    }
}

export function debounce(func, wait, immediate) {
    let timeout;
    return function () {
        let context = this, args = arguments;
        let later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        let callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

/**
 * @param element
 * @returns {*}
 */
export function getBottomBorder(element) {
    return getOffset(element) + $(element).height();
}
