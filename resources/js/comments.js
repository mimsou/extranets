(function ($) {
    'use strict';

    var scope;
    try {
        scrollToBottomComment();
    } catch (e) {
    }

    $(document).on('click', '#note_trigger', openChat);
    $(document).on('click', '#close-comments', closeChat);
    $(document).on('click', '#note-comment-form .btn', submitComment);

    //For Comment Demande
    $(document).on('click', '#demande-comment-form .btn', submitComment);

    function scrollToBottomComment() {
        var elem = $('#demande_notes #note-messages');
        elem.animate({
            scrollTop: elem.height()
        });
    }

    function init_comments() {
        $.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}});
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
            data: {model_id: id, model_type: type, category: cat, message: message},
            success: function (data) {
                $(scope + ".first-comment").remove();
                $(scope + '#note-messages').append(data);
                $(scope + 'textarea.note').html('');
                $(scope + 'textarea.note').val('');
                $(scope + 'textarea.note').prop('disabled', false);
                $(scope + '#no-comment').hide();
                let commentCounts = $(scope + '.comment-counts').text();
                $(scope + '.comment-counts').text(parseInt(commentCounts) + 1);
                scrollBottom();
                scrollToBottomComment();
            },
            error: function (jqXHR, status, error) {
                console.log(jqXHR, status, error);
                alert(error);
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
            let demande_id = $(this).data('demande-id');
            getComments(demande_id, $(this), function (elem) {
                elem.find('a').text('Voir tous les commentaires');
                elem.removeClass('active-show-all');
                elem.parents('#demande_notes').find('.demande_old_messages_shadow').show();
                elem.parents('#demande_notes').find('#note-messages').css('height', '300px');
            }, 2);
        } else {
            let demande_id = $(this).data('demande-id');
            getComments(demande_id, $(this), function (elem) {
                elem.find('a').text('Afficher les derniers commentaires');
                elem.addClass('active-show-all');
                elem.parents('#demande_notes').find('.demande_old_messages_shadow').hide();
                elem.parents('#demande_notes').find('#note-messages').css('height', 'auto');
            });
        }
    });

    function getComments(demande_id, elem, callback, limit = null) {
        $.ajax({
            type: 'POST',
            url: route + 'comments/view/all',
            data: {
                demande_id: demande_id,
                limit: limit
            },
            success: function (result) {
                elem.parents('#demande_notes').find('#note-messages').html(result);
                callback(elem);
            }
        });
    }

    init_comments();

})(window.jQuery);
