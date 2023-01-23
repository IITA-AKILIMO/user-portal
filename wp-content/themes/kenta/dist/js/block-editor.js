(() => {
    var __webpack_modules__ = [ , , , , , , , , , , , , , , , , , module => {
        "use strict";
        module.exports = window.wp.plugins;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => __WEBPACK_DEFAULT_EXPORT__
        });
        var html_react_parser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(19);
        var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(38);
        var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1___default = __webpack_require__.n(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__);
        var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(39);
        var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2___default = __webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__);
        var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(40);
        var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = __webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
        var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(41);
        var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = __webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
        var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(42);
        var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(54);
        function ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
                var symbols = Object.getOwnPropertySymbols(object);
                enumerableOnly && (symbols = symbols.filter((function(sym) {
                    return Object.getOwnPropertyDescriptor(object, sym).enumerable;
                }))), keys.push.apply(keys, symbols);
            }
            return keys;
        }
        function _objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = null != arguments[i] ? arguments[i] : {};
                i % 2 ? ownKeys(Object(source), !0).forEach((function(key) {
                    _defineProperty(target, key, source[key]);
                })) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach((function(key) {
                    Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
                }));
            }
            return target;
        }
        function _defineProperty(obj, key, value) {
            if (key in obj) {
                Object.defineProperty(obj, key, {
                    value,
                    enumerable: true,
                    configurable: true,
                    writable: true
                });
            } else {
                obj[key] = value;
            }
            return obj;
        }
        var MetaSettings = function MetaSettings(props) {
            var icon = (0, html_react_parser__WEBPACK_IMPORTED_MODULE_0__["default"])('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 500 500"><defs><style>.a{clip-path:url(#b);}</style><clipPath id="b"><rect width="500" height="500"/></clipPath></defs><g id="a" class="a"><path d="M-919,442a222.636,222.636,0,0,1-44.539-4.49,219.894,219.894,0,0,1-41.484-12.877,221.03,221.03,0,0,1-37.54-20.376,222.592,222.592,0,0,1-32.707-26.986,222.588,222.588,0,0,1-26.986-32.707,221.021,221.021,0,0,1-20.376-37.54,219.889,219.889,0,0,1-12.877-41.484A222.623,222.623,0,0,1-1140,221a222.626,222.626,0,0,1,4.49-44.539,219.894,219.894,0,0,1,12.877-41.484,221.023,221.023,0,0,1,20.376-37.54,222.6,222.6,0,0,1,26.986-32.707,222.6,222.6,0,0,1,32.707-26.986,221.027,221.027,0,0,1,37.54-20.376A219.9,219.9,0,0,1-963.539,4.49,222.636,222.636,0,0,1-919,0a222.635,222.635,0,0,1,44.539,4.49,219.892,219.892,0,0,1,41.484,12.877,221.016,221.016,0,0,1,37.54,20.376,222.586,222.586,0,0,1,32.707,26.986,222.594,222.594,0,0,1,26.986,32.707,221.026,221.026,0,0,1,20.376,37.54,219.889,219.889,0,0,1,12.877,41.484A222.637,222.637,0,0,1-698,221a222.634,222.634,0,0,1-4.49,44.539,219.887,219.887,0,0,1-12.877,41.484,221.024,221.024,0,0,1-20.376,37.54,222.585,222.585,0,0,1-26.986,32.707,222.581,222.581,0,0,1-32.707,26.986,221.019,221.019,0,0,1-37.54,20.376,219.9,219.9,0,0,1-41.484,12.877A222.635,222.635,0,0,1-919,442Zm.815-205.737,35.9,70.056h64.828l-64.828-106.071L-820.246,136h-69.94l-55.185,64.364V136H-998V306.319h52.629V264.727l27.185-28.463Z" transform="translate(1169 29)"/></g></svg>');
            return (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.Fragment, {
                children: [ (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__.PluginSidebarMoreMenuItem, {
                    target: "kenta-theme-meta-panel",
                    icon,
                    children: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Kenta Settings", "kenta")
                }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__.PluginSidebar, {
                    isPinnable: true,
                    icon,
                    name: "kenta-theme-meta-panel",
                    title: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Kenta Settings", "kenta"),
                    children: (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)("div", {
                        className: "kenta-sidebar-container",
                        children: [ (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
                            title: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Layout", "kenta"),
                            initialOpen: true,
                            children: [ (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Container Style", "kenta"),
                                value: props.meta["site-container-style"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Boxed", "kenta"),
                                    value: "boxed"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Fluid", "kenta"),
                                    value: "fluid"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "site-container-style");
                                }
                            }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Content Width", "kenta"),
                                value: props.meta["site-container-layout"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Narrow", "kenta"),
                                    value: "narrow"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Normal", "kenta"),
                                    value: "normal"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "site-container-layout");
                                }
                            }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Sidebar Layout", "kenta"),
                                value: props.meta["site-sidebar-layout"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("No Sidebar", "kenta"),
                                    value: "no-sidebar"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Left Sidebar", "kenta"),
                                    value: "left-sidebar"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Right Sidebar", "kenta"),
                                    value: "right-sidebar"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "site-sidebar-layout");
                                }
                            }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Transparent Header", "kenta"),
                                value: props.meta["site-transparent-header"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Enable", "kenta"),
                                    value: "enable"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Disable", "kenta"),
                                    value: "disable"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "site-transparent-header");
                                }
                            }) ]
                        }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
                            title: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Elements", "kenta"),
                            initialOpen: true,
                            children: [ (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Site Header", "kenta"),
                                value: props.meta["disable-site-header"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Enable", "kenta"),
                                    value: "no"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Disable", "kenta"),
                                    value: "yes"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "disable-site-header");
                                }
                            }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Site Footer", "kenta"),
                                value: props.meta["disable-site-footer"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Enable", "kenta"),
                                    value: "no"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Disable", "kenta"),
                                    value: "yes"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "disable-site-footer");
                                }
                            }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Article Header", "kenta"),
                                value: props.meta["disable-article-header"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Enable", "kenta"),
                                    value: "no"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Disable", "kenta"),
                                    value: "yes"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "disable-article-header");
                                }
                            }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
                                label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Content Spacing", "kenta"),
                                value: props.meta["disable-content-area-spacing"],
                                options: [ {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Inherit", "kenta"),
                                    value: "default"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Enable", "kenta"),
                                    value: "no"
                                }, {
                                    label: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Disable", "kenta"),
                                    value: "yes"
                                } ],
                                onChange: function onChange(value) {
                                    props.setMetaFieldValue(value, "disable-content-area-spacing");
                                }
                            }) ]
                        }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)("div", {
                            style: {
                                textAlign: "center",
                                padding: "16px"
                            },
                            children: [ (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)("p", {
                                children: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("You can override the global customize settings for individual pages or posts here.", "kenta")
                            }), (0, react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)("a", {
                                href: "https://kentatheme.com/docs/kenta-theme/general/editor-sidebar-settings/",
                                target: "_blank",
                                children: (0, _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)("Learn More")
                            }) ]
                        }) ]
                    })
                }) ]
            });
        };
        const __WEBPACK_DEFAULT_EXPORT__ = (0, _wordpress_compose__WEBPACK_IMPORTED_MODULE_2__.compose)((0, 
        _wordpress_data__WEBPACK_IMPORTED_MODULE_4__.withSelect)((function(select) {
            var postMeta = select("core/editor").getEditedPostAttribute("meta");
            var oldPostMeta = select("core/editor").getCurrentPostAttribute("meta");
            return {
                meta: _objectSpread(_objectSpread({}, oldPostMeta), postMeta),
                oldMeta: oldPostMeta
            };
        })), (0, _wordpress_data__WEBPACK_IMPORTED_MODULE_4__.withDispatch)((function(dispatch) {
            return {
                setMetaFieldValue: function setMetaFieldValue(value, field) {
                    return dispatch("core/editor").editPost({
                        meta: _defineProperty({}, field, value)
                    });
                }
            };
        })))(MetaSettings);
    }, (__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            Element: () => Element,
            attributesToProps: () => attributesToProps,
            default: () => __WEBPACK_DEFAULT_EXPORT__,
            domToReact: () => domToReact,
            htmlToDOM: () => htmlToDOM
        });
        var _index_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(20);
        var domToReact = _index_js__WEBPACK_IMPORTED_MODULE_0__.domToReact;
        var htmlToDOM = _index_js__WEBPACK_IMPORTED_MODULE_0__.htmlToDOM;
        var attributesToProps = _index_js__WEBPACK_IMPORTED_MODULE_0__.attributesToProps;
        var Element = _index_js__WEBPACK_IMPORTED_MODULE_0__.Element;
        const __WEBPACK_DEFAULT_EXPORT__ = _index_js__WEBPACK_IMPORTED_MODULE_0__;
    }, (module, __unused_webpack_exports, __webpack_require__) => {
        var domToReact = __webpack_require__(21);
        var attributesToProps = __webpack_require__(23);
        var htmlToDOM = __webpack_require__(31);
        htmlToDOM = typeof htmlToDOM.default === "function" ? htmlToDOM.default : htmlToDOM;
        var domParserOptions = {
            lowerCaseAttributeNames: false
        };
        function HTMLReactParser(html, options) {
            if (typeof html !== "string") {
                throw new TypeError("First argument must be a string");
            }
            if (html === "") {
                return [];
            }
            options = options || {};
            return domToReact(htmlToDOM(html, options.htmlparser2 || domParserOptions), options);
        }
        HTMLReactParser.domToReact = domToReact;
        HTMLReactParser.htmlToDOM = htmlToDOM;
        HTMLReactParser.attributesToProps = attributesToProps;
        HTMLReactParser.Element = __webpack_require__(34).Element;
        module.exports = HTMLReactParser;
        module.exports["default"] = HTMLReactParser;
    }, (module, __unused_webpack_exports, __webpack_require__) => {
        var React = __webpack_require__(22);
        var attributesToProps = __webpack_require__(23);
        var utilities = __webpack_require__(26);
        var setStyleProp = utilities.setStyleProp;
        var canTextBeChildOfNode = utilities.canTextBeChildOfNode;
        function domToReact(nodes, options) {
            options = options || {};
            var library = options.library || React;
            var cloneElement = library.cloneElement;
            var createElement = library.createElement;
            var isValidElement = library.isValidElement;
            var result = [];
            var node;
            var isWhitespace;
            var hasReplace = typeof options.replace === "function";
            var replaceElement;
            var props;
            var children;
            var trim = options.trim;
            for (var i = 0, len = nodes.length; i < len; i++) {
                node = nodes[i];
                if (hasReplace) {
                    replaceElement = options.replace(node);
                    if (isValidElement(replaceElement)) {
                        if (len > 1) {
                            replaceElement = cloneElement(replaceElement, {
                                key: replaceElement.key || i
                            });
                        }
                        result.push(replaceElement);
                        continue;
                    }
                }
                if (node.type === "text") {
                    isWhitespace = !node.data.trim().length;
                    if (isWhitespace && node.parent && !canTextBeChildOfNode(node.parent)) {
                        continue;
                    }
                    if (trim && isWhitespace) {
                        continue;
                    }
                    result.push(node.data);
                    continue;
                }
                props = node.attribs;
                if (skipAttributesToProps(node)) {
                    setStyleProp(props.style, props);
                } else if (props) {
                    props = attributesToProps(props);
                }
                children = null;
                switch (node.type) {
                  case "script":
                  case "style":
                    if (node.children[0]) {
                        props.dangerouslySetInnerHTML = {
                            __html: node.children[0].data
                        };
                    }
                    break;

                  case "tag":
                    if (node.name === "textarea" && node.children[0]) {
                        props.defaultValue = node.children[0].data;
                    } else if (node.children && node.children.length) {
                        children = domToReact(node.children, options);
                    }
                    break;

                  default:
                    continue;
                }
                if (len > 1) {
                    props.key = i;
                }
                result.push(createElement(node.name, props, children));
            }
            return result.length === 1 ? result[0] : result;
        }
        function skipAttributesToProps(node) {
            return utilities.PRESERVE_CUSTOM_ATTRIBUTES && node.type === "tag" && utilities.isCustomComponent(node.name, node.attribs);
        }
        module.exports = domToReact;
    }, module => {
        "use strict";
        module.exports = React;
    }, (module, __unused_webpack_exports, __webpack_require__) => {
        var reactProperty = __webpack_require__(24);
        var utilities = __webpack_require__(26);
        module.exports = function attributesToProps(attributes) {
            attributes = attributes || {};
            var valueOnlyInputs = {
                reset: true,
                submit: true
            };
            var attributeName;
            var attributeNameLowerCased;
            var attributeValue;
            var propName;
            var propertyInfo;
            var props = {};
            var inputIsValueOnly = attributes.type && valueOnlyInputs[attributes.type];
            for (attributeName in attributes) {
                attributeValue = attributes[attributeName];
                if (reactProperty.isCustomAttribute(attributeName)) {
                    props[attributeName] = attributeValue;
                    continue;
                }
                attributeNameLowerCased = attributeName.toLowerCase();
                propName = getPropName(attributeNameLowerCased);
                if (propName) {
                    propertyInfo = reactProperty.getPropertyInfo(propName);
                    if ((propName === "checked" || propName === "value") && !inputIsValueOnly) {
                        propName = getPropName("default" + attributeNameLowerCased);
                    }
                    props[propName] = attributeValue;
                    switch (propertyInfo && propertyInfo.type) {
                      case reactProperty.BOOLEAN:
                        props[propName] = true;
                        break;

                      case reactProperty.OVERLOADED_BOOLEAN:
                        if (attributeValue === "") {
                            props[propName] = true;
                        }
                        break;
                    }
                    continue;
                }
                if (utilities.PRESERVE_CUSTOM_ATTRIBUTES) {
                    props[attributeName] = attributeValue;
                }
            }
            utilities.setStyleProp(attributes.style, props);
            return props;
        };
        function getPropName(attributeName) {
            return reactProperty.possibleStandardNames[attributeName];
        }
    }, (__unused_webpack_module, exports, __webpack_require__) => {
        "use strict";
        Object.defineProperty(exports, "__esModule", {
            value: true
        });
        function _slicedToArray(arr, i) {
            return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
        }
        function _arrayWithHoles(arr) {
            if (Array.isArray(arr)) return arr;
        }
        function _iterableToArrayLimit(arr, i) {
            var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"];
            if (_i == null) return;
            var _arr = [];
            var _n = true;
            var _d = false;
            var _s, _e;
            try {
                for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
                    _arr.push(_s.value);
                    if (i && _arr.length === i) break;
                }
            } catch (err) {
                _d = true;
                _e = err;
            } finally {
                try {
                    if (!_n && _i["return"] != null) _i["return"]();
                } finally {
                    if (_d) throw _e;
                }
            }
            return _arr;
        }
        function _unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === "string") return _arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === "Object" && o.constructor) n = o.constructor.name;
            if (n === "Map" || n === "Set") return Array.from(o);
            if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
        }
        function _arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
            return arr2;
        }
        function _nonIterableRest() {
            throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
        }
        var RESERVED = 0;
        var STRING = 1;
        var BOOLEANISH_STRING = 2;
        var BOOLEAN = 3;
        var OVERLOADED_BOOLEAN = 4;
        var NUMERIC = 5;
        var POSITIVE_NUMERIC = 6;
        function getPropertyInfo(name) {
            return properties.hasOwnProperty(name) ? properties[name] : null;
        }
        function PropertyInfoRecord(name, type, mustUseProperty, attributeName, attributeNamespace, sanitizeURL, removeEmptyString) {
            this.acceptsBooleans = type === BOOLEANISH_STRING || type === BOOLEAN || type === OVERLOADED_BOOLEAN;
            this.attributeName = attributeName;
            this.attributeNamespace = attributeNamespace;
            this.mustUseProperty = mustUseProperty;
            this.propertyName = name;
            this.type = type;
            this.sanitizeURL = sanitizeURL;
            this.removeEmptyString = removeEmptyString;
        }
        var properties = {};
        var reservedProps = [ "children", "dangerouslySetInnerHTML", "defaultValue", "defaultChecked", "innerHTML", "suppressContentEditableWarning", "suppressHydrationWarning", "style" ];
        reservedProps.forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, RESERVED, false, name, null, false, false);
        }));
        [ [ "acceptCharset", "accept-charset" ], [ "className", "class" ], [ "htmlFor", "for" ], [ "httpEquiv", "http-equiv" ] ].forEach((function(_ref) {
            var _ref2 = _slicedToArray(_ref, 2), name = _ref2[0], attributeName = _ref2[1];
            properties[name] = new PropertyInfoRecord(name, STRING, false, attributeName, null, false, false);
        }));
        [ "contentEditable", "draggable", "spellCheck", "value" ].forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, BOOLEANISH_STRING, false, name.toLowerCase(), null, false, false);
        }));
        [ "autoReverse", "externalResourcesRequired", "focusable", "preserveAlpha" ].forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, BOOLEANISH_STRING, false, name, null, false, false);
        }));
        [ "allowFullScreen", "async", "autoFocus", "autoPlay", "controls", "default", "defer", "disabled", "disablePictureInPicture", "disableRemotePlayback", "formNoValidate", "hidden", "loop", "noModule", "noValidate", "open", "playsInline", "readOnly", "required", "reversed", "scoped", "seamless", "itemScope" ].forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, BOOLEAN, false, name.toLowerCase(), null, false, false);
        }));
        [ "checked", "multiple", "muted", "selected" ].forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, BOOLEAN, true, name, null, false, false);
        }));
        [ "capture", "download" ].forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, OVERLOADED_BOOLEAN, false, name, null, false, false);
        }));
        [ "cols", "rows", "size", "span" ].forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, POSITIVE_NUMERIC, false, name, null, false, false);
        }));
        [ "rowSpan", "start" ].forEach((function(name) {
            properties[name] = new PropertyInfoRecord(name, NUMERIC, false, name.toLowerCase(), null, false, false);
        }));
        var CAMELIZE = /[\-\:]([a-z])/g;
        var capitalize = function capitalize(token) {
            return token[1].toUpperCase();
        };
        [ "accent-height", "alignment-baseline", "arabic-form", "baseline-shift", "cap-height", "clip-path", "clip-rule", "color-interpolation", "color-interpolation-filters", "color-profile", "color-rendering", "dominant-baseline", "enable-background", "fill-opacity", "fill-rule", "flood-color", "flood-opacity", "font-family", "font-size", "font-size-adjust", "font-stretch", "font-style", "font-variant", "font-weight", "glyph-name", "glyph-orientation-horizontal", "glyph-orientation-vertical", "horiz-adv-x", "horiz-origin-x", "image-rendering", "letter-spacing", "lighting-color", "marker-end", "marker-mid", "marker-start", "overline-position", "overline-thickness", "paint-order", "panose-1", "pointer-events", "rendering-intent", "shape-rendering", "stop-color", "stop-opacity", "strikethrough-position", "strikethrough-thickness", "stroke-dasharray", "stroke-dashoffset", "stroke-linecap", "stroke-linejoin", "stroke-miterlimit", "stroke-opacity", "stroke-width", "text-anchor", "text-decoration", "text-rendering", "underline-position", "underline-thickness", "unicode-bidi", "unicode-range", "units-per-em", "v-alphabetic", "v-hanging", "v-ideographic", "v-mathematical", "vector-effect", "vert-adv-y", "vert-origin-x", "vert-origin-y", "word-spacing", "writing-mode", "xmlns:xlink", "x-height" ].forEach((function(attributeName) {
            var name = attributeName.replace(CAMELIZE, capitalize);
            properties[name] = new PropertyInfoRecord(name, STRING, false, attributeName, null, false, false);
        }));
        [ "xlink:actuate", "xlink:arcrole", "xlink:role", "xlink:show", "xlink:title", "xlink:type" ].forEach((function(attributeName) {
            var name = attributeName.replace(CAMELIZE, capitalize);
            properties[name] = new PropertyInfoRecord(name, STRING, false, attributeName, "http://www.w3.org/1999/xlink", false, false);
        }));
        [ "xml:base", "xml:lang", "xml:space" ].forEach((function(attributeName) {
            var name = attributeName.replace(CAMELIZE, capitalize);
            properties[name] = new PropertyInfoRecord(name, STRING, false, attributeName, "http://www.w3.org/XML/1998/namespace", false, false);
        }));
        [ "tabIndex", "crossOrigin" ].forEach((function(attributeName) {
            properties[attributeName] = new PropertyInfoRecord(attributeName, STRING, false, attributeName.toLowerCase(), null, false, false);
        }));
        var xlinkHref = "xlinkHref";
        properties[xlinkHref] = new PropertyInfoRecord("xlinkHref", STRING, false, "xlink:href", "http://www.w3.org/1999/xlink", true, false);
        [ "src", "href", "action", "formAction" ].forEach((function(attributeName) {
            properties[attributeName] = new PropertyInfoRecord(attributeName, STRING, false, attributeName.toLowerCase(), null, true, true);
        }));
        var _require = __webpack_require__(25), CAMELCASE = _require.CAMELCASE, SAME = _require.SAME, possibleStandardNamesOptimized = _require.possibleStandardNames;
        var ATTRIBUTE_NAME_START_CHAR = ":A-Z_a-z\\u00C0-\\u00D6\\u00D8-\\u00F6\\u00F8-\\u02FF\\u0370-\\u037D\\u037F-\\u1FFF\\u200C-\\u200D\\u2070-\\u218F\\u2C00-\\u2FEF\\u3001-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFFD";
        var ATTRIBUTE_NAME_CHAR = ATTRIBUTE_NAME_START_CHAR + "\\-.0-9\\u00B7\\u0300-\\u036F\\u203F-\\u2040";
        var isCustomAttribute = RegExp.prototype.test.bind(new RegExp("^(data|aria)-[" + ATTRIBUTE_NAME_CHAR + "]*$"));
        var possibleStandardNames = Object.keys(possibleStandardNamesOptimized).reduce((function(accumulator, standardName) {
            var propName = possibleStandardNamesOptimized[standardName];
            if (propName === SAME) {
                accumulator[standardName] = standardName;
            } else if (propName === CAMELCASE) {
                accumulator[standardName.toLowerCase()] = standardName;
            } else {
                accumulator[standardName] = propName;
            }
            return accumulator;
        }), {});
        exports.BOOLEAN = BOOLEAN;
        exports.BOOLEANISH_STRING = BOOLEANISH_STRING;
        exports.NUMERIC = NUMERIC;
        exports.OVERLOADED_BOOLEAN = OVERLOADED_BOOLEAN;
        exports.POSITIVE_NUMERIC = POSITIVE_NUMERIC;
        exports.RESERVED = RESERVED;
        exports.STRING = STRING;
        exports.getPropertyInfo = getPropertyInfo;
        exports.isCustomAttribute = isCustomAttribute;
        exports.possibleStandardNames = possibleStandardNames;
    }, (__unused_webpack_module, exports) => {
        var SAME = 0;
        exports.SAME = SAME;
        var CAMELCASE = 1;
        exports.CAMELCASE = CAMELCASE;
        exports.possibleStandardNames = {
            accept: 0,
            acceptCharset: 1,
            "accept-charset": "acceptCharset",
            accessKey: 1,
            action: 0,
            allowFullScreen: 1,
            alt: 0,
            as: 0,
            async: 0,
            autoCapitalize: 1,
            autoComplete: 1,
            autoCorrect: 1,
            autoFocus: 1,
            autoPlay: 1,
            autoSave: 1,
            capture: 0,
            cellPadding: 1,
            cellSpacing: 1,
            challenge: 0,
            charSet: 1,
            checked: 0,
            children: 0,
            cite: 0,
            class: "className",
            classID: 1,
            className: 1,
            cols: 0,
            colSpan: 1,
            content: 0,
            contentEditable: 1,
            contextMenu: 1,
            controls: 0,
            controlsList: 1,
            coords: 0,
            crossOrigin: 1,
            dangerouslySetInnerHTML: 1,
            data: 0,
            dateTime: 1,
            default: 0,
            defaultChecked: 1,
            defaultValue: 1,
            defer: 0,
            dir: 0,
            disabled: 0,
            disablePictureInPicture: 1,
            disableRemotePlayback: 1,
            download: 0,
            draggable: 0,
            encType: 1,
            enterKeyHint: 1,
            for: "htmlFor",
            form: 0,
            formMethod: 1,
            formAction: 1,
            formEncType: 1,
            formNoValidate: 1,
            formTarget: 1,
            frameBorder: 1,
            headers: 0,
            height: 0,
            hidden: 0,
            high: 0,
            href: 0,
            hrefLang: 1,
            htmlFor: 1,
            httpEquiv: 1,
            "http-equiv": "httpEquiv",
            icon: 0,
            id: 0,
            innerHTML: 1,
            inputMode: 1,
            integrity: 0,
            is: 0,
            itemID: 1,
            itemProp: 1,
            itemRef: 1,
            itemScope: 1,
            itemType: 1,
            keyParams: 1,
            keyType: 1,
            kind: 0,
            label: 0,
            lang: 0,
            list: 0,
            loop: 0,
            low: 0,
            manifest: 0,
            marginWidth: 1,
            marginHeight: 1,
            max: 0,
            maxLength: 1,
            media: 0,
            mediaGroup: 1,
            method: 0,
            min: 0,
            minLength: 1,
            multiple: 0,
            muted: 0,
            name: 0,
            noModule: 1,
            nonce: 0,
            noValidate: 1,
            open: 0,
            optimum: 0,
            pattern: 0,
            placeholder: 0,
            playsInline: 1,
            poster: 0,
            preload: 0,
            profile: 0,
            radioGroup: 1,
            readOnly: 1,
            referrerPolicy: 1,
            rel: 0,
            required: 0,
            reversed: 0,
            role: 0,
            rows: 0,
            rowSpan: 1,
            sandbox: 0,
            scope: 0,
            scoped: 0,
            scrolling: 0,
            seamless: 0,
            selected: 0,
            shape: 0,
            size: 0,
            sizes: 0,
            span: 0,
            spellCheck: 1,
            src: 0,
            srcDoc: 1,
            srcLang: 1,
            srcSet: 1,
            start: 0,
            step: 0,
            style: 0,
            summary: 0,
            tabIndex: 1,
            target: 0,
            title: 0,
            type: 0,
            useMap: 1,
            value: 0,
            width: 0,
            wmode: 0,
            wrap: 0,
            about: 0,
            accentHeight: 1,
            "accent-height": "accentHeight",
            accumulate: 0,
            additive: 0,
            alignmentBaseline: 1,
            "alignment-baseline": "alignmentBaseline",
            allowReorder: 1,
            alphabetic: 0,
            amplitude: 0,
            arabicForm: 1,
            "arabic-form": "arabicForm",
            ascent: 0,
            attributeName: 1,
            attributeType: 1,
            autoReverse: 1,
            azimuth: 0,
            baseFrequency: 1,
            baselineShift: 1,
            "baseline-shift": "baselineShift",
            baseProfile: 1,
            bbox: 0,
            begin: 0,
            bias: 0,
            by: 0,
            calcMode: 1,
            capHeight: 1,
            "cap-height": "capHeight",
            clip: 0,
            clipPath: 1,
            "clip-path": "clipPath",
            clipPathUnits: 1,
            clipRule: 1,
            "clip-rule": "clipRule",
            color: 0,
            colorInterpolation: 1,
            "color-interpolation": "colorInterpolation",
            colorInterpolationFilters: 1,
            "color-interpolation-filters": "colorInterpolationFilters",
            colorProfile: 1,
            "color-profile": "colorProfile",
            colorRendering: 1,
            "color-rendering": "colorRendering",
            contentScriptType: 1,
            contentStyleType: 1,
            cursor: 0,
            cx: 0,
            cy: 0,
            d: 0,
            datatype: 0,
            decelerate: 0,
            descent: 0,
            diffuseConstant: 1,
            direction: 0,
            display: 0,
            divisor: 0,
            dominantBaseline: 1,
            "dominant-baseline": "dominantBaseline",
            dur: 0,
            dx: 0,
            dy: 0,
            edgeMode: 1,
            elevation: 0,
            enableBackground: 1,
            "enable-background": "enableBackground",
            end: 0,
            exponent: 0,
            externalResourcesRequired: 1,
            fill: 0,
            fillOpacity: 1,
            "fill-opacity": "fillOpacity",
            fillRule: 1,
            "fill-rule": "fillRule",
            filter: 0,
            filterRes: 1,
            filterUnits: 1,
            floodOpacity: 1,
            "flood-opacity": "floodOpacity",
            floodColor: 1,
            "flood-color": "floodColor",
            focusable: 0,
            fontFamily: 1,
            "font-family": "fontFamily",
            fontSize: 1,
            "font-size": "fontSize",
            fontSizeAdjust: 1,
            "font-size-adjust": "fontSizeAdjust",
            fontStretch: 1,
            "font-stretch": "fontStretch",
            fontStyle: 1,
            "font-style": "fontStyle",
            fontVariant: 1,
            "font-variant": "fontVariant",
            fontWeight: 1,
            "font-weight": "fontWeight",
            format: 0,
            from: 0,
            fx: 0,
            fy: 0,
            g1: 0,
            g2: 0,
            glyphName: 1,
            "glyph-name": "glyphName",
            glyphOrientationHorizontal: 1,
            "glyph-orientation-horizontal": "glyphOrientationHorizontal",
            glyphOrientationVertical: 1,
            "glyph-orientation-vertical": "glyphOrientationVertical",
            glyphRef: 1,
            gradientTransform: 1,
            gradientUnits: 1,
            hanging: 0,
            horizAdvX: 1,
            "horiz-adv-x": "horizAdvX",
            horizOriginX: 1,
            "horiz-origin-x": "horizOriginX",
            ideographic: 0,
            imageRendering: 1,
            "image-rendering": "imageRendering",
            in2: 0,
            in: 0,
            inlist: 0,
            intercept: 0,
            k1: 0,
            k2: 0,
            k3: 0,
            k4: 0,
            k: 0,
            kernelMatrix: 1,
            kernelUnitLength: 1,
            kerning: 0,
            keyPoints: 1,
            keySplines: 1,
            keyTimes: 1,
            lengthAdjust: 1,
            letterSpacing: 1,
            "letter-spacing": "letterSpacing",
            lightingColor: 1,
            "lighting-color": "lightingColor",
            limitingConeAngle: 1,
            local: 0,
            markerEnd: 1,
            "marker-end": "markerEnd",
            markerHeight: 1,
            markerMid: 1,
            "marker-mid": "markerMid",
            markerStart: 1,
            "marker-start": "markerStart",
            markerUnits: 1,
            markerWidth: 1,
            mask: 0,
            maskContentUnits: 1,
            maskUnits: 1,
            mathematical: 0,
            mode: 0,
            numOctaves: 1,
            offset: 0,
            opacity: 0,
            operator: 0,
            order: 0,
            orient: 0,
            orientation: 0,
            origin: 0,
            overflow: 0,
            overlinePosition: 1,
            "overline-position": "overlinePosition",
            overlineThickness: 1,
            "overline-thickness": "overlineThickness",
            paintOrder: 1,
            "paint-order": "paintOrder",
            panose1: 0,
            "panose-1": "panose1",
            pathLength: 1,
            patternContentUnits: 1,
            patternTransform: 1,
            patternUnits: 1,
            pointerEvents: 1,
            "pointer-events": "pointerEvents",
            points: 0,
            pointsAtX: 1,
            pointsAtY: 1,
            pointsAtZ: 1,
            prefix: 0,
            preserveAlpha: 1,
            preserveAspectRatio: 1,
            primitiveUnits: 1,
            property: 0,
            r: 0,
            radius: 0,
            refX: 1,
            refY: 1,
            renderingIntent: 1,
            "rendering-intent": "renderingIntent",
            repeatCount: 1,
            repeatDur: 1,
            requiredExtensions: 1,
            requiredFeatures: 1,
            resource: 0,
            restart: 0,
            result: 0,
            results: 0,
            rotate: 0,
            rx: 0,
            ry: 0,
            scale: 0,
            security: 0,
            seed: 0,
            shapeRendering: 1,
            "shape-rendering": "shapeRendering",
            slope: 0,
            spacing: 0,
            specularConstant: 1,
            specularExponent: 1,
            speed: 0,
            spreadMethod: 1,
            startOffset: 1,
            stdDeviation: 1,
            stemh: 0,
            stemv: 0,
            stitchTiles: 1,
            stopColor: 1,
            "stop-color": "stopColor",
            stopOpacity: 1,
            "stop-opacity": "stopOpacity",
            strikethroughPosition: 1,
            "strikethrough-position": "strikethroughPosition",
            strikethroughThickness: 1,
            "strikethrough-thickness": "strikethroughThickness",
            string: 0,
            stroke: 0,
            strokeDasharray: 1,
            "stroke-dasharray": "strokeDasharray",
            strokeDashoffset: 1,
            "stroke-dashoffset": "strokeDashoffset",
            strokeLinecap: 1,
            "stroke-linecap": "strokeLinecap",
            strokeLinejoin: 1,
            "stroke-linejoin": "strokeLinejoin",
            strokeMiterlimit: 1,
            "stroke-miterlimit": "strokeMiterlimit",
            strokeWidth: 1,
            "stroke-width": "strokeWidth",
            strokeOpacity: 1,
            "stroke-opacity": "strokeOpacity",
            suppressContentEditableWarning: 1,
            suppressHydrationWarning: 1,
            surfaceScale: 1,
            systemLanguage: 1,
            tableValues: 1,
            targetX: 1,
            targetY: 1,
            textAnchor: 1,
            "text-anchor": "textAnchor",
            textDecoration: 1,
            "text-decoration": "textDecoration",
            textLength: 1,
            textRendering: 1,
            "text-rendering": "textRendering",
            to: 0,
            transform: 0,
            typeof: 0,
            u1: 0,
            u2: 0,
            underlinePosition: 1,
            "underline-position": "underlinePosition",
            underlineThickness: 1,
            "underline-thickness": "underlineThickness",
            unicode: 0,
            unicodeBidi: 1,
            "unicode-bidi": "unicodeBidi",
            unicodeRange: 1,
            "unicode-range": "unicodeRange",
            unitsPerEm: 1,
            "units-per-em": "unitsPerEm",
            unselectable: 0,
            vAlphabetic: 1,
            "v-alphabetic": "vAlphabetic",
            values: 0,
            vectorEffect: 1,
            "vector-effect": "vectorEffect",
            version: 0,
            vertAdvY: 1,
            "vert-adv-y": "vertAdvY",
            vertOriginX: 1,
            "vert-origin-x": "vertOriginX",
            vertOriginY: 1,
            "vert-origin-y": "vertOriginY",
            vHanging: 1,
            "v-hanging": "vHanging",
            vIdeographic: 1,
            "v-ideographic": "vIdeographic",
            viewBox: 1,
            viewTarget: 1,
            visibility: 0,
            vMathematical: 1,
            "v-mathematical": "vMathematical",
            vocab: 0,
            widths: 0,
            wordSpacing: 1,
            "word-spacing": "wordSpacing",
            writingMode: 1,
            "writing-mode": "writingMode",
            x1: 0,
            x2: 0,
            x: 0,
            xChannelSelector: 1,
            xHeight: 1,
            "x-height": "xHeight",
            xlinkActuate: 1,
            "xlink:actuate": "xlinkActuate",
            xlinkArcrole: 1,
            "xlink:arcrole": "xlinkArcrole",
            xlinkHref: 1,
            "xlink:href": "xlinkHref",
            xlinkRole: 1,
            "xlink:role": "xlinkRole",
            xlinkShow: 1,
            "xlink:show": "xlinkShow",
            xlinkTitle: 1,
            "xlink:title": "xlinkTitle",
            xlinkType: 1,
            "xlink:type": "xlinkType",
            xmlBase: 1,
            "xml:base": "xmlBase",
            xmlLang: 1,
            "xml:lang": "xmlLang",
            xmlns: 0,
            "xml:space": "xmlSpace",
            xmlnsXlink: 1,
            "xmlns:xlink": "xmlnsXlink",
            xmlSpace: 1,
            y1: 0,
            y2: 0,
            y: 0,
            yChannelSelector: 1,
            z: 0,
            zoomAndPan: 1
        };
    }, (module, __unused_webpack_exports, __webpack_require__) => {
        var React = __webpack_require__(22);
        var styleToJS = __webpack_require__(27)["default"];
        function invertObject(obj, override) {
            if (!obj || typeof obj !== "object") {
                throw new TypeError("First argument must be an object");
            }
            var key;
            var value;
            var isOverridePresent = typeof override === "function";
            var overrides = {};
            var result = {};
            for (key in obj) {
                value = obj[key];
                if (isOverridePresent) {
                    overrides = override(key, value);
                    if (overrides && overrides.length === 2) {
                        result[overrides[0]] = overrides[1];
                        continue;
                    }
                }
                if (typeof value === "string") {
                    result[value] = key;
                }
            }
            return result;
        }
        function isCustomComponent(tagName, props) {
            if (tagName.indexOf("-") === -1) {
                return props && typeof props.is === "string";
            }
            switch (tagName) {
              case "annotation-xml":
              case "color-profile":
              case "font-face":
              case "font-face-src":
              case "font-face-uri":
              case "font-face-format":
              case "font-face-name":
              case "missing-glyph":
                return false;

              default:
                return true;
            }
        }
        var styleToJSOptions = {
            reactCompat: true
        };
        function setStyleProp(style, props) {
            if (style === null || style === undefined) {
                return;
            }
            try {
                props.style = styleToJS(style, styleToJSOptions);
            } catch (err) {
                props.style = {};
            }
        }
        var PRESERVE_CUSTOM_ATTRIBUTES = React.version.split(".")[0] >= 16;
        var elementsWithNoTextChildren = new Set([ "tr", "tbody", "thead", "tfoot", "colgroup", "table", "head", "html", "frameset" ]);
        function canTextBeChildOfNode(node) {
            return !elementsWithNoTextChildren.has(node.name);
        }
        module.exports = {
            PRESERVE_CUSTOM_ATTRIBUTES,
            invertObject,
            isCustomComponent,
            setStyleProp,
            canTextBeChildOfNode,
            elementsWithNoTextChildren
        };
    }, function(__unused_webpack_module, exports, __webpack_require__) {
        "use strict";
        var __importDefault = this && this.__importDefault || function(mod) {
            return mod && mod.__esModule ? mod : {
                default: mod
            };
        };
        exports.__esModule = true;
        var style_to_object_1 = __importDefault(__webpack_require__(28));
        var utilities_1 = __webpack_require__(30);
        function StyleToJS(style, options) {
            var output = {};
            if (!style || typeof style !== "string") {
                return output;
            }
            (0, style_to_object_1["default"])(style, (function(property, value) {
                if (property && value) {
                    output[(0, utilities_1.camelCase)(property, options)] = value;
                }
            }));
            return output;
        }
        exports["default"] = StyleToJS;
    }, (module, __unused_webpack_exports, __webpack_require__) => {
        var parse = __webpack_require__(29);
        function StyleToObject(style, iterator) {
            var output = null;
            if (!style || typeof style !== "string") {
                return output;
            }
            var declaration;
            var declarations = parse(style);
            var hasIterator = typeof iterator === "function";
            var property;
            var value;
            for (var i = 0, len = declarations.length; i < len; i++) {
                declaration = declarations[i];
                property = declaration.property;
                value = declaration.value;
                if (hasIterator) {
                    iterator(property, value, declaration);
                } else if (value) {
                    output || (output = {});
                    output[property] = value;
                }
            }
            return output;
        }
        module.exports = StyleToObject;
    }, module => {
        var COMMENT_REGEX = /\/\*[^*]*\*+([^/*][^*]*\*+)*\//g;
        var NEWLINE_REGEX = /\n/g;
        var WHITESPACE_REGEX = /^\s*/;
        var PROPERTY_REGEX = /^(\*?[-#/*\\\w]+(\[[0-9a-z_-]+\])?)\s*/;
        var COLON_REGEX = /^:\s*/;
        var VALUE_REGEX = /^((?:'(?:\\'|.)*?'|"(?:\\"|.)*?"|\([^)]*?\)|[^};])+)/;
        var SEMICOLON_REGEX = /^[;\s]*/;
        var TRIM_REGEX = /^\s+|\s+$/g;
        var NEWLINE = "\n";
        var FORWARD_SLASH = "/";
        var ASTERISK = "*";
        var EMPTY_STRING = "";
        var TYPE_COMMENT = "comment";
        var TYPE_DECLARATION = "declaration";
        module.exports = function(style, options) {
            if (typeof style !== "string") {
                throw new TypeError("First argument must be a string");
            }
            if (!style) return [];
            options = options || {};
            var lineno = 1;
            var column = 1;
            function updatePosition(str) {
                var lines = str.match(NEWLINE_REGEX);
                if (lines) lineno += lines.length;
                var i = str.lastIndexOf(NEWLINE);
                column = ~i ? str.length - i : column + str.length;
            }
            function position() {
                var start = {
                    line: lineno,
                    column
                };
                return function(node) {
                    node.position = new Position(start);
                    whitespace();
                    return node;
                };
            }
            function Position(start) {
                this.start = start;
                this.end = {
                    line: lineno,
                    column
                };
                this.source = options.source;
            }
            Position.prototype.content = style;
            var errorsList = [];
            function error(msg) {
                var err = new Error(options.source + ":" + lineno + ":" + column + ": " + msg);
                err.reason = msg;
                err.filename = options.source;
                err.line = lineno;
                err.column = column;
                err.source = style;
                if (options.silent) {
                    errorsList.push(err);
                } else {
                    throw err;
                }
            }
            function match(re) {
                var m = re.exec(style);
                if (!m) return;
                var str = m[0];
                updatePosition(str);
                style = style.slice(str.length);
                return m;
            }
            function whitespace() {
                match(WHITESPACE_REGEX);
            }
            function comments(rules) {
                var c;
                rules = rules || [];
                while (c = comment()) {
                    if (c !== false) {
                        rules.push(c);
                    }
                }
                return rules;
            }
            function comment() {
                var pos = position();
                if (FORWARD_SLASH != style.charAt(0) || ASTERISK != style.charAt(1)) return;
                var i = 2;
                while (EMPTY_STRING != style.charAt(i) && (ASTERISK != style.charAt(i) || FORWARD_SLASH != style.charAt(i + 1))) {
                    ++i;
                }
                i += 2;
                if (EMPTY_STRING === style.charAt(i - 1)) {
                    return error("End of comment missing");
                }
                var str = style.slice(2, i - 2);
                column += 2;
                updatePosition(str);
                style = style.slice(i);
                column += 2;
                return pos({
                    type: TYPE_COMMENT,
                    comment: str
                });
            }
            function declaration() {
                var pos = position();
                var prop = match(PROPERTY_REGEX);
                if (!prop) return;
                comment();
                if (!match(COLON_REGEX)) return error("property missing ':'");
                var val = match(VALUE_REGEX);
                var ret = pos({
                    type: TYPE_DECLARATION,
                    property: trim(prop[0].replace(COMMENT_REGEX, EMPTY_STRING)),
                    value: val ? trim(val[0].replace(COMMENT_REGEX, EMPTY_STRING)) : EMPTY_STRING
                });
                match(SEMICOLON_REGEX);
                return ret;
            }
            function declarations() {
                var decls = [];
                comments(decls);
                var decl;
                while (decl = declaration()) {
                    if (decl !== false) {
                        decls.push(decl);
                        comments(decls);
                    }
                }
                return decls;
            }
            whitespace();
            return declarations();
        };
        function trim(str) {
            return str ? str.replace(TRIM_REGEX, EMPTY_STRING) : EMPTY_STRING;
        }
    }, (__unused_webpack_module, exports) => {
        "use strict";
        exports.__esModule = true;
        exports.camelCase = void 0;
        var CUSTOM_PROPERTY_REGEX = /^--[a-zA-Z0-9-]+$/;
        var HYPHEN_REGEX = /-([a-z])/g;
        var NO_HYPHEN_REGEX = /^[^-]+$/;
        var VENDOR_PREFIX_REGEX = /^-(webkit|moz|ms|o|khtml)-/;
        var MS_VENDOR_PREFIX_REGEX = /^-(ms)-/;
        var skipCamelCase = function(property) {
            return !property || NO_HYPHEN_REGEX.test(property) || CUSTOM_PROPERTY_REGEX.test(property);
        };
        var capitalize = function(match, character) {
            return character.toUpperCase();
        };
        var trimHyphen = function(match, prefix) {
            return "".concat(prefix, "-");
        };
        var camelCase = function(property, options) {
            if (options === void 0) {
                options = {};
            }
            if (skipCamelCase(property)) {
                return property;
            }
            property = property.toLowerCase();
            if (options.reactCompat) {
                property = property.replace(MS_VENDOR_PREFIX_REGEX, trimHyphen);
            } else {
                property = property.replace(VENDOR_PREFIX_REGEX, trimHyphen);
            }
            return property.replace(HYPHEN_REGEX, capitalize);
        };
        exports.camelCase = camelCase;
    }, (module, __unused_webpack_exports, __webpack_require__) => {
        var domparser = __webpack_require__(32);
        var formatDOM = __webpack_require__(33).formatDOM;
        var DIRECTIVE_REGEX = /<(![a-zA-Z\s]+)>/;
        function HTMLDOMParser(html) {
            if (typeof html !== "string") {
                throw new TypeError("First argument must be a string");
            }
            if (html === "") {
                return [];
            }
            var match = html.match(DIRECTIVE_REGEX);
            var directive;
            if (match && match[1]) {
                directive = match[1];
            }
            return formatDOM(domparser(html), null, directive);
        }
        module.exports = HTMLDOMParser;
    }, module => {
        var HTML = "html";
        var HEAD = "head";
        var BODY = "body";
        var FIRST_TAG_REGEX = /<([a-zA-Z]+[0-9]?)/;
        var HEAD_TAG_REGEX = /<head[^]*>/i;
        var BODY_TAG_REGEX = /<body[^]*>/i;
        var parseFromDocument = function() {
            throw new Error("This browser does not support `document.implementation.createHTMLDocument`");
        };
        var parseFromString = function() {
            throw new Error("This browser does not support `DOMParser.prototype.parseFromString`");
        };
        if (typeof window.DOMParser === "function") {
            var domParser = new window.DOMParser;
            var mimeType = "text/html";
            parseFromString = function(html, tagName) {
                if (tagName) {
                    html = "<" + tagName + ">" + html + "</" + tagName + ">";
                }
                return domParser.parseFromString(html, mimeType);
            };
            parseFromDocument = parseFromString;
        }
        if (document.implementation) {
            var doc = document.implementation.createHTMLDocument();
            parseFromDocument = function(html, tagName) {
                if (tagName) {
                    var element = doc.documentElement.querySelector(tagName);
                    element.innerHTML = html;
                    return doc;
                }
                doc.documentElement.innerHTML = html;
                return doc;
            };
        }
        var template = document.createElement("template");
        var parseFromTemplate;
        if (template.content) {
            parseFromTemplate = function(html) {
                template.innerHTML = html;
                return template.content.childNodes;
            };
        }
        function domparser(html) {
            var firstTagName;
            var match = html.match(FIRST_TAG_REGEX);
            if (match && match[1]) {
                firstTagName = match[1].toLowerCase();
            }
            var doc;
            var element;
            var elements;
            switch (firstTagName) {
              case HTML:
                doc = parseFromString(html);
                if (!HEAD_TAG_REGEX.test(html)) {
                    element = doc.querySelector(HEAD);
                    if (element) {
                        element.parentNode.removeChild(element);
                    }
                }
                if (!BODY_TAG_REGEX.test(html)) {
                    element = doc.querySelector(BODY);
                    if (element) {
                        element.parentNode.removeChild(element);
                    }
                }
                return doc.querySelectorAll(HTML);

              case HEAD:
              case BODY:
                doc = parseFromDocument(html);
                elements = doc.querySelectorAll(firstTagName);
                if (BODY_TAG_REGEX.test(html) && HEAD_TAG_REGEX.test(html)) {
                    return elements[0].parentNode.childNodes;
                }
                return elements;

              default:
                if (parseFromTemplate) {
                    return parseFromTemplate(html);
                }
                element = parseFromDocument(html, BODY).querySelector(BODY);
                return element.childNodes;
            }
        }
        module.exports = domparser;
    }, (__unused_webpack_module, exports, __webpack_require__) => {
        var domhandler = __webpack_require__(34);
        var constants = __webpack_require__(37);
        var CASE_SENSITIVE_TAG_NAMES = constants.CASE_SENSITIVE_TAG_NAMES;
        var Comment = domhandler.Comment;
        var Element = domhandler.Element;
        var ProcessingInstruction = domhandler.ProcessingInstruction;
        var Text = domhandler.Text;
        var caseSensitiveTagNamesMap = {};
        var tagName;
        for (var i = 0, len = CASE_SENSITIVE_TAG_NAMES.length; i < len; i++) {
            tagName = CASE_SENSITIVE_TAG_NAMES[i];
            caseSensitiveTagNamesMap[tagName.toLowerCase()] = tagName;
        }
        function getCaseSensitiveTagName(tagName) {
            return caseSensitiveTagNamesMap[tagName];
        }
        function formatAttributes(attributes) {
            var result = {};
            var attribute;
            for (var i = 0, len = attributes.length; i < len; i++) {
                attribute = attributes[i];
                result[attribute.name] = attribute.value;
            }
            return result;
        }
        function formatTagName(tagName) {
            tagName = tagName.toLowerCase();
            var caseSensitiveTagName = getCaseSensitiveTagName(tagName);
            if (caseSensitiveTagName) {
                return caseSensitiveTagName;
            }
            return tagName;
        }
        function formatDOM(nodes, parent, directive) {
            parent = parent || null;
            var result = [];
            for (var index = 0, len = nodes.length; index < len; index++) {
                var node = nodes[index];
                var current;
                switch (node.nodeType) {
                  case 1:
                    current = new Element(formatTagName(node.nodeName), formatAttributes(node.attributes));
                    current.children = formatDOM(node.childNodes, current);
                    break;

                  case 3:
                    current = new Text(node.nodeValue);
                    break;

                  case 8:
                    current = new Comment(node.nodeValue);
                    break;

                  default:
                    continue;
                }
                var prev = result[index - 1] || null;
                if (prev) {
                    prev.next = current;
                }
                current.parent = parent;
                current.prev = prev;
                current.next = null;
                result.push(current);
            }
            if (directive) {
                current = new ProcessingInstruction(directive.substring(0, directive.indexOf(" ")).toLowerCase(), directive);
                current.next = result[0] || null;
                current.parent = parent;
                result.unshift(current);
                if (result[1]) {
                    result[1].prev = result[0];
                }
            }
            return result;
        }
        exports.formatAttributes = formatAttributes;
        exports.formatDOM = formatDOM;
    }, function(__unused_webpack_module, exports, __webpack_require__) {
        "use strict";
        var __createBinding = this && this.__createBinding || (Object.create ? function(o, m, k, k2) {
            if (k2 === undefined) k2 = k;
            var desc = Object.getOwnPropertyDescriptor(m, k);
            if (!desc || ("get" in desc ? !m.__esModule : desc.writable || desc.configurable)) {
                desc = {
                    enumerable: true,
                    get: function() {
                        return m[k];
                    }
                };
            }
            Object.defineProperty(o, k2, desc);
        } : function(o, m, k, k2) {
            if (k2 === undefined) k2 = k;
            o[k2] = m[k];
        });
        var __exportStar = this && this.__exportStar || function(m, exports) {
            for (var p in m) if (p !== "default" && !Object.prototype.hasOwnProperty.call(exports, p)) __createBinding(exports, m, p);
        };
        Object.defineProperty(exports, "__esModule", {
            value: true
        });
        exports.DomHandler = void 0;
        var domelementtype_1 = __webpack_require__(35);
        var node_js_1 = __webpack_require__(36);
        __exportStar(__webpack_require__(36), exports);
        var defaultOpts = {
            withStartIndices: false,
            withEndIndices: false,
            xmlMode: false
        };
        var DomHandler = function() {
            function DomHandler(callback, options, elementCB) {
                this.dom = [];
                this.root = new node_js_1.Document(this.dom);
                this.done = false;
                this.tagStack = [ this.root ];
                this.lastNode = null;
                this.parser = null;
                if (typeof options === "function") {
                    elementCB = options;
                    options = defaultOpts;
                }
                if (typeof callback === "object") {
                    options = callback;
                    callback = undefined;
                }
                this.callback = callback !== null && callback !== void 0 ? callback : null;
                this.options = options !== null && options !== void 0 ? options : defaultOpts;
                this.elementCB = elementCB !== null && elementCB !== void 0 ? elementCB : null;
            }
            DomHandler.prototype.onparserinit = function(parser) {
                this.parser = parser;
            };
            DomHandler.prototype.onreset = function() {
                this.dom = [];
                this.root = new node_js_1.Document(this.dom);
                this.done = false;
                this.tagStack = [ this.root ];
                this.lastNode = null;
                this.parser = null;
            };
            DomHandler.prototype.onend = function() {
                if (this.done) return;
                this.done = true;
                this.parser = null;
                this.handleCallback(null);
            };
            DomHandler.prototype.onerror = function(error) {
                this.handleCallback(error);
            };
            DomHandler.prototype.onclosetag = function() {
                this.lastNode = null;
                var elem = this.tagStack.pop();
                if (this.options.withEndIndices) {
                    elem.endIndex = this.parser.endIndex;
                }
                if (this.elementCB) this.elementCB(elem);
            };
            DomHandler.prototype.onopentag = function(name, attribs) {
                var type = this.options.xmlMode ? domelementtype_1.ElementType.Tag : undefined;
                var element = new node_js_1.Element(name, attribs, undefined, type);
                this.addNode(element);
                this.tagStack.push(element);
            };
            DomHandler.prototype.ontext = function(data) {
                var lastNode = this.lastNode;
                if (lastNode && lastNode.type === domelementtype_1.ElementType.Text) {
                    lastNode.data += data;
                    if (this.options.withEndIndices) {
                        lastNode.endIndex = this.parser.endIndex;
                    }
                } else {
                    var node = new node_js_1.Text(data);
                    this.addNode(node);
                    this.lastNode = node;
                }
            };
            DomHandler.prototype.oncomment = function(data) {
                if (this.lastNode && this.lastNode.type === domelementtype_1.ElementType.Comment) {
                    this.lastNode.data += data;
                    return;
                }
                var node = new node_js_1.Comment(data);
                this.addNode(node);
                this.lastNode = node;
            };
            DomHandler.prototype.oncommentend = function() {
                this.lastNode = null;
            };
            DomHandler.prototype.oncdatastart = function() {
                var text = new node_js_1.Text("");
                var node = new node_js_1.CDATA([ text ]);
                this.addNode(node);
                text.parent = node;
                this.lastNode = text;
            };
            DomHandler.prototype.oncdataend = function() {
                this.lastNode = null;
            };
            DomHandler.prototype.onprocessinginstruction = function(name, data) {
                var node = new node_js_1.ProcessingInstruction(name, data);
                this.addNode(node);
            };
            DomHandler.prototype.handleCallback = function(error) {
                if (typeof this.callback === "function") {
                    this.callback(error, this.dom);
                } else if (error) {
                    throw error;
                }
            };
            DomHandler.prototype.addNode = function(node) {
                var parent = this.tagStack[this.tagStack.length - 1];
                var previousSibling = parent.children[parent.children.length - 1];
                if (this.options.withStartIndices) {
                    node.startIndex = this.parser.startIndex;
                }
                if (this.options.withEndIndices) {
                    node.endIndex = this.parser.endIndex;
                }
                parent.children.push(node);
                if (previousSibling) {
                    node.prev = previousSibling;
                    previousSibling.next = node;
                }
                node.parent = parent;
                this.lastNode = null;
            };
            return DomHandler;
        }();
        exports.DomHandler = DomHandler;
        exports["default"] = DomHandler;
    }, (__unused_webpack_module, exports) => {
        "use strict";
        Object.defineProperty(exports, "__esModule", {
            value: true
        });
        exports.Doctype = exports.CDATA = exports.Tag = exports.Style = exports.Script = exports.Comment = exports.Directive = exports.Text = exports.Root = exports.isTag = exports.ElementType = void 0;
        var ElementType;
        (function(ElementType) {
            ElementType["Root"] = "root";
            ElementType["Text"] = "text";
            ElementType["Directive"] = "directive";
            ElementType["Comment"] = "comment";
            ElementType["Script"] = "script";
            ElementType["Style"] = "style";
            ElementType["Tag"] = "tag";
            ElementType["CDATA"] = "cdata";
            ElementType["Doctype"] = "doctype";
        })(ElementType = exports.ElementType || (exports.ElementType = {}));
        function isTag(elem) {
            return elem.type === ElementType.Tag || elem.type === ElementType.Script || elem.type === ElementType.Style;
        }
        exports.isTag = isTag;
        exports.Root = ElementType.Root;
        exports.Text = ElementType.Text;
        exports.Directive = ElementType.Directive;
        exports.Comment = ElementType.Comment;
        exports.Script = ElementType.Script;
        exports.Style = ElementType.Style;
        exports.Tag = ElementType.Tag;
        exports.CDATA = ElementType.CDATA;
        exports.Doctype = ElementType.Doctype;
    }, function(__unused_webpack_module, exports, __webpack_require__) {
        "use strict";
        var __extends = this && this.__extends || function() {
            var extendStatics = function(d, b) {
                extendStatics = Object.setPrototypeOf || {
                    __proto__: []
                } instanceof Array && function(d, b) {
                    d.__proto__ = b;
                } || function(d, b) {
                    for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p];
                };
                return extendStatics(d, b);
            };
            return function(d, b) {
                if (typeof b !== "function" && b !== null) throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
                extendStatics(d, b);
                function __() {
                    this.constructor = d;
                }
                d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __);
            };
        }();
        var __assign = this && this.__assign || function() {
            __assign = Object.assign || function(t) {
                for (var s, i = 1, n = arguments.length; i < n; i++) {
                    s = arguments[i];
                    for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
                }
                return t;
            };
            return __assign.apply(this, arguments);
        };
        Object.defineProperty(exports, "__esModule", {
            value: true
        });
        exports.cloneNode = exports.hasChildren = exports.isDocument = exports.isDirective = exports.isComment = exports.isText = exports.isCDATA = exports.isTag = exports.Element = exports.Document = exports.CDATA = exports.NodeWithChildren = exports.ProcessingInstruction = exports.Comment = exports.Text = exports.DataNode = exports.Node = void 0;
        var domelementtype_1 = __webpack_require__(35);
        var Node = function() {
            function Node() {
                this.parent = null;
                this.prev = null;
                this.next = null;
                this.startIndex = null;
                this.endIndex = null;
            }
            Object.defineProperty(Node.prototype, "parentNode", {
                get: function() {
                    return this.parent;
                },
                set: function(parent) {
                    this.parent = parent;
                },
                enumerable: false,
                configurable: true
            });
            Object.defineProperty(Node.prototype, "previousSibling", {
                get: function() {
                    return this.prev;
                },
                set: function(prev) {
                    this.prev = prev;
                },
                enumerable: false,
                configurable: true
            });
            Object.defineProperty(Node.prototype, "nextSibling", {
                get: function() {
                    return this.next;
                },
                set: function(next) {
                    this.next = next;
                },
                enumerable: false,
                configurable: true
            });
            Node.prototype.cloneNode = function(recursive) {
                if (recursive === void 0) {
                    recursive = false;
                }
                return cloneNode(this, recursive);
            };
            return Node;
        }();
        exports.Node = Node;
        var DataNode = function(_super) {
            __extends(DataNode, _super);
            function DataNode(data) {
                var _this = _super.call(this) || this;
                _this.data = data;
                return _this;
            }
            Object.defineProperty(DataNode.prototype, "nodeValue", {
                get: function() {
                    return this.data;
                },
                set: function(data) {
                    this.data = data;
                },
                enumerable: false,
                configurable: true
            });
            return DataNode;
        }(Node);
        exports.DataNode = DataNode;
        var Text = function(_super) {
            __extends(Text, _super);
            function Text() {
                var _this = _super !== null && _super.apply(this, arguments) || this;
                _this.type = domelementtype_1.ElementType.Text;
                return _this;
            }
            Object.defineProperty(Text.prototype, "nodeType", {
                get: function() {
                    return 3;
                },
                enumerable: false,
                configurable: true
            });
            return Text;
        }(DataNode);
        exports.Text = Text;
        var Comment = function(_super) {
            __extends(Comment, _super);
            function Comment() {
                var _this = _super !== null && _super.apply(this, arguments) || this;
                _this.type = domelementtype_1.ElementType.Comment;
                return _this;
            }
            Object.defineProperty(Comment.prototype, "nodeType", {
                get: function() {
                    return 8;
                },
                enumerable: false,
                configurable: true
            });
            return Comment;
        }(DataNode);
        exports.Comment = Comment;
        var ProcessingInstruction = function(_super) {
            __extends(ProcessingInstruction, _super);
            function ProcessingInstruction(name, data) {
                var _this = _super.call(this, data) || this;
                _this.name = name;
                _this.type = domelementtype_1.ElementType.Directive;
                return _this;
            }
            Object.defineProperty(ProcessingInstruction.prototype, "nodeType", {
                get: function() {
                    return 1;
                },
                enumerable: false,
                configurable: true
            });
            return ProcessingInstruction;
        }(DataNode);
        exports.ProcessingInstruction = ProcessingInstruction;
        var NodeWithChildren = function(_super) {
            __extends(NodeWithChildren, _super);
            function NodeWithChildren(children) {
                var _this = _super.call(this) || this;
                _this.children = children;
                return _this;
            }
            Object.defineProperty(NodeWithChildren.prototype, "firstChild", {
                get: function() {
                    var _a;
                    return (_a = this.children[0]) !== null && _a !== void 0 ? _a : null;
                },
                enumerable: false,
                configurable: true
            });
            Object.defineProperty(NodeWithChildren.prototype, "lastChild", {
                get: function() {
                    return this.children.length > 0 ? this.children[this.children.length - 1] : null;
                },
                enumerable: false,
                configurable: true
            });
            Object.defineProperty(NodeWithChildren.prototype, "childNodes", {
                get: function() {
                    return this.children;
                },
                set: function(children) {
                    this.children = children;
                },
                enumerable: false,
                configurable: true
            });
            return NodeWithChildren;
        }(Node);
        exports.NodeWithChildren = NodeWithChildren;
        var CDATA = function(_super) {
            __extends(CDATA, _super);
            function CDATA() {
                var _this = _super !== null && _super.apply(this, arguments) || this;
                _this.type = domelementtype_1.ElementType.CDATA;
                return _this;
            }
            Object.defineProperty(CDATA.prototype, "nodeType", {
                get: function() {
                    return 4;
                },
                enumerable: false,
                configurable: true
            });
            return CDATA;
        }(NodeWithChildren);
        exports.CDATA = CDATA;
        var Document = function(_super) {
            __extends(Document, _super);
            function Document() {
                var _this = _super !== null && _super.apply(this, arguments) || this;
                _this.type = domelementtype_1.ElementType.Root;
                return _this;
            }
            Object.defineProperty(Document.prototype, "nodeType", {
                get: function() {
                    return 9;
                },
                enumerable: false,
                configurable: true
            });
            return Document;
        }(NodeWithChildren);
        exports.Document = Document;
        var Element = function(_super) {
            __extends(Element, _super);
            function Element(name, attribs, children, type) {
                if (children === void 0) {
                    children = [];
                }
                if (type === void 0) {
                    type = name === "script" ? domelementtype_1.ElementType.Script : name === "style" ? domelementtype_1.ElementType.Style : domelementtype_1.ElementType.Tag;
                }
                var _this = _super.call(this, children) || this;
                _this.name = name;
                _this.attribs = attribs;
                _this.type = type;
                return _this;
            }
            Object.defineProperty(Element.prototype, "nodeType", {
                get: function() {
                    return 1;
                },
                enumerable: false,
                configurable: true
            });
            Object.defineProperty(Element.prototype, "tagName", {
                get: function() {
                    return this.name;
                },
                set: function(name) {
                    this.name = name;
                },
                enumerable: false,
                configurable: true
            });
            Object.defineProperty(Element.prototype, "attributes", {
                get: function() {
                    var _this = this;
                    return Object.keys(this.attribs).map((function(name) {
                        var _a, _b;
                        return {
                            name,
                            value: _this.attribs[name],
                            namespace: (_a = _this["x-attribsNamespace"]) === null || _a === void 0 ? void 0 : _a[name],
                            prefix: (_b = _this["x-attribsPrefix"]) === null || _b === void 0 ? void 0 : _b[name]
                        };
                    }));
                },
                enumerable: false,
                configurable: true
            });
            return Element;
        }(NodeWithChildren);
        exports.Element = Element;
        function isTag(node) {
            return (0, domelementtype_1.isTag)(node);
        }
        exports.isTag = isTag;
        function isCDATA(node) {
            return node.type === domelementtype_1.ElementType.CDATA;
        }
        exports.isCDATA = isCDATA;
        function isText(node) {
            return node.type === domelementtype_1.ElementType.Text;
        }
        exports.isText = isText;
        function isComment(node) {
            return node.type === domelementtype_1.ElementType.Comment;
        }
        exports.isComment = isComment;
        function isDirective(node) {
            return node.type === domelementtype_1.ElementType.Directive;
        }
        exports.isDirective = isDirective;
        function isDocument(node) {
            return node.type === domelementtype_1.ElementType.Root;
        }
        exports.isDocument = isDocument;
        function hasChildren(node) {
            return Object.prototype.hasOwnProperty.call(node, "children");
        }
        exports.hasChildren = hasChildren;
        function cloneNode(node, recursive) {
            if (recursive === void 0) {
                recursive = false;
            }
            var result;
            if (isText(node)) {
                result = new Text(node.data);
            } else if (isComment(node)) {
                result = new Comment(node.data);
            } else if (isTag(node)) {
                var children = recursive ? cloneChildren(node.children) : [];
                var clone_1 = new Element(node.name, __assign({}, node.attribs), children);
                children.forEach((function(child) {
                    return child.parent = clone_1;
                }));
                if (node.namespace != null) {
                    clone_1.namespace = node.namespace;
                }
                if (node["x-attribsNamespace"]) {
                    clone_1["x-attribsNamespace"] = __assign({}, node["x-attribsNamespace"]);
                }
                if (node["x-attribsPrefix"]) {
                    clone_1["x-attribsPrefix"] = __assign({}, node["x-attribsPrefix"]);
                }
                result = clone_1;
            } else if (isCDATA(node)) {
                var children = recursive ? cloneChildren(node.children) : [];
                var clone_2 = new CDATA(children);
                children.forEach((function(child) {
                    return child.parent = clone_2;
                }));
                result = clone_2;
            } else if (isDocument(node)) {
                var children = recursive ? cloneChildren(node.children) : [];
                var clone_3 = new Document(children);
                children.forEach((function(child) {
                    return child.parent = clone_3;
                }));
                if (node["x-mode"]) {
                    clone_3["x-mode"] = node["x-mode"];
                }
                result = clone_3;
            } else if (isDirective(node)) {
                var instruction = new ProcessingInstruction(node.name, node.data);
                if (node["x-name"] != null) {
                    instruction["x-name"] = node["x-name"];
                    instruction["x-publicId"] = node["x-publicId"];
                    instruction["x-systemId"] = node["x-systemId"];
                }
                result = instruction;
            } else {
                throw new Error("Not implemented yet: ".concat(node.type));
            }
            result.startIndex = node.startIndex;
            result.endIndex = node.endIndex;
            if (node.sourceCodeLocation != null) {
                result.sourceCodeLocation = node.sourceCodeLocation;
            }
            return result;
        }
        exports.cloneNode = cloneNode;
        function cloneChildren(childs) {
            var children = childs.map((function(child) {
                return cloneNode(child, true);
            }));
            for (var i = 1; i < children.length; i++) {
                children[i].prev = children[i - 1];
                children[i - 1].next = children[i];
            }
            return children;
        }
    }, (__unused_webpack_module, exports) => {
        exports.CASE_SENSITIVE_TAG_NAMES = [ "animateMotion", "animateTransform", "clipPath", "feBlend", "feColorMatrix", "feComponentTransfer", "feComposite", "feConvolveMatrix", "feDiffuseLighting", "feDisplacementMap", "feDropShadow", "feFlood", "feFuncA", "feFuncB", "feFuncG", "feFuncR", "feGaussainBlur", "feImage", "feMerge", "feMergeNode", "feMorphology", "feOffset", "fePointLight", "feSpecularLighting", "feSpotLight", "feTile", "feTurbulence", "foreignObject", "linearGradient", "radialGradient", "textPath" ];
    }, module => {
        "use strict";
        module.exports = window.wp.editPost;
    }, module => {
        "use strict";
        module.exports = window.wp.compose;
    }, module => {
        "use strict";
        module.exports = window.wp.components;
    }, module => {
        "use strict";
        module.exports = window.wp.data;
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            __: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__.__,
            _n: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__._n,
            _nx: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__._nx,
            _x: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__._x,
            createI18n: () => _create_i18n__WEBPACK_IMPORTED_MODULE_1__.createI18n,
            defaultI18n: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__["default"],
            getLocaleData: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__.getLocaleData,
            hasTranslation: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__.hasTranslation,
            isRTL: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__.isRTL,
            resetLocaleData: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__.resetLocaleData,
            setLocaleData: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__.setLocaleData,
            sprintf: () => _sprintf__WEBPACK_IMPORTED_MODULE_0__.sprintf,
            subscribe: () => _default_i18n__WEBPACK_IMPORTED_MODULE_2__.subscribe
        });
        var _sprintf__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(43);
        var _create_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(46);
        var _default_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(52);
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            sprintf: () => sprintf
        });
        var memize__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(44);
        var memize__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(memize__WEBPACK_IMPORTED_MODULE_0__);
        var sprintf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(45);
        var sprintf_js__WEBPACK_IMPORTED_MODULE_1___default = __webpack_require__.n(sprintf_js__WEBPACK_IMPORTED_MODULE_1__);
        const logErrorOnce = memize__WEBPACK_IMPORTED_MODULE_0___default()(console.error);
        function sprintf(format) {
            try {
                for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                    args[_key - 1] = arguments[_key];
                }
                return sprintf_js__WEBPACK_IMPORTED_MODULE_1___default().sprintf(format, ...args);
            } catch (error) {
                if (error instanceof Error) {
                    logErrorOnce("sprintf error: \n\n" + error.toString());
                }
                return format;
            }
        }
    }, module => {
        function memize(fn, options) {
            var size = 0;
            var head;
            var tail;
            options = options || {};
            function memoized() {
                var node = head, len = arguments.length, args, i;
                searchCache: while (node) {
                    if (node.args.length !== arguments.length) {
                        node = node.next;
                        continue;
                    }
                    for (i = 0; i < len; i++) {
                        if (node.args[i] !== arguments[i]) {
                            node = node.next;
                            continue searchCache;
                        }
                    }
                    if (node !== head) {
                        if (node === tail) {
                            tail = node.prev;
                        }
                        node.prev.next = node.next;
                        if (node.next) {
                            node.next.prev = node.prev;
                        }
                        node.next = head;
                        node.prev = null;
                        head.prev = node;
                        head = node;
                    }
                    return node.val;
                }
                args = new Array(len);
                for (i = 0; i < len; i++) {
                    args[i] = arguments[i];
                }
                node = {
                    args,
                    val: fn.apply(null, args)
                };
                if (head) {
                    head.prev = node;
                    node.next = head;
                } else {
                    tail = node;
                }
                if (size === options.maxSize) {
                    tail = tail.prev;
                    tail.next = null;
                } else {
                    size++;
                }
                head = node;
                return node.val;
            }
            memoized.clear = function() {
                head = null;
                tail = null;
                size = 0;
            };
            if (false) {}
            return memoized;
        }
        module.exports = memize;
    }, (module, exports, __webpack_require__) => {
        var __WEBPACK_AMD_DEFINE_RESULT__;
        !function() {
            "use strict";
            var re = {
                not_string: /[^s]/,
                not_bool: /[^t]/,
                not_type: /[^T]/,
                not_primitive: /[^v]/,
                number: /[diefg]/,
                numeric_arg: /[bcdiefguxX]/,
                json: /[j]/,
                not_json: /[^j]/,
                text: /^[^\x25]+/,
                modulo: /^\x25{2}/,
                placeholder: /^\x25(?:([1-9]\d*)\$|\(([^)]+)\))?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-gijostTuvxX])/,
                key: /^([a-z_][a-z_\d]*)/i,
                key_access: /^\.([a-z_][a-z_\d]*)/i,
                index_access: /^\[(\d+)\]/,
                sign: /^[+-]/
            };
            function sprintf(key) {
                return sprintf_format(sprintf_parse(key), arguments);
            }
            function vsprintf(fmt, argv) {
                return sprintf.apply(null, [ fmt ].concat(argv || []));
            }
            function sprintf_format(parse_tree, argv) {
                var cursor = 1, tree_length = parse_tree.length, arg, output = "", i, k, ph, pad, pad_character, pad_length, is_positive, sign;
                for (i = 0; i < tree_length; i++) {
                    if (typeof parse_tree[i] === "string") {
                        output += parse_tree[i];
                    } else if (typeof parse_tree[i] === "object") {
                        ph = parse_tree[i];
                        if (ph.keys) {
                            arg = argv[cursor];
                            for (k = 0; k < ph.keys.length; k++) {
                                if (arg == undefined) {
                                    throw new Error(sprintf('[sprintf] Cannot access property "%s" of undefined value "%s"', ph.keys[k], ph.keys[k - 1]));
                                }
                                arg = arg[ph.keys[k]];
                            }
                        } else if (ph.param_no) {
                            arg = argv[ph.param_no];
                        } else {
                            arg = argv[cursor++];
                        }
                        if (re.not_type.test(ph.type) && re.not_primitive.test(ph.type) && arg instanceof Function) {
                            arg = arg();
                        }
                        if (re.numeric_arg.test(ph.type) && (typeof arg !== "number" && isNaN(arg))) {
                            throw new TypeError(sprintf("[sprintf] expecting number but found %T", arg));
                        }
                        if (re.number.test(ph.type)) {
                            is_positive = arg >= 0;
                        }
                        switch (ph.type) {
                          case "b":
                            arg = parseInt(arg, 10).toString(2);
                            break;

                          case "c":
                            arg = String.fromCharCode(parseInt(arg, 10));
                            break;

                          case "d":
                          case "i":
                            arg = parseInt(arg, 10);
                            break;

                          case "j":
                            arg = JSON.stringify(arg, null, ph.width ? parseInt(ph.width) : 0);
                            break;

                          case "e":
                            arg = ph.precision ? parseFloat(arg).toExponential(ph.precision) : parseFloat(arg).toExponential();
                            break;

                          case "f":
                            arg = ph.precision ? parseFloat(arg).toFixed(ph.precision) : parseFloat(arg);
                            break;

                          case "g":
                            arg = ph.precision ? String(Number(arg.toPrecision(ph.precision))) : parseFloat(arg);
                            break;

                          case "o":
                            arg = (parseInt(arg, 10) >>> 0).toString(8);
                            break;

                          case "s":
                            arg = String(arg);
                            arg = ph.precision ? arg.substring(0, ph.precision) : arg;
                            break;

                          case "t":
                            arg = String(!!arg);
                            arg = ph.precision ? arg.substring(0, ph.precision) : arg;
                            break;

                          case "T":
                            arg = Object.prototype.toString.call(arg).slice(8, -1).toLowerCase();
                            arg = ph.precision ? arg.substring(0, ph.precision) : arg;
                            break;

                          case "u":
                            arg = parseInt(arg, 10) >>> 0;
                            break;

                          case "v":
                            arg = arg.valueOf();
                            arg = ph.precision ? arg.substring(0, ph.precision) : arg;
                            break;

                          case "x":
                            arg = (parseInt(arg, 10) >>> 0).toString(16);
                            break;

                          case "X":
                            arg = (parseInt(arg, 10) >>> 0).toString(16).toUpperCase();
                            break;
                        }
                        if (re.json.test(ph.type)) {
                            output += arg;
                        } else {
                            if (re.number.test(ph.type) && (!is_positive || ph.sign)) {
                                sign = is_positive ? "+" : "-";
                                arg = arg.toString().replace(re.sign, "");
                            } else {
                                sign = "";
                            }
                            pad_character = ph.pad_char ? ph.pad_char === "0" ? "0" : ph.pad_char.charAt(1) : " ";
                            pad_length = ph.width - (sign + arg).length;
                            pad = ph.width ? pad_length > 0 ? pad_character.repeat(pad_length) : "" : "";
                            output += ph.align ? sign + arg + pad : pad_character === "0" ? sign + pad + arg : pad + sign + arg;
                        }
                    }
                }
                return output;
            }
            var sprintf_cache = Object.create(null);
            function sprintf_parse(fmt) {
                if (sprintf_cache[fmt]) {
                    return sprintf_cache[fmt];
                }
                var _fmt = fmt, match, parse_tree = [], arg_names = 0;
                while (_fmt) {
                    if ((match = re.text.exec(_fmt)) !== null) {
                        parse_tree.push(match[0]);
                    } else if ((match = re.modulo.exec(_fmt)) !== null) {
                        parse_tree.push("%");
                    } else if ((match = re.placeholder.exec(_fmt)) !== null) {
                        if (match[2]) {
                            arg_names |= 1;
                            var field_list = [], replacement_field = match[2], field_match = [];
                            if ((field_match = re.key.exec(replacement_field)) !== null) {
                                field_list.push(field_match[1]);
                                while ((replacement_field = replacement_field.substring(field_match[0].length)) !== "") {
                                    if ((field_match = re.key_access.exec(replacement_field)) !== null) {
                                        field_list.push(field_match[1]);
                                    } else if ((field_match = re.index_access.exec(replacement_field)) !== null) {
                                        field_list.push(field_match[1]);
                                    } else {
                                        throw new SyntaxError("[sprintf] failed to parse named argument key");
                                    }
                                }
                            } else {
                                throw new SyntaxError("[sprintf] failed to parse named argument key");
                            }
                            match[2] = field_list;
                        } else {
                            arg_names |= 2;
                        }
                        if (arg_names === 3) {
                            throw new Error("[sprintf] mixing positional and named placeholders is not (yet) supported");
                        }
                        parse_tree.push({
                            placeholder: match[0],
                            param_no: match[1],
                            keys: match[2],
                            sign: match[3],
                            pad_char: match[4],
                            align: match[5],
                            width: match[6],
                            precision: match[7],
                            type: match[8]
                        });
                    } else {
                        throw new SyntaxError("[sprintf] unexpected placeholder");
                    }
                    _fmt = _fmt.substring(match[0].length);
                }
                return sprintf_cache[fmt] = parse_tree;
            }
            if (true) {
                exports.sprintf = sprintf;
                exports.vsprintf = vsprintf;
            }
            if (typeof window !== "undefined") {
                window["sprintf"] = sprintf;
                window["vsprintf"] = vsprintf;
                if (true) {
                    !(__WEBPACK_AMD_DEFINE_RESULT__ = function() {
                        return {
                            sprintf,
                            vsprintf
                        };
                    }.call(exports, __webpack_require__, exports, module), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                }
            }
        }();
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            createI18n: () => createI18n
        });
        var tannin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(47);
        const DEFAULT_LOCALE_DATA = {
            "": {
                plural_forms(n) {
                    return n === 1 ? 0 : 1;
                }
            }
        };
        const I18N_HOOK_REGEXP = /^i18n\.(n?gettext|has_translation)(_|$)/;
        const createI18n = (initialData, initialDomain, hooks) => {
            const tannin = new tannin__WEBPACK_IMPORTED_MODULE_0__["default"]({});
            const listeners = new Set;
            const notifyListeners = () => {
                listeners.forEach((listener => listener()));
            };
            const subscribe = callback => {
                listeners.add(callback);
                return () => listeners.delete(callback);
            };
            const getLocaleData = function() {
                let domain = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "default";
                return tannin.data[domain];
            };
            const doSetLocaleData = function(data) {
                var _tannin$data$domain;
                let domain = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "default";
                tannin.data[domain] = {
                    ...tannin.data[domain],
                    ...data
                };
                tannin.data[domain][""] = {
                    ...DEFAULT_LOCALE_DATA[""],
                    ...(_tannin$data$domain = tannin.data[domain]) === null || _tannin$data$domain === void 0 ? void 0 : _tannin$data$domain[""]
                };
                delete tannin.pluralForms[domain];
            };
            const setLocaleData = (data, domain) => {
                doSetLocaleData(data, domain);
                notifyListeners();
            };
            const addLocaleData = function(data) {
                var _tannin$data$domain2;
                let domain = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "default";
                tannin.data[domain] = {
                    ...tannin.data[domain],
                    ...data,
                    "": {
                        ...DEFAULT_LOCALE_DATA[""],
                        ...(_tannin$data$domain2 = tannin.data[domain]) === null || _tannin$data$domain2 === void 0 ? void 0 : _tannin$data$domain2[""],
                        ...data === null || data === void 0 ? void 0 : data[""]
                    }
                };
                delete tannin.pluralForms[domain];
                notifyListeners();
            };
            const resetLocaleData = (data, domain) => {
                tannin.data = {};
                tannin.pluralForms = {};
                setLocaleData(data, domain);
            };
            const dcnpgettext = function() {
                let domain = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "default";
                let context = arguments.length > 1 ? arguments[1] : undefined;
                let single = arguments.length > 2 ? arguments[2] : undefined;
                let plural = arguments.length > 3 ? arguments[3] : undefined;
                let number = arguments.length > 4 ? arguments[4] : undefined;
                if (!tannin.data[domain]) {
                    doSetLocaleData(undefined, domain);
                }
                return tannin.dcnpgettext(domain, context, single, plural, number);
            };
            const getFilterDomain = function() {
                let domain = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "default";
                return domain;
            };
            const __ = (text, domain) => {
                let translation = dcnpgettext(domain, undefined, text);
                if (!hooks) {
                    return translation;
                }
                translation = hooks.applyFilters("i18n.gettext", translation, text, domain);
                return hooks.applyFilters("i18n.gettext_" + getFilterDomain(domain), translation, text, domain);
            };
            const _x = (text, context, domain) => {
                let translation = dcnpgettext(domain, context, text);
                if (!hooks) {
                    return translation;
                }
                translation = hooks.applyFilters("i18n.gettext_with_context", translation, text, context, domain);
                return hooks.applyFilters("i18n.gettext_with_context_" + getFilterDomain(domain), translation, text, context, domain);
            };
            const _n = (single, plural, number, domain) => {
                let translation = dcnpgettext(domain, undefined, single, plural, number);
                if (!hooks) {
                    return translation;
                }
                translation = hooks.applyFilters("i18n.ngettext", translation, single, plural, number, domain);
                return hooks.applyFilters("i18n.ngettext_" + getFilterDomain(domain), translation, single, plural, number, domain);
            };
            const _nx = (single, plural, number, context, domain) => {
                let translation = dcnpgettext(domain, context, single, plural, number);
                if (!hooks) {
                    return translation;
                }
                translation = hooks.applyFilters("i18n.ngettext_with_context", translation, single, plural, number, context, domain);
                return hooks.applyFilters("i18n.ngettext_with_context_" + getFilterDomain(domain), translation, single, plural, number, context, domain);
            };
            const isRTL = () => "rtl" === _x("ltr", "text direction");
            const hasTranslation = (single, context, domain) => {
                var _tannin$data, _tannin$data2;
                const key = context ? context + "" + single : single;
                let result = !!((_tannin$data = tannin.data) !== null && _tannin$data !== void 0 && (_tannin$data2 = _tannin$data[domain !== null && domain !== void 0 ? domain : "default"]) !== null && _tannin$data2 !== void 0 && _tannin$data2[key]);
                if (hooks) {
                    result = hooks.applyFilters("i18n.has_translation", result, single, context, domain);
                    result = hooks.applyFilters("i18n.has_translation_" + getFilterDomain(domain), result, single, context, domain);
                }
                return result;
            };
            if (initialData) {
                setLocaleData(initialData, initialDomain);
            }
            if (hooks) {
                const onHookAddedOrRemoved = hookName => {
                    if (I18N_HOOK_REGEXP.test(hookName)) {
                        notifyListeners();
                    }
                };
                hooks.addAction("hookAdded", "core/i18n", onHookAddedOrRemoved);
                hooks.addAction("hookRemoved", "core/i18n", onHookAddedOrRemoved);
            }
            return {
                getLocaleData,
                setLocaleData,
                addLocaleData,
                resetLocaleData,
                subscribe,
                __,
                _x,
                _n,
                _nx,
                isRTL,
                hasTranslation
            };
        };
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => Tannin
        });
        var _tannin_plural_forms__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(48);
        var DEFAULT_OPTIONS = {
            contextDelimiter: "",
            onMissingKey: null
        };
        function getPluralExpression(pf) {
            var parts, i, part;
            parts = pf.split(";");
            for (i = 0; i < parts.length; i++) {
                part = parts[i].trim();
                if (part.indexOf("plural=") === 0) {
                    return part.substr(7);
                }
            }
        }
        function Tannin(data, options) {
            var key;
            this.data = data;
            this.pluralForms = {};
            this.options = {};
            for (key in DEFAULT_OPTIONS) {
                this.options[key] = options !== undefined && key in options ? options[key] : DEFAULT_OPTIONS[key];
            }
        }
        Tannin.prototype.getPluralForm = function(domain, n) {
            var getPluralForm = this.pluralForms[domain], config, plural, pf;
            if (!getPluralForm) {
                config = this.data[domain][""];
                pf = config["Plural-Forms"] || config["plural-forms"] || config.plural_forms;
                if (typeof pf !== "function") {
                    plural = getPluralExpression(config["Plural-Forms"] || config["plural-forms"] || config.plural_forms);
                    pf = (0, _tannin_plural_forms__WEBPACK_IMPORTED_MODULE_0__["default"])(plural);
                }
                getPluralForm = this.pluralForms[domain] = pf;
            }
            return getPluralForm(n);
        };
        Tannin.prototype.dcnpgettext = function(domain, context, singular, plural, n) {
            var index, key, entry;
            if (n === undefined) {
                index = 0;
            } else {
                index = this.getPluralForm(domain, n);
            }
            key = singular;
            if (context) {
                key = context + this.options.contextDelimiter + singular;
            }
            entry = this.data[domain][key];
            if (entry && entry[index]) {
                return entry[index];
            }
            if (this.options.onMissingKey) {
                this.options.onMissingKey(singular, domain);
            }
            return index === 0 ? singular : plural;
        };
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => pluralForms
        });
        var _tannin_compile__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(49);
        function pluralForms(expression) {
            var evaluate = (0, _tannin_compile__WEBPACK_IMPORTED_MODULE_0__["default"])(expression);
            return function(n) {
                return +evaluate({
                    n
                });
            };
        }
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => compile
        });
        var _tannin_postfix__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(50);
        var _tannin_evaluate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(51);
        function compile(expression) {
            var terms = (0, _tannin_postfix__WEBPACK_IMPORTED_MODULE_0__["default"])(expression);
            return function(variables) {
                return (0, _tannin_evaluate__WEBPACK_IMPORTED_MODULE_1__["default"])(terms, variables);
            };
        }
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => postfix
        });
        var PRECEDENCE, OPENERS, TERMINATORS, PATTERN;
        PRECEDENCE = {
            "(": 9,
            "!": 8,
            "*": 7,
            "/": 7,
            "%": 7,
            "+": 6,
            "-": 6,
            "<": 5,
            "<=": 5,
            ">": 5,
            ">=": 5,
            "==": 4,
            "!=": 4,
            "&&": 3,
            "||": 2,
            "?": 1,
            "?:": 1
        };
        OPENERS = [ "(", "?" ];
        TERMINATORS = {
            ")": [ "(" ],
            ":": [ "?", "?:" ]
        };
        PATTERN = /<=|>=|==|!=|&&|\|\||\?:|\(|!|\*|\/|%|\+|-|<|>|\?|\)|:/;
        function postfix(expression) {
            var terms = [], stack = [], match, operator, term, element;
            while (match = expression.match(PATTERN)) {
                operator = match[0];
                term = expression.substr(0, match.index).trim();
                if (term) {
                    terms.push(term);
                }
                while (element = stack.pop()) {
                    if (TERMINATORS[operator]) {
                        if (TERMINATORS[operator][0] === element) {
                            operator = TERMINATORS[operator][1] || operator;
                            break;
                        }
                    } else if (OPENERS.indexOf(element) >= 0 || PRECEDENCE[element] < PRECEDENCE[operator]) {
                        stack.push(element);
                        break;
                    }
                    terms.push(element);
                }
                if (!TERMINATORS[operator]) {
                    stack.push(operator);
                }
                expression = expression.substr(match.index + operator.length);
            }
            expression = expression.trim();
            if (expression) {
                terms.push(expression);
            }
            return terms.concat(stack.reverse());
        }
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            default: () => evaluate
        });
        var OPERATORS = {
            "!": function(a) {
                return !a;
            },
            "*": function(a, b) {
                return a * b;
            },
            "/": function(a, b) {
                return a / b;
            },
            "%": function(a, b) {
                return a % b;
            },
            "+": function(a, b) {
                return a + b;
            },
            "-": function(a, b) {
                return a - b;
            },
            "<": function(a, b) {
                return a < b;
            },
            "<=": function(a, b) {
                return a <= b;
            },
            ">": function(a, b) {
                return a > b;
            },
            ">=": function(a, b) {
                return a >= b;
            },
            "==": function(a, b) {
                return a === b;
            },
            "!=": function(a, b) {
                return a !== b;
            },
            "&&": function(a, b) {
                return a && b;
            },
            "||": function(a, b) {
                return a || b;
            },
            "?:": function(a, b, c) {
                if (a) {
                    throw b;
                }
                return c;
            }
        };
        function evaluate(postfix, variables) {
            var stack = [], i, j, args, getOperatorResult, term, value;
            for (i = 0; i < postfix.length; i++) {
                term = postfix[i];
                getOperatorResult = OPERATORS[term];
                if (getOperatorResult) {
                    j = getOperatorResult.length;
                    args = Array(j);
                    while (j--) {
                        args[j] = stack.pop();
                    }
                    try {
                        value = getOperatorResult.apply(null, args);
                    } catch (earlyReturn) {
                        return earlyReturn;
                    }
                } else if (variables.hasOwnProperty(term)) {
                    value = variables[term];
                } else {
                    value = +term;
                }
                stack.push(value);
            }
            return stack[0];
        }
    }, (__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            __: () => __,
            _n: () => _n,
            _nx: () => _nx,
            _x: () => _x,
            default: () => __WEBPACK_DEFAULT_EXPORT__,
            getLocaleData: () => getLocaleData,
            hasTranslation: () => hasTranslation,
            isRTL: () => isRTL,
            resetLocaleData: () => resetLocaleData,
            setLocaleData: () => setLocaleData,
            subscribe: () => subscribe
        });
        var _create_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(46);
        var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(53);
        var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1___default = __webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__);
        const i18n = (0, _create_i18n__WEBPACK_IMPORTED_MODULE_0__.createI18n)(undefined, undefined, _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__.defaultHooks);
        const __WEBPACK_DEFAULT_EXPORT__ = i18n;
        const getLocaleData = i18n.getLocaleData.bind(i18n);
        const setLocaleData = i18n.setLocaleData.bind(i18n);
        const resetLocaleData = i18n.resetLocaleData.bind(i18n);
        const subscribe = i18n.subscribe.bind(i18n);
        const __ = i18n.__.bind(i18n);
        const _x = i18n._x.bind(i18n);
        const _n = i18n._n.bind(i18n);
        const _nx = i18n._nx.bind(i18n);
        const isRTL = i18n.isRTL.bind(i18n);
        const hasTranslation = i18n.hasTranslation.bind(i18n);
    }, module => {
        "use strict";
        module.exports = window.wp.hooks;
    }, (module, __unused_webpack_exports, __webpack_require__) => {
        "use strict";
        if (false) {} else {
            module.exports = __webpack_require__(55);
        }
    }, (__unused_webpack_module, exports, __webpack_require__) => {
        "use strict";
        /** @license React v17.0.2
 * react-jsx-runtime.development.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */        if (true) {
            (function() {
                "use strict";
                var React = __webpack_require__(22);
                var _assign = __webpack_require__(56);
                var REACT_ELEMENT_TYPE = 60103;
                var REACT_PORTAL_TYPE = 60106;
                exports.Fragment = 60107;
                var REACT_STRICT_MODE_TYPE = 60108;
                var REACT_PROFILER_TYPE = 60114;
                var REACT_PROVIDER_TYPE = 60109;
                var REACT_CONTEXT_TYPE = 60110;
                var REACT_FORWARD_REF_TYPE = 60112;
                var REACT_SUSPENSE_TYPE = 60113;
                var REACT_SUSPENSE_LIST_TYPE = 60120;
                var REACT_MEMO_TYPE = 60115;
                var REACT_LAZY_TYPE = 60116;
                var REACT_BLOCK_TYPE = 60121;
                var REACT_SERVER_BLOCK_TYPE = 60122;
                var REACT_FUNDAMENTAL_TYPE = 60117;
                var REACT_SCOPE_TYPE = 60119;
                var REACT_OPAQUE_ID_TYPE = 60128;
                var REACT_DEBUG_TRACING_MODE_TYPE = 60129;
                var REACT_OFFSCREEN_TYPE = 60130;
                var REACT_LEGACY_HIDDEN_TYPE = 60131;
                if (typeof Symbol === "function" && Symbol.for) {
                    var symbolFor = Symbol.for;
                    REACT_ELEMENT_TYPE = symbolFor("react.element");
                    REACT_PORTAL_TYPE = symbolFor("react.portal");
                    exports.Fragment = symbolFor("react.fragment");
                    REACT_STRICT_MODE_TYPE = symbolFor("react.strict_mode");
                    REACT_PROFILER_TYPE = symbolFor("react.profiler");
                    REACT_PROVIDER_TYPE = symbolFor("react.provider");
                    REACT_CONTEXT_TYPE = symbolFor("react.context");
                    REACT_FORWARD_REF_TYPE = symbolFor("react.forward_ref");
                    REACT_SUSPENSE_TYPE = symbolFor("react.suspense");
                    REACT_SUSPENSE_LIST_TYPE = symbolFor("react.suspense_list");
                    REACT_MEMO_TYPE = symbolFor("react.memo");
                    REACT_LAZY_TYPE = symbolFor("react.lazy");
                    REACT_BLOCK_TYPE = symbolFor("react.block");
                    REACT_SERVER_BLOCK_TYPE = symbolFor("react.server.block");
                    REACT_FUNDAMENTAL_TYPE = symbolFor("react.fundamental");
                    REACT_SCOPE_TYPE = symbolFor("react.scope");
                    REACT_OPAQUE_ID_TYPE = symbolFor("react.opaque.id");
                    REACT_DEBUG_TRACING_MODE_TYPE = symbolFor("react.debug_trace_mode");
                    REACT_OFFSCREEN_TYPE = symbolFor("react.offscreen");
                    REACT_LEGACY_HIDDEN_TYPE = symbolFor("react.legacy_hidden");
                }
                var MAYBE_ITERATOR_SYMBOL = typeof Symbol === "function" && Symbol.iterator;
                var FAUX_ITERATOR_SYMBOL = "@@iterator";
                function getIteratorFn(maybeIterable) {
                    if (maybeIterable === null || typeof maybeIterable !== "object") {
                        return null;
                    }
                    var maybeIterator = MAYBE_ITERATOR_SYMBOL && maybeIterable[MAYBE_ITERATOR_SYMBOL] || maybeIterable[FAUX_ITERATOR_SYMBOL];
                    if (typeof maybeIterator === "function") {
                        return maybeIterator;
                    }
                    return null;
                }
                var ReactSharedInternals = React.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED;
                function error(format) {
                    {
                        for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
                            args[_key2 - 1] = arguments[_key2];
                        }
                        printWarning("error", format, args);
                    }
                }
                function printWarning(level, format, args) {
                    {
                        var ReactDebugCurrentFrame = ReactSharedInternals.ReactDebugCurrentFrame;
                        var stack = ReactDebugCurrentFrame.getStackAddendum();
                        if (stack !== "") {
                            format += "%s";
                            args = args.concat([ stack ]);
                        }
                        var argsWithFormat = args.map((function(item) {
                            return "" + item;
                        }));
                        argsWithFormat.unshift("Warning: " + format);
                        Function.prototype.apply.call(console[level], console, argsWithFormat);
                    }
                }
                var enableScopeAPI = false;
                function isValidElementType(type) {
                    if (typeof type === "string" || typeof type === "function") {
                        return true;
                    }
                    if (type === exports.Fragment || type === REACT_PROFILER_TYPE || type === REACT_DEBUG_TRACING_MODE_TYPE || type === REACT_STRICT_MODE_TYPE || type === REACT_SUSPENSE_TYPE || type === REACT_SUSPENSE_LIST_TYPE || type === REACT_LEGACY_HIDDEN_TYPE || enableScopeAPI) {
                        return true;
                    }
                    if (typeof type === "object" && type !== null) {
                        if (type.$$typeof === REACT_LAZY_TYPE || type.$$typeof === REACT_MEMO_TYPE || type.$$typeof === REACT_PROVIDER_TYPE || type.$$typeof === REACT_CONTEXT_TYPE || type.$$typeof === REACT_FORWARD_REF_TYPE || type.$$typeof === REACT_FUNDAMENTAL_TYPE || type.$$typeof === REACT_BLOCK_TYPE || type[0] === REACT_SERVER_BLOCK_TYPE) {
                            return true;
                        }
                    }
                    return false;
                }
                function getWrappedName(outerType, innerType, wrapperName) {
                    var functionName = innerType.displayName || innerType.name || "";
                    return outerType.displayName || (functionName !== "" ? wrapperName + "(" + functionName + ")" : wrapperName);
                }
                function getContextName(type) {
                    return type.displayName || "Context";
                }
                function getComponentName(type) {
                    if (type == null) {
                        return null;
                    }
                    {
                        if (typeof type.tag === "number") {
                            error("Received an unexpected object in getComponentName(). " + "This is likely a bug in React. Please file an issue.");
                        }
                    }
                    if (typeof type === "function") {
                        return type.displayName || type.name || null;
                    }
                    if (typeof type === "string") {
                        return type;
                    }
                    switch (type) {
                      case exports.Fragment:
                        return "Fragment";

                      case REACT_PORTAL_TYPE:
                        return "Portal";

                      case REACT_PROFILER_TYPE:
                        return "Profiler";

                      case REACT_STRICT_MODE_TYPE:
                        return "StrictMode";

                      case REACT_SUSPENSE_TYPE:
                        return "Suspense";

                      case REACT_SUSPENSE_LIST_TYPE:
                        return "SuspenseList";
                    }
                    if (typeof type === "object") {
                        switch (type.$$typeof) {
                          case REACT_CONTEXT_TYPE:
                            var context = type;
                            return getContextName(context) + ".Consumer";

                          case REACT_PROVIDER_TYPE:
                            var provider = type;
                            return getContextName(provider._context) + ".Provider";

                          case REACT_FORWARD_REF_TYPE:
                            return getWrappedName(type, type.render, "ForwardRef");

                          case REACT_MEMO_TYPE:
                            return getComponentName(type.type);

                          case REACT_BLOCK_TYPE:
                            return getComponentName(type._render);

                          case REACT_LAZY_TYPE:
                            {
                                var lazyComponent = type;
                                var payload = lazyComponent._payload;
                                var init = lazyComponent._init;
                                try {
                                    return getComponentName(init(payload));
                                } catch (x) {
                                    return null;
                                }
                            }
                        }
                    }
                    return null;
                }
                var disabledDepth = 0;
                var prevLog;
                var prevInfo;
                var prevWarn;
                var prevError;
                var prevGroup;
                var prevGroupCollapsed;
                var prevGroupEnd;
                function disabledLog() {}
                disabledLog.__reactDisabledLog = true;
                function disableLogs() {
                    {
                        if (disabledDepth === 0) {
                            prevLog = console.log;
                            prevInfo = console.info;
                            prevWarn = console.warn;
                            prevError = console.error;
                            prevGroup = console.group;
                            prevGroupCollapsed = console.groupCollapsed;
                            prevGroupEnd = console.groupEnd;
                            var props = {
                                configurable: true,
                                enumerable: true,
                                value: disabledLog,
                                writable: true
                            };
                            Object.defineProperties(console, {
                                info: props,
                                log: props,
                                warn: props,
                                error: props,
                                group: props,
                                groupCollapsed: props,
                                groupEnd: props
                            });
                        }
                        disabledDepth++;
                    }
                }
                function reenableLogs() {
                    {
                        disabledDepth--;
                        if (disabledDepth === 0) {
                            var props = {
                                configurable: true,
                                enumerable: true,
                                writable: true
                            };
                            Object.defineProperties(console, {
                                log: _assign({}, props, {
                                    value: prevLog
                                }),
                                info: _assign({}, props, {
                                    value: prevInfo
                                }),
                                warn: _assign({}, props, {
                                    value: prevWarn
                                }),
                                error: _assign({}, props, {
                                    value: prevError
                                }),
                                group: _assign({}, props, {
                                    value: prevGroup
                                }),
                                groupCollapsed: _assign({}, props, {
                                    value: prevGroupCollapsed
                                }),
                                groupEnd: _assign({}, props, {
                                    value: prevGroupEnd
                                })
                            });
                        }
                        if (disabledDepth < 0) {
                            error("disabledDepth fell below zero. " + "This is a bug in React. Please file an issue.");
                        }
                    }
                }
                var ReactCurrentDispatcher = ReactSharedInternals.ReactCurrentDispatcher;
                var prefix;
                function describeBuiltInComponentFrame(name, source, ownerFn) {
                    {
                        if (prefix === undefined) {
                            try {
                                throw Error();
                            } catch (x) {
                                var match = x.stack.trim().match(/\n( *(at )?)/);
                                prefix = match && match[1] || "";
                            }
                        }
                        return "\n" + prefix + name;
                    }
                }
                var reentry = false;
                var componentFrameCache;
                {
                    var PossiblyWeakMap = typeof WeakMap === "function" ? WeakMap : Map;
                    componentFrameCache = new PossiblyWeakMap;
                }
                function describeNativeComponentFrame(fn, construct) {
                    if (!fn || reentry) {
                        return "";
                    }
                    {
                        var frame = componentFrameCache.get(fn);
                        if (frame !== undefined) {
                            return frame;
                        }
                    }
                    var control;
                    reentry = true;
                    var previousPrepareStackTrace = Error.prepareStackTrace;
                    Error.prepareStackTrace = undefined;
                    var previousDispatcher;
                    {
                        previousDispatcher = ReactCurrentDispatcher.current;
                        ReactCurrentDispatcher.current = null;
                        disableLogs();
                    }
                    try {
                        if (construct) {
                            var Fake = function() {
                                throw Error();
                            };
                            Object.defineProperty(Fake.prototype, "props", {
                                set: function() {
                                    throw Error();
                                }
                            });
                            if (typeof Reflect === "object" && Reflect.construct) {
                                try {
                                    Reflect.construct(Fake, []);
                                } catch (x) {
                                    control = x;
                                }
                                Reflect.construct(fn, [], Fake);
                            } else {
                                try {
                                    Fake.call();
                                } catch (x) {
                                    control = x;
                                }
                                fn.call(Fake.prototype);
                            }
                        } else {
                            try {
                                throw Error();
                            } catch (x) {
                                control = x;
                            }
                            fn();
                        }
                    } catch (sample) {
                        if (sample && control && typeof sample.stack === "string") {
                            var sampleLines = sample.stack.split("\n");
                            var controlLines = control.stack.split("\n");
                            var s = sampleLines.length - 1;
                            var c = controlLines.length - 1;
                            while (s >= 1 && c >= 0 && sampleLines[s] !== controlLines[c]) {
                                c--;
                            }
                            for (;s >= 1 && c >= 0; s--, c--) {
                                if (sampleLines[s] !== controlLines[c]) {
                                    if (s !== 1 || c !== 1) {
                                        do {
                                            s--;
                                            c--;
                                            if (c < 0 || sampleLines[s] !== controlLines[c]) {
                                                var _frame = "\n" + sampleLines[s].replace(" at new ", " at ");
                                                {
                                                    if (typeof fn === "function") {
                                                        componentFrameCache.set(fn, _frame);
                                                    }
                                                }
                                                return _frame;
                                            }
                                        } while (s >= 1 && c >= 0);
                                    }
                                    break;
                                }
                            }
                        }
                    } finally {
                        reentry = false;
                        {
                            ReactCurrentDispatcher.current = previousDispatcher;
                            reenableLogs();
                        }
                        Error.prepareStackTrace = previousPrepareStackTrace;
                    }
                    var name = fn ? fn.displayName || fn.name : "";
                    var syntheticFrame = name ? describeBuiltInComponentFrame(name) : "";
                    {
                        if (typeof fn === "function") {
                            componentFrameCache.set(fn, syntheticFrame);
                        }
                    }
                    return syntheticFrame;
                }
                function describeFunctionComponentFrame(fn, source, ownerFn) {
                    {
                        return describeNativeComponentFrame(fn, false);
                    }
                }
                function shouldConstruct(Component) {
                    var prototype = Component.prototype;
                    return !!(prototype && prototype.isReactComponent);
                }
                function describeUnknownElementTypeFrameInDEV(type, source, ownerFn) {
                    if (type == null) {
                        return "";
                    }
                    if (typeof type === "function") {
                        {
                            return describeNativeComponentFrame(type, shouldConstruct(type));
                        }
                    }
                    if (typeof type === "string") {
                        return describeBuiltInComponentFrame(type);
                    }
                    switch (type) {
                      case REACT_SUSPENSE_TYPE:
                        return describeBuiltInComponentFrame("Suspense");

                      case REACT_SUSPENSE_LIST_TYPE:
                        return describeBuiltInComponentFrame("SuspenseList");
                    }
                    if (typeof type === "object") {
                        switch (type.$$typeof) {
                          case REACT_FORWARD_REF_TYPE:
                            return describeFunctionComponentFrame(type.render);

                          case REACT_MEMO_TYPE:
                            return describeUnknownElementTypeFrameInDEV(type.type, source, ownerFn);

                          case REACT_BLOCK_TYPE:
                            return describeFunctionComponentFrame(type._render);

                          case REACT_LAZY_TYPE:
                            {
                                var lazyComponent = type;
                                var payload = lazyComponent._payload;
                                var init = lazyComponent._init;
                                try {
                                    return describeUnknownElementTypeFrameInDEV(init(payload), source, ownerFn);
                                } catch (x) {}
                            }
                        }
                    }
                    return "";
                }
                var loggedTypeFailures = {};
                var ReactDebugCurrentFrame = ReactSharedInternals.ReactDebugCurrentFrame;
                function setCurrentlyValidatingElement(element) {
                    {
                        if (element) {
                            var owner = element._owner;
                            var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
                            ReactDebugCurrentFrame.setExtraStackFrame(stack);
                        } else {
                            ReactDebugCurrentFrame.setExtraStackFrame(null);
                        }
                    }
                }
                function checkPropTypes(typeSpecs, values, location, componentName, element) {
                    {
                        var has = Function.call.bind(Object.prototype.hasOwnProperty);
                        for (var typeSpecName in typeSpecs) {
                            if (has(typeSpecs, typeSpecName)) {
                                var error$1 = void 0;
                                try {
                                    if (typeof typeSpecs[typeSpecName] !== "function") {
                                        var err = Error((componentName || "React class") + ": " + location + " type `" + typeSpecName + "` is invalid; " + "it must be a function, usually from the `prop-types` package, but received `" + typeof typeSpecs[typeSpecName] + "`." + "This often happens because of typos such as `PropTypes.function` instead of `PropTypes.func`.");
                                        err.name = "Invariant Violation";
                                        throw err;
                                    }
                                    error$1 = typeSpecs[typeSpecName](values, typeSpecName, componentName, location, null, "SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED");
                                } catch (ex) {
                                    error$1 = ex;
                                }
                                if (error$1 && !(error$1 instanceof Error)) {
                                    setCurrentlyValidatingElement(element);
                                    error("%s: type specification of %s" + " `%s` is invalid; the type checker " + "function must return `null` or an `Error` but returned a %s. " + "You may have forgotten to pass an argument to the type checker " + "creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and " + "shape all require an argument).", componentName || "React class", location, typeSpecName, typeof error$1);
                                    setCurrentlyValidatingElement(null);
                                }
                                if (error$1 instanceof Error && !(error$1.message in loggedTypeFailures)) {
                                    loggedTypeFailures[error$1.message] = true;
                                    setCurrentlyValidatingElement(element);
                                    error("Failed %s type: %s", location, error$1.message);
                                    setCurrentlyValidatingElement(null);
                                }
                            }
                        }
                    }
                }
                var ReactCurrentOwner = ReactSharedInternals.ReactCurrentOwner;
                var hasOwnProperty = Object.prototype.hasOwnProperty;
                var RESERVED_PROPS = {
                    key: true,
                    ref: true,
                    __self: true,
                    __source: true
                };
                var specialPropKeyWarningShown;
                var specialPropRefWarningShown;
                var didWarnAboutStringRefs;
                {
                    didWarnAboutStringRefs = {};
                }
                function hasValidRef(config) {
                    {
                        if (hasOwnProperty.call(config, "ref")) {
                            var getter = Object.getOwnPropertyDescriptor(config, "ref").get;
                            if (getter && getter.isReactWarning) {
                                return false;
                            }
                        }
                    }
                    return config.ref !== undefined;
                }
                function hasValidKey(config) {
                    {
                        if (hasOwnProperty.call(config, "key")) {
                            var getter = Object.getOwnPropertyDescriptor(config, "key").get;
                            if (getter && getter.isReactWarning) {
                                return false;
                            }
                        }
                    }
                    return config.key !== undefined;
                }
                function warnIfStringRefCannotBeAutoConverted(config, self) {
                    {
                        if (typeof config.ref === "string" && ReactCurrentOwner.current && self && ReactCurrentOwner.current.stateNode !== self) {
                            var componentName = getComponentName(ReactCurrentOwner.current.type);
                            if (!didWarnAboutStringRefs[componentName]) {
                                error('Component "%s" contains the string ref "%s". ' + "Support for string refs will be removed in a future major release. " + "This case cannot be automatically converted to an arrow function. " + "We ask you to manually fix this case by using useRef() or createRef() instead. " + "Learn more about using refs safely here: " + "https://reactjs.org/link/strict-mode-string-ref", getComponentName(ReactCurrentOwner.current.type), config.ref);
                                didWarnAboutStringRefs[componentName] = true;
                            }
                        }
                    }
                }
                function defineKeyPropWarningGetter(props, displayName) {
                    {
                        var warnAboutAccessingKey = function() {
                            if (!specialPropKeyWarningShown) {
                                specialPropKeyWarningShown = true;
                                error("%s: `key` is not a prop. Trying to access it will result " + "in `undefined` being returned. If you need to access the same " + "value within the child component, you should pass it as a different " + "prop. (https://reactjs.org/link/special-props)", displayName);
                            }
                        };
                        warnAboutAccessingKey.isReactWarning = true;
                        Object.defineProperty(props, "key", {
                            get: warnAboutAccessingKey,
                            configurable: true
                        });
                    }
                }
                function defineRefPropWarningGetter(props, displayName) {
                    {
                        var warnAboutAccessingRef = function() {
                            if (!specialPropRefWarningShown) {
                                specialPropRefWarningShown = true;
                                error("%s: `ref` is not a prop. Trying to access it will result " + "in `undefined` being returned. If you need to access the same " + "value within the child component, you should pass it as a different " + "prop. (https://reactjs.org/link/special-props)", displayName);
                            }
                        };
                        warnAboutAccessingRef.isReactWarning = true;
                        Object.defineProperty(props, "ref", {
                            get: warnAboutAccessingRef,
                            configurable: true
                        });
                    }
                }
                var ReactElement = function(type, key, ref, self, source, owner, props) {
                    var element = {
                        $$typeof: REACT_ELEMENT_TYPE,
                        type,
                        key,
                        ref,
                        props,
                        _owner: owner
                    };
                    {
                        element._store = {};
                        Object.defineProperty(element._store, "validated", {
                            configurable: false,
                            enumerable: false,
                            writable: true,
                            value: false
                        });
                        Object.defineProperty(element, "_self", {
                            configurable: false,
                            enumerable: false,
                            writable: false,
                            value: self
                        });
                        Object.defineProperty(element, "_source", {
                            configurable: false,
                            enumerable: false,
                            writable: false,
                            value: source
                        });
                        if (Object.freeze) {
                            Object.freeze(element.props);
                            Object.freeze(element);
                        }
                    }
                    return element;
                };
                function jsxDEV(type, config, maybeKey, source, self) {
                    {
                        var propName;
                        var props = {};
                        var key = null;
                        var ref = null;
                        if (maybeKey !== undefined) {
                            key = "" + maybeKey;
                        }
                        if (hasValidKey(config)) {
                            key = "" + config.key;
                        }
                        if (hasValidRef(config)) {
                            ref = config.ref;
                            warnIfStringRefCannotBeAutoConverted(config, self);
                        }
                        for (propName in config) {
                            if (hasOwnProperty.call(config, propName) && !RESERVED_PROPS.hasOwnProperty(propName)) {
                                props[propName] = config[propName];
                            }
                        }
                        if (type && type.defaultProps) {
                            var defaultProps = type.defaultProps;
                            for (propName in defaultProps) {
                                if (props[propName] === undefined) {
                                    props[propName] = defaultProps[propName];
                                }
                            }
                        }
                        if (key || ref) {
                            var displayName = typeof type === "function" ? type.displayName || type.name || "Unknown" : type;
                            if (key) {
                                defineKeyPropWarningGetter(props, displayName);
                            }
                            if (ref) {
                                defineRefPropWarningGetter(props, displayName);
                            }
                        }
                        return ReactElement(type, key, ref, self, source, ReactCurrentOwner.current, props);
                    }
                }
                var ReactCurrentOwner$1 = ReactSharedInternals.ReactCurrentOwner;
                var ReactDebugCurrentFrame$1 = ReactSharedInternals.ReactDebugCurrentFrame;
                function setCurrentlyValidatingElement$1(element) {
                    {
                        if (element) {
                            var owner = element._owner;
                            var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
                            ReactDebugCurrentFrame$1.setExtraStackFrame(stack);
                        } else {
                            ReactDebugCurrentFrame$1.setExtraStackFrame(null);
                        }
                    }
                }
                var propTypesMisspellWarningShown;
                {
                    propTypesMisspellWarningShown = false;
                }
                function isValidElement(object) {
                    {
                        return typeof object === "object" && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
                    }
                }
                function getDeclarationErrorAddendum() {
                    {
                        if (ReactCurrentOwner$1.current) {
                            var name = getComponentName(ReactCurrentOwner$1.current.type);
                            if (name) {
                                return "\n\nCheck the render method of `" + name + "`.";
                            }
                        }
                        return "";
                    }
                }
                function getSourceInfoErrorAddendum(source) {
                    {
                        if (source !== undefined) {
                            var fileName = source.fileName.replace(/^.*[\\\/]/, "");
                            var lineNumber = source.lineNumber;
                            return "\n\nCheck your code at " + fileName + ":" + lineNumber + ".";
                        }
                        return "";
                    }
                }
                var ownerHasKeyUseWarning = {};
                function getCurrentComponentErrorInfo(parentType) {
                    {
                        var info = getDeclarationErrorAddendum();
                        if (!info) {
                            var parentName = typeof parentType === "string" ? parentType : parentType.displayName || parentType.name;
                            if (parentName) {
                                info = "\n\nCheck the top-level render call using <" + parentName + ">.";
                            }
                        }
                        return info;
                    }
                }
                function validateExplicitKey(element, parentType) {
                    {
                        if (!element._store || element._store.validated || element.key != null) {
                            return;
                        }
                        element._store.validated = true;
                        var currentComponentErrorInfo = getCurrentComponentErrorInfo(parentType);
                        if (ownerHasKeyUseWarning[currentComponentErrorInfo]) {
                            return;
                        }
                        ownerHasKeyUseWarning[currentComponentErrorInfo] = true;
                        var childOwner = "";
                        if (element && element._owner && element._owner !== ReactCurrentOwner$1.current) {
                            childOwner = " It was passed a child from " + getComponentName(element._owner.type) + ".";
                        }
                        setCurrentlyValidatingElement$1(element);
                        error('Each child in a list should have a unique "key" prop.' + "%s%s See https://reactjs.org/link/warning-keys for more information.", currentComponentErrorInfo, childOwner);
                        setCurrentlyValidatingElement$1(null);
                    }
                }
                function validateChildKeys(node, parentType) {
                    {
                        if (typeof node !== "object") {
                            return;
                        }
                        if (Array.isArray(node)) {
                            for (var i = 0; i < node.length; i++) {
                                var child = node[i];
                                if (isValidElement(child)) {
                                    validateExplicitKey(child, parentType);
                                }
                            }
                        } else if (isValidElement(node)) {
                            if (node._store) {
                                node._store.validated = true;
                            }
                        } else if (node) {
                            var iteratorFn = getIteratorFn(node);
                            if (typeof iteratorFn === "function") {
                                if (iteratorFn !== node.entries) {
                                    var iterator = iteratorFn.call(node);
                                    var step;
                                    while (!(step = iterator.next()).done) {
                                        if (isValidElement(step.value)) {
                                            validateExplicitKey(step.value, parentType);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                function validatePropTypes(element) {
                    {
                        var type = element.type;
                        if (type === null || type === undefined || typeof type === "string") {
                            return;
                        }
                        var propTypes;
                        if (typeof type === "function") {
                            propTypes = type.propTypes;
                        } else if (typeof type === "object" && (type.$$typeof === REACT_FORWARD_REF_TYPE || type.$$typeof === REACT_MEMO_TYPE)) {
                            propTypes = type.propTypes;
                        } else {
                            return;
                        }
                        if (propTypes) {
                            var name = getComponentName(type);
                            checkPropTypes(propTypes, element.props, "prop", name, element);
                        } else if (type.PropTypes !== undefined && !propTypesMisspellWarningShown) {
                            propTypesMisspellWarningShown = true;
                            var _name = getComponentName(type);
                            error("Component %s declared `PropTypes` instead of `propTypes`. Did you misspell the property assignment?", _name || "Unknown");
                        }
                        if (typeof type.getDefaultProps === "function" && !type.getDefaultProps.isReactClassApproved) {
                            error("getDefaultProps is only used on classic React.createClass " + "definitions. Use a static property named `defaultProps` instead.");
                        }
                    }
                }
                function validateFragmentProps(fragment) {
                    {
                        var keys = Object.keys(fragment.props);
                        for (var i = 0; i < keys.length; i++) {
                            var key = keys[i];
                            if (key !== "children" && key !== "key") {
                                setCurrentlyValidatingElement$1(fragment);
                                error("Invalid prop `%s` supplied to `React.Fragment`. " + "React.Fragment can only have `key` and `children` props.", key);
                                setCurrentlyValidatingElement$1(null);
                                break;
                            }
                        }
                        if (fragment.ref !== null) {
                            setCurrentlyValidatingElement$1(fragment);
                            error("Invalid attribute `ref` supplied to `React.Fragment`.");
                            setCurrentlyValidatingElement$1(null);
                        }
                    }
                }
                function jsxWithValidation(type, props, key, isStaticChildren, source, self) {
                    {
                        var validType = isValidElementType(type);
                        if (!validType) {
                            var info = "";
                            if (type === undefined || typeof type === "object" && type !== null && Object.keys(type).length === 0) {
                                info += " You likely forgot to export your component from the file " + "it's defined in, or you might have mixed up default and named imports.";
                            }
                            var sourceInfo = getSourceInfoErrorAddendum(source);
                            if (sourceInfo) {
                                info += sourceInfo;
                            } else {
                                info += getDeclarationErrorAddendum();
                            }
                            var typeString;
                            if (type === null) {
                                typeString = "null";
                            } else if (Array.isArray(type)) {
                                typeString = "array";
                            } else if (type !== undefined && type.$$typeof === REACT_ELEMENT_TYPE) {
                                typeString = "<" + (getComponentName(type.type) || "Unknown") + " />";
                                info = " Did you accidentally export a JSX literal instead of a component?";
                            } else {
                                typeString = typeof type;
                            }
                            error("React.jsx: type is invalid -- expected a string (for " + "built-in components) or a class/function (for composite " + "components) but got: %s.%s", typeString, info);
                        }
                        var element = jsxDEV(type, props, key, source, self);
                        if (element == null) {
                            return element;
                        }
                        if (validType) {
                            var children = props.children;
                            if (children !== undefined) {
                                if (isStaticChildren) {
                                    if (Array.isArray(children)) {
                                        for (var i = 0; i < children.length; i++) {
                                            validateChildKeys(children[i], type);
                                        }
                                        if (Object.freeze) {
                                            Object.freeze(children);
                                        }
                                    } else {
                                        error("React.jsx: Static children should always be an array. " + "You are likely explicitly calling React.jsxs or React.jsxDEV. " + "Use the Babel transform instead.");
                                    }
                                } else {
                                    validateChildKeys(children, type);
                                }
                            }
                        }
                        if (type === exports.Fragment) {
                            validateFragmentProps(element);
                        } else {
                            validatePropTypes(element);
                        }
                        return element;
                    }
                }
                function jsxWithValidationStatic(type, props, key) {
                    {
                        return jsxWithValidation(type, props, key, true);
                    }
                }
                function jsxWithValidationDynamic(type, props, key) {
                    {
                        return jsxWithValidation(type, props, key, false);
                    }
                }
                var jsx = jsxWithValidationDynamic;
                var jsxs = jsxWithValidationStatic;
                exports.jsx = jsx;
                exports.jsxs = jsxs;
            })();
        }
    }, module => {
        "use strict";
        /*
object-assign
(c) Sindre Sorhus
@license MIT
*/        var getOwnPropertySymbols = Object.getOwnPropertySymbols;
        var hasOwnProperty = Object.prototype.hasOwnProperty;
        var propIsEnumerable = Object.prototype.propertyIsEnumerable;
        function toObject(val) {
            if (val === null || val === undefined) {
                throw new TypeError("Object.assign cannot be called with null or undefined");
            }
            return Object(val);
        }
        function shouldUseNative() {
            try {
                if (!Object.assign) {
                    return false;
                }
                var test1 = new String("abc");
                test1[5] = "de";
                if (Object.getOwnPropertyNames(test1)[0] === "5") {
                    return false;
                }
                var test2 = {};
                for (var i = 0; i < 10; i++) {
                    test2["_" + String.fromCharCode(i)] = i;
                }
                var order2 = Object.getOwnPropertyNames(test2).map((function(n) {
                    return test2[n];
                }));
                if (order2.join("") !== "0123456789") {
                    return false;
                }
                var test3 = {};
                "abcdefghijklmnopqrst".split("").forEach((function(letter) {
                    test3[letter] = letter;
                }));
                if (Object.keys(Object.assign({}, test3)).join("") !== "abcdefghijklmnopqrst") {
                    return false;
                }
                return true;
            } catch (err) {
                return false;
            }
        }
        module.exports = shouldUseNative() ? Object.assign : function(target, source) {
            var from;
            var to = toObject(target);
            var symbols;
            for (var s = 1; s < arguments.length; s++) {
                from = Object(arguments[s]);
                for (var key in from) {
                    if (hasOwnProperty.call(from, key)) {
                        to[key] = from[key];
                    }
                }
                if (getOwnPropertySymbols) {
                    symbols = getOwnPropertySymbols(from);
                    for (var i = 0; i < symbols.length; i++) {
                        if (propIsEnumerable.call(from, symbols[i])) {
                            to[symbols[i]] = from[symbols[i]];
                        }
                    }
                }
            }
            return to;
        };
    } ];
    var __webpack_module_cache__ = {};
    function __webpack_require__(moduleId) {
        var cachedModule = __webpack_module_cache__[moduleId];
        if (cachedModule !== undefined) {
            return cachedModule.exports;
        }
        var module = __webpack_module_cache__[moduleId] = {
            exports: {}
        };
        __webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
        return module.exports;
    }
    (() => {
        __webpack_require__.n = module => {
            var getter = module && module.__esModule ? () => module["default"] : () => module;
            __webpack_require__.d(getter, {
                a: getter
            });
            return getter;
        };
    })();
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
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(17);
        var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_0__);
        var _admin_settings__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(18);
        (function(wp) {
            (0, _wordpress_plugins__WEBPACK_IMPORTED_MODULE_0__.registerPlugin)("kenta-theme-settings", {
                render: _admin_settings__WEBPACK_IMPORTED_MODULE_1__["default"]
            });
        })(window.wp);
    })();
})();