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

__webpack_require__(/*! ./projects */ "./resources/js/projects.js");

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

  function allScrollBottom() {
    $('.comment-section').each(function () {
      var height = $(this).find('#note-messages')[0].scrollHeight;
      $(this).find('#note-messages').animate({
        scrollTop: height
      });
    });
  }

  allScrollBottom();

  function scrollToBottomComment(elem) {
    var element = elem.parents('.comment-section').find('#note-messages');
    var height = elem.parents('.comment-section').find('#note-messages')[0].scrollHeight;
    element.animate({
      scrollTop: height
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
    var elem = $(this);
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
        init_popover();
        scrollToBottomComment(elem);
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
      $(this).find('.show-comment-text').text('Voir tous les commentaires');
      $(this).removeClass('active-show-all');
      $(this).parents('.comment-section').find('.demande_old_messages_shadow').show();
      $(this).parents('.comment-section').find('#note-messages').css({
        'height': '300px',
        'overflow-y': 'scroll'
      });
      allScrollBottom();
    } else {
      var _demande_id = $(this).data('demande-id');

      $(this).find('.show-comment-text').text('Afficher les derniers commentaires');
      $(this).addClass('active-show-all');
      $(this).parents('.comment-section').find('.demande_old_messages_shadow').hide();
      $(this).parents('.comment-section').find('#note-messages').css({
        'height': 'auto',
        'overflow-y': 'inherit'
      });
      allScrollBottom();
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
        elem.parents('.comment-section').find('#note-messages').html(result.html);
        elem.find('.comment-counts').text(result.count);
        callback(elem);
      }
    });
  }

  function init_popover() {
    $('span[data-toggle="popover"]').popover({
      html: true
    });
    $('.message').on('mouseover', function (e) {
      $('span[data-toggle="popover"]').not(this).popover('hide');
    });
  }

  init_popover();
  init_comments();
})(window.jQuery);

/***/ }),

