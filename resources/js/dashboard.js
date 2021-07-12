(function($){
    let startDate = '';
    let endDate = '';
    $('.input-daterange').daterangepicker({
        timePicker:false,
        singleDatePicker: false,
        autoApply: false,
        minDate: '2021-01-01',
        locale: { format: 'YYYY-MM-DD' }
    }, function(start,end){
        startDate = start;
        endDate = end;
    });
    $('body').on('click','.applyBtn',function(){
        $.ajax({
            type: 'GET',
            url: route+'get-dashboard-counts',
            data: {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            },
            success: function(result){
                $('.widget-content').html(result);
            }
        });
    });
})(jQuery)
