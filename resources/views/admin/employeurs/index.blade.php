@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('modal')
    @include('admin.modals.confirmation', [
		'ident' => 'removeEmp',
		'title' => __('Êtes-vous certain?'),
		'text' => __('Voulez-vous vraiment supprimer <strong class="del_emp_non"></strong>?'),
		'controller' => action('EmployeurController@remove'),
		'redirect' => action('EmployeurController@index')
    ])
@endsection

@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">
                <div class="col-md-6 text-white p-b-30">
                    <h1>Liste des employeurs</h1>
                </div>
                <div class="col-md-6 text-white my-auto text-md-right p-b-30">
                    <a href="{{ action('EmployeurController@create') }}" class="btn btn-success"><i class="mdi mdi-plus"></i> {{ __('Ajouter un employeur') }}</a>
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
                                        <th>Statut</th>
                                        <th>Nom</th>
                                        <th>Contact principal</th>
                                        <th>Regroupement</th>
                                        <th>Dernière modification</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Statut</th>
                                        <th>Nom</th>
                                        <th>Contact principal</th>
                                        <th>Regroupement</th>
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
                    ajax: '{{ action('DatatablesController@getEmployeurs') }}',
                    columns: [
                        {data: 'statut'},
                        {data: 'nom'},
                        {data: 'contact_nom'},
                        {data: 'regroupement', name: 'regroupement.title'},
                        {data: 'updated_at', class:'text-right'},
                        {data: 'action'},
                    ]
                });
            });


            $(document).on('click', '.delete_employeur', function(e){
                var id = $(this).data('employeurid');
                var nom = $(this).data('nom');

                $('.del_emp_non').html(nom);
                $("#modalConfirmation_removeEmp .modal-body .hiddenfields").html("<input type='hidden' name='employeur_id' value='"+id+"'>");
                $('#modalConfirmation_removeEmp').modal('toggle');

            })

        })(window.jQuery);
    </script>

@endsection
