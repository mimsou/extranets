(function ($) {
    'use strict'

    function init_todos() {
        $.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}});
    }

    window.click_demande_child = null;
    $('body').on('click', '.todo-strip label',function(){
        let elem = $(this).parents('.todo-strip');
        if(elem.hasClass('in-active')){
            $(this).parents('.todo-strip').find('.create-todo').click();
        }else{
            $(this).parents('.todo-strip').find('.add-todo').click();
        }
    });
    $('body').on('click', '.todo-strip .add-todo, .create-demande-todo', function () {
        let project_id = $(this).data('project-id');
        let demande_id = $(this).data('demande-id');
        $('.f-loader').show();
        window.click_demande_child = $(this);
        showTodoList(project_id, demande_id);
    });

    function showTodoList(project_id, demande_id, callback = null) {
        $.ajax({
            type: 'GET',
            url: route + 'todo/list/' + project_id + '/' + demande_id,
            success: function (result) {
                $('.f-loader').hide();
                $('body').append(result);
                $('#todo-list-modal').modal({
                    'show': true,
                    backdrop: 'static',
                    keyboard: false
                });
                // $('.select2').select2();

                $('.sortable-todo-list').sortable({
                    handle: '.sort-handle',
                    connectWith: ".connectedSortable",
                    containment: ".todo-list-group",
                    dropOnEmpty: true,
                    stop: function (event, ui) {
                        let sortedArray = {};
                        let oldElem = $(event.target);
                        let newElem = $(ui.item[0]);
                        let newGroupID = newElem.parents('.group-section').data('group-id');
                        let oldGroupId = oldElem.parents('.group-section').data('group-id');
                        if(newGroupID != oldGroupId){
                            newElem.parents('.group-section').find('.todo-list-section .option-box-grid').each(function (i, el) {
                                sortedArray[$(this).find('input').data('todo-id')] = i + 1;
                            });
                        }else{
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
                            success: function (result) {
                            }
                        });
                    }
                });
                if(callback != null){
                    callback(result);
                }
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
        let elem = $(this).parents('.group-section');
        let textValue = $(this).val().trim();
        if (textValue != '') {
            elem.find('.save-todo-message').show();
        } else {
            elem.find('.save-todo-message').hide();
        }
        if (e.keyCode == 13) {
            elem.find('.save-todo-message').trigger('click');
        }
    });
    $('body').on('click','.add-todo-list', function(){
        $('.save-todo-message').trigger('click');
    });
    $('body').on('click', '.save-todo-message', function () {
        let groupElem = $(this).parents('.group-section');
        let elem = $(this)
        let todoText = $(this).parents('.add-todo-message-section').find('.todo-text').val();
        if(todoText.trim() != ''){
            elem.find('.todo-text').prop('disabled', true);
            let projetId = $(this).data('project-id');
            let demandeId = $(this).data('demande-id');
            let groupId = $(this).data('group-id');
            $.ajax({
                type: 'POST',
                url: route + 'todo/save',
                data: {
                    projet_id: projetId,
                    demande_id: demandeId,
                    todo: todoText,
                    group_id: groupId
                },
                success: function (result) {
                    //elem.prop('disabled', false).removeClass('disabled').hide();
                    groupElem.find('.todo-text').val('').prop('disabled', false);
                    groupElem.find('.todo-list-section').append(result.html);
                    groupElem.find('.save-todo-message').hide();
                    $('.total-todos').text($('.single-todo-div').length);
                    if(window.click_demande_child.hasClass('demande-todo')){
                        window.click_demande_child.removeClass('text-gray-400').removeClass('new-demande-from-template').addClass('create-demande-todo');
                    }
                    let stripTag = window.click_demande_child.parents('.todo-strip');
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
        let todoId = $(this).data('todo-id');
        let status = 0;
        let numberOfTodos = parseInt($('.total-todos').text());
        let elem = $(this).parent('.option-box-grid');
        if ($(this).is(':checked')) {
            elem.find('p').addClass('task-completed');
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
            elem.find('p').removeClass('task-completed');
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
                if(result.todo.completed_at != null){
                    elem.find('.completed-at-todo').html('Completed At: '+result.todo.completed_at);
                }else{
                    elem.find('.completed-at-todo').html('');
                }
                console.log(result);
            }
        });
    });

    $('body').on('click', '.todo-strip .create-todo, .new-demande-from-template', function () {
        let project_id = $(this).data('project-id');
        let demande_id = $(this).data('demande-id');
        window.click_demande_child = $(this);
        $('.f-loader').show();
        $.ajax({
            type: 'GET',
            url: route + 'todo/templates/list',
            data: {
                projet_id: project_id,
                demande_id: demande_id
            },
            success: function (result) {
                $('.f-loader').hide();
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

    $('body').on('blur','.option-box-grid p', function(){
        removeTodoMessage($(this));
    });

    // $('body').on('keypress', '.option-box-grid p', function (e) {
    //     if (e.keyCode == 13) {
    //         removeTodoMessage($(this));
    //     }
    // });

    function removeTodoMessage(elem){
        let updatedText = elem.text().trim();
        let todoId = elem.data('todo-id');
        elem.attr('contenteditable', false);
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

    $('body').on('hidden.bs.modal', '#create-todo-template-modal', function () {
        $('#create-todo-template-modal').remove();
    });

    $('body').on("hidden.bs.modal", '#todo-list-modal', function () {
        $("#todo-list-modal").remove()
    });

    $('body').on('click','.create-group',function(){
        let groupName = $('.group_name_text').val();
        let project_id = $(this).data('project-id');
        let demande_id = $(this).data('demande-id');
        if(groupName.trim() != ''){
            $.ajax({
                type: 'POST',
                url: route + 'todo/group/create',
                data: {
                    projet_id: project_id,
                    demande_id: demande_id,
                    group_name: groupName
                },
                success: function(result){
                    let elem = window.click_demande_child;
                    $('.todo-list-group').append(result);
                    $('.group_name_text').val('');
                    let stripTag = window.click_demande_child.parents('.todo-strip');
                    stripTag.removeClass('in-active');
                    stripTag.find('.fas').removeClass('create-todo').addClass('add-todo');
                    stripTag.find('.fas').removeClass('fa-plus').addClass('fa-check');
                    stripTag.find('label').html('<span class="demande-completed-todos">0</span> complété sur <span class="demande-total-todos">0</span>');
                }
            });
        }
    });

    $('body').on('click','.todo-list-section .add-new-assignee', function(){
        $(this).parents('.assignee').find('.add-new-assignee-wrapper').slideToggle();
    });

    $('body').on('change','.assign_demande', function(){
        let selectedAssignee = $(this).val();
        let todoId = $(this).data('todo');
        let elem = $(this);
        if(selectedAssignee.trim() != ''){
            $.ajax({
                type: 'POST',
                url: route + 'todo/assign/user',
                data: {
                    user: selectedAssignee,
                    todo_id: todoId
                },
                success: function(result){
                    if(result.is_exists == false){
                        let html = `
                        <div class="avatar avatar-xs ml-1 mb-1">
                           <span data-id="3" data-demand-id="8" class="remove_assignee avatar-title rounded-circle bg-dark">
                            `+result.initials+` <i class="fas fa-times remove_assignee_icon small-icon" data-id="`+result.user.id+`"></i>
                           </span>
                        </div>
                    `;
                        elem.parents('.assignee').find('.assigned-user-section').append(html);
                        elem.parents('.add-new-assignee-wrapper').slideUp();
                        elem.val('');
                    }else{
                        elem.parents('.add-new-assignee-wrapper').slideUp();
                        elem.val('');
                    }
                }
            });
        }
    });

    $('body').on('click', '.remove_assignee_icon', function(){
        let elem = $(this);
        let assignUserId = $(this).data('id');
        if(confirm('Are you sure to remove?')){
            $.ajax({
                type: 'POST',
                url: route + 'todo/remove/assignee',
                data: {
                    id: assignUserId
                },
                success: function(result){
                    elem.parents('.avatar').remove();
                }
            });
        }
    });
    function setCaret() {
        var el = document.getElementById("content-editable");
        var range = document.createRange()
        var sel = window.getSelection();
        range.setStart(el.childNodes[0], el.childNodes[0].length)
        range.collapse(true)

        sel.removeAllRanges()
        sel.addRange(range)
    }
    $('body').on('click','.group-section .edit-group-title', function(){
        let elem = $(this).parents('.group-section').find('.todo-group-title');
        elem.attr('id','content-editable');
        window.group_text_edited = elem.text();
        elem.attr('contenteditable', true).focus();
        setCaret();
    });

    $('body').on('dblclick','.todo-group-title', function(){
        window.group_text_edited = $(this).text();
        $(this).attr('contenteditable', true).focus();
    });

    $('body').on('blur','.todo-group-title', function(){
        let elem = $(this);
        $(this).attr('contenteditable', false);
        let groupName = $(this).text();
        let groupId = $(this).data('group-id');
        $.ajax({
            type: 'POST',
            url: route + 'todo/group/update',
            data: {
                group_name: groupName,
                group_id: groupId
            },
            success: function(result){
                if(result.status == 'deleted'){
                    elem.parents('.group-section').remove();
                }else if(result.status == 'error'){
                    alert('Group is not empty!');
                    elem.text(window.group_text_edited);
                }
            }
        });
    });

})(window.jQuery);
