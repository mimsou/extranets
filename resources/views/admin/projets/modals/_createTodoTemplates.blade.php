<!-- Modal -->
<div class="modal fade" id="create-todo-template-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="close position-static" data-dismiss="modal"aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <i class="fas fa-check todo-tick"></i>
                        <h2 class="mt-3">Créer un nouveau modèle</h2>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12 form-group">

                       <label>Entrez le nom du modèle</label>
                        <input type="text" class="form-control template-name" value="" />
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success btn-block save-template" data-project-id="{{ $request->project_id }}" data-demande-id="{{ $request->demande_id }}">Enregistrer le modèle</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
