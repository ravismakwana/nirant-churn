/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/gutenberg/block-extensions/register-block-styles.js":
/*!********************************************************************!*\
  !*** ./src/js/gutenberg/block-extensions/register-block-styles.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/**
 * Register block styles.
 *
 * @package
 */

/**
 * WordPress dependencies.
 */


/**
 * Quote Block styles.
 *
 * @type {Array}
 */

var layoutStyleQuote = [{
  name: 'layout-dark-background',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Layout style dark background', 'asgard')
}];
/**
 * Button Media styles.
 *
 * @type {Array}
 */

var layoutStyleButton = [{
  name: 'layout-border-blue-fill',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Blue outline', 'asgard')
}, {
  name: 'layout-border-white-no-fill',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('White outline - to be used with dark background', 'asgard')
}];
/**
 * Deregister styles.
 *
 * @return {void}
 */

var deRegister = function deRegister() {
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.unregisterBlockStyle)('core/quote', 'large');
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.unregisterBlockStyle)('core/button', 'outline');
};
/**
 * Register styles.
 *
 * @return {void}
 */


var register = function register() {
  layoutStyleQuote.forEach(function (layoutStyle) {
    return (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/quote', layoutStyle);
  });
  layoutStyleButton.forEach(function (layoutStyle) {
    return (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/button', layoutStyle);
  });
};
/**
 * Register and unregister styles on dom ready.
 */


wp.domReady(function () {
  deRegister();
  register();
});

/***/ }),

/***/ "./src/js/gutenberg/blocks/dos-and-donts/Edit.js":
/*!*******************************************************!*\
  !*** ./src/js/gutenberg/blocks/dos-and-donts/Edit.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _template__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./template */ "./src/js/gutenberg/blocks/dos-and-donts/template.js");


var ALLOWED_BLOCKS = ['core/group'];
var INNER_BLOCK_TEMPLATE = [['core/group', {
  className: 'asgard-dos-and-donts__group',
  backgroundColor: 'luminous-vivid-amber'
}, _template__WEBPACK_IMPORTED_MODULE_1__.blockColumn]];

var Edit = function Edit() {
  return /*#__PURE__*/React.createElement("div", {
    className: "asgard-dos-and-donts"
  }, /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InnerBlocks, {
    template: INNER_BLOCK_TEMPLATE,
    templateLock: true,
    allowedBlocks: ALLOWED_BLOCKS
  }));
};

/* harmony default export */ __webpack_exports__["default"] = (Edit);

/***/ }),

/***/ "./src/js/gutenberg/blocks/dos-and-donts/index.js":
/*!********************************************************!*\
  !*** ./src/js/gutenberg/blocks/dos-and-donts/index.js ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _Edit__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Edit */ "./src/js/gutenberg/blocks/dos-and-donts/Edit.js");




(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)('asgard-blocks/dos-and-donts', {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Dos and Dont\'s', 'asgard'),
  description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Dos and Donts description', 'asgard'),
  category: 'asgard',
  icon: 'editor-table',
  edit: _Edit__WEBPACK_IMPORTED_MODULE_3__["default"],
  save: function save() {
    return /*#__PURE__*/React.createElement("div", {
      className: "asgard-dos-and-donts"
    }, /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InnerBlocks.Content, null));
  }
});

/***/ }),

/***/ "./src/js/gutenberg/blocks/dos-and-donts/template.js":
/*!***********************************************************!*\
  !*** ./src/js/gutenberg/blocks/dos-and-donts/template.js ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "blockColumn": function() { return /* binding */ blockColumn; }
/* harmony export */ });
var getBlockColumn = function getBlockColumn(optionVal, colClassName, heading) {
  return ['core/column', {
    className: colClassName
  }, [['asgard-blocks/heading', {
    className: 'asgard-dos-and-donts__heading',
    option: optionVal,
    content: heading
  }], ['core/list', {
    className: 'asgard-dos-and-donts__list'
  }]]];
};

var blockColumn = [['core/columns', {
  className: 'asgard-dos-and-donts__columns'
}, [getBlockColumn('dos', 'asgard-dos-and-donts-col-one', 'Dos'), getBlockColumn('donts', 'asgard-dos-and-donts-col-one', 'Dont\'s')]]];

/***/ }),

/***/ "./src/js/gutenberg/blocks/heading-with-icon/Edit.js":
/*!***********************************************************!*\
  !*** ./src/js/gutenberg/blocks/heading-with-icon/Edit.js ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _map_icons__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./map-icons */ "./src/js/gutenberg/blocks/heading-with-icon/map-icons.js");





