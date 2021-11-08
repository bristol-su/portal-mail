/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@bristol-su/portal-ui-kit/src/generator/schema/Field.js":
/*!******************************************************************************!*\
  !*** ./node_modules/@bristol-su/portal-ui-kit/src/generator/schema/Field.js ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (class {

    constructor(type, id) {
        this.schema = {
            id: id,
            type: type,
            label: null,
            value: null,
            visible: true,
            disabled: false,
            required: false,
            hint: null,
            tooltip: null,
            errorKey: id
        }
    }

    id(id) {
        this.schema.id = id;
        return this;
    }

    errorKey(errorKey) {
        this.schema.errorKey = errorKey;
        return this;
    }

    label(label) {
        this.schema.label = label;
        return this;
    }

    value(value) {
        this.schema.value = value;
        return this;
    }

    visible(visible) {
        this.schema.visible = visible;
        return this;
    }

    disabled(disabled) {
        this.schema.disabled = disabled;
        return this;
    }

    required(required) {
        this.schema.required = required;
        return this;
    }

    hint(hint) {
        this.schema.hint = hint;
        return this;
    }

    tooltip(tooltip) {
        this.schema.tooltip = tooltip;
        return this;
    }

    asJson() {
        return this.schema;
    }

});


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/AddAddress.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/AddAddress.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "AddAddress",
  data: function data() {
    return {
      emailForm: {}
    };
  },
  methods: {
    addEmail: function addEmail(data) {
      var _this = this;

      // TODO Change to info not delete
      this.$ui.confirm["delete"]('Add email address?', 'Are you sure you want to add this email address? This will allow emails to be sent from ' + data.email).then(function () {
        _this.$httpBasic.post('/mail/address', {
          email: data.email
        }, {
          name: 'email-address-add'
        }).then(function (response) {
          _this.$ui.notify.success('Email added');

          _this.$emit('added', response.data);
        });
      });
    }
  },
  computed: {
    emailAddresses: function emailAddresses() {
      return this.emails;
    },
    form: function form() {
      return this.$tools.generator.form.newForm().withField(this.$tools.generator.field.text('email').label('Email Address').hint('The new email address').tooltip('The email you\'d like to be able to send from').required(true));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/ViewAddresses.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/ViewAddresses.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AddAddress__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddAddress */ "./resources/js/components/address/AddAddress.vue");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "ViewAddresses",
  components: {
    AddAddress: _AddAddress__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: {
    emails: {
      type: Array,
      "default": function _default() {
        return [];
      }
    }
  },
  data: function data() {
    return {
      emailTableFields: [{
        key: 'email',
        label: 'Email Address'
      }, {
        key: 'status',
        label: 'Status'
      }],
      domainFields: [{
        key: 'domain',
        label: 'Domain'
      }, {
        key: 'status',
        label: 'Status'
      }],
      viewingDomainFields: [{
        key: 'name',
        label: 'CNAME Name'
      }, {
        key: 'value',
        label: 'CNAME Value'
      }],
      newEmails: [],
      removedEmails: [],
      domains: [],
      viewingDomain: null
    };
  },
  mounted: function mounted() {
    this.refreshDomains();
  },
  methods: {
    deleteAddress: function deleteAddress(address) {
      var _this = this;

      this.$ui.confirm["delete"]('Delete email address?', 'Are you sure you want to delete this email address?').then(function () {
        _this.$httpBasic["delete"]('/mail/address/' + address.id, {
          name: 'delete-email-address-' + address.id
        }).then(function (response) {
          _this.$ui.notify.success('Email deleted');

          _this.removedEmails.push(address.id);
        });
      });
    },
    addEmail: function addEmail(email) {
      this.newEmails.push(email);
      this.refreshDomains();
      this.$ui.modal.hide('add-email');
    },
    verifyEmail: function verifyEmail(address) {
      var _this2 = this;

      this.$httpBasic.post('/mail/address/' + address.id + '/verification').then(function (response) {
        return _this2.$ui.notify.success('Verification email sent');
      })["catch"](function (error) {
        return _this2.$ui.notify.alert('Verification email not sent: ' + error.message);
      });
    },
    viewDomain: function viewDomain(domain) {
      this.viewingDomain = domain;
      this.$ui.modal.show('view-cname');
    },
    refreshDomains: function refreshDomains() {
      var _this3 = this;

      this.$httpBasic.get('/mail/domains', {
        name: 'get-domains'
      }).then(function (response) {
        return _this3.domains = response.data;
      })["catch"](function (error) {
        return _this3.$ui.notify.alert('Could not refresh the domain: ' + error.message);
      });
    },
    getDnsDetails: function getDnsDetails(dnsRecords) {
      var details = [];

      for (var _i = 0, _Object$entries = Object.entries(dnsRecords); _i < _Object$entries.length; _i++) {
        var _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2),
            recordName = _Object$entries$_i[0],
            recordValue = _Object$entries$_i[1];

        details.push({
          name: recordName,
          value: recordValue
        });
      }

      return details;
    }
  },
  computed: {
    emailAddresses: function emailAddresses() {
      var _this4 = this;

      return _.cloneDeep(this.emails).concat(this.newEmails).filter(function (email) {
        return !_this4.removedEmails.includes(email.id);
      }).map(function (email) {
        return _objectSpread(_objectSpread({}, email), {}, {
          _table: {
            isDeleting: _this4.$isLoading('delete-email-address-' + email.id)
          }
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/send/SendEmail.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/send/SendEmail.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _bristol_su_portal_ui_kit_src_generator_schema_Field__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @bristol-su/portal-ui-kit/src/generator/schema/Field */ "./node_modules/@bristol-su/portal-ui-kit/src/generator/schema/Field.js");
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e3) { throw _e3; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e4) { didErr = true; err = _e4; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "SendEmail",
  props: {
    from: {
      required: true,
      type: Array,
      "default": function _default() {
        return [];
      }
    }
  },
  methods: {
    send: function send(data) {
      var _this = this;

      var formData = new FormData();

      if (data.attachments.length > 0) {
        formData.append('type', 'file');

        var _iterator = _createForOfIteratorHelper(data.attachments),
            _step;

        try {
          for (_iterator.s(); !(_step = _iterator.n()).done;) {
            var attachment = _step.value;
            formData.append('attachments[]', attachment);
          }
        } catch (err) {
          _iterator.e(err);
        } finally {
          _iterator.f();
        }
      }

      formData.append('from', data.from);

      var _iterator2 = _createForOfIteratorHelper(data.to),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var e = _step2.value;
          formData.append('to[]', e);
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }

      var _iterator3 = _createForOfIteratorHelper(data.cc),
          _step3;

      try {
        for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
          var _e = _step3.value;
          formData.append('cc[]', _e);
        }
      } catch (err) {
        _iterator3.e(err);
      } finally {
        _iterator3.f();
      }

      var _iterator4 = _createForOfIteratorHelper(data.bcc),
          _step4;

      try {
        for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
          var _e2 = _step4.value;
          formData.append('bcc[]', _e2);
        }
      } catch (err) {
        _iterator4.e(err);
      } finally {
        _iterator4.f();
      }

      formData.append('subject', data.subject);
      formData.append('content', data.content);
      console.log(formData.forEach(function (value, key) {
        return console.log(value, key);
      }));
      this.$httpBasic.post('/mail/send', formData, {
        name: 'sending-email',
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(function (response) {
        _this.$notify.success('Email sent');
      })["catch"](function (error) {
        return _this.$notify.error('Email was not sent: ' + error.message);
      });
    },
    preview: function preview(data) {}
  },
  computed: {
    form: function form() {
      return this.$tools.generator.form.newForm().withField(this.$tools.generator.field.select('from').setOptions(this.from.map(function (e) {
        return {
          id: e.id,
          value: e.email
        };
      })).label('From').hint('Who to send the email from.').tooltip('This will appear as the address the email is sent from').required(true)).withField(this.$tools.generator.field.tags('to').label('To *').hint('Who to send the email to.').tooltip('You may enter multiple recipients by pressing enter.').required(false)).withField(this.$tools.generator.field.tags('cc').label('CC').hint('Who to cc the email to.').tooltip('You may enter multiple recipients by pressing enter.').value([]).required(false)).withField(this.$tools.generator.field.tags('bcc').label('Bcc').hint('Who to bcc the email to.').tooltip('You may enter multiple recipients by pressing enter.').value([]).required(false)).withField(this.$tools.generator.field.text('subject').label('Subject').hint('The subject of the message.').tooltip('This will appear as the subject on the email.').required(false)).withField(new _bristol_su_portal_ui_kit_src_generator_schema_Field__WEBPACK_IMPORTED_MODULE_0__["default"]('html', 'content').label('Content').hint('The body of the email').required(false)).withField(this.$tools.generator.field.file('attachments').label('Attachments').multiple(true).hint('Attachments for the email.').value([]).tooltip('You may select multiple files.').required(false));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/EditUser.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/EditUser.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "EditUser",
  data: function data() {
    return {
      userForm: {}
    };
  },
  props: {
    user: {
      required: false,
      "default": null
    },
    availableEmails: {
      required: false,
      "default": function _default() {
        return [];
      },
      type: Array
    }
  },
  methods: {
    addUser: function addUser(data) {
      var _this = this;

      this.$ui.confirm["delete"]('Change user access?', 'Are you sure you want to change the email access for this user?').then(function () {
        _this.$httpBasic.patch('/mail/user/' + data.user, {
          email_ids: data.email_ids
        }, {
          name: 'user-add'
        }).then(function (response) {
          _this.$ui.notify.success('User permissions changed');

          _this.$emit('added', response.data);
        });
      });
    }
  },
  computed: {
    userAddresses: function userAddresses() {
      return this.users;
    },
    form: function form() {
      return this.$tools.generator.form.newForm().withField(this.$tools.generator.field.number('user').label('User').hint('The user to grant access to').required(true).value(this.user !== null ? this.user.id : null).disabled(this.user !== null)).withField(this.$tools.generator.field.checkList('email_ids').label('Emails').hint('The emails the user can send from').tooltip('The email addresses that the user has permission to send from').required(false).setOptions(this.availableEmails.map(function (e) {
        return {
          id: e.id,
          text: e.email
        };
      })).value(this.user !== null ? this.user.email_addresses.map(function (e) {
        return e.id;
      }) : []));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/ViewUsers.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/ViewUsers.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _EditUser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditUser */ "./resources/js/components/users/EditUser.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "ViewUsers",
  components: {
    EditUser: _EditUser__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: {
    users: {
      required: true,
      type: Array,
      "default": function _default() {
        return [];
      }
    },
    availableEmails: {
      required: false,
      "default": function _default() {
        return [];
      },
      type: Array
    }
  },
  mounted: function mounted() {
    this.managedUsers = this.users;
  },
  data: function data() {
    return {
      userTableFields: [{
        key: 'data.preferred_name',
        label: 'Name'
      }, {
        key: 'data.email',
        label: 'Email'
      }, {
        key: 'all_emails',
        label: 'Available Emails',
        truncateCell: 30
      }],
      managedUsers: [],
      removedUsers: [],
      editingUser: null
    };
  },
  methods: {
    editUser: function editUser(user) {
      this.editingUser = user;
      this.$ui.modal.show('edit-user');
    },
    addUser: function addUser(user) {
      this.managedUsers = this.managedUsers.filter(function (u) {
        return u.id !== user.id;
      });

      if (user.email_addresses.length > 0) {
        this.managedUsers.push(user);
      }

      this.editingUser = null;
      this.$ui.modal.hide('edit-user');
    }
  },
  computed: {
    userItems: function userItems() {
      var _this = this;

      return this.managedUsers.filter(function (user) {
        return !_this.removedUsers.includes(user.id);
      }).map(function (user) {
        user.all_emails = user.email_addresses.map(function (e) {
          return e.email;
        }).join(', ');
        return user;
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/address/AddAddress.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/address/AddAddress.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AddAddress_vue_vue_type_template_id_eb90888e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddAddress.vue?vue&type=template&id=eb90888e&scoped=true& */ "./resources/js/components/address/AddAddress.vue?vue&type=template&id=eb90888e&scoped=true&");
/* harmony import */ var _AddAddress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AddAddress.vue?vue&type=script&lang=js& */ "./resources/js/components/address/AddAddress.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AddAddress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AddAddress_vue_vue_type_template_id_eb90888e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _AddAddress_vue_vue_type_template_id_eb90888e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "eb90888e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/address/AddAddress.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/address/ViewAddresses.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/address/ViewAddresses.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ViewAddresses_vue_vue_type_template_id_40942d47_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true& */ "./resources/js/components/address/ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true&");
/* harmony import */ var _ViewAddresses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ViewAddresses.vue?vue&type=script&lang=js& */ "./resources/js/components/address/ViewAddresses.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ViewAddresses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ViewAddresses_vue_vue_type_template_id_40942d47_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ViewAddresses_vue_vue_type_template_id_40942d47_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "40942d47",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/address/ViewAddresses.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/send/SendEmail.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/send/SendEmail.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SendEmail_vue_vue_type_template_id_11e04b98_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SendEmail.vue?vue&type=template&id=11e04b98&scoped=true& */ "./resources/js/components/send/SendEmail.vue?vue&type=template&id=11e04b98&scoped=true&");
/* harmony import */ var _SendEmail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SendEmail.vue?vue&type=script&lang=js& */ "./resources/js/components/send/SendEmail.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SendEmail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SendEmail_vue_vue_type_template_id_11e04b98_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _SendEmail_vue_vue_type_template_id_11e04b98_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "11e04b98",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/send/SendEmail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/users/EditUser.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/users/EditUser.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _EditUser_vue_vue_type_template_id_bfca2b72_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditUser.vue?vue&type=template&id=bfca2b72&scoped=true& */ "./resources/js/components/users/EditUser.vue?vue&type=template&id=bfca2b72&scoped=true&");
/* harmony import */ var _EditUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditUser.vue?vue&type=script&lang=js& */ "./resources/js/components/users/EditUser.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EditUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EditUser_vue_vue_type_template_id_bfca2b72_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditUser_vue_vue_type_template_id_bfca2b72_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "bfca2b72",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/users/EditUser.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/users/ViewUsers.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/users/ViewUsers.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ViewUsers_vue_vue_type_template_id_25399cfe_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true& */ "./resources/js/components/users/ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true&");
/* harmony import */ var _ViewUsers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ViewUsers.vue?vue&type=script&lang=js& */ "./resources/js/components/users/ViewUsers.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ViewUsers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ViewUsers_vue_vue_type_template_id_25399cfe_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ViewUsers_vue_vue_type_template_id_25399cfe_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "25399cfe",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/users/ViewUsers.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/address/AddAddress.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/address/AddAddress.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddAddress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddAddress.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/AddAddress.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddAddress_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/address/ViewAddresses.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/address/ViewAddresses.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewAddresses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ViewAddresses.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/ViewAddresses.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewAddresses_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/send/SendEmail.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/send/SendEmail.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SendEmail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SendEmail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/send/SendEmail.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SendEmail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/users/EditUser.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/users/EditUser.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditUser.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/EditUser.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/users/ViewUsers.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/users/ViewUsers.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewUsers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ViewUsers.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/ViewUsers.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewUsers_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/address/AddAddress.vue?vue&type=template&id=eb90888e&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/address/AddAddress.vue?vue&type=template&id=eb90888e&scoped=true& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddAddress_vue_vue_type_template_id_eb90888e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddAddress_vue_vue_type_template_id_eb90888e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddAddress_vue_vue_type_template_id_eb90888e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddAddress.vue?vue&type=template&id=eb90888e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/AddAddress.vue?vue&type=template&id=eb90888e&scoped=true&");


/***/ }),

/***/ "./resources/js/components/address/ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/address/ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewAddresses_vue_vue_type_template_id_40942d47_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewAddresses_vue_vue_type_template_id_40942d47_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewAddresses_vue_vue_type_template_id_40942d47_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true&");


/***/ }),

/***/ "./resources/js/components/send/SendEmail.vue?vue&type=template&id=11e04b98&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/send/SendEmail.vue?vue&type=template&id=11e04b98&scoped=true& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SendEmail_vue_vue_type_template_id_11e04b98_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SendEmail_vue_vue_type_template_id_11e04b98_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SendEmail_vue_vue_type_template_id_11e04b98_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SendEmail.vue?vue&type=template&id=11e04b98&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/send/SendEmail.vue?vue&type=template&id=11e04b98&scoped=true&");


/***/ }),

/***/ "./resources/js/components/users/EditUser.vue?vue&type=template&id=bfca2b72&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/users/EditUser.vue?vue&type=template&id=bfca2b72&scoped=true& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditUser_vue_vue_type_template_id_bfca2b72_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditUser_vue_vue_type_template_id_bfca2b72_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditUser_vue_vue_type_template_id_bfca2b72_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditUser.vue?vue&type=template&id=bfca2b72&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/EditUser.vue?vue&type=template&id=bfca2b72&scoped=true&");


/***/ }),

