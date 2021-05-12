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

__webpack_require__(/*! ./todo */ "./resources/js/todo.js");

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

  try {
    scrollToBottomComment();
  } catch (e) {}

  $(document).on('click', '#note_trigger', openChat);
  $(document).on('click', '#close-comments', closeChat);
  $(document).on('click', '#note-comment-form .btn', submitComment); //For Comment Demande

  $(document).on('click', '#demande-comment-form .btn', submitComment);

  function scrollToBottomComment() {
    var elem = $('#demande_notes #note-messages');
    elem.animate({
      scrollTop: elem.height()
    });
  }

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
        $(scope + '#no-comment').hide();
        var commentCounts = $(scope + '.comment-counts').text();
        $(scope + '.comment-counts').text(parseInt(commentCounts) + 1);
        scrollBottom();
        scrollToBottomComment();
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

  $('.see-all-comments').click(function () {
    if ($(this).hasClass('active-show-all')) {
      var demande_id = $(this).data('demande-id');
      getComments(demande_id, $(this), function (elem) {
        elem.find('a').text('Voir tous les commentaires');
        elem.removeClass('active-show-all');
        elem.parents('#demande_notes').find('.demande_old_messages_shadow').show();
        elem.parents('#demande_notes').find('#note-messages').css('height', '300px');
      }, 2);
    } else {
      var _demande_id = $(this).data('demande-id');

      getComments(_demande_id, $(this), function (elem) {
        elem.find('a').text('Afficher les derniers commentaires');
        elem.addClass('active-show-all');
        elem.parents('#demande_notes').find('.demande_old_messages_shadow').hide();
        elem.parents('#demande_notes').find('#note-messages').css('height', 'auto');
      });
    }
  });

  function getComments(demande_id, elem, callback) {
    var limit = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
    $.ajax({
      type: 'POST',
      url: route + 'comments/view/all',
      data: {
        demande_id: demande_id,
        limit: limit
      },
      success: function success(result) {
        elem.parents('#demande_notes').find('#note-messages').html(result);
        callback(elem);
      }
    });
  }

  init_comments();
})(window.jQuery);

/***/ }),

