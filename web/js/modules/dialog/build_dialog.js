import Template from "./hbs/build_dialog.hbs";
import "./less/build_dialog.less";
import Net from "../net";
import DOM from "../dom";


let dialogWrapper = document.createElement('div');
dialogWrapper.setAttribute('class', 'dialog-wrapper');
document.body.appendChild(dialogWrapper);

DOM.on(dialogWrapper, "click", (e, target) => {
    if (DOM.hasClass(e.target, "open")) {
        DOM.removeClass(e.currentTarget, "open");
    }
});


class BuildDialog {

    constructor(mapId) {
        this.mapId = mapId;
        let request = Net.ajax("GET", "/village/build-list", {mapId: mapId});
        request.then(this.open.bind(this), ()=> {console.log('errpr')});
    }

    open(data) {
        DOM.addClass(dialogWrapper, "open");

        let renderData = {mapId: this.mapId, builds: data};
        dialogWrapper.innerHTML = Template(renderData);
    }

    close() {

    }
}

export default BuildDialog;