/***/ "./resources/js/components/users/ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/users/ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewUsers_vue_vue_type_template_id_25399cfe_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewUsers_vue_vue_type_template_id_25399cfe_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewUsers_vue_vue_type_template_id_25399cfe_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/AddAddress.vue?vue&type=template&id=eb90888e&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/AddAddress.vue?vue&type=template&id=eb90888e&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("p-api-form", {
    attrs: {
      schema: _vm.form,
      "button-text": "Add Address",
      busy: _vm.$isLoading("email-address-add"),
      "busy-text": "Adding Address",
    },
    on: { submit: _vm.addEmail },
    model: {
      value: _vm.emailForm,
      callback: function ($$v) {
        _vm.emailForm = $$v
      },
      expression: "emailForm",
    },
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/address/ViewAddresses.vue?vue&type=template&id=40942d47&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "flex justify-end gap-2 self-end mb-2" }, [
        _c("span", [_vm._v("Actions: ")]),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "text-primary hover:text-primary-dark",
            attrs: { href: "#" },
            on: {
              click: function ($event) {
                return _vm.$ui.modal.show("add-email")
              },
              keydown: [
                function ($event) {
                  if (
                    !$event.type.indexOf("key") &&
                    _vm._k($event.keyCode, "space", 32, $event.key, [
                      " ",
                      "Spacebar",
                    ])
                  ) {
                    return null
                  }
                  $event.preventDefault()
                  return _vm.$ui.modal.show("add-email")
                },
                function ($event) {
                  if (
                    !$event.type.indexOf("key") &&
                    _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                  ) {
                    return null
                  }
                  $event.preventDefault()
                  return _vm.$ui.modal.show("add-email")
                },
              ],
            },
          },
          [
            _c(
              "svg",
              {
                directives: [
                  {
                    name: "tippy",
                    rawName: "v-tippy",
                    value: {
                      arrow: true,
                      animation: "fade",
                      placement: "top-start",
                      arrow: true,
                      interactive: true,
                    },
                    expression:
                      "{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}",
                  },
                ],
                staticClass: "h-6 w-6",
                attrs: {
                  xmlns: "http://www.w3.org/2000/svg",
                  fill: "none",
                  viewBox: "0 0 24 24",
                  stroke: "currentColor",
                  content: "Add Email Address",
                },
              },
              [
                _c("path", {
                  attrs: {
                    "stroke-linecap": "round",
                    "stroke-linejoin": "round",
                    "stroke-width": "2",
                    d: "M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z",
                  },
                }),
              ]
            ),
            _vm._v(" "),
            _c("span", { staticClass: "sr-only" }, [
              _vm._v("Add Email Address"),
            ]),
          ]
        ),
      ]),
      _vm._v(" "),
      _c("p-table", {
        attrs: {
          columns: _vm.emailTableFields,
          items: _vm.emailAddresses,
          actions: true,
          deletable: true,
        },
        on: { delete: _vm.deleteAddress },
        scopedSlots: _vm._u([
          {
            key: "actions",
            fn: function (ref) {
              var row = ref.row
              return [
                row.status === "Waiting for Verification"
                  ? _c(
                      "a",
                      {
                        staticClass: "text-primary hover:text-primary-dark",
                        attrs: { href: "#" },
                        on: {
                          click: function ($event) {
                            return _vm.verifyEmail(row)
                          },
                          keydown: [
                            function ($event) {
                              if (
                                !$event.type.indexOf("key") &&
                                _vm._k(
                                  $event.keyCode,
                                  "space",
                                  32,
                                  $event.key,
                                  [" ", "Spacebar"]
                                )
                              ) {
                                return null
                              }
                              $event.preventDefault()
                              return _vm.verifyEmail(row)
                            },
                            function ($event) {
                              if (
                                !$event.type.indexOf("key") &&
                                _vm._k(
                                  $event.keyCode,
                                  "enter",
                                  13,
                                  $event.key,
                                  "Enter"
                                )
                              ) {
                                return null
                              }
                              $event.preventDefault()
                              return _vm.verifyEmail(row)
                            },
                          ],
                        },
                      },
                      [
                        _c(
                          "svg",
                          {
                            directives: [
                              {
                                name: "tippy",
                                rawName: "v-tippy",
                                value: {
                                  arrow: true,
                                  animation: "fade",
                                  placement: "top-start",
                                  arrow: true,
                                  interactive: true,
                                },
                                expression:
                                  "{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}",
                              },
                            ],
                            staticClass: "h-6 w-6",
                            attrs: {
                              xmlns: "http://www.w3.org/2000/svg",
                              fill: "none",
                              viewBox: "0 0 24 24",
                              stroke: "currentColor",
                              content: "Send email verification link",
                            },
                          },
                          [
                            _c("path", {
                              attrs: {
                                "stroke-linecap": "round",
                                "stroke-linejoin": "round",
                                "stroke-width": "2",
                                d: "M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15",
                              },
                            }),
                          ]
                        ),
                        _vm._v(" "),
                        _c("span", { staticClass: "sr-only" }, [
                          _vm._v("Send email verification link"),
                        ]),
                      ]
                    )
                  : _vm._e(),
              ]
            },
          },
        ]),
      }),
      _vm._v(" "),
      _c("p-table", {
        attrs: {
          busy: _vm.$isLoading("get-domains"),
          columns: _vm.domainFields,
          items: _vm.domains,
          viewable: true,
        },
        on: { view: _vm.viewDomain },
      }),
      _vm._v(" "),
      _c(
        "p-modal",
        { attrs: { id: "add-email", title: "Add email address" } },
        [_c("add-address", { on: { added: _vm.addEmail } })],
        1
      ),
      _vm._v(" "),
      _c(
        "p-modal",
        {
          attrs: { id: "view-cname", title: "View DNS Records" },
          on: {
            hide: function ($event) {
              _vm.viewingDomain = null
            },
          },
        },
        [
          _vm._v(
            "\n        The following CNAME records should be created for the domain " +
              _vm._s(_vm.viewingDomain ? _vm.viewingDomain.domain : "N/A") +
              "\n        "
          ),
          _vm.viewingDomain
            ? _c("p-table", {
                attrs: {
                  columns: _vm.viewingDomainFields,
                  items: _vm.getDnsDetails(_vm.viewingDomain.dns_records),
                },
              })
            : _vm._e(),
        ],
        1
      ),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/send/SendEmail.vue?vue&type=template&id=11e04b98&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/send/SendEmail.vue?vue&type=template&id=11e04b98&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "p-form-padding",
    [
      _c("p-api-form", {
        attrs: {
          schema: _vm.form,
          "button-text": "Send",
          busy: _vm.$isLoading("sending-email"),
          "busy-text": "Sending",
        },
        on: { submit: _vm.send },
      }),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/EditUser.vue?vue&type=template&id=bfca2b72&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/EditUser.vue?vue&type=template&id=bfca2b72&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("p-api-form", {
    attrs: {
      schema: _vm.form,
      "button-text": "Grant Permissions",
      busy: _vm.$isLoading("user-add"),
      "busy-text": "Changing user permissions",
    },
    on: { submit: _vm.addUser },
    model: {
      value: _vm.userForm,
      callback: function ($$v) {
        _vm.userForm = $$v
      },
      expression: "userForm",
    },
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/users/ViewUsers.vue?vue&type=template&id=25399cfe&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("div", { staticClass: "flex justify-end gap-2 self-end mb-2" }, [
        _c("span", [_vm._v("Actions: ")]),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "text-primary hover:text-primary-dark",
            attrs: { href: "#" },
            on: {
              click: function ($event) {
                return _vm.$ui.modal.show("edit-user")
              },
              keydown: [
                function ($event) {
                  if (
                    !$event.type.indexOf("key") &&
                    _vm._k($event.keyCode, "space", 32, $event.key, [
                      " ",
                      "Spacebar",
                    ])
                  ) {
                    return null
                  }
                  $event.preventDefault()
                  return _vm.$ui.modal.show("edit-user")
                },
                function ($event) {
                  if (
                    !$event.type.indexOf("key") &&
                    _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                  ) {
                    return null
                  }
                  $event.preventDefault()
                  return _vm.$ui.modal.show("edit-user")
                },
              ],
            },
          },
          [
            _c(
              "svg",
              {
                directives: [
                  {
                    name: "tippy",
                    rawName: "v-tippy",
                    value: {
                      arrow: true,
                      animation: "fade",
                      placement: "top-start",
                      arrow: true,
                      interactive: true,
                    },
                    expression:
                      "{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}",
                  },
                ],
                staticClass: "h-6 w-6",
                attrs: {
                  xmlns: "http://www.w3.org/2000/svg",
                  fill: "none",
                  viewBox: "0 0 24 24",
                  stroke: "currentColor",
                  content: "Add User",
                },
              },
              [
                _c("path", {
                  attrs: {
                    "stroke-linecap": "round",
                    "stroke-linejoin": "round",
                    "stroke-width": "2",
                    d: "M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z",
                  },
                }),
              ]
            ),
            _vm._v(" "),
            _c("span", { staticClass: "sr-only" }, [_vm._v("Add User")]),
          ]
        ),
      ]),
      _vm._v(" "),
      _c("p-table", {
        attrs: {
          columns: _vm.userTableFields,
          items: _vm.userItems,
          editable: true,
        },
        on: { edit: _vm.editUser },
      }),
      _vm._v(" "),
      _c(
        "p-modal",
        { attrs: { id: "edit-user", title: "Edit email access" } },
        [
          _c("edit-user", {
            attrs: {
              user: _vm.editingUser,
              "available-emails": _vm.availableEmails,
            },
            on: { added: _vm.addUser },
          }),
        ],
        1
      ),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "@bristol-su/frontend-toolkit":
/*!**************************!*\
  !*** external "Toolkit" ***!
  \**************************/
/***/ ((module) => {

module.exports = Toolkit;

/***/ }),

/***/ "vue":
/*!**********************!*\
  !*** external "Vue" ***!
  \**********************/
/***/ ((module) => {

module.exports = Vue;

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
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _bristol_su_frontend_toolkit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @bristol-su/frontend-toolkit */ "@bristol-su/frontend-toolkit");
/* harmony import */ var _bristol_su_frontend_toolkit__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_bristol_su_frontend_toolkit__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_address_ViewAddresses__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/address/ViewAddresses */ "./resources/js/components/address/ViewAddresses.vue");
/* harmony import */ var _components_users_ViewUsers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/users/ViewUsers */ "./resources/js/components/users/ViewUsers.vue");
/* harmony import */ var _components_send_SendEmail__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/send/SendEmail */ "./resources/js/components/send/SendEmail.vue");





vue__WEBPACK_IMPORTED_MODULE_0___default().use((_bristol_su_frontend_toolkit__WEBPACK_IMPORTED_MODULE_1___default()));
var vue = new (vue__WEBPACK_IMPORTED_MODULE_0___default())({
  el: '#portal-mail-root',
  components: {
    ViewAddresses: _components_address_ViewAddresses__WEBPACK_IMPORTED_MODULE_2__["default"],
    ViewUsers: _components_users_ViewUsers__WEBPACK_IMPORTED_MODULE_3__["default"],
    SendEmail: _components_send_SendEmail__WEBPACK_IMPORTED_MODULE_4__["default"]
  }
});
})();

/******/ })()
;