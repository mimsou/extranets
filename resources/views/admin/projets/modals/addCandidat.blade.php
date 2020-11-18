<div class="modal fade"   id="addCandidat" data-backdrop="static"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="px-3 pt-3 text-center">
                    <div class="event-type info">
                        <div class="event-indicator ">
                            <i class="fas fa-users-medical text-white" style="font-size: 30px"></i>
                        </div>
                    </div>
                    <h3 class="pt-3 ">{{ __("Ajouter un candidat") }}</h3>

                    <hr>
                    {!! Form::open(['action' => array('ProjetController@addCandidat', $projet->id)]) !!}
                        {!! Form::hidden('demande_id', null, ['id'=>'modal_demande_id']) !!}
                        <div class="text-left">

                            <div class="form-group">
                                <label for="user_id">{{ __('Formateur') }}</label>
                                {{ Form::select('user_id', \App\Models\Candidat::orderBy('nom', 'asc')->pluck('nom', 'id'), null, ['class'=>'form-control text-center select2_candidats', 'id'=>'user_id', "style"=>"width:100%", 'placeholder'=>'Choisir candidat']) }}
                            </div>

                        </div>

                        <button type="submit" class="btn btn-lg btn-success btn-block mb-3">{{__('AJOUTER')}}</button>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
