/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/

var stylesInDom = {};

var	memoize = function (fn) {
	var memo;

	return function () {
		if (typeof memo === "undefined") memo = fn.apply(this, arguments);
		return memo;
	};
};

var isOldIE = memoize(function () {
	// Test for IE <= 9 as proposed by Browserhacks
	// @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
	// Tests for existence of standard globals is to allow style-loader
	// to operate correctly into non-standard environments
	// @see https://github.com/webpack-contrib/style-loader/issues/177
	return window && document && document.all && !window.atob;
});

var getElement = (function (fn) {
	var memo = {};

	return function(selector) {
		if (typeof memo[selector] === "undefined") {
			var styleTarget = fn.call(this, selector);
			// Special case to return head of iframe instead of iframe itself
			if (styleTarget instanceof window.HTMLIFrameElement) {
				try {
					// This will throw an exception if access to iframe is blocked
					// due to cross-origin restrictions
					styleTarget = styleTarget.contentDocument.head;
				} catch(e) {
					styleTarget = null;
				}
			}
			memo[selector] = styleTarget;
		}
		return memo[selector]
	};
})(function (target) {
	return document.querySelector(target)
});

var singleton = null;
var	singletonCounter = 0;
var	stylesInsertedAtTop = [];

var	fixUrls = __webpack_require__(4);

module.exports = function(list, options) {
	if (typeof DEBUG !== "undefined" && DEBUG) {
		if (typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
	}

	options = options || {};

	options.attrs = typeof options.attrs === "object" ? options.attrs : {};

	// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
	// tags it will allow on a page
	if (!options.singleton) options.singleton = isOldIE();

	// By default, add <style> tags to the <head> element
	if (!options.insertInto) options.insertInto = "head";

	// By default, add <style> tags to the bottom of the target
	if (!options.insertAt) options.insertAt = "bottom";

	var styles = listToStyles(list, options);

	addStylesToDom(styles, options);

	return function update (newList) {
		var mayRemove = [];

		for (var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];

			domStyle.refs--;
			mayRemove.push(domStyle);
		}

		if(newList) {
			var newStyles = listToStyles(newList, options);
			addStylesToDom(newStyles, options);
		}

		for (var i = 0; i < mayRemove.length; i++) {
			var domStyle = mayRemove[i];

			if(domStyle.refs === 0) {
				for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j]();

				delete stylesInDom[domStyle.id];
			}
		}
	};
};

function addStylesToDom (styles, options) {
	for (var i = 0; i < styles.length; i++) {
		var item = styles[i];
		var domStyle = stylesInDom[item.id];

		if(domStyle) {
			domStyle.refs++;

			for(var j = 0; j < domStyle.parts.length; j++) {
				domStyle.parts[j](item.parts[j]);
			}

			for(; j < item.parts.length; j++) {
				domStyle.parts.push(addStyle(item.parts[j], options));
			}
		} else {
			var parts = [];

			for(var j = 0; j < item.parts.length; j++) {
				parts.push(addStyle(item.parts[j], options));
			}

			stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
		}
	}
}

function listToStyles (list, options) {
	var styles = [];
	var newStyles = {};

	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		var id = options.base ? item[0] + options.base : item[0];
		var css = item[1];
		var media = item[2];
		var sourceMap = item[3];
		var part = {css: css, media: media, sourceMap: sourceMap};

		if(!newStyles[id]) styles.push(newStyles[id] = {id: id, parts: [part]});
		else newStyles[id].parts.push(part);
	}

	return styles;
}

