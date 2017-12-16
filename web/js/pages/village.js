import "./less/site.less";
import "./less/village.less";
import ResourceVillage from "../modules/resource/village";
import "../modules/tooltip";
import BuildDialog from "../modules/dialog/build_dialog";
import DOM from "../modules/dom";

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

    buildMap: document.querySelector('.js_map')
}

new ResourceVillage(domCache.resourceWood, domCache.resourceWoodHour.innerText, domCache.resourceWoodMax.innerText);
new ResourceVillage(domCache.resourceGrain, domCache.resourceGrainHour.innerText, domCache.resourceGrainMax.innerText);
new ResourceVillage(domCache.resourceStone, domCache.resourceStoneHour.innerText, domCache.resourceStoneMax.innerText);
new ResourceVillage(domCache.resourceIron, domCache.resourceIronHour.innerText, domCache.resourceIronMax.innerText);

DOM.on(domCache.buildMap, ".js_build", "click", (e, target) => {
   // debugger;
    new BuildDialog(DOM.data(target, "id"));
});