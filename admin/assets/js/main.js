"use strict";
(self["webpackChunkaddonify_wishlist"] = self["webpackChunkaddonify_wishlist"] || []).push([["/js/main"],{

/***/ "./admin/src/main.js":
/*!***************************!*\
  !*** ./admin/src/main.js ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! pinia */ "./node_modules/pinia/dist/pinia.esm-browser.js");
/* harmony import */ var _App_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./App.vue */ "./admin/src/App.vue");
/* harmony import */ var _router__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./router */ "./admin/src/router/index.js");
/* harmony import */ var element_plus__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! element-plus */ "./node_modules/element-plus/es/defaults2.mjs");
/* harmony import */ var element_plus_dist_index_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! element-plus/dist/index.css */ "./node_modules/element-plus/dist/index.css");






var pinia = (0,pinia__WEBPACK_IMPORTED_MODULE_4__.createPinia)();
var app = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createApp)(_App_vue__WEBPACK_IMPORTED_MODULE_1__["default"]);
app.use(pinia);
app.use(_router__WEBPACK_IMPORTED_MODULE_2__["default"]);
app.use(element_plus__WEBPACK_IMPORTED_MODULE_5__["default"]);
app.mount("#___adfy-wishlist-app___");

/***/ }),

/***/ "./admin/src/router/index.js":
/*!***********************************!*\
  !*** ./admin/src/router/index.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm-bundler.js");
/* harmony import */ var _views_Settings_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../views/Settings.vue */ "./admin/src/views/Settings.vue");
/* harmony import */ var _views_Styles_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../views/Styles.vue */ "./admin/src/views/Styles.vue");
/* harmony import */ var _views_Products_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../views/Products.vue */ "./admin/src/views/Products.vue");
/* harmony import */ var _views_404_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../views/404.vue */ "./admin/src/views/404.vue");





var routes = [{
  path: "/",
  name: "Settings",
  component: _views_Settings_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
}, {
  path: "/styles",
  name: "Styles",
  component: _views_Styles_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
}, {
  path: "/products",
  name: "Products",
  component: _views_Products_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
}, {
  path: '/:catchAll(.*)*',
  name: "404",
  component: _views_404_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
}];
var router = (0,vue_router__WEBPACK_IMPORTED_MODULE_4__.createRouter)({
  history: (0,vue_router__WEBPACK_IMPORTED_MODULE_4__.createWebHashHistory)(),
  routes: routes
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (router);

/***/ }),

/***/ "./admin/src/stores/options.js":
/*!*************************************!*\
  !*** ./admin/src/stores/options.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "useOptionsStore": () => (/* binding */ useOptionsStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "./node_modules/pinia/dist/pinia.esm-browser.js");
/* harmony import */ var element_plus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! element-plus */ "./node_modules/element-plus/es/components/message/index2.mjs");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }


var _lodash = lodash,
    isEqual = _lodash.isEqual,
    cloneDeep = _lodash.cloneDeep;
var _wp = wp,
    apiFetch = _wp.apiFetch;

