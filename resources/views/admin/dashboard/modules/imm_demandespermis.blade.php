<div class="card mb-3">
    <div class="card-header">
        <div class="card-title">Demandes Permis de travail</div>
        <small>Liste des projets ayant une date de réception d'EIMT depuis plus de 14 jours mais pas de date d'envoi de permis de travail</small>
    </div>

    <div class="card-body">
        <table id="imm_demandepermis" class="table" style="width:100%">
            <thead>
                <tr>
                    <th>#Projet</th>
                    <th>Client</th>
                    <th>Date création</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $demandes = imm_demandePermisTravail();
                @endphp
                @foreach ($demandes as $d)
                    <tr>
                        <td><a href="{{ action('ProjetController@edit', $d->projet_id) }}" class="btn btn-sm btn-danger">{{ $d->numero }}</a></td>
                        <td>{{ $d->nom }}</td>
                        <td style="line-height:14px">
                            <p class="mb-0">{{ \Carbon\Carbon::parse($d->date_creation)->format('Y-m-d') }}</p>
                            <small>{{ \Carbon\Carbon::parse($d->date_creation)->diffForHumans() }}</small>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
