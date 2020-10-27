(function ($) {
    'use strict';

    var location = '#informations';

    $(document).on('click', '.mail-sidebar-item', function(){
        setTimeout(function(){
            updatePages();
        }, 10);
    });

    function updatePages(){
        // We will get the current location
        var tloc = window.location.hash;
        if(tloc.length != 0) location = tloc;

        updateMenu();

        $('.content').each(function(i){
            $(this).removeClass('active');
        });
        $(location).addClass('active');
    }


    function updateMenu(){
        $('.mail-sidebar-item').each(function(i){
            if($(this).attr('href') != location){
                console.log('NOT THE SAME', $(this).attr('href'), location);
                $(this).removeClass('active');
            }else{
                console.log('SAME', $(this).attr('href'), location);
                $(this).addClass('active');
            }
        })
    }


    function fake_id(){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 9; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }



    updatePages();

})(window.jQuery);
