@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('modal')
    @include('admin.modals.confirmation', [
		'ident' => 'removeProjet',
		'title' => __('Êtes-vous certain?'),
		'text' => __('Voulez-vous vraiment supprimer le projet #<strong class="del_emp_non"></strong>? <br><h5>Cette action est irréversible et aura pour effet de dissocier tous les candidats du projet.</h5>'),
		'controller' => action('ProjetController@remove'),
		'redirect' => action('ProjetController@index')
    ])
@endsection


@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">
                <div class="col-md-6 text-white p-b-30">
                    <h1>Liste des projets</h1>
                </div>
                <div class="col-md-6 text-white my-auto text-md-right p-b-30">
                    <a href="{{ action('ProjetController@create') }}" class="btn btn-success"><i class="mdi mdi-plus"></i> {{ __('Ajouter un projet') }}</a>
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
                                        <th data-orderable="false">Numéro</th>
                                        <th>Employeur</th>
                                        <th data-orderable="false">Type de projet</th>
                                        <th data-orderable="false">Titre</th>
                                        <th data-orderable="false">Facturation horaire</th>
                                        {{-- <th>Candidats</th> --}}
                                        <th data-orderable="false">Dernière modification</th>
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Employeur</th>
                                        <th>Type de projet</th>
                                        <th>Titre</th>
                                        <th>Facturation horaire</th>
                                        {{-- <th>Candidats</th> --}}
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
                    "order":        [[ 1, "asc" ]],
                    ajax: '{{ action('DatatablesController@getProjets') }}',
                    columns: [
                        {data: 'numero'},
                        {data: 'employeur_name'},
                        {data: 'statut'},
                        {data: 'titre'},
                        {data: 'facturation_horaire'},
                        // {data: 'statut_candidat'},
                        {data: 'updated_at', class:'text-right'},
                        {data: 'action'},
                    ]
                });
            });

            $(document).on('click', '.delete_projet', function(e){
                var id = $(this).data('projetid');
                var nom = $(this).data('num');

                $('.del_emp_non').html(nom);
                $("#modalConfirmation_removeProjet .modal-body .hiddenfields").html("<input type='hidden' name='projet_id' value='"+id+"'>");
                $('#modalConfirmation_removeProjet').modal('toggle');

            });

        })(window.jQuery);
    </script>

@endsection
