export default function () {
    const events = [
        {
            name: 'scroll',
            target: document
        },
        {
            name: 'mousemove',
            target: document
        },
        {
            name: 'touchstart',
            target: document
        },
        {
            name: 'click',
            target: document
        },
        {
            name: 'resize',
            target: window
        },
        {
            name: 'keydown',
            target: document
        }
    ];

    const firstInteraction = function () {
        jQuery(document).trigger('firstInteraction');
        events.forEach((event) => {
            event.target.removeEventListener(event.name, firstInteraction, false);
        });
    }

    events.forEach((event) => {
        event.target.addEventListener(event.name, firstInteraction, false);
    });
};
