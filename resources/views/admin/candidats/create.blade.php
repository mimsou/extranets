@extends('admin.template')

@section('head')
@endsection

@section('content')
	<div class="bg-dark bg-dots m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-lg-8 text-center mx-auto text-white p-b-30">
                        <div class="m-b-10">
                            <div class="avatar avatar-lg ">
                                <div class="avatar-title bg-info rounded-circle mdi mdi-plus "></div>
                            </div>
                        </div>
                        <h3>{{ __("Création d'un candidat") }}</h3>
                    </div>


                </div>
            </div>
        </div>
        <section class="pull-up">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-8 mx-auto  mt-2">
                       <div class="card py-3 m-b-30">
                           <div class="card-body">

                                   	<h3 class="">{{ __("Information du candidat") }}</h3>
                                   	<p class="text-muted">
                                        Une fois sauvegardé, vous serez en mesure de modifier tous les détails du candidat.
                                    </p>

                                    {!! Form::open(['action' => ['CandidatController@store'] ]) !!}
                                        <div class="form-group">
                                            <label for="nom">{{ __('Nom du candidat') }} *</label>
                                            {{ Form::text('nom', null, ['required', 'class'=>'form-control', 'id'=>'nom']) }}
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="numero">{{ __('Numéro') }}</label>
                                                    {{ Form::text('numero', null, ['class'=>'form-control', 'id'=>'numero']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="statut">{{ __('Statut') }}</label>
                                                    {{ Form::select('statut', ['en_processus'=>'En processus', 'disponible'=>'Disponible', 'en_traitement'=>'En traitement', 'en_emploi'=>'En emploi', 'termine'=>'Terminé', 'retire'=>'retiré', 'non_recrute'=>'Non recruté'], null, ['class'=>'form-control', 'id'=>'statut']) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="emploi_id">{{ __('Emploi occupé') }}</label>
                                                    {{ Form::select('emploi_id', \App\Models\Emploi::orderBy('title', 'asc')->pluck('title', 'id'), null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'emploi_id']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pays_recrutement">{{ __('Pays de résidence') }}</label>
                                                    {{ Form::select('pays_recrutement', \App\Models\Pays::orderBy('title', 'asc')->pluck('title', 'id'), null, ['class'=>'form-control', 'placeholder'=>'Choisir un pays', 'id'=>'pays_recrutement']) }}
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-cta">Enregistrer</button>
                                    {!! Form::close() !!}


                           </div>
                       </div>

                    </div>

                </div>
            </div>
@endsection
