<div class="content active" id="informations">
    <div class="container-fluid pt-4">
        <h2>Information</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nom">{{ __('Nom du candidat') }} *</label>
                    {{ Form::text('nom', null, ['required', 'class'=>'form-control', 'id'=>'nom']) }}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero">{{ __('Numéro') }} *</label>
                            {{ Form::text('numero', null, ['required', 'class'=>'form-control', 'id'=>'numero']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="statut">{{ __('Statut') }}</label>
                            {{ Form::select('statut', ['disponible'=>'Disponible', 'en_traitement'=>'En traitement', 'en_emploi'=>'En emploi', 'termine'=>'Terminé', 'retire'=>'retiré', 'non_recrute'=>'Non recruté'], null, ['class'=>'form-control', 'id'=>'statut']) }}
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
            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="com_candidat">{{ __('Commentaires sur le candidat retenu') }}</label>
                    {{ Form::textarea('com_candidat', null, ['class'=>'form-control', 'placeholder'=>'Entrer vos commentaires ici', 'id'=>'com_candidat']) }}
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>
