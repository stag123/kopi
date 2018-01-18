import ResourceVillage from "../modules/resource/village";
import "../modules/tooltip";
import BuildDialog from "../modules/dialog/build";
import DOM from "../modules/dom";
import Net from "../modules/net";
import Timer from "../modules/timer";
import BuildTimerTemplate from "../modules/timer/hbs/build.hbs";
import AttackTimerTemplate from "../modules/timer/hbs/attack.hbs";

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
    buildInfo: document.querySelector('.js_build_info'),
    redInfo: document.querySelector('.js_red_info'),
    greenInfo: document.querySelector('.js_green_info'),
    yellowInfo: document.querySelector('.js_yellow_info'),
};

new ResourceVillage(domCache.resourceWood, domCache.resourceWoodHour.innerText, domCache.resourceWoodMax.innerText, (resource) => {
    window.initials.villageResource.wood = resource;
});
new ResourceVillage(domCache.resourceGrain, domCache.resourceGrainHour.innerText, domCache.resourceGrainMax.innerText, (resource) => {
    window.initials.villageResource.grain = resource;
});
new ResourceVillage(domCache.resourceStone, domCache.resourceStoneHour.innerText, domCache.resourceStoneMax.innerText, (resource) => {
    window.initials.villageResource.stone = resource;
});
new ResourceVillage(domCache.resourceIron, domCache.resourceIronHour.innerText, domCache.resourceIronMax.innerText, (resource) => {
    window.initials.villageResource.iron = resource;
});

/*DOM.on(domCache.buildMap, "click", ".js_build", (e, target) => {
   // debugger;
    new BuildDialog(DOM.data(target, "id"), window.initials.villageResource);
});*/
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

const TYPE_ATTACK = 1;
const TYPE_BUILD = 2;
const TYPE_BUILD_UNIT = 3;

if (window.initials.tasks) {
    window.initials.tasks.forEach(function(item) {
        if (item.type == TYPE_BUILD) {
            let div = document.createElement('div');
            div.innerHTML = BuildTimerTemplate({title: item.build.name + ' строится, до конца осталось: ', time: Timer.fancyDate(item.time_left)});
            let cache = div.querySelector('.js_timer');
            new Timer(cache, item.time_left);
            domCache.buildInfo.appendChild(div);
        }

        if (item.type == TYPE_BUILD_UNIT) {
            let div = document.createElement('div');
            div.innerHTML = BuildTimerTemplate({title: item.unit.name + ' обучается, до конца осталось: ', time: Timer.fancyDate(item.time_left)});
            let cache = div.querySelector('.js_timer');
            new Timer(cache, item.time_left);
            domCache.buildInfo.appendChild(div);
        }

        if (item.type == TYPE_ATTACK) {
            let dom = domCache.yellowInfo;
            let div = document.createElement('div');
            if (window.initials.villageId === item.villageFrom.id) {
                div.innerHTML = AttackTimerTemplate({title: 'Исходящая атака', href: "/village/enemy?id=" + item.villageTo.id, tooltip: "На " + item.villageTo.name, time: Timer.fancyDate(item.time_left)});
            } else {
                if (window.initials.villageId === item.units_village_id) {
                    dom = domCache.greenInfo;
                    div.innerHTML = AttackTimerTemplate({title: 'Возвращение войск', href: "/village/enemy?id=" + item.villageFrom.id, tooltip: "Из " + item.villageFrom.name, time: Timer.fancyDate(item.time_left)});
                } else {
                    dom = domCache.redInfo;
                    div.innerHTML = AttackTimerTemplate({title: 'Идет нападение', href: "/village/enemy?id=" + item.villageFrom.id, tooltip: "Из " + item.villageFrom.name, time: Timer.fancyDate(item.time_left)});
                }
            }
            let cache = div.querySelector('.js_timer');
            new Timer(cache, item.time_left);
            dom.appendChild(div);
        }
    });
}

function hashChange () {
    let hash = document.location.hash.replace('#', '').replace('map', '');
    if (hash) {
        new BuildDialog(hash, window.initials.villageResource);
    }
};


window.addEventListener("hashchange", hashChange);

if (document.location.hash) {
    hashChange();
}
