import Template from "./hbs/build.hbs";
import MessageTemplate from "./hbs/error.hbs";
import "./less/build.less";
import Net from "../net";
import DOM from "../dom";
import BaseDialog from "./base";

class BuildDialog extends BaseDialog {

    constructor(mapId, villageResource) {
        super();
        this.mapId = mapId;
        this.villageResource = villageResource;
        let request = Net.ajax("GET", "/village/build-list", {mapId: mapId});
        request.then(this.open.bind(this), ()=> {console.log('errpr')});
    }

    open(data) {
        super.open();

        if (data.builds || data.currentBuild) {
            let renderData = {
                villageResource: this.villageResource,
                mapId: this.mapId,
                builds: data.builds,
                currentBuild: data.currentBuild,
                nextBuild: data.nextBuild
            };
            this.element.innerHTML = Template(renderData);
        } else {
            this.element.innerHTML = MessageTemplate({message: 'Нет доступных зданий для постройки'});
        }
    }

    close() {
        super.close();
        document.location.hash = '';
    }
}

export default BuildDialog;