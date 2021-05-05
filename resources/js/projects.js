$(function(){
    $('body').on('click','.remove_assignee',function(){
        if(confirm('Are you sure to remove?')){
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
});