var BASE_API_URL = ADDONIFY_WISHLIST_LOCOLIZER.rest_namespace;
var oldOptions = {};
var useOptionsStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)({
  id: 'Options',
  state: function state() {
    return {
      data: {},
      // Holds all datas like options, section, tab & fields.
      options: {},
      // Holds the old options to compare with the new ones.
      message: "",
      // Holds the message to be displayed to the user.
      isLoading: true,
      isSaving: false,
      needSave: false,
      errors: ""
    };
  },
  getters: {
    // ⚡️ Check if we need to save the options.
    needSave: function needSave(state) {
      return !isEqual(state.options, oldOptions) ? true : false;
    }
  },
  actions: {
    // ⚡️ Use Axios to get options from api.
    fetchOptions: function fetchOptions() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                apiFetch({
                  path: BASE_API_URL + '/get_options',
                  method: 'GET'
                }).then(function (res) {
                  var settingsValues = res.settings_values;
                  _this.data = res.tabs;
                  _this.options = settingsValues;
                  oldOptions = cloneDeep(settingsValues);
                  _this.isLoading = false;
                });

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    // ⚡️ Handle update options & map the values to the options object.
    handleUpdateOptions: function handleUpdateOptions() {
      var payload = {};
      var changedOptions = this.options;
      Object.keys(changedOptions).map(function (key) {
        if (!isEqual(changedOptions[key], oldOptions[key])) {
          payload[key] = changedOptions[key];
        }
      });
      this.updateOptions(payload); //console.log(payload);
    },
    // ⚡️ Update options using Axios.
    updateOptions: function updateOptions(payload) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.isSaving = true; // Set saving to true.

                apiFetch({
                  path: BASE_API_URL + '/update_options',
                  method: 'POST',
                  data: {
                    settings_values: payload
                  }
                }).then(function (res) {
                  _this2.isSaving = false; // Saving is completed here.

                  _this2.message = res.message; // Set the message to be displayed to the user.

                  if (res.success === true) {
                    element_plus__WEBPACK_IMPORTED_MODULE_1__.ElMessage.success({
                      message: _this2.message,
                      offset: 50,
                      duration: 3000
                    });
                  } else {
                    element_plus__WEBPACK_IMPORTED_MODULE_1__.ElMessage.error({
                      message: _this2.message,
                      offset: 50,
                      duration: 3000
                    });
                  }

                  _this2.fetchOptions(); // Fetch options again.

                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/App.vue?vue&type=script&setup=true&lang=js":
/*!******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/App.vue?vue&type=script&setup=true&lang=js ***!
  \******************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_layouts_Header_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/layouts/Header.vue */ "./admin/src/components/layouts/Header.vue");
/* harmony import */ var _components_layouts_Footer_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/layouts/Footer.vue */ "./admin/src/components/layouts/Footer.vue");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'App',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var __returned__ = {
      Header: _components_layouts_Header_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
      Footer: _components_layouts_Footer_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=script&setup=true&lang=js":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=script&setup=true&lang=js ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var _layouts_Loading_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../layouts/Loading.vue */ "./admin/src/components/layouts/Loading.vue");
/* harmony import */ var _element_plus_icons_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @element-plus/icons-vue */ "./node_modules/@element-plus/icons-vue/dist/index.js");
/* harmony import */ var _stores_options__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../stores/options */ "./admin/src/stores/options.js");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Settings',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    var store = (0,_stores_options__WEBPACK_IMPORTED_MODULE_2__.useOptionsStore)();
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      store.fetchOptions();
    });
    var __returned__ = {
      __: __,
      _x: _x,
      _n: _n,
      _nx: _nx,
      store: store,
      onMounted: vue__WEBPACK_IMPORTED_MODULE_0__.onMounted,
      Loading: _layouts_Loading_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
      Check: _element_plus_icons_vue__WEBPACK_IMPORTED_MODULE_3__.Check,
      Close: _element_plus_icons_vue__WEBPACK_IMPORTED_MODULE_3__.Close,
      useOptionsStore: _stores_options__WEBPACK_IMPORTED_MODULE_2__.useOptionsStore
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=script&setup=true&lang=js":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=script&setup=true&lang=js ***!
  \*************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");
/* harmony import */ var _layouts_Loading_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../layouts/Loading.vue */ "./admin/src/components/layouts/Loading.vue");
/* harmony import */ var _element_plus_icons_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @element-plus/icons-vue */ "./node_modules/@element-plus/icons-vue/dist/index.js");
/* harmony import */ var _stores_options__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../stores/options */ "./admin/src/stores/options.js");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Styles',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var store = (0,_stores_options__WEBPACK_IMPORTED_MODULE_2__.useOptionsStore)();
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      store.fetchOptions();
    });
    var __returned__ = {
      store: store,
      __: __,
      _x: _x,
      _n: _n,
      _nx: _nx,
      onMounted: vue__WEBPACK_IMPORTED_MODULE_0__.onMounted,
      Loading: _layouts_Loading_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
      Check: _element_plus_icons_vue__WEBPACK_IMPORTED_MODULE_3__.Check,
      Close: _element_plus_icons_vue__WEBPACK_IMPORTED_MODULE_3__.Close,
      useOptionsStore: _stores_options__WEBPACK_IMPORTED_MODULE_2__.useOptionsStore
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Footer.vue?vue&type=script&setup=true&lang=js":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Footer.vue?vue&type=script&setup=true&lang=js ***!
  \****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Footer',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    var versionNumber = ADDONIFY_WISHLIST_LOCOLIZER.version_number;
    var thisYear = new Date().getFullYear();
    var __returned__ = {
      __: __,
      _x: _x,
      _n: _n,
      _nx: _nx,
      versionNumber: versionNumber,
      thisYear: thisYear
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Header.vue?vue&type=script&setup=true&lang=js":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Header.vue?vue&type=script&setup=true&lang=js ***!
  \****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _stores_options__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../stores/options */ "./admin/src/stores/options.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Header',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    var store = (0,_stores_options__WEBPACK_IMPORTED_MODULE_0__.useOptionsStore)();
    var __returned__ = {
      __: __,
      _x: _x,
      _n: _n,
      _nx: _nx,
      store: store,
      useOptionsStore: _stores_options__WEBPACK_IMPORTED_MODULE_0__.useOptionsStore
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Navigation.vue?vue&type=script&setup=true&lang=js":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Navigation.vue?vue&type=script&setup=true&lang=js ***!
  \********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Navigation',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    var __returned__ = {
      __: __,
      _x: _x,
      _n: _n,
      _nx: _nx
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/404.vue?vue&type=script&setup=true&lang=js":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/404.vue?vue&type=script&setup=true&lang=js ***!
  \************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: '404',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    var __returned__ = {
      __: __,
      _x: _x,
      _n: _n,
      _nx: _nx
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Products.vue?vue&type=script&setup=true&lang=js":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Products.vue?vue&type=script&setup=true&lang=js ***!
  \*****************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_layouts_Navigation_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/layouts/Navigation.vue */ "./admin/src/components/layouts/Navigation.vue");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Products',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        _x = _wp$i18n._x,
        _n = _wp$i18n._n,
        _nx = _wp$i18n._nx;
    var __returned__ = {
      __: __,
      _x: _x,
      _n: _n,
      _nx: _nx,
      Navigation: _components_layouts_Navigation_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Settings.vue?vue&type=script&setup=true&lang=js":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Settings.vue?vue&type=script&setup=true&lang=js ***!
  \*****************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_form_Settings_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/form/Settings.vue */ "./admin/src/components/form/Settings.vue");
/* harmony import */ var _components_layouts_Navigation_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/layouts/Navigation.vue */ "./admin/src/components/layouts/Navigation.vue");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Settings',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var __returned__ = {
      Settings: _components_form_Settings_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
      Navigation: _components_layouts_Navigation_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Styles.vue?vue&type=script&setup=true&lang=js":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Styles.vue?vue&type=script&setup=true&lang=js ***!
  \***************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_layouts_Navigation_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/layouts/Navigation.vue */ "./admin/src/components/layouts/Navigation.vue");
/* harmony import */ var _components_form_Styles_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/form/Styles.vue */ "./admin/src/components/form/Styles.vue");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  __name: 'Styles',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var __returned__ = {
      Navigation: _components_layouts_Navigation_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
      StyleForm: _components_form_Styles_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/App.vue?vue&type=template&id=20c9a2f8":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/App.vue?vue&type=template&id=20c9a2f8 ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_view = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-view");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Header"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_view), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Footer"])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=template&id=2c85248e":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=template&id=2c85248e ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "option-box-title"
};
var _hoisted_2 = {
  "class": "adfy-options"
};
var _hoisted_3 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_4 = {
  "class": "adfy-col left"
};
var _hoisted_5 = {
  "class": "label"
};
var _hoisted_6 = {
  "class": "option-label"
};
var _hoisted_7 = {
  "class": "option-description"
};
var _hoisted_8 = {
  "class": "adfy-col right"
};
var _hoisted_9 = {
  "class": "input"
};
var _hoisted_10 = {
  key: 0,
  "class": "adfy-setting-options"
};
var _hoisted_11 = {
  "class": "option-box-title"
};
var _hoisted_12 = {
  "class": "adfy-options"
};
var _hoisted_13 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_14 = {
  "class": "adfy-col left"
};
var _hoisted_15 = {
  "class": "label"
};
var _hoisted_16 = {
  "class": "option-label"
};
var _hoisted_17 = {
  "class": "adfy-col right"
};
var _hoisted_18 = {
  "class": "input"
};
var _hoisted_19 = {
  "class": "adfy-options"
};
var _hoisted_20 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_21 = {
  "class": "adfy-col left"
};
var _hoisted_22 = {
  "class": "label"
};
var _hoisted_23 = {
  "class": "option-label"
};
var _hoisted_24 = {
  "class": "option-description"
};
var _hoisted_25 = {
  "class": "adfy-col right"
};
var _hoisted_26 = {
  "class": "input"
};
var _hoisted_27 = {
  "class": "option-box-title"
};
var _hoisted_28 = {
  "class": "adfy-options"
};
var _hoisted_29 = {
  "class": "adfy-option-columns option-box fullwidth"
};
var _hoisted_30 = {
  "class": "adfy-col left"
};
var _hoisted_31 = {
  "class": "label"
};
var _hoisted_32 = {
  "class": "option-label"
};
var _hoisted_33 = {
  "class": "option-description"
};
var _hoisted_34 = {
  "class": "adfy-col right"
};
var _hoisted_35 = {
  "class": "input"
};
var _hoisted_36 = {
  "class": "adfy-options"
};
var _hoisted_37 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_38 = {
  "class": "adfy-col left"
};
var _hoisted_39 = {
  "class": "label"
};
var _hoisted_40 = {
  "class": "option-label"
};
var _hoisted_41 = {
  "class": "option-description"
};
var _hoisted_42 = {
  "class": "adfy-col right"
};
var _hoisted_43 = {
  "class": "input"
};
var _hoisted_44 = {
  "class": "adfy-options"
};
var _hoisted_45 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_46 = {
  "class": "adfy-col left"
};
var _hoisted_47 = {
  "class": "label"
};
var _hoisted_48 = {
  "class": "option-label"
};
var _hoisted_49 = {
  "class": "option-description"
};
var _hoisted_50 = {
  "class": "adfy-col right"
};
var _hoisted_51 = {
  "class": "input"
};
var _hoisted_52 = {
  "class": "adfy-options"
};
var _hoisted_53 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_54 = {
  "class": "adfy-col left"
};
var _hoisted_55 = {
  "class": "label"
};
var _hoisted_56 = {
  "class": "option-label"
};
var _hoisted_57 = {
  "class": "option-description"
};
var _hoisted_58 = {
  "class": "adfy-col right"
};
var _hoisted_59 = {
  "class": "input"
};
var _hoisted_60 = {
  key: 0,
  "class": "adfy-options"
};
var _hoisted_61 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_62 = {
  "class": "adfy-col left"
};
var _hoisted_63 = {
  "class": "label"
};
var _hoisted_64 = {
  "class": "option-label"
};
var _hoisted_65 = {
  "class": "adfy-col right"
};
var _hoisted_66 = {
  "class": "input"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_el_switch = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-switch");

  var _component_el_input = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-input");

  var _component_el_option = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-option");

  var _component_el_select = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-select");

  var _component_el_checkbox_button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-checkbox-button");

  var _component_el_checkbox_group = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-checkbox-group");

  return $setup.store.isLoading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["Loading"], {
    key: 0
  })) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("form", {
    key: 1,
    id: "adfy-settings-form",
    "class": "adfy-form",
    onSubmit: _cache[8] || (_cache[8] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {}, ["prevent"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("General", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Enable quick view", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Once enabled, it will be visible in product catalog.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_switch, {
    modelValue: $setup.store.options.enable_quick_view,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $setup.store.options.enable_quick_view = $event;
    }),
    "class": "enable-addonify-quick-view",
    size: "large",
    "inline-prompt": "",
    "active-icon": $setup.Check,
    "inactive-icon": $setup.Close
  }, null, 8
  /* PROPS */
  , ["modelValue", "active-icon", "inactive-icon"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), $setup.store.options.enable_quick_view ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Button Options", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Quick view button label", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_input, {
    modelValue: $setup.store.options.quick_view_btn_label,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $setup.store.options.quick_view_btn_label = $event;
    }),
    size: "large",
    placeholder: "Quick view"
  }, null, 8
  /* PROPS */
  , ["modelValue"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Button position", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_24, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Choose where you want to show the quick view button.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_select, {
    modelValue: $setup.store.options.quick_view_btn_position,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $setup.store.options.quick_view_btn_position = $event;
    }),
    placeholder: "Select",
    size: "large"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.store.data.settings.sections.button.fields.quick_view_btn_position.choices, function (label, key) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_el_option, {
          label: label,
          value: key
        }, null, 8
        /* PROPS */
        , ["label", "value"]);
      }), 256
      /* UNKEYED_FRAGMENT */
      ))];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["modelValue"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Modal Box Options", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Content to display", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Which content would you like to display on quick view modal.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_checkbox_group, {
    modelValue: $setup.store.options.modal_box_content,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $setup.store.options.modal_box_content = $event;
    }),
    size: "large"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.store.data.settings.sections.modal.fields.modal_box_content.choices, function (label, key) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_el_checkbox_button, {
          label: key
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(label), 1
            /* TEXT */
            )];
          }),
          _: 2
          /* DYNAMIC */

        }, 1032
        /* PROPS, DYNAMIC_SLOTS */
        , ["label"]);
      }), 256
      /* UNKEYED_FRAGMENT */
      ))];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["modelValue"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_40, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Product thumbnail", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Choose whether you want to display single product image or gallery in quick view modal.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_42, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_43, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_select, {
    modelValue: $setup.store.options.product_thumbnail,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $setup.store.options.product_thumbnail = $event;
    }),
    placeholder: "Select",
    size: "large"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.store.data.settings.sections.modal.fields.product_thumbnail.choices, function (label, key) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_el_option, {
          label: label,
          value: key
        }, null, 8
        /* PROPS */
        , ["label", "value"]);
      }), 256
      /* UNKEYED_FRAGMENT */
      ))];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["modelValue"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_48, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Enable lightbox", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_49, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Enable lightbox for product images in quick view modal.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_50, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_switch, {
    modelValue: $setup.store.options.enable_lightbox,
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $setup.store.options.enable_lightbox = $event;
    }),
    "class": "enable-addonify-quick-view",
    size: "large",
    "inline-prompt": "",
    "active-icon": $setup.Check,
    "inactive-icon": $setup.Close
  }, null, 8
  /* PROPS */
  , ["modelValue", "active-icon", "inactive-icon"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_52, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_54, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_55, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_56, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Display view detail button", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_57, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Enable display view detail button in modal.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_58, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_59, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_switch, {
    modelValue: $setup.store.options.display_read_more_button,
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $setup.store.options.display_read_more_button = $event;
    }),
    "class": "enable-addonify-quick-view",
    size: "large",
    "inline-prompt": "",
    "active-icon": $setup.Check,
    "inactive-icon": $setup.Close
  }, null, 8
  /* PROPS */
  , ["modelValue", "active-icon", "inactive-icon"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), $setup.store.options.display_read_more_button ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_60, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_61, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_62, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_63, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_64, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("View detail button label", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_65, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_66, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_input, {
    modelValue: $setup.store.options.read_more_button_label,
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $setup.store.options.read_more_button_label = $event;
    }),
    size: "large",
    placeholder: "View Details"
  }, null, 8
  /* PROPS */
  , ["modelValue"])])])])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options ")])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-settings-options ")], 32
  /* HYDRATE_EVENTS */
  ));
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=template&id=07be428d":
/*!******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=template&id=07be428d ***!
  \******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "option-box-title"
};
var _hoisted_2 = {
  "class": "adfy-options"
};
var _hoisted_3 = {
  "class": "adfy-option-columns option-box"
};
var _hoisted_4 = {
  "class": "adfy-col left"
};
var _hoisted_5 = {
  "class": "label"
};
var _hoisted_6 = {
  "class": "option-label"
};
var _hoisted_7 = {
  "class": "badge"
};
var _hoisted_8 = {
  "class": "option-description"
};
var _hoisted_9 = {
  "class": "adfy-col right"
};
var _hoisted_10 = {
  "class": "input"
};
var _hoisted_11 = {
  key: 0,
  "class": "adfy-color-options"
};
var _hoisted_12 = {
  "class": "adfy-options"
};
var _hoisted_13 = {
  "class": "adfy-option-columns option-box fullwidth"
};
var _hoisted_14 = {
  "class": "adfy-col left"
};
var _hoisted_15 = {
  "class": "label"
};
var _hoisted_16 = {
  "class": "option-label"
};
var _hoisted_17 = {
  "class": "option-description"
};
var _hoisted_18 = {
  "class": "adfy-col right"
};
var _hoisted_19 = {
  "class": "input-group"
};
var _hoisted_20 = {
  "class": "input"
};
var _hoisted_21 = {
  "class": "input"
};
var _hoisted_22 = {
  "class": "adfy-options"
};
var _hoisted_23 = {
  "class": "adfy-option-columns option-box fullwidth"
};
var _hoisted_24 = {
  "class": "adfy-col left"
};
var _hoisted_25 = {
  "class": "label"
};
var _hoisted_26 = {
  "class": "option-label"
};
var _hoisted_27 = {
  "class": "option-description"
};
var _hoisted_28 = {
  "class": "adfy-col right"
};
var _hoisted_29 = {
  "class": "input-group"
};
var _hoisted_30 = {
  "class": "input"
};
var _hoisted_31 = {
  "class": "input"
};
var _hoisted_32 = {
  "class": "input"
};
var _hoisted_33 = {
  "class": "input"
};
var _hoisted_34 = {
  "class": "input"
};
var _hoisted_35 = {
  "class": "input"
};
var _hoisted_36 = {
  "class": "input"
};
var _hoisted_37 = {
  "class": "input"
};
var _hoisted_38 = {
  "class": "adfy-options"
};
var _hoisted_39 = {
  "class": "adfy-option-columns option-box fullwidth"
};
var _hoisted_40 = {
  "class": "adfy-col left"
};
var _hoisted_41 = {
  "class": "label"
};
var _hoisted_42 = {
  "class": "option-label"
};
var _hoisted_43 = {
  "class": "option-description"
};
var _hoisted_44 = {
  "class": "adfy-col right"
};
var _hoisted_45 = {
  "class": "input-group"
};
var _hoisted_46 = {
  "class": "input"
};
var _hoisted_47 = {
  "class": "input"
};
var _hoisted_48 = {
  "class": "input"
};
var _hoisted_49 = {
  "class": "input"
};
var _hoisted_50 = {
  "class": "adfy-options"
};
var _hoisted_51 = {
  "class": "adfy-option-columns option-box fullwidth"
};
var _hoisted_52 = {
  "class": "adfy-col left"
};
var _hoisted_53 = {
  "class": "label"
};
var _hoisted_54 = {
  "class": "option-label"
};
var _hoisted_55 = {
  "class": "adfy-col right"
};
var _hoisted_56 = {
  "class": "input-group"
};
var _hoisted_57 = {
  "class": "input"
};
var _hoisted_58 = {
  "class": "input"
};
var _hoisted_59 = {
  "class": "input"
};
var _hoisted_60 = {
  "class": "input"
};
var _hoisted_61 = {
  "class": "option-box-title"
};
var _hoisted_62 = {
  "class": "adfy-options"
};
var _hoisted_63 = {
  "class": "adfy-option-columns option-box fullwidth"
};
var _hoisted_64 = {
  "class": "adfy-col left"
};
var _hoisted_65 = {
  "class": "label"
};
var _hoisted_66 = {
  "class": "option-label"
};
var _hoisted_67 = {
  "class": "option-description"
};
var _hoisted_68 = {
  "class": "adfy-col right"
};
var _hoisted_69 = {
  "class": "input"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_el_switch = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-switch");

  var _component_el_color_picker = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-color-picker");

  var _component_el_input = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("el-input");

  return $setup.store.isLoading ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["Loading"], {
    key: 0
  })) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("form", {
    key: 1,
    id: "adfy-styles-form",
    "class": "adfy-form",
    onSubmit: _cache[20] || (_cache[20] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {}, ["prevent"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_1, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("General", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Enable plugin styles", "addonify-quick-view")) + " ", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Optional", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("If enabled, the colors selected below will be applied to the quick view modal & elements.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_switch, {
    modelValue: $setup.store.options.enable_plugin_styles,
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $setup.store.options.enable_plugin_styles = $event;
    }),
    "class": "enable-addonify-quick-view",
    size: "large",
    "inline-prompt": "",
    "active-icon": $setup.Check,
    "inactive-icon": $setup.Close
  }, null, 8
  /* PROPS */
  , ["modelValue", "active-icon", "inactive-icon"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), $setup.store.options.enable_plugin_styles ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Modal Box Colors", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Change the look & feel of modal box & overlay mask.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_box_overlay_background_color,
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $setup.store.options.modal_box_overlay_background_color = $event;
    }),
    "show-alpha": "",
    onActiveChange: _ctx.changedColor
  }, null, 8
  /* PROPS */
  , ["modelValue", "onActiveChange"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Modal overlay background", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_box_background_color,
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $setup.store.options.modal_box_background_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Modal inner background", "addonify-quick-view")), 1
  /* TEXT */
  )])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Product Info Colors", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Tweak how product elements like title, meta, excerpt, price etc looks on modal.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_title_color,
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return $setup.store.options.product_title_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Title text", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_excerpt_text_color,
    "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
      return $setup.store.options.product_excerpt_text_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Excerpt text", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_rating_star_filled_color,
    "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
      return $setup.store.options.product_rating_star_filled_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Rating star filled", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_rating_star_empty_color,
    "onUpdate:modelValue": _cache[6] || (_cache[6] = function ($event) {
      return $setup.store.options.product_rating_star_empty_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Rating stars empty", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_price_color,
    "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
      return $setup.store.options.product_price_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Regular price", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_on_sale_price_color,
    "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
      return $setup.store.options.product_on_sale_price_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("On-sale price", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_meta_text_color,
    "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
      return $setup.store.options.product_meta_text_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Meta", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.product_meta_text_hover_color,
    "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
      return $setup.store.options.product_meta_text_hover_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Meta on hover", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // input-groups ")])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_41, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_42, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Close button color", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_43, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Change the look & feel of close modal box button.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_44, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_close_button_text_color,
    "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
      return $setup.store.options.modal_close_button_text_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Default text", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_close_button_text_hover_color,
    "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
      return $setup.store.options.modal_close_button_text_hover_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Text color on mouse hover", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_close_button_background_color,
    "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
      return $setup.store.options.modal_close_button_background_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Default background", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_49, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_close_button_background_hover_color,
    "onUpdate:modelValue": _cache[14] || (_cache[14] = function ($event) {
      return $setup.store.options.modal_close_button_background_hover_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Background color on mouse hover", "addonify-quick-view")), 1
  /* TEXT */
  )])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_50, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_52, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_53, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_54, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Miscellaneous buttons color", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_55, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_56, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_57, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_misc_buttons_text_color,
    "onUpdate:modelValue": _cache[15] || (_cache[15] = function ($event) {
      return $setup.store.options.modal_misc_buttons_text_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Default text", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_58, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_misc_buttons_text_hover_color,
    "onUpdate:modelValue": _cache[16] || (_cache[16] = function ($event) {
      return $setup.store.options.modal_misc_buttons_text_hover_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Text on mouse hover", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_59, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_misc_buttons_background_color,
    "onUpdate:modelValue": _cache[17] || (_cache[17] = function ($event) {
      return $setup.store.options.modal_misc_buttons_background_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Default background", "addonify-quick-view")), 1
  /* TEXT */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_60, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_color_picker, {
    modelValue: $setup.store.options.modal_misc_buttons_background_hover_color,
    "onUpdate:modelValue": _cache[18] || (_cache[18] = function ($event) {
      return $setup.store.options.modal_misc_buttons_background_hover_color = $event;
    }),
    "show-alpha": ""
  }, null, 8
  /* PROPS */
  , ["modelValue"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Background color on mouse hover", "addonify-quick-view")), 1
  /* TEXT */
  )])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", _hoisted_61, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Developer", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_62, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_63, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_64, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_65, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_66, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Custom CSS", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_67, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("If required, you may add your own custom CSS code here.", "addonify-quick-view")), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_68, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_69, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_el_input, {
    modelValue: $setup.store.options.custom_css,
    "onUpdate:modelValue": _cache[19] || (_cache[19] = function ($event) {
      return $setup.store.options.custom_css = $event;
    }),
    "class": "custom-css-box",
    type: "textarea",
    rows: "10",
    placeholder: "#app { color: blue; }",
    resize: "vertical",
    "input-style": "display:block;width: 100%;"
  }, null, 8
  /* PROPS */
  , ["modelValue"])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" // adfy-options ")])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 32
  /* HYDRATE_EVENTS */
  ));
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Footer.vue?vue&type=template&id=4f77115e":
/*!*********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Footer.vue?vue&type=template&id=4f77115e ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "adfy-colopon"
};
var _hoisted_2 = {
  "class": "adfy-row"
};
var _hoisted_3 = {
  "class": "adfy-col left"
};
var _hoisted_4 = {
  "class": "text"
};
var _hoisted_5 = {
  "class": "version"
};
var _hoisted_6 = {
  "class": "adfy-col right"
};
var _hoisted_7 = {
  "class": "text"
};
var _hoisted_8 = {
  href: "https://wordpress.org/plugins/addonify-wishlist/#reviews",
  "class": "adfy-link",
  target: "_blank"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<span class=\"icon\"><i class=\"dashicons dashicons-star-filled\"></i><i class=\"dashicons dashicons-star-filled\"></i><i class=\"dashicons dashicons-star-filled\"></i><i class=\"dashicons dashicons-star-filled\"></i><i class=\"dashicons dashicons-star-filled\"></i></span> :) ", 2);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("footer", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" © 2020 - " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.thisYear) + " Addonify WooCommerce Wishlist ", 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Version", "addonify-wishlist")) + ": " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.versionNumber), 1
  /* TEXT */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Rate", "addonify-wishlist")) + " ", 1
  /* TEXT */
  ), _hoisted_9])])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Header.vue?vue&type=template&id=0d12497a":
