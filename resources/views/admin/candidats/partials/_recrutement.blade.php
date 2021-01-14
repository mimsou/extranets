<div class="content" id="recrutement">
    @include('admin.partials._notes', ['model'=>$candidat, 'category'=>'recrutement'])

    <div class="container-fluid pt-4">
        <h2>Recrutement</h2>
        <div class="row">
            <div class="col-md-6">
                {{-- <div class="form-group">
                    <label for="recruteur_id">{{ __('Nom du recruteur') }}</label>
                    {{ Form::select('recruteur_id', \App\Models\User::all()->pluck('firstname', 'id'), null, ['class'=>'form-control', 'placeholder'=>'Choisir un recruteur', 'id'=>'recruteur_id']) }}
                </div> --}}


                {{-- <div class="form-group">
                    <label for="date_debut_recrutement">{{ __('Date du début de la campagne de recrutement') }}</label>
                    {{ Form::date('date_debut_recrutement', null, ['class'=>'form-control', 'id'=>'date_debut_recrutement']) }}
                </div> --}}

                <div class="form-group">
                    <label for="date_selection">{{ __('Date de la dernière sélection du travailleur') }}</label>
                    {{ Form::date('date_selection', null, ['class'=>'form-control', 'id'=>'date_selection']) }}
                </div>

                <div class="form-group">
                    <label for="date_debut_emploi">{{ __("Date de début d'emploi") }}</label>
                    {{ Form::date('date_debut_emploi', null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'date_debut_emploi']) }}
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label for="date_arrive">{{ __("Date d'arrivé du travailleur") }}</label>
                    {{ Form::date('date_arrive', null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'date_arrive']) }}
                </div>

                <div class="form-group">
                    <label for="date_fin_emploi">{{ __("Date de fin d'emploi") }}</label>
                    {{ Form::date('date_fin_emploi', null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'date_fin_emploi']) }}
                </div>

            </div>

        </div>

        <br>

        {{-- <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="com_recrutement">{{ __('Commentaires en recrutement') }}</label>
                    {{ Form::textarea('com_recrutement', null, ['class'=>'form-control', 'placeholder'=>'Entrer vos commentaires ici', 'id'=>'com_recrutement']) }}
                </div>
            </div>
        </div> --}}


        <h2 class="mt-3">Documents du candidat</h2>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="course_file">{{ __('Additionnal ressources') }}</label>
                    <div id="deleted_resource_ids"></div>

                    <div id="additional_resources" class="dropzone btn btn-block">
                        <div class="dz-message" data-dz-message><span>Glisser et déposer les fichiers ici</span></div>
                    </div>
                </div>
                <small class="text-muted">Téléverser les documents sur le serveur peut prendre un certain temps. Assurez-vous de ne pas éteindre votre navigateur pendant le processus.</small>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive p-t-10">
                    <table id="datatable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nom du fichier</th>
                                <th>Catégories</th>
                                <th>Date d'ajout</th>


                                <th>Poid</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidat->getMedia('resources') as $media)
                                <tr>
                                    <td><a class="media-name"
                                            data-src="{{ $media->getFullUrl() }}"
                                            data-type="{{ $media->mime_type }}">
                                            <strong>{{ $media->name }}</strong>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if(!is_null($media->getCustomProperty('categories')))
                                                @foreach ($media->getCustomProperty('categories') as $category)
                                                    <div class="badge badge-soft-dark mr-1">{{ $category }}</div>
                                                @endforeach
                                            @endif
                                            <button type="button" class="btn btn-transparent btn-sm cat-modal" data-toggle="modal" data-target="#mediaCategory" data-media-id="{{ $media->id }}" data-cats={{ $media->getCustomProperty('customproperties') }}>
                                                <i class="fas fa-plus-square"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <td>{{ $media->updated_at->format('Y-m-d H:i') }} <br><small>{{ $media->updated_at->diffForHumans() }}</small></td>
                                    <td>{{ $media->human_readable_size }}</td>
                                    <td>{{ $media->mime_type }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete_media" data-mediaid="{{ $media->id }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nom du fichier</th>
                                <th>Catégories</th>
                                <th>Date d'ajout</th>


                                <th>Poid</th>
                                <th>Type</th>

                                <th>Actions</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>

        <h2 class="mt-5">Demandes de recrutement associés</h2>

        @if (!$candidat->demandesRecrutement()->count())
            <p><i>Aucun projet de recrutement n'est associé à ce candidat. Veuillez vous rendre dans <a href="{{action('ProjetController@index')}}" style="text-decoration:underline">la section projet</a> pour créer un nouveau projet ou l'associer à un existant.</i></p>
        @endif

            @foreach ($candidat->demandesRecrutement as $p)
                @include('admin.candidats.partials._projet-recrutement', ['p'=>$p])
            @endforeach
    </div>
</div>
