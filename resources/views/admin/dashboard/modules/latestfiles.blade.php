<div class="card  mb-3">
    <div class="card-header">
        <div class="card-title">Derniers fichiers envoyés</div>
    </div>

    <div class="list-group list-group-flush ">

        @foreach (\Spatie\MediaLibrary\MediaCollections\Models\Media::orderBy('id', 'desc')->limit(10)->get() as $item)
            @php
                $icon = "fas fa-file-alt";
                if($item->mime_type == 'application/pdf') $icon = "fas fa-file-pdf";
                if($item->mime_type == 'application/msword') $icon = "fas fa-file-word";
                if(Str::contains($item->mime_type, 'image')) $icon = "fas fa-file-image";
                if(Str::contains($item->mime_type, 'audio')) $icon = "fas fa-file-video";
                if(Str::contains($item->mime_type, 'wordprocessingml')) $icon = "fas fa-file-word";
                if(Str::contains($item->mime_type, 'spreadsheetml')) $icon = "fas fa-file-spreadsheet";
            @endphp
            <div class="list-group-item d-flex align-items-center">
                <div class="m-r-20">
                    <div class="avatar avatar-sm ">
                        <div class="avatar-title bg-dark rounded"><i style="font-size:24px" class="{{$icon}}"></i></div>
                    </div>
                </div>
                <div class="">
                    <div>{{$item->name}}</div>
                    @if ($item->model_type == 'App\Models\Candidat')
                        @php
                            $candidat = \App\Models\Candidat::find($item->model_id);
                        @endphp
                        <div class="text-muted"><a href="{{ action('CandidatController@edit', $item->model_id) }}#recrutement"><i class="fas fa-address-card mr-1"></i> {{$candidat->nom}}</a></div>
                    @endif
                    <div class="text-muted"><small>{{ $item->human_readable_size }} - {{ $item->created_at->diffForHumans() }}</small></div>
                </div>

                <div class="ml-auto">
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi  mdi-dots-vertical mdi-18px"></i> </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" target="_blank" href="{{ $item->getFullUrl() }}" type="button">Télécharger</a>
                            @if ($item->model_type == 'App\Models\Candidat')
                                <a class="dropdown-item" href="{{ action('CandidatController@edit', $item->model_id) }}#recrutement" type="button">Fiche du candidat</a>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    @if (!\Spatie\MediaLibrary\MediaCollections\Models\Media::count())
        <div class="card-body">
            <p><i>Système de gestion des fichiers bientôt disponible</i></p>
        </div>
    @endif



</div>