/*!*********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Header.vue?vue&type=template&id=0d12497a ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "adfy-header"
};
var _hoisted_2 = {
  "class": "adfy-row"
};
var _hoisted_3 = {
  "class": "adfy-col start"
};
var _hoisted_4 = {
  "class": "branding"
};

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  width: "133",
  height: "42",
  viewBox: "0 0 133 42",
  fill: "none",
  xmlns: "http://www.w3.org/2000/svg"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M53.639 28.325C53.837 27.907 54.1413 27.566 54.552 27.302C54.97 27.038 55.4613 26.906 56.026 26.906C56.576 26.906 57.0673 27.0343 57.5 27.291C57.9327 27.5403 58.27 27.8997 58.512 28.369C58.7613 28.831 58.886 29.37 58.886 29.986C58.886 30.602 58.7613 31.1447 58.512 31.614C58.27 32.0833 57.929 32.4463 57.489 32.703C57.0563 32.9597 56.5687 33.088 56.026 33.088C55.454 33.088 54.959 32.9597 54.541 32.703C54.1303 32.439 53.8297 32.098 53.639 31.68V33H52.88V24.86H53.639V28.325ZM58.105 29.986C58.105 29.4873 58.006 29.0583 57.808 28.699C57.6173 28.3323 57.3533 28.0537 57.016 27.863C56.6787 27.6723 56.2973 27.577 55.872 27.577C55.4613 27.577 55.0837 27.676 54.739 27.874C54.4017 28.072 54.134 28.3543 53.936 28.721C53.738 29.0877 53.639 29.513 53.639 29.997C53.639 30.481 53.738 30.9063 53.936 31.273C54.134 31.6397 54.4017 31.922 54.739 32.12C55.0837 32.318 55.4613 32.417 55.872 32.417C56.2973 32.417 56.6787 32.3217 57.016 32.131C57.3533 31.933 57.6173 31.6507 57.808 31.284C58.006 30.91 58.105 30.4773 58.105 29.986ZM65.8029 26.994L62.2389 35.827H61.4359L62.6019 32.967L60.1379 26.994H60.9849L63.0309 32.12L65.0109 26.994H65.8029ZM70.6135 29.986C70.6135 29.37 70.7345 28.831 70.9765 28.369C71.2259 27.8997 71.5669 27.5403 71.9995 27.291C72.4395 27.0343 72.9345 26.906 73.4845 26.906C74.0565 26.906 74.5479 27.038 74.9585 27.302C75.3765 27.566 75.6772 27.9033 75.8605 28.314V26.994H76.6305V33H75.8605V31.669C75.6699 32.0797 75.3655 32.4207 74.9475 32.692C74.5369 32.956 74.0455 33.088 73.4735 33.088C72.9309 33.088 72.4395 32.9597 71.9995 32.703C71.5669 32.4463 71.2259 32.0833 70.9765 31.614C70.7345 31.1447 70.6135 30.602 70.6135 29.986ZM75.8605 29.997C75.8605 29.513 75.7615 29.0877 75.5635 28.721C75.3655 28.3543 75.0942 28.072 74.7495 27.874C74.4122 27.676 74.0382 27.577 73.6275 27.577C73.2022 27.577 72.8209 27.6723 72.4835 27.863C72.1462 28.0537 71.8785 28.3323 71.6805 28.699C71.4899 29.0583 71.3945 29.4873 71.3945 29.986C71.3945 30.4773 71.4899 30.91 71.6805 31.284C71.8785 31.6507 72.1462 31.933 72.4835 32.131C72.8209 32.3217 73.2022 32.417 73.6275 32.417C74.0382 32.417 74.4122 32.318 74.7495 32.12C75.0942 31.922 75.3655 31.6397 75.5635 31.273C75.7615 30.9063 75.8605 30.481 75.8605 29.997ZM78.5864 29.986C78.5864 29.37 78.7111 28.831 78.9604 28.369C79.2097 27.8997 79.5507 27.5403 79.9834 27.291C80.4234 27.0343 80.9184 26.906 81.4684 26.906C81.9964 26.906 82.4731 27.0343 82.8984 27.291C83.3237 27.5477 83.6354 27.8813 83.8334 28.292V24.86H84.6034V33H83.8334V31.658C83.6501 32.076 83.3494 32.4207 82.9314 32.692C82.5134 32.956 82.0221 33.088 81.4574 33.088C80.9074 33.088 80.4124 32.9597 79.9724 32.703C79.5397 32.4463 79.1987 32.0833 78.9494 31.614C78.7074 31.1447 78.5864 30.602 78.5864 29.986ZM83.8334 29.997C83.8334 29.513 83.7344 29.0877 83.5364 28.721C83.3384 28.3543 83.0671 28.072 82.7224 27.874C82.3851 27.676 82.0111 27.577 81.6004 27.577C81.1751 27.577 80.7937 27.6723 80.4564 27.863C80.1191 28.0537 79.8514 28.3323 79.6534 28.699C79.4627 29.0583 79.3674 29.4873 79.3674 29.986C79.3674 30.4773 79.4627 30.91 79.6534 31.284C79.8514 31.6507 80.1191 31.933 80.4564 32.131C80.7937 32.3217 81.1751 32.417 81.6004 32.417C82.0111 32.417 82.3851 32.318 82.7224 32.12C83.0671 31.922 83.3384 31.6397 83.5364 31.273C83.7344 30.9063 83.8334 30.481 83.8334 29.997ZM86.5593 29.986C86.5593 29.37 86.6839 28.831 86.9333 28.369C87.1826 27.8997 87.5236 27.5403 87.9563 27.291C88.3963 27.0343 88.8913 26.906 89.4413 26.906C89.9693 26.906 90.4459 27.0343 90.8713 27.291C91.2966 27.5477 91.6083 27.8813 91.8063 28.292V24.86H92.5763V33H91.8063V31.658C91.6229 32.076 91.3223 32.4207 90.9043 32.692C90.4863 32.956 89.9949 33.088 89.4303 33.088C88.8803 33.088 88.3853 32.9597 87.9453 32.703C87.5126 32.4463 87.1716 32.0833 86.9223 31.614C86.6803 31.1447 86.5593 30.602 86.5593 29.986ZM91.8063 29.997C91.8063 29.513 91.7073 29.0877 91.5093 28.721C91.3113 28.3543 91.0399 28.072 90.6953 27.874C90.3579 27.676 89.9839 27.577 89.5733 27.577C89.1479 27.577 88.7666 27.6723 88.4293 27.863C88.0919 28.0537 87.8243 28.3323 87.6263 28.699C87.4356 29.0583 87.3403 29.4873 87.3403 29.986C87.3403 30.4773 87.4356 30.91 87.6263 31.284C87.8243 31.6507 88.0919 31.933 88.4293 32.131C88.7666 32.3217 89.1479 32.417 89.5733 32.417C89.9839 32.417 90.3579 32.318 90.6953 32.12C91.0399 31.922 91.3113 31.6397 91.5093 31.273C91.7073 30.9063 91.8063 30.481 91.8063 29.997ZM97.5131 33.088C96.9484 33.088 96.4388 32.9633 95.9841 32.714C95.5368 32.4573 95.1811 32.098 94.9171 31.636C94.6604 31.1667 94.5321 30.6203 94.5321 29.997C94.5321 29.3737 94.6641 28.831 94.9281 28.369C95.1921 27.8997 95.5514 27.5403 96.0061 27.291C96.4608 27.0343 96.9704 26.906 97.5351 26.906C98.0998 26.906 98.6094 27.0343 99.0641 27.291C99.5261 27.5403 99.8854 27.8997 100.142 28.369C100.406 28.831 100.538 29.3737 100.538 29.997C100.538 30.613 100.406 31.1557 100.142 31.625C99.8781 32.0943 99.5151 32.4573 99.0531 32.714C98.5911 32.9633 98.0778 33.088 97.5131 33.088ZM97.5131 32.417C97.9091 32.417 98.2758 32.329 98.6131 32.153C98.9504 31.9697 99.2218 31.6983 99.4271 31.339C99.6398 30.9723 99.7461 30.525 99.7461 29.997C99.7461 29.469 99.6434 29.0253 99.4381 28.666C99.2328 28.2993 98.9614 28.028 98.6241 27.852C98.2868 27.6687 97.9201 27.577 97.5241 27.577C97.1281 27.577 96.7614 27.6687 96.4241 27.852C96.0868 28.028 95.8154 28.2993 95.6101 28.666C95.4121 29.0253 95.3131 29.469 95.3131 29.997C95.3131 30.525 95.4121 30.9723 95.6101 31.339C95.8154 31.6983 96.0831 31.9697 96.4131 32.153C96.7504 32.329 97.1171 32.417 97.5131 32.417ZM105.308 26.884C106.026 26.884 106.613 27.1077 107.068 27.555C107.522 27.995 107.75 28.6367 107.75 29.48V33H106.991V29.568C106.991 28.9153 106.826 28.4167 106.496 28.072C106.173 27.7273 105.729 27.555 105.165 27.555C104.585 27.555 104.123 27.7383 103.779 28.105C103.434 28.4717 103.262 29.0107 103.262 29.722V33H102.492V26.994H103.262V28.017C103.452 27.6503 103.727 27.3717 104.087 27.181C104.446 26.983 104.853 26.884 105.308 26.884ZM110.388 25.861C110.234 25.861 110.102 25.806 109.992 25.696C109.882 25.586 109.827 25.4503 109.827 25.289C109.827 25.1277 109.882 24.9957 109.992 24.893C110.102 24.783 110.234 24.728 110.388 24.728C110.542 24.728 110.674 24.783 110.784 24.893C110.894 24.9957 110.949 25.1277 110.949 25.289C110.949 25.4503 110.894 25.586 110.784 25.696C110.674 25.806 110.542 25.861 110.388 25.861ZM110.773 26.994V33H110.003V26.994H110.773ZM115.431 27.643H114.034V33H113.264V27.643H112.428V26.994H113.264V26.576C113.264 25.9233 113.429 25.443 113.759 25.135C114.097 24.827 114.639 24.673 115.387 24.673V25.333C114.889 25.333 114.537 25.4283 114.331 25.619C114.133 25.8097 114.034 26.1287 114.034 26.576V26.994H115.431V27.643ZM122.143 26.994L118.579 35.827H117.776L118.942 32.967L116.478 26.994H117.325L119.371 32.12L121.351 26.994H122.143Z",
  fill: "#313131"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M54.3903 14.7131H56.0891L56.9432 15.8118L57.7834 16.7905L59.3668 18.7756H57.5018L56.4123 17.4368L55.8537 16.6428L54.3903 14.7131ZM59.5099 13.2727C59.5099 14.3037 59.3145 15.1809 58.9237 15.9041C58.5359 16.6274 58.0065 17.1798 57.3356 17.5614C56.6677 17.94 55.9168 18.1293 55.0827 18.1293C54.2425 18.1293 53.4885 17.9384 52.8207 17.5568C52.1528 17.1752 51.625 16.6228 51.2372 15.8995C50.8494 15.1763 50.6555 14.3007 50.6555 13.2727C50.6555 12.2417 50.8494 11.3646 51.2372 10.6413C51.625 9.91809 52.1528 9.36719 52.8207 8.98864C53.4885 8.60701 54.2425 8.41619 55.0827 8.41619C55.9168 8.41619 56.6677 8.60701 57.3356 8.98864C58.0065 9.36719 58.5359 9.91809 58.9237 10.6413C59.3145 11.3646 59.5099 12.2417 59.5099 13.2727ZM57.4833 13.2727C57.4833 12.6049 57.3833 12.0417 57.1832 11.5831C56.9863 11.1245 56.7077 10.7768 56.3477 10.5398C55.9876 10.3028 55.5659 10.1843 55.0827 10.1843C54.5996 10.1843 54.1779 10.3028 53.8178 10.5398C53.4577 10.7768 53.1777 11.1245 52.9776 11.5831C52.7807 12.0417 52.6822 12.6049 52.6822 13.2727C52.6822 13.9406 52.7807 14.5038 52.9776 14.9624C53.1777 15.4209 53.4577 15.7687 53.8178 16.0057C54.1779 16.2427 54.5996 16.3612 55.0827 16.3612C55.5659 16.3612 55.9876 16.2427 56.3477 16.0057C56.7077 15.7687 56.9863 15.4209 57.1832 14.9624C57.3833 14.5038 57.4833 13.9406 57.4833 13.2727ZM67.0905 8.54545H69.0895V14.6854C69.0895 15.3748 68.9248 15.978 68.5955 16.495C68.2693 17.0121 67.8122 17.4152 67.2244 17.7045C66.6366 17.9908 65.9518 18.1339 65.1701 18.1339C64.3853 18.1339 63.699 17.9908 63.1111 17.7045C62.5233 17.4152 62.0663 17.0121 61.74 16.495C61.4138 15.978 61.2507 15.3748 61.2507 14.6854V8.54545H63.2496V14.5146C63.2496 14.8746 63.3281 15.1947 63.4851 15.4748C63.6451 15.7549 63.8698 15.9749 64.1591 16.1349C64.4484 16.295 64.7854 16.375 65.1701 16.375C65.5579 16.375 65.8949 16.295 66.1811 16.1349C66.4704 15.9749 66.6935 15.7549 66.8505 15.4748C67.0105 15.1947 67.0905 14.8746 67.0905 14.5146V8.54545ZM72.993 8.54545V18H70.9941V8.54545H72.993ZM83.2396 11.8555H81.2176C81.1807 11.5939 81.1053 11.3615 80.9914 11.1584C80.8775 10.9522 80.7313 10.7768 80.5528 10.6321C80.3743 10.4875 80.1681 10.3767 79.9342 10.2997C79.7034 10.2228 79.4526 10.1843 79.1817 10.1843C78.6924 10.1843 78.2661 10.3059 77.903 10.549C77.5398 10.7891 77.2582 11.1399 77.0581 11.6016C76.8581 12.0601 76.7581 12.6172 76.7581 13.2727C76.7581 13.9467 76.8581 14.513 77.0581 14.9716C77.2613 15.4302 77.5444 15.7764 77.9076 16.0103C78.2707 16.2442 78.6908 16.3612 79.1679 16.3612C79.4356 16.3612 79.6834 16.3258 79.9111 16.255C80.142 16.1842 80.3466 16.0811 80.5251 15.9457C80.7036 15.8072 80.8513 15.6394 80.9683 15.4425C81.0883 15.2455 81.1714 15.0208 81.2176 14.7685L83.2396 14.7777C83.1873 15.2116 83.0565 15.6302 82.8472 16.0334C82.641 16.4335 82.3625 16.792 82.0116 17.109C81.6638 17.4229 81.2484 17.6722 80.7652 17.8569C80.2851 18.0385 79.7419 18.1293 79.1356 18.1293C78.2923 18.1293 77.5383 17.9384 76.8735 17.5568C76.2118 17.1752 75.6886 16.6228 75.3039 15.8995C74.9223 15.1763 74.7314 14.3007 74.7314 13.2727C74.7314 12.2417 74.9253 11.3646 75.3131 10.6413C75.7009 9.91809 76.2272 9.36719 76.892 8.98864C77.5567 8.60701 78.3046 8.41619 79.1356 8.41619C79.6834 8.41619 80.1912 8.49313 80.659 8.64702C81.1299 8.8009 81.5469 9.02557 81.9101 9.32102C82.2732 9.6134 82.5687 9.97195 82.7964 10.3967C83.0272 10.8214 83.175 11.3076 83.2396 11.8555ZM84.933 18V8.54545H86.932V12.7141H87.0566L90.4589 8.54545H92.8549L89.3464 12.7788L92.8964 18H90.5051L87.9153 14.1129L86.932 15.3132V18H84.933ZM99.1328 8.54545L101.418 15.7287H101.506L103.795 8.54545H106.011L102.752 18H100.176L96.9123 8.54545H99.1328ZM109.408 8.54545V18H107.409V8.54545H109.408ZM111.313 18V8.54545H117.684V10.1935H113.312V12.4464H117.356V14.0945H113.312V16.3519H117.702V18H111.313ZM121.661 18L118.956 8.54545H121.139L122.704 15.1147H122.783L124.509 8.54545H126.379L128.101 15.1286H128.184L129.749 8.54545H131.933L129.227 18H127.279L125.479 11.8185H125.405L123.609 18H121.661Z",
  fill: "#313131"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("rect", {
  width: "42",
  height: "42",
  rx: "4",
  fill: "url(#paint0_linear_3_14)"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M20.25 13.5C23.976 13.5 27 16.524 27 20.25C27 23.976 23.976 27 20.25 27C16.524 27 13.5 23.976 13.5 20.25C13.5 16.524 16.524 13.5 20.25 13.5ZM20.25 25.5C23.1503 25.5 25.5 23.1503 25.5 20.25C25.5 17.349 23.1503 15 20.25 15C17.349 15 15 17.349 15 20.25C15 23.1503 17.349 25.5 20.25 25.5ZM26.6138 25.5533L28.7355 27.6743L27.6743 28.7355L25.5533 26.6138L26.6138 25.5533V25.5533Z",
  fill: "white"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("defs", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("linearGradient", {
  id: "paint0_linear_3_14",
  x1: "21",
  y1: "0",
  x2: "21",
  y2: "42",
  gradientUnits: "userSpaceOnUse"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("stop", {
  "stop-color": "#DA0000"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("stop", {
  offset: "1",
  "stop-color": "#FF2C2C"
})])])], -1
/* HOISTED */
);

