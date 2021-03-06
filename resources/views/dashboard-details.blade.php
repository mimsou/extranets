@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('content')
    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-md-12 m-auto text-white p-b-30">
                    <h1 class="">Bonjour, {{Auth::user()->firstname}}!</h1>
                    <p class="opacity-75">
                        Tableau de bord
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pull-up">
        @if(!is_associate_user())
            <div class="row">
                <div class="col-md-6 col-lg-4 m-b-30">
                    @include('admin.dashboard.modules.rec_projetencours')
                    @include('admin.dashboard.modules.latestfiles')
                </div>
                <div class="col-md-6 col-lg-4 m-b-30">
                    @include('admin.dashboard.modules.imm_demandeseimt')
                    @include('admin.dashboard.modules.imm_demandeseimt_enattente')
                </div>
                <div class="col-md-6 col-lg-4 m-b-30">
                    @include('admin.dashboard.modules.imm_demandespermis')
                    @include('admin.dashboard.modules.imm_demandespermis_enattente')
                </div>
            </div>
        @endif
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
    <style>
        body{
            overflow-x: hidden;
        }
    </style>
@endsection
