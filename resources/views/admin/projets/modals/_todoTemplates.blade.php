<!-- Modal -->
<div class="modal fade" id="todo-template-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="px-3 pt-3 text-center">
                    <div class="event-type info">
                        <div class="event-indicator ">
                            <i class="fas fa-check text-white" style="font-size: 40px"></i>
                        </div>
                    </div>
                    <h3 class="pt-3">Ajouter une liste de contrôle</h3>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Créer une liste depuis un gabarit?</label>
                        {!! Form::select('templates',$todoTemplates,null,['class'=>'form-control selected-template']) !!}
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-success btn-block create-todo-list"
                                data-projet-id="{{ $request->projet_id }}" data-demande-id="{{ $request->demande_id }}">
                            AJOUTER
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