var _hoisted_6 = {
  "class": "adfy-col end"
};
var _hoisted_7 = {
  "class": "buttons"
};
var _hoisted_8 = {
  href: "https://docs.addonify.com/kb/woocommerce-wihlist/",
  "class": "adfy-button fake-button has-underline",
  target: "_blank"
};
var _hoisted_9 = ["disabled", "loading"];

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "loading-icon"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  viewBox: "0 0 1024 1024",
  xmlns: "http://www.w3.org/2000/svg"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  fill: "currentColor",
  d: "M512 64a32 32 0 0 1 32 32v192a32 32 0 0 1-64 0V96a32 32 0 0 1 32-32zm0 640a32 32 0 0 1 32 32v192a32 32 0 1 1-64 0V736a32 32 0 0 1 32-32zm448-192a32 32 0 0 1-32 32H736a32 32 0 1 1 0-64h192a32 32 0 0 1 32 32zm-640 0a32 32 0 0 1-32 32H96a32 32 0 0 1 0-64h192a32 32 0 0 1 32 32zM195.2 195.2a32 32 0 0 1 45.248 0L376.32 331.008a32 32 0 0 1-45.248 45.248L195.2 240.448a32 32 0 0 1 0-45.248zm452.544 452.544a32 32 0 0 1 45.248 0L828.8 783.552a32 32 0 0 1-45.248 45.248L647.744 692.992a32 32 0 0 1 0-45.248zM828.8 195.264a32 32 0 0 1 0 45.184L692.992 376.32a32 32 0 0 1-45.248-45.248l135.808-135.808a32 32 0 0 1 45.248 0zm-452.544 452.48a32 32 0 0 1 0 45.248L240.448 828.8a32 32 0 0 1-45.248-45.248l135.808-135.808a32 32 0 0 1 45.248 0z"
})])], -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("header", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    "class": "adfy-link",
    to: "/"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_5];
    }),
    _: 1
    /* STABLE */

  })])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Documentation", "addonify-wishlist")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "submit",
    onClick: _cache[0] || (_cache[0] = function ($event) {
      return $setup.store.handleUpdateOptions();
    }),
    "class": "adfy-button",
    disabled: !$setup.store.needSave,
    loading: $setup.store.isSaving
  }, [_hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Save Options", "addonify-wishlist")), 1
  /* TEXT */
  )], 8
  /* PROPS */
  , _hoisted_9)])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Loading.vue?vue&type=template&id=38c45614":
