@extends('admin.template')

@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-md-7 m-auto text-white p-b-30">
                    <h1 class="">Bonjour, {{Auth::user()->firstname}}!</h1>
                    <p class="opacity-75">
                        Bienvenue dans votre nouveau tableau de bord! Vous trouverez ici de l'information utile. N'hésitez surtout pas à nous contacter si vous désirez modifier le contenu de ce dernier afin de combler tous vos besoins d'entreprise.
                    </p>
                </div>

                <div class="col-md-5 m-auto text-white p-t-40 p-b-30">
                    <div class="text-md-right">
                        {{-- ADD SOME CONTENT HERE --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pull-up">

        <div class="row">
            <div class="col-md-6 m-b-30">

                <div class="card ">
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

            </div>
            <div class="col-md-6">
                <div class="row d-block d-md-flex">
                    <div class="col m-b-30">
                        <div class="card">

                            <div class="card-body">
                                <div class="card-controls">
                                    {{-- <a href="#" class="badge badge-soft-success"> <i class="mdi mdi-arrow-up"></i> 12%</a> --}}
                                </div>
                                <div class="text-center p-t-30 p-b-20">
                                    <div class="text-overline text-muted opacity-75 pb-2">Candidats disponibles</div>
                                    <h1 class="text-success">{{ \App\Models\Candidat::where('statut', 'disponible')->count() }}</h1>
                                    {{-- <div class="text-success h5 fw-600">
                                        <i class="mdi mdi-arrow-up"></i> 12.6%
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col m-b-30">
                        <div class="card ">

                            <div class="card-body">
                                <div class="card-controls">
                                    {{-- <a href="#" class="badge badge-soft-success"> <i class="mdi mdi-arrow-up"></i> 12%</a> --}}
                                </div>
                                <div class="text-center p-t-30 p-b-20">
                                    <div class="text-overline text-muted opacity-75 pb-2">Nombre de projets en cours</div>
                                    <h1 class="text-muted">{{ \App\Models\Projet::whereNotIn('statut', ['fermer'])->orderBy('titre','asc')->count() }}</h1>
                                    {{-- <div class="text-muted h5 fw-600">
                                        <i class="mdi mdi-arrow-up"></i> 0%
                                    </div> --}}
                                </div>
                            </div>

                        </div>
                    </div>




                </div>

                {{-- <small class="text-muted">* Basé sur une période antérieur d'un mois</small> --}}
            </div>
        </div>




    </div>

@endsection
