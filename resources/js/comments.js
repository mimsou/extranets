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

    function allScrollBottom(){
        $('.comment-section').each(function(){
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
        $.ajaxSetup({headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}});
    }

    function submitComment(e) {
        e.preventDefault();
        scope = '#' + $(this).data('scope') + " ";
        let elem = $(this);
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
                scrollToBottomComment(elem);
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
            $(this).find('.show-comment-text').text('Voir tous les commentaires');
            $(this).removeClass('active-show-all');
            $(this).parents('.comment-section').find('.demande_old_messages_shadow').show();
            $(this).parents('.comment-section').find('#note-messages').css({
                'height': '300px',
                'overflow-y': 'scroll'
            });
            allScrollBottom();
        } else {
            let demande_id = $(this).data('demande-id');
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

    function getComments(demande_id, elem, callback, limit = null) {
        $.ajax({
            type: 'POST',
            url: route + 'comments/view/all',
            data: {
                demande_id: demande_id,
                limit: limit
            },
            success: function (result) {
                elem.parents('.comment-section').find('#note-messages').html(result.html);
                elem.find('.comment-counts').text(result.count);
                callback(elem);
            }
        });
    }

    init_comments();

})(window.jQuery);
