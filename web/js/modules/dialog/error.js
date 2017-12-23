import Template from "./hbs/error.hbs";
import BaseDialog from "./base";

class ErrorDialog extends BaseDialog {

    open(message) {
        super.open();
        dialogWrapper.innerHTML = Template({message: message});
    }
}

export default ErrorDialog;