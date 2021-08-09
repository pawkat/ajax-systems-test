import DeferJS from "./DeferJS";

const {theme_version} = window.ajax_systems;

export default function () {
    let scriptsToLoad = [

    ];

    if (typeof window.scripts_to_enqueue !== 'undefined' && window.scripts_to_enqueue) {
        const {scripts_to_enqueue} = window;
        for (const [key, data] of Object.entries(scripts_to_enqueue)) {
            if (data) {
                let formattedData = {
                    src: data.src,
                    el: data.elSelector ? document.querySelector(data.elSelector) : document.body,
                    insertInto: data.insertInto && data.insertInto === 'document.head' ? document.head : document.body,
                    dependencies: data.dependencies ? data.dependencies : [],
                };
                if (data.hasOwnProperty('loadImmediatelyIfVisible')) {
                    formattedData.loadImmediatelyIfVisible = data.loadImmediatelyIfVisible;
                }
                if (data.hasOwnProperty('handle')) {
                    formattedData.handle = data.handle;
                }
                if (data.hasOwnProperty('atts')) {
                    formattedData.atts = data.atts;
                }
                if (data.hasOwnProperty('timeout')) {
                    formattedData.timeout = data.timeout;
                }
                scriptsToLoad.push(formattedData);
            }
        }
    }

    scriptsToLoad.forEach((el) => {
        new DeferJS(el);
    });
}
