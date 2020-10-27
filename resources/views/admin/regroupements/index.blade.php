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
                    <h1>Liste des regroupements</h1>
                </div>
                <div class="col-md-6 text-white my-auto text-md-right p-b-30">
                    <a href="{{ action('RegroupementController@create') }}" class="btn btn-success"><i class="mdi mdi-plus"></i> {{ __('Ajouter un regroupement') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid  pull-up">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive p-t-10">
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titre</th>
                                        <th>Dernière modification</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titre</th>
                                        <th>Dernière modification</th>
                                        <th>Action</th>
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
        (function ($) {
            'use strict';
            $(document).ready(function () {
                $('#datatable').DataTable({
                    scrollY:        '55vh',
                    scrollCollapse: true,
                    paging:         true,
                    serverSide:     true,
                    processing:     true,
                    ajax: '{{ action('DatatablesController@getRegroupements') }}',
                    columns: [
                        {data: 'id'},
                        {data: 'title'},
                        {data: 'updated_at', class:'text-right'},
                        {data: 'action'},
                    ]
                });
            });
        })(window.jQuery);
    </script>

@endsection