/*!**********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Loading.vue?vue&type=template&id=38c45614 ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "adfy-loading"
};

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "pulse"
}, null, -1
/* HOISTED */
);

var _hoisted_3 = [_hoisted_2];
function render(_ctx, _cache) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("section", _hoisted_1, _hoisted_3);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Navigation.vue?vue&type=template&id=39b3684a":
/*!*************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Navigation.vue?vue&type=template&id=39b3684a ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "adfy-navigation"
};
var _hoisted_2 = {
  "class": "navigation"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  fill: "none",
  d: "M0 0h24v24H0z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M2.132 13.63a9.942 9.942 0 0 1 0-3.26c1.102.026 2.092-.502 2.477-1.431.385-.93.058-2.004-.74-2.763a9.942 9.942 0 0 1 2.306-2.307c.76.798 1.834 1.125 2.764.74.93-.385 1.457-1.376 1.43-2.477a9.942 9.942 0 0 1 3.262 0c-.027 1.102.501 2.092 1.43 2.477.93.385 2.004.058 2.763-.74a9.942 9.942 0 0 1 2.307 2.306c-.798.76-1.125 1.834-.74 2.764.385.93 1.376 1.457 2.477 1.43a9.942 9.942 0 0 1 0 3.262c-1.102-.027-2.092.501-2.477 1.43-.385.93-.058 2.004.74 2.763a9.942 9.942 0 0 1-2.306 2.307c-.76-.798-1.834-1.125-2.764-.74-.93.385-1.457 1.376-1.43 2.477a9.942 9.942 0 0 1-3.262 0c.027-1.102-.501-2.092-1.43-2.477-.93-.385-2.004-.058-2.763.74a9.942 9.942 0 0 1-2.307-2.306c.798-.76 1.125-1.834.74-2.764-.385-.93-1.376-1.457-2.477-1.43zM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"
})])], -1
/* HOISTED */
);

