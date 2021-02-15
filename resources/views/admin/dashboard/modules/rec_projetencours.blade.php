<div class="card ">
    <div class="card-header">
        <div class="card-title">Mandat en cours</div>
        <small>Liste de projet en recrutement avec une date de création, mais pas de date de sélection.</small>
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
                    $projets = rec_projetsencours();
                @endphp
                @foreach ($projets as $p)
                    <tr>
                        <td><a href="{{ action('ProjetController@edit', $p->id) }}" class="btn btn-sm btn-secondary">{{ $p->numero }}</a></td>
                        <td>{{ $p->employeur->nom }}</td>
                        <td style="line-height:14px">
                            <p class="mb-0">{{ $p->date_creation }}</p>
                            <small>{{ \Carbon\Carbon::parse($p->date_creation)->diffForHumans() }}</small>
                        </td>
                    </tr>
                @endforeach
                @if (count($projets) == 0)

                    <tr>
                        <td colspan="4" class="text-center"><i>Aucun mandat en cours</i></td>
                    </tr>

                @endif
            </tbody>
        </table>
    </div>
</div>
