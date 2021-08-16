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

    let htmlAge = `
        <div class="form-group col-md-3">
            <div class="age_field">
                <label>Âge des enfants</label>
                <input type="number" name="age_d_enfants[]" value="" class="form-control" placeholder="Age" />
            </div>
        </div>
    `;

    $('input[name=nombre_d_enfants]').change(function(){
        let number = $(this).val();
        $('.rep_age').html('');
        for(let i = 1; i <= number; i++){
            $('.rep_age').append(htmlAge);
            if(i > 5){
                break;
            }
        }
    });
    $('input[name=nombre_d_enfants]').keyup(function(){
        let number = $(this).val();
        $('.rep_age').html('');
        for(let i = 1; i <= number; i++){
            $('.rep_age').append(htmlAge);
            if(i > 5){
                break;
            }
        }
    });

})(window.jQuery);
