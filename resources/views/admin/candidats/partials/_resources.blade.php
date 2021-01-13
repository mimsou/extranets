<div class="content" id="resources">
    <div class="container-fluid pt-4">
        <h2>Resources</h2>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                <label for="avatar">{{ __('Profile Picture:') }}</label>
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

                            <button type="button" class="mt-2 btn-sm btn-primary" data-toggle="modal" data-target="#modalUpdateAvatar">Change profile picture</button><br>
                            <button type="button" class="mt-2 btn-sm btn-danger delete_media" data-mediaid="{{ $candidat->getFirstMedia('avatar')->id }}">Remove profile picture</button>
                        @else
                            <div id="avatar" class="dropzone p-3 text-center" style="cursor:pointer">
                                <div class="dz-message" data-dz-message><span>Drag and drop your avatar here.</span></div>
                            </div>
                        @endif    
                    </label>
                </div>
            </div>

            <div class="col-md-6">
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

        <hr/>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive p-t-10">
                    <table id="datatable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Modified</th>
                                <th>Size</th>
                                <th>Categories</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidat->getMedia('resources') as $media)
                                <tr>
                                    <td><a class="media-name" data-src="{{ $media->getFullUrl() }}">{{ $media->name }}</a></td>
                                    <td>{{ $media->mime_type }}</td>
                                    <td>{{ $media->updated_at->format('m/d/Y, h:i a') }}</td>
                                    <td>{{ $media->human_readable_size }}</td>
                                    <td>
                                        @if(!is_null($media->getCustomProperty('categories')))
                                            @foreach ($media->getCustomProperty('categories') as $category)
                                                {{ $category }}<br>
                                            @endforeach
                                        @endif    
                                        <button type="button" class="btn btn-transparent cat-modal" data-toggle="modal" data-target="#mediaCategory" data-media-id="{{ $media->id }}" data-cats={{ $media->getCustomProperty('customproperties') }}>
                                        <u>Add category</u>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete_media" data-mediaid="{{ $media->id }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Modified</th>
                                <th>Size</th>
                                <th>Categories</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>      
            </div>
        </div>

    </div>
</div>
