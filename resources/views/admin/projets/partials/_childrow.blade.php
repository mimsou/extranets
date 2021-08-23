<table cellpadding="1" cellspacing="0" border="0" width="100%">
    <tr>
        <td>
            @if (!count($projet->demandes))
                <i class="text-muted">Aucune demande dans ce projet</i>
            @else
                <table width="100%" class="child-row-table">
                    @if($statut_du_dossier != null && $statut_du_dossier != 'ALL')
                        @if(in_array($statut_du_dossier,['IMMIGRATION','RECRUTEMENT']))
                            @php
                                $demandeStatuArray = [];
                                $demandeStatuArray['IMMIGRATION'] = demandeStatuts();
                                $demandeStatuArray['RECRUTEMENT'] = demandeStatuts(null,STATUTS_DEMANDE_REC);
                                $statut_du_dossier = array_keys($demandeStatuArray[$statut_du_dossier]);
                                $demandes = $projet->demandes->whereIn('statut',$statut_du_dossier);
                            @endphp
                        @else
                            @php
                                $demandes = $projet->demandes->where('statut',$statut_du_dossier);
                            @endphp
                        @endif
                    @else
                        @php
                            $demandes = $projet->demandes;
                        @endphp
                    @endif
                    @if($isCompletedChecked == false || $isCompletedChecked == 'false')
                        @php
                          $demandes = $demandes->where('completed','!=',1);
                        @endphp
                    @endif

                    @if($isHourlyChecked != false && $isHourlyChecked != 'false')
                        @php
                            $demandes = $demandes->where('facturation_horaire','on');
                        @endphp
                    @endif
                    @foreach ($demandes as $d)
                        @php
                            $type = ($d->type == 'recrutement')?STATUTS_DEMANDE_REC:null;
                        @endphp
                        <tr>
                            <td width="200px">
                                <div class="pl-3">
                                    @if($d->type == 'accueil')
                                        <small>{{ AccueilDemandeStatus($d->statut) }}</small>
                                    @else
                                        <small>{{ demandeStatuts($d->statut, $type) }}</small>
                                    @endif
                                    <hr class="mb-0 mt-0">
                                    <div class="time-progresssion mb-2">
                                        @if($d->type == 'accueil')
                                            <div class="progression text-right" id="part_prog_{{ $d->id }}"
                                             style="transition: all 0.5s ease; background-color: aquamarine; width:{{ demandeAccueilProgression($d->statut) }}; height:3px"></div>
                                        @else
                                            <div class="progression text-right" id="part_prog_{{ $d->id }}"
                                                 style="transition: all 0.5s ease; background-color: aquamarine; width:{{ demandeProgression($d->statut, $type) }}; height:3px"></div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td width="30%">
                                <div class="pl-5 mr-4">
                                    @if ($d->facturation_horaire == 'on')
                                        <i class="fas fa-stopwatch text-muted opacity-50"
                                           style="font-size: 16px;line-height: 19px;" data-toggle="tooltip"
                                           data-placement="top" title="Facturation horaire"></i>
                                    @endif
                                    {{ $d->employeur->nom }}
                                </div>
                            </td>
                            <td width="100"><small>{{ $d->candidats()->wherePivot('statut', 'approved')->count() }}
                                    candidats
                                    sur {{ $d->nb_candidat }} requis</small></td>
                            @if(Auth::user()->role_lvl > 3)
                                <td width="150px">
                                    @if($d->todo_groups()->get()->isEmpty())
                                        <div class="todo-strip in-active ml-3">
                                            <i class="fas fa-plus create-todo bg-white"
                                               data-project-id="{{ $projet->id }}"
                                               data-demande-id="{{ $d->id }}"></i>
                                            <label>liste de contrôle</label>
                                        </div>
                                    @else
                                        @php($completedTodos = App\Models\TodoGroup::getCompletedTodos($d->projet_id,$d->id))
                                        @php($totalTodos = App\Models\TodoGroup::getTotalTodos($d->projet_id,$d->id))
                                        <div class="todo-strip ml-3">
                                            <i class="fas fa-check add-todo {{ ($completedTodos == $totalTodos)?'bg-aqua':'bg-white' }}"
                                               data-project-id="{{ $projet->id }}" data-demande-id="{{ $d->id }}"></i>
                                            <label><span
                                                    class="demande-completed-todos">{{ $completedTodos }}</span>
                                                complété sur <span
                                                    class="demande-total-todos">{{ $totalTodos }}</span></label>
                                        </div>
                                    @endif
                                </td>
                            @endif
                            <td width="100">
                                <div class="assigned-users mr-3">
                                    @foreach($d->assignedUsers()->get() as $key => $user)
                                        <div class="avatar avatar-xs add-new-assignee ml-1">
                                            <span
                                                class="avatar-title rounded-circle bg-grey">{{ $user->initials() }}</span>
                                        </div>
                                    @endforeach
                                </div>

                            </td>
                        <tr>
                    @endforeach
                </table>
            @endif

        </td>
    </tr>
</table>

