/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/***/ (function(module) {

module.exports = window["lodash"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/dom-ready":
/*!**********************************!*\
  !*** external ["wp","domReady"] ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["wp"]["domReady"];

/***/ }),

/***/ "@wordpress/hooks":
/*!*******************************!*\
  !*** external ["wp","hooks"] ***!
  \*******************************/
/***/ (function(module) {

module.exports = window["wp"]["hooks"];

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
/*!********************************!*\
  !*** ./resources/js/editor.js ***!
  \********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/hooks */ "@wordpress/hooks");
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/dom-ready */ "@wordpress/dom-ready");
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_4__);
// Internal dependencies.
// import { ICONS } from './const';

// WordPress dependencies.



// import { __ } from '@wordpress/i18n';



function addBorderSupport(settings, name) {
  // Bail early if the block does not have supports.
  if (!(settings !== null && settings !== void 0 && settings.supports)) {
    return settings;
  }

  // Only apply to Column, Heading, and Paragraph blocks.
  if (name === 'core/heading') {
    return Object.assign({}, settings, {
      supports: Object.assign(settings.supports, {
        __experimentalBorder: {
          color: true,
          radius: false,
          style: false,
          width: false,
          __experimentalDefaultControls: {
            color: true,
            radius: false,
            style: false,
            width: false
          }
        }
      })
    });
  }
  return settings;
}
(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__.addFilter)('blocks.registerBlockType', 'modify-block-supports/add-border-support', addBorderSupport);

// addFilter(
//   'blocks.registerBlockType',
//   'wa/alignblockquote',
//   (settings, name) => {
//     // if ('core/quote' === name) {
//     //   return lodash.assign({}, settings, {
//     //     attributes: lodash.assign({}, settings.attributes, {
//     //       supports: {
//     //         align: true,
//     //       },
//     //       styles: [
//     //         { name: 'default', label: 'Predeterminado', isDefault: true },
//     //         { name: 'alignwide', label: 'Ancho Completo' },
//     //         { name: 'alignfull', label: 'Alineación Completa' },
//     //         { name: 'aligncenter', label: 'Centrado' },
//     //       ],
//     //     }),
//     //   });
//     // }
//     if (!settings?.supports) {
//       return settings;
//     }
//     // return settings;
//     if (name === 'core/quote') {
//       // Añadir soporte para alineaciones
//       // settings.supports.align = true;

//       // Definir estilos adicionales
//       // settings.styles = [
//       //   // { name: 'default', label: 'Predeterminado', isDefault: true },
//       //   { name: 'alignwide', label: 'Ancho Completo' },
//       //   { name: 'alignfull', label: 'Alineación Completa' },
//       //   { name: 'aligncenter', label: 'Centrado' },
//       // ];

//       // settings.styles = settings.styles.filter(style =>
//       //   ['alignwide', 'alignfull', 'aligncenter'].includes(style.name)
//       // );

//       return assign({}, settings, {
//         supports: merge(settings.supports, {
//           align: ['wide', 'center'],
//         }),
//       });
//     }

//     return settings;
//   }
// );

// addFilter('blocks.registerBlockType', 'wa/img', (settings, name) => {
//   if ('core/image' === name) {
//     return lodash.assign({}, settings, {
//       attributes: lodash.assign({}, settings.attributes, {
//         align: {
//           type: 'string',
//           default: 'center',
//         },
//       }),
//     });
//   }

//   return settings;
// });

// Register a block style for each icon.
_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_2___default()(function () {
  // ICONS.forEach(icon => {
  //   registerBlockStyle('core/separator', {
  //     name: `icon-${icon.value}`,
  //     label: sprintf(__('%s', 'theme-slug'), icon.icon),
  //   });
  //   console.log('HOLA');
  // });

  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/paragraph', {
    name: "paragraph-limited-width",
    label: "Ancho limitado"
  });
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/paragraph', {
    name: "paragraph-font-small",
    label: "Letra peque\xF1a"
  });
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/paragraph', {
    name: "paragraph-font-medium",
    label: "Letra medium"
  });
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/paragraph', {
    name: "paragraph-hero-txt",
    label: "Letra Hero Banner"
  });
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/heading', {
    name: "heading-light",
    label: "Ligero"
  });
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/heading', {
    name: "heading-border",
    label: "Con borde"
  });
  (0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockStyle)('core/heading', {
    name: "heading-big",
    label: "Grande"
  });
  // registerBlockStyle('core/quote', {
  //   name: `fdp-uno`,
  //   label: `FDP Uno`,
  // });

  // registerBlockStyle('core/quote', {
  //   name: `fdp-dos`,
  //   label: `FDP dos`,
  // });

  // registerBlockStyle('core/quote', {
  //   name: `fdp-tres`,
  //   label: `FDP Tres`,
  // });
  // registerBlockStyle('core/paragraph', {
  //   name: `fdp-paragraph-dos`,
  //   label: `FDP Parrafo Dos`,
  // });
  // registerBlockStyle('core/heading', {
  //   name: `fdp-heading`,
  //   label: `FDP Heading`,
  // });

  // registerBlockStyle('core/heading', {
  //   name: `fdp-heading-dos`,
  //   label: `Heading Dos`,
  // });

  // registerBlockStyle('core/heading', {
  //   name: `fdp-heading-logo`,
  //   label: `Heading Logo`,
  // });
  // registerBlockStyle('core/image', {
  //   name: `fdp-image`,
  //   label: `FDP Imagen`,
  // });
});

/**
 * // Internal dependencies.
import SeparatorIconControl from './control-icon';

// WordPress dependencies.
import { BlockControls } from '@wordpress/block-editor';
import { addFilter } from '@wordpress/hooks';

const withSeparatorIcons = BlockEdit => props => {
  return 'core/separator' === props.name ? (
    <>
      <BlockEdit {...props} />
      <BlockControls group="other">
        <SeparatorIconControl
          attributes={props.attributes}
          setAttributes={props.setAttributes}
        />
      </BlockControls>
    </>
  ) : (
    <BlockEdit {...props} />
  );
};

addFilter('editor.BlockEdit', 'theme-slug/separator-icons', withSeparatorIcons);

 */
/******/ })()
;
//# sourceMappingURL=editor.js.map