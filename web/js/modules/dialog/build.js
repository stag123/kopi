import Template from "./hbs/build.hbs";
import "./less/build.less";
import Net from "../net";
import BaseDialog from "./base";

class BuildDialog extends BaseDialog {

    constructor(mapId, buildCode, villageResource) {
        super();
        this.mapId = mapId;
        this.buildCode = buildCode;
        this.villageResource = villageResource;
        let request = Net.ajax("GET", "/village/build-list", {mapId: mapId});
        request.then(this.open.bind(this), ()=> {console.log('errpr')});
    }

    open(data) {
        super.open();

        if (data.length) {
            let renderData = {
                villageResource: this.villageResource,
                mapId: this.mapId,
                buildCode: this.buildCode,
                builds: data
            };
            this.element.innerHTML = Template(renderData);
        } else {
            this.element.innerHTML = 'Нет доступных зданий для постройки';
        }
    }
}

export default BuildDialog;