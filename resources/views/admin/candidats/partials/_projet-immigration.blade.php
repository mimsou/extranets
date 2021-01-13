<div class="card mt-3 mb-4 col-12">
    <div class="card-body px-1 py-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="searchBy-name">
                    <div class="badge badge-soft-secondary mr-3"><small>#{{ $p->projet->numero }}</small></div><a href="{{ action('ProjetController@edit', $p->projet_id) }}" target="_blank" class="pr-3">{{ $p->projet->titre }}</a>
                </h5>

            </div>

            <div class="text-muted text-center m-b-10 d-flex">
                <div class="dropdown ml-3">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon mdi  mdi-dots-vertical"></i> </a>

                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(18px, 25px, 0px);">

                        <button class="dropdown-item" type="button"><a href="{{ action('ProjetController@edit', $p->projet_id) }}" target="_blank">Fiche du projet</a></button>
                        {{-- <button class="dropdown-item editparticipant" type="button" data-type="" data-pid="{{ $p->id }}">Modifier le participant</button> --}}
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item delete_participant" data-pid="{{$p->id}}" type="button"><a href="{{ action('ProjetController@removeCandidat', [$p->id, base64_encode($candidat->id)]) }}">Retirer le candidat du projet</a></button>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-between">
            <div class="text-muted">
                <i class="fas fa-user-tie mr-2 ml-1"></i> {{ (!is_null($p->employeur))?$p->employeur->nom:'NA' }}
            </div>

            <div class="text-muted">

            </div>

            <div class="text-muted">
                <i class="fas fa-calendar-edit mr-2 ml-1"></i> {{ $p->date_debut_mandat }}
            </div>
        </div>





        <div class="text-center mt-2 text-muted"><small>{{ demandeStatuts($p->statut) }}</small></div>
        <hr class="mb-0 mt-0">
        <div class="time-progresssion mb-2">
            <div class="progression text-right" id="part_prog_{{ $p->id }}" style="transition: all 0.5s ease; background-color: aquamarine; width:{{ demandeProgression($p->statut) }}; height:3px"></div>
        </div>


        <div class="d-flex justify-content-between mt-4">
            <div class="text-muted">
                <h5 class="pb-0 mb-2">CONTACT</h5>
                <i class="fas fa-user mr-2 ml-1"></i> {{ $p->contact_prenom }} {{ $p->contact_nom }} <br>
                <small><i class="fas fa-phone mr-2 ml-1"></i> <a href="tel:{{ $p->contact_phone }}">{{ $p->contact_phone }} {{ (!empty($p->contact_ext)?'#'.$p->contact_ext: '') }}</a><br>
                    <i class="fas fa-envelope mr-2 ml-1"></i> <a href="mailto:{{ $p->contact_email }}">{{ $p->contact_email }}</a></small>
            </div>
            <div class="text-muted">
                <h5 class="pb-0 mb-2 text-success">EIMT</h5>
                <small>
                    <div class="d-flex">
                        <div class="dates">
                            <p class="m-0 p-0 pr-3"><i>Envoi</i></p>
                            <p class="m-0 p-0 pr-3"><i>Acc. Réc.</i></p>
                            <p class="m-0 p-0 pr-3"><i>Réception</i></p>
                            <p class="m-0 p-0 pr-3"><i>Échéance</i></p>
                        </div>
                        <div class="values">
                            <p class="m-0 p-0">{{ (empty($p->eimt_date_envoi))?'---- / -- / --' : $p->eimt_date_envoi }}</p>
                            <p class="m-0 p-0">{{ (empty($p->eimt_date_accuse_rec))?'---- / -- / --' : $p->eimt_date_accuse_rec }}</p>
                            <p class="m-0 p-0">{{ (empty($p->eimt_date_reception))?'---- / -- / --' : $p->eimt_date_reception }}</p>
                            <p class="m-0 p-0">{{ (empty($p->eimt_date_echeance))?'---- / -- / --' : $p->eimt_date_echeance }}</p>
                        </div>
                    </div>
                </small>
            </div>
            <div class="text-muted">
                <h5 class="pb-0 mb-2 text-secondary">DST</h5>
                <small>
                    <div class="d-flex">
                        <div class="dates">
                            <p class="m-0 p-0 pr-3"><i>Envoi</i></p>
                            <p class="m-0 p-0 pr-3"><i>Acc. Réc.</i></p>
                            <p class="m-0 p-0 pr-3"><i>Réception</i></p>
                            <p class="m-0 p-0 pr-3"><i>Échéance</i></p>
                        </div>
                        <div class="values">
                            <p class="m-0 p-0">{{ (empty($p->dst_date_envoi))?'---- / -- / --' : $p->dst_date_envoi }}</p>
                            <p class="m-0 p-0">{{ (empty($p->dst_date_accuse_rec))?'---- / -- / --' : $p->dst_date_accuse_rec }}</p>
                            <p class="m-0 p-0">{{ (empty($p->dst_date_reception))?'---- / -- / --' : $p->dst_date_reception }}</p>
                            <p class="m-0 p-0">{{ (empty($p->dst_date_echeance))?'---- / -- / --' : $p->dst_date_echeance }}</p>
                        </div>
                    </div>
                </small>
            </div>
        </div>

        {{-- <div class="text-center mt-2 text-muted"><small>En attente documents immigration</small></div>
        <hr class="mb-0 mt-0">
        <div class="time-progresssion mb-2">
            <div class="progression text-right" id="part_prog_{{ $p->id }}" style="transition: all 0.5s ease; background-color: aquamarine; width:50%; height:3px"></div>
        </div> --}}
    </div>
</div>
