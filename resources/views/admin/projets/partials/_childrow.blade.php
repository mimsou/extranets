<table cellpadding="1" cellspacing="0" border="0" width="100%">
    <tr>
        <td>
            @if (!count($projet->demandes))
                <i class="text-muted">Aucune demande dans ce projet</i>
            @else
                <table width="100%" class="child-row-table">
                    @foreach ($projet->demandes as $d)
                        @php
                            $type = ($d->type == 'recrutement')?STATUTS_DEMANDE_REC:null;
                        @endphp
                        <tr>
                            <td width="200px">
                                <div class="pl-3">
                                    <small>{{ demandeStatuts($d->statut, $type) }}</small>
                                    <hr class="mb-0 mt-0">
                                    <div class="time-progresssion mb-2">
                                        <div class="progression text-right" id="part_prog_{{ $d->id }}"
                                             style="transition: all 0.5s ease; background-color: aquamarine; width:{{ demandeProgression($d->statut, $type) }}; height:3px"></div>
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
                            <td width="100"><small>{{ $d->candidats()->wherePivot('statut', 'approved')->count() }} candidats
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
                                            <span class="avatar-title rounded-circle bg-grey">{{ $user->initials() }}</span>
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

