@extends('admin.template')

@section('head')
@endsection

@section('content')
    @if(Auth::user()->role_lvl > 3)
        @include('admin.partials._notes', ['model'=>$employeur])
    @endif

    <div class="bg-dark bg-dots m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">
                <div class="col-lg-12 text-center mx-auto text-white p-b-30">
                    <div class="m-b-10">
                        <div class="avatar avatar-lg ">
                            <div class="avatar-title bg-info rounded-circle fas fa-user-tie "></div>
                        </div>
                    </div>
                    <h3>{{ $employeur->nom }}</h3>
                </div>
            </div>
        </div>
    </div>

    <section class="pull-up">
        <div class="container">
            <div class="row ">
                <div class="col-lg-7 mt-2">
                    <div class="card py-3 m-b-30">
                        <div class="card-body">
                            <h3 class="">{{ __("Information") }}</h3>
                            <p class="text-muted">
                                Utiliser cette page pour modifier les informations d'un employeur
                            </p>

                            {!! Form::model($employeur, ['method' => 'PATCH', 'action' => ['EmployeurController@update', $employeur], 'class' => 'employer-frm' ]) !!}
                                @include('admin.employeurs._form')
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>

                <div class="col-lg-5 mt-2">

                    @if(Auth::user()->role_lvl != 3) {{-- Dont't show this if logged-in user is employer --}}
                        <div class="row  mb-5">
                            <div class="col-12">
                                <a href="{{ action('EmployeurController@userManagement', $employeur->id) }}" class="btn btn-warning"><i class="fas fa-plus-circle pr-2"></i> Gestion des utilisateurs</a>
                            </div>
                        </div>
                    @endif

                    <div class="card py-3 m-b-30">
                        <div class="card-body">
                            <h3 class="mb-0">{{ __("Projets") }}</h3>
                            <h5 class="">{{ __("Recrutement") }}</h5>
                            @if (!$employeur->projets()->where('statut', 'LIKE', 'rec_%')->count())
                                <p class="text-muted opacity-50"><i>Aucun projet de recrutement n'a été associé à ce compte. </i></p>
                            @endif
                        </div>

                        <div class="list-group list-group-flush ">
                            @foreach ($employeur->projets()->where('statut', 'LIKE', 'rec_%')->get() as $p)
                                <div class="list-group-item suivi-projets">

                                    <div class="d-flex align-items-center">
                                        <div class="badge badge-secondary mr-3">
                                            <strong>#{{ $p->numero }}</strong>
                                        </div>
                                        <div class="content">
                                            <h5 class="pt-2"><a href="{{ action('ProjetController@edit', $p->id) }}" target="_blank" class="pr-3">{{ $p->titre }}</a></h5>
                                        </div>
                                    </div>

                                    @foreach ($p->demandes()->where('type', 'recrutement')->get() as $d)
                                        <div class="d-flex align-items-top">


                                                <div class="content mb-3">
                                                    {{ $d->employeur->nom }}

                                                    <div class="progress-bar-container mt-1">
                                                        <span class="progress-bar" style="width:{{ demandeProgression($d->statut, STATUTS_DEMANDE_REC) }}"></span>
                                                    </div>

                                                    <small>{{ demandeStatuts($d->statut, STATUTS_DEMANDE_REC) }} <br> <i>{{ $d->candidats()->count() }} sur {{ $d->nb_candidat }} candidats requis ({{$d->postes()}})</i></small>

                                                </div>

                                        </div>
                                    @endforeach


                                </div>
                            @endforeach
                        </div>

                        <div class="card-body">
                                <h5 class="mt-3">{{ __("Immigration") }}</h5>
                                @if (!$employeur->projets()->where('statut', 'LIKE', 'imm_%')->count())
                                <p class="text-muted opacity-50"><i>Aucun projet d'immigration n'a été associé à ce compte. </i></p>
                            @endif
                        </div>

                        <div class="list-group list-group-flush ">
                            @foreach ($employeur->projets()->where('statut', 'LIKE', 'imm_%')->get() as $p)
                                <div class="list-group-item suivi-projets">

                                    <div class="d-flex align-items-center">
                                        <div class="badge badge-danger mr-3">
                                            <strong>#{{ $p->numero }}</strong>
                                        </div>
                                        <div class="content">
                                            <h5 class="pt-2"><a href="{{ action('ProjetController@edit', $p->id) }}" target="_blank" class="pr-3">{{ $p->titre }}</a></h5>
                                        </div>
                                    </div>

                                    @foreach ($p->demandes()->where('type', 'immigration')->get() as $d)
                                        <div class="d-flex align-items-top">


                                                <div class="content mb-3">
                                                    {{ $d->employeur->nom }}

                                                    <div class="progress-bar-container mt-1">
                                                        <span class="progress-bar" style="width:{{ demandeProgression($d->statut) }}"></span>
                                                    </div>

                                                    <small>{{ demandeStatuts($d->statut) }} </small>

                                                </div>

                                        </div>
                                    @endforeach


                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="card py-3 m-b-30">
                        <div class="card-body">
                            <h3 class="mb-0">{{ __("Demandes") }}</h3>
                            <h5 class="">{{ __("Recrutement") }}</h5>
                            @if (!$employeur->demandes()->where('type', '=', 'recrutement')->count())
                                <p class="text-muted opacity-50"><i>Aucun projet de recrutement n'a été associé à ce compte. </i></p>
                            @endif
                        </div>

                        <div class="list-group list-group-flush ">
                            @foreach ($employeur->demandes()->where('type', '=', 'recrutement')->get() as $p)
                                @php
                                    if(is_null($p->projet)) continue;
                                @endphp
                                <div class="list-group-item suivi-projets">

                                    <div class="d-flex align-items-center">
                                        <div class="badge badge-secondary mr-3">
                                            <strong>#{{ $p->projet->numero }}</strong>
                                        </div>
                                        <div class="content">
                                            <h5 class="pt-2"><a href="{{ action('ProjetController@edit', $p->projet_id) }}" target="_blank" class="pr-3">{{ $p->projet->titre }}</a></h5>
                                        </div>
                                    </div>


                                        <div class="d-flex align-items-top">


                                                <div class="content mb-3">
                                                    {{ $p->employeur->nom }}

                                                    <div class="progress-bar-container mt-1">
                                                        <span class="progress-bar" style="width:{{ demandeProgression($p->statut, STATUTS_DEMANDE_REC) }}"></span>
                                                    </div>

                                                    <small>{{ demandeStatuts($p->statut, STATUTS_DEMANDE_REC) }} <br> <i>{{ $p->candidats()->count() }} sur {{ $p->nb_candidat }} candidats requis ({{$p->postes()}})</i></small>

                                                </div>

                                        </div>



                                </div>
                            @endforeach
                        </div>

                        <div class="card-body">
                                <h5 class="mt-3">{{ __("Immigration") }}</h5>
                                @if (!$employeur->demandes()->where('type', '=', 'immigration')->count())
                                <p class="text-muted opacity-50"><i>Aucun projet d'immigration n'a été associé à ce compte. </i></p>
                            @endif
                        </div>

                        <div class="list-group list-group-flush ">
                            @foreach ($employeur->demandes()->where('type', '=', 'immigration')->get() as $p)
                                @php
                                    if(is_null($p->projet)) continue;
                                @endphp
                                <div class="list-group-item suivi-projets">

                                    <div class="d-flex align-items-center">
                                        <div class="badge badge-danger mr-3">
                                            <strong>#{{ $p->projet->numero }}</strong>
                                        </div>
                                        <div class="content">
                                            <h5 class="pt-2"><a href="{{ action('ProjetController@edit', $p->projet_id) }}" target="_blank" class="pr-3">{{ $p->projet->titre }}</a></h5>
                                        </div>
                                    </div>


                                        <div class="d-flex align-items-top">


                                                <div class="content mb-3">
                                                    {{ $p->employeur->nom }}

                                                    <div class="progress-bar-container mt-1">
                                                        <span class="progress-bar" style="width:{{ demandeProgression($p->statut) }}"></span>
                                                    </div>

                                                    <small>{{ demandeStatuts($p->statut) }} </small>

                                                </div>

                                        </div>



                                </div>
                            @endforeach
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection


@section('footer')

    <script>

        var user_role = '{{ Auth::user()->role_lvl }}';

        $(document).on('change', '#has_secondary_contact_switch', function(e){
            toggleSecondary();
        });

        $(document).on('change', '#has_third_contact_switch', function(e){
            toggleThird();
        });

        function toggleSecondary(){
            if($('#has_secondary_contact_switch').is(":checked")){
                $('.secondary_contact').show();
            }else{
                $('.secondary_contact').hide();
            }
        }

        function toggleThird(){
            if($('#has_third_contact_switch').is(":checked")){
                $('.third_contact').show();
            }else{
                $('.third_contact').hide();
            }
        }

        toggleSecondary();
        toggleThird();

        if(user_role == 3) {
            $('.employer-frm :input').prop('disabled', true)
        }
    </script>

@endsection
