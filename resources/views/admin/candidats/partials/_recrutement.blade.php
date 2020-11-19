<div class="content" id="recrutement">
    <div class="container-fluid pt-4">
        <h2>Recrutement</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="recruteur_id">{{ __('Nom du recruteur') }}</label>
                    {{ Form::select('recruteur_id', \App\Models\User::all()->pluck('firstname', 'id'), null, ['class'=>'form-control', 'placeholder'=>'Choisir un recruteur', 'id'=>'recruteur_id']) }}
                </div>


                {{-- <div class="form-group">
                    <label for="date_debut_recrutement">{{ __('Date du début de la campagne de recrutement') }}</label>
                    {{ Form::date('date_debut_recrutement', null, ['class'=>'form-control', 'id'=>'date_debut_recrutement']) }}
                </div> --}}

                <div class="form-group">
                    <label for="date_selection">{{ __('Date de la dernière sélection du travailleur') }}</label>
                    {{ Form::date('date_selection', null, ['class'=>'form-control', 'id'=>'date_selection']) }}
                </div>

            </div>

            <div class="col-md-6">


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date_arrive">{{ __("Date d'arrivé du travailleur") }}</label>
                            {{ Form::date('date_arrive', null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'date_arrive']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_debut_emploi">{{ __("Date de début d'emploi") }}</label>
                            {{ Form::date('date_debut_emploi', null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'date_debut_emploi']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_fin_emploi">{{ __("Date de fin d'emploi") }}</label>
                            {{ Form::date('date_fin_emploi', null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'date_fin_emploi']) }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <br>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="com_recrutement">{{ __('Commentaires en recrutement') }}</label>
                    {{ Form::textarea('com_recrutement', null, ['class'=>'form-control', 'placeholder'=>'Entrer vos commentaires ici', 'id'=>'com_recrutement']) }}
                </div>
            </div>
        </div>


        <h2 class="mt-4">Demandes de recrutement associés</h2>

        @if (!count($candidat->demandesRecrutement()))
            <p><i>Aucun projet de recrutement n'est associé à ce candidat. Veuillez vous rendre dans <a href="{{action('ProjetController@index')}}" style="text-decoration:underline">la section projet</a> pour créer un nouveau projet ou l'associer à un existant.</i></p>
        @endif

            @foreach ($candidat->demandesRecrutement() as $p)
                @include('admin.candidats.partials._projet', ['p'=>$p])
            @endforeach
    </div>
</div>
