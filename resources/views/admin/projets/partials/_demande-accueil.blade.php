<div class="card mb-5 col-12">
    <div class="card-body px-1 py-3">
        <div class="d-flex justify-content-between edit-immigration">
            <div>
                <div class="badge-icon">
                    <small class="badge badge-success mr-1 mb-3"><strong>ACCUEIL</strong></small>
                    @if ($p->facturation_horaire == 'on')
                        <i class="fas fa-stopwatch text-muted opacity-50"
                           style="font-size: 16px;line-height: 19px; position: relative; top: -7px;"
                           data-toggle="tooltip" data-placement="top" title="Facturation horaire"></i>
                    @endif
                    @php
                        $todos = $p->getTodos();
                    @endphp
                </div>

                <h3 class="searchBy-name align-items-center d-flex">
                    @if(Auth::user()->role_lvl > 3)
                        <a href="{{ action('DemandeController@markAsCompletedOrIncomeplete', $p->id) }}" class="complete_demande" data-toggle="tooltip" data-placement="top" title="Marquer cette demande comme terminée">
                            <div class="avatar avatar-xs mr-2">
                                    <span class="avatar-title rounded-circle {{ (!$p->completed)?'bg-transparent border mt-1':'bg-success' }}">
                                        <i class="fas fa-check text-white font-weight-bold {{ (!$p->completed)?'hide-demande-tick-icon':'' }}"></i>
                                    </span>
                            </div>
                        </a>

                        <div class="spinner-grow spinner-grow loader" role="status" style="display: none">
                            <span class="sr-only">Loading...</span>
                        </div>
                    @endif

                    <a href="{{ action('EmployeurController@edit', $p->employeur_id) }}"
                       target="_blank">{{ $p->employeur->nom }}</a>
                </h3>

                @if(Auth::user()->role_lvl > 3)
                    <div class="assignee mb-3">
                        <div class="assigned-users d-flex">
                            <div class="avatar avatar-sm add-new-assignee cursor-pointer">
                                <span class="avatar-title rounded-circle"> <i class="mdi mdi-account-plus-outline add-admin-icon"></i></span>
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
{{--                {{ PROCEDURE_DEMANDE[$p->procedure] }}--}}
                <div class="dropdown ml-3">
                    <a href="#" class="d-flex flex-row-reverse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                            class="icon mdi  mdi-dots-vertical"></i> </a>
                    @php
                        $completedTodos = $p->todos()->where(['status'=>1])->count();
                        $totalTodos =$p->todos()->count();
                    @endphp
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
                    @if(auth()->user()->role_lvl > 3)
                        <div class="todo-strip {{ ($totalTodos == 0)?'in-active':'' }} ml-3 mt-5">
                            <i class="fas {{ ($totalTodos == 0)?'fa-plus create-todo':'fa-check add-todo' }} bg-white" data-project-id="{{ $p->projet_id }}" data-demande-id="{{ $p->id }}"></i>
                            <label><span class="demande-completed-todos">{{ $completedTodos }}</span>
                                complété sur <span class="demande-total-todos">{{ $totalTodos }}</span></label>
                        </div>
                    @endif
                </div>
            </div>

        </div>


        <div class="text-center  text-muted"><small>{{ AccueilDemandeStatus($p->statut) }}</small></div>
        <hr class="mb-0 mt-0">
        <div class="time-progresssion mb-2">
            <div class="progression text-right" id="part_prog_{{ $p->id }}"
                 style="transition: all 0.5s ease; background-color: aquamarine; width:{{ demandeAccueilProgression($p->statut) }}; height:3px"></div>
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
