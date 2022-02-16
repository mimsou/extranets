<div class="modal fade"   id="addDemande" data-backdrop="static"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="px-3 pt-3 text-center">
                    <div class="event-type info">
                        <div class="event-indicator ">
                            <i class="fas fa-file-check text-white" style="font-size: 30px"></i>
                        </div>
                    </div>
                    {!! Form::open(['action' => array('ProjetController@addDemande', $projet->id)]) !!}

                        {!! Form::hidden('projet_id', $projet->id) !!}
                        {!! Form::hidden('type', 'immigration') !!}

                        <h3 class="pt-3 ">{{ __("Ajouter une nouvelle demande") }}</h3>
                        @include('admin.projets.modals._demandeForm')
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
