import loadScripts from "../utilities/loadScripts";
import {aload} from "../utilities/aload";
import firstInteraction from "../utilities/firstInteraction";

export default function onReady() {
    const $ = jQuery;

    aload();
    $(document).on('firstInteraction', () => {
        aload(null, true)
    });

    firstInteraction();

    loadScripts();

}
