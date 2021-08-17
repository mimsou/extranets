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
                        {!! Form::hidden('tt_projet_id', $projet->id) !!}
                        <!-- TASK TYPE -->
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="statut">Type de tâche *</label>
                                <select class="form-control" required="" name="tt_task_type">
                                    <option value="" disabled selected>Choisir</option>
                                    @foreach(\App\Models\Enum\TaskType::all() as $task)
                                    <option value="{!! $task !!}" >{!! $task !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- User Selection (if Super-Admin) -->
                        @if(is_super_admin_user())
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="statut">Utilisateur</label>
                                {!! Form::select('tt_user_id', $users, null, ['class'=>'form-control', 'required']) !!}
                            </div>
                        </div>
                        @else
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="statut">Utilisateur: {!! Auth::user()->fullname !!}</label>
                                    {!! Form::hidden('tt_user_id', Auth::user()->id) !!}
                                </div>
                            </div>
                        @endif
                        <!-- Duration -->
                        <div class="form-group">
                            <label class="form-label">Durée *</label>
                            <input type="text" id="tt_duration" name="tt_duration" required class="form-control"
                                   data-mask="00:00"
                                   data-mask-clearifnotmatch="true"
                                   placeholder="01:30"
                                   autocomplete="off"
                                   maxlength="5">
                        </div>
                        <!-- Description -->
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="statut">Description</label>
                                {!! Form::textarea('tt_description',null,[
                                    'class' => 'form-control',
                                    'placeholder' => 'Entrez la description',
                                    'rows' => 4,
                                    'id' => 'tt_description',
                                    'maxlength' => 200,
                                    'style' => 'resize: none'
                                ]) !!}
                                <span class="pull-right label label-default" id="count_message"></span>
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