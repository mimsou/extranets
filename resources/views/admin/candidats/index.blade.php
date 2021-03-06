@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('modal')
    @include('admin.modals.confirmation', [
		'ident' => 'removeCandidat',
		'title' => __('Êtes-vous certain?'),
		'text' => __('Voulez-vous vraiment supprimer?'),
		'controller' => action('CandidatController@remove'),
		'redirect' => action('CandidatController@index')
    ])
@endsection


@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">
                <div class="col-md-6 text-white p-b-30">
                    <h1>Liste des candidats</h1>
                </div>
                <div class="col-md-6 text-white my-auto text-md-right p-b-30">
                    <a href="{{ action('CandidatController@create') }}" class="btn btn-success"><i class="mdi mdi-plus"></i> {{ __('Ajouter un candidat') }}</a>
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
{{--                                        <th>Id</th>--}}
                                        <th>Statut</th>
                                        <th>Numéro</th>
                                        <th>Nom</th>
                                        <th >Pays</th>
                                        {{-- <th>Recruteur</th> --}}
                                        <th >Emploi</th>
                                        <th >Regroupement</th>
                                        {{-- <th>Mission</th> --}}
                                        <th>Dernière modification</th>
                                        <th width="60px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
{{--                                        <th>Id</th>--}}
                                        <th>Statut</th>
                                        <th>Numéro</th>
                                        <th>Nom</th>
                                        <th >Pays</th>
                                        {{-- <th data-orderable="false">Recruteur</th> --}}
                                        <th >Emploi</th>
                                        <th >Regroupement</th>
                                        {{-- <th>Mission</th> --}}
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
                    stateSave:      true,
                    "order":        [[ 1, "asc" ]],
                    ajax: '{{ action('DatatablesController@getCandidats') }}',
                    columns: [
                        // {data: 'id'},
                        {data: 'statut'},
                        {data: 'numero'},
                        {data: 'nom'},
                        {data: 'pays.title', name: 'pays.title', "defaultContent": "<i>Not set</i>"},
                        // {data: 'recruteur', name: 'recruteur.firstname'},
                        {data: 'emploi.title', name: 'emploi.title', "defaultContent": "<i>Not set</i>"},
                        {data: 'regroupement.title', name: 'regroupement.title', "defaultContent": "<i>Not set</i>"},
                        {data: 'updated_at', class:'text-right'},
                        {data: 'action'},
                    ]
                });

                $(document).on('click', '.delete_candidate', function(e) {
                    var id = $(this).data('candidat');
                    $("#modalConfirmation_removeCandidat .modal-body .hiddenfields").html("<input type='hidden' name='candidat_id' value='"+id+"'>");
                    $('#modalConfirmation_removeCandidat').modal('toggle');

                })
            });
        })(window.jQuery);
    </script>

@endsection
