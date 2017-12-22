import Template from "./hbs/error.hbs";
import BaseDialog from "./base";

class BuildDialog extends BaseDialog {

    open(data) {
        super.open();
        dialogWrapper.innerHTML = Template(data);
    }
}

export default BuildDialog;