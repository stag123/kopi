import DOMUtils from "../dom";
import TooltipTemplate from "./hbs/default.hbs";
import "./less/index.less";

const MIN_DISTANCE_FROM_VIEWPORT_BORDER = 10;

/** Local variables */
let
    _timer = null,
    _tooltipSelector = "[data-tooltip]",
    _tooltipTextAttribute = "tooltip";


let div = document.createElement('div');

div.innerHTML = TooltipTemplate();

let _tooltipElement = div.querySelector(".tooltip");

let _tooltipText = _tooltipElement.querySelector(".tooltip-inner"),
    _tooltipVisible = false,
    _tooltipArrow = _tooltipElement.querySelector(".arrow");

/** Initialization */
/*
let elements = document.querySelectorAll(_tooltipSelector);

for (let i = 0; i < elements.length; i++) {
    elements[i].addEventListener("mouseover", _updateTooltip);
    elements[i].addEventListener("mouseout", _hideTooltip);
}
*/
DOMUtils.on(document, "mouseover", _tooltipSelector, _updateTooltip);
DOMUtils.on(document, "mouseout", _tooltipSelector, _hideTooltip);

document.body.appendChild(_tooltipElement);

/** Event handlers */
function _updateTooltip (e, target) {
    e.stopPropagation();

    let boundElement = target,
        tooltipData = boundElement.getAttribute('data-' + _tooltipTextAttribute),
        elementBox;

    if (!tooltipData) { return; }

    elementBox = DOMUtils.getBox(boundElement);

    window.clearTimeout(_timer);

    if (_tooltipVisible) _hideTooltip();

    _showTooltip(tooltipData, elementBox);
}

function _showTooltip (text, elementBox) {
    _timer = window.setTimeout(
        function () {

            _tooltipText.innerHTML = text;

            let
                tooltipBox = DOMUtils.getBox(_tooltipElement),

                targetClientTop = elementBox.top - document.body.scrollTop,
                above = targetClientTop > tooltipBox.height + 10,
                top = (above ? elementBox.top - tooltipBox.height - 6 : elementBox.bottom + 6),
                left = elementBox.center - tooltipBox.width / 2,
                tooltipWidth = _tooltipElement.offsetWidth,
                viewportWidth = document.documentElement.clientWidth,
                tooltipStyle;

            // Tooltip out of viewport
            if (left < MIN_DISTANCE_FROM_VIEWPORT_BORDER) {
                left = MIN_DISTANCE_FROM_VIEWPORT_BORDER;
                DOMUtils.css(_tooltipArrow, 'left', elementBox.center - left  + 'px');
            } else if (left + tooltipWidth > viewportWidth - MIN_DISTANCE_FROM_VIEWPORT_BORDER) {
                left = viewportWidth - tooltipWidth - MIN_DISTANCE_FROM_VIEWPORT_BORDER;
                DOMUtils.css(_tooltipArrow, 'left', elementBox.center - left  + 'px');
            } else {
                DOMUtils.css(_tooltipArrow, 'left', tooltipBox.innerWidth / 2  + 'px');
            }

            tooltipStyle = {
                top: top,
                left: left,
                opacity: 1
            };

            if (!above) {
                DOMUtils.addClass(_tooltipElement, "below");
            } else {
                DOMUtils.removeClass(_tooltipElement, "below");
            }

            DOMUtils.css(_tooltipElement, tooltipStyle);
            _tooltipVisible = true;
        },
        300
    );
}

function _hideTooltip () {
    window.clearTimeout(_timer);

    if (!_tooltipVisible) return;

    DOMUtils.css(_tooltipElement, {opacity: 0, top: -12000, left: -12000});
    _tooltipVisible = false;
}