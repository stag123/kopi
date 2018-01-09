import "../modules/tooltip";
import Net from "../modules/net";
import MapPart from "./hbs/map-part.hbs";
import DOM from "../modules/dom";

let domCache = {
    map: document.getElementById('map_container'),
    top: document.querySelector(".top"),
    left: document.querySelector(".left"),
    bottom: document.querySelector(".bottom"),
    right: document.querySelector(".right"),
};

var startx = window.initials.x,
     starty = window.initials.y;


function update(x, y) {
    let request = Net.ajax("GET", "/map/part", {x: startx + x, y: starty + y});
    request.then(function (data) {
        domCache.map.innerHTML = MapPart({mapData: data});
        startx = startx + x;
        starty = starty + y;
    }, function (error) {
        console.log(error)
    });
}

update(0, 0);

DOM.on(domCache.top, "click", update.bind(this, 0, -2));
DOM.on(domCache.left, "click", update.bind(this, -2, 0));
DOM.on(domCache.bottom, "click", update.bind(this, 0, 2));
DOM.on(domCache.right, "click", update.bind(this, 2, 0));