var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  fill: "none",
  d: "M0 0h24v24H0z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M4 3h16a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm2 9h6a1 1 0 0 1 1 1v3h1v6h-4v-6h1v-2H5a1 1 0 0 1-1-1v-2h2v1zm11.732 1.732l1.768-1.768 1.768 1.768a2.5 2.5 0 1 1-3.536 0z"
})])], -1
/* HOISTED */
);

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "icon"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  fill: "none",
  d: "M0 0h24v24H0z"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M13 16.938V19h5v2H6v-2h5v-2.062A8.001 8.001 0 0 1 4 9V3h16v6a8.001 8.001 0 0 1-7 7.938zM1 5h2v4H1V5zm20 0h2v4h-2V5z"
})])], -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("nav", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Settings", "addonify-wishlist")), 1
      /* TEXT */
      )];
    }),
    _: 1
    /* STABLE */

  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/styles"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Styles", "addonify-wishlist")), 1
      /* TEXT */
      )];
    }),
    _: 1
    /* STABLE */

  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/products"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Products", "addonify-wishlist")), 1
      /* TEXT */
      )];
    }),
    _: 1
    /* STABLE */

  })])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/404.vue?vue&type=template&id=155f1cce":
/*!*****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/404.vue?vue&type=template&id=155f1cce ***!
  \*****************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "error-404"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_router_link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("router-link");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("404", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Oops, page not found!", "addonify-quick-view")), 1
  /* TEXT */
  ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_router_link, {
    to: "/",
    "class": "adfy-button"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Go Back", "addonify-quick-view")), 1
      /* TEXT */
      )];
    }),
    _: 1
    /* STABLE */

  })]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Products.vue?vue&type=template&id=62ebf7de":
