@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('content')

    @include('admin.time-trackings.modals.timeTrackingDetails')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">
                <div class="col-md-6 text-white p-b-30">
                    <h1>Rapport de temps</h1>
{{--                    <h1><i class="fas fa-business-time "></i>&nbsp;Rapport de temps</h1>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pull-up">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-10 m-t-30 bg-dots p-4 projets_filters" id="projets_filters">
                    <div class="filters d-flex flex-md-row flex-column align-items-center justify-content-between">
                        <div class="filter_project">
                            <div class="form-group">
                                <label for="filter_project">Filtrer par projet</label>
                                {!! Form::select('filter_project',
                                    $projects,
                                    null,
                                    [
                                        'id' => "filter_project",
                                        'required' => "",
                                        'class'=>'form-control form-control-sm select2 height-35',
                                        'style'=>'width: 200px !important; !important;'
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="filter_user">
                            <div class="form-group">
                                <label for="filter_user">Filtrer par personne</label>
                                {!! Form::select('filter_user',
                                    $users,
                                    null,
                                    [
                                        'id' => "filter_user",
                                        'class'=>'form-control form-control-sm select2',
                                        'style'=>'width: 200px !important; height: 25px !important;'
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="filter_employeur">
                            <div class="form-group">
                                <label for="filter_employeur">Filtrer par employeur</label>
                                {!! Form::select('filter_employeur',
                                    $employeurs,
                                    null,
                                    [
                                        'id' => "filter_employeur",
                                        'class'=>'form-control form-control-sm select2',
                                        'style'=>'width: 200px !important; height: 25px !important;'
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="filter_project_type">
                            <div class="form-group">
                                <label for="filter_project_type">Filtrer par type de projet</label>
                                {!! Form::select('filter_project_type',
                                    $statuts,
                                    null,
                                    [
                                        'id' => "filter_project_type",
                                        'class'=>'form-control form-control-sm select2',
                                        'style'=>'width: 200px !important; height: 25px !important;'
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="filter_task_type">
                            <div class="form-group">
                                <label for="filter_task_type">Filtrer par type de tâche</label>
                                {!! Form::select('filter_task_type',
                                    array_merge(['all' => 'Tous'],\App\Models\Enum\TaskType::allByGroup()),
                                    null,
                                    [
                                        'id' => "filter_task_type",
                                        'class'=>'form-control form-control-sm select2',
                                        'style'=>'width: 200px !important; height: 25px !important;'
                                    ])
                                !!}
                            </div>
                        </div>
                        <div class="filter_per_date_from">
                            <div class="form-group">
                                <label for="filter_date_from">Filtrer par date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="mdi mdi-calendar-multiselect"></i>
                                </span>
                                    </div>
                                    {!! Form::text('date_range',null,[
                                        'class'=>'form-control input-daterange',
                                        'placeholder'=>'Filter Date',
                                        'id' => 'filter_date'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive p-t-10">
                            <table id="datatable" class="table dataTable-async" style="width:100%">
                                <thead>
                                    <tr>
                                        <th># Projet</th>
                                        <th>Projet</th>
                                        <th>Employeur</th>
                                        <th>Type de projet</th>
                                        <th>Total h.</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody> </tbody>
                                <tfoot>
                                    <tr>
                                        <th># Projet</th>
                                        <th>Projet</th>
                                        <th>Employeur</th>
                                        <th>Type de projet</th>
                                        <th>Total h.</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('atmos-assets/vendor/DataTables/datatables.min.js') }}"></script>
    <script>
        let time_tracking_table;
        let start_date = '{!! now()->startOfMonth()->format('m/d/Y') !!}';
        let end_date = '{!! now()->endOfMonth()->format('m/d/Y') !!}';

        (function ($) {
            'use strict';

            $(document).ready(function () {
                time_tracking_table = $('#datatable').DataTable({
                    scrollY:        '55vh',
                    scrollCollapse: true,
                    paging:         true,
                    serverSide:     true,
                    processing:     true,
                    stateSave:      true,
                    ajax: getUrl(),
                    columns: [
                        {data: 'projet.numero'},
                        {data: 'projet.titre'},
                        {data: 'projet.employeur.nom'},
                        {data: 'projet.statut'},
                        {data: 'total_hours'},
                        {data: 'childrow_html'},
                    ],
                    'fnInitComplete': function(){
                        //for row child
                        this.fnSetColumnVis( 5, false);
                    }
                }).on('draw.dt', function () {
                    $('.dataTable-async tr').each(function(i,e){
                        let tr = $(this);
                        let row = time_tracking_table.row( tr );

                        if(typeof row.data() != 'undefined' && $( window ).width() > 1024){
                            if ( !row.child.isShown() ) {
                                row.child( row.data().childrow_html, 'dark-row' );
                                row.child.show();
                                tr.addClass('shown');

                            }
                        }
                    });
                });
            });
            //
            // $('#projets_filters').find('select').change(function(){
            //     applyFilters('select');
            // });

            $('#filter_user').on('select2:select', function (e) {
                applyFilters('filter_user.select');
            });

            $('#filter_employeur').on('select2:select', function (e) {
                applyFilters('filter_employeur.select');
            });

            $('#filter_project').on('select2:select', function (e) {
                applyFilters('filter_project.select');
            });

            $('#filter_project_type').on('select2:select', function (e) {
                applyFilters('filter_project_type.select');
            });

            $('#filter_task_type').on('select2:select', function (e) {
                applyFilters('filter_task_type.select');
            });

            //---o Initiate Date Range Picker
            //http://www.daterangepicker.com/#options
            $('#filter_date').data('daterangepicker').setStartDate(start_date);
            $('#filter_date').data('daterangepicker').setEndDate(end_date);
            //Martin: I didn't found a way to put date format : d-m-Y
            $('#filter_date').daterangepicker({
                timePicker: false,
                singleDatePicker: false,
                autoApply: false,
                minDate: '01/01/2021',
                locale: { format: 'MM/DD/YYYY' }
            }, function(start, end) {
                start_date = start.format('MM/DD/YYYY');
                end_date = end.format('MM/DD/YYYY');
                applyFilters('daterangepicker');
            });

            function getUrl(){
                let dataURL = '{{ action('TimeTrackingController@getDatatableContent') }}';

                let user_id = $('#filter_user').select2('data')[0].id;
                let employeur_id = $('#filter_employeur').select2('data')[0].id;
                let project_type_id = $('#filter_project_type').select2('data')[0].id;
                let project_id = $('#filter_project').select2('data')[0].id;
                let task_type = $('#filter_task_type').select2('data')[0].id;

                // console.log('user_id '+user_id);
                // console.log('employeur_id '+employeur_id);
                // console.log('project_type_id '+project_type_id);
                // console.log('project_id '+project_id);

                let url = dataURL;
                url += '?user='+user_id;
                url += "&employeur="+employeur_id;
                url += "&projet_type="+project_type_id;
                url += "&projet="+project_id;
                url += "&task_type="+task_type;
                url += "&date_from="+start_date;
                url += "&date_to="+end_date;
                return url;
            }

            function applyFilters(from){
                console.log('applyFilters '+from);
                time_tracking_table.ajax.url(getUrl()).load();
            }
        })(window.jQuery);
    </script>

    <script>
        $(document).ready(function(){
            console.log('Ready');
            $('#timeTrackingDetails .modal_loading').hide();
        });

        $('#timeTrackingDetails').on('show.bs.modal', function (e) {
            console.log('show modal');
            loadTimeTrackingContent();
        })

        function loadTimeTrackingContent(){
            $('#timeTrackingDetails .modal_loading').show();
            $('#timeTrackingDetails .modal_edit_content').hide();
            $.ajax({
                type: "GET",
                url: "{!! route('time_tracking_detail_show',['projet_id'=> 4, 'user_id' => 9]) !!}",
                success: function(data)
                {
                     setTimeout(function(){
                        $('#timeTrackingDetails .modal_loading').hide();
                        $('#timeTrackingDetails .modal_edit_content').html(data.view).show();
                    }, 1000);
                },
                error: function(jqXHR, status, error) {
                    fetchErrorNotifications("Erreur", "Il y a eu un problème.");
                }
            });
        }

        function fetchErrorNotifications($title, $message) {
            $.ajax({
                url: '{{ route('flash.notifications') }}',
                type: 'GET',
                success: function (result) {
                    // Fetch any notifications if we have any
                    //http://bootstrap-notify.remabledesigns.com/
                    notification_template_ajax = result;
                    jQuery.notify({
                        // options
                        icon: 'mdi mdi-exclamation',
                        title: $title,
                        message: $message
                    }, {
                        placement: {
                            align: "right",
                            from: "top"
                        },
                        showProgressbar: true,
                        timer: 120,
                        z_index: 10031,
                        offset: {
                            x: 50,
                            y: 10
                        },
                        // settings
                        type: 'danger',
                        template: notification_template_ajax
                    });
                },
                error: function(jqXHR, status, error) {
                    console.log(jqXHR, status, error);
                    fetchErrorNotifications("Erreur", "Il y a eu un problème.");
                }
            });
        }

        //
        //---o Flash for Ajax
        //
        function fetchSuccessNotifications($title, $message) {
            $.ajax({
                url: '{{ route('flash.notifications') }}',
                type: 'GET',
                success: function (result) {
                    // Fetch any notifications if we have any
                    //http://bootstrap-notify.remabledesigns.com/
                    notification_template_ajax = result;
                    jQuery.notify({
                        // options
                        icon: 'mdi mdi-check',
                        title: $title,
                        message: $message
                    }, {
                        placement: {
                            align: "right",
                            from: "top"
                        },
                        showProgressbar: true,
                        timer: 120,
                        z_index: 10031,
                        offset: {
                            x: 50,
                            y: 10
                        },
                        // settings
                        type: 'success',
                        template: notification_template_ajax
                    });
                },
                error: function(jqXHR, status, error) {
                    console.log(jqXHR, status, error);
                    fetchErrorNotifications("Erreur", "Il y a eu un problème.");
                }
            });
        }
    </script>

@endsection
