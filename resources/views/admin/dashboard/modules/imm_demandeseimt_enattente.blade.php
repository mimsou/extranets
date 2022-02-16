<div class="card mb-3">
    <div class="card-header">
        <div class="card-title">Demandes EIMT latentes</div>
        <small>Liste des demandes envoyées mais sans date de réception, en traitement depuis plus de 4 mois.</small>
    </div>

    <div class="card-body">
        <table id="demandes_eimt_enattente" class="table" style="width:100%">
            <thead>
                <tr>
                    <th>#Projet</th>
                    <th>Client</th>
                    <th>Envoyé le</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $demandes = imm_demandeEIMT_enattente(4);
                @endphp
                @foreach ($demandes as $d)
                    <tr>
                        <td><a href="{{ action('ProjetController@edit', $d->id) }}" class="btn btn-sm btn-danger">{{ $d->numero }}</a></td>
                        <td>{{ $d->nom }}</td>
                        <td style="line-height:14px">
                            <p class="mb-0">{{ \Carbon\Carbon::parse($d->eimt_date_envoi)->format('Y-m-d') }}</p>
                            <small>{{ \Carbon\Carbon::parse($d->eimt_date_envoi)->diffForHumans() }}</small>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>


