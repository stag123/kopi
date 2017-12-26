import "./less/base.less";
import DOM from "../dom";


let dialogWrapper = document.createElement('div');
dialogWrapper.setAttribute('class', 'dialog-wrapper');
document.body.appendChild(dialogWrapper);


class BaseDialog {

    constructor() {
        this.element = dialogWrapper;

        DOM.on(this.element, "click", (e, target) => {
            if (DOM.hasClass(e.target, "open")) {
                this.close();
            }
        });
    }

    open(data) {
        DOM.addClass(this.element, "open");
    }

    close () {
        DOM.removeClass(this.element, "open");
    }
}

export default BaseDialog;