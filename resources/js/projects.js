$(function(){
    $('body').on('click','.remove_assignee',function(){
        if(confirm('Êtes-vous certain de vouloir retirer cet utilisateur?')){
            let elem = $(this);
            let assigneeId = $(this).data('id');
            let demand_id = $(this).data('demand-id')
            $.ajax({
                type: 'POST',
                url: route+'remove/assignee',
                data: {
                    assignee_id: assigneeId,
                    demand_id: demand_id
                },
                success: function(result){
                    console.log(result);
                    if(result.status == true){
                        $(elem).parent('.avatar').remove();
                    }
                }
            });
        }
    });
    $('.select2').select2();

    $('.complete_demande').click(function(e){
        let url = $(this).attr('href');
        let elem = $(this);
        e.preventDefault();
        $(this).hide();
        $('.loader').show()
        $.ajax({
            type: 'GET',
            url: $(this).attr('href'),
            data:{},
            success: function(result){
                $('.complete_demande').show();
                $('.loader').hide()
                if(result.status == 0){
                    elem.find('.avatar-title').addClass('bg-transparent border mt-1').removeClass('bg-success');
                    elem.find('.avatar-title i').addClass('hide-demande-tick-icon');
                }else{
                    elem.find('.avatar-title').addClass('bg-success').removeClass('bg-transparent border mt-1');
                    elem.find('.avatar-title i').removeClass('hide-demande-tick-icon');
                }

                console.log(result);
            }
        });
    });
});