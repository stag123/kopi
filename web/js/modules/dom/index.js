/** DOM */
const UNDIMESIONED_PROPS = "zoom,opacity,z-index";
import Delegate from "dom-delegate/lib";

class DOM {
    /**
     * A lightweight replacement for jQuery .css method requireing more attention
     * All style property names must be set exactly as the are (no camelCase naming)
     * @param {HTMLElement} element
     * @param {string|Object} style
     * @param {string|boolean} value
     * @returns {Event}
     */
    static css (element, style, value) {
        if (!!element.get) element = element.get(0);

        if (!element)  throw new TypeError("Element not specified");
        if (!style || (typeof style !== 'string' && typeof style !== 'object'))  throw new TypeError("Style must be a string or an object");
        if (
            typeof style === "string" &&
            typeof value !== "string" &&
            typeof value !== false
        ) {
            return (element.style[style] || window.getComputedStyle(element)).getPropertyValue(style);
        }

        let setStyle = (element, style, value) => {
            if (value === false) return element.style.removeProperty(style);

            if (
                typeof value === "number" &&
                UNDIMESIONED_PROPS.indexOf(style) === -1
            ) {
                value = value + "px";
            }

            element.style.setProperty(style, value);
        }

        if (typeof style === "string") {
            setStyle(element, style, value);
        } else {
            let field;
            for (field in style) {
                if (style.hasOwnProperty(field)) {
                    setStyle(element, field, style[field]);
                }
            }
        }

        return DOM;
    }

    static attr (element, name, value) {
        if (typeof value === "undefined") {
            return element.getAttribute(name);
        }
        element.setAttribute(name, value);
    }

    static data(element, name, value) {
        return DOM.attr(element, "data-" + name, value);
    }

    /**
     * Method to detect if an element and all/some of its ancestors fulfill
     * some condition
     * @param {HTMLElement} element
     * @param {Function} checkFunction
     * @param {number} depth
     * @returns {boolean}
     */
    static treeMatches (element, checkFunction, depth = 5) {

        if (!!element.get) element = element.get(0);
        if (!element) throw new TypeError("Element must be set");
        if (typeof checkFunction !== "function") throw new TypeError("Check must be a function");

        if (typeof depth !== "number") depth = 5;

        let currentLevels = 0,
            currentElement = element;

        while (currentElement && currentLevels++ < depth && currentElement !== document.body) {
            if (checkFunction(currentElement)) return true;

            currentElement = currentElement.parentElement;
        }

        return false;
    }

    static hasParent (element, parent, depth = 5) {
        return DOM.treeMatches(element, currentParent => currentParent === parent, depth);
    }

    /**
     * Shorthand optimized class add method
     * @param {HTMLElement} element
     * @param {string} className
     * @returns {DOM}
     */
    static addClass (element, className) {
        if (!!element.get) element = element.get(0);

        if (!element)  throw new TypeError("Element not specified");

        if (!element.classList.contains(className)) element.classList.add(className);

        return DOM;
    }

    /**
     * Shorthand optimized class remove method
     * @param {HTMLElement} element
     * @param {string} className
     * @returns {DOM}
     */
    static removeClass (element, className) {
        if (!!element.get) element = element.get(0);

        if (!element)  throw new TypeError("Element not specified");

        if (element.classList.contains(className)) element.classList.remove(className);

        return DOM;
    }

    static toggleClass (element, className) {
        if (DOM.hasClass(element, className)) {
            DOM.removeClass(element, className);
        } else {
            DOM.addClass(element, className);
        }
    }

    static hasClass (el, cls) {
        return (' ' + el.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }

    static getScript (url, callback) {
        var script = document.createElement("script");

        script.type = "text/javascript";
        script.src = url;
        script.defer = true;

        script.onload = callback;

        document.body.appendChild(script);
    }

    static recreateElement(node) {
        var clonedNode = node.cloneNode(true);
        node.parentNode.replaceChild(clonedNode, node);
        return clonedNode;
    }

    /**
     * * @param {HTMLElement} target
     */
    static getBox(target) {
        let rect = target.getBoundingClientRect(),
            docElem = document.documentElement,
            width = target.offsetWidth,
            margin = 0,//parseInt(target.css("margin-left")),
            height = target.offsetHeight,
            offset = {
                top: rect.top + window.pageYOffset - docElem.clientTop,
                left: rect.left + window.pageXOffset - docElem.clientLeft
            },
            box = {
                top: offset.top,
                left: offset.left,
                bottom: offset.top + height,
                right: offset.left + width,
                center: offset.left + width / 2,
                middle: offset.top + height / 2,
                width: width,
                height: height,
                textLeft: (offset.left + margin) || offset.left
            };
        box.rightOffset = Math.abs(window.innerWidth - box.right);

        return box;
    }

    static on(element, type, selectorOrCallback, callback) {
        var delegate = new Delegate(element);
        delegate.on(type, selectorOrCallback, callback);
    }

    static off(element, type, selectorOrCallback, callback) {
        var delegate = new Delegate(element);
        delegate.off(type, selectorOrCallback, callback);
    }

    static formData(element) {
        var formElements=element.elements;
        var postData={};
        for (var i=0; i<formElements.length; i++)
            if (formElements[i].type!="submit")//we dont want to include the submit-buttom
                postData[formElements[i].name]=formElements[i].value;
        return postData;
    }
}

export default DOM;