function insertStyleElement (options, style) {
	var target = getElement(options.insertInto)

	if (!target) {
		throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
	}

	var lastStyleElementInsertedAtTop = stylesInsertedAtTop[stylesInsertedAtTop.length - 1];

	if (options.insertAt === "top") {
		if (!lastStyleElementInsertedAtTop) {
			target.insertBefore(style, target.firstChild);
		} else if (lastStyleElementInsertedAtTop.nextSibling) {
			target.insertBefore(style, lastStyleElementInsertedAtTop.nextSibling);
		} else {
			target.appendChild(style);
		}
		stylesInsertedAtTop.push(style);
	} else if (options.insertAt === "bottom") {
		target.appendChild(style);
	} else if (typeof options.insertAt === "object" && options.insertAt.before) {
		var nextSibling = getElement(options.insertInto + " " + options.insertAt.before);
		target.insertBefore(style, nextSibling);
	} else {
		throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");
	}
}

function removeStyleElement (style) {
	if (style.parentNode === null) return false;
	style.parentNode.removeChild(style);

	var idx = stylesInsertedAtTop.indexOf(style);
	if(idx >= 0) {
		stylesInsertedAtTop.splice(idx, 1);
	}
}

function createStyleElement (options) {
	var style = document.createElement("style");

	options.attrs.type = "text/css";

	addAttrs(style, options.attrs);
	insertStyleElement(options, style);

	return style;
}

function createLinkElement (options) {
	var link = document.createElement("link");

	options.attrs.type = "text/css";
	options.attrs.rel = "stylesheet";

	addAttrs(link, options.attrs);
	insertStyleElement(options, link);

	return link;
}

function addAttrs (el, attrs) {
	Object.keys(attrs).forEach(function (key) {
		el.setAttribute(key, attrs[key]);
	});
}

function addStyle (obj, options) {
	var style, update, remove, result;

	// If a transform function was defined, run it on the css
	if (options.transform && obj.css) {
	    result = options.transform(obj.css);

	    if (result) {
	    	// If transform returns a value, use that instead of the original css.
	    	// This allows running runtime transformations on the css.
	    	obj.css = result;
	    } else {
	    	// If the transform function returns a falsy value, don't add this css.
	    	// This allows conditional loading of css
	    	return function() {
	    		// noop
	    	};
	    }
	}

	if (options.singleton) {
		var styleIndex = singletonCounter++;

		style = singleton || (singleton = createStyleElement(options));

		update = applyToSingletonTag.bind(null, style, styleIndex, false);
		remove = applyToSingletonTag.bind(null, style, styleIndex, true);

	} else if (
		obj.sourceMap &&
		typeof URL === "function" &&
		typeof URL.createObjectURL === "function" &&
		typeof URL.revokeObjectURL === "function" &&
		typeof Blob === "function" &&
		typeof btoa === "function"
	) {
		style = createLinkElement(options);
		update = updateLink.bind(null, style, options);
		remove = function () {
			removeStyleElement(style);

			if(style.href) URL.revokeObjectURL(style.href);
		};
	} else {
		style = createStyleElement(options);
		update = applyToTag.bind(null, style);
		remove = function () {
			removeStyleElement(style);
		};
	}

	update(obj);

	return function updateStyle (newObj) {
		if (newObj) {
			if (
				newObj.css === obj.css &&
				newObj.media === obj.media &&
				newObj.sourceMap === obj.sourceMap
			) {
				return;
			}

			update(obj = newObj);
		} else {
			remove();
		}
	};
}

var replaceText = (function () {
	var textStore = [];

	return function (index, replacement) {
		textStore[index] = replacement;

		return textStore.filter(Boolean).join('\n');
	};
})();

function applyToSingletonTag (style, index, remove, obj) {
	var css = remove ? "" : obj.css;

	if (style.styleSheet) {
		style.styleSheet.cssText = replaceText(index, css);
	} else {
		var cssNode = document.createTextNode(css);
		var childNodes = style.childNodes;

		if (childNodes[index]) style.removeChild(childNodes[index]);

		if (childNodes.length) {
			style.insertBefore(cssNode, childNodes[index]);
		} else {
			style.appendChild(cssNode);
		}
	}
}

function applyToTag (style, obj) {
	var css = obj.css;
	var media = obj.media;

	if(media) {
		style.setAttribute("media", media)
	}

	if(style.styleSheet) {
		style.styleSheet.cssText = css;
	} else {
		while(style.firstChild) {
			style.removeChild(style.firstChild);
		}

		style.appendChild(document.createTextNode(css));
	}
}

