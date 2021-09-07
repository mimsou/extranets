<div class="card mt-3 col-12 {{ $p->pivot->statut }}" style="background-color: #f4f7fb;">
    <div class="card-body px-1 py-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="searchBy-name">
                    @if($p->pivot->statut == 'removed')
                        <div class="badge badge-soft-danger mr-3">
                            <small>RETIRÉ</small>
                        </div>
                    @else
                        <div class="badge badge-soft-secondary mr-3">
                            <small>#{{ $p->numero }}</small>
                        </div>
                    @endif
                    <a href="{{ action('CandidatController@edit', $p->id) }}" target="_blank">{{ $p->nom }}</a>
                </h5>

            </div>

            @if(Auth::user()->role_lvl != 3)
                <div class="text-muted text-center m-b-10 d-flex">
                    <div class="dropdown ml-3">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon mdi  mdi-dots-vertical"></i> </a>

                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(18px, 25px, 0px);">

                            <button class="dropdown-item" type="button"><a href="{{ action('CandidatController@edit', $p->id) }}" target="_blank">Fiche du candidat</a></button>
                            {{-- <button class="dropdown-item editparticipant" type="button" data-type="" data-pid="{{ $p->id }}">Modifier le participant</button> --}}
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item delete_participant" data-pid="{{$p->id}}" type="button"><a href="{{ action('ProjetController@updateCandidat', [$demande->id, base64_encode($p->id), 'removed']) }}">Le candidat s'est désisté du projet</a></button>
                            <button class="dropdown-item delete_participant" data-pid="{{$p->id}}" type="button"><a href="{{ action('ProjetController@removeCandidat', [$demande->id, base64_encode($p->id)]) }}">Supprimer le candidat du projet</a></button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between">
            @if ($demande->type == 'immigration')
                <div class="text-muted">
                    <i class="fas fa-paper-plane mr-2 ml-1"></i> <i class="pr-2">Envoi</i>
                    {{ (!empty($p->permis_date_envoi))?$p->permis_date_envoi:'---- / -- / --' }}
                </div>

                <div class="text-muted">
                    <i class="fas fa-calendar-day mr-2 ml-1"></i> <i class="pr-2">Réception</i>
                    {{ (!empty($p->permis_date_reception))?$p->permis_date_reception:'---- / -- / --' }}
                </div>

                <div class="text-muted">
                    <i class="fas fa-alarm-clock mr-2 ml-1"></i> <i class="pr-2">Échéance</i>
                    {{ (!empty($p->permis_date_echeance))?$p->permis_date_echeance:'---- / -- / --' }}f
                </div>
            @elseif ($demande->type == 'recrutement')
                <div class="text-muted">
                    <i class="fas fa-calendar-day mr-2 ml-1"></i> <i class="pr-2">Date de sélection du travailleur</i>
                    {{ (!empty($p->date_selection))?$p->date_selection:'---- / -- / --' }}
                </div>
            @elseif ($demande->type == 'accueil')
                <div class="text-muted">
                    <i class="fas fa-calendar-day mr-2 ml-1"></i> <i class="pr-2">Date d’arrivée</i>
                    {{ (!empty($p->date_d_arrivee))?$p->date_d_arrivee:'---- / -- / --' }}
                </div>
            @endif

        </div>

        @if(Auth::user()->role_lvl > 2 && $demande->type != 'accueil')
            @if (!is_null($p->statut_pt) && $p->statut_pt != 'na' && $demande->type != 'recrutement')
                <div class="text-center mt-2 text-muted"><small>{{ permisTravailStatuts($p->statut_pt) }}</small></div>
                <hr class="mb-0 mt-0">
                <div class="time-progresssion mb-2">
                    <div class="progression text-right" style="transition: all 0.5s ease; background-color: aquamarine; width:{{ permisTravailProgression($p->statut_pt) }}; height:3px"></div>
                </div>
            @endif
        @endif
    </div>
</div>
