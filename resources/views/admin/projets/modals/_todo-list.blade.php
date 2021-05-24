<!-- Modal -->
<div class="modal fade" id="todo-list-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                    <h3 class="pt-3">Liste de contrôle</h3>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-7">
                        @php($numberOfCompleted = App\Models\TodoGroup::getCompletedTodos($projectId,$demandeId))
                        @php($numberOfTodos = App\Models\TodoGroup::getTotalTodos($projectId,$demandeId))
                        <small><span class="number-of-completed-todos">{{ $numberOfCompleted }}</span> complété sur
                            <span class="total-todos">{{ $numberOfTodos }}</span></small>
                        <div class="time-progresssion mb-2">
                            <div class="progression todo-progress text-right" id="part_prog_"
                                 style="transition: all 0.5s ease; background-color: aquamarine; width:{{ ($numberOfTodos != 0)?(($numberOfCompleted*100)/$numberOfTodos):0 }}%; height:7px; border-radius: 13px;"></div>
                        </div>
                    </div>
                    <div class="col-md-5 text-right pr-sm">
                        <small class="create-template" data-project-id="{{ $projectId }}"
                               data-demande-id="{{ $demandeId }}"><u>En faire un gabarit</u></small>
                    </div>
                </div>
                <div class="row todo-list-div">
                    <div class="col-md-12 todo-list-group scroll-height">
                        @foreach($groups as $key => $group)
                            @include('admin.projets.modals._todo_single_group',['group'=>$group])
                        @endforeach
                    </div>
                    <div class="col-md-12">
                        {!! Form::text('group_name',null,['class'=>'form-control font-italic group_name_text','placeholder'=>'Nam du groupe']) !!}
                        <a href="javascript:void(0)" class="btn btn-light mt-1 create-group" data-project-id="{{ $projectId }}"
                           data-demande-id="{{ $demandeId }}">Ajouter une liste</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

