<div class="card mb-3">
    <div class="card-header">
        <div class="card-title">Demandes Permis de travail</div>
        <small>Liste des demandes de PT envoyés mais sans date de réception, qui sont en traitement depuis plus de 4 mois.</small>
    </div>

    <div class="card-body">
        <table id="imm_demandepermis_enattente" class="table" style="width:100%">
            <thead>
                <tr>
                    <th>#Projet</th>
                    <th>Candidat</th>
                    <th>Envoyé le</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $demandes = imm_demandePermisTravail_enattente(4);
                @endphp
                @foreach ($demandes as $d)
                    <tr>
                        <td><a href="{{ action('ProjetController@edit', $d->projet_id) }}" class="btn btn-sm btn-danger">{{ $d->numero }}</a></td>
                        <td><a href="{{ action('CandidatController@edit', $d->c_id) }}">{{ $d->name }}</a></td>
                        <td style="line-height:14px">
                            <p class="mb-0">{{ \Carbon\Carbon::parse($d->permis_date_envoi)->format('Y-m-d') }}</p>
                            <small>{{ \Carbon\Carbon::parse($d->permis_date_envoi)->diffForHumans() }}</small>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
