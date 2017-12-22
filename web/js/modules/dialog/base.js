import "./less/base.less";
import DOM from "../dom";


let dialogWrapper = document.createElement('div');
dialogWrapper.setAttribute('class', 'dialog-wrapper');
document.body.appendChild(dialogWrapper);

DOM.on(dialogWrapper, "click", (e, target) => {
    if (DOM.hasClass(e.target, "open")) {
        DOM.removeClass(e.currentTarget, "open");
    }
});


class BaseDialog {

    constructor() {
        this.element = dialogWrapper;
    }

    open(data) {
        DOM.addClass(this.element, "open");
    }
}

export default BaseDialog;