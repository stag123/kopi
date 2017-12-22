import "./less/village.less";
import ResourceVillage from "../modules/resource/village";
import "../modules/tooltip";
import BuildDialog from "../modules/dialog/build";
import DOM from "../modules/dom";
import Net from "../modules/net";
import Timer from "../modules/timer";
import BuildTimerTemplate from "../modules/timer/hbs/build.hbs";

let domCache = {
    resourceWood: document.querySelector('.js_wood_count'),
    resourceWoodHour: document.querySelector('.js_wood_speed'),
    resourceWoodMax: document.querySelector('.js_wood_max'),

    resourceGrain: document.querySelector('.js_grain_count'),
    resourceGrainHour: document.querySelector('.js_grain_speed'),
    resourceGrainMax: document.querySelector('.js_grain_max'),

    resourceIron: document.querySelector('.js_iron_count'),
    resourceIronHour: document.querySelector('.js_iron_speed'),
    resourceIronMax: document.querySelector('.js_iron_max'),

    resourceStone: document.querySelector('.js_stone_count'),
    resourceStoneHour: document.querySelector('.js_stone_speed'),
    resourceStoneMax: document.querySelector('.js_stone_max'),

    buildMap: document.querySelector('.js_map'),
    buildInfo: document.querySelector('.js_build_info')
};

new ResourceVillage(domCache.resourceWood, domCache.resourceWoodHour.innerText, domCache.resourceWoodMax.innerText);
new ResourceVillage(domCache.resourceGrain, domCache.resourceGrainHour.innerText, domCache.resourceGrainMax.innerText);
new ResourceVillage(domCache.resourceStone, domCache.resourceStoneHour.innerText, domCache.resourceStoneMax.innerText);
new ResourceVillage(domCache.resourceIron, domCache.resourceIronHour.innerText, domCache.resourceIronMax.innerText);

DOM.on(domCache.buildMap, "click", ".js_build", (e, target) => {
   // debugger;
    new BuildDialog(DOM.data(target, "id"), DOM.data(target, "build-code"), window.initials.villageResource);
});
/*
function updateVillage() {
    let request = Net.ajax("GET", "/village/stat", {id: window.initials.villageId});
    request.then(function(data) {
        data.forEach(function(item) {
            if (item.build) {
                domCache.buildInfo.innerHTML = item.build.name + ' строится, будет готов через ';

            }
        });
    }, function(error) {console.log(error)});
}
setInterval(updateVillage, 5000);
    */

if (window.initials.tasks) {
    window.initials.tasks.forEach(function(item) {
        if (item.build) {
            let div = document.createElement('div');
            div.innerHTML = BuildTimerTemplate({title: item.build.name + ' строится, до конца осталось: ', time: 0});
            let cache = div.querySelector('.js_timer');
            new Timer(cache, item.time_left);
            domCache.buildInfo.appendChild(div);
        }
    });
}