function updateLink (link, options, obj) {
	var css = obj.css;
	var sourceMap = obj.sourceMap;

	/*
		If convertToAbsoluteUrls isn't defined, but sourcemaps are enabled
		and there is no publicPath defined then lets turn convertToAbsoluteUrls
		on by default.  Otherwise default to the convertToAbsoluteUrls option
		directly
	*/
	var autoFixUrls = options.convertToAbsoluteUrls === undefined && sourceMap;

	if (options.convertToAbsoluteUrls || autoFixUrls) {
		css = fixUrls(css);
	}

	if (sourceMap) {
		// http://stackoverflow.com/a/26603875
		css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
	}

	var blob = new Blob([css], { type: "text/css" });

	var oldSrc = link.href;

	link.href = URL.createObjectURL(blob);

	if(oldSrc) URL.revokeObjectURL(oldSrc);
}


/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(3);
if(typeof content === 'string') content = [[module.i, content, '']];
// Prepare cssTransformation
var transform;

var options = {"hmr":true}
options.transform = transform
// add the styles to the DOM
var update = __webpack_require__(1)(content, options);
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(false) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/less-loader/dist/cjs.js!./site.less", function() {
			var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/less-loader/dist/cjs.js!./site.less");
			if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(0)(undefined);
// imports


// module
exports.push([module.i, "html,\nbody {\n  height: 540px;\n  min-width: 800px;\n  min-height: 540px;\n  background: #303030;\n}\n.wrap {\n  min-height: 100%;\n  height: auto;\n}\n.wrap > .container {\n  width: 100%;\n  height: 100%;\n  padding: 0;\n  margin: 0;\n}\n.footer {\n  height: 60px;\n  background-color: #f5f5f5;\n  border-top: 1px solid #ddd;\n  padding-top: 20px;\n  display: none;\n}\n.jumbotron {\n  text-align: center;\n  background-color: transparent;\n}\n.jumbotron .btn {\n  font-size: 21px;\n  padding: 14px 24px;\n}\n.not-set {\n  color: #c55;\n  font-style: italic;\n}\n/* add sorting icons to gridview sort links */\na.asc:after,\na.desc:after {\n  position: relative;\n  top: 1px;\n  display: inline-block;\n  font-family: 'Glyphicons Halflings';\n  font-style: normal;\n  font-weight: normal;\n  line-height: 1;\n  padding-left: 5px;\n}\na.asc:after {\n  content: \"\\E151\";\n}\na.desc:after {\n  content: \"\\E152\";\n}\n.sort-numerical a.asc:after {\n  content: \"\\E153\";\n}\n.sort-numerical a.desc:after {\n  content: \"\\E154\";\n}\n.sort-ordinal a.asc:after {\n  content: \"\\E155\";\n}\n.sort-ordinal a.desc:after {\n  content: \"\\E156\";\n}\n.grid-view th {\n  white-space: nowrap;\n}\n.hint-block {\n  display: block;\n  margin-top: 5px;\n  color: #999;\n}\n.error-summary {\n  color: #a94442;\n  background: #fdf7f7;\n  border-left: 3px solid #eed3d7;\n  padding: 10px 20px;\n  margin: 0 0 15px 0;\n}\n/* align the logout \"link\" (button in form) of the navbar */\n.navbar {\n  background: #f5f5f5;\n}\n.nav li > form > button.logout {\n  padding: 15px;\n  border: none;\n}\n.site-login {\n  position: absolute;\n  background: #fff;\n  top: 200px;\n  left: 50%;\n  width: 600px;\n  margin-left: -300px;\n  padding: 30px;\n  border-radius: 5px;\n}\n@media (max-width: 767px) {\n  .nav li > form > button.logout {\n    display: block;\n    text-align: left;\n    width: 100%;\n    padding: 10px 15px;\n  }\n}\n.nav > li > form > button.logout:focus,\n.nav > li > form > button.logout:hover {\n  text-decoration: none;\n}\n.nav > li > form > button.logout:focus {\n  outline: none;\n}\n.menu {\n  color: #FFF;\n  height: 60px;\n  font-size: 16px;\n  text-align: center;\n  padding: 5px;\n  clear: both;\n  background: #707070;\n  line-height: 50px;\n}\n.menu .menu-item {\n  height: 40px;\n  background-size: 40px 40px;\n  background-repeat: no-repeat;\n  padding-left: 45px;\n  margin-right: 10px;\n  vertical-align: middle;\n  display: inline-block;\n  color: #FFF;\n}\n.menu .menu-item.map {\n  background-image: url(/images/icons/map.png);\n}\n.menu .menu-item.village {\n  background-image: url(/images/icons/village.png);\n}\n.menu .menu-item.profile {\n  background-image: url(/images/icons/profile.png);\n}\n.menu .menu-item.exit {\n  background-image: url(/images/icons/exit.png);\n}\n", ""]);