/*!**********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Products.vue?vue&type=template&id=62ebf7de ***!
  \**********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "adfy-container"
};
var _hoisted_2 = {
  "class": "adfy-columns main-content"
};
var _hoisted_3 = {
  "class": "adfy-col start aside secondary"
};
var _hoisted_4 = {
  "class": "adfy-col end site-primary"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("main", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("aside", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Navigation"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.__("Coming soon.....", "addonify-quick-view")), 1
  /* TEXT */
  )])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Settings.vue?vue&type=template&id=45416b1d":
/*!**********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Settings.vue?vue&type=template&id=45416b1d ***!
  \**********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "adfy-container"
};
var _hoisted_2 = {
  "class": "adfy-columns main-content"
};
var _hoisted_3 = {
  "class": "adfy-col start site-secondary"
};
var _hoisted_4 = {
  "class": "adfy-col end site-primary"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("main", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("aside", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Navigation"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Settings"])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Styles.vue?vue&type=template&id=9eae3e48":
/*!********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Styles.vue?vue&type=template&id=9eae3e48 ***!
  \********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "adfy-container"
};
var _hoisted_2 = {
  "class": "adfy-columns main-content"
};
var _hoisted_3 = {
  "class": "adfy-col start aside site-secondary"
};
var _hoisted_4 = {
  "class": "adfy-col end site-primary"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("main", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("aside", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Navigation"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["StyleForm"])])])]);
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.el-checkbox {\n\t\t--el-checkbox-font-weight: normal;\n}\n.el-select-dropdown__item.selected {\n\t\tfont-weight: normal;\n}\n.el-message--success {\n\t\t-el-message-text-color: #2f8e00;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.adfy-options .tooltip-base-box {\n\t\twidth: 400px;\n}\n.adfy-options .el-textarea__inner {\n\t\tdisplay: block;\n\t\twidth: 100%;\n\t\tfont-family: monospace;\n\t\tmin-height: 200px;\n}\n.adfy-options .el-color-picker__trigger,\n\t.adfy-options .el-color-picker__color,\n\t.adfy-options .el-color-picker__color-inner {\n\t\tborder-radius: 100%;\n}\n.adfy-options .el-color-picker__color {\n\t\tborder: none;\n}\n.adfy-options .el-color-picker__trigger {\n\t\theight: 36px;\n\t\twidth: 36px;\n\t\tpadding: 5px;\n\t\tborder: 2px dotted #bbbbbb;\n}\n.adfy-options .seperator {\n\t\tdisplay: block;\n\t\theight: 1px;\n\t\tmargin: 20px 0;\n\t\tbackground-color: #ededed;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./admin/assets/scss/index.scss":
/*!**************************************!*\
  !*** ./admin/assets/scss/index.scss ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_style_index_0_id_2c85248e_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_style_index_0_id_2c85248e_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_style_index_0_id_2c85248e_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_style_index_0_id_07be428d_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Styles.vue?vue&type=style&index=0&id=07be428d&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_style_index_0_id_07be428d_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_style_index_0_id_07be428d_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./admin/src/App.vue":
/*!***************************!*\
  !*** ./admin/src/App.vue ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _App_vue_vue_type_template_id_20c9a2f8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./App.vue?vue&type=template&id=20c9a2f8 */ "./admin/src/App.vue?vue&type=template&id=20c9a2f8");
/* harmony import */ var _App_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./App.vue?vue&type=script&setup=true&lang=js */ "./admin/src/App.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_App_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_App_vue_vue_type_template_id_20c9a2f8__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/App.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/components/form/Settings.vue":
/*!************************************************!*\
  !*** ./admin/src/components/form/Settings.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Settings_vue_vue_type_template_id_2c85248e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Settings.vue?vue&type=template&id=2c85248e */ "./admin/src/components/form/Settings.vue?vue&type=template&id=2c85248e");
/* harmony import */ var _Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Settings.vue?vue&type=script&setup=true&lang=js */ "./admin/src/components/form/Settings.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _Settings_vue_vue_type_style_index_0_id_2c85248e_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css */ "./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Settings_vue_vue_type_template_id_2c85248e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/components/form/Settings.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/components/form/Styles.vue":
/*!**********************************************!*\
  !*** ./admin/src/components/form/Styles.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Styles_vue_vue_type_template_id_07be428d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Styles.vue?vue&type=template&id=07be428d */ "./admin/src/components/form/Styles.vue?vue&type=template&id=07be428d");
/* harmony import */ var _Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Styles.vue?vue&type=script&setup=true&lang=js */ "./admin/src/components/form/Styles.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _Styles_vue_vue_type_style_index_0_id_07be428d_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Styles.vue?vue&type=style&index=0&id=07be428d&lang=css */ "./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Styles_vue_vue_type_template_id_07be428d__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/components/form/Styles.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/components/layouts/Footer.vue":
/*!*************************************************!*\
  !*** ./admin/src/components/layouts/Footer.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Footer_vue_vue_type_template_id_4f77115e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Footer.vue?vue&type=template&id=4f77115e */ "./admin/src/components/layouts/Footer.vue?vue&type=template&id=4f77115e");
/* harmony import */ var _Footer_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Footer.vue?vue&type=script&setup=true&lang=js */ "./admin/src/components/layouts/Footer.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Footer_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Footer_vue_vue_type_template_id_4f77115e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/components/layouts/Footer.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/components/layouts/Header.vue":
/*!*************************************************!*\
  !*** ./admin/src/components/layouts/Header.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Header_vue_vue_type_template_id_0d12497a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Header.vue?vue&type=template&id=0d12497a */ "./admin/src/components/layouts/Header.vue?vue&type=template&id=0d12497a");
/* harmony import */ var _Header_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Header.vue?vue&type=script&setup=true&lang=js */ "./admin/src/components/layouts/Header.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Header_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Header_vue_vue_type_template_id_0d12497a__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/components/layouts/Header.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/components/layouts/Loading.vue":
/*!**************************************************!*\
  !*** ./admin/src/components/layouts/Loading.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Loading_vue_vue_type_template_id_38c45614__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Loading.vue?vue&type=template&id=38c45614 */ "./admin/src/components/layouts/Loading.vue?vue&type=template&id=38c45614");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");

const script = {}

;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_1__["default"])(script, [['render',_Loading_vue_vue_type_template_id_38c45614__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/components/layouts/Loading.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/components/layouts/Navigation.vue":
/*!*****************************************************!*\
  !*** ./admin/src/components/layouts/Navigation.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Navigation_vue_vue_type_template_id_39b3684a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navigation.vue?vue&type=template&id=39b3684a */ "./admin/src/components/layouts/Navigation.vue?vue&type=template&id=39b3684a");
/* harmony import */ var _Navigation_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Navigation.vue?vue&type=script&setup=true&lang=js */ "./admin/src/components/layouts/Navigation.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Navigation_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Navigation_vue_vue_type_template_id_39b3684a__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/components/layouts/Navigation.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/views/404.vue":
/*!*********************************!*\
  !*** ./admin/src/views/404.vue ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _404_vue_vue_type_template_id_155f1cce__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./404.vue?vue&type=template&id=155f1cce */ "./admin/src/views/404.vue?vue&type=template&id=155f1cce");
/* harmony import */ var _404_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./404.vue?vue&type=script&setup=true&lang=js */ "./admin/src/views/404.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_404_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_404_vue_vue_type_template_id_155f1cce__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/views/404.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/views/Products.vue":
/*!**************************************!*\
  !*** ./admin/src/views/Products.vue ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Products_vue_vue_type_template_id_62ebf7de__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Products.vue?vue&type=template&id=62ebf7de */ "./admin/src/views/Products.vue?vue&type=template&id=62ebf7de");
/* harmony import */ var _Products_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Products.vue?vue&type=script&setup=true&lang=js */ "./admin/src/views/Products.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Products_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Products_vue_vue_type_template_id_62ebf7de__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/views/Products.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/views/Settings.vue":
/*!**************************************!*\
  !*** ./admin/src/views/Settings.vue ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Settings_vue_vue_type_template_id_45416b1d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Settings.vue?vue&type=template&id=45416b1d */ "./admin/src/views/Settings.vue?vue&type=template&id=45416b1d");
