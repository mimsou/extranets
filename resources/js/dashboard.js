(function($){
    let startDate = '';
    let endDate = '';
    $('.input-daterange-picker').daterangepicker({
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

     if ($("#chart-01").length) {
         let ChartData = JSON.parse($('.chartdata').text());
        console.log(ChartData);
        var options = {
            colors: colors,
            chart: {
                type: 'bar',
                height: '350'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    endingShape: 'rounded',
                    columnWidth: '55%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'EIMT',
                data: Object.values(ChartData['emit'])
            }, {
                name: 'EIMT Approuvées',
                data: Object.values(ChartData['emit_approved'])
            }, {
                name: 'DST Envoyées',
                data: Object.values(ChartData['demande_dist'])
            }, {
                name: 'DST Approuvées',
                data: Object.values(ChartData['dist_approved'])
            }, {
                name: 'PT Envoyées',
                data: Object.values(ChartData['pt_sent'])
            }, {
                name: 'PT Reçues',
                data: Object.values(ChartData['pt_received'])
            }, {
                name: 'Projets terminés',
                data: Object.values(ChartData['project_complete'])
            }],
            xaxis: {
                categories: Object.keys(ChartData['project_complete']),
            },
            yaxis: {
                title: {
                    text: 'Count'
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "" + val + ""
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#chart-01"),
            options
        );

        chart.render();
    }

})(jQuery)
