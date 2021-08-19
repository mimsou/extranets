@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-md-7 m-auto text-white p-b-30">
                    <h1 class="">Bonjour, {{Auth::user()->firstname}}!</h1>
                    <p class="opacity-75">
                        Voici un récapitulatif des avancements de l'équipe, nos bons coups!
                    </p>
                </div>

                <div class="col-md-3 text-right m-auto text-white p-t-40 p-b-30">
                    <div class="text-md-right">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="mdi mdi-calendar-multiselect"></i>
                                </span>
                            </div>
                            {!! Form::text('date_range',null,['class'=>'form-control','placeholder'=>'Filter Date', 'id' => 'date_range_dashboard']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="widget-content">
        @include('admin.dashboard.widgets')
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12  m-b-30">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Visualisation par mois</div>
                    </div>
                    <div class="card-body">
                        <textarea class="d-none chartdata">{{ json_encode($chartData) }}</textarea>
                        <h5 class="text-center">Records</h5>
                        <h6 class="text-center">
                            <span class="badge badge-primary">{{ $chartData['from_date'] }}</span> To <span class="badge badge-primary">{{ $chartData['to_date'] }}</span>
                        </h6>
                        <div id="chart-01"></div>
                    </div>
                    <div class="">
                    </div>

{{--                    <div class="card-footer">--}}
{{--                        <div class="d-flex  justify-content-between">--}}
{{--                            <h6 class="m-b-0 my-auto"><span class="opacity-75"> <i class="mdi mdi-information"></i> Restart your Re-targeting Campaigns</span>--}}
{{--                            </h6>--}}
{{--                            <a href="#!" class="btn btn-white shadow-none">See Campaigns</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>



@endsection

@section('footer')
    <script src="{{ asset('atmos-assets/vendor/DataTables/datatables.min.js') }}"></script>
    <script>
        (function ($) {
            'use strict';
            $(document).ready(function () {
                var default_options = {
                    scrollY: '35vh',
                    order: ['2', 'asc'],
                    scrollCollapse: true,
                    // stateSave: true,
                    searching: false, paging: false, info: true
                };

                $('#demandes_eimt').DataTable(default_options);
                $('#demandes_eimt_enattente').DataTable(default_options);
                $('#rec_projetencours').DataTable(default_options);
                $('#imm_demandepermis').DataTable(default_options);
                $('#imm_demandepermis_enattente').DataTable(default_options);


            });
        })(window.jQuery);
    </script>

@endsection