/* harmony import */ var _Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Settings.vue?vue&type=script&setup=true&lang=js */ "./admin/src/views/Settings.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Settings_vue_vue_type_template_id_45416b1d__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/views/Settings.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/views/Styles.vue":
/*!************************************!*\
  !*** ./admin/src/views/Styles.vue ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Styles_vue_vue_type_template_id_9eae3e48__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Styles.vue?vue&type=template&id=9eae3e48 */ "./admin/src/views/Styles.vue?vue&type=template&id=9eae3e48");
/* harmony import */ var _Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Styles.vue?vue&type=script&setup=true&lang=js */ "./admin/src/views/Styles.vue?vue&type=script&setup=true&lang=js");
/* harmony import */ var _home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_home_anujsubedi_Local_Sites_xenial_app_public_wp_content_plugins_addonify_wishlist_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Styles_vue_vue_type_template_id_9eae3e48__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"admin/src/views/Styles.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./admin/src/App.vue?vue&type=script&setup=true&lang=js":
/*!**************************************************************!*\
  !*** ./admin/src/App.vue?vue&type=script&setup=true&lang=js ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_App_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_App_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./App.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/App.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/components/form/Settings.vue?vue&type=script&setup=true&lang=js":
/*!***********************************************************************************!*\
  !*** ./admin/src/components/form/Settings.vue?vue&type=script&setup=true&lang=js ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/components/form/Styles.vue?vue&type=script&setup=true&lang=js":
/*!*********************************************************************************!*\
  !*** ./admin/src/components/form/Styles.vue?vue&type=script&setup=true&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Styles.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/components/layouts/Footer.vue?vue&type=script&setup=true&lang=js":
/*!************************************************************************************!*\
  !*** ./admin/src/components/layouts/Footer.vue?vue&type=script&setup=true&lang=js ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Footer.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Footer.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/components/layouts/Header.vue?vue&type=script&setup=true&lang=js":
/*!************************************************************************************!*\
  !*** ./admin/src/components/layouts/Header.vue?vue&type=script&setup=true&lang=js ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Header_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Header_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Header.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Header.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/components/layouts/Navigation.vue?vue&type=script&setup=true&lang=js":
/*!****************************************************************************************!*\
  !*** ./admin/src/components/layouts/Navigation.vue?vue&type=script&setup=true&lang=js ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Navigation_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Navigation_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Navigation.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Navigation.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/views/404.vue?vue&type=script&setup=true&lang=js":
/*!********************************************************************!*\
  !*** ./admin/src/views/404.vue?vue&type=script&setup=true&lang=js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_404_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_404_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./404.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/404.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/views/Products.vue?vue&type=script&setup=true&lang=js":
/*!*************************************************************************!*\
  !*** ./admin/src/views/Products.vue?vue&type=script&setup=true&lang=js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Products_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Products_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Products.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Products.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/views/Settings.vue?vue&type=script&setup=true&lang=js":
/*!*************************************************************************!*\
  !*** ./admin/src/views/Settings.vue?vue&type=script&setup=true&lang=js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Settings.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/views/Styles.vue?vue&type=script&setup=true&lang=js":
/*!***********************************************************************!*\
  !*** ./admin/src/views/Styles.vue?vue&type=script&setup=true&lang=js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_script_setup_true_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Styles.vue?vue&type=script&setup=true&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Styles.vue?vue&type=script&setup=true&lang=js");
 

/***/ }),

/***/ "./admin/src/App.vue?vue&type=template&id=20c9a2f8":
/*!*********************************************************!*\
  !*** ./admin/src/App.vue?vue&type=template&id=20c9a2f8 ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_App_vue_vue_type_template_id_20c9a2f8__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_App_vue_vue_type_template_id_20c9a2f8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./App.vue?vue&type=template&id=20c9a2f8 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/App.vue?vue&type=template&id=20c9a2f8");


/***/ }),

/***/ "./admin/src/components/form/Settings.vue?vue&type=template&id=2c85248e":
/*!******************************************************************************!*\
  !*** ./admin/src/components/form/Settings.vue?vue&type=template&id=2c85248e ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_template_id_2c85248e__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_template_id_2c85248e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=template&id=2c85248e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=template&id=2c85248e");


/***/ }),

/***/ "./admin/src/components/form/Styles.vue?vue&type=template&id=07be428d":
/*!****************************************************************************!*\
  !*** ./admin/src/components/form/Styles.vue?vue&type=template&id=07be428d ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_template_id_07be428d__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_template_id_07be428d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Styles.vue?vue&type=template&id=07be428d */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=template&id=07be428d");


/***/ }),

/***/ "./admin/src/components/layouts/Footer.vue?vue&type=template&id=4f77115e":
/*!*******************************************************************************!*\
  !*** ./admin/src/components/layouts/Footer.vue?vue&type=template&id=4f77115e ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_4f77115e__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_4f77115e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Footer.vue?vue&type=template&id=4f77115e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Footer.vue?vue&type=template&id=4f77115e");


/***/ }),

/***/ "./admin/src/components/layouts/Header.vue?vue&type=template&id=0d12497a":
/*!*******************************************************************************!*\
  !*** ./admin/src/components/layouts/Header.vue?vue&type=template&id=0d12497a ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Header_vue_vue_type_template_id_0d12497a__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Header_vue_vue_type_template_id_0d12497a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Header.vue?vue&type=template&id=0d12497a */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Header.vue?vue&type=template&id=0d12497a");


/***/ }),

/***/ "./admin/src/components/layouts/Loading.vue?vue&type=template&id=38c45614":
/*!********************************************************************************!*\
  !*** ./admin/src/components/layouts/Loading.vue?vue&type=template&id=38c45614 ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Loading_vue_vue_type_template_id_38c45614__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Loading_vue_vue_type_template_id_38c45614__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Loading.vue?vue&type=template&id=38c45614 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Loading.vue?vue&type=template&id=38c45614");


/***/ }),

/***/ "./admin/src/components/layouts/Navigation.vue?vue&type=template&id=39b3684a":
/*!***********************************************************************************!*\
  !*** ./admin/src/components/layouts/Navigation.vue?vue&type=template&id=39b3684a ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Navigation_vue_vue_type_template_id_39b3684a__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Navigation_vue_vue_type_template_id_39b3684a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Navigation.vue?vue&type=template&id=39b3684a */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/layouts/Navigation.vue?vue&type=template&id=39b3684a");


/***/ }),

/***/ "./admin/src/views/404.vue?vue&type=template&id=155f1cce":
/*!***************************************************************!*\
  !*** ./admin/src/views/404.vue?vue&type=template&id=155f1cce ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_404_vue_vue_type_template_id_155f1cce__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_404_vue_vue_type_template_id_155f1cce__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./404.vue?vue&type=template&id=155f1cce */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/404.vue?vue&type=template&id=155f1cce");


/***/ }),

/***/ "./admin/src/views/Products.vue?vue&type=template&id=62ebf7de":
/*!********************************************************************!*\
  !*** ./admin/src/views/Products.vue?vue&type=template&id=62ebf7de ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Products_vue_vue_type_template_id_62ebf7de__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Products_vue_vue_type_template_id_62ebf7de__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Products.vue?vue&type=template&id=62ebf7de */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Products.vue?vue&type=template&id=62ebf7de");


/***/ }),

/***/ "./admin/src/views/Settings.vue?vue&type=template&id=45416b1d":
/*!********************************************************************!*\
  !*** ./admin/src/views/Settings.vue?vue&type=template&id=45416b1d ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_template_id_45416b1d__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_template_id_45416b1d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=template&id=45416b1d */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Settings.vue?vue&type=template&id=45416b1d");


/***/ }),

/***/ "./admin/src/views/Styles.vue?vue&type=template&id=9eae3e48":
/*!******************************************************************!*\
  !*** ./admin/src/views/Styles.vue?vue&type=template&id=9eae3e48 ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_template_id_9eae3e48__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_template_id_9eae3e48__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Styles.vue?vue&type=template&id=9eae3e48 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/views/Styles.vue?vue&type=template&id=9eae3e48");


/***/ }),

/***/ "./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css":
/*!********************************************************************************************!*\
  !*** ./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Settings_vue_vue_type_style_index_0_id_2c85248e_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Settings.vue?vue&type=style&index=0&id=2c85248e&lang=css");


/***/ }),

/***/ "./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css":
/*!******************************************************************************************!*\
  !*** ./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Styles_vue_vue_type_style_index_0_id_07be428d_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Styles.vue?vue&type=style&index=0&id=07be428d&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./admin/src/components/form/Styles.vue?vue&type=style&index=0&id=07be428d&lang=css");


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["css/admin","/js/vendor"], () => (__webpack_exec__("./admin/src/main.js"), __webpack_exec__("./admin/assets/scss/index.scss")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);