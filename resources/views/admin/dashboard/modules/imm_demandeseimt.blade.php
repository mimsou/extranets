<div class="card ">
    <div class="card-header">
        <div class="card-title">Demandes EIMT</div>
        <small>Liste des projets créés il y a plus d'un mois pour lesquels la demande d'EIMT n'a pas encore été envoyée</small>
    </div>

    <div class="card-body">
        <table id="datatable" class="table" style="width:100%">
            <thead>
                <tr>
                    <th>#Projet</th>
                    <th>Client</th>
                    <th>Date création</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $demandes = imm_demandeEIMT();
                @endphp
                @foreach ($demandes as $d)
                    <tr>
                        <td><a href="{{ action('ProjetController@edit', $d->projet_id) }}" class="btn btn-sm btn-secondary">{{ $d->numero }}</a></td>
                        <td>{{ $d->nom }}</td>
                        <td style="line-height:14px">
                            <p class="mb-0">{{ $d->date_creation }}</p>
                            <small>{{ \Carbon\Carbon::parse($d->date_creation)->diffForHumans() }}</small>
                        </td>
                    </tr>
                @endforeach
                @if (count($demandes) == 0)

                    <tr>
                        <td colspan="4" class="text-center"><i>Aucun mandat en cours</i></td>
                    </tr>

                @endif
            </tbody>
        </table>
    </div>
</div>
