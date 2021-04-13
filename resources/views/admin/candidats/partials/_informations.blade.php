<div class="content active" id="informations">
    @if(Auth::user()->role_lvl > 3)
        @include('admin.partials._notes', ['model'=>$candidat, 'category'=>'information '])
    @endif
    <div class="container-fluid pt-4">
        <h2>Information</h2>
        <div class="row">
            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nom">{{ __('Nom du candidat') }} *</label>
                            {{ Form::text('nom', null, ['required', 'class'=>'form-control', 'id'=>'nom']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regroupement_id">{{ __('Regroupement') }} *</label>
                            {{ Form::select('regroupement_id', \App\Models\Regroupement::pluck('title', 'id'), null, ['required', 'class'=>'form-control', 'id'=>'nom', 'placeholder'=>"Aucun"]) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numero">{{ __('Numéro') }} *</label>
                            {{ Form::text('numero', null, ['class'=>'form-control', 'id'=>'numero']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="statut">{{ __('Statut') }}</label>
                            {{ Form::select('statut', ['en_processus'=>'En processus', 'disponible'=>'Disponible', 'en_processus'=>'En processus', 'en_traitement'=>'En traitement', 'en_emploi'=>'En emploi', 'termine'=>'Terminé', 'retire'=>'retiré', 'non_recrute'=>'Non recruté'], null, ['class'=>'form-control', 'id'=>'statut']) }}
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

                @if(Auth::user()->role_lvl > 3)
                    <div class="form-group">
                        <label for="avatar">{{ __('Photo de profil:') }}</label>
                        <div class="form-group">
                            {{-- @if (!is_null($candidat->getFirstMediaUrl('avatar', 'medium')))
                                <div class="avatar avatar-xl">
                                    <img src="{{ $candidat->getFirstMediaUrl('avatar', 'medium') }}" class="avatar-img rounded" id="user_avatar_preview"/>
                                </div>
                            @endif --}}
                            <label class="avatar-input" style="width: 100%">
                                @if (!is_null($candidat->getFirstMediaUrl('avatar', 'medium')) && $candidat->getFirstMediaUrl('avatar', 'medium') != "")
                                    <div class="avatar avatar-xxl">
                                        <img src="{{ $candidat->getFirstMediaUrl('avatar', 'medium') }}" class="avatar-img rounded">
                                    </div><br>

                                    <button type="button" class="mt-2 btn-sm btn-primary" data-toggle="modal" data-target="#modalUpdateAvatar">Modifier la photo de profil</button><br>
                                    <button type="button" class="mt-2 btn-sm btn-danger delete_media" data-mediaid="{{ $candidat->getFirstMedia('avatar')->id }}">Retirer la photo de profil</button>
                                @else
                                    <div id="avatar" class="dropzone p-3 text-center" style="cursor:pointer">
                                        <div class="dz-message" data-dz-message><span>Glisser et déposer l'image ici</span></div>
                                    </div>
                                @endif
                            </label>
                        </div>
                    </div>
                @endif

            </div>
            <hr>
        </div>
    </div>
</div>
