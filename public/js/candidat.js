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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/candidat.js":
/*!**********************************!*\
  !*** ./resources/js/candidat.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  'use strict';

  var location = '#informations';
  $(document).on('click', '.mail-sidebar-item', function () {
    setTimeout(function () {
      updatePages();
    }, 10);
  });

  function updatePages() {
    // We will get the current location
    var tloc = window.location.hash;
    if (tloc.length != 0) location = tloc;
    updateMenu();
    $('.content').each(function (i) {
      $(this).removeClass('active');
    });
    $(location).addClass('active');
  }

  function updateMenu() {
    $('.mail-sidebar-item').each(function (i) {
      if ($(this).attr('href') != location) {
        console.log('NOT THE SAME', $(this).attr('href'), location);
        $(this).removeClass('active');
      } else {
        console.log('SAME', $(this).attr('href'), location);
        $(this).addClass('active');
      }
    });
  }

  function fake_id() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 9; i++) {
      text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    return text;
  }

  updatePages();
  var htmlAge = "\n        <div class=\"form-group col-md-3\">\n            <div class=\"age_field\">\n                <label>\xC2ge des enfants</label>\n                <input type=\"number\" name=\"age_d_enfants[]\" value=\"\" class=\"form-control\" placeholder=\"Age\" />\n            </div>\n        </div>\n    ";
  var ages = [];
  $('.age_field').each(function () {
    ages.push($(this).find('input').val());
  });
  console.log(ages);
  $('input[name=nombre_d_enfants]').change(function () {
    var number = $(this).val();
    $('.rep_age').html('');

    for (var i = 1; i <= number; i++) {
      $('.rep_age').append(htmlAge);

      if (ages[i - 1] !== undefined) {
        $('.age_field:last-child').find('input').val(ages[i - 1]);
      }

      if (i > 5) {
        break;
      }
    }
  });
  $('input[name=nombre_d_enfants]').keyup(function () {
    var number = $(this).val();
    $('.rep_age').html('');

    for (var i = 1; i <= number; i++) {
      $('.rep_age').append(htmlAge);

      if (ages[i - 1] !== undefined) {
        console.log(ages[i - 1]);
        $('.age_field:last-child').find('input').val(ages[i - 1]);
      }

      if (i > 5) {
        break;
      }
    }
  });
})(window.jQuery);

/***/ }),

/***/ 1:
/*!****************************************!*\
  !*** multi ./resources/js/candidat.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\MAMP\htdocs\immigremploi\resources\js\candidat.js */"./resources/js/candidat.js");


/***/ })

/******/ });