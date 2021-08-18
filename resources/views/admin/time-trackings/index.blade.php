@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">
                <div class="col-md-6 text-white p-b-30">
                    <h1>Rapport de temps</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pull-up">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-10 m-t-30 bg-dots p-4 projets_filters" id="projets_filters">
                    <div class="filters d-flex flex-md-row flex-column align-items-center justify-content-between">
                        <div class="filter_per_project">
                            <div class="form-group">
                                <label for="filter_project">Filtrer par projet</label>
                                <select class="form-control form-control-sm height-35"
                                        required="" id="filter_project" name="filter_project">
                                    <option value="0" selected>Tous</option>
                                    @foreach($projects as $key =>$project)
                                        <option value="{!! $key !!}" >{!! $project !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter_per_user">
                            <div class="form-group">
                                <label for="filter_user">Filtrer par personne</label>
                                <select class="form-control form-control-sm height-35"
                                        required="" id="filter_user" name="filter_user">
                                    <option value="0" selected>Tous</option>
                                    @foreach($users as $key =>$user)
                                        <option value="{!! $key !!}" >{!! $user !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter_per_date_from">
                            <div class="form-group">
                                <label for="filter_date_from">Filtrer par date</label>
                                <input type="text" class="input-daterange form-control" id="filter_date">
{{--                                {{ Form::date('filter_date_from', now()->startOfMonth()->format('Y-m-d'), [--}}
{{--                                    'class'=>'form-control',--}}
{{--                                    'id'=>'filter_date_from'--}}
{{--                                    ]) }}--}}
                            </div>
                        </div>
{{--                        <div class="filter_per_date_to">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="filter_date_to">Filtrer par date</label>--}}
{{--                                <!-- https://github.com/uxsolutions/bootstrap-datepicker -->--}}
{{--                                <input id="filter_date_to2" type="text"--}}
{{--                                       class="js-datepicker form-control"--}}
{{--                                       placeholder="Select a Date" value="{!! now()->endOfMonth()->format('Y-m-d') !!}">--}}
{{--                                {{ Form::date('filter_date_to', now()->endOfMonth()->format('Y-m-d'), [--}}
{{--                                    'class'=>'form-control',--}}
{{--                                    'id'=>'filter_date_to'--}}
{{--                                    ]) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
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
                                <tbody>

                                </tbody>
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
                        this.fnSetColumnVis( 5, false);
                    }
                }).on('draw.dt', function () {
                    $('.dataTable-async tr').each(function(i,e){
                        var tr = $(this);
                        var row = time_tracking_table.row( tr );

                        console.log($( window ).width());
                        console.log(row.data());

                        if(typeof row.data() != 'undefined' && $( window ).width() > 1024){
                            // this.fnSetColumnVis( 5, false);

                            if ( !row.child.isShown() ) {
                                row.child( row.data().childrow_html, 'dark-row' );
                                row.child.show();
                                tr.addClass('shown');

                            }
                        }
                    });
                });
            });

            $('#projets_filters').find('select').change(function(){
                applyFilters();
            });

            //---o Initiate Date Range Picker
            //http://www.daterangepicker.com/#options
            $('#filter_date').data('daterangepicker').setStartDate(start_date);
            $('#filter_date').data('daterangepicker').setEndDate(end_date);
            //Martin: I didn't found a way to put date format : d-m-Y
            $('#filter_date').daterangepicker({
                "locale": {
                    "format": "MM/DD/YYYY",
                }
            }, function(start, end, label) {
                start_date = start.format('MM/DD/YYYY');
                end_date = end.format('MM/DD/YYYY');
                applyFilters();
            });

            function getUrl(){
                let dataURL = '{{ action('TimeTrackingController@getDatatableContent') }}';
                let user_id = document.getElementById('filter_user').value;
                let project_id = document.getElementById('filter_project').value;
                let url = dataURL+'?user='+user_id+"&projet="+project_id;
                url += "&date_from="+start_date;
                url += "&date_to="+end_date;
                return url;
            }

            function applyFilters(){
                let search = "";
                time_tracking_table.ajax.url(getUrl()).load();
                time_tracking_table.search(search).draw();
            }
        })(window.jQuery);
    </script>

@endsection