/***/ "./resources/js/todo.js":
/*!******************************!*\
  !*** ./resources/js/todo.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  'use strict';

  function init_todos() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      }
    });
  }

  window.click_demande_child = null;
  $('body').on('click', '.todo-strip .add-todo', function () {
    var project_id = $(this).data('project-id');
    var demande_id = $(this).data('demande-id');
    $('.f-loader').fadeIn(300);
    window.click_demande_child = $(this);
    showTodoList(project_id, demande_id);
  });

  function showTodoList(project_id, demande_id) {
    var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
    $.ajax({
      type: 'GET',
      url: route + 'todo/list/' + project_id + '/' + demande_id,
      success: function success(result) {
        $('.f-loader').fadeOut(300);
        $('body').append(result);
        $('#todo-list-modal').modal({
          'show': true,
          backdrop: 'static',
          keyboard: false
        });
        $('.sortable-todo-list').sortable({
          handle: '.sort-handle',
          stop: function stop(event, ui) {
            var sortedArray = {};
            $('.todo-list-section .option-box-grid').each(function (i, el) {
              sortedArray[$(this).find('input').data('todo-id')] = i + 1;
            });
            $.ajax({
              type: 'POST',
              url: route + 'todo/update/orders',
              data: {
                todos: sortedArray
              },
              success: function success(result) {}
            });
          }
        });
        callback(result);
      },
      error: function error(_error) {}
    });
  } //Create Template Modal


  $('body').on('click', '.create-template', function () {
    var projectId = $(this).data('project-id');
    var demandeId = $(this).data('demande-id');
    $.ajax({
      type: 'GET',
      url: route + 'todo/template/create',
      data: {
        project_id: projectId,
        demande_id: demandeId
      },
      success: function success(result) {
        $('body').append(result);
        $('#todo-list-modal').modal('hide');
        $('#create-todo-template-modal').modal({
          show: true,
          backdrop: 'static',
          keyboard: false
        });
      }
    });
  }); //Save Todo Template

  $('body').on('click', '.save-template', function () {
    var projetId = $(this).data('project-id');
    var demandeId = $(this).data('demande-id');
    var templateName = $('.template-name').val();
    $(this).text('Économie...').prop('disabled', true);
    $('.template-name').prop('disabled', true);
    $.ajax({
      type: 'POST',
      url: route + 'todo/template/save',
      data: {
        project_id: projetId,
        demande_id: demandeId,
        template_name: templateName
      },
      success: function success(result) {
        $('#create-todo-template-modal').modal('hide');
      }
    });
  });
  $('body').on('keyup', '.todo-text', function () {
    var textValue = $(this).val().trim();

    if (textValue != '') {
      $('.save-todo-message').show();
    } else {
      $('.save-todo-message').hide();
    }
  });
  $('body').on('click', '.save-todo-message', function () {
    var elem = $(this);
    elem.prop('disabled', true).addClass('disabled');
    var todoText = $('.todo-text').val();
    $('.todo-text').prop('disabled', true);
    var projetId = $(this).data('project-id');
    var demandeId = $(this).data('demande-id');
    $.ajax({
      type: 'POST',
      url: route + 'todo/save',
      data: {
        projet_id: projetId,
        demande_id: demandeId,
        todo: todoText
      },
      success: function success(result) {
        elem.prop('disabled', false).removeClass('disabled').hide();
        $('.todo-text').val('').prop('disabled', false);
        $('.todo-list-section').append(result.html);
        $('.total-todos').text($('.single-todo-div').length);
        var stripTag = window.click_demande_child.parents('.todo-strip');
        stripTag.removeClass('in-active');
        stripTag.find('.fa').removeClass('fa-plus').addClass('fa-check');
        stripTag.find('label').html('<span class="demande-completed-todos">0</span> complété sur <span class="demande-total-todos">0</span>');
        stripTag.find('.demande-total-todos').text($('.single-todo-div').length);
        stripTag.find('.demande-completed-todos').text($('.todo-list-section').find('.task-completed').length);
      }
    });
  });
  $('body').on('click', '.todo-checkbox', function () {
    var todoId = $(this).data('todo-id');
    var status = 0;
    var numberOfTodos = parseInt($('.total-todos').text());

    if ($(this).is(':checked')) {
      $(this).parent('.option-box-grid').find('p').addClass('task-completed');
      var numberOfCompleted = parseInt($('.number-of-completed-todos').text());
      numberOfCompleted += 1;
      $('.number-of-completed-todos').text(numberOfCompleted);
      $('.todo-progress').css('width', numberOfCompleted * 100 / numberOfTodos + '%');
      window.click_demande_child.parents('.todo-strip').find('.demande-completed-todos').text(numberOfCompleted);
      status = 1;
    } else {
      $(this).parent('.option-box-grid').find('p').removeClass('task-completed');

      var _numberOfCompleted = parseInt($('.number-of-completed-todos').text());

      _numberOfCompleted -= 1;
      $('.number-of-completed-todos').text(_numberOfCompleted);
      $('.todo-progress').css('width', _numberOfCompleted * 100 / numberOfTodos + '%');
      window.click_demande_child.parents('.todo-strip').find('.demande-completed-todos').text(_numberOfCompleted);
      status = 0;
    }

    $.ajax({
      type: 'GET',
      url: route + 'todo/update/status',
      data: {
        status: status,
        todo_id: todoId
      },
      success: function success(result) {
        console.log(result);
      }
    });
  });
  $('body').on('click', '.todo-strip .create-todo', function () {
    var project_id = $(this).data('project-id');
    var demande_id = $(this).data('demande-id');
    window.click_demande_child = $(this);
    $('.f-loader').fadeIn(300);
    $.ajax({
      type: 'GET',
      url: route + 'todo/templates/list',
      data: {
        projet_id: project_id,
        demande_id: demande_id
      },
      success: function success(result) {
        $('.f-loader').fadeOut(300);
        $('body').append(result);
        $('#todo-template-modal').modal({
          show: true,
          backdrop: 'static',
          keyboard: false
        });
      },
      error: function error(_error2) {}
    });
  });
  $('body').on('click', '.create-todo-list', function () {
    var projet_id = $(this).data('projet-id');
    var demande_id = $(this).data('demande-id');
    var template = $('.selected-template').val();
    $(this).text('S\'il vous plaît, attendez..');

    if (template == '0') {
      $(this).text('AJOUTER');
      $('#todo-template-modal').modal('hide');
      showTodoList(projet_id, demande_id);
    } else {
      $.ajax({
        type: 'POST',
        url: route + 'todo/from/template',
        data: {
          projet_id: projet_id,
          demande_id: demande_id,
          template_id: template
        },
        success: function success(result) {
          $(this).text('AJOUTER');
          $.notify({
            message: result.message
          }, {
            type: 'success'
          });
          $('#todo-template-modal').modal('hide');
          showTodoList(projet_id, demande_id, function (result) {
            var stripTag = window.click_demande_child.parents('.todo-strip');
            stripTag.removeClass('in-active');
            stripTag.find('.fa').removeClass('fa-plus').addClass('fa-check');
            stripTag.find('label').html('<span class="demande-completed-todos">0</span> complété sur <span class="demande-total-todos">0</span>');
            stripTag.find('.demande-total-todos').text($('.single-todo-div').length);
          });
        }
      });
    }
  });
  $('body').on('dblclick', '.option-box-grid p', function () {
    $(this).attr('contenteditable', true).focus();
  });
  $('body').on('keypress', '.option-box-grid p', function (e) {
    if (e.keyCode == 13) {
      var elem = $(this);
      var updatedText = $(this).text().trim();
      var todoId = $(this).data('todo-id');
      $(this).attr('contenteditable', false);
      $.ajax({
        type: 'POST',
        url: route + 'todo/update/' + todoId,
        data: {
          todo: updatedText
        },
        success: function success(result) {
          if (result.status == true) {
            $.notify({
              message: result.message
            }, {
              type: 'success'
            });

            if (updatedText == '') {
              elem.parents('.single-todo-div').remove();
              window.click_demande_child.parents('.todo-strip').find('.demande-total-todos').text($('.single-todo-div').length);
              $('.total-todos').text($('.single-todo-div').length);
            }
          }

          elem.attr('contenteditable', false);
        }
      });
    }
  });
  $('body').on('hidden.bs.modal', '#create-todo-template-modal', function () {
    $('#create-todo-template-modal').remove();
  });
  $('body').on("hidden.bs.modal", '#todo-list-modal', function () {
    $("#todo-list-modal").remove();
  });
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