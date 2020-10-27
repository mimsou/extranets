<div class="card mt-3 col-12">
    <div class="card-body px-1 py-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="searchBy-name">
                    <div class="badge badge-soft-secondary mr-3"><small>#{{ $p->numero }}</small></div><a href="{{ action('CandidatController@edit', $p->id) }}" target="_blank">{{ $p->nom }}</a>
                </h5>

            </div>

            <div class="text-muted text-center m-b-10 d-flex">
                <div class="dropdown ml-3">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon mdi  mdi-dots-vertical"></i> </a>

                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(18px, 25px, 0px);">

                        <button class="dropdown-item" type="button"><a href="{{ action('CandidatController@edit', $p->id) }}" target="_blank">Fiche du candidat</a></button>
                        {{-- <button class="dropdown-item editparticipant" type="button" data-type="" data-pid="{{ $p->id }}">Modifier le participant</button> --}}
                        <div class="dropdown-divider"></div>
                    <button class="dropdown-item delete_participant" data-pid="{{$p->id}}" type="button"><a href="{{ action('ProjetController@removeCandidat', [$projet->id, base64_encode($p->id)]) }}">Retirer le candidat du projet</a></button>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-between">
            <div class="text-muted">
                <i class="fas fa-hammer mr-2 ml-1"></i> {{ (!is_null($p->emploi))?$p->emploi->title:'NA' }}
            </div>

            <div class="text-muted">
                {!! $p->statutIconHTML() !!} {{ $p->statutReadable() }}
            </div>
        </div>

        <div class="text-center mt-2 text-muted"><small>En attente documents immigration</small></div>
        <hr class="mb-0 mt-0">
        <div class="time-progresssion mb-2">
            <div class="progression text-right" id="part_prog_{{ $p->id }}" style="transition: all 0.5s ease; background-color: aquamarine; width:50%; height:3px"></div>
        </div>
    </div>
</div>
