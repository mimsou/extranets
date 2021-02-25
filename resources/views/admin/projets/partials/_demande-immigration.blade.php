<div class="card mt-3 mb-5 col-12">
    <div class="card-body px-1 py-3">
        <div class="d-flex justify-content-between">
            <div>
                <div class="badge badge-danger mr-3 mb-3"><small><strong>IMMIGRATION</strong></small></div>
                <h3 class="searchBy-name">
                     <a href="{{ action('EmployeurController@edit', $p->employeur_id) }}" target="_blank">{{ $p->employeur->nom }}</a>
                </h3>
            </div>

            <div class="text-muted text-center m-b-10 d-flex">
                {{ PROCEDURE_DEMANDE[$p->procedure] }}
                <div class="dropdown ml-3">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon mdi  mdi-dots-vertical"></i> </a>

                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(18px, 25px, 0px);">

                        {{-- <button class="dropdown-item" type="button"><a href="{{ action('CandidatController@edit', $p->id) }}" target="_blank">Fiche du candidat</a></button> --}}
                        <button class="dropdown-item editdemande" type="button" data-demandeid="{{ $p->id }}">Modifier les paramètres de la demande</button>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item delete_demande" data-demandeid="{{$p->id}}" type="button">
                            <a href="{{ action('ProjetController@removeDemande', [$projet->id, base64_encode($p->id)]) }}">Supprimer la demande du projet</a>
                        </button>
                    </div>
                </div>
            </div>

        </div>


        <div class="text-center  text-muted"><small>{{ demandeStatuts($p->statut) }}</small></div>
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
                            <p class="m-0 p-0 pr-3"><i>Approbation</i></p>
                            <p class="m-0 p-0 pr-3"><i>Expiration</i></p>
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

        <div class="d-flex justify-content-between mt-5">
            <div>
                <h4 class="mb-0 pb-0">Candidats</h4>
                <small>{{ $p->candidats()->count() }} sur {{ $p->nb_candidat }} candidats requis</small>
            </div>

            <div><button class="btn btn-sm btn-primary addCandidat" data-demandeid="{{$p->id}}">AJOUTER UN CANDIDAT</button></div>
        </div>

        @foreach ($p->candidats as $c)
            @include('admin.projets.partials._candidat', ['p'=>$c, 'demande'=>$p])
        @endforeach

        @php
            $nb_to_fill = $p->nb_candidat - $p->candidats()->count();
        @endphp

        @for ($i = 0; $i < $nb_to_fill; $i++)
            <div class="empty-spot my-3"></div>
        @endfor
    </div>
</div>
