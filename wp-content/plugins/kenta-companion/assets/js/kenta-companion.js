/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/date-format.js":
/*!*************************************!*\
  !*** ./resources/js/date-format.js ***!
  \*************************************/
/***/ (function() {

(function () {
  // Defining locale
  Date.shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  Date.longMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  Date.shortDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  Date.longDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; // Defining patterns

  var replaceChars = {
    // Day
    d: function d() {
      var d = this.getDate();
      return (d < 10 ? '0' : '') + d;
    },
    D: function D() {
      return Date.shortDays[this.getDay()];
    },
    j: function j() {
      return this.getDate();
    },
    l: function l() {
      return Date.longDays[this.getDay()];
    },
    N: function N() {
      var N = this.getDay();
      return N === 0 ? 7 : N;
    },
    S: function S() {
      var S = this.getDate();
      return S % 10 === 1 && S !== 11 ? 'st' : S % 10 === 2 && S !== 12 ? 'nd' : S % 10 === 3 && S !== 13 ? 'rd' : 'th';
    },
    w: function w() {
      return this.getDay();
    },
    z: function z() {
      var d = new Date(this.getFullYear(), 0, 1);
      return Math.ceil((this - d) / 86400000);
    },
    // Week
    W: function W() {
      var target = new Date(this.valueOf());
      var dayNr = (this.getDay() + 6) % 7;
      target.setDate(target.getDate() - dayNr + 3);
      var firstThursday = target.valueOf();
      target.setMonth(0, 1);

      if (target.getDay() !== 4) {
        target.setMonth(0, 1 + (4 - target.getDay() + 7) % 7);
      }

      var retVal = 1 + Math.ceil((firstThursday - target) / 604800000);
      return retVal < 10 ? '0' + retVal : retVal;
    },
    // Month
    F: function F() {
      return Date.longMonths[this.getMonth()];
    },
    m: function m() {
      var m = this.getMonth();
      return (m < 9 ? '0' : '') + (m + 1);
    },
    M: function M() {
      return Date.shortMonths[this.getMonth()];
    },
    n: function n() {
      return this.getMonth() + 1;
    },
    t: function t() {
      var year = this.getFullYear();
      var nextMonth = this.getMonth() + 1;

      if (nextMonth === 12) {
        year = year++;
        nextMonth = 0;
      }

      return new Date(year, nextMonth, 0).getDate();
    },
    // Year
    L: function L() {
      var L = this.getFullYear();
      return L % 400 === 0 || L % 100 !== 0 && L % 4 === 0;
    },
    o: function o() {
      var d = new Date(this.valueOf());
      d.setDate(d.getDate() - (this.getDay() + 6) % 7 + 3);
      return d.getFullYear();
    },
    Y: function Y() {
      return this.getFullYear();
    },
    y: function y() {
      return ('' + this.getFullYear()).substr(2);
    },
    // Time
    a: function a() {
      return this.getHours() < 12 ? 'am' : 'pm';
    },
    A: function A() {
      return this.getHours() < 12 ? 'AM' : 'PM';
    },
    B: function B() {
      return Math.floor(((this.getUTCHours() + 1) % 24 + this.getUTCMinutes() / 60 + this.getUTCSeconds() / 3600) * 1000 / 24);
    },
    g: function g() {
      return this.getHours() % 12 || 12;
    },
    G: function G() {
      return this.getHours();
    },
    h: function h() {
      var h = this.getHours();
      return ((h % 12 || 12) < 10 ? '0' : '') + (h % 12 || 12);
    },
    H: function H() {
      var H = this.getHours();
      return (H < 10 ? '0' : '') + H;
    },
    i: function i() {
      var i = this.getMinutes();
      return (i < 10 ? '0' : '') + i;
    },
    s: function s() {
      var s = this.getSeconds();
      return (s < 10 ? '0' : '') + s;
    },
    v: function v() {
      var v = this.getMilliseconds();
      return (v < 10 ? '00' : v < 100 ? '0' : '') + v;
    },
    // Timezone
    e: function e() {
      return Intl.DateTimeFormat().resolvedOptions().timeZone;
    },
    I: function I() {
      var DST = null;

      for (var i = 0; i < 12; ++i) {
        var d = new Date(this.getFullYear(), i, 1);
        var offset = d.getTimezoneOffset();
        if (DST === null) DST = offset;else if (offset < DST) {
          DST = offset;
          break;
        } else if (offset > DST) break;
      }

      return this.getTimezoneOffset() === DST | 0;
    },
    O: function O() {
      var O = this.getTimezoneOffset();
      return (-O < 0 ? '-' : '+') + (Math.abs(O / 60) < 10 ? '0' : '') + Math.floor(Math.abs(O / 60)) + (Math.abs(O % 60) === 0 ? '00' : (Math.abs(O % 60) < 10 ? '0' : '') + Math.abs(O % 60));
    },
    P: function P() {
      var P = this.getTimezoneOffset();
      return (-P < 0 ? '-' : '+') + (Math.abs(P / 60) < 10 ? '0' : '') + Math.floor(Math.abs(P / 60)) + ':' + (Math.abs(P % 60) === 0 ? '00' : (Math.abs(P % 60) < 10 ? '0' : '') + Math.abs(P % 60));
    },
    T: function T() {
      var tz = this.toLocaleTimeString(navigator.language, {
        timeZoneName: 'short'
      }).split(' ');
      return tz[tz.length - 1];
    },
    Z: function Z() {
      return -this.getTimezoneOffset() * 60;
    },
    // Full Date/Time
    c: function c() {
      return this.format('Y-m-d\\TH:i:sP');
    },
    r: function r() {
      return this.toString();
    },
    U: function U() {
      return Math.floor(this.getTime() / 1000);
    }
  }; // Simulates PHP's date function

  Date.prototype.format = function (format) {
    var date = this;
    return format.replace(/(\\?)(.)/g, function (_, esc, chr) {
      return esc === '' && replaceChars[chr] ? replaceChars[chr].call(date) : chr;
    });
  };
}).call(this);

/***/ }),

