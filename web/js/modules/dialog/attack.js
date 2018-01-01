import Template from "./hbs/attack.hbs";
import MessageTemplate from "./hbs/error.hbs";
import "./less/attack.less";
import BaseDialog from "./base";

class AttackDialog extends BaseDialog {

    constructor(villageFromId, villageToId, units) {
        super();
        this.villageFromId = villageFromId;
        this.villageToId = villageToId;
        this.units = units
    }

    open(data) {
        super.open();

        if (Object.keys(this.units).length) {
            let renderData = {
                villageFromId: this.villageFromId,
                villageToId: this.villageToId,
                units: this.units
            };
            this.element.innerHTML = Template(renderData);
        } else {
            this.element.innerHTML = MessageTemplate({message: 'Нет доступных войск для атаки'});
        }
    }
}

export default AttackDialog;