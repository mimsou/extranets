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
                            <td width="340px">
                                <div class="pl-3">
                                    <small>{{ demandeStatuts($d->statut, $type) }}</small>
                                    <hr class="mb-0 mt-0">
                                    <div class="time-progresssion mb-2">
                                        <div class="progression text-right" id="part_prog_{{ $d->id }}" style="transition: all 0.5s ease; background-color: aquamarine; width:{{ demandeProgression($d->statut, $type) }}; height:3px"></div>
                                    </div>
                                </div>
                            </td>
                            <td width="40%">
                                <div class="pl-5">
                                    @if ($d->facturation_horaire == 'on')
                                        <i class="fas fa-stopwatch text-muted opacity-50" style="font-size: 16px;line-height: 19px;" data-toggle="tooltip" data-placement="top" title="Facturation horaire"></i>
                                    @endif
                                    {{ $d->employeur->nom }}
                                </div>
                            </td>
                            <td><small>{{ $d->candidats()->wherePivot('statut', 'approved')->count() }} candidats sur {{ $d->nb_candidat }} requis</small></td>
                            @if(Auth::user()->role_lvl > 3)
                                <td>
                                    @if($d->todos()->get()->isEmpty())
                                        <div class="todo-strip in-active">
                                            <i class="fas fa-plus create-todo" data-project-id="{{ $projet->id }}" data-demande-id="{{ $d->id }}"></i>
                                            <label>liste de contrôle</label>
                                        </div>
                                    @else
                                        <div class="todo-strip">
                                            <i class="fas fa-check add-todo" data-project-id="{{ $projet->id }}" data-demande-id="{{ $d->id }}"></i>
                                            <label><span class="demande-completed-todos">{{ $d->todos()->where(['status'=>1])->count() }}</span> complété sur <span class="demande-total-todos">{{ $d->todos()->count() }}</span></label>
                                        </div>
                                    @endif
                                </td>
                            @endif
                        <tr>
                    @endforeach
                </table>
            @endif

        </td>
    </tr>
</table>