// exports


/***/ }),
/* 4 */
/***/ (function(module, exports) {


/**
 * When source maps are enabled, `style-loader` uses a link element with a data-uri to
 * embed the css on the page. This breaks all relative urls because now they are relative to a
 * bundle instead of the current page.
 *
 * One solution is to only use full urls, but that may be impossible.
 *
 * Instead, this function "fixes" the relative urls to be absolute according to the current page location.
 *
 * A rudimentary test suite is located at `test/fixUrls.js` and can be run via the `npm test` command.
 *
 */

module.exports = function (css) {
  // get current location
  var location = typeof window !== "undefined" && window.location;

  if (!location) {
    throw new Error("fixUrls requires window.location");
  }

	// blank or null?
	if (!css || typeof css !== "string") {
	  return css;
  }

  var baseUrl = location.protocol + "//" + location.host;
  var currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");

	// convert each url(...)
	/*
	This regular expression is just a way to recursively match brackets within
	a string.

	 /url\s*\(  = Match on the word "url" with any whitespace after it and then a parens
	   (  = Start a capturing group
	     (?:  = Start a non-capturing group
	         [^)(]  = Match anything that isn't a parentheses
	         |  = OR
	         \(  = Match a start parentheses
	             (?:  = Start another non-capturing groups
	                 [^)(]+  = Match anything that isn't a parentheses
	                 |  = OR
	                 \(  = Match a start parentheses
	                     [^)(]*  = Match anything that isn't a parentheses
	                 \)  = Match a end parentheses
	             )  = End Group
              *\) = Match anything and then a close parens
          )  = Close non-capturing group
          *  = Match anything
       )  = Close capturing group
	 \)  = Match a close parens

	 /gi  = Get all matches, not the first.  Be case insensitive.
	 */
	var fixedCss = css.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function(fullMatch, origUrl) {
		// strip quotes (if they exist)
		var unquotedOrigUrl = origUrl
			.trim()
			.replace(/^"(.*)"$/, function(o, $1){ return $1; })
			.replace(/^'(.*)'$/, function(o, $1){ return $1; });

		// already a full url? no change
		if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(unquotedOrigUrl)) {
		  return fullMatch;
		}

		// convert the url to a full url
		var newUrl;

		if (unquotedOrigUrl.indexOf("//") === 0) {
		  	//TODO: should we add protocol?
			newUrl = unquotedOrigUrl;
		} else if (unquotedOrigUrl.indexOf("/") === 0) {
			// path should be relative to the base url
			newUrl = baseUrl + unquotedOrigUrl; // already starts with '/'
		} else {
			// path should be relative to current directory
			newUrl = currentDir + unquotedOrigUrl.replace(/^\.\//, ""); // Strip leading './'
		}

		// send back the fixed url(...)
		return "url(" + JSON.stringify(newUrl) + ")";
	});

	// send back the fixed css
	return fixedCss;
};


/***/ }),
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(12);


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(2);

