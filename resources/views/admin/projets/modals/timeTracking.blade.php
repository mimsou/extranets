<div class="modal fade modal-slide-right show"
     id="timeTracking" tabindex="-1" role="dialog"
     aria-labelledby="slideRightModalLabel" name="timeTracking"
     aria-modal="true" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slideRightModalLabel"><i class="fas fa-business-time fa-2x"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body bg-gray-100 card-scroll">
                <div class="card py-3 m-b-30">
                    <div class="card-body">
                        <h4 class="mb-3">Nouveau</h4>
                        {!! Form::open(['route' => ['time_tracking_store', 'id' => 4 ], 'id' => 'time_tracking_form']) !!}
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="statut">Type de tâche</label>
{{--                                {!! Form::select('statut', $statuts, null, ['class'=>'form-control', 'required']) !!}--}}
                                <select class="form-control" required="" name="statut">
                                    <option value="new_projet" selected="selected">Type de tâche</option>
                                    <optgroup label="Immigration">
                                        <option value="imm_eimt_dst_pt">Imm - EIMT-DST-PT</option>
                                        <option value="imm_eimt_dst_pt_ave">Imm - EIMT-DST-PT-AVE</option>
                                    </optgroup>
                                    <optgroup label="Recrutement">
                                        <option value="rec_mission_dedie">Rec - Mission dédiée</option>
                                        <option value="rec_mission_partagee">Rec - Mission partagée</option>
                                    </optgroup>
                                    <option value="acc_accueil">Acc - Accueil</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="statut">Utilisateur</label>
                                {!! Form::select('user', $users, null, ['class'=>'form-control', 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Durée *</label>
                            <input type="text" name="field-name" required class="form-control"
                                   data-mask="00:00"
                                   data-mask-clearifnotmatch="true"
                                   placeholder="01:30"
                                   autocomplete="off"
                                   maxlength="8">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="statut">Description</label>
                                {!! Form::textarea('notes',null,['class'=>'form-control','placeholder'=>'Entrez la note','rows'=>4]) !!}
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-cta mt-4">Enregistrer</button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="modal_edit_content">

                </div>
                <div class="modal_loading">
                    <div class="col-md-12 m-b-30">
                        <div class="fa-2x">
                           <i class="fas fa-spinner fa-pulse"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>