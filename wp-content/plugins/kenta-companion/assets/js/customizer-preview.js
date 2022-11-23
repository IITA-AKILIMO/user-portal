/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/extensions/cookies-consent.js":
/*!****************************************************!*\
  !*** ./resources/js/extensions/cookies-consent.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var js_cookie__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! js-cookie */ "./node_modules/js-cookie/dist/js.cookie.mjs");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }



var CookiesConsent = /*#__PURE__*/function () {
  function CookiesConsent($) {
    var _this = this;

    var timeout = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 800;

    _classCallCheck(this, CookiesConsent);

    var $cookiesConsentModal = $('.kenta-cookies-consent-container');

    if ($cookiesConsentModal.length <= 0) {
      return;
    }

    if (js_cookie__WEBPACK_IMPORTED_MODULE_0__["default"].get('kenta_cookies_consent_accepted')) {
      $cookiesConsentModal.remove();
      return;
    }

    setTimeout(function () {
      $cookiesConsentModal.addClass('active');
    }, timeout);
    $cookiesConsentModal.find('.accept-button').on('click', function (ev) {
      ev.preventDefault();

      var period = _this.getPeriod($cookiesConsentModal.data('period'));

      js_cookie__WEBPACK_IMPORTED_MODULE_0__["default"].set('kenta_cookies_consent_accepted', 'true', {
        expires: new Date(new Date() * 1 + period),
        sameSite: 'lax'
      });
      $cookiesConsentModal.removeClass('active');
      setTimeout(function () {
        $cookiesConsentModal.remove();
      }, 500);
    });
    $cookiesConsentModal.find('.decline-button').on('click', function (ev) {
      ev.preventDefault();

      var period = _this.getPeriod($cookiesConsentModal.data('period'));

      js_cookie__WEBPACK_IMPORTED_MODULE_0__["default"].set('kenta_cookies_consent_accepted', 'no', {
        expires: new Date(new Date() * 1 + period),
        sameSite: 'lax'
      });
      $cookiesConsentModal.removeClass('active');
      setTimeout(function () {
        $cookiesConsentModal.remove();
      }, 500);
    });
  }

  _createClass(CookiesConsent, [{
    key: "getPeriod",
    value: function getPeriod(period) {
      var periods = {
        onehour: 36e5,
        oneday: 864e5,
        oneweek: 7 * 864e5,
        onemonth: 31 * 864e5,
        threemonths: 3 * 31 * 864e5,
        sixmonths: 6 * 31 * 864e5,
        oneyear: 365 * 864e5,
        forever: 10000 * 864e5
      };
      return periods[period];
    }
  }]);

  return CookiesConsent;
}();

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CookiesConsent);

/***/ }),

/***/ "./resources/js/extensions/datetime.js":
/*!*********************************************!*\
  !*** ./resources/js/extensions/datetime.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Datetime = /*#__PURE__*/_createClass(function Datetime($) {
  _classCallCheck(this, Datetime);

  $('.kenta-local-time').each(function () {
    var format = $(this).data('time-format');
    $(this).text(new Date().format(format));
  });
});

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Datetime);

/***/ }),

/***/ "./resources/js/extensions/infinite-scroll.js":
/*!****************************************************!*\
  !*** ./resources/js/extensions/infinite-scroll.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var InfiniteScroll = /*#__PURE__*/_createClass(function InfiniteScroll($) {
  _classCallCheck(this, InfiniteScroll);

  var $pagination = $('.kenta-infinite-scroll');
  var $posts = $('.kenta-posts .card-list');

  if (!window.InfiniteScroll || $posts.length <= 0 || $pagination.length <= 0) {
    return;
  }

  var pagination_type = $pagination.data('pagination-type');
  var pagination_max_pages = $pagination.data('pagination-max-pages');
  var threshold = false;
  var navClass = false;
  var scopeClass = '.kenta-posts';

  if ('infinite-scroll' === pagination_type) {
    threshold = 300;
    navClass = scopeClass + ' .kenta-load-more-btn';
  }

  $posts.infiniteScroll({
    path: scopeClass + ' .kenta-pagination a',
    hideNav: navClass,
    append: false,
    history: false,
    scrollThreshold: threshold,
    status: scopeClass + ' .page-load-status'
  });
  var pagesLoaded = 0; // Request

  $posts.on('request.infiniteScroll', function (event, path) {
    $pagination.find('.kenta-load-more-btn').hide();

    if (pagination_max_pages - 1 !== pagesLoaded) {
      $pagination.find('.kenta-pagination-loader').show();
    }
  }); // Load

  $posts.on('load.infiniteScroll', function (event, response) {
    pagesLoaded++; // get posts from response

    var items = $(response).find(scopeClass).find('.card-wrapper');
    $posts.infiniteScroll('appendItems', items);

    if ($posts.masonry) {
      $posts.masonry('appended', items);
    }

    if (window.ScrollReveal) ScrollReveal().sync();

    if (pagination_max_pages - 1 !== pagesLoaded) {
      if ('load-more' === pagination_type) {
        $pagination.find('.kenta-load-more-btn').fadeIn();
      }
    } else {
      $pagination.find('.kenta-pagination-finish').fadeIn(1000); // $pagination.delay(2000).fadeOut(1000);
    }

    $pagination.find('.kenta-pagination-loader').hide();
  }); // Load more click

  $pagination.find('.kenta-load-more-btn').on('click', function () {
    $posts.infiniteScroll('loadNextPage');
    return false;
  });
});

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (InfiniteScroll);

