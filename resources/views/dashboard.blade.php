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
            <div class="col-md-4 m-b-30">

                <div class="card ">
                    <div class="card-header">
                        <div class="card-title">Derniers fichiers envoyés</div>

                        <div class="card-controls">

                            <a href="#" class="js-card-refresh icon"> </a>

                        </div>

                    </div>

                    <div class="list-group list-group-flush ">

                        {{-- <div class="list-group-item d-flex align-items-center">
                            <div class="m-r-20">
                                <div class="avatar avatar-sm ">
                                    <div class="avatar-title bg-dark rounded"><i class="mdi mdi-24px mdi-file-pdf"></i></div>
                                </div>
                            </div>
                            <div class="">
                                <div>SRS Document</div>
                                <div class="text-muted">25.5 Mb</div>
                            </div>

                            <div class="ml-auto">
                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi  mdi-dots-vertical mdi-18px"></i> </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" type="button">Télécharger</button>
                                        <button class="dropdown-item" type="button">Copier l'URL</button>

                                    </div>
                                </div>
                            </div>

                        </div> --}}

                        <div class="card-body">
                            <p><i>Système de gestion des fichiers bientôt disponible</i></p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
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
                                    <div class="text-overline text-muted opacity-75 pb-2">Candidats en emploi</div>
                                    <h1 class="text-muted">{{ \App\Models\Candidat::where('statut', 'en_emploi')->count() }}</h1>
                                    {{-- <div class="text-danger h5 fw-600">
                                        <i class="mdi mdi-arrow-down"></i> 4.6%
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
                                    <div class="text-overline text-muted opacity-75 pb-2">Dossiers complétés</div>
                                    <h1 class="text-success">{{ \App\Models\Candidat::where('statut', 'termine')->count() }}</h1>
                                    {{-- <div class="text-success h5 fw-600">
                                        <i class="mdi mdi-arrow-up"></i> 45%
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
