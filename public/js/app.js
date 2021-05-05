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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./comments */ "./resources/js/comments.js");

/***/ }),

/***/ "./resources/js/comments.js":
/*!**********************************!*\
  !*** ./resources/js/comments.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  'use strict';

  var scope;
  $(document).on('click', '#note_trigger', openChat);
  $(document).on('click', '#close-comments', closeChat);
  $(document).on('click', '#note-comment-form .btn', submitComment);

  function init_comments() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      }
    });
  }

  function submitComment(e) {
    e.preventDefault();
    scope = '#' + $(this).data('scope') + " ";
    var url = $(scope + '#note-comment-form').data('url');
    var id = $(scope + '#note_model_id').val();
    var type = $(scope + '#note_model_type').val();
    var cat = $(scope + '#note_category').val();
    var message = $(scope + '#note_message').val();
    $(scope + 'textarea.note').prop('disabled', true);
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        model_id: id,
        model_type: type,
        category: cat,
        message: message
      },
      success: function success(data) {
        $(scope + ".first-comment").remove();
        $(scope + '#note-messages').append(data);
        $(scope + 'textarea.note').html('');
        $(scope + 'textarea.note').val('');
        $(scope + 'textarea.note').prop('disabled', false);
        scrollBottom();
      },
      error: function error(jqXHR, status, _error) {
        console.log(jqXHR, status, _error);
        alert(_error);
        $(scope + 'textarea.note').prop('disabled', false);
      }
    });
  }

  function scrollBottom() {
    var objDiv = document.getElementById("note-messages");
    objDiv.scrollTop = objDiv.scrollHeight;
  }

  function openChat(e) {
    scope = '#' + $(this).data('scope') + " ";
    console.log(scope);
    scrollBottom();
    $(scope + '#note_trigger').addClass('active');
    $(scope + '#note_window').addClass('active');
  }

  function closeChat() {
    scope = '#' + $(this).data('scope') + " ";
    $(scope + '#note_trigger').removeClass('active');
    $(scope + '#note_window').removeClass('active');
  }

  init_comments();
})(window.jQuery);

/***/ }),

/***/ "./resources/sass/candidat.scss":
/*!**************************************!*\
  !*** ./resources/sass/candidat.scss ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/chat.scss":
/*!**********************************!*\
  !*** ./resources/sass/chat.scss ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/comments.scss":
/*!**************************************!*\
  !*** ./resources/sass/comments.scss ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/general.scss":
/*!*************************************!*\
  !*** ./resources/sass/general.scss ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/projet.scss":
/*!************************************!*\
  !*** ./resources/sass/projet.scss ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/candidat.scss ./resources/sass/projet.scss ./resources/sass/general.scss ./resources/sass/chat.scss ./resources/sass/comments.scss ./resources/css/app.css ***!
  \***************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\js\app.js */"./resources/js/app.js");
__webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\sass\candidat.scss */"./resources/sass/candidat.scss");
__webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\sass\projet.scss */"./resources/sass/projet.scss");
__webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\sass\general.scss */"./resources/sass/general.scss");
__webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\sass\chat.scss */"./resources/sass/chat.scss");
__webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\sass\comments.scss */"./resources/sass/comments.scss");
module.exports = __webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\css\app.css */"./resources/css/app.css");


/***/ })

/******/ });