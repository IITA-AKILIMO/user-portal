/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************!*\
  !*** ./src/frontend.js ***!
  \*************************/
window.createKBSlides = function (id) {
  var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  if (window.jQuery && jQuery().slick !== undefined) {
    jQuery(function ($) {
      $(".kb-slides-".concat(id, " .kb-slides-inner-container")).slick(Object.assign({
        appendDots: ".kb-slides-".concat(id, " .kb-slides-dots"),
        customPaging: function customPaging(slider, i) {
          return '<span class="kb-slide-dot"></span>';
        }
      }, options));
    });
  }
};
/******/ })()
;