var Edit = function Edit(_ref) {
  var className = _ref.className,
      attributes = _ref.attributes,
      setAttributes = _ref.setAttributes;
  var option = attributes.option,
      content = attributes.content;
  var HeadingIcon = (0,_map_icons__WEBPACK_IMPORTED_MODULE_3__.getIconComponent)(option);
  console.warn('Option HeadingIcon', option, HeadingIcon);
  return /*#__PURE__*/React.createElement("div", {
    className: "asgard-icon-heading"
  }, /*#__PURE__*/React.createElement("span", {
    className: "asgard-icon-heading__heading"
  }, /*#__PURE__*/React.createElement(HeadingIcon, null)), /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText, {
    tagName: "h4",
    className: className,
    value: content,
    onChange: function onChange(content) {
      return setAttributes({
        content: content
      });
    },
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading...', 'asgard')
  }), /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InspectorControls, null, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading Settings', 'asgard')
  }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.RadioControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Select Icon', 'asgard'),
    help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Controls Icon Selection', 'asgard'),
    selected: option,
    options: [{
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Dos', 'asgard'),
      value: 'dos'
    }, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Dont's", 'asgard'),
      value: 'donts'
    }],
    onChange: function onChange(option) {
      return setAttributes({
        option: option
      });
    }
  }))));
};

/* harmony default export */ __webpack_exports__["default"] = (Edit);

/***/ }),

/***/ "./src/js/gutenberg/blocks/heading-with-icon/index.js":
/*!************************************************************!*\
  !*** ./src/js/gutenberg/blocks/heading-with-icon/index.js ***!
  \************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _Edit__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Edit */ "./src/js/gutenberg/blocks/heading-with-icon/Edit.js");
/* harmony import */ var _map_icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./map-icons */ "./src/js/gutenberg/blocks/heading-with-icon/map-icons.js");





(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)('asgard-blocks/heading', {
  title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Icon Heading', 'asgard'),
  description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('This is the description of heading icon block', 'asgard'),
  category: 'asgard',
  icon: 'admin-customizer',
  attributes: {
    option: {
      type: 'string',
      default: 'dos'
    },
    content: {
      type: 'string',
      source: 'html',
      selector: 'h4',
      default: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Dos', 'asgard')
    }
  },
  edit: _Edit__WEBPACK_IMPORTED_MODULE_3__["default"],
  save: function save(_ref) {
    var _ref$attributes = _ref.attributes,
        option = _ref$attributes.option,
        content = _ref$attributes.content;
    var HeadingIcon = (0,_map_icons__WEBPACK_IMPORTED_MODULE_4__.getIconComponent)(option);
    return /*#__PURE__*/React.createElement("div", {
      className: "asgard-icon-heading"
    }, /*#__PURE__*/React.createElement("span", {
      className: "asgard-icon-heading__heading"
    }, /*#__PURE__*/React.createElement(HeadingIcon, null)), /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText.Content, {
      tagName: "h4",
      value: content
    }));
  }
});

/***/ }),

/***/ "./src/js/gutenberg/blocks/heading-with-icon/map-icons.js":
/*!****************************************************************!*\
  !*** ./src/js/gutenberg/blocks/heading-with-icon/map-icons.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getIconComponent": function() { return /* binding */ getIconComponent; }
/* harmony export */ });
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../icons */ "./src/js/icons/index.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);


var getIconComponent = function getIconComponent(option) {
  var IconMap = {
    dos: _icons__WEBPACK_IMPORTED_MODULE_0__.Check,
    donts: _icons__WEBPACK_IMPORTED_MODULE_0__.Close
  };
  return !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(option) && option in IconMap ? IconMap[option] : IconMap.dos;
};

/***/ }),

