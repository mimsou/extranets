<div class="row d-block d-md-flex">
    <div class="col m-b-30">
        <div class="card">

            <div class="card-body">
                <div class="card-controls">
                    {{-- <a href="#" class="badge badge-soft-success"> <i class="mdi mdi-arrow-up"></i> 12%</a> --}}
                </div>
                <div class="text-center p-t-30 p-b-20">
                    <div class="text-overline text-muted opacity-75 pb-2">Candidats disponibles</div>
                    <h1 class="text-success">{{ \App\Models\Candidat::where('statut', 'disponible')->count() }}</h1>
                    {{-- <div class="text-success h5 fw-600">
                        <i class="mdi mdi-arrow-up"></i> 12.6%
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="col m-b-30">
        <div class="card ">

            <div class="card-body">
                <div class="card-controls">
                    {{-- <a href="#" class="badge badge-soft-success"> <i class="mdi mdi-arrow-up"></i> 12%</a> --}}
                </div>
                <div class="text-center p-t-30 p-b-20">
                    <div class="text-overline text-muted opacity-75 pb-2">Nombre de projets en cours</div>
                    <h1 class="text-muted">{{ \App\Models\Projet::whereNotIn('statut', ['fermer'])->orderBy('titre','asc')->count() }}</h1>
                    {{-- <div class="text-muted h5 fw-600">
                        <i class="mdi mdi-arrow-up"></i> 0%
                    </div> --}}
                </div>
            </div>

        </div>
    </div>




</div>
