import "./less/enemy.less";
import DOM from "../modules/dom";
import AttackDialog from "../modules/dialog/attack";

let domCache = {
    attackButton: document.querySelector(".attack")
};

DOM.on(domCache.attackButton, "click", function() {
    (new AttackDialog(window.initials.villageFromId, window.initials.villageToId, window.initials.units)).open();
});