/***/ "./src/js/icons/Check.js":
/*!*******************************!*\
  !*** ./src/js/icons/Check.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }



var SvgCheck = function SvgCheck(props) {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0__.createElement("svg", _extends({
    xmlns: "http://www.w3.org/2000/svg",
    fill: "#228b22",
    width: 18,
    height: 18,
    viewBox: "0 0 122 122",
    xmlSpace: "preserve"
  }, props), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0__.createElement("path", {
    d: "M61.44 0c16.966 0 32.326 6.877 43.445 17.995s17.996 26.479 17.996 43.444c0 16.967-6.877 32.327-17.996 43.445S78.406 122.88 61.44 122.88s-32.326-6.877-43.444-17.995S0 78.406 0 61.439c0-16.965 6.877-32.326 17.996-43.444S44.474 0 61.44 0zM34.556 67.179a3.207 3.207 0 0 1 4.303-4.756L52.3 74.611l31.543-33.036a3.213 3.213 0 1 1 4.656 4.428L54.793 81.305l-.004-.004a3.207 3.207 0 0 1-4.475.168l-15.758-14.29zM100.33 22.55C90.377 12.598 76.627 6.441 61.44 6.441c-15.188 0-28.938 6.156-38.89 16.108-9.953 9.953-16.108 23.702-16.108 38.89 0 15.188 6.156 28.938 16.108 38.891 9.952 9.952 23.702 16.108 38.89 16.108 15.187 0 28.937-6.156 38.89-16.108 9.953-9.953 16.107-23.702 16.107-38.891.001-15.187-6.154-28.937-16.107-38.889z"
  }));
};

/* harmony default export */ __webpack_exports__["default"] = (SvgCheck);

/***/ }),

/***/ "./src/js/icons/Close.js":
/*!*******************************!*\
  !*** ./src/js/icons/Close.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }



var SvgClose = function SvgClose(props) {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0__.createElement("svg", _extends({
    xmlns: "http://www.w3.org/2000/svg",
    width: 18,
    height: 18,
    fill: "red",
    viewBox: "0 0 122 122"
  }, props), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0__.createElement("path", {
    d: "M61.44 0c16.966 0 32.326 6.877 43.445 17.996 11.119 11.118 17.996 26.479 17.996 43.444 0 16.967-6.877 32.326-17.996 43.444-11.119 11.119-26.479 17.996-43.445 17.996s-32.326-6.877-43.444-17.996C6.877 93.766 0 78.406 0 61.439c0-16.965 6.877-32.326 17.996-43.444C29.114 6.877 44.474 0 61.44 0zm18.72 37.369a3.332 3.332 0 1 1 4.713 4.713L65.512 61.444l19.361 19.362a3.333 3.333 0 0 1-4.713 4.713L60.798 66.157 41.436 85.52a3.333 3.333 0 0 1-4.713-4.713l19.363-19.362-19.363-19.363a3.333 3.333 0 0 1 4.713-4.713l19.363 19.362L80.16 37.369zm20.012-14.661C90.26 12.796 76.566 6.666 61.44 6.666c-15.126 0-28.819 6.13-38.731 16.042C12.797 32.62 6.666 46.314 6.666 61.439c0 15.126 6.131 28.82 16.042 38.732 9.912 9.911 23.605 16.042 38.731 16.042 15.126 0 28.82-6.131 38.732-16.042 9.912-9.912 16.043-23.606 16.043-38.732.001-15.125-6.13-28.819-16.042-38.731z"
  }));
};

/* harmony default export */ __webpack_exports__["default"] = (SvgClose);

/***/ }),

/***/ "./src/js/icons/index.js":
/*!*******************************!*\
  !*** ./src/js/icons/index.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Check": function() { return /* reexport safe */ _Check__WEBPACK_IMPORTED_MODULE_0__["default"]; },
/* harmony export */   "Close": function() { return /* reexport safe */ _Close__WEBPACK_IMPORTED_MODULE_1__["default"]; }
/* harmony export */ });
/* harmony import */ var _Check__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Check */ "./src/js/icons/Check.js");
/* harmony import */ var _Close__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Close */ "./src/js/icons/Close.js");



/***/ }),

/***/ "./src/sass/blocks.scss":
/*!******************************!*\
  !*** ./src/sass/blocks.scss ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

module.exports = window["React"];

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/***/ (function(module) {

module.exports = window["lodash"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**************************!*\
  !*** ./src/js/blocks.js ***!
  \**************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_blocks_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/blocks.scss */ "./src/sass/blocks.scss");
/* harmony import */ var _js_gutenberg_blocks_heading_with_icon__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../js/gutenberg/blocks/heading-with-icon */ "./src/js/gutenberg/blocks/heading-with-icon/index.js");
/* harmony import */ var _js_gutenberg_blocks_dos_and_donts__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../js/gutenberg/blocks/dos-and-donts */ "./src/js/gutenberg/blocks/dos-and-donts/index.js");
/* harmony import */ var _js_gutenberg_block_extensions_register_block_styles__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../js/gutenberg/block-extensions/register-block-styles */ "./src/js/gutenberg/block-extensions/register-block-styles.js");
 // blocks




}();
/******/ })()
;
//# sourceMappingURL=blocks.js.map