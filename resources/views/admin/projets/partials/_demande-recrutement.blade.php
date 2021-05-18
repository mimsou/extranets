<div class="card mb-5 col-12">
    <div class="card-body px-1 py-3">
        <div class="d-flex justify-content-between">
            <div>
                <div><small class="badge badge-secondary mr-1 mb-3"><strong>RECRUTEMENT</strong></small>
                    @if ($p->facturation_horaire == 'on')
                        <i class="fas fa-stopwatch text-muted opacity-50"
                           style="font-size: 16px;line-height: 19px; position: relative; top: -7px;"
                           data-toggle="tooltip" data-placement="top" title="Facturation horaire"></i>
                    @endif
                    @php
                        $todos = $p->getTodos();
                    @endphp
                    @if($todos->count() > 0)
                        <i class="fas fa-list create-demande-todo demande-todo" data-project-id="{{ $p->projet_id }}" data-demande-id="{{ $p->id }}"></i>
                    @else
                        <i class="fas fa-list text-gray-400 demande-todo new-demande-from-template" data-project-id="{{ $p->projet_id }}" data-demande-id="{{ $p->id }}"></i>
                    @endif
                </div>
                <h3 class="searchBy-name">
                    <a href="{{ action('EmployeurController@edit', $p->employeur_id) }}"
                       target="_blank">{{ $p->employeur->nom }}</a>
                </h3>
                @if(Auth::user()->role_lvl > 3)
                    <div class="assignee">
                        <div class="assigned-users">
                            <div class="avatar avatar-sm add-new-assignee cursor-pointer">
                                <span class="avatar-title rounded-circle"> <i class="mdi mdi-account-plus"></i></span>
                            </div>
                            @foreach ($p->assignedUsers()->get() as $user)
                                <div class="avatar avatar-sm ml-1">
                                    <span data-id="{{ $user->id }}" data-demand-id="{{ $p->id }}"
                                          class="remove_assignee avatar-title rounded-circle bg-dark">{{ $user->initials() }} <i
                                            class="fas fa-times remove_assignee_icon"></i></span>
                                </div>
                            @endforeach
                        </div>
                        <div class="add-new-assignee-wrapper mt-2" style="display: none">
                            <select class="form-control assign_demande select2" data-demande-id="{{ $p->id }}" name="assign_user">
                                <option></option>
                                @foreach(\App\Models\User::whereIn('role_lvl', [10, 5])->get() as $user)
                                    <option value="{{ $user['id'] }}"> {{ $user['full_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-muted text-center m-b-10 d-flex">
                {{ $p->postes() }}
                <div class="dropdown ml-3">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                            class="icon mdi  mdi-dots-vertical"></i> </a>

                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                         style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(18px, 25px, 0px);">

                        {{-- <button class="dropdown-item" type="button"><a href="{{ action('CandidatController@edit', $p->id) }}" target="_blank">Fiche du candidat</a></button> --}}
                        <button class="dropdown-item editdemande" type="button" data-demandeid="{{ $p->id }}">
                            @if(Auth::user()->role_lvl == 3)
                                Afficher les détails
                            @else
                                Modifier les paramètres de la demande
                            @endif
                        </button>
                        @if(Auth::user()->role_lvl > 3)
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item delete_demande" data-demandeid="{{$p->id}}" type="button">
                                <a href="{{ action('ProjetController@removeDemande', [$projet->id, base64_encode($p->id)]) }}">Supprimer
                                    la demande du projet</a>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>


        <div class="text-center  text-muted"><small>{{ demandeStatuts($p->statut, STATUTS_DEMANDE_REC) }}</small></div>
        <hr class="mb-0 mt-0">
        <div class="time-progresssion mb-2">
            <div class="progression text-right" id="part_prog_{{ $p->id }}"
                 style="transition: all 0.5s ease; background-color: aquamarine; width:{{ demandeProgression($p->statut, STATUTS_DEMANDE_REC) }}; height:3px"></div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <div class="text-muted">
                <h5 class="pb-0 mb-2">CONTACT</h5>
                <i class="fas fa-user mr-2 ml-1"></i> {{ $p->contact_prenom }} {{ $p->contact_nom }} <br>
                <small><i class="fas fa-phone mr-2 ml-1"></i> <a
                        href="tel:{{ $p->contact_phone }}">{{ $p->contact_phone }} {{ (!empty($p->contact_ext)?'#'.$p->contact_ext: '') }}</a><br>
                    <i class="fas fa-envelope mr-2 ml-1"></i> <a
                        href="mailto:{{ $p->contact_email }}">{{ $p->contact_email }}</a></small>
            </div>
            <div class="text-muted">
                <h5 class="pb-0 mb-2 text-success">DATES IMPORTANTES</h5>
                <small>
                    <div class="d-flex">
                        <div class="dates">
                            <p class="m-0 p-0 pr-3"><i>Date de la signature du contrat de travail</i></p>
                        </div>
                        <div class="values">
                            <p class="m-0 p-0">{{ (empty($p->date_debut_mandat))?'---- / -- / --' : $p->date_debut_mandat }}</p>
                        </div>
                    </div>
                </small>
            </div>

        </div>

        <div class="d-flex justify-content-between mt-5">
            <div>
                <h4 class="mb-0 pb-0">Candidats</h4>
                <small>{{ $p->candidats()->wherePivot('statut', 'approved')->count() }} sur {{ $p->nb_candidat }}
                    candidats requis</small>
            </div>
            @if(Auth::user()->role_lvl > 3)
                <div>
                    <button class="btn btn-sm btn-primary addCandidat" data-demandeid="{{$p->id}}">AJOUTER UN CANDIDAT
                    </button>
                </div>
            @endif
        </div>

        @foreach ($p->candidats as $c)
            @include('admin.projets.partials._candidat', ['p'=>$c, 'demande'=>$p])
        @endforeach

        @php
            $nb_to_fill = $p->nb_candidat - $p->candidats()->wherePivot('statut', 'approved')->count();
        @endphp

        @for ($i = 0; $i < $nb_to_fill; $i++)
            <div class="empty-spot my-3"></div>
        @endfor
        @if(Auth::user()->role_lvl > 3)
            @php($notes = $p->getNotes()->sortByDesc('id'))
            @php($scope = \Illuminate\Support\Str::random(10))
            <div id="{{ $scope }}" class="comment-section">
                @include('admin.partials._comments',['demande'=>$p,'notes'=> $notes])
            </div>
        @endif
    </div>
</div>
