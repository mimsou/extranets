(function ($) {
    'use strict'

    function init_todos() {
        $.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}});
    }

    window.click_demande_child = null;
    $('body').on('click', '.todo-strip .add-todo', function () {
        let project_id = $(this).data('project-id');
        let demande_id = $(this).data('demande-id');
        $('.f-loader').fadeIn(300);
        window.click_demande_child = $(this);
        showTodoList(project_id, demande_id);
    });

    function showTodoList(project_id, demande_id, callback = null) {
        $.ajax({
            type: 'GET',
            url: route + 'todo/list/' + project_id + '/' + demande_id,
            success: function (result) {
                $('.f-loader').fadeOut(300);
                $('body').append(result);
                $('#todo-list-modal').modal({
                    'show': true,
                    backdrop: 'static',
                    keyboard: false
                });
                $('.sortable-todo-list').sortable({
                    handle: '.sort-handle',
                    stop: function (event, ui) {
                        let sortedArray = {};
                        $('.todo-list-section .option-box-grid').each(function (i, el) {
                            sortedArray[$(this).find('input').data('todo-id')] = i + 1;
                        });
                        $.ajax({
                            type: 'POST',
                            url: route + 'todo/update/orders',
                            data: {
                                todos: sortedArray
                            },
                            success: function (result) {
                            }
                        });
                    }
                });
                callback(result)
            },
            error: function (error) {

            }
        });
    }


    //Create Template Modal
    $('body').on('click', '.create-template', function () {
        let projectId = $(this).data('project-id');
        let demandeId = $(this).data('demande-id');
        $.ajax({
            type: 'GET',
            url: route + 'todo/template/create',
            data: {
                project_id: projectId,
                demande_id: demandeId
            },
            success: function (result) {
                $('body').append(result);
                $('#todo-list-modal').modal('hide');
                $('#create-todo-template-modal').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    });

    //Save Todo Template
    $('body').on('click', '.save-template', function () {
        let projetId = $(this).data('project-id');
        let demandeId = $(this).data('demande-id');
        let templateName = $('.template-name').val();
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
            success: function (result) {
                $('#create-todo-template-modal').modal('hide');
            }
        });
    });

    $('body').on('keyup', '.todo-text', function (e) {
        let textValue = $(this).val().trim();
        if (textValue != '') {
            $('.save-todo-message').show();
        } else {
            $('.save-todo-message').hide();
        }
        if (e.keyCode == 13) {
            $('.save-todo-message').trigger('click');
        }
    });

    $('body').on('click', '.save-todo-message', function () {
        let elem = $(this);
        elem.prop('disabled', true).addClass('disabled');
        let todoText = $('.todo-text').val();
        $('.todo-text').prop('disabled', true);
        let projetId = $(this).data('project-id');
        let demandeId = $(this).data('demande-id');
        $.ajax({
            type: 'POST',
            url: route + 'todo/save',
            data: {
                projet_id: projetId,
                demande_id: demandeId,
                todo: todoText
            },
            success: function (result) {
                elem.prop('disabled', false).removeClass('disabled').hide();
                $('.todo-text').val('').prop('disabled', false);
                $('.todo-list-section').append(result.html);
                $('.total-todos').text($('.single-todo-div').length);
                let stripTag = window.click_demande_child.parents('.todo-strip');
                stripTag.removeClass('in-active');
                stripTag.find('.fa').removeClass('fa-plus').addClass('fa-check');
                stripTag.find('label').html('<span class="demande-completed-todos">0</span> complété sur <span class="demande-total-todos">0</span>');
                stripTag.find('.demande-total-todos').text($('.single-todo-div').length);
                stripTag.find('.demande-completed-todos').text($('.todo-list-section').find('.task-completed').length);
                $('.todo-text').focus();
            }
        });
    });

    $('body').on('click', '.todo-checkbox', function () {
        let todoId = $(this).data('todo-id');
        let status = 0;
        let numberOfTodos = parseInt($('.total-todos').text());
        if ($(this).is(':checked')) {
            $(this).parent('.option-box-grid').find('p').addClass('task-completed');
            let numberOfCompleted = parseInt($('.number-of-completed-todos').text());
            numberOfCompleted += 1;
            $('.number-of-completed-todos').text(numberOfCompleted);
            $('.todo-progress').css('width', ((numberOfCompleted * 100) / numberOfTodos) + '%');
            window.click_demande_child.parents('.todo-strip').find('.demande-completed-todos').text(numberOfCompleted);
            status = 1;
            if (numberOfTodos == numberOfCompleted) {
                window.click_demande_child.parents('.todo-strip').find('.add-todo').removeClass('bg-white').addClass('bg-aqua');
            }
        } else {
            $(this).parent('.option-box-grid').find('p').removeClass('task-completed');
            let numberOfCompleted = parseInt($('.number-of-completed-todos').text());
            numberOfCompleted -= 1;
            $('.number-of-completed-todos').text(numberOfCompleted);
            $('.todo-progress').css('width', ((numberOfCompleted * 100) / numberOfTodos) + '%');
            window.click_demande_child.parents('.todo-strip').find('.demande-completed-todos').text(numberOfCompleted);
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
            success: function (result) {
                console.log(result);
            }
        });
    });

    $('body').on('click', '.todo-strip .create-todo', function () {
        let project_id = $(this).data('project-id');
        let demande_id = $(this).data('demande-id');
        window.click_demande_child = $(this);
        $('.f-loader').fadeIn(300);
        $.ajax({
            type: 'GET',
            url: route + 'todo/templates/list',
            data: {
                projet_id: project_id,
                demande_id: demande_id
            },
            success: function (result) {
                $('.f-loader').fadeOut(300);
                $('body').append(result);
                $('#todo-template-modal').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            },
            error: function (error) {

            }
        });
    });

    $('body').on('click', '.create-todo-list', function () {
        let projet_id = $(this).data('projet-id');
        let demande_id = $(this).data('demande-id');
        let template = $('.selected-template').val();
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
                success: function (result) {
                    $(this).text('AJOUTER');
                    $.notify({
                        message: result.message
                    }, {type: 'success'});
                    $('#todo-template-modal').modal('hide');
                    showTodoList(projet_id, demande_id, function (result) {
                        let stripTag = window.click_demande_child.parents('.todo-strip');
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
            let elem = $(this);
            let updatedText = $(this).text().trim();
            let todoId = $(this).data('todo-id');
            $(this).attr('contenteditable', false);
            $.ajax({
                type: 'POST',
                url: route + 'todo/update/' + todoId,
                data: {
                    todo: updatedText
                },
                success: function (result) {
                    if (result.status == true) {
                        $.notify({
                            message: result.message
                        }, {type: 'success'});
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
        $("#todo-list-modal").remove()
    });

})(window.jQuery);
