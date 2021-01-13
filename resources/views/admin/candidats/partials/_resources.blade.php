<div class="content" id="resources">
    <div class="container-fluid pt-4">
        <h2>Medias</h2>
        <hr/>
        <div class="row">
            <div class="col-md-3">
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

            <div class="col-md-9">
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

    </div>
</div>