/***/ }),

/***/ "./resources/js/extensions/masonry.js":
/*!********************************************!*\
  !*** ./resources/js/extensions/masonry.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Masonry = /*#__PURE__*/_createClass(function Masonry($) {
  _classCallCheck(this, Masonry);

  var $cardList = $('.card-list');

  if ($cardList.data('card-layout') === 'archive-masonry' && $cardList.masonry) {
    $cardList.masonry({
      itemSelector: '.card-wrapper'
    });
  }
});

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Masonry);

/***/ }),

/***/ "./node_modules/js-cookie/dist/js.cookie.mjs":
/*!***************************************************!*\
  !*** ./node_modules/js-cookie/dist/js.cookie.mjs ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/*! js-cookie v3.0.1 | MIT */
/* eslint-disable no-var */
function assign (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];
    for (var key in source) {
      target[key] = source[key];
    }
  }
  return target
}
/* eslint-enable no-var */

/* eslint-disable no-var */
var defaultConverter = {
  read: function (value) {
    if (value[0] === '"') {
      value = value.slice(1, -1);
    }
    return value.replace(/(%[\dA-F]{2})+/gi, decodeURIComponent)
  },
  write: function (value) {
    return encodeURIComponent(value).replace(
      /%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g,
      decodeURIComponent
    )
  }
};
/* eslint-enable no-var */

/* eslint-disable no-var */

function init (converter, defaultAttributes) {
  function set (key, value, attributes) {
    if (typeof document === 'undefined') {
      return
    }

    attributes = assign({}, defaultAttributes, attributes);

    if (typeof attributes.expires === 'number') {
      attributes.expires = new Date(Date.now() + attributes.expires * 864e5);
    }
    if (attributes.expires) {
      attributes.expires = attributes.expires.toUTCString();
    }

    key = encodeURIComponent(key)
      .replace(/%(2[346B]|5E|60|7C)/g, decodeURIComponent)
      .replace(/[()]/g, escape);

    var stringifiedAttributes = '';
    for (var attributeName in attributes) {
      if (!attributes[attributeName]) {
        continue
      }

      stringifiedAttributes += '; ' + attributeName;

      if (attributes[attributeName] === true) {
        continue
      }

      // Considers RFC 6265 section 5.2:
      // ...
      // 3.  If the remaining unparsed-attributes contains a %x3B (";")
      //     character:
      // Consume the characters of the unparsed-attributes up to,
      // not including, the first %x3B (";") character.
      // ...
      stringifiedAttributes += '=' + attributes[attributeName].split(';')[0];
    }

    return (document.cookie =
      key + '=' + converter.write(value, key) + stringifiedAttributes)
  }

  function get (key) {
    if (typeof document === 'undefined' || (arguments.length && !key)) {
      return
    }

    // To prevent the for loop in the first place assign an empty array
    // in case there are no cookies at all.
    var cookies = document.cookie ? document.cookie.split('; ') : [];
    var jar = {};
    for (var i = 0; i < cookies.length; i++) {
      var parts = cookies[i].split('=');
      var value = parts.slice(1).join('=');

      try {
        var foundKey = decodeURIComponent(parts[0]);
        jar[foundKey] = converter.read(value, foundKey);

        if (key === foundKey) {
          break
        }
      } catch (e) {}
    }

    return key ? jar[key] : jar
  }

  return Object.create(
    {
      set: set,
      get: get,
      remove: function (key, attributes) {
        set(
          key,
          '',
          assign({}, attributes, {
            expires: -1
          })
        );
      },
      withAttributes: function (attributes) {
        return init(this.converter, assign({}, this.attributes, attributes))
      },
      withConverter: function (converter) {
        return init(assign({}, this.converter, converter), this.attributes)
      }
    },
    {
      attributes: { value: Object.freeze(defaultAttributes) },
      converter: { value: Object.freeze(converter) }
    }
  )
}

var api = init(defaultConverter, { path: '/' });
/* eslint-enable no-var */

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (api);


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
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!********************************************!*\
  !*** ./resources/js/customizer-preview.js ***!
  \********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _extensions_cookies_consent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./extensions/cookies-consent */ "./resources/js/extensions/cookies-consent.js");
/* harmony import */ var _extensions_masonry__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./extensions/masonry */ "./resources/js/extensions/masonry.js");
/* harmony import */ var _extensions_infinite_scroll__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./extensions/infinite-scroll */ "./resources/js/extensions/infinite-scroll.js");
/* harmony import */ var _extensions_datetime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./extensions/datetime */ "./resources/js/extensions/datetime.js");





if (wp.customize && wp.customize.selectiveRefresh) {
  wp.customize.selectiveRefresh.bind('partial-content-rendered', function () {
    new _extensions_datetime__WEBPACK_IMPORTED_MODULE_3__["default"](jQuery);
    new _extensions_cookies_consent__WEBPACK_IMPORTED_MODULE_0__["default"](jQuery, 0);
    new _extensions_masonry__WEBPACK_IMPORTED_MODULE_1__["default"](jQuery);
    new _extensions_infinite_scroll__WEBPACK_IMPORTED_MODULE_2__["default"](jQuery);
  });
}
})();

/******/ })()
;