__webpack_require__(13);

var _village2 = _interopRequireDefault(__webpack_require__(15));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var domCache = {
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
  resourceStoneMax: document.querySelector('.js_stone_max')
};
new _village2.default(domCache.resourceWood, domCache.resourceWoodHour.innerText, domCache.resourceWoodMax.innerText);
new _village2.default(domCache.resourceGrain, domCache.resourceGrainHour.innerText, domCache.resourceGrainMax.innerText);
new _village2.default(domCache.resourceStone, domCache.resourceStoneHour.innerText, domCache.resourceStoneMax.innerText);
new _village2.default(domCache.resourceIron, domCache.resourceIronHour.innerText, domCache.resourceIronMax.innerText);

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(14);
if(typeof content === 'string') content = [[module.i, content, '']];
// Prepare cssTransformation
var transform;

var options = {"hmr":true}
options.transform = transform
// add the styles to the DOM
var update = __webpack_require__(1)(content, options);
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(false) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/less-loader/dist/cjs.js!./village.less", function() {
			var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/less-loader/dist/cjs.js!./village.less");
			if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(0)(undefined);
// imports


// module
exports.push([module.i, "html,\nbody {\n  height: 540px;\n  min-width: 800px;\n  min-height: 540px;\n  background: #303030;\n}\n.wrap {\n  min-height: 100%;\n  height: auto;\n}\n.wrap > .container {\n  width: 100%;\n  height: 100%;\n  padding: 0;\n  margin: 0;\n}\n.footer {\n  height: 60px;\n  background-color: #f5f5f5;\n  border-top: 1px solid #ddd;\n  padding-top: 20px;\n  display: none;\n}\n.jumbotron {\n  text-align: center;\n  background-color: transparent;\n}\n.jumbotron .btn {\n  font-size: 21px;\n  padding: 14px 24px;\n}\n.not-set {\n  color: #c55;\n  font-style: italic;\n}\n/* add sorting icons to gridview sort links */\na.asc:after,\na.desc:after {\n  position: relative;\n  top: 1px;\n  display: inline-block;\n  font-family: 'Glyphicons Halflings';\n  font-style: normal;\n  font-weight: normal;\n  line-height: 1;\n  padding-left: 5px;\n}\na.asc:after {\n  content: \"\\E151\";\n}\na.desc:after {\n  content: \"\\E152\";\n}\n.sort-numerical a.asc:after {\n  content: \"\\E153\";\n}\n.sort-numerical a.desc:after {\n  content: \"\\E154\";\n}\n.sort-ordinal a.asc:after {\n  content: \"\\E155\";\n}\n.sort-ordinal a.desc:after {\n  content: \"\\E156\";\n}\n.grid-view th {\n  white-space: nowrap;\n}\n.hint-block {\n  display: block;\n  margin-top: 5px;\n  color: #999;\n}\n.error-summary {\n  color: #a94442;\n  background: #fdf7f7;\n  border-left: 3px solid #eed3d7;\n  padding: 10px 20px;\n  margin: 0 0 15px 0;\n}\n/* align the logout \"link\" (button in form) of the navbar */\n.navbar {\n  background: #f5f5f5;\n}\n.nav li > form > button.logout {\n  padding: 15px;\n  border: none;\n}\n.site-login {\n  position: absolute;\n  background: #fff;\n  top: 200px;\n  left: 50%;\n  width: 600px;\n  margin-left: -300px;\n  padding: 30px;\n  border-radius: 5px;\n}\n@media (max-width: 767px) {\n  .nav li > form > button.logout {\n    display: block;\n    text-align: left;\n    width: 100%;\n    padding: 10px 15px;\n  }\n}\n.nav > li > form > button.logout:focus,\n.nav > li > form > button.logout:hover {\n  text-decoration: none;\n}\n.nav > li > form > button.logout:focus {\n  outline: none;\n}\n.menu {\n  color: #FFF;\n  height: 60px;\n  font-size: 16px;\n  text-align: center;\n  padding: 5px;\n  clear: both;\n  background: #707070;\n  line-height: 50px;\n}\n.menu .menu-item {\n  height: 40px;\n  background-size: 40px 40px;\n  background-repeat: no-repeat;\n  padding-left: 45px;\n  margin-right: 10px;\n  vertical-align: middle;\n  display: inline-block;\n  color: #FFF;\n}\n.menu .menu-item.map {\n  background-image: url(/images/icons/map.png);\n}\n.menu .menu-item.village {\n  background-image: url(/images/icons/village.png);\n}\n.menu .menu-item.profile {\n  background-image: url(/images/icons/profile.png);\n}\n.menu .menu-item.exit {\n  background-image: url(/images/icons/exit.png);\n}\n.resource-container {\n  color: #FFF;\n  background: #707070;\n  border-radius: 0 0 20px 20px;\n  font-size: 12px;\n  width: 531px;\n  height: 40px;\n  margin: 0 auto;\n  margin-bottom: 30px;\n  padding: 10px;\n  z-index: 999;\n  position: relative;\n}\n.resource-container .resource {\n  height: 30px;\n  background-size: 30px 30px;\n  background-repeat: no-repeat;\n  padding-left: 35px;\n  margin-right: 10px;\n  display: inline-block;\n  width: 115px;\n  text-align: left;\n}\n.resource-container .resource .count {\n  vertical-align: middle;\n  line-height: 30px;\n  text-align: left;\n}\n.resource-container .resource.wood {\n  color: sandybrown;\n  color: #fff;\n  background-image: url(/images/icons/wood.png);\n}\n.resource-container .resource.grain {\n  color: orange;\n  color: #fff;\n  background-image: url(/images/icons/grain.png);\n}\n.resource-container .resource.iron {\n  color: skyblue;\n  color: #fff;\n  background-image: url(/images/icons/iron.png);\n}\n.resource-container .resource.stone {\n  color: lightsteelblue;\n  color: #fff;\n  background-image: url(/images/icons/stone.png);\n}\n.menu-left {\n  height: 500px;\n  width: 200px;\n  background: #909090;\n  position: absolute;\n  top: -70px;\n  right: 0;\n  text-align: left;\n  padding: 5px;\n  padding-top: 100px;\n}\n.menu-left .resource-container {\n  color: #FFF;\n  background: none;\n  border-radius: 0;\n  font-size: 12px;\n  width: 100px;\n  height: auto;\n  margin: 0;\n}\n.container {\n  background-image: url(/images/backgrounds/b2.png);\n}\n.village-container {\n  text-align: center;\n  width: 754px;\n  height: 500px;\n  padding-right: 200px;\n  position: relative;\n  margin: 0 auto;\n}\n.village-container .map {\n  padding: 2px;\n  width: 544px;\n  height: 384px;\n  overflow: hidden;\n  display: inline-block;\n}\n.village-container .map .selector {\n  display: none;\n}\n.village-container .map > :nth-child(even) .map-cell .index__background {\n  left: 45px;\n}\n.village-container .map > :nth-child(even) .map-cell .selector {\n  margin-left: 43px !important;\n}\n.village-container .map .map-row {\n  height: 60px;\n  line-height: 60px;\n  clear: both;\n  letter-spacing: -10px;\n  position: relative;\n}\n.village-container .map .map-row .map-cell {\n  height: 90px;\n  width: 90px;\n  display: inline-block;\n}\n.village-container .map .map-row .map-cell .index__background {\n  position: relative;\n  background-repeat: no-repeat;\n  background-size: 90px 90px;\n  height: 90px;\n  width: 90px;\n  display: inline-block;\n  z-index: 1;\n  background-image: url(/images/backgrounds/grass_05.png);\n}\n.village-container .map .map-row .map-cell .index__background.b1 {\n  background-image: url(/images/backgrounds/grass_16.png);\n}\n.village-container .map .map-row .map-cell .index__background.b2 {\n  background-image: url(/images/backgrounds/grass_15.png);\n}\n.village-container .map .map-row .map-cell .index__background.b3 {\n  background-image: url(/images/backgrounds/grass_13.png);\n}\n.village-container .map .map-row .map-cell .index__background.b4 {\n  background-image: url(/images/backgrounds/grass_04.png);\n}\n.village-container .map .map-row .map-cell .index__background.village {\n  background-image: url(/images/buildings/medieval_smallCastle.png);\n  cursor: pointer;\n}\n.village-container .map .map-row .map-cell .selector {\n  margin-left: -2px;\n}\n.village-container .map .map-row .map-cell.my-village .selector {\n  z-index: 3;\n  width: 94px;\n  display: block;\n  margin-top: 21.5px;\n  height: 47px;\n  background-color: skyblue;\n  z-index: 2;\n  position: absolute;\n}\n.village-container .map .map-row .map-cell.my-village .selector:before {\n  content: \"\";\n  position: absolute;\n  z-index: 2;\n  top: -23.5px;\n  left: 0;\n  width: 0;\n  height: 0;\n  border-left: 47px solid transparent;\n  border-right: 47px solid transparent;\n  border-bottom: 23.5px solid skyblue;\n}\n.village-container .map .map-row .map-cell.my-village .selector:after {\n  content: \"\";\n  position: absolute;\n  z-index: 2;\n  bottom: -23.5px;\n  left: 0;\n  width: 0;\n  height: 0;\n  border-left: 47px solid transparent;\n  border-right: 47px solid transparent;\n  border-top: 23.5px solid skyblue;\n}\n.village-container .map .map-row .map-cell.my-village .index__background {\n  z-index: 4;\n}\n.village-container .map .map-row .map-cell:hover .selector {\n  width: 94px;\n  display: block;\n  margin-top: 21.5px;\n  height: 47px;\n  background-color: lawngreen;\n  z-index: 2;\n  position: absolute;\n}\n.village-container .map .map-row .map-cell:hover .selector:before {\n  content: \"\";\n  position: absolute;\n  z-index: 2;\n  top: -23.5px;\n  left: 0;\n  width: 0;\n  height: 0;\n  border-left: 47px solid transparent;\n  border-right: 47px solid transparent;\n  border-bottom: 23.5px solid lawngreen;\n}\n.village-container .map .map-row .map-cell:hover .selector:after {\n  content: \"\";\n  position: absolute;\n  z-index: 2;\n  bottom: -23.5px;\n  left: 0;\n  width: 0;\n  height: 0;\n  border-left: 47px solid transparent;\n  border-right: 47px solid transparent;\n  border-top: 23.5px solid lawngreen;\n}\n.village-container .map .map-row .map-cell:hover .index__background {\n  z-index: 3;\n}\n", ""]);

// exports


/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var ResourceVillage =
/*#__PURE__*/
function () {
  function ResourceVillage(element, speedHour, max) {
    _classCallCheck(this, ResourceVillage);

    this.element = element;
    this.speed = speedHour;
    this.start_time = ResourceVillage.getTime();
    this.max = max;
    this.resource_start = parseInt(this.element.innerHTML);
    this.startTimer();
  }

  _createClass(ResourceVillage, [{
    key: "update",
    value: function update() {
      var res = Math.floor(this.speed * (ResourceVillage.getTime() - this.start_time) / 3600);

      if (this.resource_start + res > this.max) {
        this.element.innerHTML = this.max;
        return;
      }

      this.element.innerHTML = this.resource_start + res;
    }
  }, {
    key: "startTimer",
    value: function startTimer() {
      this.timer = window.setInterval(this.update.bind(this), 100);
    }
  }], [{
    key: "getTime",
    value: function getTime() {
      return new Date().getTime() / 1000;
    }
  }]);

  return ResourceVillage;
}();

var _default = ResourceVillage;
exports.default = _default;

/***/ })
/******/ ]);