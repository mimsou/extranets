<!-- Modal -->
<div class="modal fade" id="todo-template-modal" tabindex="-1" role="dialog"
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
                        <h2 class="mt-3">Ajouter une liste de contrôle</h2>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12 form-group">
                       <label>Créer une liste depuis un gabarit?</label>
                        {!! Form::select('templates',$todoTemplates,null,['class'=>'form-control selected-template']) !!}
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success btn-block create-todo-list" data-projet-id="{{ $request->projet_id }}" data-demande-id="{{ $request->demande_id }}">AJOUTER</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
