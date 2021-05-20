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
    @php
        $statuts = \App\Models\Projet::getProjetDeType();
    @endphp
    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">
                <div class="col-md-6 text-white p-b-30">
                    <h1>Liste des projets</h1>
                </div>
                @if(Auth::user()->role_lvl > 3)
                    <div class="col-md-6 text-white my-auto text-md-right p-b-30">
                        <a href="{{ action('ProjetController@create') }}" class="btn btn-success"><i class="mdi mdi-plus"></i> {{ __('Ajouter un projet') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container-fluid  pull-up">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-10 m-t-30 bg-dots p-4 projets_filters" id="projets_filters">
                    <div class="filters d-flex flex-md-row flex-column align-items-center justify-content-between">
                        <div class="filter_per_personne">
                            <div class="form-group">
                                <label for="auditor">Filtrer par personne</label>
                                {!! Form::select('personne',$personne,null,['class'=>'form-control form-control-sm height-35']) !!}
                            </div>
                        </div>
                        <div class="filter_per_type">
                            <div class="form-group">
                                <label for="type_de_projet" class="">Type de projet</label>
                                <select name="type_de_projet" class="form-control form-control-sm height-35">
                                    <option value="">TOUS</option>
                                    @foreach($statuts as $key => $options)

                                        @if(is_array($options))
                                            <option value="{{ $key }}" class="optionGroup">{{ $key }}</option>
                                            @foreach($options as $k => $option)
                                                <option value="{{ $k }}">&nbsp;&nbsp;&nbsp;{{ $option }}</option>
                                            @endforeach
                                        @else
                                            <option value="{{ $key }}">{{ $options }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter_per_employer">
                            <div class="form-group">
                                <label for="employeur">Employeur</label><br>
                                {!! Form::select('employeur',\App\Models\Employeur::orderBy('nom', 'ASC')->pluck('nom', 'id')->prepend('TOUS',''),null,['class'=>'form-control form-control-sm select2','style'=>'width: 184px !important; height: 25px !important;']) !!}
                            </div>
                        </div>
                        <div class="filter_per_status">
                            <div class="form-group">
                                @php
                                    $demandeStatuArray = [];
                                    $demandeStatuArray['IMMIGRATION'] = demandeStatuts();
                                    $demandeStatuArray['RECRUTEMENT'] = demandeStatuts(null,STATUTS_DEMANDE_REC);
                                @endphp
                                <label for="market" class="">Statut du dossier</label>
                                <select name="statut_du_dossier" class="form-control form-control-sm height-35" >
                                    <option value="">TOUS</option>
                                    @foreach($demandeStatuArray as $key => $options)

                                        @if(is_array($options))
                                            <option value="{{ $key }}" class="optionGroup">{{ $key }}</option>
                                            @foreach($options as $k => $option)
                                                <option value="{{ $k }}">&nbsp;&nbsp;&nbsp;{{ $option }}</option>
                                            @endforeach
                                        @else
                                            <option value="{{ $key }}">{{ $options }}</option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter_per_termine">
                            <div class="form-group m-b-10">
                                <label class="cstm-switch">
                                    <input type="checkbox" name="completed_demande" value="1" class="cstm-switch-input">
                                    <span class="cstm-switch-indicator "></span>
                                    <span class="cstm-switch-description">Afficher les demandes terminées </span>
                                </label>
                            </div>
                        </div>

                        <div class="filter_per_horaire">
                            <div class="form-group m-b-10">
                                <label class="cstm-switch">
                                    <input type="checkbox" name="hourly_checkbox" value="1" class="cstm-switch-input">
                                    <span class="cstm-switch-indicator "></span>
                                    <span class="cstm-switch-description">Afficher facturation horaire </span>
                                </label>
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
                                        <th>Numéro</th>
                                        <th>Employeur</th>
                                        <th>Type de projet</th>
                                        <th>Titre</th>
                                        <th>Responsable</th>
                                        <th data-orderable="false">Facturation horaire</th>
                                        {{-- <th>Candidats</th> --}}
                                        <th>Dernière modification</th>
                                        <th data-orderable="false" width="70px">Action</th>
                                        <th></th>
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
                                        <th>Responsable</th>
                                        <th>Facturation horaire</th>
                                        {{-- <th>Candidats</th> --}}
                                        <th>Dernière modification</th>
                                        <th>Action</th>
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
        var project_table;

        (function ($) {
            'use strict';

            let dataURL = '{{ action('DatatablesController@getProjets') }}';
            $(document).ready(function () {
                project_table = $('#datatable').DataTable({
                    scrollY:        '55vh',
                    scrollCollapse: true,
                    paging:         true,
                    serverSide:     true,
                    processing:     true,
                    searchDelay:    2000,
                    "order":        [[ 1, "asc" ]],
                    ajax: dataURL,
                    columns: [
                        {data: 'numero'},
                        {data: 'nom', name:'employeurs.nom'},
                        {data: 'statut'},
                        {data: 'titre'},
                        {data: 'responsable', name:'users.firstname'},
                        {data: 'facturation_horaire', name:'users.lastname'},
                        // {data: 'statut_candidat'},
                        {data: 'updated_at', class:'text-right'},
                        {data: 'action', class:'text-right'},
                        {data: 'childrow_html'},
                    ],
                    'fnInitComplete': function(){
                        this.fnSetColumnVis( 8, false);
                    }
                }).on('draw.dt', function () {



                    $('.dataTable-async tr').each(function(i,e){
                        var tr = $(this);
                        var row = project_table.row( tr );

                        //console.log($( window ).width());
                        //console.log(row.data());

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
            $('input[name=completed_demande], input[name=hourly_checkbox]').click(function(){
                applyFilters();
            });

            function applyFilters(){
                var search = "";
                let personne = ($('select[name=personne] option:selected').val() != '')?$('select[name=personne] option:selected').val():'ALL';
                let type_de_projet = ($('select[name=type_de_projet]').val() != '')?$('select[name=type_de_projet]').val():'ALL';
                let employeur = ($('select[name=employeur] option:selected').val() != '')?$('select[name=employeur] option:selected').val():'ALL';
                let statut_du_dossier = ($('select[name=statut_du_dossier] option:selected').val() != '')?$('select[name=statut_du_dossier] option:selected').val():'ALL';

                let isCompletedChecked = ($('input[name=completed_demande]').is(':checked'))?true:false;
                let isHourlyChecked = ($('input[name=hourly_checkbox]').is(':checked'))?true:false;
                project_table.ajax.url( dataURL+'/'+personne+'/'+type_de_projet+'/'+employeur+'/'+statut_du_dossier+'/'+isCompletedChecked+'/'+isHourlyChecked).load();
                project_table.search(search).draw();
            }

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