/***/ "./resources/js/projects.js":
/*!**********************************!*\
  !*** ./resources/js/projects.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('body').on('click', '.edit-immigration .remove_assignee', function () {
    if (confirm('Êtes-vous certain de vouloir retirer cet utilisateur?')) {
      var elem = $(this);
      var assigneeId = $(this).data('id');
      var demand_id = $(this).data('demand-id');
      $.ajax({
        type: 'POST',
        url: route + 'remove/assignee',
        data: {
          assignee_id: assigneeId,
          demand_id: demand_id
        },
        success: function success(result) {
          console.log(result);

          if (result.status == true) {
            $(elem).parent('.avatar').remove();
          }
        }
      });
    }
  });
  $('.select2').select2();
  $('.complete_demande').click(function (e) {
    var url = $(this).attr('href');
    var elem = $(this);
    e.preventDefault();
    $(this).hide();
    $('.loader').show();
    $.ajax({
      type: 'GET',
      url: $(this).attr('href'),
      data: {},
      success: function success(result) {
        $('.complete_demande').show();
        $('.loader').hide();

        if (result.status == 0) {
          elem.find('.avatar-title').addClass('bg-transparent border mt-1').removeClass('bg-success');
          elem.find('.avatar-title i').addClass('hide-demande-tick-icon');
        } else {
          elem.find('.avatar-title').addClass('bg-success').removeClass('bg-transparent border mt-1');
          elem.find('.avatar-title i').removeClass('hide-demande-tick-icon');
        }

        console.log(result);
      }
    });
  });
});

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
  window.todoStrip = null;
  $('body').on('click', '.todo-strip label', function () {
    var elem = $(this).parents('.todo-strip');

    if (elem.hasClass('in-active')) {
      $(this).parents('.todo-strip').find('.create-todo').click();
    } else {
      $(this).parents('.todo-strip').find('.add-todo').click();
    }
  });
  $('body').on('click', '.todo-strip .add-todo, .create-demande-todo', function () {
    var project_id = $(this).data('project-id');
    var demande_id = $(this).data('demande-id');
    $('.f-loader').show();
    window.click_demande_child = $(this);
    window.todoStrip = null;
    showTodoList(project_id, demande_id);
  });

  function showTodoList(project_id, demande_id) {
    var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
    $.ajax({
      type: 'GET',
      url: route + 'todo/list/' + project_id + '/' + demande_id,
      success: function success(result) {
        $('.f-loader').hide();
        $('body').append(result);
        $('#todo-list-modal').modal({
          'show': true,
          backdrop: 'static',
          keyboard: false
        }); // $('.select2').select2();

        $('.sortable-todo-list').sortable({
          handle: '.sort-handle',
          connectWith: ".connectedSortable",
          containment: ".todo-list-group",
          dropOnEmpty: true,
          stop: function stop(event, ui) {
            var sortedArray = {};
            var oldElem = $(event.target);
            var newElem = $(ui.item[0]);
            var newGroupID = newElem.parents('.group-section').data('group-id');
            var oldGroupId = oldElem.parents('.group-section').data('group-id');

            if (newGroupID != oldGroupId) {
              newElem.parents('.group-section').find('.todo-list-section .option-box-grid').each(function (i, el) {
                sortedArray[$(this).find('input').data('todo-id')] = i + 1;
              });
            } else {
              oldElem.parents('.group-section').find('.todo-list-section .option-box-grid').each(function (i, el) {
                sortedArray[$(this).find('input').data('todo-id')] = i + 1;
              });
            }

            $.ajax({
              type: 'POST',
              url: route + 'todo/update/orders',
              data: {
                todos: sortedArray,
                oldGroupId: oldGroupId,
                newGroupID: newGroupID
              },
              success: function success(result) {}
            });
          }
        });

        if (callback != null) {
          callback(result);
        }
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
  $('body').on('keyup', '.todo-text', function (e) {
    var elem = $(this).parents('.group-section');
    var textValue = $(this).val().trim();

    if (textValue != '') {
      elem.find('.save-todo-message').show();
    } else {
      elem.find('.save-todo-message').hide();
    }

    if (e.keyCode == 13) {
      elem.find('.save-todo-message').trigger('click');
    }
  });
  $('body').on('click', '.add-todo-list', function () {
    $('.save-todo-message').trigger('click');
  });
  $('body').on('click', '.save-todo-message', function () {
    var groupElem = $(this).parents('.group-section');
    var elem = $(this);
    var todoText = $(this).parents('.add-todo-message-section').find('.todo-text').val();

    if (todoText.trim() != '') {
      elem.find('.todo-text').prop('disabled', true);
      var projetId = $(this).data('project-id');
      var demandeId = $(this).data('demande-id');
      var groupId = $(this).data('group-id');
      $.ajax({
        type: 'POST',
        url: route + 'todo/save',
        data: {
          projet_id: projetId,
          demande_id: demandeId,
          todo: todoText,
          group_id: groupId
        },
        success: function success(result) {
          //elem.prop('disabled', false).removeClass('disabled').hide();
          groupElem.find('.todo-text').val('').prop('disabled', false);
          groupElem.find('.todo-list-section').append(result.html);
          groupElem.find('.save-todo-message').hide();
          $('.delete-template-content').show();
          $('.total-todos').text($('.single-todo-div').length);

          if (window.click_demande_child.hasClass('demande-todo')) {
            window.click_demande_child.removeClass('text-gray-400').removeClass('new-demande-from-template').addClass('create-demande-todo');
          }

          var stripTag = window.click_demande_child.parents('.todo-strip');
          stripTag.removeClass('in-active');
          stripTag.find('.fas').removeClass('create-todo').addClass('add-todo');
          stripTag.find('.fas').removeClass('fa-plus').addClass('fa-check');
          stripTag.find('label').html('<span class="demande-completed-todos">0</span> complété sur <span class="demande-total-todos">0</span>');
          stripTag.find('.demande-total-todos').text($('.single-todo-div').length);
          stripTag.find('.demande-completed-todos').text($('.todo-list-section').find('.task-completed').length);
          groupElem.find('.todo-text').focus();
        }
      });
    }
  });
  $('body').on('click', '.todo-checkbox', function () {
    var todoId = $(this).data('todo-id');
    var status = 0;
    var numberOfTodos = parseInt($('.total-todos').text());
    var elem = $(this).parent('.option-box-grid');

    if ($(this).is(':checked')) {
      elem.find('p').addClass('task-completed');
      var numberOfCompleted = parseInt($('.number-of-completed-todos').text());
      numberOfCompleted += 1;
      $('.number-of-completed-todos').text(numberOfCompleted);
      $('.todo-progress').css('width', numberOfCompleted * 100 / numberOfTodos + '%');
      window.click_demande_child.parents('.todo-strip').find('.demande-completed-todos').text(numberOfCompleted);
      status = 1;

      if (numberOfTodos == numberOfCompleted) {
        window.click_demande_child.parents('.todo-strip').find('.add-todo').removeClass('bg-white').addClass('bg-aqua');
      }
    } else {
      elem.find('p').removeClass('task-completed');

      var _numberOfCompleted = parseInt($('.number-of-completed-todos').text());

      _numberOfCompleted -= 1;
      $('.number-of-completed-todos').text(_numberOfCompleted);
      $('.todo-progress').css('width', _numberOfCompleted * 100 / numberOfTodos + '%');
      window.click_demande_child.parents('.todo-strip').find('.demande-completed-todos').text(_numberOfCompleted);
      status = 0;
      window.click_demande_child.parents('.todo-strip').find('.add-todo').removeClass('bg-aqua').addClass('bg-white');
    }

    $.ajax({
      type: 'GET',
      url: route + 'todo/update/status',
      data: {
        status: status,
        todo_id: todoId
      },
      success: function success(result) {
        if (result.todo.completed_at != null) {
          elem.find('.completed-at-todo').html('"Terminé le: ' + result.todo.completed_at);
        } else {
          elem.find('.completed-at-todo').html('');
        }

        console.log(result);
      }
    });
  });
  $('body').on('click', '.todo-strip .create-todo, .new-demande-from-template', function () {
    var project_id = $(this).data('project-id');
    var demande_id = $(this).data('demande-id');
    window.click_demande_child = $(this);
    window.todoStrip = $(this).parents('.todo-strip');
    $('.f-loader').show();
    $.ajax({
      type: 'GET',
      url: route + 'todo/templates/list',
      data: {
        projet_id: project_id,
        demande_id: demande_id
      },
      success: function success(result) {
        $('.f-loader').hide();
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
            stripTag.find('.fas').removeClass('fa-plus').addClass('fa-check').removeClass('create-todo').addClass('add-todo');
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
  $('body').on('blur', '.option-box-grid p', function () {
    removeTodoMessage($(this));
  }); // $('body').on('keypress', '.option-box-grid p', function (e) {
  //     if (e.keyCode == 13) {
  //         removeTodoMessage($(this));
  //     }
  // });

  function removeTodoMessage(elem) {
    var updatedText = elem.text().trim();
    var todoId = elem.data('todo-id');
    elem.attr('contenteditable', false);
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

  $('body').on('hidden.bs.modal', '#create-todo-template-modal', function () {
    $('#create-todo-template-modal').remove();
  });
  $('body').on("hidden.bs.modal", '#todo-list-modal', function () {
    $("#todo-list-modal").remove();
  });
  $('body').on("hidden.bs.modal", '#todo-template-modal', function () {
    $("#todo-template-modal").remove();
  });
  $('body').on('click', '.create-group', function () {
    var groupName = $('.group_name_text').val();
    var project_id = $(this).data('project-id');
    var demande_id = $(this).data('demande-id');

    if (groupName.trim() != '') {
      $.ajax({
        type: 'POST',
        url: route + 'todo/group/create',
        data: {
          projet_id: project_id,
          demande_id: demande_id,
          group_name: groupName
        },
        success: function success(result) {
          $('.delete-template-content').show();
          var elem = window.click_demande_child;
          $('.todo-list-group').append(result);
          $('.group_name_text').val('');
          var stripTag = window.click_demande_child.parents('.todo-strip');
          stripTag.removeClass('in-active');
          stripTag.find('.fas').removeClass('create-todo').addClass('add-todo');
          stripTag.find('.fas').removeClass('fa-plus').addClass('fa-check');
          stripTag.find('label').html('<span class="demande-completed-todos">0</span> complété sur <span class="demande-total-todos">0</span>');
        }
      });
    }
  });
  $('body').on('click', '.todo-list-section .add-new-assignee', function () {
    $(this).parents('.assignee').find('.add-new-assignee-wrapper').slideToggle();
  });
  $('body').on('change', '.assign_demande', function () {
    var selectedAssignee = $(this).val();
    var todoId = $(this).data('todo');
    var elem = $(this);

    if (selectedAssignee.trim() != '') {
      $.ajax({
        type: 'POST',
        url: route + 'todo/assign/user',
        data: {
          user: selectedAssignee,
          todo_id: todoId
        },
        success: function success(result) {
          if (result.is_exists == false) {
            var html = "\n                        <div class=\"avatar avatar-xs ml-1 mb-1\">\n                           <span data-id=\"3\" data-demand-id=\"8\" class=\"remove_assignee avatar-title rounded-circle bg-dark\">\n                            " + result.initials + " <i class=\"fas fa-times remove_assignee_icon small-icon\" data-id=\"" + result.user.id + "\"></i>\n                           </span>\n                        </div>\n                    ";
            elem.parents('.assignee').find('.assigned-user-section').append(html);
            elem.parents('.add-new-assignee-wrapper').slideUp();
            elem.val('');
          } else {
            elem.parents('.add-new-assignee-wrapper').slideUp();
            elem.val('');
          }
        }
      });
    }
  });
  $('body').on('click', '.todo-list-sec .remove_assignee_icon', function () {
    var elem = $(this);
    var assignUserId = $(this).data('id');

    if (confirm('Are you sure to remove?')) {
      $.ajax({
        type: 'POST',
        url: route + 'todo/remove/assignee',
        data: {
          id: assignUserId
        },
        success: function success(result) {
          elem.parents('.avatar').remove();
        }
      });
    }
  });

  function setCaret() {
    var el = document.getElementById("content-editable");
    var range = document.createRange();
    var sel = window.getSelection();
    range.setStart(el.childNodes[0], el.childNodes[0].length);
    range.collapse(true);
    sel.removeAllRanges();
    sel.addRange(range);
  }

  $('body').on('click', '.group-section .edit-group-title', function () {
    var elem = $(this).parents('.group-section').find('.todo-group-title');
    elem.attr('id', 'content-editable');
    window.group_text_edited = elem.text();
    elem.attr('contenteditable', true).focus();
    setCaret();
  });
  $('body').on('dblclick', '.todo-group-title', function () {
    window.group_text_edited = $(this).text();
    $(this).attr('contenteditable', true).focus();
  });
  $('body').on('blur', '.todo-group-title', function () {
    var elem = $(this);
    $(this).attr('contenteditable', false);
    var groupName = $(this).text();
    var groupId = $(this).data('group-id');
    $.ajax({
      type: 'POST',
      url: route + 'todo/group/update',
      data: {
        group_name: groupName,
        group_id: groupId
      },
      success: function success(result) {
        if (result.status == 'deleted') {
          elem.parents('.group-section').remove();
        } else if (result.status == 'error') {
          alert('Group is not empty!');
          elem.text(window.group_text_edited);
        }
      }
    });
  });
  $('body').on('click', '.view-template', function () {
    var templateId = $(this).data('id');
    $.ajax({
      type: 'GET',
      url: route + 'todo/template/view/' + templateId,
      success: function success(result) {
        $('body').append(result);
        $('#todo-list-modal').modal('show');
      }
    });
  });
  $('body').on('click', '.delete-template-content', function () {
    if (confirm('Are you sure to delete all?')) {
      var demande_id = $(this).data('demande-id');
      var projet_id = $(this).data('projet-id');
      $.ajax({
        type: 'POST',
        url: route + 'todo/template/content/delete',
        data: {
          demande_id: demande_id,
          projet_id: projet_id
        },
        success: function success(result) {
          if (window.todoStrip != null && window.todoStrip != undefined) {
            window.todoStrip.find('.demande-completed-todos').html(result.completed);
            window.todoStrip.find('.demande-total-todos').html(result.total);
            var stripTag = window.todoStrip;
            stripTag.addClass('in-active');
            stripTag.find('.fas').removeClass('add-todo').addClass('create-todo');
            stripTag.find('.fas').removeClass('fa-check').addClass('fa-plus');
            stripTag.find('label').html('liste de contrôle');
          } else {
            window.click_demande_child.parents('.todo-strip').find('.demande-completed-todos').html(result.completed);
            window.click_demande_child.parents('.todo-strip').find('.demande-total-todos').html(result.total);

            var _stripTag = window.click_demande_child.parents('.todo-strip');

            _stripTag.addClass('in-active');

            _stripTag.find('.fas').removeClass('add-todo').addClass('create-todo');

            _stripTag.find('.fas').removeClass('fa-check').addClass('fa-plus');

            _stripTag.find('label').html('liste de contrôle');
          }

          $('#todo-list-modal').modal('hide');
        }
      });
    }
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