/***/ "./resources/js/extensions/cookies-consent.js":
/*!****************************************************!*\
  !*** ./resources/js/extensions/cookies-consent.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

"use strict";
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

/***/ "./resources/js/extensions/magnific-popup.js":
/*!***************************************************!*\
  !*** ./resources/js/extensions/magnific-popup.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var MagnificPopup = /*#__PURE__*/_createClass(function MagnificPopup($) {
  _classCallCheck(this, MagnificPopup);

  // Check for magnific popup plugin
  if ($.magnificPopup === undefined) {
    return;
  }

  $('.kenta-lightbox *:not(.no-lightbox) > img').css('cursor', 'zoom-in');
  $('.kenta-lightbox').magnificPopup({
    delegate: '*:not(.no-lightbox) > img',
    type: 'image',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      arrowMarkup: '<button title="%title%" type="button" class="kenta-mfp-arrow kenta-mfp-arrow-%dir%"></button>',
      tPrev: 'Previous',
      tNext: 'Next',
      tCounter: '%curr% of %total%'
    },
    closeOnContentClick: true,
    fixedContentPos: true,
    fixedBgPos: true,
    overflowY: 'auto',
    removalDelay: 300,
    mainClass: 'kenta-popup-zoom-in',
    callbacks: {
      elementParse: function elementParse(item) {
        item.src = item.el.attr('src');
      }
    }
  });
});

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (MagnificPopup);

/***/ }),

/***/ "./resources/js/extensions/masonry.js":
/*!********************************************!*\
  !*** ./resources/js/extensions/masonry.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

/***/ "./resources/js/kenta-companion.js":
/*!*****************************************!*\
  !*** ./resources/js/kenta-companion.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _date_format__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./date-format */ "./resources/js/date-format.js");
/* harmony import */ var _date_format__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_date_format__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _extensions_cookies_consent__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./extensions/cookies-consent */ "./resources/js/extensions/cookies-consent.js");
/* harmony import */ var _extensions_masonry__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./extensions/masonry */ "./resources/js/extensions/masonry.js");
/* harmony import */ var _extensions_infinite_scroll__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./extensions/infinite-scroll */ "./resources/js/extensions/infinite-scroll.js");
/* harmony import */ var _extensions_datetime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./extensions/datetime */ "./resources/js/extensions/datetime.js");
/* harmony import */ var _extensions_magnific_popup__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./extensions/magnific-popup */ "./resources/js/extensions/magnific-popup.js");






jQuery(document).ready(function ($) {
  'use strict';

  new _extensions_datetime__WEBPACK_IMPORTED_MODULE_4__["default"]($);
  new _extensions_masonry__WEBPACK_IMPORTED_MODULE_2__["default"]($);
  new _extensions_cookies_consent__WEBPACK_IMPORTED_MODULE_1__["default"]($);
  new _extensions_infinite_scroll__WEBPACK_IMPORTED_MODULE_3__["default"]($);
  new _extensions_magnific_popup__WEBPACK_IMPORTED_MODULE_5__["default"]($);
});

/***/ }),

/***/ "./resources/scss/kenta-companion.scss":
/*!*********************************************!*\
  !*** ./resources/scss/kenta-companion.scss ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/kenta-admin.scss":
/*!*****************************************!*\
  !*** ./resources/scss/kenta-admin.scss ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/js-cookie/dist/js.cookie.mjs":
/*!***************************************************!*\
  !*** ./node_modules/js-cookie/dist/js.cookie.mjs ***!
  \***************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

"use strict";
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
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/kenta-companion": 0,
/******/ 			"css/kenta-admin": 0,
/******/ 			"css/kenta-companion": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkkenta_companion"] = self["webpackChunkkenta_companion"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/kenta-admin","css/kenta-companion"], () => (__webpack_require__("./resources/js/kenta-companion.js")))
/******/ 	__webpack_require__.O(undefined, ["css/kenta-admin","css/kenta-companion"], () => (__webpack_require__("./resources/scss/kenta-companion.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/kenta-admin","css/kenta-companion"], () => (__webpack_require__("./resources/scss/kenta-admin.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;