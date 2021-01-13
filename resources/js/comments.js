(function ($) {
    'use strict';

    var scope;

    $(document).on('click', '#note_trigger', openChat);
    $(document).on('click', '#close-comments', closeChat);
    $(document).on('click', '#note-comment-form .btn', submitComment);

    function init_comments(){
        $.ajaxSetup({ headers: { 'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content') } });
    }

    function submitComment(e){
        e.preventDefault();
        scope = '#'+ $(this).data('scope') +" ";

        var url = $(scope+'#note-comment-form').data('url');

        var id = $(scope+'#note_model_id').val();
        var type = $(scope+'#note_model_type').val();
        var cat = $(scope+'#note_category').val();
        var message = $(scope+'#note_message').val();

        $(scope+'textarea.note').prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            data: {model_id:id, model_type:type, category:cat, message:message},
            success: function(data) {
                $(scope+".first-comment").remove();
                $(scope+'#note-messages').append(data);
                $(scope+'textarea.note').html('');
                $(scope+'textarea.note').val('');
                $(scope+'textarea.note').prop('disabled', false);
                scrollBottom();
            },
            error: function(jqXHR, status, error){
                console.log(jqXHR, status, error);
                alert(error);
                $(scope+'textarea.note').prop('disabled', false);
            }
        });
    }


    function scrollBottom(){
        var objDiv = document.getElementById("note-messages");
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    function openChat(e){
        scope = '#'+ $(this).data('scope') +" ";
        console.log(scope);
        scrollBottom();
        $(scope+'#note_trigger').addClass('active');
        $(scope+'#note_window').addClass('active');
    }

    function closeChat(){
        scope = '#'+ $(this).data('scope') +" ";
        $(scope+'#note_trigger').removeClass('active');
        $(scope+'#note_window').removeClass('active');
    }

    init_comments();

})(window.jQuery);
