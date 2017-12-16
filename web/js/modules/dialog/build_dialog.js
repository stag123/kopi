import Template from "./hbs/build_dialog.hbs";
import "./less/build_dialog.less";
import Net from "../net";
import DOM from "../dom";


let dialogWrapper = document.createElement('div');
dialogWrapper.setAttribute('class', 'dialog-wrapper');
document.body.appendChild(dialogWrapper);


class BuildDialog {

    constructor(mapId) {
        let request = Net.ajax("GET", "/village/build-list", {mapId: mapId});
        request.then(this.open.bind(this), ()=> {console.log('errpr')});
    }

    open(data) {
        DOM.addClass(dialogWrapper, "open");
        dialogWrapper.innerHTML = Template(data);
        console.log(data);
    }

    close() {

    }
}

export default BuildDialog;