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

                <div class="row text-left">
                    <div class="col-6">
                         <label for="avatar">{{ __('Profile Picture:') }}</label>
                        <div class="form-group">
                            @if (!is_null($candidat->getFirstMediaUrl('avatar', 'medium')))
                                <img src="{{ $candidat->getFirstMediaUrl('avatar', 'medium') }}" class="rounded img-thumbnail"/>
                            @endif
                            <label class="avatar-input" style="width: 100%">
                                <div id="avatar" class="dropzone p-3 text-center" style="cursor:pointer">
                                    Click here to upload your Profile Picture.
                                </div>
                                <input type="file" class="avatar-file-picker" id="user_avatar" name="avatar" required style="position:relative">
                            </label>
                        </div>
                    </div>
                    <div class="col-6">                        
                        <div class="form-group">
                            <label for="course_file">{{ __('Additionnal ressources') }}</label>
                            <div id="deleted_resource_ids"></div>

                            <div id="additional_resources" class="dropzone btn btn-block">
                                <div class="dz-message" data-dz-message><span>Drop your addtional resources here.</span></div>
                            </div>
                        </div>

                        <small class="text-muted">Saving can take some time if a video needs to be uploaded to the server.</small>

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
            <div class="col-md-12">
                <div class="table-responsive p-t-10">
                    <table id="datatable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Modified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidat->getMedia('resources') as $media)
                                <td><div class="media-name" data-src="{{ $media->getFullUrl() }}">{{ $media->name }}</div></td>
                                <td>{{ $media->mime_type }}</td>
                                <td>{{ $media->updated_at->format('m/d/Y, h:i a') }}</td>
                                <td>{{ $media->updated_at }}</td>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Modified</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>     
                  
            </div>
        </div>
    </div>
</div>
