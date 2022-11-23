(() => {
    "use strict";
    var __webpack_modules__ = {
        54: (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: () => __WEBPACK_DEFAULT_EXPORT__
            });
            var NoticeDismiss = {
                init: function init($) {
                    $(".kenta-theme-notice .kenta-notice-dismiss").click((function() {
                        var $notice = $(this).parents(".notice.is-dismissible");
                        var dismiss_url = $notice.attr("data-dismiss-url");
                        if (dismiss_url) {
                            $.ajax({
                                url: dismiss_url,
                                complete: function complete() {
                                    $notice.hide();
                                }
                            });
                        }
                    }));
                }
            };
            const __WEBPACK_DEFAULT_EXPORT__ = NoticeDismiss;
        }
    };
    var __webpack_module_cache__ = {};
    function __webpack_require__(moduleId) {
        var cachedModule = __webpack_module_cache__[moduleId];
        if (cachedModule !== undefined) {
            return cachedModule.exports;
        }
        var module = __webpack_module_cache__[moduleId] = {
            exports: {}
        };
        __webpack_modules__[moduleId](module, module.exports, __webpack_require__);
        return module.exports;
    }
    (() => {
        __webpack_require__.d = (exports, definition) => {
            for (var key in definition) {
                if (__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
                    Object.defineProperty(exports, key, {
                        enumerable: true,
                        get: definition[key]
                    });
                }
            }
        };
    })();
    (() => {
        __webpack_require__.o = (obj, prop) => Object.prototype.hasOwnProperty.call(obj, prop);
    })();
    (() => {
        __webpack_require__.r = exports => {
            if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
                Object.defineProperty(exports, Symbol.toStringTag, {
                    value: "Module"
                });
            }
            Object.defineProperty(exports, "__esModule", {
                value: true
            });
        };
    })();
    var __webpack_exports__ = {};
    (() => {
        __webpack_require__.r(__webpack_exports__);
        var _admin_dismiss_notices__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(54);
        jQuery((function($) {
            _admin_dismiss_notices__WEBPACK_IMPORTED_MODULE_0__["default"].init($);
        }));
    })();
})();